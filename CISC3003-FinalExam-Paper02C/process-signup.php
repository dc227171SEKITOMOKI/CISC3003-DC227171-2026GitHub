<?php
if (empty($_POST["name"])) { die("Name is required"); }
if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) { die("Valid email is required"); }
if (strlen($_POST["password"]) < 8) { die("Password must be at least 8 characters"); }
if ( ! preg_match("/[a-z]/i", $_POST["password"])) { die("Password must contain at least one letter"); }
if ( ! preg_match("/[0-9]/", $_POST["password"])) { die("Password must contain at least one number"); }
if ($_POST["password"] !== $_POST["password_confirmation"]) { die("Passwords must match"); }

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

// 1. 生成激活令牌 (Token) 和它的哈希值
$activation_token = bin2hex(random_bytes(16));
$activation_token_hash = hash("sha256", $activation_token);

$mysqli = require __DIR__ . "/database.php";

// 2. 将数据和令牌哈希存入数据库
$sql = "INSERT INTO user (name, email, password_hash, account_activation_hash) VALUES (?, ?, ?, ?)";
$stmt = $mysqli->stmt_init();
if ( ! $stmt->prepare($sql)) { die("SQL error: " . $mysqli->error); }

$stmt->bind_param("ssss", $_POST["name"], $_POST["email"], $password_hash, $activation_token_hash);

if ($stmt->execute()) {
    
    require "php/Exception.php";
    require "php/PHPMailer.php";
    require "php/SMTP.php";
    
    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
    
    try {
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        $mail->Username = "sekitomoki20030219@gmail.com";
        $mail->Password = "tysbslinslsxurug";
        
        $mail->setFrom("sekitomoki20030219@gmail.com", "CISC3003 Account");
        $mail->addAddress($_POST["email"]);
        
        $mail->Subject = "Account Activation";
        
        $mail->Body = "Click here to activate your account: \n\n http://localhost/CISC3003-FinalExam-Paper02C/activate-account.php?token=$activation_token";
        
        $mail->send();
        
        header("Location: signup-success.html");
        exit;
    } catch (Exception $e) {
        die("Email could not be sent. Mailer error: {$mail->ErrorInfo}");
    }
    
} else {
    if ($mysqli->errno === 1062) { die("email already taken"); } else { die($mysqli->error . " " . $mysqli->errno); }
}