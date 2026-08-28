<?php

require_once __DIR__ . '/controllers/DashboardController.php';
require_once __DIR__ . '/controllers/CategoryController.php';
require_once __DIR__ . '/controllers/ProductController.php';
require_once __DIR__ . '/controllers/OrderController.php';
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/EmployeeController.php';
require_once __DIR__ . '/controllers/ContactController.php';
require_once __DIR__ . '/controllers/ReviewController.php';
require_once __DIR__ . '/controllers/ProfileController.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

switch ($page) {
    case 'categories':
        $controller = new CategoryController();
        $controller->handleRequest();
        break;
    case 'products':
        $controller = new ProductController();
        $controller->handleRequest();
        break;
    case 'orders':
        $controller = new OrderController();
        $controller->handleRequest();
        break;
    case 'users':
        $controller = new UserController();
        $controller->handleRequest();
        break;
    case 'employees':
        $controller = new EmployeeController();
        $controller->handleRequest();
        break;
    case 'messages':
        $controller = new ContactController();
        $controller->handleRequest();
        break;
    case 'reviews':
        $controller = new ReviewController();
        $controller->handleRequest();
        break;
    case 'update_profile':
        $controller = new ProfileController();
        $controller->handleRequest();
        break;
    case 'dashboard':
    default:
        $controller = new DashboardController();
        $controller->handleRequest();
        break;
}

?>
