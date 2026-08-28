<?php

require_once __DIR__ . '/controllers/DashboardController.php';
require_once __DIR__ . '/controllers/InventoryController.php';
require_once __DIR__ . '/controllers/StockMovementController.php';
require_once __DIR__ . '/controllers/SalaryController.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

switch ($page) {
    case 'inventory':
        $controller = new InventoryController();
        $controller->handleRequest();
        break;
    case 'movements':
        $controller = new StockMovementController();
        $controller->handleRequest();
        break;
    case 'salary':
    case 'employees':
        $controller = new SalaryController();
        $controller->handleRequest();
        break;
    case 'dashboard':
    default:
        $controller = new DashboardController();
        $controller->handleRequest();
        break;
}

?>
