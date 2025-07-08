<?php

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
$schedule = "";
$appointmentData = "";
$appointmentData2 = "";


$server = new Server();
$result = $server->viewData();
$doctors = $server->ViewDoctorsBy_SessionID();
$schedule = $server->ScheduleData();
$appointmentData = $server->appointmentData();
$appointmentData2 = $server->appointmentData();

if (isset($_POST['confirm'])) {
    $inserterrors = $server->appointment_StepFinal($_POST);
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
        .content {
            font-family: 'Titillium Web', sans-serif;
        }

        form {
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
                    <h4 class="page-title"><u>Create Appointment:</u><span
                                style="color:orangered">&emsp;FINAL-STEP</span><?php
                        echo $inserterrors;
                        echo $cancel;
                        ?></h4>
                </div>

                <div class="col-sm-5 col-6 text-right m-b-30">
                    <form method="POST">
                        <?php $appointment_id = $_SESSION['appointment_id'] ?>
                        <input type="hidden" name="appointment_id" value="<?php echo $appointment_id ?>"/>
                        <button class="btn btn-danger" type="submit" name="cancel"
                                onclick="return confirm('Are sure to cancel?');">
                            <i class="fa fa-times"></i> Cancel
                        </button>
                    </form>
                </div>
            </div>
            <br>
            <div class="row doctor-grid">
                <div class="card col-sm-12" style="min-height: 190px;padding-top: 2%">

                    <?php
                    $doctor_id = $_SESSION['doctor_id'];
                    while ($row = $doctors->fetch_assoc()) {
                    ?>
                    <div class="row">
                        <div class="col-sm-2">
                            <img alt="" src="<?php echo $row['propic'] ?>" style="height: 150px;width:150px"
                                 onerror="this.onerror=null; this.src='../gallery/propic/doctors/default.jpg'" alt="">
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
                            </table>
                        </div>
                        <?php
                        $doctor_id = $row['user_id'];
                        $_SESSION['doctor_id'] = $doctor_id;
                        }

                        ?>
                        <div class="col-sm-4">
                            <h4><b>Type & Schedule</b></h4>
                            <table>
                                <?php
                                while ($data = $appointmentData->fetch_assoc()) {
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
                                        <?php if ($data['type'] == 'Online') { ?>
                                            <td>Appointment Cost:</td>
                                            <td style="color:orangered"><?php echo $data['cost_usd'] ?> USD</td>
                                        <?php } elseif ($data['type'] == 'Physical') { ?>
                                            <td>Appointment Cost:</td>
                                            <td style="color:orangered"><?php echo $data['cost_bdt'] ?> BDT</td>
                                        <?php } ?>
                                    </tr>

                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                        <div class="col-sm-2">
                            <h4><b>Department</b></h4>
                            <table>
                                <?php
                                while ($data = $appointmentData2->fetch_assoc()) {
                                    $dept_id = $data['dept_id']
                                    ?>
                                    <tr>
                                        <?php echo $server->getDeptNameByID($dept_id) ?>
                                    </tr>

                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <center>
                <form method="POST">
                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="status" value="1" name="" required
                                   checked>
                            <label class="form-check-label" style="color: red;font-size: 15px;">
                                I accept all appointment <a href="#">terms and policies.</a>
                            </label>
                        </div>
                    </div>
                   <input type="submit" class="btn btn-primary" name="confirm" value="Send Request" style="width: 300px"/>
                </form>
            </center>

        </div>
        <?php include './parts/messages.php'; ?>
    </div>
</div>
<?php include './parts/js-links.php'; ?>

</body>
</html>