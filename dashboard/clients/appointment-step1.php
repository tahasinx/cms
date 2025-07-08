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
$depdata = "";
$inserterrors = "";

$server = new Server();
$result = $server->viewData();
$depdata = $server->DeptData();

if (isset($_POST['next'])) {
    $inserterrors = $server->appointment_Step1($_POST);
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
                            <h4 class="page-title"><u>Create Appointment:</u><span style="color:orangered">STEP-1</span><?php echo $inserterrors; ?></h4>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <form method="POST" action="">
                               <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Department<span class="text-danger">*</span></label>
                                            <select class="form-control" type="text" name="dept_id" required>
                                                <?php while ($row = $depdata->fetch_assoc()) { ?>
                                                    <option value="<?php echo $row['dept_id'] ?>"><?php echo $row['dept_name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Doctor Type<span class="text-danger">*</span></label>
                                            <select class="form-control" type="text" name="doctor_type" required>
                                                <?php include "../doctor-types.php"; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Issue / Sickness Description<span class="text-danger">*</span></label>
                                            <textarea class="form-control" rows="5" cols="30" name="issue" required></textarea>
                                        </div>
                                    </div>
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
                <?php include './parts/messages.php'; ?>
            </div>
        </div>
        <?php include './parts/js-links.php'; ?>

    </body>
</html>