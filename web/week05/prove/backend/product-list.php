<?php
session_start();
include_once 'utils.php';
$cart = $_SESSION['cart'];

// Get the contents of the JSON file 
$strJsonFileContents = file_get_contents("products.json");

// Convert to array 
$data = json_decode($strJsonFileContents, true);

$products = [
    'status' => 'OK',
    'message' => '',
    'data' => [
        'products' => $data,
        'cart' => [
            'cart' => $cart,
            'items' => orderNumItems($cart),
            'total' => orderValue($cart)
        ]
    ]
];

header('Content-Type: application/json');
echo json_encode($products);