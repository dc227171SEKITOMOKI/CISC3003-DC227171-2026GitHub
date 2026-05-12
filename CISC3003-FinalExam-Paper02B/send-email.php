<?php

$name = $_POST["name"];
$email = $_POST["email"];
$subject = $_POST["subject"];
$message = $_POST["message"];

require 'php/Exception.php';
require 'php/PHPMailer.php';
require 'php/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);


// $mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = "smtp.gmail.com";
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;

$mail->Username = "sekitomoki20030219@gmail.com";
$mail->Password = "tysbslinslsxurug";

$mail->setFrom("sekitomoki20030219@gmail.com", "CISC3003 Form");
$mail->addReplyTo($email, $name);
$mail->addAddress("sekitomoki20030219@gmail.com", "Seki Tomoki");

$mail->Subject = $subject;
$mail->Body = $message;

$mail->send();

header("Location: sent.html");
exit;