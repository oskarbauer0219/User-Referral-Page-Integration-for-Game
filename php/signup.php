<?php
session_start();
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $link = 'user' . uniqid(); // Generate a unique link for each user

    // Check if username already exists
    $check_user = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $check_user->bind_param("s", $username);
    $check_user->execute();
    $result = $check_user->get_result();

    if ($result->num_rows > 0) {
        $error_message = "Username already exists!";
    } else {
        // Insert user data into the database
        $insert_user = $conn->prepare("INSERT INTO users (username, password, coins, link) VALUES (?, ?, 0, ?)");
        $insert_user->bind_param("sss", $username, $password, $link);

        if ($insert_user->execute()) {
            header("Location: login.php"); // Redirect to login page on success
            exit();
        } else {
            $error_message = "Error during signup!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
        .container { background-color: white; padding: 20px; border-radius: 10px; width: 300px; margin: 50px auto; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); }
        input, button { width: 100%; padding: 10px; margin: 5px 0; border-radius: 5px; border: 1px solid #ccc; }
        button { background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        .error { color: red; font-size: 14px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Signup</h2>
    <form action="signup.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <?php if (isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>
        <button type="submit">Signup</button>
    </form>
</div>

</body>
</html>
