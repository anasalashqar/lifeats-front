<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Admin Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />

    <!-- Favicon -->
    <link rel="icon" href="assets/img/wrist-watch.ico" type="image/x-icon" />

    <!-- Fonts and icons -->
    <?php require_once "views/layouts/components/fonts.html"; ?>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php require_once "views/layouts/components/sidebar.php"; ?>

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <?php require_once "views/layouts/components/logoheader.php"; ?>
                </div>
                <!-- Navbar Header -->
                <?php require_once "views/layouts/components/navbar.php"; ?>
            </div>

            <!-- Main Content -->
            <div class="container">
                <div class="page-inner">
                    <h2>Meal Selection Details</h2>
                    <hr>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <img id="meal-image" src="" alt="Meal Image" class="img-fluid rounded" />
                        </div>
                        <div class="col-md-8">
                            <h3 id="meal-name">Meal Name</h3>
                            <p id="meal-description">Meal description goes here.</p>
                            <ul class="list-group">
                                <li class="list-group-item"><strong>Calories:</strong> <span id="meal-calories"></span></li>
                                <li class="list-group-item"><strong>Protein:</strong> <span id="meal-protein"></span>g</li>
                                <li class="list-group-item"><strong>Carbs:</strong> <span id="meal-carbs"></span>g</li>
                                <li class="list-group-item"><strong>Fats:</strong> <span id="meal-fats"></span>g</li>
                            </ul>
                        </div>
                    </div>

                    <h4>Category</h4>
                    <div class="d-flex align-items-center mb-4">
                        <img id="category-image" src="" alt="Category Image" style="width: 60px; border-radius: 6px; margin-right: 15px;">
                        <strong id="category-name">Category Name</strong>
                    </div>

                    <h4>Meal Schedule</h4>
                    <ul class="list-group mb-4">
                        <li class="list-group-item"><strong>Date:</strong> <span id="schedule-date"></span></li>
                        <li class="list-group-item"><strong>Locked:</strong> <span id="schedule-locked"></span></li>
                        <li class="list-group-item"><strong>Schedule ID:</strong> <span id="schedule-id"></span></li>
                    </ul>

                    <a href="index.php?page=meal-selections/index" class="btn btn-primary">Back to List</a>
                </div>
            </div>


            <!-- Footer -->
            <?php require_once "views/layouts/components/footer.html"; ?>
            <?php require_once "views/layouts/components/spinner.html"; ?>
        </div>
    </div>

    <!--   Core JS Files   -->
    <?php require "views/layouts/components/scripts.html"; ?>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        const spinnerOverlay = document.getElementById('spinner-overlay');

        function getQueryParam(key) {
            const url = new URLSearchParams(window.location.search);
            return url.get(key);
        }

        const selectionId = getQueryParam('id');

        if (selectionId) {
            spinnerOverlay.style.display = 'block';
            fetch(`http://127.0.0.1:8000/api/admin/meal-selections/${selectionId}`)
                .then(res => res.json())
                .then(data => {
                    // Meal Info
                    document.getElementById('meal-name').textContent = data.meal.name;
                    document.getElementById('meal-description').textContent = data.meal.description;
                    document.getElementById('meal-calories').textContent = data.meal.calories;
                    document.getElementById('meal-protein').textContent = data.meal.protein;
                    document.getElementById('meal-carbs').textContent = data.meal.carbs;
                    document.getElementById('meal-fats').textContent = data.meal.fats;
                    document.getElementById('meal-image').src = data.meal.image_url;

                    // Category
                    document.getElementById('category-name').textContent = data.category.name;
                    document.getElementById('category-image').src = data.category.image;

                    // Schedule
                    document.getElementById('schedule-id').textContent = data.meal_schedule.id;
                    document.getElementById('schedule-date').textContent = data.meal_schedule.date;
                    document.getElementById('schedule-locked').textContent = data.meal_schedule.locked == 1 ? 'Yes' : 'No';
                })
                .catch(err => {
                    console.error('Error loading meal selection:', err);
                    alert('Failed to load meal selection details.');
                }).finally(() => {
                    spinnerOverlay.style.display = 'none'; // Hide spinner
                });
        } else {
            alert('No selection ID provided in URL.');
        }
    </script>

</body>

</html>