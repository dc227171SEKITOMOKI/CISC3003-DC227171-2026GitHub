<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user && $user["account_activation_hash"] === null) {
        
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: ../maptest/index.php");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../web_template/style.css">
    <style>
        .error-alert {
            background-color: #ff3333;
            color: white;
            padding: 10px;
            margin-bottom: 20px;
            border: 2px solid #000;
            font-weight: bold;
            text-align: center;
        }
        .back-btn {
            position: absolute;
            top: 30px;
            right: 30px;
            padding: 10px 20px;
            background-color: #eb685b;
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            border: 2px solid #000;
            box-shadow: 4px 4px 0px #000;
            transition: transform 0.2s, box-shadow 0.2s;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <a href="../maptest/index.php" class="back-btn">BACK TO HOME</a>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo">
                    <div class="logo-square"></div>
                </div>
                <h2>Sign In</h2>
                <p>Enter your credentials</p>
            </div>
            
            <?php if ($is_invalid): ?>
                <div class="error-alert">Invalid login credentials</div>
            <?php endif; ?>
            
            <form class="login-form" method="post" novalidate>
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email" required autocomplete="email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrapper password-wrapper">
                        <input type="password" id="password" name="password" required autocomplete="current-password">
                        <button type="button" class="password-toggle" id="passwordToggle" aria-label="Toggle password visibility">
                            <span class="toggle-text">SHOW</span>
                        </button>
                    </div>
                </div>

                <div class="form-options">
                    <div class="checkbox-wrapper">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember" class="checkbox-label">
                            <div class="checkbox-box"></div>
                            <span>Remember me</span>
                        </label>
                    </div>
                    <a href="forgot-password.php" class="forgot-link">Forgot password?</a>
                </div>

                <button type="submit" class="login-btn">
                    <span class="btn-text">SIGN IN</span>
                </button>
            </form>

            <div class="divider">
                <span>OR</span>
            </div>

            <div class="social-login">
                <button type="button" class="social-btn">
                    <span class="social-text">GOOGLE</span>
                </button>
                <button type="button" class="social-btn">
                    <span class="social-text">GITHUB</span>
                </button>
            </div>

            <div class="signup-link">
                <span>No account? </span>
                <a href="signup.html">CREATE ONE</a>
            </div>
        </div>
    </div>

    <!-- 仅保留密码显示切换，移除阻止原生表单提交的 JS -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const passwordInput = document.getElementById('password');
            const passwordToggle = document.getElementById('passwordToggle');
            
            if (passwordToggle && passwordInput) {
                passwordToggle.addEventListener('click', () => {
                    const type = passwordInput.type === 'password' ? 'text' : 'password';
                    passwordInput.type = type;
                    
                    const toggleText = passwordToggle.querySelector('.toggle-text');
                    if (toggleText) {
                        toggleText.textContent = type === 'password' ? 'SHOW' : 'HIDE';
                    }
                });
            }
        });
    </script>
</body>
</html>








