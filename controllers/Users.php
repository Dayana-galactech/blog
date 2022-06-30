<?php

if (session_id() == '') {
    session_start();
}
class Users extends Controller
{

    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function register()
    {
        $data = [
            'username' => '',
            'email' => '',
            'password' => '',
            'type' => '',
        ];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo "inside post";
            $csrf = $_SESSION['csrf_token'];
            if (!empty($_POST['username']) && !empty($_POST['email'])  && !empty($_POST['password'])) {
                if (isset($_POST['csrf']) && hash_equals($csrf, $_POST['csrf'])) {
                    $username = htmlspecialchars($_POST['username']);
                    $email = htmlspecialchars($_POST['email']);
                    $password = htmlspecialchars($_POST['password']);
                    $type = 'Author';
                    $data = [
                        'username' => $username,
                        'email' => $email,
                        'password' => $password,
                        'type' => $type
                    ];

                    // Hash password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    //Register user from model function
                    if ($this->userModel->register($data)) {
                        $userID = $this->userModel->getID($data['email']);
                        $_SESSION['user'] = array(
                            "email" => $data['email'],
                            "username" => $data['username'],
                            "type" => "$type",
                            "userID" => "$userID",
                        );
                        header('location:' . URLROOT);
                    } else {
                        echo 'Something went wrong.';
                    }
                } else {
                    echo "csrf not valid";
                }
            } else {
                http_response_code(400);
                echo "Some fields are empty!";
            }
        } else {
            $this->view('/register', $data);
        }
    }

    public function login()
    {

        $data = [
            'email' => '',
            'password' => '',
        ];

        //Check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo"in post" ;
            var_dump("in post");
            $csrf = $_SESSION['csrf_token'];
            if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['csrf'])) {

                if (hash_equals($csrf, $_POST['csrf'])) {
                    $email = htmlspecialchars($_POST['email']);
                    $password = htmlspecialchars($_POST['password']);

                    $data = [
                        'email' => $email,
                        'password' => $password,
                    ];

                    $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                    echo $loggedInUser." , okay";
                    if ($loggedInUser) {
                        echo "inside loggedinuser";
                        $this->createUserSession($loggedInUser);
                    } else {
                        echo 'Password or email is incorrect. Please try again.';

                        $this->view('/login', $data);
                    }
                }
            }
        } else {
            // $data = [
            //     'email' => '',
            //     'password' => '',
            // ];
            echo "not post";
        }
        $this->view('/login', $data);
    }

    public function createUserSession($user)
    {

        $userID = $this->userModel->getID($user->email);
        $_SESSION['user'] = array(
            "email" => $user->email,
            "username" => $user->username,
            "type" => $user->type,
            "userID" => "$userID",
        );
       echo $_SESSION['user']['type'];
        header('location:' . URLROOT);
    }

    public function logout()
    {
        unset($_SESSION['user']['username']);
        unset($_SESSION['']['email']);
        if (isset($_COOKIE[session_name()])) :
            setcookie(session_name(), '', time() - 7000000, '/');
        endif;
        session_destroy();
        header('location:' . URLROOT . '/?url=/users/login');
    }
}
