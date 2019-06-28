<?php 

  class UserModel extends BaseModel {
    private $table;

    public $id;
    public $name;
    public $lastname;
    public $email;
    public $password;
    public $role;
    public $gender;

    public function __construct(){
      parent::__construct();
      $this->table = "user";
    }

    public function createAccount() {
        $sql = "INSERT INTO $this->table (name, lastname, email, password, gender_id) VALUES (:username, :lastname, :email, :pass, :gender);";
        
        $connection = $this->conn;
        $pQuery = $connection->prepare($sql);
   
        $pass = password_hash($this->password, PASSWORD_DEFAULT);
        
        $pQuery->bindParam(":username", $this->name);
        $pQuery->bindParam(":lastname", $this->lastname);
        $pQuery->bindParam(":email", $this->email);
        $pQuery->bindParam(":pass", $pass);
        $pQuery->bindParam(":gender", $this->gender);

        $pQuery->execute();
        return $pQuery->rowCount();        
    }

    public function updateUserData() {
      $sql = "UPDATE $this->table SET name = :name, lastname = :lastname WHERE user_id = :id;";
   
      $connection = $this->conn;
      $pQuery = $connection->prepare($sql);
   
      $pass = password_hash($this->password, PASSWORD_DEFAULT);
      
      $pQuery->bindParam(":id", $this->id);
      $pQuery->bindParam(":name", $this->name);
      $pQuery->bindParam(":lastname", $this->lastname);

      $pQuery->execute();
      return $pQuery->rowCount(); 
    }

    public function updatePassword() {
      $sql = "UPDATE $this->table SET password = :pass WHERE user_id = :id;";
   
      $connection = $this->conn;
      $pQuery = $connection->prepare($sql);
   
      $pass = password_hash($this->password, PASSWORD_DEFAULT);
      
      $pQuery->bindParam(":id", $this->id);
      $pQuery->bindParam(":pass", $pass);

      $pQuery->execute();
      return $pQuery->rowCount(); 
    }

    public function isUserExist() {
      $sql = "SELECT user_id FROM $this->table WHERE email LIKE :email;";

      $connection = $this->conn;
      $pQuery = $connection->prepare($sql);

      $pQuery->bindParam(":email", $this->email);
      $pQuery->execute();

      $result = $pQuery->fetch(PDO::FETCH_ASSOC);
      return $pQuery->rowCount();
    }

    public function getUserDataByEmail() {
      $sql = "SELECT user_id, name, lastname, email, role_id, password FROM $this->table WHERE email LIKE :email;";

      $connection = $this->conn;
      $pQuery = $connection->prepare($sql);

      $pQuery->bindParam(":email", $this->email);
      $pQuery->execute();

      $result = $pQuery->fetch(PDO::FETCH_ASSOC);
      return $result;
    }

    public function getUserDataById() {
      $sql = "SELECT user_id, name, lastname, email, role_id, password, gender_id FROM $this->table WHERE user_id = :id;";

      $connection = $this->conn;
      $pQuery = $connection->prepare($sql);

      $pQuery->bindParam(":id", $this->id);
      $pQuery->execute();

      $result = $pQuery->fetch(PDO::FETCH_ASSOC);
      return $result;
    }

    public function getUserRole() {
        $sql = "SELECT role_id FROM $this->table WHERE user_id = :id;";

        $connection = $this->conn;
        $pQuery = $connection->prepare($sql);
  
        $pQuery->bindParam(":id", $this->id);
        $pQuery->execute();
  
        $result = $pQuery->fetch(PDO::FETCH_ASSOC);
        return $result;
      }
  }

  ?>