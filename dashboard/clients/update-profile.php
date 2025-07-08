<?php

session_start();
if (!isset($_SESSION["client_id"])) {
    header("location:logout.php");
}

require_once './classes/Server.php';
$result = "";
$updateError = "";

$server = new Server();
$result = $server->viewData();

if (isset($_POST['update'])) {
    $updateError = $server->updateProfile($_POST);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

        <?php include './parts/css-links.php'; ?>
        <style>
            label, h3{
                font-family: 'Rajdhani', sans-serif !important;
                font-weight: bolder !important;
                text-transform: uppercase
            }
            form input{
                border: 1px solid !important;
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
                <div class="page-wrapper">
                    <div class="content">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-title"><u>Update Profile</u>
                                    <?php echo '<span style="color:red">' . $updateError . '<span style="color:red">'; ?>
                                </h4>
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
                                                <span class="btn-text">upload</span>
                                                <input class="upload" type="file" onchange="loadFile(event)" name="propic">
                                            </div>
                                        </div>
                                        <?php
                                        $oldpic = $row['propic'];
                                        $_SESSION['oldpic'] = $oldpic;
                                        ?>
                                        <script>
                                            var loadFile = function (event) {
                                                var output = document.getElementById('output');
                                                output.src = URL.createObjectURL(event.target.files[0]);
                                            };
                                        </script>
                                        <div class="profile-basic">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group form-focus">
                                                        <label class="focus-label">First Name<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control floating" name = "first_name" value="<?php echo $row['first_name'] ?>" required >
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-focus">
                                                        <label class="focus-label">Last Name</label>
                                                        <input type="text" class="form-control floating" name = "last_name" value="<?php echo $row['last_name'] ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-focus">
                                                        <label class="focus-label">Birth Date<span class="text-danger">*</span></label>
                                                        <div class="cal-icon">
                                                            <input class="form-control floating datetimepicker" type="text" name="birthday" value="<?php echo $row['birthday'] ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-focus select-focus">
                                                        <label class="focus-label">Gender<span class="text-danger">*</span></label>
                                                        <select class="select form-control floating" name="gender" required>
                                                            <?php if ($row['gender'] == 'Male') { ?>
                                                                <option value="Male" selected>Male</option>
                                                                <option value="Female">Female</option>
                                                            <?php } else {
                                                                ?>
                                                                <option value="Male">Male</option>
                                                                <option value="Female" selected>Female</option>
                                                            <?php }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-box">
                                <h3 class="card-title">Contact Informations</h3>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">Address<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control floating" name = "address" value="<?php echo $row['address'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">Country<span class="text-danger">*</span></label>
                                            <select class = "form-control floating select" name = "country" required>
                                                <option><?php echo $row['country'] ?></option>
                                                <?php include '../countries.php';
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">City<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control floating" name="city" value="<?php echo $row['city'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">State</label>
                                            <input type="text" class="form-control floating" name="state" value="<?php echo $row['state'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">Post Code<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control floating" name="postal_code" value="<?php echo $row['postal_code'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">Phone Number<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control floating" name="phone" value="<?php echo $row['phone'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">Email</label>
                                            <input type="text" name="email" class="form-control floating" value="<?php echo $row['email'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-box">
                                <h3 class="card-title">Authentication Information </h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">Username<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control floating" name = "username" value="<?php echo $row['username'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">Password<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control floating" name = "password" value="<?php echo $row['password'] ?>" required>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary submit-btn" type="submit" name="update">Submit</button>
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