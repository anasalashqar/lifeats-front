<?php
session_start();

// ROUTING ARRAY FOR `?page=...` ROUTES
$routes = [
    "" => "views/meals/index.php",
    // Meals
    'meals/index' => 'views/meals/index.php',
    'meals/create' => 'views/meals/create.php',
    'meals-edit' => 'views/meals/edit.php',

    // Meal Categories
    'meal-categories/index' => 'views/meal-categories/index.php',
    'meal-categories/create' => 'views/meal-categories/create.php',
    'meal-categories-edit' => 'views/meal-categories/edit.php',

    // User Subscriptions
    'user-subscriptions/index' => 'views/user-subscriptions/index.php',
    'user-subscriptions/view' => 'views/user-subscriptions/view.php',

    'subscriptions/index' => 'views/subscriptions/index.php',
    'subscriptions/create' => 'views/subscriptions/create.php',
    'subscriptions-edit-subscription' => 'views/subscriptions/edit-subscription.php',

    'customers/index' => 'views/customer/index.php',
    'customers/create' => 'views/customer/create.php',
    'customers-edit' => 'views/customer/edit.php',
    'customers-show' => 'views/customer/show.php',

    'meals-selection/index' => 'views/meals-selection/index.php',
    'meals-selection/show' => 'views/meals-selection/show.php',

    "meal-schedules/index" => 'views/meal-schedules/index.php',
    "meal-schedules/show" => 'views/meal-schedules/show.php',

];


// If ?page= is set → Use VIEW ROUTING
$page = $_GET['page'] ?? ''; // default to '' if not set

if (array_key_exists($page, $routes)) {
    include_once __DIR__ . '/' . $routes[$page];
    exit();
} else {
    include_once __DIR__ . '/views/404.php';
    exit();
}


// If neither page nor controller was matched
include_once __DIR__ . '/views/404.php';
exit();



