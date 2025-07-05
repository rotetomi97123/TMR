<?php

require_once '../db_config.php';

header('Content-Type: application/json');

try {
    // Fetch all unique property type names
    $stmt = $pdo->query("SELECT DISTINCT name FROM property_types WHERE name IS NOT NULL AND name != '' ORDER BY name ASC");
    $types = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo json_encode($types);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
