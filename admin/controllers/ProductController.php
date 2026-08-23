<?php

require_once __DIR__ . '/../../shared/config/Database.php';
require_once __DIR__ . '/../../shared/helpers/Auth.php';
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';
require_once __DIR__ . '/../models/AdminModel.php';

class ProductController {
    private $productModel;
    private $categoryModel;
    private $adminModel;

    public function __construct() {
        global $conn;
        check_auth(['admin']);
        $this->productModel = new ProductModel($conn);
        $this->categoryModel = new CategoryModel($conn);
        $this->adminModel = new AdminModel($conn);
    }

    public function handleRequest() {
        $admin_id = $_SESSION['user_id'];
        $fetch_profile = $this->adminModel->getAdminProfile($admin_id);
        $message = [];

        if (isset($_GET['update'])) {
            $this->handleUpdate($_GET['update'], $admin_id, $fetch_profile);
            return;
        }

        if (isset($_POST['add_product'])) {
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $price = filter_var($_POST['price'], FILTER_SANITIZE_STRING);
            $category_id = filter_var($_POST['category_id'], FILTER_SANITIZE_STRING);
            $stock_quantity = filter_var($_POST['stock_quantity'], FILTER_SANITIZE_STRING);
            $low_stock_threshold = filter_var($_POST['low_stock_threshold'], FILTER_SANITIZE_STRING);
            $details = filter_var($_POST['details'], FILTER_SANITIZE_STRING);

            $cat_name = '';
            if (!empty($category_id)) {
                $stmt_cat = $this->productModel->getCategoriesList();
                foreach ($stmt_cat as $c) {
                    if ($c['id'] == $category_id) {
                        $cat_name = $c['name'];
                        break;
                    }
                }
            }

            $image = filter_var($_FILES['image']['name'], FILTER_SANITIZE_STRING);
            $image_size = $_FILES['image']['size'];
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_folder = __DIR__ . '/../../uploaded_img/' . $image;

            if ($this->productModel->getProductByName($name)) {
                $message[] = 'product name already exist!';
            } else {
                $inserted = $this->productModel->addProduct($name, $cat_name, $category_id, $details, $price, $stock_quantity, $low_stock_threshold, $image);
                if ($inserted) {
                    if ($image_size > 2000000) {
                        $message[] = 'image size is too large!';
                    } else {
                        move_uploaded_file($image_tmp_name, $image_folder);
                        $message[] = 'new product added!';
                    }
                }
            }
        }

        if (isset($_GET['delete'])) {
            $delete_id = filter_var($_GET['delete'], FILTER_SANITIZE_STRING);
            $product = $this->productModel->getProductById($delete_id);
            if ($product && file_exists(__DIR__ . '/../../uploaded_img/' . $product['image'])) {
                unlink(__DIR__ . '/../../uploaded_img/' . $product['image']);
            }
            $this->productModel->deleteProduct($delete_id);
            header('Location: index.php?page=products');
            exit();
        }

        $categories = $this->productModel->getCategoriesList();
        $products = $this->productModel->getAllProducts();
        require __DIR__ . '/../views/products.php';
    }

    private function handleUpdate($update_id, $admin_id, $fetch_profile) {
        $message = [];

        if (isset($_POST['update_product'])) {
            $pid = filter_var($_POST['pid'], FILTER_SANITIZE_STRING);
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $price = filter_var($_POST['price'], FILTER_SANITIZE_STRING);
            $category_id = filter_var($_POST['category_id'], FILTER_SANITIZE_STRING);
            $stock_quantity = filter_var($_POST['stock_quantity'], FILTER_SANITIZE_STRING);
            $low_stock_threshold = filter_var($_POST['low_stock_threshold'], FILTER_SANITIZE_STRING);
            $details = filter_var($_POST['details'], FILTER_SANITIZE_STRING);

            $cat_name = '';
            if (!empty($category_id)) {
                $stmt_cat = $this->productModel->getCategoriesList();
                foreach ($stmt_cat as $c) {
                    if ($c['id'] == $category_id) {
                        $cat_name = $c['name'];
                        break;
                    }
                }
            }

            $image = filter_var($_FILES['image']['name'], FILTER_SANITIZE_STRING);
            $image_size = $_FILES['image']['size'];
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_folder = __DIR__ . '/../../uploaded_img/' . $image;
            $old_image = $_POST['old_image'];

            $this->productModel->updateProduct($pid, $name, $cat_name, $category_id, $details, $price, $stock_quantity, $low_stock_threshold);
            $message[] = 'product updated successfully!';

            if (!empty($image)) {
                if ($image_size > 2000000) {
                    $message[] = 'image size is too large!';
                } else {
                    $updated_img = $this->productModel->updateProductImage($pid, $image);
                    if ($updated_img) {
                        move_uploaded_file($image_tmp_name, $image_folder);
                        if (file_exists(__DIR__ . '/../../uploaded_img/' . $old_image)) {
                            unlink(__DIR__ . '/../../uploaded_img/' . $old_image);
                        }
                        $message[] = 'image updated successfully!';
                    }
                }
            }
        }

        $product = $this->productModel->getProductById($update_id);
        $categories = $this->productModel->getCategoriesList();
        require __DIR__ . '/../views/update_product.php';
    }
}

?>
