<?php

class UploadModel extends BaseModel {
    public $student;
    public $user;

    public function __construct(){
      parent::__construct();
    }

    public function CreateStudentAccount() {
        try {
            $this->conn->beginTransaction();
            $rows = $this->user->createAccount();
            if($rows != 1) {
                return false;
            }
    
            $user_data = $this->user->getUserDataByEmail();
            if(!isset($user_data['user_id'])) {
                return false;
            }

            $this->student->user_id = $user_data['user_id'];
    
            $rows = $this->student->createStudent();
            if($rows != 1) {
                return false;
            }
    
            $this->conn->commit();
            return true;
        } catch(Exception $e) {
            return false;
        }
    }

      

  }


?>