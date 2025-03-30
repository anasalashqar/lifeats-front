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
          <h1>Edit Customer</h1>

          <form id="editUserForm">
            <input type="hidden" name="id">

            <div class="row">
              <div class="col-md-12">
                <hr>

                <div class="mb-3">
                  <label class="form-label">Name:</label>
                  <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                  <label class="form-label">Email:</label>
                  <input type="email" name="email" class="form-control" required>
                </div>

                <input type="hidden" name="role" value="user">

                <div class="mb-3">
                  <label class="form-label">Phone Number:</label>
                  <input type="text" name="phone" class="form-control">
                </div>

                <input type="hidden" name="password" value=""> <!-- Not editable, preserved -->

                <hr>
                <h2>Address Details</h2>

                <div class="mb-3">
                  <label class="form-label">Address:</label>
                  <input type="text" name="address" class="form-control">
                </div>

                <div class="mb-3">
                  <label class="form-label">Preferences:</label>
                  <input type="text" name="preferences" class="form-control">
                </div>

                <div class="mb-3">
                  <label class="form-label">Allergies:</label>
                  <input type="text" name="allergies" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary px-4">Update Customer</button>
                <a href="index.php?page=customers/index" class="btn btn-danger">Cancel</a>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- Footer -->
      <?php require_once "views/layouts/components/spinner.html"; ?>
      <?php require_once "views/layouts/components/footer.html"; ?>
    </div>
  </div>

  <script>
    // Get ?id= from the URL
    function getQueryParam(key) {
      const url = new URLSearchParams(window.location.search);
      return url.get(key);
    }

    const userId = getQueryParam('id');
    const form = document.getElementById('editUserForm');
    const spinnerOverlay = document.getElementById('spinner-overlay');

    if (userId) {
      spinnerOverlay.style.display = 'block';
      fetch(`http://127.0.0.1:8000/api/admin/users/${userId}`)
        .then(res => res.json())
        .then(user => {
          form.elements['id'].value = user.id;
          form.elements['name'].value = user.name;
          form.elements['email'].value = user.email;
          form.elements['phone'].value = user.phone || '';
          form.elements['address'].value = user.address || '';
          form.elements['role'].value = user.role || 'user';
          form.elements['preferences'].value = user.preferences || '';
          form.elements['allergies'].value = user.allergies || '';
          form.elements['password'].value = user.password; // unchanged
        })
        .catch(err => {
          console.error('Failed to load user:', err);
          alert('Error loading customer data');
        }).finally(() => {
          spinnerOverlay.style.display = 'none'; // Hide spinner
        })
    } else {
      alert('No customer ID provided.');
    }

    form.addEventListener('submit', function(e) {
      e.preventDefault();
      const formData = new FormData(form);
      const data = {
        name: formData.get('name'),
        email: formData.get('email'),
        phone: formData.get('phone'),
        address: formData.get('address'),
        role: formData.get('role'),
        preferences: formData.get('preferences'),
        allergies: formData.get('allergies'),
        password: formData.get('password') // required by backend
      };
      spinnerOverlay.style.display = 'block';
      fetch(`http://127.0.0.1:8000/api/admin/users/${userId}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(data)
        })
        .then(res => {
          if (!res.ok) throw new Error('Failed to update user');
          return res.json();
        })
        .then(result => {
          alert('Customer updated successfully!');
          window.location.href = 'index.php?page=customers/index';
        })
        .catch(err => {
          console.error('Update failed:', err);
          alert('Failed to update customer.');
        }).finally(() => {
          spinnerOverlay.style.display = 'none'; // Hide spinner
        });
    })
  </script>



  <!--   Core JS Files   -->
  <?php require "views/layouts/components/scripts.html"; ?>
</body>

</html>