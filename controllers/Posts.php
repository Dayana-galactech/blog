<?php

if (session_id() == '') {
    session_start();
}
if (isset($_GET['deletepost'])) {
    $del = $_GET['deletepost'];

    $obj->deletePost($del);
}

use Utility\Database;

require_once './utility/Database.php';
class Posts extends Controller
{


    public function __construct()
    {
        $this->userModel = $this->model('Post');
        $this->postcategory = $this->model('postcategory');
        $this->changeone = $this->model('changeone');
        $this->db = new Database;
    }
    public function index()
    {
        $this->view('./admin_managePosts');
    }


    public function createPost()
    {
        $data = [
            'userID' => '',
            'title' => '',
            'image' => '',
            'categoryname' => '',
            'body' => '',
            'published' => '',
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $csrf = $_SESSION['csrf_token'];
            if (!empty($_POST['title']) && !empty($_POST['body']) && !empty($_POST['categoryID'])) {
                if (isset($_POST['csrf']) && hash_equals($csrf, $_POST['csrf'])) {
                    $image = $_FILES['image']['name'];
                    $random = uniqid();
                    if (!empty($image)) {
                        $target = "./images/" . "" . $random . "" . basename($image);
                        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                            $title = htmlspecialchars($_POST['title']);
                            $body = htmlspecialchars($_POST['body']);
                            if (isset($_POST['published'])) {
                                $published = $_POST['published'];
                            } else {
                                $published = 0;
                            }
                            $data = [
                                'userID' => $_SESSION['user']['userID'],
                                'title' => $title,
                                'image' => basename($target),
                                'body' => $body,
                                'published' => $published
                            ];
                            $inserted_post_id = $this->userModel->createPost($data);
                            echo "created";
                            var_dump($inserted_post_id);
                            $data2 = [
                                'postID' => $inserted_post_id,
                                'categoryID' => $_POST['categoryID'],
                            ];
                            $this->postcategory->postcategory($data2['postID'], $data2['categoryID']);
                            header('Location:' . URLROOT);
                        } else {
                            echo "failed to upload image";
                        }
                    } else {
                        echo "image field empty";
                    }
                } else {
                    echo "wrong csrf";
                }
            } else {
                echo "title or body empty";
            }
        } else {
            echo "not post request";
        }
    }

    public function updatePost()
    {
        $data = [
            'userID' => '',
            'title' => '',
            'image' => '',
            'categoryname' => '',
            'body' => '',
            'published' => '',
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $csrf = $_SESSION['csrf_token'];
            if (!empty($_POST['title']) && !empty($_POST['body']) && !empty($_POST['categoryID'])) {
                if (isset($_POST['csrf']) && hash_equals($csrf, $_POST['csrf'])) {
                    $image = $_FILES['image']['name'];
                    if (!empty($image)) {
                        $target = "./images/" . basename($image);
                        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                            $title = htmlspecialchars($_POST['title']);
                            $body = htmlspecialchars($_POST['body']);
                            if (isset($_POST['published'])) {
                                $published = 1;
                                var_dump("sart yes");
                            } else {
                                $published = 0;
                            }
                            $data = [
                                'postID' => $_POST['postID'],
                                'userID' => $_SESSION['user']['userID'],
                                'title' => $title,
                                'image' => $image,
                                'body' => $body,
                                'published' => $published
                            ];
                            $this->userModel->updatePost($data['postID'], $data['userID'], $data['title'], $data['image'], $data['body'], $data['published']);
                            echo "created";
                            $data2 = [
                                'postID' => $_POST['postID'],
                                'categoryID' => $_POST['categoryID'],
                            ];
                            $this->postcategory->updatepostcategory($data2['postID'], $data2['categoryID']);
                        } else {
                            echo "failed to upload image";
                        }
                    } else {
                        echo "image field empty";
                    }
                } else {
                    echo "wrong csrf";
                }
            } else {
                echo "title or body empty";
            }
        } else {
            echo "not post request";
        }
    }

    public function deletePost()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_POST['postID'])) {
                $postID = htmlspecialchars($_POST['postID']);
                echo $postID;
                if ($this->userModel->deletePost($postID)) {
                    echo "Post Deleted";
                }
            } else {
                echo "empty";
            }
        } else {
            echo "notpost";
        }
    }

    public function searchPosts()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_POST['categoryID'])) {
                $categoryID = htmlspecialchars($_POST['categoryID']);
                echo $categoryID;
                $_SESSION['post']['categoryID'] = $categoryID;
                echo $_SESSION['post']['categoryID'];
            } else {
                echo "empty";
            }
        } else {
            echo "notpost";
        }
    }
    public function edit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_POST['postID'])) {
                $postID = htmlspecialchars($_POST['postID']);
                echo $postID;
                $_SESSION['post']['postID'] = $postID;
                echo $_SESSION['post']['postID'];
            } else {
                echo "empty";
            }
        } else {
            echo "notpost";
        }
    }
    public function changeone()
    {
        $data = [
            'post1ID' => '',
            'post2ID' => '',
            'post3ID' => '',
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            var_dump('heeyy');
            if (!empty($_POST['post1ID']) && !empty($_POST['post2ID']) && !empty($_POST['post3ID'])) {
                var_dump($_POST['post1ID']);
                var_dump($_POST['post2ID']);
                var_dump($_POST['post3ID']);
                $data = [
                    'post1ID' => $_POST['post1ID'],
                    'post2ID' => $_POST['post2ID'],
                    'post3ID' => $_POST['post3ID'],
                ];
                $this->changeone->add($data['post1ID'],$data['post2ID'],$data['post3ID']);
                echo "created";
                header('Location:' . URLROOT);
            } else {
                echo "title or body empty";
            }
        } else {
            echo "not post request";
        }
    } 
}
