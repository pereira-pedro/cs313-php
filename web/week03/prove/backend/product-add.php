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
    $productIndex = array_search($id, array_column($cart['items'], 'id'));
    var_dump(array_column($cart['items'], 'id'));
    // if not exists update quantity
    if ($productIndex !== false) {
        // remove if qty is 0
        if ($qty !== 0) {
            $cart['items'][$productIndex]['qty'] += $qty;
        } else {
            if (count($cart['items']) === 1) {
                unset($cart);
            } else {
                unset($cart['items'][$productIndex]);
            }
        }
    } else {
        array_push($cart['items'], [
            'id' => $id,
            'qty' => $qty,
            'price' => $product['price'],
            'title' => $product['title']
        ]);
    }

    if (isset($cart)) {
        $_SESSION['cart'] = $cart;
    }
}

$response = [
    'status' => $status,
    'message' => $message,
    'data' => orderNumItems($_SESSION['cart'])
];

header('Content-Type: application/json');
echo json_encode($response);