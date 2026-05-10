<?php
header('Content-Type: application/json; charset=utf-8');
$mysqli = require __DIR__ . "/../php-account-activation-main/database.php";

// SQL 逻辑：利用 GROUP_CONCAT 和 SUBSTRING_INDEX 强制让 level_id 匹配最高分
$sql = "SELECT u.name AS player_id, 
               SUBSTRING_INDEX(GROUP_CONCAT(g.level_id ORDER BY g.score DESC), ',', 1) AS level_id, 
               MAX(g.score) as score 
        FROM game_records g 
        JOIN user u ON g.user_id = u.id 
        GROUP BY g.user_id, u.name 
        ORDER BY score DESC 
        LIMIT 10";

$result = $mysqli->query($sql);
$leaderboard = [];
$rank = 1;

while ($row = $result->fetch_assoc()) {
    $leaderboard[] = [
        "rank" => $rank++,
        "player_id" => $row["player_id"],
        "level" => $row["level_id"],
        "score" => $row["score"]
    ];
}

echo json_encode($leaderboard);