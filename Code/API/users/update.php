<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once("../../core/initialize.php");

$users = new Users($db);

$data = json_decode(file_get_contents("php://input"));

$users->id = $data->id;
$users->username = $data->username;
$users->email = $data->email;
$users->password = $data->password;
$users->firstName = $data->firstName;
$users->lastName = $data->lastName;
$users->bio = $data->bio ?? '';
$users->profile_picture = $data->profile_picture ?? '';
$users->interests = $data->interests ?? '';
$users->alias = $data->alias ?? '';

if($users->update()){
    echo json_encode(array('message'=> 'User Updated'));
}
else{
    echo json_encode(array('message'=> 'User NOT Updated'));
}

?>
