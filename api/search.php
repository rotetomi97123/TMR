<?php
header('Content-Type: application/json');
session_start();

if (isset($_SESSION['city'])) {
  echo json_encode(['city' => $_SESSION['city']]);
  exit;
}
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$apiKey = $_ENV['OPENCAGE_API_KEY'];

$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['lat']) || !isset($input['lon'])) {
  echo json_encode(['error' => 'Missing coordinates']);
  http_response_code(400);
  exit;
}

$lat = $input['lat'];
$lon = $input['lon'];

$url = "https://api.opencagedata.com/geocode/v1/json?q={$lat}+{$lon}&key={$apiKey}";

$response = file_get_contents($url);
$data = json_decode($response, true);

$components = $data['results'][0]['components'] ?? [];
$city = $components['city'] ?? $components['town'] ?? $components['village'] ?? $components['state'] ?? 'Unknown';

$city = preg_replace('/\s*Municipality$/i', '', $city);

$_SESSION['city'] = $city;

echo json_encode(['city' => $city]);
