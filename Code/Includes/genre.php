<?php
class Genre {
    private $conn;
    private $table = "genres";

    public $id;
    public $name;
    public $description;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO {$this->table} (name, description) VALUES (:name, :description)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        return $stmt->execute();
    }

    public function read() {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}

// Function to save genres to the database
// function saveGenreToDatabase($db, $name, $description = null) {
//     $query = "INSERT IGNORE INTO genres (name, description) VALUES (:name, :description)";
//     $stmt = $db->prepare($query);
//     $stmt->bindParam(':name', $name);
//     $stmt->bindParam(':description', $description);
//     return $stmt->execute();
// }

// // Function to save subgenres to the database
// function saveSubgenreToDatabase($db, $genre_id, $name, $description = null) {
//     $query = "INSERT IGNORE INTO subgenres (genre_id, name, description) VALUES (:genre_id, :name, :description)";
//     $stmt = $db->prepare($query);
//     $stmt->bindParam(':genre_id', $genre_id);
//     $stmt->bindParam(':name', $name);
//     $stmt->bindParam(':description', $description);
//     return $stmt->execute();
// }

// // Function to link a genre to a band in the database
// function linkGenreToBand($db, $band_id, $genre_id) {
//     $query = "INSERT INTO band_genres (band_id, genre_id) VALUES (:band_id, :genre_id)";
//     $stmt = $db->prepare($query);
//     $stmt->bindParam(':band_id', $band_id);
//     $stmt->bindParam(':genre_id', $genre_id);
//     return $stmt->execute();
// }

// // Function to get the genre ID by its name
// function getGenreIdByName($db, $name) {
//     $query = "SELECT id FROM genres WHERE name = :name LIMIT 1";
//     $stmt = $db->prepare($query);
//     $stmt->bindParam(':name', $name);
//     $stmt->execute();
//     $row = $stmt->fetch();
//     return $row ? $row['id'] : null;
// }

// // Function to fetch genres from LastFM
// function fetchGenresFromLastFM($query, $api_key) {
//     $url = "http://ws.audioscrobbler.com/2.0/?method=tag.getTopTags&api_key=" . $api_key . "&format=json";
    
//     // Initialize cURL session
//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     $response = curl_exec($ch);
//     curl_close($ch);

//     return json_decode($response, true);
// }

// // Function to fetch genres from MusicBrainz
// function fetchGenresFromMusicBrainz($query) {
//     $url = "https://musicbrainz.org/ws/2/genre?query=" . urlencode($query) . "&limit=50&fmt=json";
    
//     // Initialize cURL session
//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     $response = curl_exec($ch);
//     curl_close($ch);

//     return json_decode($response, true);
// }

// // Function to save genre and link to band in the database
// function saveGenreAndLinkToBand($db, $genre_name, $band_id) {
//     saveGenreToDatabase($db, $genre_name);

//     $genre_id = getGenreIdByName($db, $genre_name);

//     if ($genre_id) {
//         linkGenreToBand($db, $band_id, $genre_id);
//     }
// }
?>
