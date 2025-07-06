<?php
require_once '../db_config.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Access denied']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$user_id = (int)($data['id'] ?? 0);
$action = $data['action'] ?? '';

if (!$user_id || !in_array($action, ['activate', 'deactivate', 'delete'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

try {
    if ($action === 'delete') {
        $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);
    } else {
        $new_status = ($action === 'activate') ? 1 : 0;
        $stmt = $pdo->prepare("UPDATE users SET is_active = ? WHERE user_id = ?");
        $stmt->execute([$new_status, $user_id]);
    }

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
