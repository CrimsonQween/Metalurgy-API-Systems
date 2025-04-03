<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

include_once("../../core/initialize.php");

// Create a new instance of the User class
$users = new Users($db);

// Get pagination parameters from the request (optional)
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
$offset = ($page - 1) * $limit;

try {
    // Fetch all users with pagination
    $result = $users->read($limit, $offset);
    $num = $result->rowCount();

    if ($num > 0) {
        $users_list = array();
        $users_list['data'] = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $user_item = array(
                "id" => $id,
                "username" => $username,
                "email" => $email,
                "firstName" => $firstName, 
                "lastName" => $lastName   
            );

            array_push($users_list['data'], $user_item);
        }

        echo json_encode($users_list);
    } else {
        echo json_encode(array("message" => "No Users Found"));
    }
} catch (Exception $e) {
    echo json_encode(array("message" => "Error: " . $e->getMessage()));
}

?>
