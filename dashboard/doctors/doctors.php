<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("location:logout.php");
}

require_once './classes/Server.php';
$result = "";
$doctors = "";

$server = new Server();
$result = $server->viewData();
$doctors = $server->allDoctors();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
        <title>CMS</title>
        <?php include './parts/css-links.php'; ?>

    </head>

    <body>
        <div class="main-wrapper">
            <?php while ($row = $result->fetch_assoc()) { ?>

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
                        <div class="col-sm-4 col-3"><h4 class="page-title"><u>DOCTORS</u></h4></div>
                    </div>
                    <div class="row doctor-grid">
                        <?php
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
                                        <div class="dropdown profile-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <form method="POST" action="doctor-profile.php" >
                                                    <input type="hidden" value="<?php echo $row['user_id'] ?>" name="doctor_id"/>
                                                    <button type="submit" class="dropdown-item" name="view" style="border: none;background: none;outline: none;width:100%;cursor: pointer" />
                                                    <i class="fa fa-user m-r-5"></i> Profile
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <h4 class="doctor-name text-ellipsis"><a href="profile.html"><?php echo $row['first_name'] . " " . $row['last_name'] ?></a></h4>
                                        <div class="doc-prof"><?php echo $row['category'] ?></div>
                                        <div class="doc-prof">Department:<?php
                                            $dept_id = $row['department_id'];
                                            echo $server->getDeptNameByID($dept_id)
                                            ?></div>
                                        <br>
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