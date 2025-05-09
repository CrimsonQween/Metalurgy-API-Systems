<?php

class Bands {
    private $conn;
    private $table = "bands";

    public $id;
    public $name;
    public $origin;
    public $year_formed;
    public $spotify_id;
    public $image_url;

    public function __construct($db) {
        $this->conn = $db;
    }

    // CREATE
    public function create() {
        $query = "INSERT INTO " . $this->table . " (name, origin, year_formed, spotify_id, image_url, spotify_url, followers,popularity)
                VALUES (:name, :origin, :year_formed, :spotify_id, :image_url, :spotify_url , :followers, :popularity)";

        $stmt = $this->conn->prepare($query);

        foreach (['name', 'origin', 'year_formed', 'spotify_id', 'image_url', 'spotify_url', 'followers', 'popularity'] as $field) {
            $this->$field = htmlspecialchars(strip_tags($this->$field));
            $stmt->bindParam(":$field", $this->$field);
        }

        return $stmt->execute();
    }

    // READ ALL
    public function read() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // READ SINGLE
    public function read_single() {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE
    public function update() {
        $query = "UPDATE " . $this->table . " SET 
                    name = :name,
                    origin = :origin,
                    year_formed = :year_formed,
                    spotify_id = :spotify_id,
                    image_url = :image_url,
                    spotify_url = :spotify_url,
                    followers = :followers,
                    popularity = :popularity
                    WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        foreach (['id', 'name', 'origin', 'year_formed', 'spotify_id', 'image_url', 'spotify_url', 'followers', 'popularity'] as $field) {
            $this->$field = htmlspecialchars(strip_tags($this->$field));
            $stmt->bindParam(":$field", $this->$field);
        }

        return $stmt->execute();
    }

    // DELETE
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }
}

// Functions to aid in Genre Linking

function linkBandToGenre($db, $band_id, $genre_id) {
    $query = "INSERT IGNORE INTO band_genres (band_id, genre_id) VALUES (:band_id, :genre_id)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':band_id', $band_id);
    $stmt->bindParam(':genre_id', $genre_id);
    return $stmt->execute();
}

function linkBandToSubgenre($db, $band_id, $subgenre_id) {
    $query = "INSERT IGNORE INTO band_genres (band_id, subgenre_id) VALUES (:band_id, :subgenre_id)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':band_id', $band_id);
    $stmt->bindParam(':subgenre_id', $subgenre_id);
    return $stmt->execute();
}

function getBandIdByName($db, $name) {
    $query = "SELECT id FROM bands WHERE name = :name LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->execute();
    $row = $stmt->fetch();
    return $row ? $row['id'] : null;
}

?>