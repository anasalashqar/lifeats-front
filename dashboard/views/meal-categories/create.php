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
    <?php require_once "views/layouts/components/sidebar.php"; ?>

    <div class="main-panel">
      <div class="main-header">
        <div class="main-header-logo">
          <?php require_once "views/layouts/components/logoheader.php"; ?>
        </div>
        <?php require_once "views/layouts/components/navbar.php"; ?>
      </div>

      <div class="container">
        <div class="page-inner">
          <h1 class="mb-4">Add New Meal Category</h1>

          <form id="createMealCategoryForm">
            <div class="mb-3">
              <label class="form-label">Name:</label>
              <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Image URL:</label>
              <input type="text" name="image" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary px-4">Save</button>
          </form>

          <div id="category-create-message" class="mt-3"></div>
        </div>
      </div>


      <!-- Footer -->
      <?php require_once "views/layouts/components/spinner.html"; ?>
      <?php require_once "views/layouts/components/footer.html"; ?>
    </div>
  </div>


  <!--   Core JS Files   -->
  <?php require "views/layouts/components/scripts.html"; ?>

  <script>
    const form = document.getElementById('createMealCategoryForm');
    const messageDiv = document.getElementById('category-create-message');

    form.addEventListener('submit', function(e) {
      e.preventDefault();
      const spinnerOverlay = document.getElementById('spinner-overlay');
      const formData = new FormData(form);
      const data = {
        name: formData.get('name'),
        image: formData.get('image')
      };
      spinnerOverlay.style.display = 'block';
      fetch('http://127.0.0.1:8000/api/admin/meal-categories', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(data)
        })
        .then(res => {
          if (!res.ok) throw new Error('Something went wrong');
          return res.json();
        })
        .then(response => {
          alert("add is successful");
          window.location.href = "index.php?page=meal-categories/index"
          form.reset();
        })
        .catch(error => {
          messageDiv.innerHTML = `<div class="alert alert-danger">Error: ${error.message}</div>`;
        }).finally(() => {
          spinnerOverlay.style.display = 'none'; // Hide spinner
        });
    });
  </script>
</body>

</html>