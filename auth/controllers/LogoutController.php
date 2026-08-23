<?php

require_once __DIR__ . '/../../shared/helpers/Auth.php';

class LogoutController {
    public function handleRequest() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        header('Location: index.php?action=login');
        exit();
    }
}

?>
