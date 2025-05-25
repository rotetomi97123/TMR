<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

header('Content-Type: application/json');

if (!isset($_GET['q']) || trim($_GET['q']) === '') {
    echo json_encode([]);
    exit;
}

$query = trim($_GET['q']);

// Initialize session cache array if not set
if (!isset($_SESSION['autocomplete_cache'])) {
    $_SESSION['autocomplete_cache'] = [];
}

// If cached, return cached result immediately
if (isset($_SESSION['autocomplete_cache'][$query])) {
    echo json_encode($_SESSION['autocomplete_cache'][$query]);
    exit;
}

$apiKey = $_ENV['OPENCAGE_API_KEY'];

$url = "https://api.opencagedata.com/geocode/v1/json?"
     . "q=" . urlencode($query)
     . "&key={$apiKey}"
     . "&limit=5"
     . "&no_annotations=1"
     . "&language=en"
     . "&countrycode=RS";

$response = file_get_contents($url);
if ($response === false) {
    echo json_encode([]);
    exit;
}

$data = json_decode($response, true);

$cities = [];

if (!empty($data['results'])) {
    foreach ($data['results'] as $result) {
        $components = $result['components'];
        $city = $components['city'] ?? $components['town'] ?? $components['village'] ?? $components['state'] ?? null;

        if ($city) {
            $city = preg_replace('/\s*Municipality$/i', '', $city);
            if (!in_array($city, $cities)) {
                $cities[] = $city;
            }
        }
    }
}

// Save to session cache
$_SESSION['autocomplete_cache'][$query] = $cities;

echo json_encode($cities);
