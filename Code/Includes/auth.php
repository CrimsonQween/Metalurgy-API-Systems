<?php
function getSpotifyAccessToken($client_id, $client_secret) {
    $ch = curl_init();

    $encodedCredentials = base64_encode($client_id . ':' . $client_secret);

    curl_setopt($ch, CURLOPT_URL, 'https://accounts.spotify.com/api/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Basic ' . $encodedCredentials,
        'Content-Type: application/x-www-form-urlencoded'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');

    $response = curl_exec($ch);

    // Debug cURL errors
    if (curl_errno($ch)) {
        echo 'cURL error: ' . curl_error($ch);
        curl_close($ch);
        return null;
    }

    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $json = json_decode($response, true);

    // Debugging output
    if ($status_code !== 200) {
        echo "Spotify Auth Error (HTTP $status_code): " . ($json['error_description'] ?? $json['error'] ?? 'Unknown error');
        return null;
    }

    return $json['access_token'] ?? null;
}
?>
