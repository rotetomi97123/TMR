<?php
require_once '../db_config.php';
session_start();

header('Content-Type: application/json');

// Check if admin is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Access denied']);
    exit;
}

// Read and validate input
$data = json_decode(file_get_contents('php://input'), true);
$property_id = (int)($data['id'] ?? 0);
$action = $data['action'] ?? '';

if (!$property_id || !in_array($action, ['activate', 'deactivate'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

// Determine new state
$new_status = ($action === 'activate') ? 1 : 0;

// Update DB
$stmt = $pdo->prepare("UPDATE properties SET is_active_property = ? WHERE property_id = ?");
if ($stmt->execute([$new_status, $property_id])) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
