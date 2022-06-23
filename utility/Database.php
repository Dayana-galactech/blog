<?php

namespace Utility;

use Exception;
use PDO;
class Database {

    public static function getConnection(){
        $pdo=null;
        try{
            $var=file_get_contents('./credentials.json');

            $config= (array) json_decode($var);

            $pdo = new PDO("mysql:host=" . $config['host'] . ";dbname=" .$config['dbname'].";port=".$config['port'], $config['user'], $config['password']);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec("set names utf8");
            
        }catch(Exception $exception){
           echo $exception->getMessage();
        }
        return $pdo;
    }

            //Allows us to write queries
            public function query($sql) {
                $database = new Database();
                $db = $database->getConnection();
                $this->statement = $db->prepare($sql);
            }
    
            //Bind values
            public function bind($parameter, $value, $type = null) {
                switch (is_null($type)) {
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;
                }
                $this->statement->bindValue($parameter, $value, $type);
            }
    
            //Execute the prepared statement
            public function execute() {
                return $this->statement->execute();
            }
    
            //Return an array
            public function resultSet() {
                $this->execute();
                return $this->statement->fetchAll(PDO::FETCH_OBJ);
            }
    
            //Return a specific row as an object
            public function single() {
                $this->execute();
                return $this->statement->fetch(PDO::FETCH_OBJ);
            }
    
            //Get's the row count
            public function rowCount() {
                return $this->statement->rowCount();
            }
            
}  

