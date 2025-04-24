<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");

include_once("../../core/initialize.php");

$data = json_decode(file_get_contents("php://input"));

$genre = new Genre($db);
$genre->name = $data->name;
$genre->description = $data->description;

if ($genre->create()) {
    echo json_encode(["message" => "Genre created successfully"]);
} else {
    echo json_encode(["message" => "Failed to create genre"]);
}
