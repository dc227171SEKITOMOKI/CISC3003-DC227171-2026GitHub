<?php
session_start();

$user = null;
// 如果检测到 Session 里有 user_id，说明已登录
if (isset($_SESSION["user_id"])) {
    // 引入你们原来写好的 database.php
    $mysqli = require __DIR__ . "/../php-account-activation-main/database.php";
    
    // 去数据库查询当前用户的 name
    $sql = "SELECT * FROM user WHERE id = {$_SESSION["user_id"]}";
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="zh-CN">

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

    /* 恢复网页原生滚动，并调整排版使其变为标准两屏页面 */
    body {
        overflow-y: auto !important;
        overflow-x: hidden !important;
        display: block !important; /* 覆盖 style.css 里的 flex */
        background-color: #212121; /* 匹配暗色背景 */
        margin: 0;
    }
    /* 第一屏：标题和游戏水平排列 */
    .first-screen {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        width: 100vw;
        height: 100vh;
        position: relative;
        overflow: hidden; /* 防止背景方块溢出滚动条 */
    }
    
    /* 背景浮动方块动画特效 */
    .floating-blocks {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        margin: 0;
        padding: 0;
        z-index: 1; /* 保持在文字和游戏底下一层 */
    }
    .floating-blocks li {
        position: absolute;
        display: block;
        list-style: none;
        width: 20px;
        height: 20px;
        background: rgba(30, 167, 166, 0.15); /* 默认青灰色半透明 */
        animation: floatUp 25s linear infinite;
        bottom: -150px;
    }
    .floating-blocks li:nth-child(even) { background: rgba(235, 104, 91, 0.15); /* 偶数替换为珊瑚红 */ }
    .floating-blocks li:nth-child(1) { left: 10%; width: 80px; height: 80px; animation-delay: 0s; }
    .floating-blocks li:nth-child(2) { left: 25%; width: 30px; height: 30px; animation-delay: 2s; animation-duration: 12s; }
    .floating-blocks li:nth-child(3) { left: 35%; width: 50px; height: 50px; animation-delay: 4s; }
    .floating-blocks li:nth-child(4) { left: 50%; width: 90px; height: 90px; animation-delay: 0s; animation-duration: 18s; }
    .floating-blocks li:nth-child(5) { left: 65%; width: 40px; height: 40px; animation-delay: 0s; }
    .floating-blocks li:nth-child(6) { left: 75%; width: 110px; height: 110px; animation-delay: 3s; }
    .floating-blocks li:nth-child(7) { left: 85%; width: 150px; height: 150px; animation-delay: 7s; }
    .floating-blocks li:nth-child(8) { left: 95%; width: 25px; height: 25px; animation-delay: 15s; animation-duration: 45s; }
    .floating-blocks li:nth-child(9) { left: 15%; width: 15px; height: 15px; animation-delay: 2s; animation-duration: 35s; }
    .floating-blocks li:nth-child(10) { left: 42%; width: 65px; height: 65px; animation-delay: 0s; animation-duration: 11s; }

    @keyframes floatUp {
        0% { transform: translateY(0) rotate(0deg); opacity: 1; border-radius: 0; }
        100% { transform: translateY(-120vh) rotate(360deg); opacity: 0; border-radius: 20%; } /* 旋转上升并变圆角 */
    }

    .hero-section {
        width: 40%;
        padding-left: 5%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center; /* 居中对齐文字 */
        font-family: 'Coustard', serif;
        z-index: 10;
    }
    .hero-section h1 {
        font-size: 6vw; /* 响应式字体大小，稍微调大 */
        color: #eb685b; /* 提取游戏内的珊瑚红 */
        text-shadow: 4px 4px 0px #1ea7a6; /* 提取游戏内的青灰色 */
        margin: 0;
        text-align: center;
        line-height: 1.2;
    }
    .scroll-down {
        margin-top: 40px;
        font-size: 1.5rem;
        color: #fff;
        animation: bounce 2s infinite;
        font-family: 'Coustard', serif;
    }
    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
        40% { transform: translateY(-20px); }
        60% { transform: translateY(-10px); }
    }
    /* 修改游戏容器 */
    .canvas-container {
        position: relative !important;
        width: 60% !important;
        height: 100vh !important;
        display: flex;
        justify-content: center;
        align-items: center;
        top: 0 !important;
        left: 0 !important;
        transform: none !important;
        margin: 0 !important;
        z-index: 5;
    }
    /* 下拉第二屏游戏介绍样式 */
    .info-section {
        width: 100%;
        box-sizing: border-box;
        background-color: #2a2a2a; /* 比纯黑稍微亮一点的深灰，增加层次感 */
        padding: 100px 20px 120px;
        text-align: center;
        font-family: 'Coustard', serif;
    }
    .info-section h2 {
        font-size: 3rem;
        color: #eb685b;
        text-shadow: 2px 2px 0px #1ea7a6;
        margin-bottom: 30px;
    }
    .info-section h3 {
        font-size: 2rem;
        color: #1ea7a6;
        margin-top: 50px;
        margin-bottom: 20px;
    }
    .info-section p {
        max-width: 800px;
        margin: 0 auto;
        font-size: 1.25rem;
        line-height: 1.8;
        color: #e0e0e0;
        text-align: left;
    }
    .play-container {
        position: relative;
        display: inline-block;
        margin-top: 80px;
    }
    /* Play后面的向外辐射爆炸特效 */
    .explosion-blocks {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        z-index: 1;
        pointer-events: none;
    }
    .explosion-blocks div {
        position: absolute;
        width: 20px;
        height: 20px;
        background: rgba(30, 167, 166, 0.4); /* 青灰色 */
        border-radius: 3px;
        animation: explodeAnim 2.5s infinite cubic-bezier(0.1, 0.8, 0.3, 1);
        opacity: 0;
    }
    .explosion-blocks div:nth-child(even) { background: rgba(235, 104, 91, 0.4); /* 珊瑚红 */ }
    
    /* 8个不同方向和属性的方块 */
    .explosion-blocks div:nth-child(1) { --tx: -130px; --ty: -100px; --rot: 45deg; animation-delay: 0s; width: 30px; height: 30px; }
    .explosion-blocks div:nth-child(2) { --tx: 20px;   --ty: -140px; --rot: 90deg; animation-delay: 0.4s; width: 25px; height: 25px; }
    .explosion-blocks div:nth-child(3) { --tx: 140px;  --ty: -90px;  --rot: 135deg; animation-delay: 0.8s; width: 40px; height: 40px; }
    .explosion-blocks div:nth-child(4) { --tx: 160px;  --ty: 30px;   --rot: 180deg; animation-delay: 0.2s; width: 15px; height: 15px; }
    .explosion-blocks div:nth-child(5) { --tx: 120px;  --ty: 130px;  --rot: 225deg; animation-delay: 0.6s; width: 35px; height: 35px; }
    .explosion-blocks div:nth-child(6) { --tx: -10px;  --ty: 150px;  --rot: 270deg; animation-delay: 0.1s; width: 20px; height: 20px; }
    .explosion-blocks div:nth-child(7) { --tx: -140px; --ty: 100px;  --rot: 315deg; animation-delay: 0.7s; width: 45px; height: 45px; }
    .explosion-blocks div:nth-child(8) { --tx: -160px; --ty: -20px;  --rot: 360deg; animation-delay: 0.3s; width: 18px; height: 18px; }

    @keyframes explodeAnim {
        0% { transform: translate(-50%, -50%) scale(0) rotate(0deg); opacity: 1; }
        100% { transform: translate(calc(-50% + var(--tx)), calc(-50% + var(--ty))) scale(1) rotate(var(--rot)); opacity: 0; border-radius: 50%; }
    }

    .play-link {
        display: inline-block;
        position: relative;
        z-index: 10;
        font-size: 6rem;
        color: #eb685b;
        text-shadow: 4px 4px 0px #1ea7a6;
        text-decoration: none;
        font-family: 'Coustard', serif;
        font-weight: 900;
        transform: rotate(-8deg); /* 微微倾斜 */
        transition: transform 0.3s ease, color 0.3s ease;
    }
    .play-link:hover {
        transform: rotate(-3deg) scale(1.1); /* 鼠标悬停时稍微回正并放大 */
        color: #fff;
    }

    /* 页尾样式 */
    .footer {
        width: 100%;
        background-color: #1a1a1a;
        padding: 40px 5vw;
        box-sizing: border-box;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #333;
        font-family: 'Coustard', serif;
    }
    .footer-left {
        color: #888;
        font-size: 0.9rem;
    }
    .footer-nav {
        display: flex;
        gap: 30px;
    }
    .footer-nav a {
        color: #888;
        text-decoration: none;
        font-size: 0.9rem;
        transition: color 0.3s ease;
    }
    .footer-nav a:hover {
        color: #eb685b;
    }
  </style>
