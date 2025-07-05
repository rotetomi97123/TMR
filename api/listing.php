<?php
header('Content-Type: application/json');
require_once '../db_config.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
        exit;
    }

    $listing_type = $_POST['listing_type'] ?? '';
    $location = trim($_POST['location'] ?? '');
    $type = $_POST['type'] ?? '';
    $price_input = $_POST['rental_price'] ?? '';
    $square_meters = $_POST['square_meters'] ?? '';

    // Alapvető validáció
    if (empty($type) || empty($listing_type)) {
        echo json_encode([
            'success' => false,
            'error' => 'Type and listing type are required.'
        ]);
        exit;
    }

  
    // SQL alap
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
            COALESCE(pi.image_url, '') AS image_url,
            pd.size AS square_meters,
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
        WHERE pt.name = :type
          AND p.transaction = :listing_type
    ";

    $params = [
        ':type' => $type,
        ':listing_type' => $listing_type
    ];

    // Csak akkor szűrjünk városra, ha nem üres
    if (!empty($location)) {
        $sql .= " AND p.city LIKE :location ";
        $params[':location'] = '%' . $location . '%';
    }

    if ($price_input !== '' && $price_input > 0) {
        $sql .= " AND p.price <= :price ";
        $params[':price'] = $price_input;
    }

    if ($square_meters !== '' && $square_meters > 0) {
        $sql .= " AND pd.size >= :square_meters ";
        $params[':square_meters'] = $square_meters;
    }

    $sql .= " ORDER BY p.created_at DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $properties
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
