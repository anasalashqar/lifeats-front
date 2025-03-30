<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Admin Dashboard</title>
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />

  <!-- Favicon -->
  <link rel="icon" href="assets/img/wrist-watch.ico" type="image/x-icon" />

  <!-- Fonts and icons -->
  <style>
    .fadeIn {
      animation: fadeIn 0.4s ease-in-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(15px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .card .card-title {
      font-size: 1.25rem;
      font-weight: 600;
    }

    .form-select {
      min-width: 200px;
    }
  </style>

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

          <div id="details" class="animated fadeIn"></div>
          <a href="index.php?page=user-subscriptions/index" class="btn btn-primary">Back to List</a>
        </div>
      </div>

      <!-- Footer -->
      <?php require_once "views/layouts/components/spinner.html"; ?>
      <?php require_once "views/layouts/components/footer.html"; ?>
    </div>
  </div>

  <!--   Core JS Files   -->

  <script>
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');
    const detailsDiv = document.getElementById('details');
    const reportLink = document.getElementById('report-link');

    const spinnerOverlay = document.getElementById('spinner-overlay');
    spinnerOverlay.style.display = 'block';
    fetch(`http://127.0.0.1:8000/api/admin/user-subscriptions/${id}`)
      .then(res => {
        if (!res.ok) throw new Error("Failed to fetch subscription");
        return res.json();
      })
      .then(subscription => {
        detailsDiv.innerHTML = `
  <div class="row g-4">
    <div class="col-md-6">
      <div class="card shadow-sm border-0">
        <div class="card-body">
          <h5 class="card-title"><i class="fas fa-user me-2 text-primary"></i>User Information</h5>
          <hr>
          <p><strong>Name:</strong> ${subscription.user.name}</p>
          <p><strong>Email:</strong> ${subscription.user.email}</p>
          <p><strong>Phone:</strong> ${subscription.user.phone}</p>
          <p><strong>Address:</strong> ${subscription.user.address}</p>
          <p><strong>Preferences:</strong> ${subscription.user.preferences}</p>
          <p><strong>Allergies:</strong> ${subscription.user.allergies}</p>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card shadow-sm border-0">
        <div class="card-body">
          <h5 class="card-title"><i class="fas fa-box me-2 text-success"></i>Subscription Plan</h5>
          <hr>
          <p><strong>Plan Name:</strong> ${subscription.subscription.name}</p>
          <p><strong>Goal:</strong> ${subscription.subscription.goal}</p>
          <p><strong>Description:</strong> ${subscription.subscription.description}</p>
          <p><strong>Duration:</strong> ${subscription.subscription.duration_days} days</p>
          <p><strong>Price:</strong> $${subscription.subscription.price}</p>
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="card shadow-sm border-0">
        <div class="card-body">
          <h5 class="card-title"><i class="fas fa-info-circle me-2 text-warning"></i>Subscription Info</h5>
          <hr>
          <p><strong>ID:</strong> ${subscription.id}</p>
          <p><strong>Start Date:</strong> ${subscription.start_date}</p>
          <p><strong>End Date:</strong> ${subscription.end_date}</p>
          <p><strong>Status:</strong></p>
          <form id="statusForm" class="mb-3">
            <select name="status" class="form-select w-auto" onchange="updateStatus(this.value, ${subscription.id})">
              <option value="active" ${subscription.status === 'active' ? 'selected' : ''}>Active</option>
              <option value="paused" ${subscription.status === 'paused' ? 'selected' : ''}>Paused</option>
              <option value="cancelled" ${subscription.status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
            </select>
          </form>
          <p><strong>Created At:</strong> ${formatDate(subscription.created_at)}</p>
          <p><strong>Updated At:</strong> ${formatDate(subscription.updated_at)}</p>
        </div>
      </div>
    </div>
  </div>
`;
      })
      .catch(err => {
        detailsDiv.innerHTML = `<p class="text-danger">${err.message}</p>`;
      }).finally(() => {
        spinnerOverlay.style.display = 'none'; // Hide spinner
      });

    function updateStatus(newStatus, id) {
      spinnerOverlay.style.display = 'block';
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
        }).finally(() => {
          spinnerOverlay.style.display = 'none'; // Hide spinner
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