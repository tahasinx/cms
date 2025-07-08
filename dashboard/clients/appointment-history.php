<?php

session_start();
if (!isset($_SESSION["client_id"])) {
    header("location:logout.php");
}

$conn = new mysqli("localhost", "root", "", "cms");
require_once './classes/Server.php';

$result = "";
$appointments = "";
$inserterrors = "";

$server = new Server();
$result = $server->viewData();

$appointments = $server->Appointments();
$seen = $server->notification_seen();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
        <title>CMS</title>
        <?php include './parts/css-links.php'; ?>
        <style>
            .content{
                font-family: 'Titillium Web', sans-serif;
            }
            form{
                font-size: 15px
            }
        </style>
        <!--
        <script>
            setTimeout(function ()
            {
                if (self.name != '_refreshed_') {
                    self.name = '_refreshed_';
                    self.location.reload(true);
                } else {
                    self.name = '';
                }
            }, 1000);
        </script>
        -->
    </head>

    <body>
        <div class="main-wrapper">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <?php
                if ($row['status'] == 0) {
                    echo "<script type='text/javascript'>alert('SORRY! YOU ARE BLOCKED!');document.location='logout.php';</script>";
                }
                ?>
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
                        <div class="col-sm-7 col-6">
                            <h4 class="page-title"><u>Appointment History:</u></h4>
                        </div>

                        <div class="col-sm-5 col-6 text-right m-b-30">

                        </div>
                    </div>
                    <?php
                    $i = 1;
                    $x = 1;

                    $m = 1000001;
                    $n = 1000001;
                    $k = 1000001;
                    if ($appointments->num_rows > 0) {
                        while ($data = $appointments->fetch_assoc()) {
                            $id = $data['appointment_id'];
                            $status = $data['status'];
                            $cause = $data['cancelled_cause'];
                            $type = $data['type'];
                            $appointment_date = $data['appointment_date'];

                            date_default_timezone_set('Asia/Dhaka');
                            $date = strtotime(str_replace("/", "-", $appointment_date));
                            $today = strtotime(date('d-m-Y'));

                            ?>
                            <div class="row doctor-grid">
                                <div class="card col-sm-12" style="min-height: 190px;padding-top: 2%">
                                    <?php
                                    $doctorid = $data['doctor_id'];
                                    $sql = "SELECT *FROM `doctors` WHERE user_id ='$doctorid'";
                                    $doctors = $conn->query($sql);
                                    while ($row = $doctors->fetch_assoc()) {
                                        ?>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <img alt="" src="<?php echo $row['propic'] ?>" style="height: 150px;width:150px" onerror="this.onerror=null; this.src='../gallery/propic/doctors/default.jpg'" alt="">
                                            </div>
                                            <div class="col-sm-4">
                                                <h4><b>Selected Doctor</b></h4>
                                                <table>
                                                    <tr>
                                                        <td>Name:</td>
                                                        <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Type:</td>
                                                        <td><?php echo $row['category']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Degree:</td>
                                                        <td><?php echo $row['degree']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Position:</td>
                                                        <td><?php echo $row['position']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Ratings:</td>
                                                        <td>
                                                            <?php if ($server->average_ratingPoint($row['user_id']) == 0) { ?>
                                                                <span class="fa fa-star"></span>
                                                                <span class="fa fa-star"></span>
                                                                <span class="fa fa-star"></span>
                                                                <span class="fa fa-star"></span>
                                                                <span class="fa fa-star"></span>
                                                            <?php } elseif ($server->average_ratingPoint($row['user_id']) == 1) { ?>
                                                                <span class="fa fa-star checked text-danger"></span>
                                                                <span class="fa fa-star"></span>
                                                                <span class="fa fa-star"></span>
                                                                <span class="fa fa-star"></span>
                                                                <span class="fa fa-star"></span>
                                                            <?php } elseif ($server->average_ratingPoint($row['user_id']) == 2) { ?>
                                                                <span class="fa fa-star checked text-danger"></span>
                                                                <span class="fa fa-star checked text-danger"></span>
                                                                <span class="fa fa-star"></span>
                                                                <span class="fa fa-star"></span>
                                                                <span class="fa fa-star"></span>
                                                            <?php } elseif ($server->average_ratingPoint($row['user_id']) == 3) { ?>
                                                                <span class="fa fa-star checked text-danger"></span>
                                                                <span class="fa fa-star checked text-danger"></span>
                                                                <span class="fa fa-star checked text-danger"></span>
                                                                <span class="fa fa-star"></span>
                                                                <span class="fa fa-star"></span>
                                                            <?php } elseif ($server->average_ratingPoint($row['user_id']) == 4) { ?>
                                                                <span class="fa fa-star checked text-danger"></span>
                                                                <span class="fa fa-star checked text-danger"></span>
                                                                <span class="fa fa-star checked text-danger"></span>
                                                                <span class="fa fa-star checked text-danger"></span>
                                                                <span class="fa fa-star"></span>
                                                            <?php } elseif ($server->average_ratingPoint($row['user_id']) == 5) { ?>
                                                                <span class="fa fa-star checked text-danger"></span>
                                                                <span class="fa fa-star checked text-danger"></span>
                                                                <span class="fa fa-star checked text-danger"></span>
                                                                <span class="fa fa-star checked text-danger"></span>
                                                                <span class="fa fa-star checked text-danger"></span>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td style="color:orangered ">Visiting Cost:</td>
                                                        <td>
                                                            <?php
                                                            if($type == 'Online'){
                                                                echo $row['cost_usd'];
                                                            }elseif ($type == 'Physical'){
                                                                echo $row['cost_bdt'];
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>

                                                </table>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <div class="col-sm-4">
                                            <h4><b>Type & Schedule</b></h4>
                                            <table>
                                                <?php
                                                $sql = "SELECT *FROM `appointment` WHERE appointment_id = '$id'";
                                                $schedule = $conn->query($sql);
                                                while ($data = $schedule->fetch_assoc()) {
                                                    ?>
                                                    <tr>
                                                        <td>Schedule:</td>
                                                        <td><?php echo $data['schedule'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Type:</td>
                                                        <td><?php echo $data['type'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Request Date:</td>
                                                        <td><?php echo $data['request_date'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Appointment Date:</td>
                                                        <td>
                                                            <?php
                                                            if ($data['is_cancelled'] == 1) {
                                                                echo '';
                                                            } elseif ($data['request_status'] == 1) {
                                                                echo '';
                                                            } elseif ($data['is_visited'] == 1) {
                                                                echo $data['appointment_date'];

                                                            }elseif ($data['is_complete'] == 1) {
                                                                echo $data['appointment_date'];
                                                            } else {
                                                                echo $data['appointment_date'];
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="color:blue">Status:</td>
                                                        <td>
                                                            <?php
                                                            if ($today > $date && $date != "" && $data['is_visited'] == 0) {
                                                                echo '<span style="color:red">Expired.</span>';
                                                            } elseif ($data['request_status'] == 1) {
                                                                echo '<span style="color:red">Pending.</span>';
                                                            } elseif ($data['status'] == 1) {
                                                                echo '<span style="color:green">Accepted.</span>';
                                                            } elseif ($data['is_cancelled'] == 1) {
                                                                ?>
                                                                <span style="color:red">Canceled.</span>
                                                                <span class="btn btn-danger" data-toggle="modal" data-target="#myModal<?php echo $i++; ?>">CAUSE</span>
                                                                <!--modal:cancel-->
                                                                <div class="modal fade" id="myModal<?php echo $x++; ?>" role="dialog">
                                                                    <div class="modal-dialog">

                                                                        <!-- Modal content-->
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 style="color:red">Cancellation Cause</h4>
                                                                                <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
                                                                            </div>
                                                                            <div class="modal-body" style="height: 150px">
                                                                                <?php echo $cause; ?>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <?php
                                                            } elseif ($data['is_visited'] == 1) {
                                                                echo '<span style="color:green">Visited.</span>';
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>

                                                    <?php
                                                }
                                                ?>
                                            </table>
                                        </div>




                                        <div class="col-sm-2">

                                            <table>
                                                <?php
                                                $sql = "SELECT *FROM `appointment` WHERE appointment_id = '$id' ";
                                                $appointmentData = $conn->query($sql);
                                                while ($data = $appointmentData->fetch_assoc()) {
                                                    $dept_id = $data['dept_id']
                                                    ?>
                                                    <h4><b>Department</b></h4>
                                                    <tr>
                                                        <?php echo $server->getDeptNameByID($dept_id) ?>
                                                    </tr>
                                                    <br>
                                                    <br>

                                                    <h4><b>Appointment Token</b></h4>
                                                    <tr>
                                                    <br>
                                                        <td>
                                                            <?php
                                                            if ($data['is_cancelled'] == 1 || $today > $date && $date != "" || $status == 0 ) {
                                                                ?>

                                                            <?php } else { ?>
                                                                <a href="appointment-token.php?appointment_id=<?= $data['appointment_id'] ?>" class="btn btn-primary " target="_blank">Token</a>
                                                            <?php } ?>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>

                                                    </tr>

                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <div class="col-md-12 col-sm-12  col-lg-12">
                            <div class="profile-widget">
                                <center>
                                    <img alt="" src="../gallery/NoRecordFound.jpg" alt="" style="height: 100%;width: 100%">
                                </center>
                            </div>
                        </div>
                    <?php }
                    ?>


                </div>
                <?php include './parts/messages.php'; ?>
            </div>
        </div>
        <?php include './parts/js-links.php'; ?>

    </body>
</html>