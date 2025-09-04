<?php
require_once "Database.php";

class User extends Database {
    private $error;
    private $user_id;

    // Method for registering a user
    public function register($first_name, $last_name, $username, $password) {
        // Check if the username already exists
        $sql_check = "SELECT * FROM users WHERE username = ?";
        $stmt_check = $this->conn->prepare($sql_check);
        $stmt_check->bind_param("s", $username);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        if ($result_check->num_rows > 0) {
            $this->error = "Username already taken";
            return false;
        }
    
        // Proceed with registration if username is available
        $sql = "INSERT INTO users (first_name, last_name, username, password) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $first_name, $last_name, $username, $password); // Bind values to the query
        
        if ($stmt->execute()) {
            return true; // Registration successful
        } else {
            $this->error = $stmt->error; // Capture any error
            return false; // Registration failed
        }
    }

    // Method for logging in a user
    public function login($username, $password) {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Verify if user exists and password is correct
        if ($user && password_verify($password, $user['password'])) {
            $this->user_id = $user['id']; // Store the user's ID for session
            return true;
        } else {
            $this->error = "Invalid username or password";
            return false;
        }
    }

    // Method to retrieve the user ID (used for session management)
    public function getUserId() {
        return $this->user_id;
    }

    // Method to retrieve errors
    public function getError() {
        return $this->error;
    }

    public function getUserDetails($username) {
        // Prepare SQL query to fetch user details by username
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
    
        // Check if the statement was prepared correctly
        if (!$stmt) {
            die("Error preparing SQL statement: " . $this->conn->error);
        }
    
        // Bind the username parameter to the SQL statement
        $stmt->bind_param("s", $username);
    
        // Execute the query
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                // Return user details as an associative array
                return $result->fetch_assoc();
            } else {
                // No user found
                return null;
            }
        } else {
            die("Error executing SQL statement: " . $stmt->error);
        }
    }

}
