<?php

class Config
{
    protected $params = [];

    public function __construct($file_path)
    {
        if(is_file($file_path)) {
            $this->params = include($file_path);
        }
    }

    public function get($var_name, $default)
    {
        $chunks = explode('.', $var_name);


        $config = empty($this->params) ? $default : $this->params;

        foreach ($chunks as $param_name) {
            if (isset($config[$param_name])) {
                $config = $config[$param_name];
            } else {
                return $default;
            }
        }

        return $config;
    }
}