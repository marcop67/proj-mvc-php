<?php

require_once './App/Db/DbPDO.php';
use App\Db\DbPDO as Db;

class Controller
{
    public $dbConnection = null;

    function __construct()
    {
        $this->openDatabaseConnection();
    }

    private function openDatabaseConnection()
    {
        // set the (optional) options of the PDO connection. in this case, we set the fetch mode to
        // "objects", which means all results will be objects, like this: $result->user_name !
        // For example, fetch mode FETCH_ASSOC would return results like this: $result["user_name] !
        // @see http://www.php.net/manual/en/pdostatement.fetch.php
        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);

        // generate a database connection, using the PDO connector
        // @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
        //$pdoIstance = Db::getInstance(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS, $options);

        $this->dbConnection = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS, $options);

        //$this->dbConnection = $pdoIstance->getConnection();

    }

    public function loadModel(string $model_name)
    {
        require 'App/Models/' . $model_name . '.php';
        // return new model (and pass the database connection to the model)
        return new $model_name($this->dbConnection);
    }

    public function generateResponse($response)
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(200);
        echo json_encode($response);
    }

    public function generateError($error, $code)
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($code);
        echo json_encode($error);
        exit();
    }
}
