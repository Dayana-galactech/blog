<?php

namespace Models;
use Utility\Database;
require_once './utility/Database.php';

abstract class BaseModel {
  public $pdo;
  public $id;
  public $TABLE_NAME;

  public function __construct() {
    $this->TABLE_NAME = $this->getTableName();
    $this->pdo = Database::getConnection();
  }

  abstract function getTableName();
  
 
   public function getAll($page=0, $count = 10) {
    $start = ($page) * $count;
    $sql = "SELECT * FROM " . $this->TABLE_NAME." LIMIT " . $start . ',' . $count;
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll();
    return  $data;
  }

  public function getByID($id){
    $sql = "SELECT * FROM " . $this->TABLE_NAME . " WHERE id =?;";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$id]);
    $data = $stmt->fetchAll();
    return  $data;
  }

  public function create(array $data){
    $keys = array_keys($data);
    $values  = array_values($data);
    $questionMarks = array_fill(0, count($keys), '?');

    $sql = "INSERT INTO ". $this->TABLE_NAME ." (".implode(',', $keys).") VALUES(".implode(',', $questionMarks).");";
    $stmt = $this->pdo->prepare($sql);
    $record=$stmt->execute($values);
    
   
  return $record; 
  }


  public function update(int $id, array $data){
    $keys=array();
    $values=array();
    foreach ($data as $x=>$v){
      array_push($keys,$x);
      array_push($values,$v);
    }

    $sql = "UPDATE ". $this->TABLE_NAME ." SET ".$keys[1]."='".$values[1]."',".$keys[2]."='".$values[2]."' WHERE id=?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$id]);
    $record= $stmt->execute();
    return $record; 
  } 

  public function delete(int $id){
    $sql = "DELETE FROM " . $this->TABLE_NAME . " WHERE id=?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$id]);
    return  $stmt;
  }

}