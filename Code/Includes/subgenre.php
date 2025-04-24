<?php
class Subgenre {
    private $conn;
    private $table = "subgenres";

    public $id;
    public $name;
    public $description;
    public $genre_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO {$this->table} (name, description, genre_id)
                VALUES (:name, :description, :genre_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":genre_id", $this->genre_id);
        return $stmt->execute();
    }

    public function readByGenre($genre_id) {
        $query = "SELECT * FROM {$this->table} WHERE genre_id = :genre_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":genre_id", $genre_id);
        $stmt->execute();
        return $stmt;
    }
}
?>
