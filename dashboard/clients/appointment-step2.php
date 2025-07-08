<?php

if (!isset($_SERVER['HTTP_REFERER'])) {
    header("location:logout.php");
    exit;
}

session_start();
if (!isset($_SESSION["client_id"])) {
    header("location:logout.php");
}

require_once './classes/Server.php';
$result = "";
$cancel = "";
$depdata = "";
$doctors = "";
$inserterrors = "";


$server = new Server();
$result = $server->viewData();
$doctors = $server->ViewDoctorsByType();



if (isset($_POST['next'])) {
    $inserterrors = $server->appointment_Step2($_POST);
}

if (isset($_POST['cancel'])) {
    $cancel = $server->cancelAppointment($_POST);
}
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
                            <h4 class="page-title"><u>Create Appointment:</u><span style="color:orangered">STEP-2</span>[ SELECT DOCTOR ]<?php
                                echo $inserterrors;
                                echo $cancel;
                                ?></h4>
                        </div>

                        <div class="col-sm-5 col-6 text-right m-b-30">
                            <form method="POST">
                                <?php $appointment_id = $_SESSION['appointment_id'] ?>
                                <input type="hidden" name="appointment_id" value="<?php echo $appointment_id ?>"/>
                                <button class="btn btn-danger" type="submit" name="cancel" onclick="return confirm('Are sure to cancel?');">
                                    <i class="fa fa-times"></i> Cancel
                                </button>
                            </form>
                        </div>
                    </div>
                    <br>
                    <div class="row doctor-grid">
                        <?php
                        $i = 1;
                        $x = 1;
                        $y = 1;
                        if ($doctors->num_rows > 0) {
                            while ($row = $doctors->fetch_assoc()) {
                                ?>
                                <div class="col-md-4 col-sm-4  col-lg-3">
                                    <div class="profile-widget">
                                        <div class="doctor-img">
                                            <a class="avatar" href="#">
                                                <img alt="" src="<?php echo $row['propic'] ?>" onerror="this.onerror=null; this.src='../gallery/propic/doctors/default.jpg'" alt="">
                                            </a>
                                        </div>
                                        <h4 class="doctor-name text-ellipsis"><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></h4>
                                        <div class="doc-prof"><?php echo $row['category'] ?></div>
                                        <div class="text-danger">Visiting Cost:</div><?php echo $row['cost_bdt'] ?> BDT / <?php echo $row['cost_usd'] ?> USD
                                        <form method="POST" action="">
                                            <input type="hidden" name="cost_bdt" value="<?= $row['cost_bdt'] ?>" />
                                            <input type="hidden" name="cost_usd" value="<?= $row['cost_usd'] ?>" />
                                            <input type="hidden" name="doctor_id" value="<?php echo $row['user_id'] ?>" />
                                            <button class="btn btn-success" type="submit" name="next">Select</button>||<span class="btn btn-primary" data-toggle="modal" data-target="#myModal<?php echo $x++; ?>">Profile</span>
                                        </form>
                                    </div>
                                </div>
                                <div class="modal fade" id="myModal<?php echo $y++; ?>" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" style="color:red">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <img alt="" src="<?php echo $row['propic'] ?>" style="height: 150px;width:150px" onerror="this.onerror=null; this.src='../gallery/propic/doctors/default.jpg'" alt="">
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <h4><b>Profile Details</b></h4>
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
                                                                    <span class="fa fa-star checked text-danger"></span>
                                                                    <span class="fa fa-star checked text-danger"></span>
                                                                    <span class="fa fa-star checked text-danger"></span>
                                                                    <span class="fa fa-star text-danger"></span>
                                                                    <span class="fa fa-star"></span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <hr>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Visiting Cost:</td>
                                                                <td><?php echo $row['cost_bdt'] ?> BDT / <?php echo $row['cost_usd'] ?> USD </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <?php
                                                        $doctor_id = $row['user_id'];
                                                        $_SESSION['doctor_id'] = $doctor_id;
                                                        ?>
                                                        <h4><b>Schedules</b></h4>
                                                        <table>
                                                            <?php
                                                            $schedule = $i++;
                                                            $$schedule = "";
                                                            $$schedule = $server->ScheduleData();
                                                            if ($$schedule->num_rows > 0) {
                                                                while ($data = $$schedule->fetch_assoc()) {
                                                                    ?>
                                                                    <?php if ($data['day1_status'] == 1) { ?>
                                                                        <tr>
                                                                            <td><?php echo $data['day_1'] ?>:</td>
                                                                            <td><?php echo $data['day1_time'] ?></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    <?php if ($data['day2_status'] == 1) { ?>
                                                                        <tr>
                                                                            <td><?php echo $data['day_2'] ?>:</td>
                                                                            <td><?php echo $data['day2_time'] ?></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    <?php if ($data['day3_status'] == 1) { ?>
                                                                        <tr>
                                                                            <td><?php echo $data['day_3'] ?>:</td>
                                                                            <td><?php echo $data['day3_time'] ?></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    <?php if ($data['day4_status'] == 1) { ?>
                                                                        <tr>
                                                                            <td><?php echo $data['day_4'] ?>:</td>
                                                                            <td><?php echo $data['day4_time'] ?></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    <?php if ($data['day5_status'] == 1) { ?>
                                                                        <tr>
                                                                            <td><?php echo $data['day_5'] ?>:</td>
                                                                            <td><?php echo $data['day5_time'] ?></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    <?php if ($data['day6_status'] == 1) { ?>
                                                                        <tr>
                                                                            <td><?php echo $data['day_6'] ?>:</td>
                                                                            <td><?php echo $data['day6_time'] ?></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    <?php if ($data['day7_status'] == 1) { ?>
                                                                        <tr>
                                                                            <td><?php echo $data['day_7'] ?>:</td>
                                                                            <td><?php echo $data['day7_time'] ?></td>
                                                                        </tr>
                                                                    <?php } ?>

                                                                    <?php
                                                                }
                                                            } else {
                                                                echo '';
                                                            }
                                                            ?>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                </div>
                <?php include './parts/messages.php'; ?>
            </div>
        </div>
        <?php include './parts/js-links.php'; ?>

    </body>
</html>