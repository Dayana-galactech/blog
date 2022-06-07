<?php

use Models\BaseModel;
use Utility\Database;

require_once './utility/Database.php';

class Comment extends BaseModel
{

    private $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = new Database;
    }
    public function createComment($data)
    {
    $keys = array_keys($data);
    $values  = array_values($data);
    $questionMarks = array_fill(0, count($keys), '?');

    $sql = "INSERT INTO " . $this->TABLE_NAME . " (" . implode(',', $keys) . ") VALUES(" . implode(',', $questionMarks) . ");";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($values);
    $id = $this->pdo->lastInsertId();
    return $id;
    }
    public function getComment()
    {
        $this->db->query('SELECT * FROM comments');
        $row = $this->db->single();
        return $row;
    }
    public function deleteComment($id){
        $sql = "DELETE FROM " . $this->TABLE_NAME . " WHERE commentID=$id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return  $stmt;
    }
    function getTableName()
    {
        return 'comments';
    }
}
