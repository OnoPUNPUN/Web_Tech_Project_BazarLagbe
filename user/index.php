<?php

require_once __DIR__ . '/controllers/HomeController.php';
require_once __DIR__ . '/controllers/ShopController.php';
require_once __DIR__ . '/controllers/CategoryController.php';
require_once __DIR__ . '/controllers/ProductController.php';
require_once __DIR__ . '/controllers/SearchController.php';
require_once __DIR__ . '/controllers/CartController.php';
require_once __DIR__ . '/controllers/WishlistController.php';
require_once __DIR__ . '/controllers/CheckoutController.php';
require_once __DIR__ . '/controllers/OrderController.php';
require_once __DIR__ . '/controllers/ReviewController.php';
require_once __DIR__ . '/controllers/ContactController.php';
require_once __DIR__ . '/controllers/AboutController.php';
require_once __DIR__ . '/controllers/ProfileController.php';
require_once __DIR__ . '/controllers/PaymentController.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {
    case 'shop':
        $controller = new ShopController();
        $controller->handleRequest();
        break;
    case 'category':
        $controller = new CategoryController();
        $controller->handleRequest();
        break;
    case 'product':
        $controller = new ProductController();
        $controller->handleRequest();
        break;
    case 'search':
        $controller = new SearchController();
        $controller->handleRequest();
        break;
    case 'cart':
        $controller = new CartController();
        $controller->handleRequest();
        break;
    case 'wishlist':
        $controller = new WishlistController();
        $controller->handleRequest();
        break;
    case 'checkout':
        $controller = new CheckoutController();
        $controller->handleRequest();
        break;
    case 'payment':
        $controller = new PaymentController();
        $controller->handleRequest();
        break;
    case 'orders':
        $controller = new OrderController();
        $controller->handleRequest();
        break;
    case 'review':
        $controller = new ReviewController();
        $controller->handleRequest();
        break;
    case 'contact':
        $controller = new ContactController();
        $controller->handleRequest();
        break;
    case 'about':
        $controller = new AboutController();
        $controller->handleRequest();
        break;
    case 'profile':
        $controller = new ProfileController();
        $controller->handleRequest();
        break;
    case 'home':
    default:
        $controller = new HomeController();
        $controller->handleRequest();
        break;
}

?>
