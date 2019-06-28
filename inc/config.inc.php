<?php
    $root = '/project_61999/';
    $rootPath = $_SERVER['DOCUMENT_ROOT'].$root;

    $libsPath = $rootPath.'libs/';
    $controllersPath = $rootPath.'app/Http/Controllers/';
    $modelsPath = $rootPath.'app/';
    $viewsPath = $rootPath.'resources/views/';

    $templatesPath = $rootPath.'resources/templates/';
        
    $method = $_SERVER['REQUEST_METHOD'];
    $filename = $_SERVER['SCRIPT_NAME'];
    $full_url = $_SERVER['REQUEST_URI'];
    $url = str_replace($filename,'',$full_url);

    $location = $_SERVER['REQUEST_SCHEME'].'://'. $_SERVER['SERVER_NAME'].$root;
    $localhost = 'localhost';
    $db_name = 'chart_generator';
    $username = 'root';
    $password = '';

    // Define constants
    define('ROOT', $root);
    define('LIB_DIR', $libsPath);
    
    define('CONTROLLERS_DIR', $controllersPath);
    define('MODELS_DIR', $modelsPath);
    define('VIEWS_DIR', $viewsPath);
    define('TEMPLATES_DIR', $templatesPath);

    define('HTTP_METHOD', $method);
    define('URL', $url);
    define('LOCATION', $location);

    //Database config
    define('DB_HOST', $localhost);
    define('DB_NAME', $db_name);
    define('DB_USER', $username);
    define('DB_PASS', $password);

?>
  
