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

                $id = $model->create($product);
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
        case 'retrieve':
            $data = $model->retrieve($product->id);
            $id = $product->id;
            break;
    }
    $response = [
        'status' => 'OK',
        'message' => $message,
        'id' => $id,
        'data' => $data
    ];
} catch (Exception $ex) {
    $response = [
        'status' => 'FAIL',
        'message' => $ex->getMessage(),
        'id' => '',
        'data' => ''
    ];
}


header('Content-Type: application/json');
echo json_encode($response);