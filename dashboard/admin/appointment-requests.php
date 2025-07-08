<?php

session_start();
$adminid = $_SESSION['admin_id'];

if (!isset($_SESSION["admin_id"])) {
    header("location:logout.php");
}

$conn = new mysqli("localhost", "root", "", "cms");

require_once './classes/Server.php';
$result = "";
$output = "";
$requests = "";
$appointments = "";

$server = new Server();
$result = $server->adminData();
$requests = $server->TotalRequest();
$appointments = $server->PendingAppointments();
$seen = $server->notification_seen();

if (isset($_POST['accept'])) {
    $output = $server->AcceptAppointment($_POST);
}
if (isset($_POST['cancel'])) {
    $output = $server->CancelAppointment($_POST);
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
                    <h4 class="page-title"><u>Requested Appointments</u></h4>
                </div>

                <div class="col-sm-5 col-6 text-right m-b-30">
                    <?php echo $output; ?>
                </div>
            </div>
            <?php
            $i = 1;
            $x = 1;

            $m = 10000000;
            $n = 10000000;

            if ($appointments->num_rows > 0) {
                while ($data = $appointments->fetch_assoc()) {
                    $id = $data['appointment_id'];
                    $dept_id = $data['dept_id'];
                    $client_id = $data['client_id'];
                    $doctor_id = $data['doctor_id'];
                    $schedule_time = $data['schedule'];
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
                                    <img alt="" src="<?php echo $row['propic'] ?>" style="height: 150px;width:150px"
                                         onerror="this.onerror=null; this.src='../gallery/propic/doctors/default.jpg'"
                                         alt="">
                                </div>
                                <div class="col-sm-3">
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
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
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
                                                <td style="color:blue">Status:</td>
                                                <td>
                                                    <?php
                                                    if ($data['status'] == 0) {
                                                        echo '<span style="color:red">Pending.</span>';
                                                    } else {
                                                        echo '<span style="color:green">Accepted.</span>';
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
                                        <h4><b>Department</b></h4>
                                        <tr>
                                            <a href="department-details.php?dept_id=<?php echo $dept_id; ?>"
                                               target="_blank">
                                                <?php echo $server->getDeptNameByID($dept_id) ?>
                                            </a>
                                        </tr>
                                        <br>
                                        <br>
                                        <h4><b>Requested By</b></h4>
                                        <tr>
                                            <h5>
                                                <a class="avatar"
                                                   href="client-profile.php?client_id=<?php echo $client_id ?>">
                                                    <img src="<?= $server->getClient_ImageByID($client_id) ?>"/>
                                                </a>

                                                <a href="client-profile.php?client_id=<?php echo $client_id ?>">
                                                   <?= $server->getClient_NameByID($client_id) ?>
                                                </a>
                                            </h5>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-sm-1">
                                    <button type="button" class="btn btn-info" data-toggle="modal"
                                            data-target="#myModal<?php echo $i++; ?>">Accept
                                    </button>
                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#myModal<?php echo $m++; ?>">Cancel&nbsp;
                                    </button>
                                </div>
                            </div>

                            <!--modal:accept-->
                            <div class="modal fade" id="myModal<?php echo $x++; ?>" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 style="color:blue">
                                                <mark>Schedule:</mark><?php echo $schedule_time; ?></h4>
                                            <button type="button" class="close text-danger" data-dismiss="modal">
                                                &times;
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="">
                                                <input type="hidden" name="id" value="<?php echo $id ?>"/>
                                                <input type="hidden" name="client_id"
                                                       value="<?php echo $client_id; ?>"/>
                                                <input type="hidden" name="doctor_id"
                                                       value="<?php echo $doctor_id; ?>"/>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group form-focus">
                                                            <label class="focus-label">Appointment Date<span
                                                                        class="text-danger">*</span></label>
                                                            <div class="cal-icon">
                                                                <input class="form-control floating datetimepicker"
                                                                       type="text" name="appointment_date"
                                                                       style="border:1px solid" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <center>
                                                            <input type="submit" class="btn btn-primary" name="accept"
                                                                   value="ACCEPT" style="width: 100%">
                                                        </center>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!--modal:cancel-->
                            <div class="modal fade" id="myModal<?php echo $n++; ?>" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 style="color:blue">
                                                <mark>Schedule:</mark><?php echo $schedule_time; ?></h4>
                                            <button type="button" class="close text-danger" data-dismiss="modal">
                                                &times;
                                            </button>
                                        </div>
                                        <form method="POST" action="">
                                            <div class="modal-body" style="height: 150px">

                                                <input type="hidden" name="id" value="<?php echo $id ?>"/>
                                                <input type="hidden" name="client_id"
                                                       value="<?php echo $client_id; ?>"/>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group form-focus">
                                                            Cancellation Cause<span class="text-danger">*</span><br><br>
                                                            <textarea class="form-control floating"
                                                                      style="height:100px ;resize: none" cols="30"
                                                                      name="cancelled_cause" required></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row modal-footer">
                                                <div class="col-md-12">
                                                    <center>
                                                        <input type="submit" class="btn btn-danger" name="cancel"
                                                               value="Cancel" style="width: 100%">
                                                    </center>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

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
<div class="sidebar-overlay" data-reff=""></div>

<!--scripts-->
<script src="assets/js/jquery-3.2.1.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.slimscroll.js"></script>
<script src="assets/js/select2.min.js"></script>
<script src="assets/js/moment.min.js"></script>
<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
<script src="assets/js/app.js"></script>
</body>


</html>