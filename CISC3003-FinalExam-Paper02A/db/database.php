<?php
$host = "localhost";
$dbname = "message_db";
$username = "root";
$password = "";

$conn = mysqli_connect(hostname: $host,
    username: $username,
    password: $password,
    database: $dbname);

if (mysqli_connect_errno()) {
    die("Connection error: " . mysqli_connect_error());
}