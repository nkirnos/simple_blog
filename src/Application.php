<?php

class Application {

    protected $base_dir;

    protected $config;

    public $view_manager;

    public function __construct()
    {
        $this->setBaseDir(realpath('../'));
    }

    public function setBaseDir($base_dir)
    {
        $this->base_dir = $base_dir;
        if(!defined('BASE_DIR')) {
            define('BASE_DIR', $this->base_dir);
        }
    }

    public function run()
    {
        $this->processRoute();
    }

    protected function processRoute()
    {
        $routes_manager = new Route\Manager;

        $route_file = $this->getBaseDir() . '/routes.php';
        
        if (is_file($route_file)) {
            $routes_manager->setRoutes(include($route_file));
        }

        $routes_manager->process();
    }

    public function getBaseDir()
    {
        return $this->base_dir;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function setConfig($config)
    {
        $this->config = $config;
    }
}