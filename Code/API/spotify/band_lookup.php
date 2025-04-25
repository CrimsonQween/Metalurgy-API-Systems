<?php

include_once("../../Core/initialize.php"); 

// Function to save band info to the database
function saveBandToDatabase($db, $name, $genres, $followers, $popularity, $image_url, $spotify_url, $spotify_id) {
    $query = "INSERT INTO bands (name, genres, followers, popularity, image_url, spotify_url, spotify_id) 
            VALUES (:name, :genres, :followers, :popularity, :image_url, :spotify_url, :spotify_id)";
    
    $stmt = $db->prepare($query);

    // Bind parameters
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":genres", $genres);
    $stmt->bindParam(":followers", $followers);
    $stmt->bindParam(":popularity", $popularity);
    $stmt->bindParam(":image_url", $image_url);
    $stmt->bindParam(":spotify_url", $spotify_url);
    $stmt->bindParam(":spotify_id", $spotify_id);

    // Execute the statement and return the result
    return $stmt->execute();
}

$client_id = "86219762966343f7a26927cf1a126d81";
$client_secret = "22896849e85243d89c8359f9a8981142";

$query = $_GET['q'] ?? '';

if (empty($query)) {
    echo json_encode(["error" => "Missing 'q' parameter"]);
    exit;
}

$access_token = getSpotifyAccessToken($client_id, $client_secret);

if (!$access_token) {
    echo json_encode(["error" => "Failed to authenticate with Spotify"]);
    exit;
}

// Fetch band data from Spotify using the access token
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.spotify.com/v1/search?q=" . urlencode($query) . "&type=artist&limit=1");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $access_token"
]);

$response = curl_exec($ch);
curl_close($ch);

// Decode the JSON response from Spotify
$data = json_decode($response, true);

// Check if we got any artist data
if (isset($data['artists']['items'][0])) {
    $artist = $data['artists']['items'][0];

    // Extract relevant data
    $artist_name = $artist['name'];
    $genres = implode(", ", $artist['genres']); // Convert genres array to a string
    $followers = $artist['followers']['total'];
    $popularity = $artist['popularity'];
    $image_url = $artist['images'][0]['url']; // Using the highest resolution image
    $spotify_url = $artist['external_urls']['spotify']; // Link to Spotify
    $spotify_id = $artist['id'];  // Spotify artist ID

    // Save to database
    if (saveBandToDatabase($db, $artist_name, $genres, $followers, $popularity, $image_url, $spotify_url, $spotify_id)) {
        echo json_encode([
            'message' => 'Band data saved successfully!',
            'band' => [
                'name' => $artist_name,
                'genres' => $genres,
                'followers' => $followers,
                'popularity' => $popularity,
                'image_url' => $image_url,
                'spotify_url' => $spotify_url,
                'spotify_id' => $spotify_id
            ]
        ]);
    } else {
        echo json_encode(['error' => 'Failed to save band data to database']);
    }
} else {
    echo json_encode(["error" => "Artist not found"]);
}
?>
