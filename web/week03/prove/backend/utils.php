<?php
function orderNumItems($cart)
{
    $total = 0;
    foreach ($cart['items'] as $c) {
        $total += $c['qty'];
    }

    return $total;
}

function orderValue($cart)
{
    $total = 0;
    foreach ($cart['items'] as $c) {
        $total += $c['qty'] * $c['price'];
    }
}

function getProduct($id)
{
    // Get the contents of the JSON file 
    $strJsonFileContents = file_get_contents("products.json");

    // Convert to array 
    $data = json_decode($strJsonFileContents, true);

    return $data[array_search($id, array_column($data, 'id'))];
}

function findProductInCart($id, $cart)
{
    return array_search($id, array_column($cart, 'id'));
}