<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

spl_autoload_register(function ($class_name) {
    $class_name = str_replace('\\', '/', $class_name);
    require_once  '../src/' . $class_name . '.php';
});

$app = new Application;

$app->setConfig(new Config($app->getBaseDir() . '/config.php'));

$app->run();
