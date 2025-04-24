<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: DELETE");

include_once("../../core/initialize.php");

$band = new Bands($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    $band->id = $data->id;

    if ($band->delete()) {
        echo json_encode(["message" => "Band deleted successfully"]);
    } else {
        echo json_encode(["message" => "Failed to delete band"]);
    }
} else {
    echo json_encode(["message" => "Incomplete data. Please provide a valid band id"]);
}
?>
