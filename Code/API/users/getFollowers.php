<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once("../../core/initialize.php");

$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : 0;

$query = "
    SELECT u.id, u.username, u.firstName, u.lastName
    FROM follows f
    JOIN users u ON f.follower_id = u.id
    WHERE f.followed_id = :user_id
";

$stmt = $db->prepare($query);
$stmt->bindParam(":user_id", $user_id);
$stmt->execute();

$followers = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(["followers" => $followers]);
?>
