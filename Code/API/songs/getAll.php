<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once("../../core/initialize.php");

$song = new Song($db);
$stmt = $song->read();

$songs = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $songs[] = [
        "id" => $id,
        "title" => $title,
        "duration" => $duration,
        "spotify_id" => $spotify_id,
        "album_id" => $album_id,
        "track_number" => $track_number,
        "spotify_url" => $spotify_url
    ];
}
echo json_encode($songs);
?>
