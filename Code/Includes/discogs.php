<?php

function fetchGenresFromDiscogs($query, $token) {
    $url = "https://api.discogs.com/database/search?q=" . urlencode($query) . "&token=" . $token;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

function saveGenreToDatabase($db, $name, $description = null) {
    $query = "INSERT IGNORE INTO genres (name, description) VALUES (:name, :description)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    return $stmt->execute();
}

function saveSubgenreToDatabase($db, $genre_id, $name, $description = null) {
    $query = "INSERT IGNORE INTO subgenres (genre_id, name, description) VALUES (:genre_id, :name, :description)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':genre_id', $genre_id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    return $stmt->execute();
}

function getGenreIdByName($db, $name) {
    $query = "SELECT id FROM genres WHERE name = :name LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->execute();
    $row = $stmt->fetch();
    return $row ? $row['id'] : null;
}

?>