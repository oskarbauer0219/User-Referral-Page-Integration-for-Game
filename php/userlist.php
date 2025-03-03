<?php
session_start();
include('db_connection.php');

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

// Add friend and increase coins when clicking on a username
if (isset($_GET['user_id'])) {
    $friend_id = $_GET['user_id'];

    // Check if already a friend
    $check_friend = $conn->prepare("SELECT * FROM friends WHERE user_id = ? AND friend_id = ?");
    $check_friend->bind_param("ii", $user_id, $friend_id);
    $check_friend->execute();
    $check_friend_result = $check_friend->get_result();

    if ($check_friend_result->num_rows == 0) {
        // Increase the clicked user's coins
        $update_coins = $conn->prepare("UPDATE users SET coins = coins + 500 WHERE id = ?");
        $update_coins->bind_param("i", $friend_id);
        $update_coins->execute();

        // Add the friend in the friends table
        $insert_friend = $conn->prepare("INSERT INTO friends (user_id, friend_id) VALUES (?, ?)");
        $insert_friend->bind_param("ii", $user_id, $friend_id);
        $insert_friend->execute();

        // Prevent further clicks
        header("Location: userlist.php"); // Refresh the page
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
        .container { background-color: white; padding: 20px; border-radius: 10px; width: 500px; margin: 50px auto; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 8px; text-align: left; }
        .button { padding: 5px 10px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .button:hover { background-color: #45a049; }
    </style>
</head>
<body>

<div class="container">
    <h2>User List</h2>
    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Coins</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $user['username'] ?></td>
                    <td><?= $user['coins'] ?></td>
                    <td>
                        <?php if ($user['id'] != $user_id) { ?>
                            <a href="userlist.php?user_id=<?= $user['id'] ?>" class="button">Add Friend</a>
                        <?php } else { ?>
                            <span>Can't click yourself</span>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
