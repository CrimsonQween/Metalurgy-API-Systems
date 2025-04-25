<?php

include_once("../../Core/initialize.php"); 

$client_id = "86219762966343f7a26927cf1a126d81";
$client_secret = "22896849e85243d89c8359f9a8981142";

$access_token = getSpotifyAccessToken($client_id, $client_secret); 

$access_token = getSpotifyAccessToken($client_id, $client_secret);

if (!$access_token) {
    echo json_encode(["error" => "Failed to authenticate with Spotify"]);
    exit;
}

$album_spotify_id = $_GET['album_spotify_id'] ?? '';

if (empty($album_spotify_id)) {
    echo json_encode(["error" => "Missing 'album_spotify_id' parameter"]);
    exit;
}

function fetchTracksFromAlbum($album_spotify_id, $access_token) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/albums/{$album_spotify_id}/tracks");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $access_token"
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

function getAlbumId($spotify_id, $db) {
    $stmt = $db->prepare("SELECT id, band_id FROM albums WHERE spotify_id = :spotify_id");
    $stmt->bindParam(":spotify_id", $spotify_id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function saveTrackToDatabase($db, $album_id, $band_id, $title, $duration, $spotify_id, $track_number, $spotify_url) {
    $stmt = $db->prepare("INSERT INTO songs (album_id, band_id, title, duration, spotify_id, track_number, spotify_url) 
                            VALUES (:album_id, :band_id, :title, :duration, :spotify_id, :track_number, :spotify_url)");
    $stmt->bindParam(":album_id", $album_id);
    $stmt->bindParam(":band_id", $band_id);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":duration", $duration);
    $stmt->bindParam(":spotify_id", $spotify_id);
    $stmt->bindParam(":track_number", $track_number);
    $stmt->bindParam(":spotify_url", $spotify_url);
    return $stmt->execute();
}

// Fetch album ID + band ID from your database
$albumData = getAlbumId($album_spotify_id, $db);

if (!$albumData) {
    echo json_encode(["error" => "Album not found in your database"]);
    exit;
}

$tracks = fetchTracksFromAlbum($album_spotify_id, $access_token);

if (!isset($tracks['items'])) {
    echo json_encode(["error" => "No tracks found"]);
    exit;
}

$inserted = [];

foreach ($tracks['items'] as $track) {
    $title = $track['name'];
    $duration = $track['duration_ms'];
    $spotify_id = $track['id'];
    $track_number = $track['track_number'];
    $spotify_url = $track['external_urls']['spotify'];

    if (saveTrackToDatabase($db, $albumData['id'], $albumData['band_id'], $title, $duration, $spotify_id, $track_number, $spotify_url)) {
        $inserted[] = $title;
    }
}

echo json_encode([
    "message" => "Tracks saved",
    "saved_tracks" => $inserted
]);
?>