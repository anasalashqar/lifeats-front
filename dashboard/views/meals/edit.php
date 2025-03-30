<?php
$mealId = $_GET['id'] ?? null;
if (!$mealId) {
  echo "<p class='text-danger'>No meal ID provided.</p>";
  exit;
}
?>

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
          <h1 class="mb-4">Edit Product</h1>
          <form id="mealForm">
            <input type="hidden" name="id" id="mealId" value="<?= htmlspecialchars($mealId) ?>">

            <div class="mb-3">
              <label class="form-label">Name</label>
              <input type="text" id="mealName" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea id="mealDescription" name="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label">Calories</label>
              <input type="number" id="mealCalories" name="calories" class="form-control">
            </div>

            <div class="mb-3">
              <label class="form-label">Protein (g)</label>
              <input type="number" id="mealProtein" name="protein" class="form-control">
            </div>

            <div class="mb-3">
              <label class="form-label">Carbs (g)</label>
              <input type="number" id="mealCarbs" name="carbs" class="form-control">
            </div>

            <div class="mb-3">
              <label class="form-label">Fats (g)</label>
              <input type="number" id="mealFats" name="fats" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Update Meal</button>
            <a href="index.php?page=meals" class="btn btn-secondary">Cancel</a>
          </form>
        </div>
      </div>

      <!-- Footer -->
      <?php require_once "views/layouts/components/footer.html"; ?>
    </div>
  </div>

  <!--   Core JS Files   -->
  <?php require_once "views/layouts/components/spinner.html"; ?>
  <?php require "views/layouts/components/scripts.html"; ?>

  <script>
    const id = document.getElementById("mealId").value;

    const spinnerOverlay = document.getElementById('spinner-overlay');
    spinnerOverlay.style.display = 'block';

    // Load meal data
    fetch(`http://127.0.0.1:8000/api/admin/meals/${id}`)
      .then(res => res.json())
      .then(meal => {
        document.getElementById('mealName').value = meal.name;
        document.getElementById('mealDescription').value = meal.description;
        document.getElementById('mealCalories').value = meal.calories;
        document.getElementById('mealProtein').value = meal.protein;
        document.getElementById('mealCarbs').value = meal.carbs;
        document.getElementById('mealFats').value = meal.fats;
      }).finally(() => {
        spinnerOverlay.style.display = 'none'; // Hide spinner
      });


    // Update meal on form submit
    document.getElementById('mealForm').addEventListener('submit', function(e) {
      e.preventDefault();

      const updatedMeal = {
        name: document.getElementById('mealName').value,
        description: document.getElementById('mealDescription').value,
        calories: parseInt(document.getElementById('mealCalories').value),
        protein: parseInt(document.getElementById('mealProtein').value),
        carbs: parseInt(document.getElementById('mealCarbs').value),
        fats: parseInt(document.getElementById('mealFats').value),
      };
      spinnerOverlay.style.display = 'block';
      fetch(`http://127.0.0.1:8000/api/admin/meals/${id}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(updatedMeal)
        })
        .then(res => res.json())
        .then(data => {
          alert('Meal updated successfully!');
          window.location.href = 'index.php?page=meals/index';
        })
        .catch(err => {
          console.error('Error updating meal:', err);
          alert('Something went wrong.');
        }).finally(() => {
          spinnerOverlay.style.display = 'none'; // Hide spinner
        });
    });
  </script>
</body>

</html>