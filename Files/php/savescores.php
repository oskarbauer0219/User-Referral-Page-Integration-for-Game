<?php

include 'login.php';

if (isset($_GET['name']) && isset($_GET['score'])) {
    $con = mysqli_connect($host, $db_username, $db_password, $db_name);

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Lightly sanitize the GET parameters to prevent SQL injections and possible XSS attacks
    $name = strip_tags(mysqli_real_escape_string($con, $_GET['name']));
    $score = strip_tags(mysqli_real_escape_string($con, $_GET['score']));

    // Check if the user already exists
    $query = "SELECT * FROM $db_table WHERE name='$name'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        // User exists, update the score
        $sql = "UPDATE $db_table SET score='$score' WHERE name='$name'";
        if (mysqli_query($con, $sql)) {
            echo 'Your score was updated. Congrats!';
        } else {
            echo 'There was a problem updating your score. Please try again later.';
        }
    } else {
        // User does not exist, insert a new record
        $sql = "INSERT INTO $db_table (name, score) VALUES ('$name','$score')";
        if (mysqli_query($con, $sql)) {
            echo 'Your score was saved. Congrats!';
        } else {
            echo 'There was a problem saving your score. Please try again later.';
        }
    }

    mysqli_close($con); // Close the MySQL connection to save resources.
} else {
    echo 'Your name or score wasn\'t passed in the request. Make sure you add ?name=NAME_HERE&score=1337 to the URL.';
}

?>