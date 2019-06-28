<?php 

  class StudentModel extends BaseModel {
    private $table;

    public $id;
    public $user_id;
    public $fn;
    public $group;
    public $speciality;

    public function __construct(){
      parent::__construct();
      $this->table = "student";
    }

    public function createStudent() {
      $sql = "INSERT INTO $this->table (user_id, fn, student_group, speciality) VALUES (:user_id, :fn, :student_group, :speciality);";
        
      $connection = $this->conn;
      $pQuery = $connection->prepare($sql);
 
      $pQuery->bindParam(":user_id", $this->user_id);
      $pQuery->bindParam(":fn", $this->fn);
      $pQuery->bindParam(":student_group", $this->group);
      $pQuery->bindParam(":speciality", $this->speciality);

      $pQuery->execute();
      return $pQuery->rowCount();        
    }

    public function getStudentIdByFN() {
      $sql = "SELECT student.student_id
              FROM student
              WHERE student.fn = :fn";

      $connection = $this->conn;
      $pQuery = $connection->prepare($sql);
      $pQuery->bindParam(":fn", $this->fn);

      $pQuery->execute();

      $result = $pQuery->fetch(PDO::FETCH_ASSOC);
      return $result;
    }

    public function getStudentDataById() {
      $sql = "SELECT student.fn, 
                     user.email, 
                     user.name, 
                     user.lastname, 
                     student.student_group,
                     student.speciality
                FROM student INNER JOIN user on student.user_id = user.user_id
                WHERE student.user_id = :user_id";

        $connection = $this->conn;
        $pQuery = $connection->prepare($sql);
        $pQuery->bindParam(":user_id", $this->user_id);

        $pQuery->execute();
  
        $result = $pQuery->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAllStudents() {
        $sql = "SELECT  student.student_id, 
                        student.fn,
                        email, 
                        name, 
                        lastname, 
                        student.user_id,
                        gender.gender,
                        student.student_group,
                        student.speciality
                FROM student INNER JOIN user on student.user_id = user.user_id
                INNER JOIN gender on user.gender_id = gender.gender_id
                ORDER BY student_id";

        $connection = $this->conn;
        $pQuery = $connection->prepare($sql);
        $pQuery->execute();
  
        $result = $pQuery->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAllStudentsResults() {
        $sql = "SELECT student.fn, 
                       gender.gender,
                       user.email, 
                       user.name, 
                       user.lastname, 
                       category.category_name, 
                       category.category_id,
                       mark.stage,
                       mark.mark_value,
                       mark.author,
                       mark.comment     
                FROM student INNER JOIN mark on student.student_id = mark.student_id 
                              INNER JOIN user ON student.user_id = user.user_id
                              INNER JOIN category ON mark.category_id = category.category_id
                              INNER JOIN gender ON gender.gender_id = user.gender_id
                ORDER By category_id, stage DESC";


        $connection = $this->conn;
        $pQuery = $connection->prepare($sql);
        $pQuery->execute();

        $result = $pQuery->fetchAll(PDO::FETCH_ASSOC);
        return $result;              
    }

    public function getResultsCategoryStage() {
      $sql="SELECT  student.student_id, 
                    category.category_name, 
                    mark.stage,
                    mark.mark_value,
                    gender.gender
            FROM student INNER JOIN mark on student.student_id = mark.student_id 
                         INNER JOIN user ON student.user_id = user.user_id
                         INNER JOIN gender ON user.gender_id = gender.gender_id
                         INNER JOIN category ON mark.category_id = category.category_id
            WHERE category.category_id = :category_id AND
                  mark.stage = :stage";

      $connection = $this->conn;
      $pQuery = $connection->prepare($sql);
 
      $pQuery->bindParam(":category_id", $this->category_id);
      $pQuery->bindParam(":stage", $this->stage);

      $pQuery->execute();
      $result = $pQuery->fetchAll(PDO::FETCH_ASSOC);
      return $result;       

    }

    public function getStudentResults() {
      
      $sql = "SELECT mark.mark_value, 
                     category.category_name, 
                     stage,
                     mark.author,
                     mark.comment
              FROM student INNER JOIN mark on student.student_id = mark.student_id 
                           INNER JOIN category on mark.category_id = category.category_id
              WHERE student.user_id = :user_id;";

      $connection = $this->conn;
      $pQuery = $connection->prepare($sql);

      $pQuery->bindParam(":user_id", $this->user_id);
      $pQuery->execute();

      $result = $pQuery->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    }
    
  }

  ?>