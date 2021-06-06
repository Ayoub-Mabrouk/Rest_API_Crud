<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

use Firebase\JWT\JWT;
require_once "../../vendor/autoload.php";
$data = json_decode(file_get_contents("php://input"));
$key = "exampl_key";
$payload = array(
    "iat" => time(),
    "exp" => time()+(3), //add 2 hours to time
    "name"=>"ayoub",
    "age"=>"25"
);
$jwt = JWT::encode($payload, $key);
echo $jwt;



