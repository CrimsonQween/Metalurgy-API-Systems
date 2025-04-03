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

// Create User Endpoint
public function create() {
    $query = "INSERT INTO users (username, email, password, firstName, lastName) 
            VALUES (:username, :email, :password, :first_name, :last_name)";
    
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(":username", $this->username);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":password", $this->password);
    $stmt->bindParam(":first_name", $this->firstName);
    $stmt->bindParam(":last_name", $this->lastName);

    return $stmt->execute();
}

//  Get Users Endpoint
public function read($limit = 10, $offset = 0) {
    $query = "SELECT id, username, email, firstName, lastName FROM " . $this->table . " LIMIT :limit OFFSET :offset";
    $stmt = $this->conn->prepare($query);
    
    $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
    $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt;
}

// Update User Endpoint#
public function update(){
    $query = "UPDATE {$this->table} SET username =:username, email = :email , password = :password ,firstName = :firstName , lastName = :lastName WHERE id = :id;";

    $stmt = $this->conn->prepare($query);
    
    $this->id = htmlspecialchars(strip_tags($this->id));
    $this->username = htmlspecialchars(strip_tags($this->username));
    $this->email = htmlspecialchars(strip_tags($this->email));
    $this->password = htmlspecialchars(strip_tags($this->password));
    $this->firstName = htmlspecialchars(strip_tags($this->firstName));
    $this->lastName = htmlspecialchars(strip_tags($this->lastName));

    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":username", $this->username);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":password", $this->password);
    $stmt->bindParam(":firstName", $this->firstName);
    $stmt->bindParam(":lastName", $this->lastName);

    if($stmt->execute()){
        return true;
    }
    printf("Error %s. \n", $stmt->error);
    return false;
}

}