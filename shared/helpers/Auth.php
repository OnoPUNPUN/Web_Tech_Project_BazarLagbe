<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function verify_password($input_pass, $stored_pass) {
    if (password_verify($input_pass, $stored_pass)) {
        return true;
    }
    if (md5($input_pass) === $stored_pass) {
        return true;
    }
    return false;
}

function hash_password($pass) {
    return password_hash($pass, PASSWORD_DEFAULT);
}

function get_base_url() {
    $script_dir = dirname($_SERVER['SCRIPT_NAME']);
    $base = preg_replace('/(\/admin|\/user|\/stock_manager|\/rider|\/auth).*$/', '', $script_dir);
    return rtrim($base, '/') . '/';
}

function check_auth($allowed_roles = []) {
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
        $baseUrl = get_base_url();
        header('Location: ' . $baseUrl . 'auth/index.php?action=login');
        exit();
    }
    if (!empty($allowed_roles)) {
        if (!in_array($_SESSION['user_type'], $allowed_roles)) {
            redirect_by_role($_SESSION['user_type']);
            exit();
        }
    }
}

function redirect_by_role($role) {
    $baseUrl = get_base_url();
    switch ($role) {
        case 'admin':
            header('Location: ' . $baseUrl . 'admin/index.php');
            break;
        case 'stock_manager':
            header('Location: ' . $baseUrl . 'stock_manager/index.php');
            break;
        case 'rider':
            header('Location: ' . $baseUrl . 'rider/index.php');
            break;
        case 'warehouse_staff':
        case 'user':
        default:
            header('Location: ' . $baseUrl . 'user/index.php');
            break;
    }
    exit();
}

?>
