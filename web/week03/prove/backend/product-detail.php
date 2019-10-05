<?php
include_once 'utils.php';
session_start();
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

$status = 'OK';
$message = '';

if ($id === 0) {
    $status = 'FAIL';
    $message = 'Invalid product.';
}

if ($status === 'OK') {

    $product = getProduct($id);
}

$response = [
    'status' => $status,
    'message' => $message,
    'data' => $product
];

header('Content-Type: application/json');
echo json_encode($response);