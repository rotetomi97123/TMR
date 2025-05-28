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
    $rental_price_input = isset($_POST['rental_price']) ? trim($_POST['rental_price']) : '';
    $square_meters = isset($_POST['square_meters']) ? trim($_POST['square_meters']) : '';

    // Validate required inputs
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

    // Exchange rate: 1 EUR = 117 RSD (adjust as needed)
    $exchangeRate = 117;

    // Convert rental_price from EUR input to RSD for filtering, applying rounding logic
    $rental_price_rsd = '';
    if ($rental_price_input !== '') {
        $priceEUR = floatval($rental_price_input);

        if ($listing_type === 'rent') {
            // For rent: JS rounds UP to nearest 50 EUR
            // So on input, round DOWN to nearest 50 EUR to invert that logic
            $roundedEUR = floor($priceEUR / 50) * 50;
            $rental_price_rsd = $roundedEUR * $exchangeRate;
        } else {
            // For sale or other types: JS rounds DOWN to nearest 1000 EUR
            // So on input, round UP to nearest 1000 EUR to invert
            $roundedEUR = ceil($priceEUR / 1000) * 1000;
            $rental_price_rsd = $roundedEUR * $exchangeRate;
        }
    }

    // Prepare base SQL query
    $sql = "
        SELECT * FROM listings 
        WHERE status = 'approved' 
          AND is_visible = 1 
          AND city_area LIKE :location 
          AND property_type = :type
          AND listing_type = :listing_type
    ";

    $params = [
        ':location' => '%' . $location . '%',
        ':type' => $type,
        ':listing_type' => $listing_type
    ];

    // Add rental_price filter if set
    if ($rental_price_rsd !== '' && $rental_price_rsd > 0) {
        $sql .= " AND rental_price <= :rental_price ";
        $params[':rental_price'] = $rental_price_rsd;
    }
    if ($square_meters !== '' && $square_meters > 0) 
    {
        $sql .= " AND square_meters >= :square_meters ";
        $params[':square_meters'] = $square_meters;
    }

    $sql .= " ORDER BY created_at DESC";

    // Prepare and execute statement
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

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
