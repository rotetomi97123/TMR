<?php
header('Content-Type: application/json');
require_once '../db_config.php';

if (!isset($_GET['property_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'No property_id provided']);
    exit;
}

$propertyId = $_GET['property_id'];

try {
    $sql = "
        SELECT 
            pi.image_id,
            pi.property_id,
            pi.image_url,
            pi.is_main
        FROM property_images pi
        WHERE pi.property_id = ?
        ORDER BY pi.is_main DESC
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$propertyId]);
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'count' => count($images),
        'data' => $images
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
