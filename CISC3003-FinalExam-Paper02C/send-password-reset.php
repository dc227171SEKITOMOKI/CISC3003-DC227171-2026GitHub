<?php
$email = $_POST["email"];

// 生成重置 Token 和它的哈希值
$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);

// 设置过期时间（例如 30 分钟后）
$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

$mysqli = require __DIR__ . "/database.php";

// 将 Token 存入对应用户的数据库记录中
$sql = "UPDATE user
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE email = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sss", $token_hash, $expiry, $email);
$stmt->execute();

// 如果找到了该邮箱对应的用户，就发送邮件
if ($mysqli->affected_rows) {
    
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
        
        // ⚠️ 请填入你测试成功的 Gmail 账号和 16 位专用密码
        $mail->Username = "sekitomoki20030219@gmail.com";
        $mail->Password = "tysbslinslsxurug";
        
        $mail->setFrom("sekitomoki20030219@gmail.com", "CISC3003 Account");
        $mail->addAddress($email);
        $mail->Subject = "Password Reset";
        
        // ⚠️ 确保这个 URL 路径和你电脑上的真实文件夹路径一致
        $mail->Body = "Click here to reset your password: \n\n http://localhost/CISC3003-FinalExam-Paper02C/reset-password.php?token=$token";

        $mail->send();
    } catch (Exception $e) {
        die("Message could not be sent. Mailer error: {$mail->ErrorInfo}");
    }
}

// 无论邮箱是否存在，都显示这句话（防止黑客通过提示探测注册邮箱）
echo "Message sent, please check your inbox.";