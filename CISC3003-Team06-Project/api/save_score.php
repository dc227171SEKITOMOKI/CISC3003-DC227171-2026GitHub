<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

// 1. 检查是否登录
if (!isset($_SESSION["user_id"])) {
    echo json_encode(["success" => false, "message" => "Not logged in"]);
    exit;
}

// 2. 连接数据库 (使用相对路径找到你们原本的 database.php)
$mysqli = require __DIR__ . "/../php-account-activation-main/database.php";

// 3. 接收前端传来的 JSON 数据
$data = json_decode(file_get_contents('php://input'), true);
$score = $data['score'] ?? 0;
$level = $data['level'] ?? 1;

// 4. 安全机制：防止 Endless 模式超过 10 级导致外键报错
$db_level = min((int)$level, 10);

// 5. 插入数据库
$sql = "INSERT INTO game_records (user_id, level_id, score) VALUES (?, ?, ?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("iii", $_SESSION["user_id"], $db_level, $score);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Score saved!"]);
} else {
    echo json_encode(["success" => false, "message" => "Database error"]);
}