<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PUT");

include_once("../../core/initialize.php");

$band = new Bands($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id) && !empty($data->name) && !empty($data->origin)) {
    $band->id = $data->id;
    $band->name = $data->name;
    $band->origin = $data->origin;
    $band->year_formed = $data->year_formed ?? null;
    $band->spotify_id = $data->spotify_id ?? null;
    $band->image_url = $data->image_url ?? null;

    if ($band->update()) {
        echo json_encode(["message" => "Band updated successfully"]);
    } else {
        echo json_encode(["message" => "Failed to update band"]);
    }
} else {
    echo json_encode(["message" => "Missing required fields"]);
}
?>
