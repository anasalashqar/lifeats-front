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
          <h1 class="mb-4">Edit Subscription</h1>
          <form id="editSubscriptionForm">
            <input type="hidden" name="id">

            <div class="mb-3">
              <label class="form-label">Name:</label>
              <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Duration (Days):</label>
              <input name="duration_days" class="form-control" type="number" required />
            </div>

            <div class="mb-3">
              <label class="form-label">Price ($):</label>
              <input name="price" class="form-control" type="number" step="0.01" required />
            </div>

            <div class="mb-3">
              <label class="form-label">Goal:</label>
              <input name="goal" class="form-control" type="text" required />
            </div>

            <div class="mb-3">
              <label class="form-label">Image URL:</label>
              <input name="image_url" class="form-control" type="url" />
            </div>

            <div class="mb-3">
              <label class="form-label">Active:</label>
              <select name="active" class="form-control" required>
                <option value="1">Yes</option>
                <option value="0">No</option>
              </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Subscription</button>
            <a href="subscriptions.html" class="btn btn-danger">Cancel</a>
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
    // Utility to get query param (?id=2)
    function getQueryParam(param) {
      const urlParams = new URLSearchParams(window.location.search);
      return urlParams.get(param);
    }

    const subscriptionId = getQueryParam('id');
    const form = document.getElementById('editSubscriptionForm');

    // Fetch subscription and populate form
    if (subscriptionId) {
      spinnerOverlay.style.display = 'block';
      fetch(`http://127.0.0.1:8000/api/admin/subscriptions/${subscriptionId}`)
        .then(res => res.json())
        .then(data => {
          form.elements['id'].value = data.id;
          form.elements['name'].value = data.name;
          form.elements['duration_days'].value = data.duration_days;
          form.elements['price'].value = data.price;
          form.elements['goal'].value = data.goal;
          form.elements['image_url'].value = data.image_url || '';
          form.elements['active'].value = data.active;
        })
        .catch(err => {
          console.error('Error loading subscription:', err);
          alert('Failed to load subscription data.');
        }).finally(() => {
          spinnerOverlay.style.display = 'none';
        })
    } else {
      alert('No subscription ID provided in URL.');
    }

    // Handle form submission
    form.addEventListener('submit', function(e) {
      e.preventDefault();

      const updatedData = {
        name: form.elements['name'].value,
        duration_days: parseInt(form.elements['duration_days'].value),
        price: parseFloat(form.elements['price'].value),
        goal: form.elements['goal'].value,
        image_url: form.elements['image_url'].value,
        active: parseInt(form.elements['active'].value),
      };

      spinnerOverlay.style.display = 'block'; // Show spinner immediately
      fetch(`http://127.0.0.1:8000/api/admin/subscriptions/${subscriptionId}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            // 'Authorization': 'Bearer ...' // if using auth
          },
          body: JSON.stringify(updatedData),
        })
        .then(response => {
          if (!response.ok) throw new Error('Failed to update');
          return response.json();
        })
        .then(result => {
          alert('Subscription updated successfully!');
          window.location.href = 'index.php?page=subscriptions/index'; // or any redirect
        })
        .catch(err => {
          console.error('Update error:', err);
          alert('Error updating subscription');
        }).finally(() => {
          spinnerOverlay.style.display = 'none';
        })
    });
  </script>

</body>

</html>