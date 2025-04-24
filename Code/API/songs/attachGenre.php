<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Authorization, X-Requested-With");

include_once("../../core/initialize.php");

$data = json_decode(file_get_contents("php://input"));

try {
    if (empty($data->song_id) || empty($data->genre_id)) {
        echo json_encode(["message" => "Incomplete data", "error" => "Song ID or Genre ID is missing"]);
        exit();
    }

    $song_check = $db->prepare("SELECT COUNT(*) FROM songs WHERE id = :song_id");
    $song_check->bindParam(":song_id", $data->song_id);
    $song_check->execute();
    
    $genre_check = $db->prepare("SELECT COUNT(*) FROM genres WHERE id = :genre_id");
    $genre_check->bindParam(":genre_id", $data->genre_id);
    $genre_check->execute();

    if ($song_check->fetchColumn() == 0) {
        echo json_encode(["message" => "Song not found", "error" => "The specified song ID does not exist"]);
        exit();
    }
    
    if ($genre_check->fetchColumn() == 0) {
        echo json_encode(["message" => "Genre not found", "error" => "The specified genre ID does not exist"]);
        exit();
    }

    $query = "INSERT IGNORE INTO song_genres (song_id, genre_id) VALUES (:song_id, :genre_id)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":song_id", $data->song_id, PDO::PARAM_INT);
    $stmt->bindParam(":genre_id", $data->genre_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Genre successfully attached to the song"]);
    } else {
        echo json_encode(["message" => "Failed to attach genre", "error" => "Database query execution failed"]);
    }
} catch (PDOException $e) {
    echo json_encode(["message" => "Database error", "error" => $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(["message" => "An error occurred", "error" => $e->getMessage()]);
}
?>
