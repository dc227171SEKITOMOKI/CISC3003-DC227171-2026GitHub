<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../web_template/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo">
                    <div class="logo-square"></div>
                </div>
                <h2>Forgot Password</h2>
                <p>Enter your email to reset</p>
            </div>

            <form method="post" action="send-password-reset.php" class="login-form">
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-wrapper">
                        <input type="email" name="email" id="email" required>
                    </div>
                </div>

                <button type="submit" class="login-btn" style="margin-top: 20px;">
                    <span class="btn-text">SEND LINK</span>
                </button>
            </form>

            <div class="signup-link">
                <span>Remember your password? </span>
                <a href="login.php">SIGN IN</a>
            </div>
        </div>
    </div>
</body>
</html>