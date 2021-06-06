<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include_once '../../config/Database.php';
include_once '../../models/User.php';

//instantiate Db & connect
$database= new Database();

//instantiate user object
$user = new User($database->connect());

//get id
$user->id = isset($_GET['id']) ? $_GET['id']:die();

//get user
$user->read_single();
exit(json_encode(array_slice((array)$user,2),JSON_PRETTY_PRINT));

// use Firebase\JWT\JWT;
// require_once "../../vendor/autoload.php";
// $data = json_decode(file_get_contents("php://input"));
// $key = "exampl_key";
// $payload = array(
//     "iat" => time(),
//     "exp" => time()+30,
//     "name"=>"ayoub",
//     "age"=>"25"
// );

// $jwt = JWT::encode($payload, $key);
// echo $jwt;
