<?php
namespace Route;

use \Controllers\NotFoundController;
use \Controllers\MethodNotAllowedController;
use \Controllers\ErrorController;

class Manager {
    protected $method;
    protected $request_uri;
    protected $domain;
    protected $scheme;
    protected $url;

    protected $routes = [];

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->request_uri = $_SERVER['REQUEST_URI'];
        $this->domain = $_SERVER['SERVER_NAME'];
        $this->scheme = $_SERVER['REQUEST_SCHEME'];
        $this->url = $this->scheme . '://' . $this->domain . $this->request_uri; 
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getRequestUri()
    {
        return $this->request_uri;
    }

    public function setRoutes($routes)
    {
        foreach ($routes as $route) {
            $methods = $route->getMethods();
            
            foreach ($methods as $method) {
                $this->routes[$route->getUri()][$method] = $route;
            }
        }
    }

    public function process()
    {
        $controller = $this->getController();
    }

    public function getController()
    {
        $page_url = parse_url($this->getUrl(), PHP_URL_PATH);

        if (isset($this->routes[$page_url])) {
            if (isset($this->routes[$page_url][$this->getMethod()])) {
                $route = $this->routes[$page_url][$this->getMethod()];
                $controller_class = $route->getControllerClass();
                $controller_function = $route->getControllerFunction();
                $controller = new $controller_class();
                if(method_exists($controller, $controller_function)){
                    return $controller->$controller_function();
                } else {
                    $controller = new ErrorController;
                    return $controller->error(
                        sprintf('Function \'%s\' not found in controller %s', 
                            $controller_function,
                            $controller_class
                        )
                    );
                }
            } else {
                $controller = new MethodNotAllowedController;
                return $controller->index();
            }
        }

        $controller = new NotFoundController;
        return $controller->index();
    }


}