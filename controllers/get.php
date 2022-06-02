<?php
if (session_id() == '') {
    session_start();
}
require_once('./utility/Database.php ');

use Utility\Database;


// function getCategory()
// {
//     $database = new Database();
//     $db = $database->getConnection();
//     $sql = "SELECT * FROM category";
//     $result = $db->query($sql);
//     while ($row = $result->fetchAll(PDO::FETCH_ASSOC)) {
//         return $row;
//     }
// }
function getCategory()
{
    $database = new Database();
    $db = $database->getConnection();
    $sql = "SELECT users.username, category.name, category.categoryID FROM users INNER JOIN category ON users.userID=category.userID";
    $result = $db->query($sql);
    while ($row = $result->fetchAll(PDO::FETCH_ASSOC)) {    
        return $row;
    }
}
function getPost()
{
    $database = new Database();
    $db = $database->getConnection();
    $sql = "SELECT users.username, posts.title, posts.postID, posts.createdAt, posts.published, posts.body FROM users INNER JOIN posts ON users.userID=posts.userID";
    $result = $db->query($sql);
    while ($row = $result->fetchAll(PDO::FETCH_ASSOC)) {    
        return $row;
    }
}

function getCategoryByYou()
{
    $userID = $_SESSION['user']['userID'];
    $database = new Database();
    $db = $database->getConnection();
    $sql = "SELECT users.username, category.name, category.categoryID FROM users INNER JOIN category ON users.userID=category.userID WHERE category.userID=$userID";
    $result = $db->query($sql);
    while ($row = $result->fetchAll(PDO::FETCH_ASSOC)) {
        return $row;
    }
}
function getPostByYou()
{
    $userID = $_SESSION['user']['userID'];
    $database = new Database();
    $db = $database->getConnection();
    $sql = "SELECT users.username, posts.title, posts.postID FROM users INNER JOIN posts ON users.userID=posts.userID WHERE posts.userID=$userID";
    $result = $db->query($sql);
    while ($row = $result->fetchAll(PDO::FETCH_ASSOC)) {
        return $row;
    }
}
function getPostCategory($postID){
    $database = new Database();
    $db = $database->getConnection();
    $sql="SELECT category.name From postcategory INNER JOIN category ON category.categoryID=postcategory.categoryID WHERE postcategory.postID=$postID";
    $result = $db->query($sql);
    while ($row = $result->fetchAll(PDO::FETCH_ASSOC)) {
        return $row;
    }
}

