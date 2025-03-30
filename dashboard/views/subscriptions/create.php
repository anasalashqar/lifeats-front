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
          <h1 class="mb-4">Add New Subscription</h1>
          <form id="subscriptionForm">
            <div class="row">
              <div class="col-md-12">

                <div class="mb-3">
                  <label class="form-label">Subscription Name:</label>
                  <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                  <label class="form-label">Duration (Days):</label>
                  <input type="number" name="duration_days" class="form-control" required min="1">
                </div>

                <div class="mb-3">
                  <label class="form-label">Price ($):</label>
                  <input type="number" name="price" class="form-control" required step="0.01">
                </div>

                <div class="mb-3">
                  <label class="form-label">Goal:</label>
                  <input type="text" name="goal" class="form-control" required>
                </div>

                <div class="mb-3">
                  <label class="form-label">Image URL:</label>
                  <input type="url" name="image_url" class="form-control" placeholder="https://...">
                </div>

                <div class="mb-3">
                  <label class="form-label">Active:</label>
                  <select name="active" class="form-control" required>
                    <option value="1" selected>Yes</option>
                    <option value="0">No</option>
                  </select>
                </div>

              </div>
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
    document.getElementById('subscriptionForm').addEventListener('submit', function(e) {
      e.preventDefault();

      const form = e.target;
      const formData = new FormData(form);

      const data = {
        name: formData.get('name'),
        duration_days: parseInt(formData.get('duration_days')),
        price: parseFloat(formData.get('price')),
        goal: formData.get('goal'),
        image_url: formData.get('image_url'), // optional
        active: parseInt(formData.get('active')),
      };

      const spinnerOverlay = document.getElementById('spinner-overlay');
      spinnerOverlay.style.display = 'block';

      fetch('http://127.0.0.1:8000/api/admin/subscriptions', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            // 'Authorization': 'Bearer <token>' // if you need auth
          },
          body: JSON.stringify(data),
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Failed to create subscription');
          }
          return response.json();
        })
        .then(result => {
          alert('Subscription created successfully!');
          form.reset(); // optional
          document.location.href = "index.php?page=subscriptions/index";
          // Optionally redirect or update UI
          // window.location.href = 'subscriptions.html';
        })
        .catch(error => {
          console.error(error);
          alert('Error creating subscription');
        }).finally(() => {
          spinnerOverlay.style.display = 'none';
        })
    });
  </script>

</body>

</html>