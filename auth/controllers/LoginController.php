<?php

require_once __DIR__ . '/../../shared/config/Database.php';
require_once __DIR__ . '/../../shared/helpers/Auth.php';
require_once __DIR__ . '/../models/AuthModel.php';

class LoginController {
    private $authModel;

    public function __construct() {
        global $conn;
        $this->authModel = new AuthModel($conn);
    }

    public function handleRequest() {
        if (isset($_SESSION['user_id']) && isset($_SESSION['user_type'])) {
            redirect_by_role($_SESSION['user_type']);
        }

        $messages = [];

        if (isset($_POST['submit'])) {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
            $pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);

            $user = $this->authModel->getUserByEmail($email);

            if ($user) {
                if (verify_password($pass, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_type'] = $user['user_type'];
                    if ($user['user_type'] == 'admin') {
                        $_SESSION['admin_id'] = $user['id'];
                    }
                    redirect_by_role($user['user_type']);
                } else {
                    $messages[] = 'incorrect email or password!';
                }
            } else {
                $messages[] = 'incorrect email or password!';
            }
        }

        require __DIR__ . '/../views/login.php';
    }
}

?>
