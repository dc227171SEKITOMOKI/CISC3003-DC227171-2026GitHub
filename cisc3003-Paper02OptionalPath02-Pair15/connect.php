<?php
$servername = "localhost";
$username = "CISC3003Team06";
$password = "1111";
$dbname = "login";

// create a connection
$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error){
    echo "connection failed";
}
?>