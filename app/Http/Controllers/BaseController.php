<?php 
    class BaseController {
        public function __construct(){

        }

        function signIn($model) {
            $_SESSION['id'] = base64_encode($model['user_id']);
            $_SESSION['role'] = base64_encode($model['role_id']);
        }

        function logout() {
            session_unset();
            session_destroy();
        }

        function isLoggedIn() {
            if( isset($_SESSION) && isset($_SESSION['id'])) {
                return true;
            } else {
                return false;
            }
        }

        // We have to be sure that user is logged in.
        function getUserId() {
            return base64_decode($_SESSION['id']);
        }

        // We have to be sure that user is logged in.
        function getUserRole() {
            return base64_decode($_SESSION['role']);
        }

        // We have to be sure that user is logged in.
        function isTeacher() {
            $role = BaseController::getUserRole();
            if( $role == 1) {
                return true;
            } else {
                return false;
            }   
        }

        // It's the connection between controller and view
        function display($template, $model = array()) {
            // Include header
            include_once TEMPLATES_DIR.'header.php';

            // Include role basic template
            if(BaseController::isLoggedIn()) {
                if(BaseController::isTeacher()) {
                    include_once TEMPLATES_DIR.'sidebar-teacher.php';
                } else {
                    include_once TEMPLATES_DIR.'navbar-student.php';
                }
            }
            
            // Include current page
            include_once VIEWS_DIR.$template;

            // Include footer
            include_once TEMPLATES_DIR.'buttons.php';
            include_once TEMPLATES_DIR.'footer.php';
        }  

        function load($template, $model = array()) {
            // Include header
            include_once TEMPLATES_DIR.'header.php';

            // Include current page
            include_once VIEWS_DIR.$template;

            // Include footer
            include_once TEMPLATES_DIR.'footer.php';
        }  
        
    }



   
?>