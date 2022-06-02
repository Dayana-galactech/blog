<?php
class Pages extends Controller {
    public function __construct() {
        //$this->userModel = $this->model('User');
    }

    public function index() {
        $data = [
            'title' => 'home'
        ];

        $this->view('index', $data);
    }
    public function register() {
  
        $this->view('register');
    }
    public function login() {

        $this->view('login');
    }
    public function adminDashboard() {

        $this->view('admin_dashboard');
    } 
    public function userDashboard() {

        $this->view('user_dashboard');
    }       
    public function admin_manageCategories() {

        $this->view('admin_manageCategories');
    }   
    public function admin_managePosts() {

        $this->view('admin_managePosts');
    }
    public function admin_posts() {

        $this->view('admin_posts');
    }    
}