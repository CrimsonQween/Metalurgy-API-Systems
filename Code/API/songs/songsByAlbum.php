<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once("../../core/initialize.php");

$album_id = isset($_GET['album_id']) ? $_GET['album_id'] : die(json_encode(["message" => "Album ID is required"]));

$query = "SELECT * FROM songs WHERE album_id = :album_id ORDER BY track_number ASC";
$stmt = $db->prepare($query);
$stmt->bindParam(":album_id", $album_id, PDO::PARAM_INT);
$stmt->execute();

$songs = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $songs[] = [
        "id" => $id,
        "title" => $title,
        "duration" => $duration,
        "spotify_id" => $spotify_id,
        "album_id" => $album_id,
        "track_number" => $track_number
    ];
}

if (!empty($songs)) {
    echo json_encode($songs);
} else {
    echo json_encode(["message" => "No songs found for this album"]);
}
?>
