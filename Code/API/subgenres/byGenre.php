<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once("../../core/initialize.php");

if (!isset($_GET['genre_id'])) {
    echo json_encode(["message" => "genre_id is required"]);
    exit;
}

$sub = new Subgenre($db);
$result = $sub->readByGenre($_GET['genre_id']);

$subgenres = [];
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $subgenres[] = $row;
}

echo json_encode($subgenres);
