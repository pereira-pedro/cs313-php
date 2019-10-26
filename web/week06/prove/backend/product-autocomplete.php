<?php
session_start();
include_once 'utils.php';
include_once 'models/Product.php';

$key = filter_input(INPUT_GET, 'key', FILTER_SANITIZE_STRING);

try {
    $model = new Product();

    $key = '%' . $key . '%';
    $data = $model->listAllTA($key);
    $result = [];

    foreach ($data as $row) {
        array_push($data, [
            'id' => $data->id,
            'name' => $data->title
        ]);
    }
} catch (PDOException $ex) {
    $result = [];
}


header('Content-Type: application/json');
echo json_encode($result);