<?php
namespace App\Db;
use PDO;

class DbPDO
{

    protected static $instance;
    protected $connection;

    public static function getInstance(string $dsn, string $username, string $password, array $options)
    {
        if(!static::$instance){
            static::$instance = new static($dsn, $username, $password, $options);
        }
        return static::$instance;

    }
    protected function __construct(string $dsn, string $username, string $password, array $options)
    {

        $this->connection = new PDO($dsn, $username, $password);
        if(array_key_exists('options', $options)){
            foreach ($options['options'] as  $opt){
                $this->connection->setAttribute(key($opt), current($opt));
            }
        }

    }
    public function getConnection() : PDO
    {
        return $this->connection;
    }

}

