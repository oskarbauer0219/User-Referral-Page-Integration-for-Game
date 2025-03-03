<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "user_project";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all users
$result = $conn->query("SELECT id FROM scores");
$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row['id'];
}

// Shuffle the users array to create randomness
shuffle($users);

// Function to count the current number of friends
function getFriendCount($conn, $userId) {
    $query = $conn->query("SELECT COUNT(*) AS friend_count FROM friends WHERE user_id = $userId");
    $row = $query->fetch_assoc();
    return $row['friend_count'];
}

// Assign friendships with a maximum of 6 friends per user
for ($i = 0; $i < count($users); $i++) {
    for ($j = $i + 1; $j < count($users); $j++) {
        $user_id = $users[$i];
        $friend_id = $users[$j];

        // Check if both users have less than 6 friends
        if (getFriendCount($conn, $user_id) < 6 && getFriendCount($conn, $friend_id) < 6) {
            // Ensure no duplicate friendships
            $check = $conn->query("SELECT * FROM friends WHERE (user_id = $user_id AND friend_id = $friend_id) OR (user_id = $friend_id AND friend_id = $user_id)");
            if ($check->num_rows == 0) {
                $conn->query("INSERT INTO friends (user_id, friend_id) VALUES ($user_id, $friend_id)");
                $conn->query("INSERT INTO friends (user_id, friend_id) VALUES ($friend_id, $user_id)"); // Two-way friendship
            }
        }
    }
}

echo "Friendships assigned successfully!";
$conn->close();
?>
