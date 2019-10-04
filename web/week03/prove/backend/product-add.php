<?php
session_start();
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$qty = filter_input(INPUT_POST, 'qty', FILTER_VALIDATE_INT);

$status = 'OK';

if ($id === 0) {
    $status = 'FAIL';
    $message = 'Invalid product.';
} else {
    if ($qty === 0) {
        $status = 'FAIL';
        $message = 'Invalid product quantity.';
    }
}

if ($status === 'OK') {
    $_SESSION["product-id"] = $id;
    $_SESSION["product-qdy"] = $qty;
    $_SESSION["order-id"] = uniqid();
}

$response = [
    'status' => $status,
    'message' => $message
];
header('Content-Type: application/json');
echo json_encode($response);