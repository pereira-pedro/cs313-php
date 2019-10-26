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

class Utils
{
    static function array2object($array)
    {
        $object = new stdClass();
        foreach ($array as $key => $value) {
            $object->$key = $value;
        }
        return $object;
    }

    static function getPostObject($entity)
    {
        return array2object(filter_input_array(INPUT_POST, $entity->getDefinition(), true));
    }
}