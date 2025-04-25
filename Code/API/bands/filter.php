<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once("../../core/initialize.php");

if (!isset($_GET['genre_id'])) {
    echo json_encode(["message" => "Missing genre_id"]);
    exit;
}

$genre_id = $_GET['genre_id'];

$query = "SELECT b.* 
            FROM bands b
            JOIN band_genres bg ON b.id = bg.band_id
            WHERE bg.genre_id = :genre_id";

$stmt = $db->prepare($query);
$stmt->bindParam(":genre_id", $genre_id);
$stmt->execute();

$bands = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($bands) {
    echo json_encode($bands);
} else {
    echo json_encode(["message" => "No bands found for that genre"]);
}
?>
