<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods,Authorization, X-Requested-Width");

include_once("../../core/initialize.php");

$users = new Users($db);
$id = isset($_GET['id']) ? $_GET['id'] : die(json_encode(["message" => "No User ID provided"]));

$stmt = $db->prepare("SELECT id, username, email, firstName, lastName, alias, bio, profile_picture, interests FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo json_encode($user);
} else {
    echo json_encode(["message" => "User not found"]);
}

?>