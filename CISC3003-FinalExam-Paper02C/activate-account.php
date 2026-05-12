<?php

$token = $_GET["token"];
$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT * FROM user WHERE account_activation_hash = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $token_hash);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null) {
    die("Token is invalid or account already activated.");
}


$sql = "UPDATE user SET account_activation_hash = NULL WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $user["id"]);
$stmt->execute();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Account Activated</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>Account Activated</h1>
    <p>Account activated successfully. You can now <a href="login.php">log in</a>.</p>
    <footer>
        <p>CISC3003 Web Programming: Seki Tomoki DC227171 2026</p>
    </footer>
</body>
</html>