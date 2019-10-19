<?php
include_once 'Product.php';
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

try {


    if ($id === 0) {
        throw new Exception('Invalid product.');
    }

    $products = new Product();

    $response = [
        'status' => 'OK',
        'message' => '',
        'data' => $products->getDetails($id)
    ];
} catch (Exception $ex) {
    $response = [
        'status' => 'FAIL',
        'message' => $ex->getMessage(),
        'data' => ''
    ];
}

header('Content-Type: application/json');
echo json_encode($response);