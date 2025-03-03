<?php
// Database connection details
// $servername = "localhost";
// $username = "root";
// $password = "";
// $database = "user_project";
include 'login.php';

header("Access-Control-Allow-Origin: *");

// Allow specific HTTP methods (GET, POST, etc.)
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

// Allow specific headers
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight requests (for OPTIONS method)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

if (isset($_GET['name'])) {
    // Get the value of the 'username' parameter
    $name = $_GET['name'];
} else {
    $name = "edadras2095";
}

// Create connection
$conn = new mysqli($host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to get the link of the user with name 'edadras2095'
// $name = "edadras2095";
$sql = "SELECT score FROM scores WHERE name = '$name'";
$result = $conn->query($sql);

// Output the link
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo $row["score"];
} else {
    echo "User not found.";
}

// Close connection
$conn->close();
?>
