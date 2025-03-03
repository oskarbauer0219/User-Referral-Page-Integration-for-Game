<?php
header('Access-Control-Allow-Origin: *');

include 'login.php';

if(isset($_GET['score'])){

    // Connect to server and select database.
    $con = mysqli_connect($host, $db_username, $db_password, $db_name);

    // Retrieve data from database: one row for each player who has submitted a better score
    $sql = "SELECT COUNT(*) AS rank
            FROM scores
            WHERE score > " . $_GET['score'] . " GROUP BY name";

    $result = mysqli_query($con, $sql);

    $i = 0;
    // Start looping rows in mysql database.
    while($rows = mysqli_fetch_array($result)){
        $i++;
    // close while loop 
    }

    // Print the rank (the number of people who have better score than you + 1)
    echo ($i + 1);

    // close MySQL connection 
    mysqli_close($con);    

    
} else {
    
    echo 'Your score wasnt passed in the request. Make sure you add "?score=1337" to the URL.';

}
    

?>