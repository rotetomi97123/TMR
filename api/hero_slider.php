<?php
header('Content-Type: application/json');
require_once '../db_config.php';

try {
    // Make sure it's a POST request
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            'success' => false,
            'error' => 'Invalid request method.'
        ]);
        exit;
    }

    // Prepare SQL to get first 4 approved and visible listings
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
