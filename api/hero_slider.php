<?php
header('Content-Type: application/json');
require_once '../db_config.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            'success' => false,
            'error' => 'Invalid request method.'
        ]);
        exit;
    }

    $stmt = $pdo->prepare("
        SELECT * FROM listings 
        WHERE status = 'approved' 
        AND is_visible = 1 
        ORDER BY created_at DESC 
        LIMIT 3
    ");

    $stmt->execute();

    $listings = $stmt->fetchAll();

    echo json_encode([
        'success' => true,
        'data' => $listings
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
