<?php

namespace App\Core;

class Router
{
    protected string $controllerClass = 'App\Controllers\HomeController';
    protected string $method = 'getIndex';
    protected array $params = [];

    public function __construct()
    {
        $url = $this->getUrl();
        $httpMethod = strtolower($_SERVER['REQUEST_METHOD']); 

        if (!empty($url[0])) {
            $candidate = 'App\Controllers\\' . ucfirst($url[0]) . 'Controller';
            if (!class_exists($candidate)) {
                $this->handleNotFound();
            }
            $this->controllerClass = $candidate;
            unset($url[0]);
        }

        // 2️⃣ Instantiate controller (NO try/catch silent)
        $controller = new $this->controllerClass();

        // 3️⃣ Resolve method
        if (!empty($url[1])) {
            $candidateMethod = $httpMethod . ucfirst($url[1]);
            if (method_exists($controller, $candidateMethod)) {
                $this->method = $candidateMethod;
                unset($url[1]);
            }
        }

        // 4️⃣ Params
        $this->params = array_values($url);

        // 5️⃣ Safe call
        if (!is_callable([$controller, $this->method])) {
            $this->handleNotFound();
        }

        call_user_func_array([$controller, $this->method], $this->params);
    }

    protected function handleNotFound(): void
    {
        http_response_code(404);
        echo "404 - Not Found";
        exit;
    }

    protected function getUrl(): array
    {
        if (!empty($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }
}
