<?php
header('Content-Type: application/json');
require_once '../db_config.php';

try {
    // Only accept POST requests
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            'success' => false,
            'error' => 'Invalid request method.'
        ]);
        exit;
    }

    // Get POST values safely
    $listing_type = isset($_POST['listing_type']) ? trim($_POST['listing_type']) : '';
    $location = isset($_POST['location']) ? trim($_POST['location']) : '';
    $type = isset($_POST['type']) ? trim($_POST['type']) : '';

    // Validate inputs
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

    if (empty($listing_type)) {
        echo json_encode([
            'success' => false,
            'error' => 'Listing type is required.'
        ]);
        exit;
    }

    // Prepare SQL with placeholders
    $stmt = $pdo->prepare("
        SELECT * FROM listings 
        WHERE status = 'approved' 
          AND is_visible = 1 
          AND city_area LIKE :location 
          AND property_type = :type
          AND listing_type = :listing_type
        ORDER BY created_at DESC
    ");

    // Execute statement with bound params
    $stmt->execute([
        ':location' => '%' . $location . '%',
        ':type' => $type,
        ':listing_type' => $listing_type
    ]);

    // Fetch all matched listings
    $listings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return JSON response with data
    echo json_encode([
        'success' => true,
        'data' => $listings
    ]);
} catch (Exception $e) {
    // Return error JSON on exception
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
