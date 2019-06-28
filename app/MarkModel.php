<?php 

  class MarkModel extends BaseModel {
    private $table;

    public $id;
    public $student_id;
    public $category_id;
    public $stage;
    public $mark_value;
    public $author;
    public $comment;
    public $time_stamp;

    public function __construct(){
      parent::__construct();
      $this->table = "mark";
    }

    public function addMark() {
      $sql = "INSERT INTO $this->table (student_id, category_id, stage, mark_value, author, comment) VALUES (:student_id, :category_id, :stage, :mark_value, :author, :comment);";
        
      $connection = $this->conn;
      $pQuery = $connection->prepare($sql);
 
      $pQuery->bindParam(":student_id", $this->student_id);
      $pQuery->bindParam(":category_id", $this->category_id);
      $pQuery->bindParam(":stage", $this->stage);
      $pQuery->bindParam(":mark_value", $this->mark_value);
      $pQuery->bindParam(":author", $this->author);
      $pQuery->bindParam(":comment", $this->comment);

      $pQuery->execute();
      return $pQuery->rowCount();        
    }

    
  }

  ?>