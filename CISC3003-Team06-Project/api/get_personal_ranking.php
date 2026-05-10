<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION["user_id"])) {
    echo json_encode([]);
    exit;
}

$mysqli = require __DIR__ . "/../php-account-activation-main/database.php";

$sql = "SELECT level_id as level, score 
        FROM game_records 
        WHERE user_id = ? 
        ORDER BY played_at DESC 
        LIMIT 10";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();
$result = $stmt->get_result();

$history = [];
while ($row = $result->fetch_assoc()) {
    $history[] = [
        "id" => "Me", 
        "level" => $row["level"],
        "score" => $row["score"]
    ];
}

echo json_encode($history);