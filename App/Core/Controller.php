<?php

require_once './App/Db/DbPDO.php';
use App\Db\DbPDO as Db;
/**
 * This is the "base controller class". All other "real" Controllers extend this class.
 */
class Controller
{
    /**
     * @var null Database Connection
     */
    public $dbConnection = null;

    /**
     * Whenever a controller is created, open a database connection too. The idea behind is to have ONE connection
     * that can be used by multiple Models (there are frameworks that open one connection per model).
     */
    function __construct()
    {
        $this->openDatabaseConnection();
    }

    /**
     * Open the database connection with the credentials from application/Config/Config.php
     */
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

    /**
     * Load the model with the given name.
     * loadModel("SongModel") would include Models/songmodel.php and create the object in the controller, like this:
     * $songs_model = $this->loadModel('SongsModel');
     * Note that the model class name is written in "CamelCase", the model's filename is the same in lowercase letters
     * @param string $model_name The name of the model
     * @return object model
     */
    public function loadModel(string $model_name)
    {
        require 'App/Models/' . $model_name . '.php';
        // return new model (and pass the database connection to the model)
        return new $model_name($this->dbConnection);
    }

    public function generateResponse($response)
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
    }

    public function generateError($error)
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($error);
        exit();
    }
}
