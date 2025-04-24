<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Authorization, X-Requested-With");

include_once("../../core/initialize.php");

$data = json_decode(file_get_contents("php://input"));

try {
    if (empty($data->band_id) || empty($data->genre_id)) {
        echo json_encode(["message" => "Incomplete data", "error" => "Band ID or Genre ID is missing"]);
        exit();
    }

    $band_check = $db->prepare("SELECT COUNT(*) FROM bands WHERE id = :band_id");
    $band_check->bindParam(":band_id", $data->band_id);
    $band_check->execute();
    
    $genre_check = $db->prepare("SELECT COUNT(*) FROM genres WHERE id = :genre_id");
    $genre_check->bindParam(":genre_id", $data->genre_id);
    $genre_check->execute();

    if ($band_check->fetchColumn() == 0) {
        echo json_encode(["message" => "Band not found", "error" => "The specified band ID does not exist"]);
        exit();
    }
    
    if ($genre_check->fetchColumn() == 0) {
        echo json_encode(["message" => "Genre not found", "error" => "The specified genre ID does not exist"]);
        exit();
    }

    $query = "INSERT IGNORE INTO band_genres (band_id, genre_id) VALUES (:band_id, :genre_id)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":band_id", $data->band_id, PDO::PARAM_INT);
    $stmt->bindParam(":genre_id", $data->genre_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Genre successfully attached to the band"]);
    } else {
        echo json_encode(["message" => "Failed to attach genre", "error" => "Database query execution failed"]);
    }
} catch (PDOException $e) {
    echo json_encode(["message" => "Database error", "error" => $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(["message" => "An error occurred", "error" => $e->getMessage()]);
}
?>
