<?php
session_start();
include_once 'utils.php';
include_once 'models/Product.php';
$cart = $_SESSION['cart'];

$key = filter_input(INPUT_POST, 'key', FILTER_SANITIZE_STRING);

try {
    $products = new Product();

    $data = $products->listProducts($key);

    $result = [
        'status' => 'OK',
        'message' => '',
        'data' => [
            'products' => $data,
            'cart' => [
                'cart' => $cart,
                'items' => orderNumItems($cart),
                'total' => orderValue($cart)
            ],
            'key' => $key
        ]
    ];
} catch (PDOException $ex) {
    $result = [
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
    ];
}


header('Content-Type: application/json');
echo json_encode($result);