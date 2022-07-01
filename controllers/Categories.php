<?php

if (session_id() == '') {
    session_start();
}


class Categories extends Controller
{



    public function __construct()
    {
        $this->userModel = $this->model('Category');
    }
 


    public function createCategory()
    {
        $data = [
            'name' => '',
            'userID' => '',
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $csrf = $_SESSION['token'];
            var_dump($csrf);
            var_dump($_SESSION['tokens']);
            if (!empty($_POST['name'])) {
                if (isset($_POST['csrf']) && hash_equals($csrf, $_POST['csrf'])) {
                    $name = htmlspecialchars($_POST['name']);
                    $data = [
                        'name' => $name,
                        'userID' => $_SESSION['user']['userID'],
                    ];
                    if ($this->userModel->createCategory($data)) {
                        echo "created";
                    }else{
                        echo "not created";
                    }
                }else{
                    echo "wrong csrf";
                }
            }else{
                echo "empty name";
            }
        }
        else{
            echo "not post";
        }
    }
    public function updateCategory()
    {
        $data = [
            'userID' => '',
            'name' => '',
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $csrf = $_SESSION['tokens'];
           
            if (!empty($_POST['name'])) {
                if (isset($_POST['csrf']) && hash_equals($csrf, $_POST['csrf'])) {
                    $name = htmlspecialchars($_POST['name']);
                    $categoryID=htmlspecialchars($_POST['categoryID']);
                    $data = [
                        'categoryID'=>$categoryID,
                        'userID' => $_SESSION['user']['userID'],
                        'name' => $name,
                    ];
                    if ($this->userModel->updateCategory($data['categoryID'],$data['userID'],$data['name'])) {
                        echo "updated";
                    }
                }else{
                    echo "wrong csrf";
                }
            }
        }
    }
    public function deleteCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!empty($_POST['categoryID'])) {
                $categoryID=htmlspecialchars($_POST['categoryID']);
                echo $categoryID;
               if($this->userModel->deleteCategory($categoryID)){
                   echo "Category Deleted";
               
               }
            }else{
                echo "empty";
            }
        }else{
            echo "notpost";
        }
    }
}
