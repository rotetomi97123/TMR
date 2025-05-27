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

    $location = isset($_POST['location']) ? trim($_POST['location']) : '';
    $type = isset($_POST['type']) ? trim($_POST['type']) : '';

    if (empty($location)) {
        echo json_encode([
            'success' => false,
            'error' => 'Location is required.'
        ]);
        exit;
    }

    if (empty($type)) {
        echo json_encode([
            'success' => false,
            'error' => 'Type is required.'
        ]);
        exit;
    }

    $stmt = $pdo->prepare("
        SELECT * FROM listings 
        WHERE status = 'approved' 
        AND is_visible = 1 
        AND city_area LIKE :location 
        AND property_type = :type
        ORDER BY created_at DESC
    ");

    $stmt->execute([
        ':location' => '%' . $location . '%',
        ':type' => $type
    ]);

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
