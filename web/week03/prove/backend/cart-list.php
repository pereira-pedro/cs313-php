<?php
include_once 'utils.php';
session_start();

$cart = $_SESSION['cart'];

header('Content-Type: application/json');
echo json_encode([
    'status' => 'OK',
    'message' => '',
    'data' => [
        'cart' => $cart,
        'items' => orderNumItems($cart),
        'total' => orderValue($cart)
    ]
]);