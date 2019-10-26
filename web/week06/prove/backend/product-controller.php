<?php
include_once 'utils.php';
include_once 'models/Product.php';

session_start();
$action = filter_input(INPUT_POST, 'action');

try {
    $model = new Product();

    $product = Utils::getPostObject($model);
    var_dump($product);

    switch ($action) {
        case 'save':
            if ($product->id === null || $product->id === false) {

                $model->create($product);
                $message = "Product '$product->title' was created.";
            } else {
                $model->update($product);
                $message = "Product '$product->title' was updated.";
            }
            break;
        case 'delete':
            $model->delete($product->id);
            $message = "Product '$product->title' was deleted.";
            break;
    }
    $response = [
        'status' => 'OK',
        'message' => $message
    ];
} catch (Exception $ex) {
    $response = [
        'status' => 'FAIL',
        'message' => $ex->getMessage()
    ];
}


header('Content-Type: application/json');
echo json_encode($response);