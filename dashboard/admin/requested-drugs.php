<?php

session_start();
$adminid = $_SESSION['admin_id'];

if (!isset($_SESSION["admin_id"])) {
    header("location:logout.php");
}

require_once './classes/Server.php';
$result = "";
$totalDoc = "";
$totalDept = "";
$totalClient = "";

$server = new Server();
$result = $server->adminData();

$data = $server->view_drug_requests();

if (isset($_POST['cancel'])) {
    $rate = $server->cancel_request($_POST);
}

if (isset($_POST['submit'])) {
    $rate = $server->send_feedback($_POST);
}

if (isset($_POST['delivered'])) {
    $rate = $server->mark_as_delivered($_POST);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>CMS</title>

    <?php
    include './parts/css-links.php';
    ?>

    <style>
        .form-control {
            border: 1px solid !important;
        }
    </style>
</head>

<body>

<div class="main-wrapper">
    <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="header">
            <?php include './parts/top-nav.php'; ?>
        </div>

        <div class="sidebar" id="sidebar">
            <?php include './parts/side-nav.php'; ?>
        </div>
    <?php } ?>
    <div class="page-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-sm-8 "><h4 class="page-title"><u>Requested Drugs</u></h4></div>
                <div class="col-sm-4 text-right m-b-20">
                    <a href="requested-tests.php" class="btn btn-primary btn-rounded float-right"><i
                                class="fa fa-medkit"></i>
                        Requested Tests
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <input id="myInput" type="text" placeholder="Search ...."
                                       style="height: 35px;width: 40%;border: 1px solid;text-align: center">

                            <a href="" class="btn btn-outline-dark float-right">
                                <span style="color:orangered ">
                                    Total: <?= $server->total_drug_requestS() ?>
                                </span>
                            </a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead class="d-none">
                                    <tr>
                                        <th>Requested On</th>
                                        <th>Delivered On</th>
                                        <th>Received On</th>
                                        <th>Status</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="myTable">
                                    <?php
                                    $i = 1;
                                    $j = 1;
                                    if ($data->num_rows > 0) {
                                        while ($row = $data->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td style="width:60px">
                                                    <a class="avatar" href="">
                                                        <img src="<?= $server->getClient_ImageByID($row['requested_by']) ?>"/>
                                                    </a>
                                                </td>
                                                <td>
                                                    <h5 class="time-title p-0">Requested By</h5>
                                                    <p><?= $server->getClient_NameByID($row['requested_by']) ?></p>
                                                </td>
                                                <td>
                                                    <h5 class="time-title p-0">Requested On</h5>
                                                    <p><?= $row['requested_on'] ?></p>
                                                </td>
                                                <td>
                                                    <h5 class="time-title p-0">Delivered On</h5>
                                                    <p><?= $row['delivered_on'] ?></p>
                                                </td>
                                                <td>
                                                    <h5 class="time-title p-0">Received On</h5>
                                                    <p><?= $row['received_on'] ?></p>
                                                </td>
                                                <td>
                                                    <h5 class="time-title p-0">Status</h5>
                                                    <p>
                                                        <?php
                                                        if ($row['is_pending'] == 1) {
                                                            echo '<span style="color:blueviolet">Pending</span>';
                                                        } elseif ($row['is_processing'] == 1) {
                                                            echo '<span style="color:yellow">Processing</span>';
                                                        } elseif ($row['is_delivered'] == 1) {
                                                            echo '<span style="color:green">Delivered</span>';
                                                        } elseif ($row['is_received'] == 1) {
                                                            echo '<span style="color:green">Received</span>';
                                                        } elseif ($row['is_cancelled'] == 1) {
                                                            echo '<span style="color:red">Cancelled</span>';
                                                        }elseif ($row['is_feedbacked'] == 1) {
                                                            echo '<span style="color:blueviolet">Feedbacked</span>&nbsp;<a  href="check-feedback.php?url=requested-drugs.php&request_id='.$row['request_id'].'" style="color:orangered">check</a>';
                                                        }elseif ($row['is_agreed'] == 1) {
                                                            echo '<span style="color:green">Agreed</span>';
                                                        }
                                                        ?>
                                                    </p>
                                                </td>
                                                <td class="text-right">

                                                    <form method="POST" action="">
                                                        <a href="client-profile.php?client_id=<?= $row['requested_by'] ?>"
                                                           target="_blank"
                                                           class="btn btn-outline-info" title="Requested By">
                                                            <i class="fa fa-user"></i>
                                                        </a>
                                                        <a href="<?= $row['prescription_image'] ?>" target="_blank"
                                                           class="btn btn-outline-dark" title="Prescription">
                                                            <i class="fa fa-file"></i>
                                                        </a>
                                                        <input type="hidden" name="serial_no" value="<?= $row['id'] ?>">
                                                        <?php
                                                        if ($row['is_pending'] == 1) {
                                                            ?>
                                                            <a href="" data-toggle="modal" data-target="#myModal<?= $i++ ?>"
                                                               class="btn btn-outline-primary" title="Send Feedback">
                                                                <i class="fa fa-feed"></i>
                                                            </a>
                                                            <button type="submit" name="cancel"
                                                                    class="btn btn-outline-danger "
                                                                    title="Cancel"
                                                                    onclick="return confirm('Are you really sure to cancel?')">
                                                                <i class="fa fa-remove"></i>
                                                            </button>
                                                            <?php
                                                        } elseif ($row['is_processing'] == 1) {
                                                            ?>
                                                            <button type="submit" name="cancel"
                                                                    class="btn btn-outline-primary"
                                                                    title="Cancel">
                                                                <i class="fa fa-remove"></i>
                                                            </button>
                                                            <?php
                                                        } elseif ($row['is_agreed'] == 1) {
                                                            ?>
                                                            <button type="submit" name="delivered"
                                                                    class="btn btn-outline-primary"
                                                                    title="Mark as delivered">
                                                                <i class="fa fa-exchange"></i>
                                                            </button>
                                                            <button type="submit" name="cancel"
                                                                    class="btn btn-outline-danger "
                                                                    title="Cancel"
                                                                    onclick="return confirm('Are you really sure to cancel?')">
                                                                <i class="fa fa-remove"></i>
                                                            </button>
                                                            <?php
                                                        } elseif ($row['is_feedbacked'] == 0 && $row['is_cancelled'] == 0) {
                                                            ?>
                                                            <a href="" data-toggle="modal" data-target="#myModal<?= $i++ ?>"
                                                               class="btn btn-outline-primary" title="Send Feedback">
                                                                <i class="fa fa-feed"></i>
                                                            </a>
                                                            <?php
                                                        }elseif ($row['is_feedbacked'] == 1) {
                                                            ?>
                                                            <button type="submit" name="cancel"
                                                                    class="btn btn-outline-danger "
                                                                    title="Cancel"
                                                                    onclick="return confirm('Are you really sure to cancel?')">
                                                                <i class="fa fa-remove"></i>
                                                            </button>
                                                            <?php
                                                        }
                                                        ?>

                                                    </form>
                                                </td>
                                            </tr>

                                            <!-- Modal -->
                                            <tr>
                                                <td colspan="7">

                                                    <div class="modal fade" id="myModal<?= $j++ ?>" role="dialog">
                                                        <div class="modal-dialog">
                                                            <div class="multi-field-wrapper">
                                                                <!-- Modal content-->
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        Make Prescription
                                                                        <button type="button" class="close btn-danger"
                                                                                data-dismiss="modal">
                                                                            &times;
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">

                                                                        <div style="padding-left:2%;min-height: 300px">
                                                                            <center>
                                                                                <form method="POST" class="form-inline">
                                                                                    <input type="hidden"
                                                                                           name="request_id"
                                                                                           value="<?= $row['request_id'] ?>">

                                                                                    <div class="multi-fields">
                                                                                        <div class="multi-field">
                                                                                            <input type="text"
                                                                                                   name="item_name[]"
                                                                                                   placeholder="Enter Drug Name"
                                                                                                   style="width: 200px"
                                                                                                   class="form-control"
                                                                                                   required >
                                                                                            <input type="number" min="1"
                                                                                                   name="unit_price[]"
                                                                                                   placeholder="Enter Total Price [in taka]"
                                                                                                   style="width: 200px"
                                                                                                   class="form-control"
                                                                                                   required>
                                                                                            <button type="button"class="btn btn-danger remove-field">
                                                                                            &times;
                                                                                            </button>

                                                                                        </div>
                                                                                    </div>
                                                                                    <input type="number" min="1"
                                                                                           name="delivery_cost"
                                                                                           placeholder="Enter Delivery Cost [in taka]"
                                                                                           style="width: 400px"
                                                                                           class="form-control"
                                                                                           required>
                                                                                    <button type="submit" name="submit" class="btn btn-primary" style="width: 88%">
                                                                                        Submit
                                                                                    </button>
                                                                                </form>
                                                                            </center>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button class="btn btn-outline-dark add-field">
                                                                            Add New Field &nbsp;
                                                                            <span style="font-size:16px; font-weight:bold;">+ </span>
                                                                        </button>
                                                                        <button type="button" class="btn btn-default"
                                                                                data-dismiss="modal">Close
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else { ?>
                                        <tr>
                                            <td colspan="6">
                                                <center>
                                                     <span class="text-danger">
                                                          No Request Found !
                                                     </span>
                                                </center>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php include './parts/messages.php'; ?>
    </div>
</div>
<div class="sidebar-overlay" data-reff=""></div>

<!--scripts-->
<?php include './parts/js-links.php'; ?>
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