<?php
require_once 'classes/Server.php';

$result = "";

$server = new Server();
$data = $server->feedbacked_data($_GET['request_id']);

if (isset($_POST['update'])) {
    $result = $server->update_feedback_data($_POST);
}

if (isset($_POST['update_cost'])) {
    $result = $server->update_delivery_cost($_POST);
}

if (isset($_POST['delete'])) {
    $result = $server->delete_feedback_data($_POST);
}

if (isset($_POST['submit'])) {
    $rate = $server->send_feedback($_POST);
}

?>
<html>

<head>

</head>
<body>
<a href="<?= $_GET['url'] ?>" style="float: right">GO BACK</a>
<br>
<center>
    <h1><?= $result; ?></h1>
    <table border="1">
        <tr>
            <th>Serial No</th>
            <th>Item Name</th>
            <th>Total Price</th>
            <th>Action</th>
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
                        <td>
                            <input type="hidden" name="id" value="<?= $row['id'] ?>"/>
                            <input style="cursor: pointer" name="update" type="submit" value="update">
                            <input style="cursor:pointer;color: red" name="delete" type="submit" value="Remove"
                                   onclick="return confirm('Are you sure to remove?')">
                        </td>

                    </form>
                </tr>
            <?php }
        } else {

        } ?>
        <tr>
            <td colspan="4" style="text-align: center;color:blueviolet">
                Total Item Price: <?= $server->total_price() ?><br>
                Delivery Cost:
                <form method="POST">
                    <input type="hidden"
                           name="request_id"
                           value="<?= $_GET['request_id'] ?>">
                    <input type="" name="delivery_cost" value="<?= $server->delivery_cost() ?>" style="text-align: center">
                    <button type="submit" name="update_cost">Update</button>
                </form>

            </td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <fieldset style="width:41%">
        <legend>ADD NEW DATA</legend>
        <form method="POST">
            <div class="multi-field-wrapper">
                <div class="multi-fields">
                    <div class="multi-field">
                        <input type="hidden"
                               name="request_id"
                               value="<?= $_GET['request_id'] ?>">
                        <input type="text"
                               name="item_name[]"
                               placeholder="Enter Test Name"
                               style="width: 200px"
                               class="form-control"
                               required>
                        <input type="number" min="1"
                               name="unit_price[]"
                               placeholder="Enter Unit Price [in taka]"
                               style="width: 200px"
                               class="form-control"
                               required>
                        <button type="button" class="btn remove-field" style="color: red;cursor: pointer">
                            &times;
                        </button>
                    </div>
                </div>
                <br>
               <button type="button" class="add-field" style="cursor: pointer">Add field</button>
            </div>
            <br>
            <button type="submit" name="submit" class="btn btn-primary" style="width: 300px">
                Submit
            </button>
        </form>
    </fieldset>
</center>

<!--scripts-->
<?php include './parts/js-links.php'; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">

    $('.multi-field-wrapper').each(function () {
        var $wrapper = $('.multi-fields', this);
        $(".add-field", $(this)).click(function (e) {
            $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();
        });
        $('.multi-field .remove-field', $wrapper).click(function () {
            if ($('.multi-field', $wrapper).length > 1)
                $(this).parent('.multi-field').remove();
        });
    });

</script>
</body>
</html>