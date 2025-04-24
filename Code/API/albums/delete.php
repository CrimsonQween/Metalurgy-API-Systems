<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once("../../core/initialize.php");

$album = new Album($db);
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    $album->id = $data->id;
    
    if ($album->delete()) {
        echo json_encode(array("message" => "Album deleted successfully"));
    } else {
        echo json_encode(array("message" => "Failed to delete album"));
    }
} else {
    echo json_encode(array("message" => "Incomplete data"));
}
?>
