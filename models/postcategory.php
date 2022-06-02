<?php

use Models\BaseModel;
use Utility\Database;

require_once './utility/Database.php';

class postcategory extends BaseModel
{

    private $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = new Database;
    }
    public function postcategory($postID, $categoryID)
    {
        $sql = "INSERT INTO postcategory (postID,categoryID) VALUES($postID,$categoryID)";
        $stmt = $this->pdo->prepare($sql);
        $record = $stmt->execute();
        return $record;
    }
    public function updatepostcategory($postID, $categoryID)
    {
        $sql = "UPDATE " . $this->TABLE_NAME . " SET categoryID='$categoryID' WHERE postID=$postID";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $record = $stmt->execute();
        return $record;
    }

    function getTableName()
    {
        return 'postcategory';
    }
}
