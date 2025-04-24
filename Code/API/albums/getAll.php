<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once("../../core/initialize.php");

$album = new Album($db);

$stmt = $album->read();
$num = $stmt->rowCount();

if ($num > 0) {
    $albums_arr = array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $album_item = array(
            "id" => $id,
            "title" => $title,
            "spotify_id" => $spotify_id,
            "release_year" => $release_year,
            "band_id" => $band_id,
            "cover_image" => $cover_image
        );
        array_push($albums_arr, $album_item);
    }

    echo json_encode($albums_arr);
} else {
    echo json_encode(array("message" => "No albums found"));
}
?>
