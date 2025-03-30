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
          <h1>Meal Schedules</h1>

          <table class="table table-striped">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>Date</th>
                <th>User</th>
                <th>Subscription</th>
                <th>Locked</th>
                <th>Meals</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="meals-table-body">
              <!-- Meal schedules will be inserted here -->
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
      fetch('http://127.0.0.1:8000/api/admin/meal-schedules')
        .then(res => res.json())
        .then(data => {
          const tbody = document.getElementById('meals-table-body');
          tbody.innerHTML = '';

          data.forEach(schedule => {
            const user = schedule.user_subscription.user;
            const subscriptionName = schedule.user_subscription.subscription?.name || 'N/A';
            const meals = schedule.selections.map(sel => sel.meal.name).join(', ');

            const tr = document.createElement('tr');
            tr.innerHTML = `
          <td>${schedule.id}</td>
          <td>${schedule.date}</td>
          <td>${user.name}</td>
          <td>${subscriptionName}</td>
          <td><span class="badge bg-${schedule.locked ? 'danger' : 'success'}">${schedule.locked ? 'Locked' : 'Unlocked'}</span></td>
          <td>${meals}</td>
          <td>
            <a href="index.php?page=meal-schedules/show&id=${schedule.id}" class="btn btn-sm btn-info">
              <i class="fas fa-eye"></i>
            </a>
          </td>
        `;

            tbody.appendChild(tr);
          });
        })
        .catch(err => {
          console.error('Failed to load meal schedules:', err);
          document.getElementById('meals-table-body').innerHTML = '<tr><td colspan="7">Error loading data.</td></tr>';
        }).finally(() => {
          spinnerOverlay.style.display = 'none'; // Hide spinner
        });
    });
  </script>
</body>

</html>