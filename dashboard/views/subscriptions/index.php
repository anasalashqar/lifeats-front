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
      <div class="container main-content">
        <div class="page-inner">
          <h1>Subscriptions List</h1>
          <a href="index.php?page=subscriptions/create" class="btn btn-primary my-2">Add New Subscription</a>

          <table class="table table-striped">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Image</th>
                <th>Duration (Days)</th>
                <th>Price</th>
                <th>Goal</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="subscriptions-table-body">
              <!-- Dynamic rows go here -->
            </tbody>
          </table>
        </div>
      </div>

      <script>
        document.addEventListener('DOMContentLoaded', () => {
          fetch('http://127.0.0.1:8000/api/admin/subscriptions')
            .then(response => response.json())
            .then(data => {
              const tbody = document.getElementById('subscriptions-table-body');
              tbody.innerHTML = ''; // Clear existing content

              data.forEach(subscription => {
                const tr = document.createElement('tr');

                // Fallback image if none is provided (replace later with real image_url from backend)
                const imageUrl = subscription.image_url || 'https://via.placeholder.com/80x50.png?text=No+Image';

                tr.innerHTML = `
          <td>${subscription.id}</td>
          <td>${subscription.name}</td>
          <td><img src="${imageUrl}" alt="Subscription Image" style="width: 80px; height: auto; border-radius: 8px;"></td>
          <td>${subscription.duration_days} days</td>
          <td>$${subscription.price}</td>
          <td>${subscription.goal}</td>
          <td>
            ${subscription.active ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Inactive</span>'}
          </td>
          <td>
            <button class="btn btn-sm btn-dark" onclick="window.location.href='index.php?page=subscriptions-edit-subscription&id=${subscription.id}'">
                <i class="fas fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-danger" onclick="deleteSubscription(${subscription.id})">
                <i class="fas fa-trash"></i>
            </button>
          </td>
        `;

                tbody.appendChild(tr);
              });
            })
            .catch(error => {
              console.error('Error fetching subscriptions:', error);
            });
        });

        // Placeholder functions
        function editSubscription(id) {
          alert('Edit Subscription ID: ' + id);
        }

        function deleteSubscription(id) {
          if (confirm('Are you sure you want to delete subscription ID ' + id + '?')) {
            fetch(`http://127.0.0.1:8000/api/admin/subscriptions/${id}`, {
                method: 'DELETE',
                headers: {
                  'Content-Type': 'application/json',
                  // 'Authorization': 'Bearer ...' // Add this if needed
                }
              })
              .then(response => {
                if (!response.ok) {
                  throw new Error('Failed to delete subscription');
                }
                alert('Subscription deleted successfully!');
                // Reload table (or you can remove the row from DOM)
                location.reload(); // Simple option: reload page to see update
              })
              .catch(error => {
                console.error('Error deleting subscription:', error);
                alert('Failed to delete subscription');
              });
          }
        }
      </script>

      <!-- Footer -->
      <?php require_once "views/layouts/components/footer.html"; ?>
    </div>
  </div>

  <!--   Core JS Files   -->
  <?php require "views/layouts/components/scripts.html"; ?>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>