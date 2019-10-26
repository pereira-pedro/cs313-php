<?php
session_start();
include_once 'utils.php';
include_once 'models/Product.php';

$key = filter_input(INPUT_GET, 'key', FILTER_SANITIZE_STRING);

try {
    $model = new Product();

    $key = '%' . $key . '%';
    $result = $products->listAll($key);
} catch (PDOException $ex) {
    $result = [];
}


header('Content-Type: application/json');
echo json_encode($result);