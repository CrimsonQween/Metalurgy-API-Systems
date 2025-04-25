<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once("../../core/initialize.php");

if (!isset($_GET['band_id'])) {
    echo json_encode(["message" => "Missing band_id"]);
    exit;
}

$band_id = $_GET['band_id'];

$query = "SELECT * FROM albums WHERE band_id = :band_id";
$stmt = $db->prepare($query);
$stmt->bindParam(":band_id", $band_id);
$stmt->execute();

$albums = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($albums) {
    echo json_encode($albums);
} else {
    echo json_encode(["message" => "No albums found for that band"]);
}
?>
