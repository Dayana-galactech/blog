<?php

if (session_id() == '') {
    session_start();
}

use Utility\Database;

require_once './utility/Database.php';
class Comments extends Controller
{


    public function __construct()
    {
        $this->userModel = $this->model('Comment');
        $this->postcomment = $this->model('postcomment');
        $this->db = new Database;
    }

    public function cc()
    {
        $data = [
            'userID' => '',
            'postID' => '',
            'body' => '',

        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $csrf = $_SESSION['tokens'];
           
            if (!empty($_POST['body']) && !empty($_POST['postID'])) {

                if (isset($_POST['csrf']) && hash_equals($csrf, $_POST['csrf'])) {

                    $body = htmlspecialchars($_POST['body']);
                    $data = [
                        'userID' => $_SESSION['user']['userID'],
                        'postID' => $_POST['postID'],
                        'body' => $body,
                        
                    ];
                    $inserted_comment_id = $this->userModel->createComment($data);
                    echo "Comment created";
                    $data2 = [
                        'commentID' => $inserted_comment_id,
                        'postID' => $_POST['postID'],
                    ];
                    $this->postcomment->postcomment($data2['postID'],$data2['commentID']);
               
                } else {
                    echo "wrong csrf";
                }
            } else {
                echo "Empty Comment";
            }
        } else {
            echo "not post request";
        }
    }


    public function deleteComment()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_POST['commentID'])) {
                $commentID = htmlspecialchars($_POST['commentID']);
                echo $commentID;
                if ($this->userModel->deletePost($commentID)) {
                    echo "Comment Deleted";
                }
            } else {
                echo "empty";
            }
        } else {
            echo "not post request";
        }
    }
}
