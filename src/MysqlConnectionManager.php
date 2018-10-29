<?php

class MysqlConnectionManager
{
    protected static $instance;
    
    public static function getInstance($connection, $config)
    {
        if(!isset(self::$instance))
        {
            $db_config = $config->get('database.' . $connection, []);

            if(!empty($db_config))
            {
                $host = isset($db_config['db_host']) ? $db_config['db_host'] : '';
                $db = isset($db_config['db_name']) ? $db_config['db_name'] : '';
                $login = isset($db_config['db_user']) ? $db_config['db_user'] : '';
                $password = isset($db_config['db_pass']) ? $db_config['db_pass'] : '';
                $dsn = sprintf('mysql:host=%s;dbname=%s', $host, $db);
                self::$instance = new \PDO($dsn, $login, $password, array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
            } else {
                throw new \Exception('Empty db config');
            }
            
            
        }
        return self::$instance;
    }
}