<?php

session_start();

if (!isset($_SESSION["client_id"])) {
    header("location:logout.php");
}

require_once './classes/Server.php';
$result = "";
$rate = "";
$server = new Server();
$data = $server->eventData();
$result = $server->viewData();
$rating = $server->rate_doctor();
$top_doctors = $server->six_doctors();
$upcomming = $server->upcoming_appoinment();

if (isset($_POST['rate'])) {
    $rate = $server->get_RatingPoint($_POST);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <?php include './parts/css-links.php'; ?>
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
                <div class="col-sm-12">
                    <div class="dash-widget" style="min-height: 110px">
                        <div class="chart-title">
                            <h4>Top Doctors</h4>
                        </div>
                        <div class="dash-widget-info">
                            <div class="row">
                                <?php
                                if ($top_doctors->num_rows > 0) {
                                    while ($row = $top_doctors->fetch_assoc()) {
                                        ?>

                                        <div class="col-md-4 col-sm-4  col-lg-3">
                                            <div class="profile-widget">
                                                <div class="doctor-img">
                                                    <a class="avatar">
                                                        <img alt="" src="<?php echo $row['propic'] ?>"
                                                             onerror="this.onerror=null; this.src='../gallery/propic/doctors/default.jpg'"
                                                             alt="">
                                                    </a>
                                                </div>
                                                <div class="dropdown profile-action">
                                                    <a href="#" class="action-icon dropdown-toggle"
                                                       data-toggle="dropdown" aria-expanded="false"><i
                                                                class="fa fa-ellipsis-v"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <form method="POST" action="doctor-profile.php">
                                                            <input type="hidden" value="<?php echo $row['user_id'] ?>"
                                                                   name="doctor_id"/>
                                                            <button type="submit" class="dropdown-item" name="view"
                                                                    style="border: none;background: none;outline: none;width:100%;cursor: pointer"/>
                                                            &nbsp;<i class="fa fa-user m-r-5"></i> Profile
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <h4 class="doctor-name text-ellipsis"><a
                                                            href="profile.html"><?php echo $row['first_name'] . " " . $row['last_name'] ?></a>
                                                </h4>
                                                <div class="doc-prof"><?php echo $row['category'] ?></div>
                                                <div class="doc-prof">Department:<?php
                                                    $dept_id = $row['department_id'];
                                                    echo $server->getDeptNameByID($dept_id)
                                                    ?></div>
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
                                            </div>
                                        </div>

                                        <?php
                                    }
                                } else {
                                    ?>
                                    <div class="col-md-12 col-sm-12  col-lg-12">
                                        <div class="profile-widget">
                                            <center>
                                                <img alt="" src="../gallery/NoRecordFound.jpg" alt=""
                                                     style="height: 100%;width: 100%">
                                            </center>
                                        </div>
                                    </div>
                                <?php }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php
                if ($data->num_rows > 0) {
                    while ($row = $data->fetch_assoc()) {
                        ?>

                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="card"
                                 style='background-image: url("<?php echo $row['event_banner']; ?>");background-repeat: no-repeat;background-size: cover;background-position: center;height: 320px'>

                                <div class="card-body">
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
                                            Date <a class="category" href="#"><?php echo $row['date'] ?>
                                                &nbsp;<?php echo $row['month'] ?>,<?php echo $row['year'] ?></a>
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

        <?php
        if ($rating->num_rows > 0) {
            while ($row = $rating->fetch_assoc()) {
                $doctor_id = $row['doctor_id'];
                $appointment_id = $row['appointment_id'];
            }
            ?>

            <script>window.location.href="index.php#rating"</script>

            <div class="awesome-modal" id="rating"><a class="close-icon" href="#close"></a>
                <center>
                    Please rate your last visit with us.<br><br>
                    <table>
                        <tr>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="point" value="1"/>
                                    <input type="hidden" name="doctor_id"
                                           value="<?php echo $doctor_id; ?>"/>
                                    <input type="hidden" name="appointment_id"
                                           value="<?php echo $appointment_id; ?>"/>
                                    <button type="submit" name="rate"
                                            style="height: 50px;width: 50px;border-radius: 50%;cursor: pointer;outline: none;">
                                        <span class="fa fa-star checked"></span></button>
                                </form>
                            </td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="point" value="2"/>
                                    <input type="hidden" name="doctor_id"
                                           value="<?php echo $doctor_id; ?>"/>
                                    <input type="hidden" name="appointment_id"
                                           value="<?php echo $appointment_id; ?>"/>
                                    <button type="submit" name="rate"
                                            style="height: 50px;width: 50px;border-radius: 50%;cursor: pointer;outline: none;">
                                        <span class="fa fa-star checked"></span></button>
                                </form>
                            </td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="point" value="3"/>
                                    <input type="hidden" name="doctor_id"
                                           value="<?php echo $doctor_id; ?>"/>
                                    <input type="hidden" name="appointment_id"
                                           value="<?php echo $appointment_id; ?>"/>
                                    <button type="submit" name="rate"
                                            style="height: 50px;width: 50px;border-radius: 50%;cursor: pointer;outline: none;">
                                        <span class="fa fa-star checked"></span></button>
                                </form>
                            </td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="point" value="4"/>
                                    <input type="hidden" name="doctor_id"
                                           value="<?php echo $doctor_id; ?>"/>
                                    <input type="hidden" name="appointment_id"
                                           value="<?php echo $appointment_id; ?>"/>
                                    <button type="submit" name="rate"
                                            style="height: 50px;width: 50px;border-radius: 50%;cursor: pointer;outline: none;">
                                        <span class="fa fa-star checked"></span></button>
                                </form>
                            </td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="point" value="5"/>
                                    <input type="hidden" name="doctor_id"
                                           value="<?php echo $doctor_id; ?>"/>
                                    <input type="hidden" name="appointment_id"
                                           value="<?php echo $appointment_id; ?>"/>
                                    <button type="submit" name="rate"
                                            style="height: 50px;width: 50px;border-radius: 50%;cursor: pointer;outline: none;">
                                        <span class="fa fa-star checked"></span></button>
                                </form>
                            </td>
                        </tr>
                    </table>

                </center>
            </div>

        <?php } ?>
        <?php
        if ($upcomming->num_rows > 0) {
            while ($data = $upcomming->fetch_assoc()) {
                $appointment_date = $data['appointment_date'];
                $schedule = $data['schedule'];
                $type = $data['type'];
                date_default_timezone_set('Asia/Dhaka');
                $curdate = date('d/m/Y');
            }
            ?>
            <?php if ($appointment_date === $curdate) { ?>
                <script>window.location.href="index.php#appoitment"</script>
                <div class="awesome-modal" id="appoitment"><a class="close-icon" href="#close"></a>
                    <center>
                        <p>You have an appointment today.</p>
                        <table>
                            <tr>
                                <td>Date:</td>
                                <td style="color:orangered"><?php echo $appointment_date; ?></td>
                            </tr>
                            <tr>
                                <td>Type:</td>
                                <td style="color:orangered"><?php echo $type; ?></td>
                            </tr>
                            <tr>
                                <td>Schedule:</td>
                                <td style="color:orangered"><?php echo $schedule; ?></td>
                            </tr>
                        </table>
                    </center>
                </div>
               <?php
            }
        } else {

        }
        ?>

    </div>
</div>
<?php include './parts/js-links.php'; ?>

<script type="text/javascript">
    $(function () {
        $('#ratingModal').modal('show');
    });
</script>


<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
</body>
</html>