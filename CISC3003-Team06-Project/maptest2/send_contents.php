<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: contact.php");
    exit();
}

// ===== 你的原始输入逻辑（不改）=====
$subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
$message = isset($_POST['body']) ? trim($_POST['body']) : '';

if (empty($subject) || empty($message)) {
    die("Subject or message cannot be empty.");
}

// ===== PHPMailer =====
$mail = new PHPMailer(true);

try {

    // SMTP 设置（Gmail）
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;

    // 🔴 改成你的 Gmail
    $mail->Username = 'uriel34825@gmail.com';

    // 🔴 Gmail App Password（16位）
    $mail->Password = 'pzwf ewyo mtim osof';

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->CharSet = 'UTF-8';

    // ===== 邮件信息 =====
    $mail->setFrom('uriel34825@gmail.com', 'Train Puzzle Game');

    $mail->addAddress('uriel341031@gmail.com');

    $mail->Subject = "[Train Puzzle Feedback] " . $subject;

    $mail->Body =
"New feedback received from Train Puzzle\n\n" .
"Subject: $subject\n\n" .
"Message:\n$message";

    // ===== 发送 =====
    $mail->send();

    // ===== 成功（不改你UI结构，只是输出）=====
    echo "
    <div style='text-align:center; margin-top:100px; font-family:sans-serif; color:#019897;'>
        <h2>Thank You!</h2>
        <p>Your feedback has been sent successfully.</p>
        <a href='contact.php' style='color:#eb685b;'>Go Back</a>
    </div>
    ";

} catch (Exception $e) {

    // ===== 失败 =====
    echo "
    <div style='text-align:center; margin-top:100px; font-family:sans-serif; color:red;'>
        <h2>Send Failed</h2>
        <p>{$mail->ErrorInfo}</p>
        <a href='contact.php' style='color:#eb685b;'>Try Again</a>
    </div>
    ";
}
?>