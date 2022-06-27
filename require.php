<?php
//Require libraries from folder libraries
require_once './globals.php';
require_once './utility/core.php';
require_once './utility/controller.php';
require_once './utility/Database.php';
require_once './models/BaseModel.php';
require_once './models/User.php';
require_once './models/Category.php';
require_once './models/Comment.php';
require_once('./controllers/get.php');
define('URLROOT', 'https://dayana.galactech.cloud');
//Instantiate core class
$init = new Core();
