<?php
function itemsInCart($cart)
{
    $total = 0;
    foreach ($cart['items'] as $c) {
        $total += $c->qty;
    }

    return $total;
}