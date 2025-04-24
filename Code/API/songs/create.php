<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once("../../core/initialize.php");

$song = new Song($db);
$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->title) &&
    !empty($data->duration) &&
    !empty($data->spotify_id) &&
    !empty($data->album_id)
) {
    $song->title = $data->title;
    $song->duration = $data->duration;
    $song->spotify_id = $data->spotify_id;
    $song->album_id = $data->album_id;
    $song->track_number = $data->track_number ?? null;

    if ($song->create()) {
        echo json_encode(["message" => "Song created"]);
    } else {
        echo json_encode(["message" => "Song creation failed"]);
    }
} else {
    echo json_encode(["message" => "Incomplete data"]);
}
?>
