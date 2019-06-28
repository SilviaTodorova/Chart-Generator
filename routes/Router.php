<?php

class Router {
    private $routes;

    public function __construct(){
        $this->routes = [];
    }

    public function route($method, $path, $callback) {
        array_push($this->routes, [
            'method' => $method,
            'path' => $path,
            'callback' => $callback
        ]);
    }

    public function run(){
        
        foreach($this->routes as $route){
            if($route['method'] == HTTP_METHOD && preg_match("#$route[path]#", URL, $matches)){
                $route['callback']($matches);
                return;
            }
        }

        NoPageController::index(); 
    }
}

?>
