<?php
session_start();

class UserController extends BaseController {
    private static $controller = 'user';

    // HTTP Method: GET & POST
    public function login() {
        try {
            if (isset($_POST) && 
                isset($_POST['email']) && 
                isset($_POST['password'])) {

                $user = new UserModel();
                $user->email = $_POST['email'];
                $user->password = $_POST['password'];

                $errors = UserController::getErrors($user);

                $is_exist = 0;

                if(!get_object_vars($errors)) {
                   // Check user exists
                  $is_exist = $user->isUserExist();
                }
                
                if ($is_exist > 0) {
                    $user_data = $user->getUserDataByEmail();
                    $encypted_password = $user_data['password'];
                    
                    if (isset($encypted_password)) {
                        if (password_verify($user->password, $encypted_password)) {
                            // Set data in session
                            BaseController::signIn($user_data);

                            // Load home page
                            UserController::index();
                        } else {
                            BaseController::load(self::$controller . '/login.php', array('error_description' => 'Невалидна парола'));
                        }
                    }
                } else {
                  BaseController::load(self::$controller . '/login.php', array('error_description' => 'Невалидно потребителско име'));
                }
            } else {
             BaseController::load(self::$controller . '/login.php', array('error_description' => 'Възникна грешка. Свършете се с администратор.'));
            }

        } catch (Exception $e) {
         BaseController::load(self::$controller . '/login.php', array('error_description' => 'Възникна грешка. Свършете се с администратор.'));
        }
    }

    // HTTP Method: GET
    public function logout() {
      try {
        BaseController::logout();
        BaseController::load(self::$controller . '/login.php');
      } catch (Exception $e) {
        BaseController::display(self::$controller . '/login.php', array('error_description' => 'Възникна грешка. Свършете се с администратор.'));
      }
    }

    // HTTP Method: GET
    // ROLE: Teacher & Student
    public function index() {
      try {
        if(BaseController::isLoggedIn()) {

          // Load home page. It depends on user role.
          if(BaseController::isTeacher()) {
            $user = new UserModel();
            $user->id = BaseController::getUserId();
            $user_data = $user->getUserDataById();

            $model = array(
                'user_data' => $user_data,
                'url' => LOCATION
            );

            BaseController::display(self::$controller . '/charts.php',$model);
          } else {
            $student = new StudentModel();
            $student->user_id = BaseController::getUserId();

            $chart = new ChartModel();

            $student_data = $student->getStudentDataById();
            $charts = $chart->getStudentChart();

            $results = $student->getStudentResults();

            $model = array(
              'student_data' => $student_data,
              'charts' => $charts,
              'results' => $results
            );

            BaseController::display(self::$controller . '/homepage.php', $model);
          }
        } else {
          BaseController::load(self::$controller . '/login.php');
        }
      } catch (Exception $e) {
        BaseController::load(self::$controller . '/login.php', array('error_description' => 'Възникна грешка. Свършете се с администратор.'));
      }
    }

    // HTTP Method: GET
    // ROLE: Teacher & Student
    public function profile() {
      try {
        if(BaseController::isLoggedIn()) {

          $user = new UserModel();
          $user->id = BaseController::getUserId();
          $user_data = $user->getUserDataById();

          $model = array(
            'user_data' => $user_data
          );

          BaseController::display(self::$controller . '/profile.php', $model);
        } else {
          BaseController::display(self::$controller . '/login.php', array('error_description' => 'Изисква се регистрация.'));
        }
      } catch (Exception $e) {
        BaseController::display(self::$controller . '/login.php', array('error_description' => 'Възникна грешка. Свършете се с администратор.'));
      }
    }

