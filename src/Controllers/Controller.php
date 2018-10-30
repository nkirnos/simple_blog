<?php

namespace Controllers;
use \View;

class Controller
{
    protected $view;

    public function __construct()
    {   
        $this->view = new View(BASE_DIR . '/views');
    }

    public function index()
    {
        echo get_class($this);
    }

    public function redirect($url, $http_response_code = 301, $replace = true)
    {
        header( sprintf('Location: %s', $url) , $replace, $http_response_code );
    }
}