<?php 
  class Database {

    private $host = DB_HOST;
    private $db_name = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;

    public $conn;
    private static $instance = null;

    private function __construct() {
      $this->conn = null;
      try { 
        $this->conn = new PDO('mysql:host=' . $this->host . ';charset=utf8;dbname=' . $this->db_name, $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        // echo "Connection failed: " . $e->getMessage();
        echo "Грешка при свързване с базата";
      }
    }

    public static function getInstance() {
      if(!self::$instance){
          self::$instance = new Database();
      }

      return self::$instance;
  }

  }

    
?>