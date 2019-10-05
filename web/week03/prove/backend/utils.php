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