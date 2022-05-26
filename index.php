<?php

// require_once './utility/Database.php';
// require_once './models/BaseModel.php';
// require_once './models/Employee.php';
// require_once './controllers/EmployeeController.php';


// require_once './utility/core.php';
// require_once './utility/controller.php';

// // make sure this is the last file to require:
// require_once './config/routes.php';



// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//   $url = trim($_GET['url']);
//   $requestMethod = $_SERVER["REQUEST_METHOD"];

//   if (!URLRouter::isValid($requestMethod, $url)) {
//     echo json_encode(['status' => 'error', 'code' => '404']);
//     return;
//   }

//   $response = URLRouter::execute($requestMethod, $url);

//   if (is_array($response)) {
//     header("Content-Type: application/json");
//     echo json_encode($response);
//   } else {
//     header("Content-Type: text/html");
//     require_once $response;
//   }


    require_once 'require.php';
