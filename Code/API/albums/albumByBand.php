<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once("../../core/initialize.php");

$album = new Album($db);

$band_id = isset($_GET['band_id']) ? $_GET['band_id'] : die(json_encode(["message" => "Band ID is required"]));

$query = "SELECT * FROM albums WHERE band_id = :band_id";
$stmt = $db->prepare($query);
$stmt->bindParam(":band_id", $band_id, PDO::PARAM_INT);
$stmt->execute();

$albums = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $albums[] = [
        "id" => $id,
        "title" => $title,
        "spotify_id" => $spotify_id,
        "release_year" => $release_year,
        "band_id" => $band_id,
        "cover_image" => $cover_image,
        "spotify_url" => $spotify_url,
        "track_count" => $track_counts
    ];
}

if (!empty($albums)) {
    echo json_encode($albums);
} else {
    echo json_encode(["message" => "No albums found for this band"]);
}
?>
