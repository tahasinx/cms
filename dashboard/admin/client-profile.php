<?php

session_start();
$adminid = $_SESSION['admin_id'];

if (!isset($_SESSION["admin_id"])) {
    header("location:logout.php");
}
require_once './classes/Server.php';
$result = '';
$result2 = '';
$delete = '';
$change = '';
$data = '';

$server = new Server();
$result = $server->getClientData();
$data = $server->adminData();

if (isset($_POST['delete'])) {
    $delete = $server->DeleteClient($_POST);
}
if (isset($_POST['change'])) {
    $change = $server->ChangeClientStatus($_POST);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>CMS</title>

        <?php include './parts/css-links.php'; ?>

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
            <?php } ?>

            <?php echo $change; ?>
            <div class="page-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-sm-4 col-3">
                            <h4><u>Client Profile</u></h4>
                        </div>
                        <div class="col-sm-8 col-9 text-right m-b-20">
                            <a href="" class="btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Doctor</a>
                        </div>
                    </div>

                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <div class="card-box profile-header" style="min-height: 190px">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="profile-view">
                                            <div class="profile-img-wrap">
                                                <div class="profile-img">
                                                    <img class="" src="<?php echo $row['propic'] ?>" onerror="this.onerror=null; this.src='assets/img/user.jpg'" alt="">
                                                </div>
                                            </div>
                                            <div class="profile-basic">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <div class="profile-info-left">
                                                            <h3 class="user-name m-t-0 mb-0">
                                                                <?php echo $row['first_name'] . ' ' . $row['last_name']; ?>
                                                            </h3>
                                                            <small class="text-muted"><?php echo $row['address'] ?></small>
                                                            <div class="staff-id">ID : <?php echo $row['client_id'] ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <ul class="personal-info">
                                                            <li>
                                                                <span class="title">Phone:</span>
                                                                <span class="text"><a href="#"><?php echo $row['phone'] ?></a></span>
                                                            </li>
                                                            <?php
                                                            if ($row['phone'] == '') {
                                                                echo '<br>';
                                                            }
                                                            ?>
                                                            <li>
                                                                <span class="title">Email:</span>
                                                                <span class="text"><a href="mailto:<?php echo $row['email'] ?>?Subject=" target="_top"><?php echo $row['email'] ?></a></span>
                                                            </li>
                                                            <?php
                                                            if ($row['email'] == '') {
                                                                echo '<br>';
                                                            }
                                                            ?>
                                                            <li>
                                                                <span class="title">Birthday:</span>
                                                                <span class="text"><?php echo $row['birthday'] ?></span>
                                                            </li>
                                                            <li>
                                                                <span class="title">Country:</span>
                                                                <span class="text"><?php echo $row['country'] ?></span>
                                                            </li>
                                                            <li>
                                                                <span class="title">City:</span>
                                                                <span class="text"><?php echo $row['city'] ?></span>
                                                            </li>
                                                            <li>
                                                                <span class="title">State:</span>
                                                                <span class="text"><?php echo $row['state'] ?></span>
                                                            </li>
                                                            <?php
                                                            if ($row['state'] == '') {
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
        <?php include './parts/js-links.php'; ?>

    </body>


</html>