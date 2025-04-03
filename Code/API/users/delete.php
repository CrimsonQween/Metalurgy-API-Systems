<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once("../../core/initialize.php");

$users = new Users($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)){
    $users->id = $data->id;

    if($users->delete()){
        echo json_encode(array("message" => "User deleted successfully"));
    } else {
        echo json_encode(array("message" => "User deletion failed. User not found"));
    }
} else {
    echo json_encode(array("message" => "Incomplete data. Please provide a valid user id"));
}
?>