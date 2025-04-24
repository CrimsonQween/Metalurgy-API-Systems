<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");

include_once("../../core/initialize.php");

$band = new Bands($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->name) && !empty($data->origin) && !empty($data->year_formed)) {
    $band->name = $data->name;
    $band->origin = $data->origin;
    $band->year_formed = $data->year_formed;
    $band->spotify_id = $data->spotify_id ?? null;
    $band->image_url = $data->image_url ?? null;

    if ($band->create()) {
        echo json_encode(["message" => "Band created successfully"]);
    } else {
        echo json_encode(["message" => "Failed to create band"]);
    }
} else {
    echo json_encode(["message" => "Missing required fields"]);
}

?>
