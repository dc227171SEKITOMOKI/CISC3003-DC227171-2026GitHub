<?php
$token = $_POST["token"];
$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT * FROM user WHERE reset_token_hash = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $token_hash);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null) { die("Token not found"); }
if (strtotime($user["reset_token_expires_at"]) <= time()) { die("Token has expired"); }

// 验证密码规则（和注册时一样）
if (strlen($_POST["password"]) < 8) { die("Password must be at least 8 characters"); }
if ( ! preg_match("/[a-z]/i", $_POST["password"])) { die("Password must contain at least one letter"); }
if ( ! preg_match("/[0-9]/", $_POST["password"])) { die("Password must contain at least one number"); }
if ($_POST["password"] !== $_POST["password_confirmation"]) { die("Passwords must match"); }

// 哈希新密码
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

// 更新密码，并将 reset_token 清空
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
<html>
<head>
    <title>Password Updated</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>Password Updated</h1>
    <p>Password updated successfully. You can now <a href="login.php">log in</a>.</p>
    <footer>
        <p>CISC3003 Web Programming: Seki Tomoki DC227171 2026</p>
    </footer>
</body>
</html>