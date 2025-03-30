<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Admin Dashboard</title>
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />

  <!-- Favicon -->
  <link rel="icon" href="../../assets/img/wrist-watch.ico" type="image/x-icon" />

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
          <h1 class="mb-4">Edit Meal Category</h1>

          <form id="editMealCategoryForm">
            <input type="hidden" name="id" id="category-id">

            <div class="mb-3">
              <label class="form-label">Name:</label>
              <input type="text" name="name" id="category-name" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Image URL:</label>
              <input type="text" name="image" id="category-image" class="form-control" required>
            </div>

            <div id="existing-image" class="mb-3"></div>

            <button type="submit" class="btn btn-primary">Update Category</button>
            <a href="index.php?page=meal-categories/index" class="btn btn-danger">Cancel</a>
          </form>

          <div id="edit-message" class="mt-3"></div>
        </div>
      </div>

      <!-- Footer -->
      <?php require_once "views/layouts/components/spinner.html"; ?>
      <?php require_once "views/layouts/components/footer.html"; ?>
    </div>
  </div>

  <script>
    const urlParams = new URLSearchParams(window.location.search);
    const categoryId = urlParams.get('id');

    const form = document.getElementById('editMealCategoryForm');
    const messageDiv = document.getElementById('edit-message');
    const spinnerOverlay = document.getElementById('spinner-overlay');
    // Prefill data
    spinnerOverlay.style.display = 'block';
    fetch(`http://127.0.0.1:8000/api/admin/meal-categories/${categoryId}`)
      .then(res => {
        if (!res.ok) throw new Error("Category not found");
        return res.json();
      })
      .then(data => {
        document.getElementById('category-id').value = data.id;
        document.getElementById('category-name').value = data.name;
        document.getElementById('category-image').value = data.image;

        document.getElementById('existing-image').innerHTML = `
        <label class="form-label">Current Image:</label><br>
        <img src="${data.image}" alt="${data.name}" style="max-width: 100px;">
      `;
      })
      .catch(error => {
        messageDiv.innerHTML = `<div class="alert alert-danger">${error.message}</div>`;
      }).finally(() => {
        spinnerOverlay.style.display = 'none'; // Hide spinner
      });

    // Handle update submit
    form.addEventListener('submit', function(e) {
      e.preventDefault();

      const updatedData = {
        name: document.getElementById('category-name').value,
        image: document.getElementById('category-image').value
      };

      spinnerOverlay.style.display = 'block';
      fetch(`http://127.0.0.1:8000/api/admin/meal-categories/${categoryId}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(updatedData)
        })
        .then(res => {
          if (!res.ok) throw new Error('Failed to update category');
          return res.json();
        })
        .then(response => {
          window.location.href = "index.php?page=meal-categories/index"
        })
        .catch(error => {
          messageDiv.innerHTML = `<div class="alert alert-danger">${error.message}</div>`;
        }).finally(() => {
          spinnerOverlay.style.display = 'none'; // Hide spinner
        });
    });
  </script>

  <!--   Core JS Files   -->
  <?php require "views/layouts/components/scripts.html"; ?>
</body>

</html>