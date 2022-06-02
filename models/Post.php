<?php

use Models\BaseModel;
use Utility\Database;

require_once './utility/Database.php';

class Post extends BaseModel
{

    private $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = new Database;
    }
    public function createPost($data)
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
    public function getPosts()
    {
        $this->db->query('SELECT * FROM posts');
        $row = $this->db->single();
        return $row;
    }
    public function deletePost($id){
        $sql = "DELETE FROM " . $this->TABLE_NAME . " WHERE postID=$id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return  $stmt;
    }
    public function updatePost($postID,$userID,$title,$image,$body,$published){
        $sql = "UPDATE " . $this->TABLE_NAME . " SET userID='$userID', title='$title', image='$image', body='$body', published='$published' WHERE postID=$postID";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $record = $stmt->execute();
        return $record;
    }
    function getTableName()
    {
        return 'posts';
    }
}
