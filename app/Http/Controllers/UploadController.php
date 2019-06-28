
<?php

include LIB_DIR.'classes/PHPExcel/IOFactory.php';
include LIB_DIR.'classes/PHPExcel/Cell.php';

class UploadController extends BaseController
{
    private static $controller = 'upload';

    public function index() {
        try {
            $data = array();
            if(BaseController::isLoggedIn()) {
                if (isset($_POST) && isset($_POST['import'])) {
                
                  $allowedFileType = [
                                        'application/vnd.ms-excel',
                                        'text/xls','text/xlsx',
                                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                                     ];
                  
                  if(in_array($_FILES['file']['type'], $allowedFileType)) {
                        $inputFileName = 'uploads/'.$_FILES['file']['name'];
                        move_uploaded_file($_FILES['file']['tmp_name'], $inputFileName);

                        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                        $objPHPExcel = $objReader->load($inputFileName);
                        

                        $action = $_POST['action'];
                        $class = ucfirst('UploadController');
                        $controller = new $class();
                        call_user_func(array($controller,  $action), $objPHPExcel);
                        return;

                    } else {
                        BaseController::load('error.php');
                    }
               
                } else {
                    BaseController::load('error.php');
                }
            } else {
                BaseController::load('user/login.php', array('error_description' => 'Изисква се регистрация.'));
            }
        } catch (Exception $e) {
            BaseController::load('error.php');
        }
    }

    private function uploadStudents($objPHPExcel) {
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        
        for ($row = 2; $row <= $highestRow; $row++) { 
            // echo  'A' . $row . ':' . $highestColumn . $row;
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);
           
            $user = new UserModel();
            $user->name = $rowData[0][1];
            $user->lastname = $rowData[0][2];
            $user->email = $rowData[0][3];
            $user->gender = $rowData[0][4];
            $user->password = $rowData[0][0];

            $student = new StudentModel();   
            $student->fn = $rowData[0][0];
            $student->group = $rowData[0][5];
            $student->speciality = $rowData[0][6];
            
            $upload = new UploadModel();
            $upload->user = $user;
            $upload->student = $student;

            if(!$upload->CreateStudentAccount()) {
                $user->id = BaseController::getUserId();
                $user_data = $user->getUserDataById();

                $students = $student->getAllStudents();
                $model = array(
                    'user_data' => $user_data,
                    'students' => $students,
                    'error_description' => 'Невалидни данни'
                );
                
                BaseController::display('student/students.php', $model);
                return;
            }
        }

        
        $user = new UserModel();
        $user->id = BaseController::getUserId();
        $user_data = $user->getUserDataById();

        $student = new StudentModel();
        $students = $student->getAllStudents();
        $model = array(
            'user_data' => $user_data,
            'students' => $students
        );

        BaseController::display('student/students.php', $model);
    }

    // HTTP Method: POST
    // ROLE: Teacher
    public function uploadMarksByCategoryAndStage($objPHPExcel) {
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        for ($row = 2; $row <= $highestRow; $row++) { 
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);

            $student = new StudentModel();
            $student->fn = $rowData[0][0];
            $result = $student->getStudentIdByFN();

            if(isset($result['student_id'])) {
                $mark = new MarkModel();
                $mark->student_id = $result['student_id'];
                $mark->category_id = $_POST['category'];
                $mark->stage = $_POST['stage'];
                $mark->mark_value = $rowData[0][1];
                $mark->author = $rowData[0][2];
                $mark->comment = $rowData[0][3];
    
                try {
                   $mark->addMark();     
                } catch(Exception $e) {
                //    echo $e->getMessage();
                //     $user = new UserModel();
                //     $user->id = BaseController::getUserId();
                //     $user_data = $user->getUserDataById();
                //     $student = new StudentModel();
                //     $results = $student->getAllStudentsResults();
    
                //     $model = array(
                //         'user_data' => $user_data,
                //         'results' => $results,
                //         'error_description' => 'Невалидни данни'.var_dump($mark)
                //     );
                    
                //     BaseController::display('student/student-results.php', $model);
                //     return;
                }
            }
           
        }

        $user = new UserModel();
        $user->id = BaseController::getUserId();
        $user_data = $user->getUserDataById();
        $student = new StudentModel();
        $results = $student->getAllStudentsResults();
        
        $model = array(
            'user_data' => $user_data,
            'results' => $results
        );
        
        BaseController::display('student/student-results.php', $model);
        return;
    }
}


