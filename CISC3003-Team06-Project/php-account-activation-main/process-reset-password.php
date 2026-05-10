<?php

$token = $_POST["token"];

$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT * FROM user
        WHERE reset_token_hash = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    die("token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("token has expired");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$sql = "UPDATE user
        SET password_hash = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE id = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("ss", $password_hash, $user["id"]);

$stmt->execute();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Password Reset Successful</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../web_template/style.css">
    <style>
        .success-box {
            text-align: center;
            padding: 20px 0;
        }
        .success-icon {
            font-size: 40px;
            color: #ffffff;
            margin-bottom: 10px;
        }
        .success-text {
            font-size: 1.2rem;
            margin-bottom: 30px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">

                <h2>Success</h2>
            </div>
            
            <div class="success-box">
                <div class="success-icon">✓</div>
                <div class="success-text">
                    Password updated successfully.
                </div>
                <a href="login.php" class="login-btn" style="text-decoration: none; display: inline-block;">
                    <span class="btn-text">GO TO LOGIN</span>
                </a>
            </div>
        </div>
    </div>
</body>
</html>