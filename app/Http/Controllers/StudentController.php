<?php

class StudentController extends BaseController {
    private static $controller = 'student';

    // HTTP Method: GET
    // ROLE: Teacher
    public function getAllStudents() {
        try {
            if(BaseController::isLoggedIn() && BaseController::isTeacher()) {            
                $user = new UserModel();
                $user->id = BaseController::getUserId();
                $user_data = $user->getUserDataById();
    
                $student = new StudentModel();
                $students = $student->getAllStudents();
    
                $model = array(
                    'user_data' => $user_data,
                    'students' => $students
                );
                BaseController::display(self::$controller . '/students.php', $model);
            } else {
                BaseController::load('user/login.php', array('error_description' => 'Изисква се регистрация.'));
            }
        } catch (Exception $e) {
            BaseController::load('error.php');
        }
    }

    // HTTP Method: GET
    // ROLE: Teacher
    public function getAllStudentsResults() {
        try {
            if(BaseController::isLoggedIn() && BaseController::isTeacher()) {
                $user = new UserModel();
                $user->id = BaseController::getUserId();
                $user_data = $user->getUserDataById();
    
                $student = new StudentModel();
                $results = $student->getAllStudentsResults();
    
                $model = array(
                    'user_data' => $user_data,
                    'results' => $results
                );
                BaseController::display(self::$controller . '/student-results.php', $model);
            } else {
                BaseController::load('user/login.php', array('error_description' => 'Изисква се регистрация.'));
             }
        } catch (Exception $e) {
            BaseController::load('error.php');
        }
    }

    public function all() {
        try {
            if(BaseController::isLoggedIn() && BaseController::isTeacher()) {        
                $student = new StudentModel();
                $results = $student->getAllStudentsResults();
                $dapper_model = array();

                foreach ($results as $row) {
                    $tmp = array(
                        'fn' => $row['fn'],
                        'gender' => $row['gender'],
                        'category_name' => $row['category_name'],
                        'category_id' => $row['category_id'],
                        'stage' => $row['stage'],
                        'mark_value' => $row['mark_value']
                    );

                    array_push($dapper_model, $tmp);
                    
                }
                echo json_encode($dapper_model,JSON_UNESCAPED_UNICODE);
                return;
            } else {
                echo json_encode(array('message' => 'error'),JSON_UNESCAPED_UNICODE);
                return;
            }
        } catch (Exception $e) {
            echo json_encode(array('message' => 'error'),JSON_UNESCAPED_UNICODE);
            return;
        }  
    }
    // HTTP Method: POST
    // ROLE: Teacher
    public function getResultsCategoryStage() {
        try {
            if(BaseController::isLoggedIn() && BaseController::isTeacher()) {
                $student = new StudentModel();
                $students = $student->getResultsCategoryStage();
    
                $student_ids = array();
                $category_stage = array();
                $gender = array();
                $marks = array();

                foreach ($students as $row) {
                    array_push($student_ids, $row['student_id']);
                    array_push($category_stage, $row['category_name'].'_'.$row['stage']);
                    array_push($gender, $row['gender']);
                    array_push($marks, $row['mark_value']);
                }

                $model = array(
                    'student_id' => $student_ids,
                    'category_stage' => $category_stage,
                    'gender' => $gender,
                    'mark_value' => $marks,
                );
                echo json_encode($model,JSON_UNESCAPED_UNICODE);
                return;
            } else {
                echo json_encode(array('message' => 'error'),JSON_UNESCAPED_UNICODE);
                return;
            }
        } catch (Exception $e) {
            echo json_encode(array('message' => 'error'),JSON_UNESCAPED_UNICODE);
            return;
        }  
    }

    // Teacher & Student
    public function getStudentResults() {
        try {
            if(BaseController::isLoggedIn()) {
                $student = new StudentModel();
                $student->user_id = BaseController::getUserId();

                $results = $student->getStudentResults();
                //$all_results = $student->getAllStudentsResults();

                $model = array(
                    'results' => $results
                );

                echo json_encode($model,JSON_UNESCAPED_UNICODE);
                return;
            } else {
                BaseController::load('user/login.php', array('error_description' => 'Изисква се регистрация.'));
             }
        } catch (Exception $e) {
            BaseController::load('error.php');
        }
    }
}
