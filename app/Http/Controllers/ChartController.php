<?php 
  class ChartController extends BaseController {
    private static $controller = 'chart';

    public function save() {
      try {
        
        if(BaseController::isLoggedIn() && BaseController::isTeacher()) { 
          if($_SERVER['CONTENT_TYPE'] == 'application/json'){
            $data = json_decode(file_get_contents('php://input'), false);
  
            if(isset($data->img)) {
              $chart = new ChartModel();

              $chart->img = $data->img;
              $chart->insert();
  
              echo json_encode(array('message' => 'success'),JSON_UNESCAPED_UNICODE);
              return;
            }
          }
        }

        echo json_encode(array('message' => 'error'),JSON_UNESCAPED_UNICODE);
        return;
        
      } catch (Exception $e) {
          echo json_encode(array('message' => 'error'),JSON_UNESCAPED_UNICODE);
          return;
      }  
    }

    public function getAll() {
      try {
          if(BaseController::isLoggedIn() && BaseController::isTeacher()) {        
              $chart = new ChartModel();
              $results = $chart->getAll();

              echo json_encode($results,JSON_UNESCAPED_UNICODE);
              return;
          } 

          echo json_encode(array('message' => 'error'),JSON_UNESCAPED_UNICODE);
          return;
          
      } catch (Exception $e) {
          echo json_encode(array('message' => 'error'),JSON_UNESCAPED_UNICODE);
          return;
      }  
  }

  public function getStudentChart() {
    try {
        if(BaseController::isLoggedIn() && BaseController::isTeacher()) {        
            $chart = new ChartModel();
            $results = $chart->getStudentChart();

            echo json_encode($results,JSON_UNESCAPED_UNICODE);
            return;
        } 

        echo json_encode(array('message' => 'error'),JSON_UNESCAPED_UNICODE);
        return;
        
    } catch (Exception $e) {
        echo json_encode(array('message' => 'error'),JSON_UNESCAPED_UNICODE);
        return;
    }  
  }

  public function changeVisibility() {
    try {
        if(BaseController::isLoggedIn() && BaseController::isTeacher()) {  
          
          if(isset($_GET["id"]) && isset($_GET["visible"])) {
            $chart = new ChartModel();
            $chart->id = $_GET["id"];
            $chart->is_visible = $_GET["visible"];
            $results = $chart->changeVisibility();
          }
        } 
          
        UserController::index();
        
    } catch (Exception $e) {
      echo var_dump($e);
      BaseController::load('error.php');
    }  
  }

  public function delete() {
    try {
        if(BaseController::isLoggedIn() && BaseController::isTeacher()) { 
          if(isset($_GET["id"])) {
            $chart = new ChartModel();
            $chart->id = $_GET["id"];
            $results = $chart->delete();
          }
         
        } 
          
       UserController::index();
        
    } catch (Exception $e) {
      BaseController::load('error.php');
    }  
  }
  

}
?>