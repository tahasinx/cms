<?php

session_start();
$adminid = $_SESSION['admin_id'];

if (!isset($_SESSION["admin_id"])) {
    header("location:logout.php");
}

require_once './classes/Server.php';
$result = "";

$server = new Server();
$result = $server->adminData();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
        <title>CMS</title>
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">

        <script src="assets/js/html5shiv.min.js"></script>
        <script src="assets/js/respond.min.js"></script>

    </head>

    <body>
        <div class="main-wrapper">
            <div class="header">
                <?php include './parts/top-nav.php'; ?>
            </div>
            <div class="sidebar" id="sidebar">
                <?php include './parts/side-nav.php'; ?>
            </div>
            <?php while ($row = $result->fetch_assoc()) { ?>

                <div class="page-wrapper">
                    <div class="content">
                        <div class="row">
                            <div class="col-sm-7 col-6">
                                <h4 class="page-title">My Profile</h4>
                            </div>

                            <div class="col-sm-5 col-6 text-right m-b-30">
                                <a href="update-profile.php" class="btn btn-primary btn-rounded"><i class="fa fa-plus"></i> Edit Profile</a>
                            </div>
                        </div>
                        <div class="card-box profile-header" style="min-height: 190px">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="profile-view">
                                        <div class="profile-img-wrap">
                                            <div class="profile-img">
                                                <a href="#"><img class="" src="<?php echo $row['propic'] ?>" onerror="this.onerror=null; this.src='assets/img/user.jpg'" alt=""></a>
                                            </div>
                                        </div>
                                        <div class="profile-basic">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="profile-info-left">
                                                        <h3 class="user-name m-t-0 mb-0">
                                                            <?php
                                                            if ($row['first_name'] == '') {
                                                                echo "Admin";
                                                            } else {
                                                                echo $row['first_name'] . ' ' . $row['last_name'];
                                                            }
                                                            ?></h3>
                                                        <small class="text-muted"><?php echo $row['type'] ?></small>
                                                        <div class="staff-id">ID : <?php echo $row['admin_id'] ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <ul class="personal-info">
                                                        <li>
                                                            <span class="title">Phone:</span>
                                                            <span class="text"><a href="#"><?php echo $row['phone'] ?></a></span>
                                                        </li><?php
                                                        if ($row['phone'] == '') {
                                                            echo '<br>';
                                                        }
                                                        ?>
                                                        <li>
                                                            <span class="title">Email:</span>
                                                            <span class="text"><a href="mailto:<?php echo $row['email'] ?>?Subject=" target="_top"><?php echo $row['email'] ?></a></span>
                                                        </li><?php
                                                    if ($row['email'] == '') {
                                                        echo '<br>';
                                                    }
                                                    ?>
                                                        <li>
                                                            <span class="title">Username:</span>
                                                            <span class="text"><?php echo $row['username'] ?></span>
                                                        </li>
                                                        <li>
                                                            <span class="title">Password:</span>
                                                            <span class="text"><?php echo $row['password'] ?></span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                        
                                </div>
                            </div>
                        </div>

                    </div>
    <?php include './parts/messages.php'; ?>
                </div>
<?php } ?>
        </div>
        <div class="sidebar-overlay" data-reff=""></div>
        <script src="assets/js/jquery-3.2.1.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/app.js"></script>
    </body>

</html>