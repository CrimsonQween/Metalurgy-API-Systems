<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods,Authorization, X-Requested-Width");

include_once("../../core/initialize.php");

$users = new Users($db);

//read submitted json data from request
$data = json_decode(file_get_contents("php://input"));

//Fill the user properties with decoded values
$users->username = $data->username;
$users->email = $data->email;
$users->password = $data->password;
$users->firstName = $data->firstName;
$users->lastName = $data->lastName;
$users->bio = $data->bio ?? '';
$users->profile_picture = $data->profile_picture ?? '';
$users->interests = $data->interests ?? '';
$users->alias = $data->alias ?? '';

$result = $users->create();

if ($result === true) {
    echo json_encode(["message" => "User created."]);
} elseif ($result === "exists") {
    echo json_encode(["message" => "Username or email already exists."]);
} else {
    echo json_encode(["message" => "User not created."]);
}

?>
