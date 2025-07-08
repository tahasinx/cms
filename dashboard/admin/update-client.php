<?php

session_start();
$adminid = $_SESSION['admin_id'];

if (!isset($_SESSION["admin_id"])) {
    header("location:logout.php");
}
require_once './classes/Server.php';
$result = '';
$data = '';
$update = '';

$server = new Server();
$result = $server->getClientData();
$data = $server->adminData();

if (isset($_POST['update'])) {
    $update = $server->UpdateClientData($_POST);
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

            <?php echo $update; ?>
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
                            <form method="POST" action = "" enctype="multipart/form-data">
                                <input type="hidden" value="<?php echo $row['client_id'] ?>" name="client_id"/>
                                <div class="card-box">
                                    <h3 class="card-title">Basic Informations</h3>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="profile-img-wrap">
                                                <img class="inline-block" src="<?php echo $row['propic'] ?>" onerror="this.onerror=null; this.src='assets/img/user.jpg'" id="output">
                                                <div class="fileupload btn">
                                                    <span class="btn-text">upload</span>
                                                    <input class="upload" type="file" onchange="loadFile(event)" name="propic" >
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
                                                            <input type="text" class="form-control floating" value="<?php echo $row['first_name'] ?>" name = "first_name" required >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-focus">
                                                            <label class="focus-label">Last Name</label>
                                                            <input type="text" class="form-control floating" value="<?php echo $row['last_name'] ?>" name = "last_name" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-focus">
                                                            <label class="focus-label">Birth Date<span class="text-danger">*</span></label>
                                                            <div class="cal-icon">
                                                                <input class="form-control floating datetimepicker" value="<?php echo $row['birthday'] ?>" type="text" name="birthday" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-focus select-focus">
                                                            <label class="focus-label">Gender<span class="text-danger">*</span></label>
                                                            <select class="select form-control floating" name="gender" required>
                                                                <option value="Male" <?php
                                                                if ($row['gender'] == 'Male') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>Male</option>
                                                                <option value="Female" <?php
                                                                if ($row['gender'] == 'Female') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>Female</option>
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
                                                <input type="text" class="form-control floating" value="<?php echo $row['address'] ?>" name = "address" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">Country<span class="text-danger">*</span></label>
                                                <select class = "form-control floating select" name = "country" required>
                                                    <option selected><?php echo $row['country'] ?></option>
                                                    <?php include '../../dashboard/countries.php';
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
                                                <input type="text" class="form-control floating" value="<?php echo $row['state'] ?>" name="state">
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
                                                <input type="text" class="form-control floating" value="<?php echo $row['phone'] ?>" name="phone" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">Email</label>
                                                <input type="text" name="email" value="<?php echo $row['email'] ?>" class="form-control floating">
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
                                                <input type="text" class="form-control floating" name = "username" value = "<?php echo $row['username'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">Password<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control floating" name = "password" value = "<?php echo $row['password'] ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="m-t-20 text-center">
                                    <button class="btn btn-primary submit-btn" type="submit" name="update">Update</button>
                                </div>
                            </form>
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