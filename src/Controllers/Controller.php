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
}