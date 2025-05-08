<?php

include_once("../../core/initialize.php");  // Initialize DB connection

$api_key = $lastfm_api_key;

//Fetch all bands from your database
$query = "SELECT id, name FROM bands";
$stmt = $db->prepare($query);
$stmt->execute();
$bands = $stmt->fetchAll();

//Loop through each band
foreach ($bands as $band) {
    $band_id = $band['id'];
    $band_name = $band['name'];

//Fetch genres from Last.fm using artist.getTopTags
    $data = fetchArtistGenresFromLastFM($band_name, $api_key);

    if (isset($data['toptags']['tag']) && !empty($data['toptags']['tag'])) {
        foreach ($data['toptags']['tag'] as $result) {
            $genre_name = $result['name'] ?? null;

            if ($genre_name) {
                // Save genre if it doesn't exist
                saveGenreToDatabase($db, $genre_name, 'Auto-fetched from Last.fm');

                // Get genre ID
                $genre_id = getGenreIdByName($db, $genre_name);

                // Link genre to band
                if ($genre_id) {
                    linkGenreToBand($db, $band_id, $genre_id);
                }
            }
        }
    }

    echo "Processed genres for band: {$band_name}\n";
}

?>

