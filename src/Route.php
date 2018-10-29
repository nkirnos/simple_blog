<?php

class Route
{
    protected $uri, $methods, $controller_class;

    public function __construct($uri, $controller_class, $methods)
    {
        $this->setUri($uri);

        $this->setMethods($methods);

        $this->controller_class = $controller_class;
    }

    public function setMethods($methods)
    {
        $this->methods = is_array($methods) ? $methods : [$methods];
        
        foreach (array_keys($this->methods) as $key) {

            $this->methods[$key] = strtoupper($this->methods[$key]);

            if (!in_array($this->methods[$key], ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'])) {
                unset($this->methods[$key]);
            }
        }
    }

    public function getMethods()
    {
        return $this->methods;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public static function get($uri, $controller_class)
    {
        return new self($uri, $controller_class, ['GET']);
    }

    public static function post($uri, $controller_class)
    {
        return new self($uri, $controller_class, ['POST']);
    }

    public static function match($uri, $controller_class, $methods)
    {
        return new self($uri, $controller_class, $methods);
    }

    public function isAllowedMethod($method)
    {
        return in_array(strtoupper($method), $this->getMethods());
    }

    public function getControllerClass()
    {
        $controller_class = explode('::', $this->controller_class);
        return $controller_class[0];
    }

    public function getControllerFunction()
    {
        $controller_class = explode('::', $this->controller_class);
        return isset($controller_class[1]) ? $controller_class[1] : 'index';
    }
    
}