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
    $sql = "SELECT users.username, posts.title, posts.postID, posts.createdAt, posts.published, posts.body FROM users INNER JOIN posts ON users.userID=posts.userID AND posts.published='1'  ";
    $result = $db->query($sql);
    while ($row = $result->fetchAll(PDO::FETCH_ASSOC)) {    
        return $row;
    }
}
function getAllPost()
{
    $database = new Database();
    $db = $database->getConnection();
    $sql = "SELECT users.username, posts.title, posts.postID, posts.createdAt, posts.published, posts.body FROM users INNER JOIN posts ON users.userID=posts.userID ";
    $result = $db->query($sql);
    while ($row = $result->fetchAll(PDO::FETCH_ASSOC)) {    
        return $row;
    }
}

function getPostByID($postID)
{
    
    $database = new Database();
    $db = $database->getConnection();
    $sql = "SELECT users.username, posts.title, posts.postID, posts.createdAt, posts.published, posts.body, posts.image FROM users INNER JOIN posts ON users.userID=posts.userID WHERE posts.postID=$postID  AND posts.published='1' ";
    $result = $db->query($sql);
    while ($row = $result->fetchAll(PDO::FETCH_ASSOC)) {    
        return $row;
    }
}

function getCategoryByID($categoryID)
{
    
    $database = new Database();
    $db = $database->getConnection();
    $sql = "SELECT users.username, category.name FROM users INNER JOIN category ON users.userID=category.userID WHERE category.categoryID=$categoryID LIMIT 1 ";
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
function getPostByYou($userID)
{
    
    $database = new Database();
    $db = $database->getConnection();
    $sql = "SELECT users.username, posts.title, posts.postID, posts.body, posts.createdAt, posts.published, posts.image FROM users INNER JOIN posts ON users.userID=posts.userID WHERE posts.userID=$userID";
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
function getPostByCategory($categoryID){
    $database = new Database();
    $db = $database->getConnection();
    $sql="SELECT posts.title, posts.postID, posts.createdAt, posts.published, posts.body, posts.image From postcategory INNER JOIN posts ON posts.postID=postcategory.postID WHERE postcategory.categoryID=$categoryID AND posts.published='1' ";
    $result = $db->query($sql);
    while ($row = $result->fetchAll(PDO::FETCH_ASSOC)) {
        return $row;
    }
}
function getComments($postID){
    $database = new Database();
    $db = $database->getConnection();
    $sql="SELECT comments.body, users.username FROM comments INNER JOIN users ON comments.userID=users.userID WHERE postID=$postID";
    $result = $db->query($sql);
    while ($row = $result->fetchAll(PDO::FETCH_ASSOC)) {
        return $row;
    }
}

function changeone()
{
    $database = new Database();
    $db = $database->getConnection();
    $sql = "SELECT postID FROM card1 ";
    $result = $db->query($sql);
    while ($row = $result->fetchAll(PDO::FETCH_ASSOC)) {    
        return $row;
    }
}

function changetwo()
{
    $database = new Database();
    $db = $database->getConnection();
    $sql = "SELECT postID FROM card2 ";
    $result = $db->query($sql);
    while ($row = $result->fetchAll(PDO::FETCH_ASSOC)) {    
        return $row;
    }
}

function changethree()
{
    $database = new Database();
    $db = $database->getConnection();
    $sql = "SELECT postID FROM card3 ";
    $result = $db->query($sql);
    while ($row = $result->fetchAll(PDO::FETCH_ASSOC)) {    
        return $row;
    }
}