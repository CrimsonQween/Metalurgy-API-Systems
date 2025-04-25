<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");

include_once("../../core/initialize.php");

$band = new Bands($db);

$stmt = $band->read();
$num = $stmt->rowCount();

if ($num > 0) {
    $bands_arr = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $band_item = [
            'id' => $id,
            'name' => $name,
            'origin' => $origin,
            'year_formed' => $year_formed,
            'spotify_id' => $spotify_id,
            'image_url' => $image_url,
            'spotify_url' => $spotify_url,
            'followers' => $followers,
            'popularity' => $popularity,
            'genres' => $genres
        ];
        array_push($bands_arr, $band_item);
    }
    echo json_encode($bands_arr);
} else {
    echo json_encode(["message" => "No bands found"]);
}
?>
