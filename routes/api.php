<?php
    $router = new Router();

    // UserController
    $router->route('POST', 'login', function(){
        UserController::login(); 
    });

    $router->route('GET', 'logout', function(){
        UserController::logout(); 
    });

    $router->route('GET', 'user/profile', function(){
       UserController::profile(); 
    });

    $router->route('POST', 'user/editAccount', function(){
        UserController::editAccount(); 
    });

    // UploadController
    $router->route('POST', 'upload', function(){
        UploadController::index(); 
    });

    // StudentController
    $router->route('GET', 'student/getAllStudentsResults', function(){
        StudentController::getAllStudentsResults(); 
    });

    $router->route('POST', 'student/getStudentResults', function(){
        StudentController::getStudentResults(); 
    });

    $router->route('GET', 'student/getAllStudents', function(){
        StudentController::getAllStudents(); 
    });

    $router->route('POST', 'student/getResultsCategoryStage', function(){
        StudentController::getResultsCategoryStage(); 
    });

    $router->route('POST', 'student/all', function(){
        StudentController::all(); 
    });

    // ChartController
    $router->route('POST', 'chart/save', function(){
        ChartController::save(); 
    });

    $router->route('POST', 'chart/getAll', function(){
        ChartController::getAll(); 
    });

    $router->route('GET', 'chart/changeVisibility', function(){
        ChartController::changeVisibility(); 
    });

    $router->route('GET', 'chart/delete', function(){
        ChartController::delete(); 
    });

    // Home
    $router->route('GET', '', function(){
        UserController::index(); 
    });

    $router->run();

?>