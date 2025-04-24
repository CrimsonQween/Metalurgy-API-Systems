<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once("../../core/initialize.php");

$song = new Song($db);
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    $song->id = $data->id;

    if ($song->delete()) {
        echo json_encode(["message" => "Song deleted"]);
    } else {
        echo json_encode(["message" => "Delete failed"]);
    }
} else {
    echo json_encode(["message" => "ID required"]);
}
?>
