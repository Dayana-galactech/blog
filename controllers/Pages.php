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
    public function userDashboard() {

        $this->view('user_dashboard');
    }       
    public function ManageCategories() {

        $this->view('ManageCategories');
    }   
    public function ManagePosts() {

        $this->view('ManagePosts');
    }
    public function admin_posts() {

        $this->view('admin_posts');
    }  
    public function categories() {

        $this->view('categories');
    }   
    public function posts() {

        $this->view('posts');
      
    }   
    public function yourArticles() {

        $this->view('yourArticles');
      
    }   
    public function createPost() {

        $this->view('createPost');
      
    }  
    public function edit() {

        $this->view('edit');
      
    } 
}