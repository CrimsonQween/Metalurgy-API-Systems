<?php
class Song {
    private $conn;
    private $table = "songs";

    public $id;
    public $title;
    public $duration;
    public $spotify_id;
    public $album_id;
    public $track_number;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO {$this->table} 
        (title, duration, spotify_id, album_id, track_number) 
        VALUES (:title, :duration, :spotify_id, :album_id, :track_number)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":duration", $this->duration);
        $stmt->bindParam(":spotify_id", $this->spotify_id);
        $stmt->bindParam(":album_id", $this->album_id);
        $stmt->bindParam(":track_number", $this->track_number);

        return $stmt->execute();
    }

    public function read() {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function delete() {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }
}
?>
