<?php

class Album {
    private $conn;
    private $table = "albums";  

    public $id;
    public $title;
    public $spotify_id;
    public $release_year;
    public $band_id; 
    public $cover_image;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create an album
    public function create() {
        $query = "INSERT INTO " . $this->table . " (title, spotify_id, release_year, band_id, cover_image) 
            VALUES (:title, :spotify_id, :release_year, :band_id, :cover_image)";
        
        $stmt = $this->conn->prepare($query);

        // Bind the parameters
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":spotify_id", $this->spotify_id);
        $stmt->bindParam(":release_year", $this->release_year);
        $stmt->bindParam(":band_id", $this->band_id);
        $stmt->bindParam(":cover_image", $this->cover_image);

        // Execute and return the result
        return $stmt->execute();
    }

    // Read all albums
    public function read($limit = 10, $offset = 0) {
        $query = "SELECT * FROM " . $this->table . " LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }

    // Read a single album by ID
    public function read_single() {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        return $stmt;
    }

    // Update album
    public function update() {
        $query = "UPDATE " . $this->table . " SET 
                title = :title, 
                spotify_id = :spotify_id, 
                release_year = :release_year, 
                band_id = :band_id,
                cover_image = :cover_image
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":spotify_id", $this->spotify_id);
        $stmt->bindParam(":release_year", $this->release_year);
        $stmt->bindParam(":band_id", $this->band_id);
        $stmt->bindParam(":cover_image", $this->cover_image);

        return $stmt->execute();
    }

    // Delete album
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":id", $this->id);
        
        return $stmt->execute();
    }
}
?>
