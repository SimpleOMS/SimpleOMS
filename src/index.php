<?php
include 'init.php';
if (!empty($_POST['item']) && !empty($_POST['name'])) {
    $item = intval($_POST['item']);
    // Check if item exists
    if (mysqli_num_rows($conn->query('SELECT * FROM item WHERE id = ' . $item)) == 0) {
        die('Error: Item does not exist!');
        // Item doesn't exist
    } else {
        $ordernumber = strval(randomNumber(4));
        $iteminfo = mysqli_fetch_array($conn->query('SELECT * FROM item WHERE id = ' . $item));
        $name = trim($_POST['name']);
        $order = "Name: $name.
Item: $iteminfo[name].
Additions:
";
        // Continue to place order
        // Loop through possible additions
        $additions = '';
        foreach($_POST as $addition => $on) {
            if (strval(intval($addition)) == strval($addition)) {
                // It's an addition
                // Check if addition exists
                if (mysqli_num_rows($conn->query('SELECT * FROM addition WHERE id = ' . intval($addition))) == 0) {
                    // Addition doesn't exist
                } else {
                    // Continue to place addition
                    $additions .= mysqli_fetch_array($conn->query('SELECT * FROM addition WHERE id = ' . intval($addition)))['item'] . "\n";
                }
            }
            // Otherwise, it's not an addition!
        }
        $order .= $additions;
        if (empty(trim($additions))) {
            $order .= '(None)';
        }
        $stmt = $conn->prepare('INSERT INTO request (name, content, orderNumber) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $name, $order, $ordernumber);
        $stmt->execute();
        header('Location: thanks.php?n=' . $ordernumber);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?=$name?></title>
    <link rel="stylesheet" href="ns2.css">
    <link rel="stylesheet" href="pc.css">
    <style>
        @import url('fonts.css');

        * {
            font-family: 'DM Sans', sans-serif;
            outline: 0;
            transition: 0.125s;
            box-sizing: border-box;
        }

        select {
            display: none;
        }

        .list {
            max-height: 200px !important;
            overflow-y: scroll !important;
        }

        .pretty {
            display: block;
            margin-bottom: 15px;
        }

        .nice-select {
            display: block;
            margin-bottom: 15px;
            font-size: 1em;
        }

        label {
            font-size: 1em;
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
    <form method="post">
        <h1><?=$name?></h1>
        <script src="ns2.js"></script>
        <h2>Your name:</h2>
        <input type="text" name="name" required autofocus placeholder="John Doe">
        <h2>Select an Item:</h2>
        <select name="item" id="select" class="wide" required>
            <?php
        $c = 0;
        $items = $conn->query('SELECT * FROM item');
        while ($row = mysqli_fetch_assoc($items)):
        if ($c == 0) {
            ?>
            <option value="<?=intval($row['id'])?>" selected><?=htmlspecialchars($row['name'])?></option>
            <?php
        }
        ?>
            <option value="<?=intval($row['id'])?>"><?=htmlspecialchars($row['name'])?></option>
            <?php
    $c++;
        endwhile;
        ?>
        </select>
        <h2>Select Additions:</h2>
        <?php
    $additions = $conn->query('SELECT * FROM addition');
    while ($rw = mysqli_fetch_assoc($additions)):
    ?>
        <div class="pretty p-default p-curve">
            <input type="checkbox" name="<?=intval($rw['id'])?>">
            <div class="state">
                <label><?=htmlspecialchars($rw['item'])?></label>
            </div>
        </div>
        <?php
    endwhile;
    ?>
        <button type="submit">Place Order</button>
        <script>
            NiceSelect.bind(document.getElementById('select'), {
                searchable: true
            });

        </script>
    </form>
    <p><small>Powered by SimpleOMS.</small></p>
</body>

</html>
