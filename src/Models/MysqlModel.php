<?php
namespace Models;
use \MysqlConnectionManager;
use \Config\ApplicationConfig;

class MysqlModel 
{
    protected $connection;
    protected $table_name;
    protected $fillable_fields = ['title', 'html'];

    public function __construct($connection = 'default')
    {
        $this->initConnection($connection);
        if(empty($this->table_name)) {
            $this->table_name = strtolower((new \ReflectionClass($this))->getShortName() . 's');
        }
    }

    
    public static function all()
    {
        $instance = new static($connection = 'default');
        return $instance->getAll();
    }

    protected function initConnection($connection_name)
    {
        $config = ApplicationConfig::getInstance();
        $this->connection = MysqlConnectionManager::getInstance($connection_name, $config);
    }

    protected function getConnection()
    {
        return $this->connection;
    }

    public function getTableName()
    {
        return $this->table_name;
    }

    public function getAll()
    {
        $db = $this->connection;
        $res = $db->prepare(sprintf('select * from `%s`', $this->table_name));
        $res->execute();
        $result = [];
        while ($row = $res->fetchObject(static::class)) {
            $result[] = $row;
        }
        return $result;
    }

}