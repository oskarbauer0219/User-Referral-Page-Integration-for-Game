<?php
// Database connection parameters
$servername = "localhost"; // Change if your MySQL server is hosted elsewhere
$username = "root";        // MySQL username
$password = "";            // MySQL password (default is an empty string for localhost)
$dbname = "user_project";  // Database name that will be created

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database '$dbname' created successfully or already exists.<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Select the database to work with
$conn->select_db($dbname);

// Create users table
$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    coins INT DEFAULT 0,
    link VARCHAR(255) NOT NULL UNIQUE
)";
if ($conn->query($sql_users) === TRUE) {
    echo "Table 'users' created successfully or already exists.<br>";
} else {
    echo "Error creating users table: " . $conn->error . "<br>";
}

// Create friends table
$sql_friends = "CREATE TABLE IF NOT EXISTS friends (
    user_id INT NOT NULL,
    friend_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (friend_id) REFERENCES users(id),
    PRIMARY KEY (user_id, friend_id)
)";
if ($conn->query($sql_friends) === TRUE) {
    echo "Table 'friends' created successfully or already exists.<br>";
} else {
    echo "Error creating friends table: " . $conn->error . "<br>";
}

// Close connection
$conn->close();
?>
