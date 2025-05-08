<?php

include_once("../../core/initialize.php");

$api_key = $lastfm_api_key;

// Set header to JSON (optional but good practice)
header('Content-Type: application/json');

// Fetch all songs with their band names
$query = "
    SELECT songs.id AS song_id, songs.title AS song_title, bands.name AS band_name
    FROM songs
    INNER JOIN bands ON songs.band_id = bands.id
";
$stmt = $db->prepare($query);
$stmt->execute();
$songs = $stmt->fetchAll();

$result_log = [];

foreach ($songs as $song) {
    $song_id = $song['song_id'];
    $band_name = $song['band_name'];
    $song_title = $song['song_title'];

    // Fetch genres for this band from Last.fm
    $genreData = fetchArtistGenresFromLastFM($band_name, $api_key);

    if (isset($genreData['toptags']['tag']) && !empty($genreData['toptags']['tag'])) {
        foreach ($genreData['toptags']['tag'] as $tag) {
            $genre_name = $tag['name'] ?? null;

            if ($genre_name) {
                saveGenreToDatabase($db, $genre_name, 'Auto-fetched for song');

                $genre_id = getGenreIdByName($db, $genre_name);
                if ($genre_id) {
                    linkGenreToSong($db, $song_id, $genre_id);
                }
            }
        }

        $result_log[] = "Linked genres to song: $song_title by $band_name";
    } else {
        $result_log[] = "No genres found for: $song_title by $band_name";
    }
}

// JSON response
echo json_encode([
    "status" => "done",
    "messages" => $result_log
]);


?>