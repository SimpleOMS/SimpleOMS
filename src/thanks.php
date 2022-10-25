<?php
include 'init.php';
if (!isset($_GET['n'])) {
    exit;
}
$n = intval($_GET['n']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Thank You!</title>
    <style>
        @import url('fonts.css');

        * {
            font-family: 'DM Sans', sans-serif;
        }

        .button {
            padding: 10px 25px;
            border: 1px solid #E8E8E8;
            cursor: pointer;
            border-radius: 5px;
            background: white;
            font-size: 1em;
            text-decoration: none;
            color: black;
        }

        .button:hover,
        .button:focus {
            border: 1px solid #DBDBDB;
        }

        .button:active {
            border: 1px solid #DBDBDB;
            background: #DBDBDB;
        }

    </style>
</head>

<body>
    <h1>Your order number is #<?=$n?>!</h1>
    <h2>Your order has been placed!</h2>
    <h3>We'll let you know when your order is ready! Remember your order number!</h3>
    <a href="./" class="button">OK, Thanks!</a>
</body>

</html>
