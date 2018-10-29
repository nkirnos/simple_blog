<?php
namespace Config;

class ApplicationConfig
{
    public static function getInstance()
    {
        return new \Config(BASE_DIR . '/config.php');
    }
}