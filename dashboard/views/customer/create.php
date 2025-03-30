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
                    <h1>Add New User</h1>

                    <form id="userForm">
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

                                <input type="hidden" name="role" value="user" />

                                <div class="mb-3">
                                    <label class="form-label">Phone Number:</label>
                                    <input type="text" name="phone" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Password:</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>

                                <hr>
                                <h2>Additional Info</h2>

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

                                <button type="submit" class="btn btn-primary px-4">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Footer -->
            <?php require_once "views/layouts/components/spinner.html"; ?>
            <?php require_once "views/layouts/components/footer.html"; ?>
        </div>

        <!--   Core JS Files   -->
        <?php require "views/layouts/components/scripts.html"; ?>
        <script>
            document.getElementById('userForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const form = e.target;
                const formData = new FormData(form);
                const spinnerOverlay = document.getElementById('spinner-overlay');

                const userData = {
                    name: formData.get('name'),
                    email: formData.get('email'),
                    phone: formData.get('phone'),
                    address: formData.get('address'),
                    role: formData.get('role'),
                    preferences: formData.get('preferences'),
                    allergies: formData.get('allergies'),
                    password: formData.get('password'),
                };
                spinnerOverlay.style.display = 'block';
                fetch('http://127.0.0.1:8000/api/admin/users', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(userData),
                    })
                    .then(res => {
                        if (!res.ok) throw new Error('Failed to create user');
                        return res.json();
                    })
                    .then(result => {
                        alert('User created successfully!');
                        form.reset();
                        // Redirect or reload list
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Something went wrong');
                    }).finally(() => {
                        spinnerOverlay.style.display = 'none'; // Hide spinner
                    });
            });
        </script>

</body>

</html>