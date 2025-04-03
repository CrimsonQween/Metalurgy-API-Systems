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

    public function __construct($db) {
        $this->conn = $db;
    }

// Create User
public function create() {
    $query = "INSERT INTO users (username, email, password, firstName, lastName) 
            VALUES (:username, :email, :password, :first_name, :last_name)";
    
    $stmt = $this->conn->prepare($query);

    // Bind values
    $stmt->bindParam(":username", $this->username);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":password", $this->password);
    $stmt->bindParam(":first_name", $this->firstName);
    $stmt->bindParam(":last_name", $this->lastName);

    // Execute query
    return $stmt->execute();
}
}