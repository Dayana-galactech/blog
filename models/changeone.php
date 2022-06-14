<?php

use Models\BaseModel;
use Utility\Database;

require_once './utility/Database.php';

class changeone extends BaseModel
{

    private $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = new Database;
    }
  
    public function add($post1ID,$post2ID,$post3ID)
    {
     $sql = "INSERT INTO " . $this->TABLE_NAME . " (post1ID,post2ID,post3ID) VALUES(" . $post1ID . "," . $post2ID . "," . $post3ID . ");";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt;
    }
    function getTableName()
    {
        return 'card1';
    }
}
