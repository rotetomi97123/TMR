<?php
header('Content-Type: application/json');

// Include DB config (must return $pdo as a PDO connection)
require_once '../db_config.php';

try {
    // SQL: Get first 3 properties with type, main image, and details
    $sql = "
        SELECT 
            p.property_id,
            p.title,
            p.description,
            p.address,
            p.city,
            p.zip_code,
            pt.name AS property_type,
            p.transaction,
            p.price,
            p.available_from,
            p.created_at,
            pi.image_url,
            pd.size,
            pd.rooms,
            pd.floor,
            pd.furnished,
            pd.heating_type,
            pd.parking,
            pd.beds,
            pd.bathroom
        FROM properties p
        JOIN property_types pt ON p.property_type_id = pt.property_type_id
        LEFT JOIN property_images pi ON p.property_id = pi.property_id AND pi.is_main = 1
        LEFT JOIN property_details pd ON p.property_id = pd.property_id
        ORDER BY p.created_at DESC
        LIMIT 6
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'count' => count($properties),
        'data' => $properties
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
