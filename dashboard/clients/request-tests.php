<?php

session_start();

if (!isset($_SESSION["client_id"])) {
    header("location:logout.php");
}

require_once './classes/Server.php';
$result = "";
$rate = "";
$server = new Server();
$result = $server->viewData();
$data = $server->view_test_requests();

if (isset($_POST['order'])) {
    $rate = $server->order_tests($_POST);
}

if (isset($_POST['cancel'])) {
    $rate = $server->cancel_request($_POST);
}

if (isset($_POST['received'])) {
    $rate = $server->mark_as_received($_POST);
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
        .blink_me {
            animation: blinker 1s linear infinite;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
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
                <div class="col-sm-4 col-3"><h4 class="page-title">Request Tests:&emsp;<u>Upload Prescription</u></h4>
                </div>
                <div class="col-sm-8 col-9 text-right m-b-20">
                    <a href="request-drugs.php" class="btn btn-primary btn-rounded float-right"><i class="fa fa-medkit"></i>
                        Request Drugs
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-4">

                        <div class="dash-widget">
                            <form method="POST" action="" enctype="multipart/form-data">
                                <input type="file" class="form-control" name="prescription_image" required
                                       onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                                <div style="padding: 3%;border: 1px solid;height: 400px;width: 100%">
                                    <img id="blah" alt="your image" style="width: 100%;height: 380px"/>
                                </div>
                                <br>
                                <button type="submit" name="order" class="btn btn-outline-primary"
                                        style="width: 100%;cursor: pointer">
                                    <i class="fa fa-paper-plane"></i> Send Request
                                </button>
                            </form>
                        </div>

                </div>
                <div class="col-12 col-md-8 col-lg-8 col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title d-inline-block">Request History</h4>
                            <a href="" class="btn btn-outline-dark float-right">
                                <span style="color:orangered ">
                                    Total: <?= $server->total_test_requestS() ?>
                                </span>
                            </a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead class="d-none">
                                    <tr>
                                        <th>Serial No</th>
                                        <th>Requested On</th>
                                        <th>Delivered On</th>
                                        <th>Received On</th>
                                        <th>Status</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i = 1;
                                    if ($data->num_rows > 0) {
                                        while ($row = $data->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <h5 class="time-title p-0">Serial No</h5>
                                                    <p><?= $i++ ?></p>
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
                                                            echo '<span style="color:blueviolet">Feedbacked</span>&nbsp;<a  href="check-feedback.php?url=request-tests.php&request_id='.$row['request_id'].'&is_feedbacked='.$row['is_feedbacked'].'" style="color:orangered">check</a>';
                                                        } elseif ($row['is_agreed'] == 1) {
                                                            echo '<span style="color:green">Agreed</span>';
                                                        }
                                                        ?>
                                                    </p>
                                                </td>
                                                <td class="text-right">

                                                    <form method="POST" action="">
                                                        <a href="<?= $row['prescription_image'] ?>" target="_blank"
                                                           class="btn btn-outline-dark" title="Prescription">
                                                            <i class="fa fa-file"></i>
                                                        </a>
                                                        <input type="hidden" name="serial_no" value="<?= $row['id'] ?>">
                                                        <?php
                                                        if ($row['is_pending'] == 1) {
                                                            ?>
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
                                                        } elseif ($row['is_delivered'] == 1) {
                                                            ?>
                                                            <a href="check-feedback.php?url=request-tests.php&request_id=<?= $row['request_id']?>&is_feedbacked=<?= $row['is_feedbacked']?>" class="btn btn-outline-primary"
                                                               title="Check Feedback">
                                                                <i class="fa fa-feed"></i>
                                                            </a>
                                                            <button class="btn btn-outline-success blink_me" type="submit" name="received"
                                                                    title="Mark as received.">
                                                                <i class="fa fa-check "></i>
                                                            </button>
                                                            <?php
                                                        } elseif ($row['is_received'] == 1) {
                                                            ?>
                                                            <a href="check-feedback.php?url=request-tests.php&request_id=<?= $row['request_id']?>&is_feedbacked=<?= $row['is_feedbacked']?>" class="btn btn-outline-primary"
                                                               title="Check Feedback">
                                                                <i class="fa fa-feed"></i>
                                                            </a>
                                                            <?php
                                                        }
                                                        elseif ($row['is_agreed'] == 1) {
                                                            ?>
                                                            <a href="check-feedback.php?url=request-tests.php&request_id=<?= $row['request_id']?>&is_feedbacked=<?= $row['is_feedbacked']?>" class="btn btn-outline-primary"
                                                               title="Check Feedback">
                                                                <i class="fa fa-feed"></i>
                                                            </a>
                                                            <button type="submit" name="cancel"
                                                                    class="btn btn-outline-danger "
                                                                    title="Cancel"
                                                                    onclick="return confirm('Are you really sure to cancel?')">
                                                                <i class="fa fa-remove"></i>
                                                            </button>
                                                            <?php
                                                        }elseif ($row['is_cancelled'] == 1) {
                                                            ?>

                                                            <?php
                                                        }
                                                        ?>

                                                    </form>
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

</body>


</html>