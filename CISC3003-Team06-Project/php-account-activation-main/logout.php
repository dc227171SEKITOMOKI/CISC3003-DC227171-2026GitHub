<?php
// 启动 session
session_start();

// 清空所有 session 变量
session_unset();

// 销毁 session
session_destroy();

// 登出后跳转回首页 (index.php)
header("Location: ../maptest/index.php");
exit;