</head>
<body class="game game--loading">

  <!-- 顶部导航栏 -->
  <nav class="top-nav">
    <a href="#">Home</a>
    <a href="../maptest2/game.php">Game</a>
    <a href="../maptest2/leader.php">Leader Board</a>
    <a href="../maptest2/search.php">Search</a>
    <a href="../maptest2/contact.php">Contact Us</a>
    
    <?php if (isset($user)): ?>
        <span style="color: #1ea7a6; font-size: 1.1rem; line-height: 1.1;">Welcome, <?= htmlspecialchars($user["name"]) ?></span>
        <a href="../php-account-activation-main/logout.php">Logout</a>
    <?php else: ?>
        <a href="../php-account-activation-main/login.php">Login</a>
    <?php endif; ?>
  </nav>


  <!-- 首屏：标题与游戏动画水平并排 -->
  <div class="first-screen">
    <!-- 浮动方块背景特效 -->
    <ul class="floating-blocks">
      <li></li><li></li><li></li><li></li><li></li>
      <li></li><li></li><li></li><li></li><li></li>
    </ul>

    <div class="hero-section">
      <h1>TRAIN<br>PUZZLE<br>GAME</h1>
      <div class="scroll-down">SCROLL DOWN ⬇️</div>
    </div>
    
    <div class="canvas-container">
      <a class="btn" style="display: none;" onclick="finish()">Finished</a>
      <canvas width="1380" height="1380"></canvas>
    </div>
  </div>

  <!-- 下拉第二屏：游戏介绍 -->
  <div class="info-section">
    <h2>Welcome to Train Puzzle</h2>
    <p style="text-align: center;">Train Puzzle is a strategic track-routing challenge where your logical thinking and reflexes are put to the test. In this beautiful isometric miniature world, you are the ultimate railway architect!</p>
    
    <h3>How to Play 🚂</h3>
    <p>
      1. <strong>Connect the Tracks:</strong> Click or tap on the unaligned track tiles to rotate them and form a continuous, safe path.<br><br>
      2. <strong>Guide the Train:</strong> Think ahead! Keep the train moving smoothly to its destination without derailing or hitting dead ends.<br><br>
      3. <strong>Beat the Clock:</strong> The faster you route the train, the better your logical flow. Are you ready for the ultimate railway challenge?
    </p>

    <!-- 底部超大 Play 按钮及爆炸辐射特效 -->
    <div class="play-container">
      <div class="explosion-blocks">
        <div></div><div></div><div></div><div></div>
        <div></div><div></div><div></div><div></div>
      </div>
      <a href="../maptest2/game.php" class="play-link">Play?</a>
    </div>
  </div>

  <!-- 页尾 -->
  <footer class="footer">
    <div class="footer-left">
      cisc3003 web programing team 6 project
    </div>
    <nav class="footer-nav">
      <a href="#">Home</a>
      <a href="../maptest2/game.php">Game</a>
      <a href="../maptest2/leader.php">Leader Board</a>
      <a href="../maptest2/search.php">Search</a>
      <a href="../maptest2/contact.php">Contact Us</a>
    </nav>
  </footer>

  <div class="modal" style="display: none;">
    <div class="modal__content modal__main">
      <h2 class="modal__title">Train Puzzle</h2>
      <label>
        Difficulty
        <input type="range" min="1" max="100" value="25" oninput="setSpeed(this)">
      </label>
      <div class="modal__controls">
        <a class="btn" onclick="playLevel(false, false)">Play</a>
      </div>
    </div>

    <div class="modal__content modal__loading">
      <h2 class="modal__title">Train Puzzle</h2>
      <div class="modal__text">Loading...</div>
    </div>

    <div class="modal__content modal__gameover">
      <h2 class="modal__title">Game Over</h2>
      <div class="modal__controls">
        <a class="btn" onclick="gotoMenu()">Try again</a>
      </div>
    </div>

    <div class="modal__content modal__win">
      <h2 class="modal__title">Well done!</h2>
      <div class="modal__controls">
        <a class="btn" onclick="gotoMenu()">Thanks</a>
      </div>
    </div>
  </div>

  <script src="script.js"></script>
</body>
</html>
