<?php
header('Access-Control-Allow-Origin: *');

include 'login.php';


// Connect to server and select database.
$con = mysqli_connect($host, $db_username, $db_password, $db_name);

// Retrieve data from database
$sql = "SELECT *
        FROM scores
        ORDER BY score DESC
        LIMIT 10";	// The 'LIMIT 10' part will only read 10 scores. Feel free to change this value
$result = mysqli_query($con, $sql);

// Start looping rows in mysql database.
while($rows = mysqli_fetch_array($result)){
    echo $rows['name'] . "|" . $rows['score'] . "|" . $rows['link'] . "|";
// close while loop 
}

// close MySQL connection 
mysqli_close($con);
?>