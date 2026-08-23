<?php

require_once __DIR__ . '/../../shared/config/Database.php';
require_once __DIR__ . '/../../shared/helpers/Auth.php';
require_once __DIR__ . '/../models/CategoryModel.php';
require_once __DIR__ . '/../models/AdminModel.php';

class CategoryController {
    private $categoryModel;
    private $adminModel;

    public function __construct() {
        global $conn;
        check_auth(['admin']);
        $this->categoryModel = new CategoryModel($conn);
        $this->adminModel = new AdminModel($conn);
    }

    public function handleRequest() {
        $admin_id = $_SESSION['user_id'];
        $fetch_profile = $this->adminModel->getAdminProfile($admin_id);
        $message = [];

        if (isset($_POST['add_category'])) {
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);

            if ($this->categoryModel->getCategoryByName($name)) {
                $message[] = 'category name already exists!';
            } else {
                $this->categoryModel->addCategory($name, $description);
                $message[] = 'category added successfully!';
            }
        }

        if (isset($_POST['update_category'])) {
            $cat_id = filter_var($_POST['cat_id'], FILTER_SANITIZE_STRING);
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);

            $this->categoryModel->updateCategory($cat_id, $name, $description);
            $message[] = 'category updated successfully!';
        }

        if (isset($_GET['delete'])) {
            $delete_id = filter_var($_GET['delete'], FILTER_SANITIZE_STRING);
            $this->categoryModel->deleteCategory($delete_id);
            header('Location: index.php?page=categories');
            exit();
        }

        $categories = $this->categoryModel->getAllCategories();
        require __DIR__ . '/../views/categories.php';
    }
}

?>
