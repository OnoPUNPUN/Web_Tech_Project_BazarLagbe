<?php

class Database {
    private static $instance = null;
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "shop_db";
    private $conn = null;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Database Connection Failed: " . $this->conn->connect_error);
        }
        $this->conn->set_charset("utf8mb4");
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        if ($this->conn === null || !@$this->conn->ping()) {
            $this->connect();
        }
        return $this->conn;
    }
}

// Global mysqli instance variable $conn and $mysqli as requested
$db = Database::getInstance();
$conn = $db->getConnection();
$mysqli = $conn;

?>
