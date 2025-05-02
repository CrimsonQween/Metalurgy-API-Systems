<?php

include_once("../../core/initialize.php");

$api_key_lastfm = '223fe2ea7fdb302d649ebec2a63d4f74';
$query = $_GET['query'] ?? '';  

if (empty($query)) {
    echo json_encode(["error" => "Missing 'query' parameter"]);
    exit;
}

// Fetch genres from Last.fm
$lastfm_data = fetchGenresFromLastFM($api_key_lastfm, $query);
$musicbrainz_data = fetchGenresFromMusicBrainz($query);

// Save genres and subgenres to the database
if (isset($lastfm_data['toptags']['tag']) && !empty($lastfm_data['toptags']['tag'])) {
    foreach ($lastfm_data['toptags']['tag'] as $genre) {
        $name = $genre['name'];
        $description = $genre['url']; 
        saveGenreToDatabase($db, $name, $description);
    }
}

if (isset($musicbrainz_data['genres']) && !empty($musicbrainz_data['genres'])) {
    foreach ($musicbrainz_data['genres'] as $genre) {
        $name = $genre['name'];
        $description = $genre['id']; 
        saveGenreToDatabase($db, $name, $description);
    }
}

echo json_encode(["message" => "Genres saved successfully."]);

?>
