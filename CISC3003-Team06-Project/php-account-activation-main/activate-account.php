<?php

$token = $_GET["token"];

$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT * FROM user
        WHERE account_activation_hash = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    die("token not found");
}

$sql = "UPDATE user
        SET account_activation_hash = NULL
        WHERE id = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $user["id"]);

$stmt->execute();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Account Activated</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../web_template/style.css">
    <style>
        .login-header {
            margin-top: 40px; /* 让上方内容往下移动 */
        }
        .success-box {
            text-align: center;
            padding: 20px 0;
        }
        .success-icon {
            font-size: 40px;
            color: #ffffff;
            margin-top: -30px; /* 让图标往上移动一点 */
            margin-bottom: 10px;
        }
        .success-text {
            font-size: 1.2rem;
            margin-bottom: 30px;
            color: #333;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo">
                    <div class="logo-square"></div>
                </div>
                <h2>Activated!</h2>
            </div>
            
            <div class="success-box">
                <div class="success-icon">✓</div>
                <div class="success-text">
                    Account activated successfully.
                </div>
                <a href="login.php" class="login-btn" style="text-decoration: none; display: inline-block;">
                    <span class="btn-text">GO TO LOGIN</span>
                </a>
            </div>
        </div>
    </div>
</body>
</html>