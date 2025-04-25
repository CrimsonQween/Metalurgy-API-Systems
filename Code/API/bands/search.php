<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once("../../core/initialize.php");

if (!isset($_GET['name'])) {
    echo json_encode(["message" => "Missing band name"]);
    exit;
}

$name = "%" . $_GET['name'] . "%";

$query = "SELECT * FROM bands WHERE name LIKE :name";
$stmt = $db->prepare($query);
$stmt->bindParam(":name", $name);
$stmt->execute();

$bands = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($bands) {
    echo json_encode($bands);
} else {
    echo json_encode(["message" => "No bands found"]);
}
?>
