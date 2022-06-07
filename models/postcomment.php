<?php

use Models\BaseModel;
use Utility\Database;

require_once './utility/Database.php';

class postcomment extends BaseModel
{

    private $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = new Database;
    }
    public function postcomment($postID,$commentID)
    {
        $sql = "INSERT INTO postcomment (postID,commentID) VALUES($postID,$commentID)";
        $stmt = $this->pdo->prepare($sql);
        $record = $stmt->execute();
        return $record;
    }

    function getTableName()
    {
        return 'postcomment';
    }
}
