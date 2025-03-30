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
          <h1 class="mb-4">Add New Meal</h1>

          <form id="createMealForm">
            <div class="mb-3">
              <label class="form-label">Name:</label>
              <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Description:</label>
              <textarea name="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label">Calories:</label>
              <input type="number" name="calories" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Protein (g):</label>
              <input type="number" name="protein" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Carbs (g):</label>
              <input type="number" name="carbs" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Fats (g):</label>
              <input type="number" name="fats" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Image URL:</label>
              <input type="text" name="image_url" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Category:</label>
              <select name="category_id" class="form-select" required>
                <option value="1">Breakfast</option>
                <option value="2">Lunch</option>
                <option value="3">Dinner</option>
              </select>
            </div>

            <button type="submit" class="btn btn-primary px-4">Save</button>
          </form>
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
    document.getElementById('createMealForm').addEventListener('submit', function(e) {
      e.preventDefault();

      const spinnerOverlay = document.getElementById('spinner-overlay');
      spinnerOverlay.style.display = 'block'; // Show spinner

      const form = e.target;

      const newMeal = {
        name: form.name.value,
        description: form.description.value,
        calories: parseInt(form.calories.value),
        protein: parseInt(form.protein.value),
        carbs: parseInt(form.carbs.value),
        fats: parseInt(form.fats.value),
        image_url: form.image_url.value,
        category_id: parseInt(form.category_id.value)
      };

      fetch('http://127.0.0.1:8000/api/admin/meals', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(newMeal)
        })
        .then(async res => {
          const data = await res.json();

          if (!res.ok) {
            console.error('API Error:', data);
            alert("Error: " + (data.message || "Validation failed."));
            return;
          }

          alert("Meal created successfully!");
          window.location.href = 'index.php?page=meals/index';
        })
        .catch(err => {
          console.error("Network or JS Error:", err);
          alert("Something went wrong while creating the meal.");
        })
        .finally(() => {
          spinnerOverlay.style.display = 'none'; // Hide spinner
        });
    });
  </script>

</body>

</html>