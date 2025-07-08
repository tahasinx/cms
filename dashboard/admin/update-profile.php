<?php

session_start();
$adminid = $_SESSION['admin_id'];

if (!isset($_SESSION["admin_id"])) {
    header("location:logout.php");
}

require_once './classes/Server.php';
$result = "";
$update = "";

$server = new Server();
$result = $server->adminData();
if (isset($_POST['update'])) {
    $update = $server->updateAdmin($_POST);
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
            label, h3{
                font-family: 'Rajdhani', sans-serif !important;
            }
            form input,textarea{
                border: 1px solid !important;
            }

        </style>
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
                            <div class="col-sm-12">
                                <h4 class="page-title">Edit Profile<?php echo $update; ?></h4>
                            </div>
                        </div>
                        <form method="POST" action = "" enctype="multipart/form-data">
                            <div class="card-box">
                                <h3 class="card-title">Basic Informations</h3>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="profile-img-wrap">
                                            <img class="inline-block" src="<?php echo $row['propic'] ?>" onerror="this.onerror=null; this.src='assets/img/user.jpg'" alt="user" id="output">
                                            <div class="fileupload btn">
                                                <span class="btn-text">change</span>
                                                <input class="upload" type="file" onchange="loadFile(event)" name="propic">
                                            </div>
                                        </div>
                                        <script>
                                            var loadFile = function (event) {
                                                var output = document.getElementById('output');
                                                output.src = URL.createObjectURL(event.target.files[0]);
                                            };
                                        </script>
                                        <?php
                                        $oldpic = $row['propic'];
                                        $_SESSION['oldpic'] = $oldpic;
                                        ?>
                                        <div class="profile-basic">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group form-focus">
                                                        <label class="focus-label">First Name<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control floating" name="first_name" value="<?php echo $row['first_name'] ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-focus">
                                                        <label class="focus-label">Last Name</label>
                                                        <input type="text" class="form-control floating" name="last_name" value="<?php echo $row['last_name'] ?>" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-focus">
                                                        <label class="focus-label">Email<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control floating" name="email" value="<?php echo $row['email'] ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-focus">
                                                        <label class="focus-label">Phone<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control floating" name="phone" value="<?php echo $row['phone'] ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-box">
                                <h3 class="card-title">Authentication Data</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">Admin ID<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control floating" value="<?php echo $row['admin_id'] ?>" name="admin_id" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">Username<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control floating" value="<?php echo $row['username'] ?>" name="username" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">Password<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control floating" value="<?php echo $row['password'] ?>" name="password" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center m-t-20">
                                <button class="btn btn-primary submit-btn" type="submit" name="update" >Update</button>
                            </div>
                        </form>
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
        <script src="assets/js/select2.min.js"></script>
        <script src="assets/js/moment.min.js"></script>
        <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
        <script src="assets/js/app.js"></script>
    </body>

</html>