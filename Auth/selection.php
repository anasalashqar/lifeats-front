<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Meal Selection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php
    require_once __DIR__ . "/../Homepage/includes/navbar.php";
    ?>
    <div class="mt-3 mb-3">
        <div class="container">
            <h2 class="text-center mb-4">Meal Selection</h2>
            <div id="schedule-container" class="row gy-4"></div>
        </div>
    </div>


    <script>
        // Helper to get cookie by name
        function getCookie(name) {
            const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
            return match ? decodeURIComponent(match[2]) : null;
        }

        // Get and parse user cookie
        const userCookie = getCookie('user');
        let userId = null;

        if (userCookie) {
            try {
                const user = JSON.parse(userCookie);
                userId = user.id;
            } catch (e) {
                console.error("Invalid user cookie:", e);
            }
        }

        // If userId is valid, construct API URL
        const API_GET = userId ?
            `http://127.0.0.1:8000/api/user-subscriptions/${userId}/schedule` :
            null;


        const API_POST = "http://127.0.0.1:8000/api/ml/confirm";


        const container = document.getElementById("schedule-container");

        function getJordanDateNow() {
            const nowUTC = new Date();
            const jordanOffset = 3 * 60; // UTC+3
            return new Date(nowUTC.getTime() + jordanOffset * 60 * 1000);
        }

        async function fetchMealSchedule() {
            try {
                const res = await fetch(API_GET);
                const schedules = await res.json();

                if (res.status === 404) {
                    document.getElementById("schedule-container").innerHTML = "No Subsicriptions Schedule found!"
                    return;
                }


                const now = getJordanDateNow();
                const currentDate = now.toISOString().split("T")[0];
                const afterMidnight = now.getHours() >= 23 && now.getMinutes() >= 59;

                // Find editable day logic
                let editableDate = null;
                for (let i = 0; i < schedules.length - 1; i++) {
                    const d1 = schedules[i].date;
                    const d2 = schedules[i + 1].date;
                    if (d1 === currentDate) {
                        editableDate = afterMidnight ? schedules[i + 2]?.date : d2;
                        break;
                    }
                }

                container.innerHTML = "";

                const nows = new Date();

                // Define today and tomorrow in YYYY-MM-DD format
                let today = new Date(nows.getFullYear(), nows.getMonth(), now.getDate());
                today = new Date(today)
                const tomorrow = new Date(today);
                today.setDate(today.getDate() + 1);
                tomorrow.setDate(today.getDate() + 1);

                const todayStr = today.toISOString().split('T')[0];
                const tomorrowStr = tomorrow.toISOString().split('T')[0];

                schedules.forEach(schedule => {
                    if (schedule.date === tomorrowStr) {
                        renderEditableForm(schedule); // Editable tomorrow's meal
                    } else if (schedule.date === todayStr) {
                        renderLockedCard(schedule); // Locked today's meal
                    }
                    // All other dates are ignored
                });


            } catch (error) {
                console.error("Error fetching schedules:", error);
            }
        }

        function renderEditableForm(schedule) {
            const mealScheduleId = schedule.id;
            const groupedSelections = {};
            console.log(schedule);

            schedule.selections.forEach(sel => {
                const cat = sel.category;
                if (!groupedSelections[cat]) groupedSelections[cat] = [];
                groupedSelections[cat].push({
                    selection_id: sel.id,
                    ...sel
                });
            });

            const hasChosenMeals = schedule.selections.some(sel => sel.selected == 1);

            if (schedule.locked == 1 && hasChosenMeals) {
                const div = document.createElement("div");
                div.className = "col-12 mb-4";
                div.innerHTML = `
            <div class="p-3 rounded" style="background-color: #f5f5f5;">
                <h4 class="text-success">You have already chosen your meals for ${schedule.date}</h4>
                <div class="row mt-3" id="confirmed-${mealScheduleId}"></div>
            </div>
        `;

                const sectionContainer = div.querySelector(`#confirmed-${mealScheduleId}`);

                Object.entries(groupedSelections).forEach(([category, selections]) => {
                    const selectedMeal = selections.find(sel => sel.selected == 1);

                    const item = selectedMeal ?
                        `
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <strong>${category}</strong>
                    </div>
                    <div class="card-body d-flex align-items-center gap-3">
                        <img src="${selectedMeal.meal.image_url}" alt="${selectedMeal.meal.name}" class="rounded" style="width: 100px; height: 100px; object-fit: cover;">
                        <div>
                            <h6 class="mb-1">${selectedMeal.meal.name}</h6>
                            <p class="mb-0 text-muted">${selectedMeal.meal.calories} cal</p>
                        </div>
                    </div>
                </div>
            ` :
                        `
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <strong>${category}</strong>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-0">No meal selected</p>
                    </div>
                </div>
            `;

                    const section = document.createElement("div");
                    section.className = "col-md-6 mb-3";
                    section.innerHTML = item;
                    sectionContainer.appendChild(section);
                });

                container.appendChild(div);
                return;
            }

            // Editable Form
            const form = document.createElement("form");
            form.className = "col-12 mb-4";
            form.innerHTML = `
        <div class="p-3 rounded" style="background-color: #f5f5f5;">
            <h4 class="text-primary">✏️ Editable: ${schedule.date}</h4>
            <div class="row mt-3" id="form-${mealScheduleId}"></div>
            <button type="submit" class="btn btn-success mt-3">✅ Confirm Meals</button>
        </div>
    `;

            const mealSections = form.querySelector(`#form-${mealScheduleId}`);

            Object.entries(groupedSelections).forEach(([category, selections]) => {
                const section = document.createElement("div");
                section.className = "col-md-6 mb-3";
                const options = selections.map(sel => `
            <option value="${sel.selection_id}">${sel.meal.name} (${sel.meal.calories} cal)</option>
        `).join("");

                section.innerHTML = `
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <strong>${category}</strong>
                </div>
                <div class="card-body">
                    <select class="form-select" name="meal-${category}" required>
                        <option value="">-- Select a ${category} meal --</option>
                        ${options}
                    </select>
                </div>
            </div>
        `;
                mealSections.appendChild(section);
            });

            form.addEventListener("submit", async (e) => {
                e.preventDefault();
                const formData = new FormData(form);
                const selectedMealIds = [];

                for (const [_, value] of formData.entries()) {
                    if (value) selectedMealIds.push(parseInt(value));
                }

                const payload = {
                    meal_schedule_id: mealScheduleId,
                    selected_meal_ids: selectedMealIds
                };
                console.log(payload);
                

                try {
                    const token = getCookie('token'); // Make sure getCookie is defined

                    if (!token) {
                        alert('Missing authentication token.');
                        return;
                    }

                    const res = await fetch(API_POST, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "Authorization": "Bearer " + token // ✅ Inject token here
                        },
                        body: JSON.stringify(payload)
                    });


                    if (!res.ok) throw new Error("Failed to confirm meals");
                    alert("Meals confirmed successfully!");
                    fetchMealSchedule(); // refresh view
                } catch (error) {
                    alert("Error: " + error.message);
                }
            });

            container.appendChild(form);
        }


        function renderLockedCard(schedule) {
            const grouped = {};

            schedule.selections.forEach(sel => {
                const cat = sel.category;
                if (!grouped[cat]) grouped[cat] = [];
                grouped[cat].push(sel);
            });

            const div = document.createElement("div");
            div.className = "col-12 mb-4";
            div.innerHTML = `
        <div class="p-3 rounded" style="background-color: #f5f5f5;">
            <h4 class="text-muted">🔒 Locked: ${schedule.date}</h4>
            <div class="row mt-3" id="locked-${schedule.id}"></div>
        </div>
    `;

            const sectionContainer = div.querySelector(`#locked-${schedule.id}`);

            Object.entries(grouped).forEach(([category, selections]) => {
                const selectedMeal = selections.find(sel => sel.selected);

                const content = selectedMeal ? `
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <strong>${category}</strong>
                </div>
                <div class="card-body d-flex align-items-center gap-3">
                    <img src="${selectedMeal.meal.image_url}" alt="${selectedMeal.meal.name}" class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                    <div>
                        <h6 class="mb-1">${selectedMeal.meal.name}</h6>
                        <p class="mb-0 text-muted">${selectedMeal.meal.calories} cal</p>
                    </div>
                </div>
            </div>
        ` : `
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <strong>${category}</strong>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-0">No meal selected</p>
                </div>
            </div>
        `;

                const cardWrapper = document.createElement("div");
                cardWrapper.className = "col-md-6 mb-3";
                cardWrapper.innerHTML = content;
                sectionContainer.appendChild(cardWrapper);
            });

            container.appendChild(div);
        }

        fetchMealSchedule();
    </script>
    <?php
    require_once __DIR__ . "/../Homepage/includes/footer.php";
    ?>
</body>

</html>