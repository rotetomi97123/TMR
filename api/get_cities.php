<?php

require_once '../db_config.php';

header('Content-Type: application/json');

$stmt = $pdo->query("SELECT DISTINCT city_area FROM listings WHERE city_area IS NOT NULL AND city_area != '' ORDER BY city_area ASC");
$cities = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo json_encode($cities);