<?php 
  class ChartModel extends BaseModel {
    private $table;

    public $id;
    public $img;
    public $is_visible;

    public function __construct(){
      parent::__construct();
      $this->table = "chart";
    }

    public function insert() {
        $sql = "INSERT INTO $this->table (img) VALUES (:img);";
          
        $connection = $this->conn;
        $pQuery = $connection->prepare($sql);
   
        $pQuery->bindParam(":img", $this->img);
  
        $pQuery->execute();
        return $pQuery->rowCount();               
    }

    public function getAll() {
        $sql = "SELECT chart_id, 
                       img,
                       is_visible
                FROM $this->table
                WHERE is_deleted = 0";


        $connection = $this->conn;
        $pQuery = $connection->prepare($sql);
        $pQuery->execute();

        $result = $pQuery->fetchAll(PDO::FETCH_ASSOC);
        return $result;              
      }

      public function getStudentChart() {
        $sql = "SELECT chart_id, 
                       img
                FROM $this->table
                WHERE is_visible = 1
                      AND is_deleted = 0";


        $connection = $this->conn;
        $pQuery = $connection->prepare($sql);
        $pQuery->execute();

        $result = $pQuery->fetchAll(PDO::FETCH_ASSOC);
        return $result;         
      }

    
      public function delete() {
        $sql = "UPDATE $this->table SET is_deleted = 1 WHERE chart_id = :id;";

        $connection = $this->conn;
        $pQuery = $connection->prepare($sql);

        $pQuery->bindParam(":id", $this->id);
        $pQuery->execute();

        return $pQuery->rowCount();       
      } 

      public function changeVisibility() {
        $sql = "UPDATE $this->table SET is_visible = :is_visible WHERE chart_id = :id;";

        $connection = $this->conn;
        $pQuery = $connection->prepare($sql);

        $pQuery->bindParam(":id", $this->id);
        $pQuery->bindParam(":is_visible", $this->is_visible);

        $pQuery->execute();
        return $pQuery->rowCount();      
      }
  
    }

  ?>