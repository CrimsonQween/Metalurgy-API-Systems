<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once("../../core/initialize.php");

// Create a new instance of the User class
$users = new Users($db);

$page = $_GET['page'] ?? 1;
$limit = $_GET['limit'] ?? 10;
$offset = ($page - 1) * $limit;

$result = $users->read($limit, $offset);
$num = $result->rowCount();

if ($num > 0) {
    $output = ["data" => []];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $output["data"][] = [
            "id" => $id,
            "username" => $username,
            "email" => $email,
            "firstName" => $firstName,
            "lastName" => $lastName,
            "bio" => $bio,
            "profile_picture" => $profile_picture,
            "interests" => $interests,
            "alias" => $alias
        ];
    }
    echo json_encode($output);
} else {
    echo json_encode(["message" => "No users found."]);
}
?>
