<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods,Authorization, X-Requested-Width");

include_once("../../core/initialize.php");

$query = isset($GET['query']) ? "%".$_GET['query']."%" : die(json_encode(["message" => "No search query provided"]));

$stmt = $db->prepare("SELECT id, username, firstName, lastName FROM users WHERE username LIKE ? OR firstName LIKE ? OR lastName LIKE ?");
$stmt->execute([$query, $query, $query]);

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode(["data" => $results]);

?>