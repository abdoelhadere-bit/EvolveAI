<?php

namespace app\Core;


class Router {
    protected $currentController = 'app\Controllers\HomeController';
    protected $currentMethod = 'index'; 
    protected $params = [];

    public function __construct() {
        $url = $this->getUrl();
        
        $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);

        if (isset($url[0])) {
            $controllerName = 'app\Controllers\\' . ucfirst($url[0]) . 'Controller';
            if (class_exists($controllerName)) {
                $this->currentController = $controllerName;
                unset($url[0]);
            } else {
                $this->handleNotFound();
                return;
            }
        }

        try {
            $this->currentController = new $this->currentController();
        } catch (\Throwable $e) {
            $this->handleNotFound();
            return;
        }

        $urlMethod = isset($url[1]) ? $url[1] : 'index';
        
        $targetMethod = $requestMethod . ucfirst($urlMethod);

        if (method_exists($this->currentController, $targetMethod) && is_callable([$this->currentController, $targetMethod])
        ) {
            $this->currentMethod = $targetMethod;
            if(isset($url[1])) unset($url[1]);
        } else {

            $this->handleNotFound();
            return;
        }

        $this->params = $url ? array_values($url) : [];

        $this->currentController = new $this->currentController; 
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    protected function handleNotFound() {
        
        http_response_code(404);
        echo "404 - Not Found";
        exit();
    }

    public function getUrl() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }
}