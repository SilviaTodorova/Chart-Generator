<?php

class NoPageController extends BaseController {

    function index() {
        header('HTTP/1.0 404 Not Found');
        http_response_code(404);
        BaseController::error('404.php');
        exit();
    }

}

?>
