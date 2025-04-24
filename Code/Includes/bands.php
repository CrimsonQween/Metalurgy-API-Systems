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
        $query = "INSERT INTO " . $this->table . " (name, origin, year_formed, spotify_id, image_url)
                VALUES (:name, :origin, :year_formed, :spotify_id, :image_url)";

        $stmt = $this->conn->prepare($query);

        foreach (['name', 'origin', 'year_formed', 'spotify_id', 'image_url'] as $field) {
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
                    image_url = :image_url
                    WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        foreach (['id', 'name', 'origin', 'year_formed', 'spotify_id', 'image_url'] as $field) {
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

?>