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

//user query
// $result=$user->read();

// get row count 
echo json_encode($user->read()->fetchAll(PDO::FETCH_ASSOC),JSON_PRETTY_PRINT);
