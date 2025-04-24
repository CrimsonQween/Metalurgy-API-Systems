<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");

include_once("../../core/initialize.php");

$band = new Bands($db);

$band->id = $_GET['id'] ?? null;

if ($band->id) {
    $result = $band->read_single();

    if ($result) {
        echo json_encode($result);
    } else {
        echo json_encode(["message" => "Band not found"]);
    }
} else {
    echo json_encode(["message" => "Invalid band ID"]);
}
?>
