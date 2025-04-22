<?php

class Users {
    private $conn;
    private $table = "users";

    public $id;
    public $username;
    public $email;
    public $password;
    public $firstName;
    public $lastName;
    public $joined_at;
    public $alias;
    public $bio;
    public $profile_picture;
    public $interests;

    public function __construct($db) {
        $this->conn = $db;
    }

// Create User Endpoint
public function create() {
// Check if username or email already exists
    $checkQuery = "SELECT id FROM " . $this->table . " WHERE username = :username OR email = :email";
    $checkStmt = $this->conn->prepare($checkQuery);
    $checkStmt->bindParam(":username", $this->username);
    $checkStmt->bindParam(":email", $this->email);
    $checkStmt->execute();
    
    if ($checkStmt->rowCount() > 0) {
        return "exists";
    }

    $query = "INSERT INTO users (username, email, password, firstName, lastName, bio, profile_picture, interests, alias) 
    VALUES (:username, :email, :password, :first_name, :last_name, :bio, :profile_picture, :interests, :alias)";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(":username", $this->username);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":password", $this->password);
    $stmt->bindParam(":first_name", $this->firstName);
    $stmt->bindParam(":last_name", $this->lastName);
    $stmt->bindParam(":bio", $this->bio);
    $stmt->bindParam(":profile_picture", $this->profile_picture);
    $stmt->bindParam(":interests", $this->interests);
    $stmt->bindParam(":alias", $this->alias);

return $stmt->execute();
}

//  Get Users Endpoint
public function read($limit = 10, $offset = 0) {
    $query = "SELECT * FROM " . $this->table . " LIMIT :limit OFFSET :offset";
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
    $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt;
}

// Update User Endpoint#
public function update() {
    $query = "UPDATE {$this->table} SET 
            username = :username, email = :email, password = :password,
            firstName = :firstName, lastName = :lastName,
            bio = :bio, profile_picture = :profile_picture,
            interests = :interests, alias = :alias
            WHERE id = :id";

    $stmt = $this->conn->prepare($query);

    foreach (['id', 'username', 'email', 'password', 'firstName', 'lastName', 'bio', 'profile_picture', 'interests', 'alias'] as $field) {
        $this->$field = htmlspecialchars(strip_tags($this->$field));
        $stmt->bindParam(":$field", $this->$field);
    }

    return $stmt->execute();
}

// Delete User Endpoint
public function delete() {
    $query = "DELETE FROM {$this->table} WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $this->id = htmlspecialchars(strip_tags($this->id));
    $stmt->bindParam(":id", $this->id);
    return $stmt->execute();

}
}