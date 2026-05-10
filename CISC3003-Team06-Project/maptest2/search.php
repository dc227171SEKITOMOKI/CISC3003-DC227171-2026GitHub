<?php
session_start();

$user = null;
if (isset($_SESSION["user_id"])) {
    // 因为 maptest2 和 php-account-activation-main 是平级目录，所以路径是 ../
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
  <title>Search - Train Puzzle</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Coustard:wght@400;900&display=swap" rel="stylesheet">
  <style>
    /* 顶部导航栏专属样式 */
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
    body {
        display: block; 
        overflow-y: auto; 
    }
  </style>
</head>
<body>

  <nav class="top-nav">
    <a href="../maptest/index.php">Home</a>
    <a href="game.php">Game</a>
    <a href="leader.php">Leader Board</a>
    <a href="search.php">Search</a>
    <a href="contact.php">Contact Us</a>
    <?php if (isset($user)): ?>
        <span style="color: #1ea7a6; font-size: 1.1rem; line-height: 1.1;">Welcome, <?= htmlspecialchars($user["name"]) ?></span>
        <a href="../php-account-activation-main/logout.php">Logout</a>
    <?php else: ?>
        <a href="../php-account-activation-main/login.php">Login</a>
    <?php endif; ?>
  </nav>

  <div class="page-container">
    <h2>Data Center</h2>
    <p style="color: #019897; margin-bottom: 30px;">Search for top players or puzzle levels.</p>
    
    <div class="search-console">
        <select id="searchTypeSelect" class="search-input">
        <option value="user">User Records</option>
        <option value="history">Gameplay History</option> 
    </select>
        <input type="text" id="searchInput" class="search-input" placeholder="Enter name..." autocomplete="off">
    </div>

    <div id="searchResults" class="search-results-box">
        <p style="color: rgba(216, 209, 198, 0.5);">Start typing to see results...</p>
    </div>
  </div>

  <script src="api.js"></script>
  
  <script>
    document.addEventListener("DOMContentLoaded", () => {
        const searchInput = document.getElementById('searchInput');
        const searchTypeSelect = document.getElementById('searchTypeSelect');

        if (searchInput) {
            searchInput.addEventListener('input', handleSearchInput);
        }

        if (searchTypeSelect) {
            searchTypeSelect.addEventListener('change', () => {
                searchInput.value = '';
                document.getElementById('searchResults').innerHTML = '<p style="color: rgba(216, 209, 198, 0.5);">Start typing to see results...</p>';
            });
        }
    });
  </script>
</body>
</html>