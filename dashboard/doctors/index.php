<?php
session_start();
$userid = $_SESSION['user_id'];
require_once './classes/Server.php';

if (!isset($_SESSION["user_id"])) {
header("location:logout.php");
}

$data = '';
$saveData = '';

$server = new Server();
$data = $server->viewData();
$result = $server->UpcomingAppointment();
$events = $server->eventData();
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

    </head>

    <body>

        <div class="main-wrapper">
            <?php while ($row = $data->fetch_assoc()) { ?>
            <div class="header">
                <?php include './parts/top-nav.php'; ?>
            </div>

            <div class="sidebar" id="sidebar">
                <?php include './parts/side-nav.php'; ?>
            </div>
            <?php
            if ($row['doctor_status'] == 0) {
            echo "<script type='text/javascript'>alert('SORRY! YOU ARE BLOCKED!');document.location='logout.php';</script>";
            }
            }
            ?>
            <div class="page-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12 col-xl-12" >
                            <div class="card" style="height: 380px">
                                <div class="card-header">
                                    <h4 class="card-title d-inline-block">Upcoming Appointments</h4> <a href="appointments.php" class="btn btn-primary float-right">View all</a>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead class="d-none">
                                                <tr>
                                                    <th>Patient Name</th>
                                                    <th>Doctor Name</th>
                                                    <th>Timing</th>
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
                                                        <h5 class="time-title p-0">Appointment Date</h5>
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
                                                    <td class="text-right">
                                                        <a href="appointments.php" class="btn btn-outline-primary take-btn">Take up</a>
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
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        if ($events->num_rows > 0) {
                            while ($row = $events->fetch_assoc()) {
                                ?>

                                <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                    <div class="card" style='background-image: url("<?php echo $row['event_banner']; ?>");background-repeat: no-repeat;background-size: cover;background-position: center;height: 320px'>

                                        <div class="card-body" >
                                            <div class="blog-article" style="color:white">

                                                <div class="blog-article-thumbnail">

                                                    <a class="date" href="#">
                                                        <small><?php echo $row['month'] ?></small>
                                                        <span><?php echo $row['date'] ?></span>
                                                        <small><?php echo $row['year'] ?></small>
                                                    </a>
                                                </div>
                                                <h4 class="blog-article-title"><?php echo $row['event_title'] ?></h4>
                                                <div class="blog-article-details">
                                                    By <a class="author" href="#">Admin</a>
                                                    Date <a class="category" href="#"><?php echo $row['date'] ?>&nbsp;<?php echo $row['month'] ?>,<?php echo $row['year'] ?></a>
                                                </div><!-- blog-article-details -->

                                                <div class="blog-article-content">

                                                    <p><?php echo $row['event_description'] ?></p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <?php
                            }
                        } else {

                        }
                        ?>
                    </div>
            </div>
            <?php include './parts/messages.php'; ?>
            
        </div>
        <div class="sidebar-overlay" data-reff=""></div>

        <!--scripts-->
        <?php include './parts/js-links.php'; ?>

    </body>


</html>