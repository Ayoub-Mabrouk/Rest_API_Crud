<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

use Firebase\JWT\JWT;
require_once "../../vendor/autoload.php";
$data = json_decode(file_get_contents("php://input"));
$key = "exampl_key";
try {
    $decoded = JWT::decode($data->token, $key, array('HS256'));
    exit(json_encode($decoded, JSON_PRETTY_PRINT));
} catch (\Throwable $th) {
    echo $th->getMessage();
}