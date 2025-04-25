<?php

include_once("../../Core/initialize.php"); 

$client_id = "86219762966343f7a26927cf1a126d81";
$client_secret = "22896849e85243d89c8359f9a8981142";

$access_token = getSpotifyAccessToken($client_id, $client_secret); 


// Function to fetch albums from Spotify API
function fetchAlbums($band_spotify_id, $access_token) {
    // Initialize cURL to fetch album data from Spotify
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/artists/{$band_spotify_id}/albums?limit=10");  // Limit to 10 albums
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $access_token"  // Authorization with access token
    ]);

    // Execute the request and close the cURL session
    $response = curl_exec($ch);
    curl_close($ch);

    // Decode the JSON response
    return json_decode($response, true);
}

// Function to save album to database
function saveAlbumToDatabase($db, $band_id, $title, $release_year, $spotify_id, $cover_image, $track_count, $spotify_url) {
    // Prepare SQL query to insert album data into the database
    $query = "INSERT INTO albums (band_id, title, release_year, spotify_id, cover_image, track_count, spotify_url) 
            VALUES (:band_id, :title, :release_year, :spotify_id, :cover_image, :track_count, :spotify_url)";
    
    // Prepare the SQL statement
    $stmt = $db->prepare($query);

    // Bind parameters
    $stmt->bindParam(":band_id", $band_id);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":release_year", $release_year);
    $stmt->bindParam(":spotify_id", $spotify_id);
    $stmt->bindParam(":cover_image", $cover_image);
    $stmt->bindParam(":track_count", $track_count);
    $stmt->bindParam(":spotify_url", $spotify_url);

    // Execute the statement
    return $stmt->execute();
}

// Fetch the band_spotify_id and query parameters from the URL or input (e.g., $_GET)
$band_spotify_id = $_GET['band_spotify_id'] ?? '';  // Band Spotify ID from query parameter

// Check if band_spotify_id is provided
if (empty($band_spotify_id)) {
    echo json_encode(["error" => "Missing 'band_spotify_id' parameter"]);
    exit;
}

// Check if access token is available
if (!$access_token) {
    echo json_encode(["error" => "Failed to authenticate with Spotify"]);
    exit;
}

// Fetch albums from Spotify
$albums = fetchAlbums($band_spotify_id, $access_token);

// Check if we have album data
if (isset($albums['items']) && !empty($albums['items'])) {
    // Iterate over the albums and save each one to the database
    foreach ($albums['items'] as $album) {
        $title = $album['name'];  // Album title
        $release_year = substr($album['release_date'], 0, 4);  // Extract the release year from the release_date
        $spotify_id = $album['id'];  // Spotify album ID
        $cover_image = $album['images'][0]['url'];  // Album cover image URL (highest resolution)
        $track_count = $album['total_tracks'];  // Number of tracks in the album
        $spotify_url = $album['external_urls']['spotify'];  // Album's Spotify URL

        // Assume you already have the band_id stored in the database (you can get it using the band's Spotify ID)
        // Example: Fetch band_id from the database if needed
        $band_id = getBandIdFromSpotifyId($band_spotify_id, $db);  // This function will need to be defined

        // Save the album data to the database
        if (saveAlbumToDatabase($db, $band_id, $title, $release_year, $spotify_id, $cover_image, $track_count, $spotify_url)) {
            echo json_encode([
                'message' => 'Album data saved successfully!',
                'album' => [
                    'title' => $title,
                    'release_year' => $release_year,
                    'spotify_id' => $spotify_id,
                    'cover_image' => $cover_image,
                    'track_count' => $track_count,
                    'spotify_url' => $spotify_url  // Include the Spotify URL in the response
                ]
            ]);
        } else {
            echo json_encode(['error' => 'Failed to save album data to database']);
        }
    }
} else {
    echo json_encode(["error" => "No albums found for this band"]);
}

/**
 * Fetch the band ID from the database using the band's Spotify ID.
 * Assumes you have a `bands` table with a `spotify_id` column.
 */
function getBandIdFromSpotifyId($band_spotify_id, $db) {
    $query = "SELECT id FROM bands WHERE spotify_id = :spotify_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':spotify_id', $band_spotify_id);
    $stmt->execute();

    // Return the band ID if found
    if ($row = $stmt->fetch()) {
        return $row['id'];
    }
    return null;  // If no band found, return null
}
?>