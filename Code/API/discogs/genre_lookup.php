<?php

include_once("../../core/initialize.php");
include_once("../../includes/discogs.php");

//Discogs Token
$discogs_token = 'SQfsuPhEMzReMUMQgcWEXAPIWsAOvcrQapEYuxew';

$query = $_GET['query']?? '';

if (empty($query)) {
    echo json_encode(["error" => "Missing 'query' paremeter"]);
    exit;
}

// Fetch genres/subgenres from Discogs
$data = fetchGenresFromDiscogs($query, $discogs_token);

if (isset($data['results']) && !empty($data['results'])) {
    foreach ($data['results'] as $result) {
        $genres = $result['genre'] ?? [];
        $styles = $result['style'] ?? [];

        foreach ($genres as $genre_name) {
            // Save genre
            saveGenreToDatabase($db, $genre_name);
            $genre_id = getGenreIdByName($db, $genre_name);

            if ($genre_id && !empty($styles)) {
                foreach ($styles as $subgenre_name) {
                    saveSubgenreToDatabase($db, $genre_id, $subgenre_name);
                }
            }
        }
    }

    echo json_encode(["message" => "Genres and subgenres saved successfully."]);
} else {
    echo json_encode(["error" => "No genres found for this query."]);
}

?>