<?php

require_once __DIR__ . '/../../shared/config/Database.php';
require_once __DIR__ . '/../../shared/helpers/Auth.php';
require_once __DIR__ . '/../models/ProfileModel.php';

class ProfileController {
    private $profileModel;

    public function __construct() {
        global $conn;
        check_auth(['admin']);
        $this->profileModel = new ProfileModel($conn);
    }

    public function handleRequest() {
        $admin_id = $_SESSION['user_id'];
        $fetch_profile = $this->profileModel->getProfile($admin_id);
        $message = [];

        if (isset($_POST['update_profile'])) {
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);

            $this->profileModel->updateProfileInfo($admin_id, $name, $email);

            $image = filter_var($_FILES['image']['name'], FILTER_SANITIZE_STRING);
            $image_size = $_FILES['image']['size'];
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_folder = __DIR__ . '/../../uploaded_img/' . $image;
            $old_image = $_POST['old_image'];

            if (!empty($image)) {
                if ($image_size > 2000000) {
                    $message[] = 'image size is too large!';
                } else {
                    $updated = $this->profileModel->updateProfileImage($admin_id, $image);
                    if ($updated) {
                        move_uploaded_file($image_tmp_name, $image_folder);
                        if (file_exists(__DIR__ . '/../../uploaded_img/' . $old_image)) {
                            unlink(__DIR__ . '/../../uploaded_img/' . $old_image);
                        }
                        $message[] = 'image updated successfully!';
                    }
                }
            }

            $update_pass = filter_var($_POST['update_pass'], FILTER_SANITIZE_STRING);
            $new_pass = filter_var($_POST['new_pass'], FILTER_SANITIZE_STRING);
            $confirm_pass = filter_var($_POST['confirm_pass'], FILTER_SANITIZE_STRING);

            if (!empty($update_pass) && !empty($new_pass) && !empty($confirm_pass)) {
                if (!verify_password($update_pass, $fetch_profile['password'])) {
                    $message[] = 'old password not matched!';
                } elseif ($new_pass != $confirm_pass) {
                    $message[] = 'confirm password not matched!';
                } else {
                    $hashed_new_pass = hash_password($confirm_pass);
                    $this->profileModel->updatePassword($admin_id, $hashed_new_pass);
                    $message[] = 'password updated successfully!';
                }
            }

            $fetch_profile = $this->profileModel->getProfile($admin_id);
        }

        require __DIR__ . '/../views/update_profile.php';
    }
}

?>
