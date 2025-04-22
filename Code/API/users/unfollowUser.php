<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type");

include_once("../../core/initialize.php");

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->follower_id) && !empty($data->followed_id)) {
    $query = "DELETE FROM follows WHERE follower_id = :follower_id AND followed_id = :followed_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":follower_id", $data->follower_id);
    $stmt->bindParam(":followed_id", $data->followed_id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Unfollowed successfully"]);
    } else {
        echo json_encode(["message" => "Unfollow failed"]);
    }
} else {
    echo json_encode(["message" => "Invalid input"]);
}
?>
