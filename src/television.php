<?php
include 'init.php';
$res = $conn->query('SELECT * FROM request WHERE completed = 0 ORDER BY datetime DESC');
$num = intval(mysqli_num_rows($res));
$minutes = intval(gmdate('i', ($num * $timePerOrder) + $timePerOrder));
$unit = 'minutes';
if (intval($minutes) == 1) {
    $unit = 'minute';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Display View - <?=$name?></title>
    <meta http-equiv="refresh" content="5">
    <style>
        @import url('fonts.css');
        * {
            font-family: 'DM Sans', sans-serif;
            text-align: center;
            overflow: hidden;
        }
        .card {
            display: inline-block;
            border: 1px solid #E8E8E8;
            width: 200px;
            border-radius: 5px;
            margin: 15px 10px;
            max-width: 200px;
        }
        .card * {
            max-width: 200px;
            word-wrap: break-word;
        }
        .cards {
            margin: auto;
        }
    </style>
</head>
<body>
    <h1><?=$name?></h1>
    <h3>If you order now, you will be #<?=$num?> in line. The estimated wait time is <?=intval($minutes)?> <?=$unit?>.</h3>
    <div class="cards">
        <?php
        while ($row = mysqli_fetch_assoc($res)) {
            $names = explode(' ', $row['name']);
            $fname = substr($names[0], 0, 25);
            $lname = substr(end($names), 0, 1) . '.';
            if (end($names) == $names[0]) {
                $lname = '';
            }
            ?>
            <div class="card">
                <h2><?=$fname?> <?=$lname?></h2>
            </div>
            <?php
        }
        ?>
    </div>
</body>
</html>