<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once("../../core/initialize.php");

$genre = new Genre($db);
$result = $genre->read();

$genres = [];
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $genres[] = $row;
}

echo json_encode($genres);
