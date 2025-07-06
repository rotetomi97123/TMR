<?php
require_once '../db_config.php';
session_start();

header('Content-Type: application/json');

// Check if admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Access denied']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$property_id = (int)($data['id'] ?? 0);

if (!$property_id) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid property ID']);
    exit;
}

// Optional: delete related images/details if needed
$pdo->prepare("DELETE FROM property_images WHERE property_id = ?")->execute([$property_id]);
$pdo->prepare("DELETE FROM property_details WHERE property_id = ?")->execute([$property_id]);

$stmt = $pdo->prepare("DELETE FROM properties WHERE property_id = ?");
if ($stmt->execute([$property_id])) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Could not delete']);
}
