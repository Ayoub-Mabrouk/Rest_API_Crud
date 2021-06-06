<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/User.php';

//instantiate Db & connect
$database = new Database();

//instantiate user object
$user = new User($database->connect());

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

$user->name=preg_replace("/[^a-zA-Z]+/","", $data->name);
$user->id_address=preg_replace("/[^0-9]/","", $data->id_address);
$user->id=preg_replace("/[^0-9]/","", $data->id);

if($user->update()){
    echo json_encode(
        array('message'=>'User Updated')
    );
}