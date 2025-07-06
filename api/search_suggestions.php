<?php
$suggestions = ["Novi sad", "House", "Office", "Villa", "Garage"];
$q = strtolower($_GET['q'] ?? '');

$matches = array_filter($suggestions, function ($item) use ($q) {
  return strpos(strtolower($item), $q) === 0;
});

echo json_encode(array_values($matches));
