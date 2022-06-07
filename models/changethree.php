<?php

use Models\BaseModel;
use Utility\Database;

require_once './utility/Database.php';

class changethree extends BaseModel
{

    private $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = new Database;
    }
  
    public function create($data)
    {
     $sql = "INSERT INTO " . $this->TABLE_NAME . " (postID) VALUES(" . $data . ");";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt;
    }
    function getTableName()
    {
        return 'card3';
    }
}
