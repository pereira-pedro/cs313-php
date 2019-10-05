<?php
include_once 'utils.php';
session_start();
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$qty = filter_input(INPUT_POST, 'qty', FILTER_VALIDATE_INT);

$status = 'OK';

if ($status === 'OK' && $id === 0) {
    $status = 'FAIL';
    $message = 'Invalid product.';
}

if ($status === 'OK' && $qty === 0) {
    $status = 'FAIL';
    $message = 'Invalid product quantity.';
}

$product = getProduct($id);

if ($status === 'OK') {

    $cart = isset($_SESSION['cart']) ?
        $_SESSION['cart'] : [
            id => uniqid(),
            items => []
        ];

    array_push($cart['items'], [
        id => $id,
        qty => $qty,
        price => $price,
        title => $product['title']
    ]);

    $_SESSION['cart'] = $cart;
}

$response = [
    'status' => $status,
    'message' => $message,
    'data' => orderNumItems($_SESSION['cart'])
];

header('Content-Type: application/json');
echo json_encode($response);