<?php
// $servername = "localhost";
// $dbusername = "root";
// $password = "";
// $database = "user_project";
include 'login.php';
header("Access-Control-Allow-Origin: *");

// Allow specific HTTP methods (GET, POST, etc.)
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

// Allow specific headers
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight requests (for OPTIONS method)
// if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
//     http_response_code(200);
//     exit();
// }

if (isset($_GET['name'])) {
    // Get the value of the 'username' parameter
    $username = $_GET['name'];
} else {
    $username = "edadras2095";
}
if (isset($_GET['flag'])) {
    // Get the value of the 'flag' parameter
    $flag=$_GET['flag'];
} else {
    $flag=0;
}
// echo $username;
// Create connection
$conn = new mysqli($host, $db_username, $db_password, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define the username
// $userName = "edadras2095"; 
// Get the user's ID and current score
$userQuery = $conn->query("SELECT id, score FROM scores WHERE name = '$username'");
if ($userQuery->num_rows > 0) {
    $userRow = $userQuery->fetch_assoc();
    $userId = $userRow['id'];
    
    // Increase the user's score by 500
    if($flag==1) {$conn->query("UPDATE scores SET score = score + 500 WHERE id = $userId");}
    if($flag==0) {$conn->query("UPDATE scores SET score = score WHERE id = $userId");}

    // Fetch all friends of the user along with their scores
    $friendsQuery = $conn->query("SELECT scores.name, scores.score FROM friends 
                                  JOIN scores ON friends.friend_id = scores.id 
                                  WHERE friends.user_id = $userId");

        while ($friend = $friendsQuery->fetch_assoc()) {
            echo $friend['name']. "|"  . $friend['score']. "|" ;
        }

} else {
    echo "User not found.";
}

$conn->close();
?>
