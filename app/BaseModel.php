<?php
    class BaseModel {
        public $conn;
        
        public function __construct() {
            $this->conn = Database::getInstance()->conn;
        }

    }

?>