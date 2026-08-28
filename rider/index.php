<?php

require_once __DIR__ . '/controllers/DashboardController.php';
require_once __DIR__ . '/controllers/OrderController.php';
require_once __DIR__ . '/controllers/HistoryController.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

switch ($page) {
    case 'orders':
        $controller = new OrderController();
        $controller->handleRequest();
        break;
    case 'history':
        $controller = new HistoryController();
        $controller->handleRequest();
        break;
    case 'dashboard':
    default:
        $controller = new DashboardController();
        $controller->handleRequest();
        break;
}

?>
