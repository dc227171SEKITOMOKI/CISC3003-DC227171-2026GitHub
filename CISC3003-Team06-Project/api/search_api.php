<?php
header('Content-Type: application/json; charset=utf-8');

// 连接你真实的数据库 (引入你现成的 database.php)
$mysqli = require __DIR__ . "/../php-account-activation-main/database.php";

$type = $_GET['type'] ?? 'user';
$query = $_GET['q'] ?? '';
$searchTerm = "%" . $query . "%";
$results = [];

try {
    if ($type === 'user') {
        // 1. 搜索 user 表
        $sql = "SELECT name AS player_name, email, created_at FROM user WHERE name LIKE ? LIMIT 20";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) { $results[] = $row; }

    }  elseif ($type === 'history') {
        // 3. 搜索 game_records 表，并 JOIN 关联 user 表获取玩家名字
        $sql = "SELECT u.name AS player_name, g.level_id, g.score, g.played_at
                FROM game_records g 
                JOIN user u ON g.user_id = u.id 
                WHERE u.name LIKE ? 
                ORDER BY g.played_at DESC LIMIT 20";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($row = $res->fetch_assoc()) { $results[] = $row; }
    }

    echo json_encode(['success' => true, 'results' => $results]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Database query failed']);
}