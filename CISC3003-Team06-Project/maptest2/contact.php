
<?php
session_start();

$user = null;

if (isset($_SESSION["user_id"])) {

    $mysqli = require __DIR__ . "/../php-account-activation-main/database.php";

    $sql = "SELECT * FROM user WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="zh-CN">

<head>

    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Contact Us - Train Puzzle</title>

    <link rel="stylesheet" href="style.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Coustard:wght@400;900&display=swap" rel="stylesheet">

    <style>

        body {
            display: block;
            overflow-y: auto;
            background: #252021;
            color: white;
            margin: 0;
            font-family: sans-serif;
        }

        .top-nav {
            position: absolute;
            top: 0;
            width: 100%;
            padding: 30px 5vw;
            box-sizing: border-box;
            display: flex;
            justify-content: flex-end;
            gap: 40px;
            z-index: 100;
            font-family: 'Coustard', serif;
        }

        .top-nav a {
            color: #e0e0e0;
            text-decoration: none;
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }

        .top-nav a:hover {
            color: #eb685b;
            text-shadow: 1px 1px 0px #1ea7a6;
        }

        .page-container {

            width: 500px;

            margin: 120px auto;

            padding: 40px;

            background: #2f2a2b;

            border-radius: 16px;

            box-sizing: border-box;
        }

        h2 {
            margin-top: 0;
        }

        input,
        textarea {

            width: 100%;

            padding: 12px;

            margin-top: 8px;

            margin-bottom: 20px;

            border: none;

            border-radius: 8px;

            box-sizing: border-box;

            font-size: 16px;
        }

        textarea {
            resize: vertical;
        }

        .btn {

            background: #eb685b;

            color: white;

            border: none;

            padding: 12px 24px;

            border-radius: 8px;

            cursor: pointer;

            font-size: 16px;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .welcome-user {
            color: #1ea7a6;
            font-size: 1.1rem;
            line-height: 1.1;
        }

    </style>

</head>

<body>

<nav class="top-nav">

    <a href="../maptest/index.php">Home</a>

    <a href="game.php">Game</a>

    <a href="leader.php">Leader Board</a>

    <a href="search.php">Search</a>

    <a href="#" style="color: #eb685b;">Contact Us</a>

    <?php if (isset($user)): ?>

        <span class="welcome-user">
            Welcome, <?= htmlspecialchars($user["name"]) ?>
        </span>

        <a href="../php-account-activation-main/logout.php">
            Logout
        </a>

    <?php else: ?>

        <a href="../php-account-activation-main/login.php">
            Login
        </a>

    <?php endif; ?>

</nav>

<div class="page-container">

    <h2>Contact Us</h2>

    <p style="color:#019897; margin-bottom:30px;">

        Have questions, feedback, or found a bug?
        Send us a message!

    </p>

    <form action="send_contents.php" method="POST">

        <label for="subject">
            Subject:
        </label>

        <input
            type="text"
            id="subject"
            name="subject"
            placeholder="Bug Report / Feedback"
            required
        >

        <label for="body">
            Message:
        </label>

        <textarea
            id="body"
            name="body"
            rows="8"
            placeholder="Write your comments here..."
            required
        ></textarea>

        <button type="submit" class="btn">
            Send Message
        </button>

    </form>

</div>

</body>

</html>

