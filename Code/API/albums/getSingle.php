<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once("../../core/initialize.php");

$album = new Album($db);

if (isset($_GET['id'])) {
    $album->id = $_GET['id'];
    
    $stmt = $album->read_single();
    $num = $stmt->rowCount();
    
    if ($num > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
        $album_item = array(
            "id" => $id,
            "title" => $title,
            "spotify_id" => $spotify_id,
            "release_year" => $release_year,
            "band_id" => $band_id,
            "cover_image" => $cover_image,
            "spotify_url" => $spotify_url,
            "track_count" => $track_count
        );

        echo json_encode($album_item);
    } else {
        echo json_encode(array("message" => "Album not found"));
    }
} else {
    echo json_encode(array("message" => "Incomplete data"));
}
?>
