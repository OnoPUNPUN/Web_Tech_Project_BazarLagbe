<?php

require_once __DIR__ . '/controllers/LoginController.php';
require_once __DIR__ . '/controllers/RegisterController.php';
require_once __DIR__ . '/controllers/LogoutController.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'login';

switch ($action) {
    case 'register':
        $controller = new RegisterController();
        $controller->handleRequest();
        break;
    case 'logout':
        $controller = new LogoutController();
        $controller->handleRequest();
        break;
    case 'login':
    default:
        $controller = new LoginController();
        $controller->handleRequest();
        break;
}

?>
