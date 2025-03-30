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
                    <h1>Products List</h1>
                    <a href="index.php?controller=product&action=create" class="btn btn-primary my-2">Add New Product</a>
                    <form action="index.php?controller=product&action=search" method="POST" class="form-inline my-2 d-flex">
                        <input type="text" name="keyword" class="form-control" placeholder="Search for products">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                    <table class="table table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Calories</th>
                                <th>Protein</th>
                                <th>Carbs</th>
                                <th>Fats</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="meals-table-body">
                            <!-- Meals will be inserted here -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer -->
            <?php require_once "views/layouts/components/spinner.html"; ?>
            <?php require_once "views/layouts/components/footer.html"; ?>
        </div>
    </div>

    <!--   Core JS Files   -->
    <?php require "views/layouts/components/scripts.html"; ?>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const spinnerOverlay = document.getElementById('spinner-overlay');
            spinnerOverlay.style.display = 'block';
            fetch('http://127.0.0.1:8000/api/admin/meal-selections')
                .then(res => res.json())
                .then(data => {
                    const tbody = document.getElementById('meals-table-body');
                    tbody.innerHTML = '';

                    data.forEach(selection => {
                        const meal = selection.meal;
                        const tr = document.createElement('tr');

                        tr.innerHTML = `
          <td>${meal.id}</td>
          <td><img src="${meal.image_url}" alt="${meal.name}" style="width: 70px; border-radius: 6px;"></td>
          <td>${meal.name}</td>
          <td>${meal.description}</td>
          <td>${meal.calories}</td>
          <td>${meal.protein}g</td>
          <td>${meal.carbs}g</td>
          <td>${meal.fats}g</td>
          <td>
            <a href="index.php?page=meals-selection/show&id=${selection.id}" class="btn btn-sm btn-info">
              <i class="fas fa-eye"></i>
            </a>
          </td>
        `;

                        tbody.appendChild(tr);
                    });
                })
                .catch(err => {
                    console.error('Failed to load meal selections:', err);
                }).finally(() => {
                    spinnerOverlay.style.display = 'none'; // Hide spinner
                });
        });
    </script>
</body>

</html>