    // HTTP Method: POST
    // ROLE: Teacher & Student
    public function editAccount() {
      
      try {
        if(BaseController::isLoggedIn()) {
          $user = new UserModel();
          $user->id = BaseController::getUserId();
          $user_data = $user->getUserDataById();
          $model = array(
            'user_data' => $user_data,
            'error_description' => 'Невалидни данни'
          );

          if (isset($_POST)) {

              // Only Teacher can change his name and lastname 
              if(BaseController::isTeacher()) {
                  if(isset($_POST['name']) && isset($_POST['lastname'])) {
                    $user->name = $_POST['name'];
                    $user->lastname = $_POST['lastname'];
                    
                    $errors = UserController::getErrorsName($user);
                    if(!get_object_vars($errors)) {
                      $user->updateUserData();
                    } else {
                        BaseController::display(self::$controller . '/profile.php', $model);
                        return;
                    }
                    
                  } else {
                    BaseController::display(self::$controller . '/profile.php', $model);
                    return;
                  }
                } 
              
                // Both Teacher & Student can change their password
                if(isset($_POST['password']) && isset($_POST['confirm-password']) && $_POST['new-password']) {
                  if(strcmp($_POST['new-password'], $_POST['confirm-password']) == 0) {
                    
                    $encypted_password = $user_data['password'];

                    if (isset($encypted_password)) {
                      
                        if (password_verify($_POST['password'], $encypted_password)) {
                          $user->password = $_POST['new-password'];
                          $row = $user->updatePassword();

                          if($row != 1 ) {
                            BaseController::display(self::$controller . '/profile.php', $model);
                            return;
                          }

                        } else {
                            BaseController::display(self::$controller . '/profile.php', $model);
                            return;
                        }
                    } else {
                      BaseController::display(self::$controller . '/profile.php', $model);
                      return;
                    }
                  } else {
                    BaseController::display(self::$controller . '/profile.php', $model);
                    return;
                }
                }

              } else {
                BaseController::display(self::$controller . '/profile.php', $model);
                return;
              }

              $user_data = $user->getUserDataById();
              $model = array(
                'user_data' => $user_data,
                'success_description' => 'Успешно променени данни.'
              );

              if(BaseController::isTeacher()) {
                BaseController::display(self::$controller . '/profile.php', $model);
              } else {
                UserController::index();
              }
             
              
        } else {
          BaseController::display(self::$controller . '/login.php', array('error_description' => 'Изисква се регистрация.'));
        }
      } catch (Exception $e) {
        BaseController::load('error.php');
      }
  }

  private function getErrors($user){  
    $errors = new stdClass();

    $isAllSet =isset($user->email) && isset($user->password);
   
    if(!$isAllSet) {
      $errors->data ='Невалидни данни';
      return $errors;
    } 

    $email_len = is_string($user->email) ? strlen($user->email) : 0;
    if($email_len <= 0  || $email_len > 255 || !preg_match('/([^@]+@[^\.]+\..+)/',$user->email)){
        $errors->email ='Невалиден имейл';
    }

    $pass_len = is_string($user->password) ? strlen($user->password) : 0;
    if($pass_len <= 0  || $pass_len > 2056){
        $errors->password ='Невалидна парола';
    }

    return $errors;
  }

  private function getErrorsName($user){  
    $errors = new stdClass();

    $isAllSet = isset($user->name) && isset($user->lastname);
   
    if(!$isAllSet) {
      $errors->data ='Невалидни данни';
      return $errors;
    } 

    $name_len = is_string($user->name) ? strlen($user->name) : 0;
    if($name_len <= 0  || $name_len > 100 || !preg_match('/^[\p{Cyrillic}\s\-]+$/u',$user->name)){
        $errors->name ='Невалидно име';
    } 
    
    $lastname_len = is_string($user->lastname) ? strlen($user->lastname) : 0;
    if($lastname_len <= 0  || $lastname_len > 100 || !preg_match('/^[\p{Cyrillic}\s\-]+$/u',$user->lastname)){
        $errors->lastname ='Невалидна фамилия';
    } 

    return $errors;
  }

  private function isRole($role){

    if(isset($_SESSION['id'])){
      
      $user = new UserModel();
      $user->id = base64_decode($_SESSION['id']);
      
      $result = json_decode($user->getUserRole());
      return isset($result->role) && $result->role == $role;
  } else {
    return false;
  }
}

}
