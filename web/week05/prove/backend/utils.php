<?php
function orderNumItems($cart)
{
    $num = 0;
    foreach ($cart['items'] as $c) {
        $num += $c['qty'];
    }

    return $num;
}

function orderValue($cart)
{
    $total = 0;
    foreach ($cart['items'] as $c) {
        $total += $c['qty'] * $c['price'];
    }

    return $total;
}