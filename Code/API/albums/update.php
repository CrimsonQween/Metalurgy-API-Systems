<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once("../../core/initialize.php");

$album = new Album($db);
$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->id) &&
    !empty($data->title) &&
    !empty($data->spotify_id) &&
    !empty($data->release_year) &&
    !empty($data->band_id) &&
    !empty($data->cover_image)
) {
    $album->id = $data->id;
    $album->title = $data->title;
    $album->spotify_id = $data->spotify_id;
    $album->release_year = $data->release_year;
    $album->band_id = $data->band_id;
    $album->cover_image = $data->cover_image;

    if ($album->update()) {
        echo json_encode(array("message" => "Album updated successfully"));
    } else {
        echo json_encode(array("message" => "Failed to update album"));
    }
} else {
    echo json_encode(array("message" => "Incomplete data"));
}
?>
