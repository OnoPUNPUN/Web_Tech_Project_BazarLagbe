<?php

require_once __DIR__ . '/../../shared/config/Database.php';
require_once __DIR__ . '/../../shared/helpers/Auth.php';
require_once __DIR__ . '/../models/SalaryModel.php';
require_once __DIR__ . '/../models/StockManagerModel.php';

class SalaryController {
    private $salaryModel;
    private $stockManagerModel;

    public function __construct() {
        global $conn;
        check_auth(['stock_manager']);
        $this->salaryModel = new SalaryModel($conn);
        $this->stockManagerModel = new StockManagerModel($conn);
    }

    public function handleRequest() {
        $sm_id = $_SESSION['user_id'];
        $fetch_profile = $this->stockManagerModel->getProfile($sm_id);
        $message = [];

        if (isset($_POST['pay_salary'])) {
            $employee_id = filter_var($_POST['employee_id'], FILTER_SANITIZE_NUMBER_INT);
            $amount = filter_var($_POST['amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $salary_month = filter_var($_POST['salary_month'], FILTER_SANITIZE_STRING);
            $notes = filter_var($_POST['notes'], FILTER_SANITIZE_STRING);

            if ($amount <= 0) {
                $message[] = 'Salary payment amount must be greater than zero!';
            } elseif (empty($salary_month)) {
                $message[] = 'Salary month is required!';
            } else {
                $result = $this->salaryModel->paySalary($employee_id, $amount, $salary_month, $sm_id, $notes);
                $message[] = $result['message'];
            }
        }

        $selected_month = isset($_GET['month']) ? filter_var($_GET['month'], FILTER_SANITIZE_STRING) : date('F Y');

        $employees = $this->salaryModel->getEmployeesSalaryStatusByMonth($selected_month);
        $payments = $this->salaryModel->getAllSalaryPayments();

        require __DIR__ . '/../views/salary.php';
    }
}

?>
