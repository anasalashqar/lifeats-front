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
          <h1>Meal Categories List</h1>
          <a href="index.php?page=meal-categories/create" class="btn btn-primary my-2">Add New Category</a>
          <form action="index.php?controller=mealCategory&action=search" method="POST" class="form-inline my-2 d-flex">
            <input type="text" name="keyword" class="form-control" placeholder="Search for categories">
            <button type="submit" class="btn btn-primary">Search</button>
          </form>
          <table class="table table-striped">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="meal-categories-table-body">
              <!-- Categories will be inserted here -->
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
    const spinnerOverlay = document.getElementById('spinner-overlay');
    spinnerOverlay.style.display = 'block';
    fetch("http://127.0.0.1:8000/api/admin/meal-categories")
      .then(res => res.json())
      .then(categories => {
        const tbody = document.getElementById('meal-categories-table-body');
        categories.forEach(category => {
          const tr = document.createElement('tr');
          tr.innerHTML = `
          <td>${category.id}</td>
          <td><img src="${category.image}" alt="${category.name}" width="75"></td>
          <td>${category.name}</td>
          <td>
            <a href="index.php?page=meal-categories-edit&id=${category.id}" class="btn btn-sm btn-dark">
              <i class="fas fa-edit"></i>
            </a>
            <form onsubmit="return deleteCategory(event, ${category.id})" style="display:inline;">
              <button type="submit" class="btn btn-sm btn-danger">
                <i class="fas fa-trash"></i>
              </button>
            </form>
          </td>
        `;
          tbody.appendChild(tr);
        });
      })
      .catch(err => {
        console.error('Failed to load meal categories:', err);
      }).finally(() => {
        spinnerOverlay.style.display = 'none'; // Hide spinner
      });

    function deleteCategory(event, categoryId) {
      event.preventDefault();

      if (!confirm("Are you sure you want to delete this category?")) {
        return false;
      }

      spinnerOverlay.style.display = 'block';
      fetch(`http://127.0.0.1:8000/api/admin/meal-categories/${categoryId}`, {
          method: 'DELETE',
          headers: {
            'Content-Type': 'application/json'
          }
        })
        .then(res => {
          if (!res.ok) throw new Error("Failed to delete category.");
          return res.json();
        })
        .then(response => {
          alert("Category deleted successfully!");
          window.location.reload(); // Refresh the list
        })
        .catch(error => {
          alert("Error: " + error.message);
        }).finally(() => {
          spinnerOverlay.style.display = 'none'; // Hide spinner
        });

      return false; // prevent default form action
    }
  </script>
</body>

</html>