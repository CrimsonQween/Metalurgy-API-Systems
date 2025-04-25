<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once("../../core/initialize.php");

$conditions = [];
$params = [];

if (isset($_GET['album_id'])) {
    $conditions[] = "album_id = :album_id";
    $params[':album_id'] = $_GET['album_id'];
}

if (isset($_GET['genre_id'])) {
    $conditions[] = "genre_id = :genre_id";
    $params[':genre_id'] = $_GET['genre_id'];
}

if (isset($_GET['band_id'])) {
    $conditions[] = "band_id = :band_id";
    $params[':band_id'] = $_GET['band_id'];
}

if (empty($conditions)) {
    echo json_encode(["message" => "At least one filter required (album_id, genre_id, or band_id)"]);
    exit;
}

$query = "SELECT * FROM songs WHERE " . implode(" AND ", $conditions);

$stmt = $db->prepare($query);

foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}

$stmt->execute();
$songs = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($songs ?: ["message" => "No songs found"]);
?>
