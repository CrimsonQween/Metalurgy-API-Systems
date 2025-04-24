<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");

include_once("../../core/initialize.php");

$data = json_decode(file_get_contents("php://input"));

$sub = new Subgenre($db);
$sub->name = $data->name;
$sub->description = $data->description;
$sub->genre_id = $data->genre_id;

if ($sub->create()) {
    echo json_encode(["message" => "Subgenre created successfully"]);
} else {
    echo json_encode(["message" => "Failed to create subgenre"]);
}
