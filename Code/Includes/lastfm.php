<?php

function fetchGenresFromLastFM($query, $api_key) {
    $url = "http://ws.audioscrobbler.com/2.0/?method=tag.getTopTags&api_key=" . $api_key . "&format=json";
    
    // Initialize cURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

// Save genre to the database
function saveGenreToDatabase($db, $name, $description = null) {
    $query = "INSERT IGNORE INTO genres (name, description) VALUES (:name, :description)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    return $stmt->execute();
}

// Save subgenre to the database
function saveSubgenreToDatabase($db, $genre_id, $name, $description = null) {
    $query = "INSERT IGNORE INTO subgenres (genre_id, name, description) VALUES (:genre_id, :name, :description)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':genre_id', $genre_id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    return $stmt->execute();
}

// Link genre to a band in the database
function linkGenreToBand($db, $band_id, $genre_id) {
    $query = "INSERT INTO band_genres (band_id, genre_id) VALUES (:band_id, :genre_id)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':band_id', $band_id);
    $stmt->bindParam(':genre_id', $genre_id);
    return $stmt->execute();
}

// Get genre ID by name
function getGenreIdByName($db, $name) {
    $query = "SELECT id FROM genres WHERE name = :name LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->execute();
    $row = $stmt->fetch();
    return $row ? $row['id'] : null;
}

function fetchArtistGenresFromLastFM($artist, $api_key) {
    $url = "http://ws.audioscrobbler.com/2.0/?method=artist.getTopTags&artist=" . urlencode($artist) . "&api_key=" . $api_key . "&format=json";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

function linkGenreToSong($db, $song_id, $genre_id) {
    $query = "INSERT IGNORE INTO song_genres (song_id, genre_id) VALUES (:song_id, :genre_id)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':song_id', $song_id);
    $stmt->bindParam(':genre_id', $genre_id);
    return $stmt->execute();
}

?>
