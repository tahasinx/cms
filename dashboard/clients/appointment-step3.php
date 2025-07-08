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
$inserterrors = "";
$schedule = "";
$doctors = "";


$server = new Server();
$result = $server->viewData();
$doctors = $server->ViewDoctorsByType();
$schedule = $server->get_ScheduleData();

if (isset($_POST['cancel'])) {
    $cancel = $server->cancelAppointment($_POST);
}
if (isset($_POST['next'])) {
    $inserterrors = $server->appointment_Step3($_POST);
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
                            <h4 class="page-title"><u>Create Appointment:</u><span style="color:orangered">&emsp;STEP-3</span>:Type & Schedule<?php
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
                        <div class="card col-sm-12" style="min-height: 190px;padding-top: 2%"> 
                            <form method="POST" action="">
                                <div class="row">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Appointment Type<span class="text-danger">*</span></label>
                                            <select class="form-control" name="type" required>
                                                <option value="" disabled selected>--Select--</option>
                                                <option value="Physical">Physical</option>
                                                <option value="Online">Online</option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php
                                    while ($row = $doctors->fetch_assoc()) {
                                        $doctor_id = $row['user_id'];
                                        $_SESSION['doctor_id'] = $doctor_id;
                                    }
                                    ?>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Schedule Day & Time<span class="text-danger">*</span></label>
                                            <select class="form-control" name="schedule" required>
                                                <option value="" disabled selected>--Select--</option>
                                                <?php
                                                while ($data = $schedule->fetch_assoc()) {
                                                    ?>
                                                    <?php if ($data['day1_status'] == 1) { ?>
                                                        <option><?php echo $data['day_1'] ?> [ <?php echo $data['day1_time'] ?> ]</option> 
                                                    <?php } ?>

                                                    <?php if ($data['day2_status'] == 1) { ?>
                                                        <option><?php echo $data['day_2'] ?> [ <?php echo $data['day2_time'] ?> ]</option>
                                                    <?php } ?>

                                                    <?php if ($data['day3_status'] == 1) { ?>
                                                        <option><?php echo $data['day_3'] ?> [ <?php echo $data['day3_time'] ?> ]</option>
                                                    <?php } ?>

                                                    <?php if ($data['day4_status'] == 1) { ?>
                                                        <option><?php echo $data['day_4'] ?> [ <?php echo $data['day4_time'] ?> ]</option>
                                                    <?php } ?>

                                                    <?php if ($data['day5_status'] == 1) { ?>
                                                        <option><?php echo $data['day_5'] ?> [ <?php echo $data['day5_time'] ?> ]</option>
                                                    <?php } ?>

                                                    <?php if ($data['day6_status'] == 1) { ?>
                                                        <option><?php echo $data['day_6'] ?> [ <?php echo $data['day6_time'] ?> ]</option>
                                                    <?php } ?>
                                                    <?php if ($data['day7_status'] == 1) { ?>
                                                        <option><?php echo $data['day_7'] ?> [ <?php echo $data['day7_time'] ?> ]</option>
                                                    <?php } ?>

                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-12">
                                        <center>
                                            <button class="btn btn-primary" type="submit" name="next">Next &nbsp;<i class="fa fa-arrow-right"></i></button>
                                        </center>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
            <?php include './parts/messages.php'; ?>
        </div>
    </div>
    <?php include './parts/js-links.php'; ?>

</body>
</html>