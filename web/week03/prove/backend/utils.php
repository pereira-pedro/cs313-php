<?php
function orderNumItems($cart)
{
    $total = 0;
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