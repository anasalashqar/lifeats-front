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
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Subscription Details</h1>
            <!-- Generate Report Button -->
            <button class="btn btn-success" onclick="generatePDF()">
              <i class="fas fa-file-download"></i> Generate Report
            </button>
          </div>

          <div id="details"></div>
          <a href="index.php?page=user-subscriptions/index" class="btn btn-primary">Back to List</a>
        </div>
      </div>

      <!-- Footer -->
      <?php require_once "views/layouts/components/footer.html"; ?>
    </div>
  </div>

  <!--   Core JS Files   -->

  <script>
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');
    const detailsDiv = document.getElementById('details');
    const reportLink = document.getElementById('report-link');

    fetch(`http://127.0.0.1:8000/api/admin/user-subscriptions/${id}`)
      .then(res => {
        if (!res.ok) throw new Error("Failed to fetch subscription");
        return res.json();
      })
      .then(subscription => {
        detailsDiv.innerHTML = `
        <h2>User Information</h2>
        <hr>
        <p><b>Name:</b> ${subscription.user.name}</p>
        <p><b>Email:</b> ${subscription.user.email}</p>
        <p><b>Phone:</b> ${subscription.user.phone}</p>
        <p><b>Address:</b> ${subscription.user.address}</p>
        <p><b>Preferences:</b> ${subscription.user.preferences}</p>
        <p><b>Allergies:</b> ${subscription.user.allergies}</p>

        <h2>Subscription Plan</h2>
        <hr>
        <p><b>Plan Name:</b> ${subscription.subscription.name}</p>
        <p><b>Goal:</b> ${subscription.subscription.goal}</p>
        <p><b>Description:</b> ${subscription.subscription.description}</p>
        <p><b>Duration:</b> ${subscription.subscription.duration_days} days</p>
        <p><b>Price:</b> $${subscription.subscription.price}</p>

        <h2>Subscription Info</h2>
        <hr>
        <p><b>ID:</b> ${subscription.id}</p>
        <p><b>Start Date:</b> ${subscription.start_date}</p>
        <p><b>End Date:</b> ${subscription.end_date}</p>
        <p><b>Status:</b>
          <form id="statusForm">
            <select name="status" class="form-select w-25" onchange="updateStatus(this.value, ${subscription.id})">
              <option value="active" ${subscription.status === 'active' ? 'selected' : ''}>active</option>
              <option value="paused" ${subscription.status === 'paused' ? 'selected' : ''}>paused</option>
              <option value="cancelled" ${subscription.status === 'cancelled' ? 'selected' : ''}>cancelled</option>
            </select>
          </form>
        </p>
        <p><b>Created At:</b> ${formatDate(subscription.created_at)}</p>
        <p><b>Updated At:</b> ${formatDate(subscription.updated_at)}</p>
      `;
      })
      .catch(err => {
        detailsDiv.innerHTML = `<p class="text-danger">${err.message}</p>`;
      });

    function updateStatus(newStatus, id) {
      fetch(`http://127.0.0.1:8000/api/admin/user-subscriptions/${id}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            status: newStatus
          })
        })
        .then(res => {
          if (!res.ok) throw new Error("Status update failed");
          return res.json();
        })
        .then(() => {
          alert("Status updated successfully!");
        })
        .catch(err => {
          alert("Error: " + err.message);
        });
    }

    function formatDate(dateString) {
      const date = new Date(dateString);
      return date.toLocaleString();
    }
  </script>
  <!-- PDF Export Script -->

  <script src="services/orderReport/user-subscriptions.js">

  </script>

  <?php require "views/layouts/components/scripts.html"; ?>


</body>

</html>