<?php

function randomStr($n)
{
    $characters = 'abcdefghijklmnopqrstuvwxzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $string = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $string .= $characters[$index];
    }
    return $string;
}