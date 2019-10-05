<?php
function orderNumItems($cart)
{
    $total = 0;
    var_dump(array_column($cart['items'], 'qty'));
    foreach (array_column($cart['items'], 'qty') as $c) {
        $total += $c;
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