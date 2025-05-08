<?php

include_once("../../core/initialize.php");

$query = "SELECT id, name FROM bands";
$stmt = $db->prepare($query);
$stmt->execute();
$bands = $stmt->fetchAll();

$results = [];

foreach ($bands as $band) {
    $band_id = $band['id'];
    $band_name = $band['name'];
    $data = fetchArtistGenresFromLastFM($band_name, $lastfm_api_key);

    if (isset($data['toptags']['tag']) && !empty($data['toptags']['tag'])) {
        $tags = array_filter($data['toptags']['tag'], function ($tag) {
            $name = strtolower($tag['name'] ?? '');
            return !in_array($name, ['seen live', 'favorites', 'all']);
        });

        $tags = array_values($tags);
        $main_tag = array_shift($tags);
        $main_genre_name = $main_tag['name'] ?? null;

        if ($main_genre_name) {
            saveGenreToDatabase($db, $main_genre_name, 'Auto-fetched from Last.fm');
            $main_genre_id = getGenreIdByName($db, $main_genre_name);

            if ($main_genre_id) {
                linkGenreToBand($db, $band_id, $main_genre_id);
                foreach ($tags as $sub_tag) {
                    $subgenre_name = $sub_tag['name'] ?? null;
                    if ($subgenre_name) {
                        saveSubgenreToDatabase($db, $main_genre_id, $subgenre_name, 'Auto-fetched subgenre from Last.fm');
                    }
                }
            }
        }
        $results[] = ['band' => $band_name, 'status' => 'processed'];
    } else {
        $results[] = ['band' => $band_name, 'status' => 'no tags'];
    }
}

echo json_encode(['results' => $results]);

?>