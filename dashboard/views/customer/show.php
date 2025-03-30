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
          <h2>Customer Information</h2>
          <hr>
          <p><b>Name:</b> <span id="user-name">Loading...</span></p>
          <p><b>Email:</b> <span id="user-email"></span></p>
          <p><b>Phone:</b> <span id="user-phone"></span></p>

          <h2>Address Information</h2>
          <hr>
          <p><b>Address:</b> <span id="user-address"></span></p>
          <p><b>Preferences:</b> <span id="user-preferences"></span></p>
          <p><b>Allergies:</b> <span id="user-allergies"></span></p>

          <h2>Active Subscriptions</h2>
          <hr>
          <table class="table table-striped">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>Subscription Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody id="subscriptions-table-body">
              <!-- Injected dynamically -->
            </tbody>
          </table>

          <a href="index.php?page=customers/index" class="btn btn-primary">Back to list</a>
        </div>
      </div>


      <!-- Footer -->\
      <?php require_once "views/layouts/components/spinner.html"; ?>
      <?php require_once "views/layouts/components/footer.html"; ?>
    </div>
  </div>

  <!--   Core JS Files   -->
  <?php require "views/layouts/components/scripts.html"; ?>

  <script>
    function getQueryParam(key) {
      const url = new URLSearchParams(window.location.search);
      return url.get(key);
    }
    const spinnerOverlay = document.getElementById('spinner-overlay');

    const userId = getQueryParam('id');

    if (userId) {
      spinnerOverlay.style.display = 'block';
      // Fetch user info
      fetch(`http://127.0.0.1:8000/api/admin/users/${userId}`)
        .then(res => res.json())
        .then(user => {
          document.getElementById('user-name').textContent = user.name;
          document.getElementById('user-email').textContent = user.email;
          document.getElementById('user-phone').textContent = user.phone || '—';
          document.getElementById('user-address').textContent = user.address || '—';
          document.getElementById('user-preferences').textContent = user.preferences || '—';
          document.getElementById('user-allergies').textContent = user.allergies || '—';
        })
        .catch(err => {
          console.error('Error fetching user:', err);
          alert('Could not load customer info.');
        }).finally(() => {
          spinnerOverlay.style.display = 'none'; // Hide spinner
        });

      spinnerOverlay.style.display = 'block';
      // Fetch user subscriptions
      fetch(`http://127.0.0.1:8000/api/admin/user-subscriptions`)
        .then(res => res.json())
        .then(allSubs => {
          const tbody = document.getElementById('subscriptions-table-body');
          tbody.innerHTML = '';

          const userSubs = allSubs.filter(sub => sub.user_id == userId);

          if (userSubs.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5">No subscriptions found.</td></tr>';
            return;
          }

          userSubs.forEach(sub => {
            const subscriptionName = sub.subscription?.name || 'Unknown Plan';
            const startDate = sub.start_date || '—';
            const endDate = sub.end_date || '—';
            const status = sub.status || '—';

            const tr = document.createElement('tr');
            tr.innerHTML = `
          <td>${sub.id}</td>
          <td>${subscriptionName}</td>
          <td>${startDate}</td>
          <td>${endDate}</td>
          <td><span class="badge bg-${status === 'active' ? 'success' : 'secondary'}">${status}</span></td>
        `;
            tbody.appendChild(tr);
          });
        })
        .catch(err => {
          console.error('Error fetching subscriptions:', err);
          document.getElementById('subscriptions-table-body').innerHTML = '<tr><td colspan="5">Failed to load subscriptions.</td></tr>';
        }).finally(() => {
          spinnerOverlay.style.display = 'none'; // Hide spinner
        });
    } else {
      alert('No customer ID provided.');
    }
  </script>


</body>

</html>