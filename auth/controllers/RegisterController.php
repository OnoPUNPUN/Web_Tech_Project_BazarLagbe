<?php

require_once __DIR__ . '/../../shared/config/Database.php';
require_once __DIR__ . '/../../shared/helpers/Auth.php';
require_once __DIR__ . '/../models/AuthModel.php';

class RegisterController {
    private $authModel;

    public function __construct() {
        global $conn;
        $this->authModel = new AuthModel($conn);
    }

    public function handleRequest() {
        $messages = [];

        if (isset($_POST['submit'])) {
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
            $pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
            $cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_STRING);

            $image = filter_var($_FILES['image']['name'], FILTER_SANITIZE_STRING);
            $image_size = $_FILES['image']['size'];
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_folder = __DIR__ . '/../../uploaded_img/' . $image;

            $existing = $this->authModel->getUserByEmail($email);

            if ($existing) {
                $messages[] = 'user email already exist!';
            } else {
                if ($pass != $cpass) {
                    $messages[] = 'confirm password not matched!';
                } else {
                    $hashed_pass = hash_password($pass);
                    $registered = $this->authModel->createUser($name, $email, $hashed_pass, $image);

                    if ($registered) {
                        if ($image_size > 2000000) {
                            $messages[] = 'image size is too large!';
                        } else {
                            move_uploaded_file($image_tmp_name, $image_folder);
                            $messages[] = 'registered successfully!';
                            header('Location: index.php?action=login');
                            exit();
                        }
                    }
                }
            }
        }

        require __DIR__ . '/../views/register.php';
    }
}

?>
