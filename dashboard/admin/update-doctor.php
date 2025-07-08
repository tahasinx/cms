<?php

session_start();
require_once './classes/Server.php';

//if (!isset($_SESSION["user_id"])) {
//    header("location:logout.php");
//}
$data = '';
$dept = '';
$updateData = '';
$result = "";

$server = new Server();
$result = $server->adminData();
$dept = $server->ActiveDeptData();

if (isset($_POST['show'])) {
    $data = $server->viewDoctorData($_POST);
}

if (isset($_POST['save'])) {
    $updateData = $server->updateDoctor($_POST);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>CMS</title>
        <style>
            label, h3{
                font-family: 'Rajdhani', sans-serif !important;
            }
            form input,textarea{
                border: 1px solid !important;
            }

        </style>
        <?php include './parts/css-links.php'; ?>
    </head>
    <body>
        <div class="main-wrapper">

            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="header">
                    <?php include './parts/top-nav.php'; ?>
                </div>

                <div class="sidebar" id="sidebar">
                    <?php include './parts/side-nav.php'; ?>
                </div>
            <?php } ?>
            
            <?php echo $updateData; ?>
            <?php while ($row = $data->fetch_assoc()) { ?>
            <?php $dept_id = $row['department_id']; ?>
                <div class="page-wrapper">
                    <div class="content">
                        <div class="row">
                            <div class="col-sm-4 col-3">
                                <h4 class="page-title"><u>Update Doctor's Profile</u>
                                    <?php
                                    echo '<span style="color:red">' . $updateData . '</span>';
                                    ?>
                                </h4>
                            </div>
                            <div class="col-sm-8 col-9 text-right m-b-20">
                                <a href="doctors.php" class="btn btn-primary btn-rounded float-right"><i class="fa fa-user-md"></i> Doctors</a>
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
                                            <?php
                                            $oldpic = $row['propic'];
                                            $_SESSION['oldpic'] = $oldpic;
                                            ?>
                                        </div>
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
                                                        <input type="text" class="form-control floating" name = "first_name" value = "<?php echo $row['first_name']; ?>" required >
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-focus">
                                                        <label class="focus-label">Last Name</label>
                                                        <input type="text" class="form-control floating" name = "last_name" value = "<?php echo $row['last_name']; ?>" required>
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
                                                        <select class="select form-control floating" name="gender" >
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
                                                <option selected><?php echo $row['country'] ?></option>
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
                                            <input type="text" class="form-control floating" value="<?php echo $row['state'] ?>" name="state">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">Post Code<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control floating" value="<?php echo $row['postal_code'] ?>" name="postal_code" required>
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
                                            <label class="focus-label">Email<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control floating" value="<?php echo $row['email'] ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-box">
                                <h3 class="card-title">Highest Education Informations</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">Institution<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control floating" value="<?php echo $row['edu_institution'] ?>" name="edu_institution" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">Subject<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control floating" value="<?php echo $row['edu_subject'] ?>" name="edu_subject" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">Passing Year/Date<span class="text-danger">*</span></label>
                                            <div class="cal-icon">
                                                <input type="text" class="form-control floating datetimepicker" value="<?php echo $row['pass_year'] ?>" name="pass_year" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">Degree<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control floating" value="<?php echo $row['degree'] ?>" name="degree" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">Grade<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control floating" value="<?php echo $row['grade'] ?>" name="grade" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-box">
                                <h3 class="card-title">Experience/Last service</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">Company Name</label>
                                            <input type="text" class="form-control floating" value="<?php echo $row['last_company'] ?>" name="last_company">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">Location</label>
                                            <input type="text" class="form-control floating" value="<?php echo $row['last_clocation'] ?>" name="last_clocation">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">Job Position</label>
                                            <input type="text" class="form-control floating" value="<?php echo $row['last_cposition'] ?>" name="last_cposition">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">Period From</label>
                                            <div class="cal-icon">
                                                <input type="text" class="form-control floating datetimepicker" value="<?php echo $row['last_cjoining'] ?>" name="last_cjoining" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">Period To</label>
                                            <div class="cal-icon">
                                                <input type="text" class="form-control floating datetimepicker" value="<?php echo $row['last_cleft'] ?>" name="last_cleft">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">Experience[ Total Period ]</label>
                                            <div class="cal-icon">
                                                <input type="text" class="form-control floating" value="<?php echo $row['experience'] ?>" name="experience">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-box">
                                <h3 class="card-title">Job Information</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-focus select-focus">
                                            <label class="focus-label">Department<span class="text-danger">*</span></label>
                                            <select class="select form-control floating" name="department_id">
                                                <option selected value="<?php echo $dept_id ?>"><?php echo $server->getDeptNameByID($dept_id);?></option>
                                                <?php if ($dept->num_rows > 0) {
                                                while ($x = $dept->fetch_assoc()) {?>
                                                   <option value="<?php echo $x['dept_id'] ?>"><?php echo $x['dept_name'] ?></option>
                                                <?php }
                                                }
                                                else{
                                                    echo '<option>N/A</option>';
                                                }
                                                ?>
                                               
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">Position<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control floating" value="<?php echo $row['position'] ?>" name="position" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-focus select-focus">
                                            <label class="focus-label">Category<span class="text-danger">*</span></label>
                                            <select class="select form-control floating" name="category">
                                                <option value="<?php echo $row['category'] ?>" selected><?php echo $row['category'] ?></option>
                                                <?php include "../doctor-types.php"; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">Joining Date<span class="text-danger">*</span></label>
                                            <div class="cal-icon">
                                                <input type="text" class="form-control floating datetimepicker" value="<?php echo $row['joining_date'] ?>" name="joining_date" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-box" style="min-height:300px">
                                <h3 class="card-title">Biography / Personal Record</h3>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">Short Biography<span class="text-danger">*</span></label>
                                            <textarea class="form-control floating" style="min-height: 200px;resize: none" cols="30" name="biography" required><?php echo $row['biography'] ?></textarea>
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
                                            <input type="text" class="form-control floating" name = "username" value = "<?php echo $row['username']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">Password<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control floating" name = "password" value = "<?php echo $row['password']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">User ID <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control floating" name="doctor_id" value = "<?php echo $row['user_id']; ?>" name="userid" readonly>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary submit-btn" type="submit" name="save">Submit</button>
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


    <!-- Mirrored from dreamguys.co.in/preclinic/template/edit-profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 18 Nov 2019 07:31:38 GMT -->
</html>