<?php
session_start();
include_once 'utils.php';
include_once 'models/Product.php';
$cart = $_SESSION['cart'];

$key = filter_input(INPUT_POST, 'key', FILTER_SANITIZE_STRING);

$result = [];

try {
    $products = new Product();

    $data = $products->listProducts($key);

    array_push($result, [
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
    ]);
} catch (PDOException $ex) {
    array_push($result, [
        'status' => 'FAIL',
        'message' => 'DB Error: ' . $ex->getMessage(),
        'data' => [
            'products' => '',
            'cart' => [
                'cart' => $cart,
                'items' => orderNumItems($cart),
                'total' => orderValue($cart)
            ]
        ]
    ]);
}


header('Content-Type: application/json');
echo json_encode($result);