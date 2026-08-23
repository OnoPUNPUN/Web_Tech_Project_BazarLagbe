<?php

require_once __DIR__ . '/shared/helpers/Auth.php';

if (isset($_SESSION['user_id']) && isset($_SESSION['user_type'])) {
    redirect_by_role($_SESSION['user_type']);
} else {
    header('Location: auth/index.php?action=login');
    exit();
}

?>
