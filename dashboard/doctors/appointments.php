<?php
session_start();
$userid = $_SESSION['user_id'];
require_once './classes/Server.php';

$conn = new mysqli("localhost", "root", "", "cms");

if (!isset($_SESSION["user_id"])) {
    header("location:logout.php");
}

$data = '';
$result = '';
$saveData = '';

$server = new Server();
$data = $server->viewData();
$result = $server->UpcomingAppointment();

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
            .content{
                font-family: 'Titillium Web', sans-serif;
            }

        </style>
    </head>

    <body>

        <div class="main-wrapper">
            <?php
            $i = 1;
            $j = 1;

            $m = 1000000001;
            $n = 1000000001;

            while ($row = $data->fetch_assoc()) {
                ?>
                <?php
                if ($row['doctor_status'] == 0) {
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
                        <div class="col-sm-1"></div>
                        <div class="col-sm-9">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title d-inline-block">Upcoming Appointments</h4>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead class="d-none">
                                                <tr>
                                                    <th>Patient Name</th>
                                                    <th>Doctor Name</th>
                                                    <th>Date</th>
                                                    <th>Schedule</th>
                                                    <th>Type</th>
                                                    <th class="text-right">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        $client_id = $row['client_id'];
                                                        $issue = $row['issue'];
                                                        $appointmentID = $row['appointment_id'];
                                                        $schedule_time = $row['schedule'];
                                                        ?>
                                                        <tr>
                                                            <td style="min-width: 200px;">
                                                                <a class="avatar">
                                                                    <img src="<?php echo $server->getClient_ImageByID($client_id) ?>" onerror="this.onerror=null; this.src='assets/img/user.jpg'"/>
                                                                </a>
                                                                <h2>
                                                                    <a href=""><?php echo $server->getClient_NameByID($client_id) ?>
                                                                        <span><?php echo $server->getClient_AddressByID($client_id) ?></span>
                                                                    </a>
                                                                </h2>
                                                            </td>
                                                            <td>
                                                                <h5 class="time-title p-0">Date</h5>
                                                                <p><?php echo $row['appointment_date'] ?></p>
                                                            </td>
                                                            <td>
                                                                <h5 class="time-title p-0">Schedule</h5>
                                                                <p><?php echo $row['schedule'] ?></p>
                                                            </td>
                                                            <td>
                                                                <h5 class="time-title p-0">Type</h5>
                                                                <p><?php echo $row['type'] ?></p>
                                                            </td>
                                                            <td class="">
                                                                <a data-toggle="modal" data-target="#myModal<?php echo $i++; ?>" class="btn btn-success" title="profile"><i class="fa fa-user"></i></a>
                                                                <a data-toggle="modal" data-target="#myModal<?php echo $m++; ?>" class="btn btn-danger" title="cancel"><i class="fa fa-edit"></i></a>
                                                            
                                                                <!--modal:profile-->
                                                                <div class="modal fade" id="myModal<?php echo $j++; ?>" role="dialog">
                                                                    <div class="modal-dialog modal-lg">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal" style="color:red">&times;</button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="row">
                                                                                    <?php
                                                                                    $sql = "SELECT *FROM clients WHERE client_id = '$client_id'";
                                                                                    $output = $conn->query($sql);
                                                                                    while ($rows = $output->fetch_assoc()) {
                                                                                        ?>
                                                                                        <div class="col-sm-3">
                                                                                            <img alt="" src="<?php echo $rows['propic'] ?>" style="height: 150px;width:150px" onerror="this.onerror=null; this.src='../gallery/propic/doctors/default.jpg'" alt="">
                                                                                        </div>
                                                                                        <div class="col-sm-4">
                                                                                            <h4><b>Profile Details</b></h4>
                                                                                            <table>
                                                                                                <tr>
                                                                                                    <td>Name:</td>
                                                                                                    <td><?php echo $rows['first_name'] . ' ' . $rows['last_name']; ?></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>Age:</td>
                                                                                                    <td>
                                                                                                        <?php
                                                                                                        $birthday = $rows['birthday'];
                                                                                                        date_default_timezone_set("Asia/Dhaka");
                                                                                                        $dob = strtotime(str_replace("/", "-", $birthday));
                                                                                                        $tdate = time();
                                                                                                        echo date('Y', $tdate) - date('Y', $dob);
                                                                                                        ?>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>Gender:</td>
                                                                                                    <td><?php echo $rows['gender']; ?></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>Country:</td>
                                                                                                    <td><?php echo $rows['country']; ?></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>City:</td>
                                                                                                    <td><?php echo $rows['city']; ?></td>
                                                                                                </tr>
                                                                                            </table>
                                                                                        </div>
                                                                                    <?php } ?>
                                                                                    <div class="col-sm-5">
                                                                                        <h4><b>Issue/Sickness</b></h4>
                                                                                        <?php echo $issue; ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                                                                                <h4 style="color:blue"><mark>Schedule:</mark><?php echo $schedule_time; ?></h4>
                                                                                <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
                                                                            </div>
                                                                            <form method="POST" action="">
                                                                                <div class="modal-body" style="height: 150px">

                                                                                    <input type="hidden" name="id" value="<?php echo $appointmentID; ?>" />
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <div class="form-group form-focus">
                                                                                                Cancellation Cause<span class="text-danger">*</span><br><br>
                                                                                                <textarea class="form-control floating" style="height:100px ;resize: none" cols="30" name="cancelled_cause" required></textarea>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                                <div class="row modal-footer">
                                                                                    <div class="col-md-12">
                                                                                        <center>
                                                                                            <input type="submit" class="btn btn-danger" name="cancel" value="Cancel" style="width: 100%">
                                                                                        </center>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                    <?php }
                                                    ?>
                                                </tbody>
                                            </table>

                                        </div>
                                    <?php } else {
                                        ?>
                                        <span class="card-header" style="color:red">NO DATA FOUND!</span>
                                    <?php }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1"></div>
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