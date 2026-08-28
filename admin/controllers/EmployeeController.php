<?php

require_once __DIR__ . '/../../shared/config/Database.php';
require_once __DIR__ . '/../../shared/helpers/Auth.php';
require_once __DIR__ . '/../models/EmployeeModel.php';
require_once __DIR__ . '/../models/AdminModel.php';

class EmployeeController {
    private $employeeModel;
    private $adminModel;

    public function __construct() {
        global $conn;
        check_auth(['admin']);
        $this->employeeModel = new EmployeeModel($conn);
        $this->adminModel = new AdminModel($conn);
    }

    public function handleRequest() {
        $admin_id = $_SESSION['user_id'];
        $fetch_profile = $this->adminModel->getAdminProfile($admin_id);
        $message = [];

        if (isset($_POST['pay_salary'])) {
            $message[] = 'Error: Admin is not authorized to pay employee salaries!';
        }

        if (isset($_POST['update_employee'])) {
            $emp_id = filter_var($_POST['employee_id'], FILTER_SANITIZE_NUMBER_INT);
            $salary = filter_var($_POST['salary'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);

            if ($salary < 0) {
                $message[] = 'Salary cannot be negative!';
            } else {
                $this->employeeModel->updateEmployee($emp_id, $salary, $status);
                $message[] = 'Employee information updated successfully!';
            }
        }

        $selected_month = isset($_GET['month']) ? filter_var($_GET['month'], FILTER_SANITIZE_STRING) : date('F Y');

        $employees = $this->employeeModel->getEmployeesPaymentStatusByMonth($selected_month);
        $payment_history = $this->employeeModel->getAllSalaryPayments();

        require __DIR__ . '/../views/employees.php';
    }
}

?>
