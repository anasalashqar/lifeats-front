<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <title>Document</title>
    <style>
        .navbar {
            background-color: rgb(249, 236, 230) !important;
            position: sticky;
            top: 0;
            z-index: 1020;
            padding: 0.5rem 1rem;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            font-weight: 700;
            font-size: 1.5rem;
        }

        .logo {
            width: 70px;
            height: 70px;

        }

        .navbar-nav .nav-link {
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            opacity: 0.5;

        }

        .navbar-dark .navbar-nav .nav-link {
            color: #ff691c;
        }

        .navbar-dark .navbar-nav .nav-link.active {
            color: #ff691c;
            font-weight: 600;
        }

        /* Custom styles for the collapsed menu */
        .navbar-dark .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.5);
        }

        .navbar-dark .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.9%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* Ensure the collapsed menu has proper styling */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background-color: rgb(249, 236, 230);
                padding: 1rem;
                margin-top: 0.5rem;
                border-radius: 0.25rem;
            }

            .navbar-nav .btn-outline-light {
                margin-left: 0 !important;
                margin-top: 0.5rem;
                display: inline-block;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container p-0">
            <a class="navbar-brand" href="/Homepage/index.php">

                <img src="../../assets/logo3.ico" alt="" class="logo">

            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/./Homepage/index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/./Meals/php/subscription-plans.php">Subsicriptions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="faq.html">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/./Meals/php/meal.php">Famous Meals</a>
                    </li>
                    <?php
                    $user = null;
                    if (isset($_COOKIE['user'])) {
                        $decoded = urldecode($_COOKIE['user']);
                        $userData = json_decode($decoded, true);

                        if (json_last_error() === JSON_ERROR_NONE && isset($userData['id'])) {
                            $user = $userData; // You can access name/email/etc if needed
                        }
                    }
                    ?>

                    <?php if ($user): ?>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-light ms-lg-2 mt-2 mt-lg-0 d-flex align-items-center" href="/Auth/profile.php">
                                <i class="fas fa-user-circle me-2"></i>Profile
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-light ms-lg-2 mt-2 mt-lg-0" href="/Auth/login.php">Login</a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>