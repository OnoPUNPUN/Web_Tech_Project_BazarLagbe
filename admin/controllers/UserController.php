<?php

require_once __DIR__ . '/../../shared/config/Database.php';
require_once __DIR__ . '/../../shared/helpers/Auth.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/AdminModel.php';

class UserController {
    private $userModel;
    private $adminModel;

    public function __construct() {
        global $conn;
        check_auth(['admin']);
        $this->userModel = new UserModel($conn);
        $this->adminModel = new AdminModel($conn);
    }

    public function handleRequest() {
        $admin_id = $_SESSION['user_id'];
        $fetch_profile = $this->adminModel->getAdminProfile($admin_id);
        $message = [];

        if (isset($_POST['update_role'])) {
            $update_user_id = filter_var($_POST['user_id'], FILTER_SANITIZE_STRING);
            $update_role = filter_var($_POST['user_type'], FILTER_SANITIZE_STRING);

            if ($update_user_id != $admin_id) {
                $allowed_roles = ['user', 'admin', 'stock_manager', 'rider', 'warehouse_staff'];
                if (in_array($update_role, $allowed_roles)) {
                    $this->userModel->updateUserRole($update_user_id, $update_role);
                    $message[] = 'user role updated successfully!';
                }
            } else {
                $message[] = 'you cannot change your own role!';
            }
        }

        if (isset($_GET['delete'])) {
            $delete_id = filter_var($_GET['delete'], FILTER_SANITIZE_STRING);
            if ($delete_id != $admin_id) {
                $this->userModel->deleteUser($delete_id);
                header('Location: index.php?page=users');
                exit();
            }
        }

        $users = $this->userModel->getAllUsers();
        require __DIR__ . '/../views/users.php';
    }
}

?>
