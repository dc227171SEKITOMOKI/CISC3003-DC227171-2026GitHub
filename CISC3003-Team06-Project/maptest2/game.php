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
  <title>Train Puzzle</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Coustard:wght@400;900&display=swap" rel="stylesheet">
  <style>
    /* 顶部导航栏样式 */
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
        color: #eb685b; /* 珊瑚红，游戏中提取的颜色 */
        text-shadow: 1px 1px 0px #1ea7a6;
    }
  </style>
</head>
<body class="game game--loading">

  <!-- 顶部导航栏 -->
  <nav class="top-nav">
    <a href="../maptest/index.php">Home</a>
    <a href="#">Game</a>
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

  <div class="canvas-container">
    <a class="btn" style="left: 5%; right: auto;" onclick="location.reload()">Reset</a>
    <a class="btn" onclick="finish()">Finished</a>
    <div class="level-indicator" id="levelIndicator">Level 1</div>
    <div class="score-indicator" id="scoreIndicator">Score 0</div>
    <canvas width="1380" height="1380"></canvas>
  </div>

  <div class="modal">
    <div class="modal__content modal__main">
      <h2 class="modal__title">Train Puzzle</h2>
      <label class="modal__label">
        Difficulty
        <input type="range" min="1" max="100" value="25" oninput="setSpeed(this)">
      </label>
      <div class="modal__controls modal__controls--stack">
        <a class="btn btn--wide" onclick="showLevelSelect()">Start</a>
        <a class="btn btn--wide" onclick="showRanking()">Ranking</a>
      </div>
    </div>

    <div class="modal__content modal__levels">
      <h2 class="modal__title">Select Level</h2>
      <div class="modal__level-grid">
        <a class="btn btn--level" onclick="startSelectedLevel(1)">1</a>
        <a class="btn btn--level" onclick="startSelectedLevel(2)">2</a>
        <a class="btn btn--level" onclick="startSelectedLevel(3)">3</a>
        <a class="btn btn--level" onclick="startSelectedLevel(4)">4</a>
        <a class="btn btn--level" onclick="startSelectedLevel(5)">5</a>
        <a class="btn btn--level" onclick="startSelectedLevel(6)">6</a>
        <a class="btn btn--level" onclick="startSelectedLevel(7)">7</a>
        <a class="btn btn--level" onclick="startSelectedLevel(8)">8</a>
        <a class="btn btn--level" onclick="startSelectedLevel(9)">9</a>
        <a class="btn btn--level" onclick="startSelectedLevel(10)">10</a>
      </div>
      <div class="modal__controls modal__controls--stack">
        <a class="btn btn--wide" onclick="startEndlessMode()">Endless</a>
        <a class="btn btn--wide" onclick="showMainMenu()">Back</a>
      </div>
    </div>

    <div class="modal__content modal__ranking">
      <h2 class="modal__title">Ranking</h2>
      <div class="ranking-panel">
        <div class="ranking-header">
          <span>ID</span>
          <span>Level</span>
          <span>Score</span>
        </div>
        <div id="rankingList" class="ranking-list"></div>
      </div>
      <div class="modal__controls modal__controls--stack">
        <a class="btn btn--wide" onclick="showMainMenu()">Back</a>
      </div>
    </div>

    <div class="modal__content modal__loading">
      <h2 class="modal__title">Train Puzzle</h2>
      <div class="modal__text">Loading...</div>
    </div>

    <div class="modal__content modal__gameover">
      <h2 class="modal__title">Game Over</h2>
      <div class="modal__text" id="gameOverText"></div>
      <div class="modal__controls">
        <a class="btn btn--wide" id="tryAgainBtn" href="javascript:void(0)">Try again</a>
      </div>
    </div>

    <div class="modal__content modal__win">
  <h2 class="modal__title">Well done!</h2>
  <div class="modal__controls">
    <a class="btn btn--wide" onclick="handleNextLevelClick()">Next Level</a>
  </div>
</div>
  </div>
  <script src="api.js"></script>
  <script src="script.js"></script>
</body>
</html>
