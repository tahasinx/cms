<?php
session_start();
$userid = $_SESSION['user_id'];
require_once './classes/Server.php';

if (!isset($_SESSION["user_id"])) {
    header("location:logout.php");
}


$view = '';
$updateData = '';
$response = '';
$result = '';

$server = new Server();
$view = $server->viewData();
$result = $server->DeptData();

if (isset($_POST['save'])) {
    $updateData = $server->updateProfile($_POST);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>CMS</title>
    <style>
        label,
        h3 {
            font-family: 'Rajdhani', sans-serif !important;
            font-weight: bolder !important;
            text-transform: uppercase
        }

        form input,
        textarea {
            border: 1px solid !important;
        }
    </style>
    <?php include './parts/css-links.php'; ?>
</head>

<body>
    <div class="main-wrapper">
        <?php while ($row = $view->fetch_assoc()) { ?>
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
            ?>
            <div class="page-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="page-title"><u>Profile Details</u>
                                <?php echo '<span style="color:red">' . $updateData . '<span style="color:red">'; ?>
                            </h4>
                        </div>
                    </div>
                    <form method="POST" action="" enctype="multipart/form-data">
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
                                        var loadFile = function(event) {
                                            var output = document.getElementById('output');
                                            output.src = URL.createObjectURL(event.target.files[0]);
                                        };
                                    </script>
                                    <div class="profile-basic">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group form-focus">
                                                    <label class="focus-label">First Name<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control floating" name="first_name" value="<?php echo $row['first_name']; ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus">
                                                    <label class="focus-label">Last Name</label>
                                                    <input type="text" class="form-control floating" name="last_name" value="<?php echo $row['last_name']; ?>" required>
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
                                                    <select class="select form-control floating" name="gender">
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
                            <h3 class="card-title">Personal Information</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-focus">
                                        <label class="focus-label">Religion<span class="text-danger">*</span></label>
                                        <input class="form-control floating" name="religion" value="<?php echo $row['religion'] ?>" list="religion" required>
                                        <datalist id="religion">
                                            <option>Islam</option>
                                            <option>Christianity</option>
                                            <option>Judaism</option>
                                            <option>Hinduism</option>
                                            <option>Buddhism</option>
                                            <option>Atheist</option>
                                            <option>Other</option>
                                        </datalist>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus" style="border:1px solid">
                                        <label class="focus-label">Marital Status<span class="text-danger">*</span></label>
                                        <select class="form-control floating select" name="marital_status" required>
                                            <option <?php
                                                    if ($row['marital_status'] == 'Married') {
                                                        echo 'selected';
                                                    }
                                                    ?>>Married</option>
                                            <option <?php
                                                    if ($row['marital_status'] == 'Unmarried') {
                                                        echo 'selected';
                                                    }
                                                    ?>>Unmarried</option>
                                            <option <?php
                                                    if ($row['marital_status'] == 'Divorced') {
                                                        echo 'selected';
                                                    }
                                                    ?>>Divorced</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus" style="border:1px solid">
                                        <label class="focus-label">Age<span class="text-danger">*</span></label>
                                        <select class="form-control floating select" name="age" required>
                                            <option><?php echo $row['age'] ?></option>
                                            <option disabled>Select</option>
                                            <?php
                                            for ($i = 18; $i <= 100; $i++) {
                                            ?>
                                                <option><?php echo $i; ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group form-focus">
                                        <label class="focus-label">Nationality<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control floating" name="nationality" value="<?php echo $row['nationality'] ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus">
                                        <label class="focus-label">Personal Interest</label>
                                        <input type="text" class="form-control floating" name="interest" value="<?php echo $row['interest'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus">
                                        <label class="focus-label">Hobby</label>
                                        <input type="text" class="form-control floating" name="hobby" value="<?php echo $row['hobby'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus" style="border:1px solid">
                                        <label class="focus-label">Blood Group<span class="text-danger">*</span></label>
                                        <select class="form-control floating select" name="blood_group" required>
                                            <option <?php
                                                    if ($row['blood_group'] == 'A+') {
                                                        echo 'selected';
                                                    }
                                                    ?>>A+</option>
                                            <option <?php
                                                    if ($row['blood_group'] == 'A-') {
                                                        echo 'selected';
                                                    }
                                                    ?>>A-</option>
                                            <option <?php
                                                    if ($row['blood_group'] == 'B+') {
                                                        echo 'selected';
                                                    }
                                                    ?>>B+</option>
                                            <option <?php
                                                    if ($row['blood_group'] == 'B-') {
                                                        echo 'selected';
                                                    }
                                                    ?>>B-</option>
                                            <option <?php
                                                    if ($row['blood_group'] == 'AB+') {
                                                        echo 'selected';
                                                    }
                                                    ?>>AB+</option>
                                            <option <?php
                                                    if ($row['blood_group'] == 'AB-') {
                                                        echo 'selected';
                                                    }
                                                    ?>>AB-</option>
                                            <option <?php
                                                    if ($row['blood_group'] == 'O+') {
                                                        echo 'selected';
                                                    }
                                                    ?>>O+</option>
                                            <option <?php
                                                    if ($row['blood_group'] == 'O-') {
                                                        echo 'selected';
                                                    }
                                                    ?>>O-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus" style="border:1px solid">
                                        <label class="focus-label">Smoking Habit<span class="text-danger">*</span></label>
                                        <select class="form-control floating select" name="smoking" required>
                                            <option <?php
                                                    if ($row['smoking'] == 'Non-smoker') {
                                                        echo 'selected';
                                                    }
                                                    ?>>Non-smoker</option>
                                            <option <?php
                                                    if ($row['smoking'] == 'Chain-smoker') {
                                                        echo 'selected';
                                                    }
                                                    ?>>Chain-smoker</option>
                                            <option <?php
                                                    if ($row['smoking'] == 'Light/Social smoker') {
                                                        echo 'selected';
                                                    }
                                                    ?>>Light/Social smoker</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-box">
                            <h3 class="card-title">Contact Information</h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-focus">
                                        <label class="focus-label">Address<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control floating" name="address" value="<?php echo $row['address'] ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus">
                                        <label class="focus-label">Country<span class="text-danger">*</span></label>
                                        <select class="form-control floating select" name="country" required>
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
                            <h3 class="card-title">Highest Education</h3>
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
                        <?php if ($row['is_certified'] == 0) { ?>
                            <div class="card-box">
                                <h3 class="card-title">Medical License/ Upload License Certificate<span class="text-danger">: PDF*</span></h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <input type="file" class="form-control floating" name="certificate" accept="application/pdf" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
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
                                            <input type="text" class="form-control floating datetimepicker" value="<?php echo $row['last_cjoining'] ?>" name="last_cjoining">
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
                                        <select class="select form-control floating" name="department_id" required>
                                            <option value="<?php echo $row['department_id']; ?>" selected><?php echo $server->getDeptNameByID($row['department_id']) ?></option>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                while ($data = $result->fetch_assoc()) {
                                            ?>
                                                    <option value="<?php echo $data['dept_id'] ?>"><?php echo $data['dept_name'] ?></option>
                                            <?php
                                                }
                                            } else {
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
                                        <input type="text" class="form-control floating" name="username" value="<?php echo $row['username']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus">
                                        <label class="focus-label">Password<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control floating" name="password" value="<?php echo $row['password']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus">
                                        <label class="focus-label">User ID <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control floating" value="<?php echo $row['user_id']; ?>" readonly>
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