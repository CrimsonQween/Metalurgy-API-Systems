<?php

function fetchGenresFromMusicBrainz($query) {
    $url = "https://musicbrainz.org/ws/2/genre?query=" . urlencode($query) . "&fmt=json";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}

?>
