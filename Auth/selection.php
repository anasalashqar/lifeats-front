<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Meal Selection</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light p-4">
    <div class="container">
        <h2 class="text-center mb-4">Meal Selection</h2>
        <div id="schedule-container" class="row gy-4"></div>
    </div>

    <script>
        const API_GET = "http://127.0.0.1:8000/api/user-subscriptions/1/schedule";
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

                schedules.forEach(schedule => {
                    if (schedule.date === editableDate) {
                        renderEditableForm(schedule);
                    } else if (new Date(schedule.date) < new Date(editableDate)) {
                        console.log(schedule);

                        renderLockedCard(schedule);
                    }
                    // Future dates are ignored
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
                div.className = "col-12";
                div.innerHTML = `
        <h4 class="text-success">You have already chosen your meals for ${schedule.date}</h4>
        <div class="row" id="confirmed-${mealScheduleId}"></div>
    `;

                const sectionContainer = div.querySelector(`#confirmed-${mealScheduleId}`);

                Object.entries(groupedSelections).forEach(([category, selections]) => {
                    const selectedMeal = selections.find(sel => sel.selected == 1);

                    const item = selectedMeal ?
                        `
                <div class="card border-success">
                    <div class="card-header bg-light">
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
                <div class="card border-secondary">
                    <div class="card-header bg-light">
                        <strong>${category}</strong>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-0">No meal selected</p>
                    </div>
                </div>
            `;

                    const section = document.createElement("div");
                    section.className = "col-md-6";
                    section.innerHTML = item;
                    sectionContainer.appendChild(section);
                });

                container.appendChild(div);
                return;
            }


            // Editable Form
            const form = document.createElement("form");
            form.className = "col-12";
            form.innerHTML = `
        <h4 class="text-primary">Editable: ${schedule.date}</h4>
        <div class="row" id="form-${mealScheduleId}"></div>
        <button type="submit" class="btn btn-success mt-3">Confirm Meals</button>
    `;

            const mealSections = form.querySelector(`#form-${mealScheduleId}`);

            Object.entries(groupedSelections).forEach(([category, selections]) => {
                const section = document.createElement("div");
                section.className = "col-md-6";
                const options = selections.map(sel => `
            <option value="${sel.selection_id}">${sel.meal.name} (${sel.meal.calories} cal)</option>
        `).join("");

                section.innerHTML = `
            <div class="card shadow-sm">
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

                try {
                    const res = await fetch(API_POST, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
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
            div.className = "col-12";
            div.innerHTML = `<h4 class="text-secondary">Locked: ${schedule.date}</h4><div class="row" id="locked-${schedule.id}"></div>`;

            const sectionContainer = div.querySelector(`#locked-${schedule.id}`);

            Object.entries(grouped).forEach(([category, selections]) => {
                const card = document.createElement("div");
                card.className = "col-md-6";

                const selectedMeal = selections.find(sel => sel.selected);

                const items = selectedMeal ?
                    `<li>${selectedMeal.meal.name} (${selectedMeal.meal.calories} cal)</li>` :
                    `<li class="text-muted">No meal selected</li>`;

                card.innerHTML = `
            <div class="card border-secondary">
                <div class="card-header bg-light">
                    <strong>${category}</strong>
                </div>
                <div class="card-body">
                    <ul class="mb-0">${items}</ul>
                </div>
            </div>
        `;
                sectionContainer.appendChild(card);
            });

            container.appendChild(div);
        }

        fetchMealSchedule();
    </script>
</body>

</html>