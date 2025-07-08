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
$result = $server->AppointmentHistory();
$seen = $server->notification_seen();

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
            $x = 1;

            $m = 1000001;
            $n = 1000001;

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
                        <div class="col-sm-10">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title d-inline-block">All Appointments</h4>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead class="d-none">
                                                <tr>
                                                    <th>Patient Name</th>
                                                    <th>Doctor Name</th>
                                                    <th>Schedule</th>
                                                    <th>Date</th>
                                                    <th class="text-right">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        $client_id = $row['client_id'];
                                                        $issue = $row['issue'];
                                                        $cause = $row['cancelled_cause'];
                                                        $appointmentID = $row['appointment_id'];
                                                        $schedule_time = $row['schedule'];
                                                        $appointment_date = $row['appointment_date'];

                                                        date_default_timezone_set('Asia/Dhaka');
                                                        $date = strtotime(str_replace("/", "-", $appointment_date));
                                                        $today = strtotime(date('d-m-Y'));
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
                                                                <h5 class="time-title p-0">Schedule</h5>
                                                                <p><?php echo $row['schedule'] ?></p>
                                                            </td>
                                                            <td>
                                                                <h5 class="time-title p-0">Date</h5>
                                                                <p><?php echo $row['appointment_date'] ?></p>
                                                            </td>
                                                            <td>
                                                                <h5 class="time-title p-0">Status</h5>
                                                                <p>

                                                                    <?php
                                                                    if ($today > $date && $date != "") {
                                                                        echo '<span style="color:red">Expired.</span>';
                                                                    } elseif ($row['request_status'] == 1) {
                                                                        echo '<span style="color:red">Pending.</span>';
                                                                    } elseif ($row['status'] == 1) {
                                                                        echo '<span style="color:green">Accepted.</span>';
                                                                    } elseif ($row['is_cancelled'] == 1) {
                                                                        ?>
                                                                        <span style="color:red">Cancelled.</span>
                                                                        <?php
                                                                    } elseif ($row['is_visited'] == 1) {
                                                                        echo '<span style="color:green">Visited.</span>';
                                                                    } elseif ($row['is_complete'] == 1) {
                                                                        echo '<span style="color:green">Completed.</span>';
                                                                    }
                                                                    ?>

                                                                </p>
                                                            </td>
                                                            <td>
                                                                <a data-toggle="modal" data-target="#myModal<?php echo $m++; ?>" class="btn btn-success" title="profile"><i class="fa fa-user"></i></a>
                                                                <!--modal:profile-->
                                                                <div class="modal fade" id="myModal<?php echo $n++; ?>" role="dialog">
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
                                                                
                                                            </td>

                                                        </tr>

                                                    <?php } ?>
                                                </tbody>
                                            </table>

                                            <?php
                                        } else {
                                            ?>
                                            <span class="card-header" style="color:red">NO DATA FOUND!</span>
                                        <?php }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1"></div>
                    </div>
                    <?php include './parts/messages.php'; ?>
                </div>

            </div>
            <div class="sidebar-overlay" data-reff=""></div>

            <!--scripts-->
            <?php include './parts/js-links.php'; ?>

    </body>


</html>