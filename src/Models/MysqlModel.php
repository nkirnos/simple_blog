<?php
namespace Models;
use \MysqlConnectionManager;
use \Config\ApplicationConfig;

class MysqlModel 
{
    protected $connection;
    protected $table_name;
    protected $fields = [];
    protected $fillable_fields = ['title', 'html'];

    public function __construct($connection = 'default')
    {
        $this->initConnection($connection);
        if(empty($this->table_name)) {
            $this->table_name = strtolower((new \ReflectionClass($this))->getShortName() . 's');
        }
        $this->initFields();
    }

    protected function initFields()
    {
        $db = $this->connection;
        $res = $db->prepare(sprintf('DESCRIBE `%s`', $this->table_name));
        $res->execute();
        $table_fields = $res->fetchAll(\PDO::FETCH_COLUMN);
        $data = [];
        foreach ($table_fields as $field_name) {
            if (!array_key_exists($field_name, $this->fields)){
                $this->fields[$field_name] = null;
            }
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

    public function save()
    {
        $data = $this->fields;
        
        if (array_key_exists('updated_at', $data)) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }
        if (!array_key_exists('id', $data) || empty($data['id'])) {
            $this->id = $this->insertRecord($data);
        } else {
            if($this->updateRecord($data)){
                $this->updated_at = $data['updated_at'];
            };
        }
    }

    public function remove()
    {
        if(!empty($this->fields['id'])) {
            $sql = sprintf('DELETE FROM `%s` where `id` = \'%s\'',
                $this->getTableName(),
                $this->id
            );
            if($this->connection->exec($sql)) {
                return true;
            }
        }
        return false;
    }

    public function toArray()
    {
        return $this->fields;
    }

    protected function insertRecord($data)
    {
        if(array_key_exists('id', $data)) {
            unset($data['id']);
        }
        $sql = sprintf('INSERT INTO `%s` (`%s`) VALUES(\'%s\')', 
            $this->getTableName(),
            join('`,`', array_keys($data)),
            join('\',\'', array_values($data))
        );
        $db = $this->connection;
        $res = $db->prepare($sql);
        $res->execute();
        return $db->lastInsertId();
    }

    protected function updateRecord($data)
    {
        $update_fields = [];
        foreach (array_keys($data) as $field_name) {
            $update_fields[$field_name] = sprintf('`%s` = \'%s\'', $field_name, $data[$field_name]);
        }
        unset($update_fields['id']);
        $sql = sprintf('UPDATE `%s` SET %s WHERE `id` = \'%s\'', 
            $this->getTableName(),
            join(', ', array_values($update_fields)),
            $data['id']
        );
        $db = $this->connection;
        $res = $db->prepare($sql);
        return $res->execute();
    }

    public function retrieve($id)
    {
        $db = $this->connection;
        $res = $db->prepare(sprintf('select * from `%s` where `id` = \'%s\'', $this->table_name, $id));
        if($res->execute()) {
            if($row = $res->fetch(\PDO::FETCH_ASSOC)) {
                foreach(array_keys($row) as $field_name) {
                    $this->$field_name = $row[$field_name];
                }
                return true;
            }
        }
        return false;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->fields)) {
            return $this->fields[$name];
        }
        return null;
    }

    public function __set($name, $value)
    {
        return $this->fields[$name] = $value;
    }

}