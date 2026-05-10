<?php

$email = $_POST["email"];

$token = bin2hex(random_bytes(16));

$token_hash = hash("sha256", $token);

$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

$mysqli = require __DIR__ . "/database.php";

$sql = "UPDATE user
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE email = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("sss", $token_hash, $expiry, $email);

$stmt->execute();

if ($mysqli->affected_rows) {

    $mail = require __DIR__ . "/mailer.php";

    $mail->setFrom("j4858890@gmail.com");
    $mail->addAddress($email);
    $mail->Subject = "Password Reset";
    $mail->Body = <<<END

    Click <a href="http://cisc3003-team06-project-2026.site/php-account-activation-main/reset-password.php?token=$token">here</a> 
    to reset your password.

    END;

    try {

        $mail->send();

    } catch (Exception $e) {

        die("Message could not be sent. Mailer error: {$mail->ErrorInfo}");

    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Link Sent</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../web_template/style.css">
    <style>
        .login-header {
            margin-top: 40px;
        }
        .success-box {
            text-align: center;
            padding: 10px 0 20px 0;
        }
        .success-icon {
            font-size: 70px; /* 把表情调小一点点适应方框 */
            background-color: #ffffff; /* <-- 在这里修改底部的颜色！ */
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px auto;
            border: 2px solid #ffffff; /* 边框颜色 */
        }
        .success-text {
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: #333;
            font-weight: bold;
        }
        .success-subtext {
            font-size: 0.95rem;
            color: #666;
            margin-bottom: 30px;
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
                <h2>Email Sent!</h2>
            </div>
            
            <div class="success-box">
                <div class="success-icon">✉️</div>
                <div class="success-text">Message sent!</div>
                <div class="success-subtext">Please check your inbox <br> for the password reset link.</div>

                </a>
            </div>
        </div>
    </div>
</body>
</html>