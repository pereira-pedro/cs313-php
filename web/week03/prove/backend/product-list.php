<?php
// Get the contents of the JSON file 
$strJsonFileContents = file_get_contents("products.json");

// Convert to array 
$data = json_decode($strJsonFileContents, true);

$products = [
    'status' => 'OK',
    'message' => '',
    'data' => $data
];

header('Content-Type: application/json');
echo json_encode($products);
?>