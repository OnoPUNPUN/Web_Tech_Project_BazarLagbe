<?php

require_once __DIR__ . '/../../shared/config/Database.php';
require_once __DIR__ . '/../../shared/helpers/Auth.php';
require_once __DIR__ . '/../models/ContactModel.php';
require_once __DIR__ . '/../models/AdminModel.php';

class ContactController {
    private $contactModel;
    private $adminModel;

    public function __construct() {
        global $conn;
        check_auth(['admin']);
        $this->contactModel = new ContactModel($conn);
        $this->adminModel = new AdminModel($conn);
    }

    public function handleRequest() {
        $admin_id = $_SESSION['user_id'];
        $fetch_profile = $this->adminModel->getAdminProfile($admin_id);

        if (isset($_GET['delete'])) {
            $delete_id = filter_var($_GET['delete'], FILTER_SANITIZE_STRING);
            $this->contactModel->deleteMessage($delete_id);
            header('Location: index.php?page=messages');
            exit();
        }

        $messages_list = $this->contactModel->getAllMessages();
        require __DIR__ . '/../views/contacts.php';
    }
}

?>
