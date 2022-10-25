<?php
$name = 'Ice Cream Truck';
$conn = mysqli_connect('localhost', 'root', 'root', 'oms');
$timePerOrder = 60; // In seconds


function randomNumber($length) {
    $result = '';
    for($i = 0; $i < $length; $i++) {
        $result .= mt_rand(1, 9);
    }
    return $result;
}