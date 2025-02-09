<?php
require_once "Database.php";

class User {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->conn;
    }

    // ✅ General Validation Function to Avoid Repetition
    private function validateUserData($name, $email) {
        $name = trim($name);
        $email = trim($email);

        if (empty($name) || empty($email)) {
            return ["status" => "error", "message" => "All fields are required."];
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ["status" => "error", "message" => "Invalid email format."];
        }
        if (strlen($name) < 4 || strlen($name) > 20) {
            return ["status" => "error", "message" => "Name must be between 4 and 20 characters."];
        }
        if (strlen($email) > 30) {
            return ["status" => "error", "message" => "Email cannot exceed 30 characters."];
        }

        return [
            "status" => "valid", "name" => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
            "email" => htmlspecialchars($email, ENT_QUOTES, 'UTF-8')];
    }

    // ✅ CREATE - Add a new user
    public function createUser($name, $email) {
        $validation = $this->validateUserData($name, $email);
        if ($validation["status"] !== "valid") return $validation;

        try {
            $stmt = $this->conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
            $stmt->bind_param("ss", $validation["name"], $validation["email"]);
            $stmt->execute();

            return ["status" => "success", "message" => "User created successfully."];
        } catch (Exception $e) {
            return ["status" => "error", "message" => $e->getMessage()];
        }
    }

    // ✅ READ - Get all users
    public function getUsers() {
        $result = $this->conn->query("SELECT * FROM users ORDER BY created_at DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // ✅ READ - Get a single user by ID
    public function getUserById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // ✅ UPDATE - Modify user details
    public function updateUser($id, $name, $email) {
        $validation = $this->validateUserData($name, $email);
        if ($validation["status"] !== "valid"){
            return $validation;
        }
        try {
            $stmt = $this->conn->prepare("UPDATE users SET name=?, email=? WHERE id=?");
            $stmt->bind_param("ssi", $validation["name"], $validation["email"], $id);
            $stmt->execute();

            return ["status" => "success", "message" => "User updated successfully."];
        } catch (Exception $e) {
            return ["status" => "error", "message" => $e->getMessage()];
        }
    }

    // ✅ DELETE - Remove a user
    public function deleteUser($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM users WHERE id=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            return ["status" => "success", "message" => "User deleted successfully."];
        } catch (Exception $e) {
            return ["status" => "error", "message" => $e->getMessage()];
        }
    }
}
