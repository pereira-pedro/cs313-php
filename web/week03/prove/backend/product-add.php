<?php
include_once 'utils.php';
session_start();
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$qty = filter_input(INPUT_POST, 'qty', FILTER_VALIDATE_INT);

$status = 'OK';
$message = '';

if ($id === 0) {
    $status = 'FAIL';
    $message = 'Invalid product.';
}

if ($status === 'OK') {

    $product = getProduct($id);

    $cart = isset($_SESSION['cart']) ?
        $_SESSION['cart'] : [
            'id' => uniqid(),
            'items' => []
        ];

    // search if product already exists in cart
    $productIndex = array_search($id, array_column($cart['items'], 'id', true));

    // if exists update quantity
    if ($productIndex === false) {
        array_push($cart['items'], [
            'id' => $id,
            'qty' => $qty,
            'price' => $product['price'],
            'title' => $product['title']
        ]);
    } else {
        // remove if qty is 0
        if ($qty !== 0) {
            $cart['items'][$productIndex]['qty'] += $qty;
        } else {
            unset($cart['items'][$productIndex]);
        }
    }

    if (count($cart['items']) === 0) {
        unset($cart);
        unset($_SESSION['cart']);
    }

    if (isset($cart)) {
        $_SESSION['cart'] = $cart;
    }
}

$response = [
    'status' => $status,
    'message' => $message,
    'data' => [
        cart => $_SESSION['cart'],
        items => orderNumItems($_SESSION['cart']),
        total => orderValue($_SESSION['cart'])
    ],
    'orig' => $cart
];

header('Content-Type: application/json');
echo json_encode($response);