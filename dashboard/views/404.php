<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>404 Not Found</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            font-family: 'Public Sans', sans-serif;
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>

    <div class="container d-flex flex-column justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="text-center">
            <i class="fas fa-exclamation-triangle fa-5x text-warning mb-4"></i>
            <h1 class="display-1 text-danger">404</h1>
            <h4 class="mb-3 text-secondary">Oops! Page not found</h4>
            <p class="lead mb-4">Sorry, the page you’re looking for doesn’t exist or has been moved.</p>
            <a href="index.php?page=meals/index" class="btn btn-outline-primary px-4">
                <i class="fas fa-home me-2"></i>Back to Admin Dashboard
            </a>
        </div>
    </div>

    <!-- Bootstrap JS (optional if you want animations or modals) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>