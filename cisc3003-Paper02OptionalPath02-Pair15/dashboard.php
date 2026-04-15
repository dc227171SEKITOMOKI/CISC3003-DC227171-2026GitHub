<?php
session_start();
include("connect.php");

// 检查用户是否已登录
if(!isset($_SESSION['user'])){
    header("Location: index.php");
    exit();
}

// 获取登录用户的详细信息
$email = $_SESSION['user']; 

$sql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

$name = $user["fullname"];
$ouremail = $user["email"];

echo "$name";
echo "$email";

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <nav class="navbar">
            <h2>Welcome, <span id="username">
            <?php echo htmlspecialchars($name); ?></span></h2>
            <a href="logout.php">
                <button id="logout" class="btn logout-btn">Logout <i class="fas fa-sign-out-alt"></i></button>
            </a>
        </nav>
        
        <div class="user-details">
            <img src="https://xsgames.co/randomusers/avatar.php?g=female" style="border-radius:8px;" alt="profile-picture"> <h3>Your Profile</h3>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <p><strong>Member Since:</strong> January 2023</p>
        </div>
    
        <div class="dashboard-actions">
            <button class="btn">Update Profile</button>
            <button class="btn">View Reports</button>
            <button class="btn">Settings</button>
        </div>
    </div> </body>
</html>