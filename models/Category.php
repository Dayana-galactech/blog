<?php

use Models\BaseModel;
use Utility\Database;

require_once './utility/Database.php';

class Category extends BaseModel
{

    private $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = new Database;
    }
    public function createCategory($data) {
        return self::create($data);
    }
    public function getCategories(){
        $this->db->query('SELECT * FROM category');
       $row = $this->db->single();
            return $row;
        
    }
    public function deleteCategory($id){
        $sql = "DELETE FROM " . $this->TABLE_NAME . " WHERE categoryID=$id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return  $stmt;
    }
    public function updateCategory($categoryID,$userID,$name){
        $sql = "UPDATE " . $this->TABLE_NAME . " SET userID='$userID', name='$name' WHERE categoryID=$categoryID";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $record = $stmt->execute();
        return $record;
    }
    function getTableName()
    {
        return 'category';
    }
    
 
}
