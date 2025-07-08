<?php
require_once 'classes/Server.php';

$result = "";

$server = new Server();
$data = $server->feedbacked_data($_GET['request_id']);
$output ="";

if (isset($_POST['cancel'])) {
    $rate = $server->cancel_request($_POST);
}

if (isset($_POST['agree'])) {
    $output = $server->confirm_feedback($_POST);
}
?>
<html>

<head>

</head>
<body>
<a href="<?= $_GET['url'] ?>" style="float: right">GO BACK</a>
<?= $output; ?>
<br>
<center>
    <table border="1">
        <tr>
            <th>Serial No</th>
            <th>Item Name</th>
            <th>Total Price</th>
        </tr>
        <?php
        $i = 1;
        if ($data->num_rows) {
            while ($row = $data->fetch_assoc()) {
                ?>
                <tr>
                    <form method="POST">

                        <td style="text-align: center"><?= $i++ ?></td>
                        <td><input name="item_name" value="<?= $row['item_name'] ?>"></td>
                        <td><input name="unit_price" value="<?= $row['unit_price'] ?>"></td>
                    </form>
                </tr>
            <?php }
        } else {

        } ?>
        <tr>
            <td colspan="4" style="text-align: center;color:blueviolet">
                Total Price: <?= $server->total_price() ?> /=<br>
                Delivery Cost: <?= $server->delivery_cost() ?> /=
            </td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <?php
    if($_GET['is_feedbacked'] == 1){
    ?>
    <fieldset style="width:410px">
        <legend>Take Action</legend>
        <form method="POST">
            <input type="hidden" name="request_id" value="<?= $_GET['request_id'] ?>">
            <input type="hidden" name="total_cost" value="<?= $server->total_price() + $server->delivery_cost()?>" />
            <table>
                <tr>
                    <td>Total Item Cost:</td>
                    <td><?= $server->total_price() ?> /=</td>
                </tr>
                <tr>
                    <td>Delivery Charge:</td>
                    <td><?= $server->delivery_cost() ?> /=</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td>
                        Total Payable:
                    </td>
                    <td style="color: Blue">
                        <?= $server->total_price() + $server->delivery_cost()?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="submit" name="agree" style="cursor: pointer;width: 100%;color:green">I am agree.</button>
                    </td>
                </tr>
            </table>

        </form>
    </fieldset>
    <?php } ?>
</center>

<!--scripts-->
<?php include './parts/js-links.php'; ?>


</body>
</html>