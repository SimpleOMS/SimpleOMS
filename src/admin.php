<?php
include 'init.php';
if (isset($_POST['done_id'])) {
    $id = intval($_POST['done_id']);
    $conn->query('UPDATE request SET completed = 1 WHERE id = ' . $id);
    header('Location: admin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Orders - <?=$name?></title>
    <style>
        @import url('fonts.css');
        * {
            font-family: 'DM Sans', sans-serif;
        }
        button {
            padding: 10px 25px;
            border: 1px solid #E8E8E8;
            cursor: pointer;
            border-radius: 5px;
            background: white;
            font-size: 1em;
        }
        
        input {
            padding: 10px 25px;
            border: 1px solid #E8E8E8;
            border-radius: 5px;
            background: white;
            font-size: 1em;
            width: 100%;
        }

        button:hover, button:focus, input:focus {
            border: 1px solid #DBDBDB;
        }

        button:active {
            border: 1px solid #DBDBDB;
            background: #DBDBDB;
        }
    </style>
</head>
<body>
    <h1>Orders</h1>
<?php
    if (mysqli_num_rows($conn->query('SELECT * FROM request WHERE completed = 0 ORDER BY datetime LIMIT 1')) == 0) {
    ?>
    <h2>Relax, no orders right now!</h2>
    <script>
                    setTimeout(function() {
                        window.location.href = window.location.href;
                    }, 5000);
                </script>
    <?php
} else {
$row = mysqli_fetch_array($conn->query('SELECT * FROM request WHERE completed = 0 ORDER BY datetime LIMIT 1'));
?>
    <h3>Showing oldest non-completed order.</h3>
    <h2>Name: <?=htmlspecialchars($row['name'])?>. Number #<?=htmlspecialchars($row['orderNumber'])?>.</h2>
    <div><?=nl2br(htmlspecialchars($row['content']))?></div>
    <form method="post">
        <input type="hidden" name="done_id" value="<?=intval($row['id'])?>">
        <h3>Make sure to let <?=htmlspecialchars($row['name'])?> (#<?=htmlspecialchars($row['orderNumber'])?>) know that their order is ready before marking as done.</h3>
        <button class="button">Mark as Done</button>
    </form>
    <?php
    }
        ?>
</body>
</html>