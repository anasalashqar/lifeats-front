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
          <h1>Customers List</h1>

          <a href="index.php?page=customers/create" class="btn btn-primary my-2">Add New Customer</a>

          <form class="form-inline my-2 d-flex" onsubmit="return false;">
            <input type="text" id="searchInput" class="form-control" placeholder="Search by name or email">
            <button type="button" class="btn btn-primary" onclick="filterUsers()">Search</button>
          </form>

          <table class="table table-striped">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="users-table-body">
              <!-- Rows will be injected here -->
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
    let users = [];
    const spinnerOverlay = document.getElementById('spinner-overlay');

    function fetchUsers() {
      spinnerOverlay.style.display = 'block';
      fetch('http://127.0.0.1:8000/api/admin/users')
        .then(res => res.json())
        .then(data => {
          users = data;
          renderUsers(data);
        })
        .catch(err => {
          console.error('Error fetching users:', err);
        }).finally(() => {
          spinnerOverlay.style.display = 'none'; // Hide spinner
        });
    }

    function renderUsers(userList) {
      const tbody = document.getElementById('users-table-body');
      tbody.innerHTML = '';
      const spinnerOverlay = document.getElementById('spinner-overlay');
      userList.forEach(user => {
        const tr = document.createElement('tr');
        tr.id = `user-row-${user.id}`;

        tr.innerHTML = `
      <td>${user.id}</td>
      <td>${user.name}</td>
      <td>${user.email}</td>
      <td>${user.phone || '—'}</td>
      <td>
        <a href="index.php?page=customers-edit&id=${user.id}" class="btn btn-sm btn-dark">
          <i class="fas fa-edit"></i>
        </a>
        <a href="index.php?page=customers-show&id=${user.id}" class="btn btn-sm btn-warning">
          <i class="fas fa-info-circle"></i>
        </a>
        <button class="btn btn-sm btn-danger" onclick="confirmDelete(${user.id})">
          <i class="fas fa-trash"></i>
        </button>
      </td>
    `;

        tbody.appendChild(tr);
      });
    }

    function confirmDelete(id) {
      if (confirm(`Are you sure you want to delete user ID ${id}?`)) {
        deleteUser(id);
      }
    }

    function deleteUser(id) {
      spinnerOverlay.style.display = 'block';
      fetch(`http://127.0.0.1:8000/api/admin/users/${id}`, {
          method: 'DELETE',
          headers: {
            'Content-Type': 'application/json'
          }
        })
        .then(res => {
          if (!res.ok) throw new Error('Failed to delete user');
          alert('User deleted successfully');
          document.getElementById(`user-row-${id}`).remove();
        })
        .catch(err => {
          console.error('Error deleting user:', err);
          alert('Failed to delete user');
        }).finally(() => {
          spinnerOverlay.style.display = 'none'; // Hide spinner
        });
    }

    // Optional search
    function filterUsers() {
      const keyword = document.getElementById('searchInput').value.toLowerCase();
      const filtered = users.filter(u =>
        u.name.toLowerCase().includes(keyword) || u.email.toLowerCase().includes(keyword)
      );
      renderUsers(filtered);
    }

    document.addEventListener('DOMContentLoaded', fetchUsers);
  </script>

</body>

</html>