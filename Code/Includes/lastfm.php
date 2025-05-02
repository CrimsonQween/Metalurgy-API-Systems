<?php

function fetchGenresFromLastFM($api_key, $query) {
    $url = "http://ws.audioscrobbler.com/2.0/?method=tag.getTopTags&api_key={$api_key}&format=json&tag=" . urlencode($query);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}

?>
