<?php
session_start();
$userid = $_SESSION['user_id'];
require_once './classes/Server.php';

$data = '';
$saveData = '';
$response = '';

$server = new Server();
$data = $server->viewData();

if (isset($_POST['save'])) {

    $saveData = $server->completeProfile($_POST);

}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>CMS</title>
        <style>
            .center{
                height: 20%;
                width: 35%;
                border: 1px solid;
                margin: 15% auto;
                padding: 2%
            }
            h3{
                color: red;
                font-family: 'Rajdhani', sans-serif;

            }
        </style>
        <?php include './parts/css-links.php'; ?>

    </head>

    <body>

        <div class="main-wrapper">
            <?php while ($row = $data->fetch_assoc()) { ?>

                <div class="header">
                    <?php include './parts/top-nav.php'; ?>
                </div>

                <div class="sidebar" id="sidebar">
                    <?php include './parts/clean-sidenav.php'; ?>
                </div>

                <div class="page-wrapper">
                    <div class="content">
                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">
                                <h4 class="page-title"><u>Profile Details</u>
                                    <?php echo $saveData ?><?php if (!empty($response)) { ?>
                                        <div class="response <?php echo $response["type"]; ?>
                                             ">
                                                 <?php echo $response["message"]; ?>
                                        </div>
                                        <?php }
                                    ?></h4>
                                <form method = "POST" action = "" enctype = "multipart/form-data">
                                    <div class = "row">
                                        <div class = "col-sm-6">
                                            <div class = "form-group">
                                                <label>First Name <span class = "text-danger">*</span></label>
                                                <input class = "form-control" type = "text" name = "first_name" value = "<?php echo $row['first_name']; ?>" required >
                                            </div>
                                        </div>
                                        <div class = "col-sm-6">
                                            <div class = "form-group">
                                                <label>Last Name</label>
                                                <input class = "form-control" type = "text" name = "last_name" value = "<?php echo $row['last_name']; ?>" required>
                                            </div>
                                        </div>
                                        <div class = "col-sm-6">
                                            <div class = "form-group">
                                                <label>Username <span class = "text-danger">*</span></label>
                                                <input class = "form-control" type = "text" name = "username" value = "<?php echo $row['username']; ?>" required>
                                            </div>
                                        </div>
                                        <div class = "col-sm-6">
                                            <div class = "form-group">
                                                <label>User ID<span class = "text-danger">*</span></label>
                                                <input class = "form-control" type = "text" value = "<?php echo $row['user_id']; ?>" required readonly>
                                            </div>
                                        </div>
                                        <div class = "col-sm-6">
                                            <div class = "form-group">
                                                <label>Category <span class = "text-danger">*</span></label>
                                                <input class = "form-control" type = "text" list = "category" name = "category" required>
                                                <datalist id = "category">
                                                    <option>General</option>
                                                    <option>Specialist</option>
                                                </datalist>
                                            </div>
                                        </div>
                                        <div class = "col-sm-6">
                                            <div class = "form-group">
                                                <label>Department <span class = "text-danger">*</span></label>
                                                <input class = "form-control" type = "text" list = "dept" name = "department_id" required>
                                                <datalist id = "dept">
                                                    <option>x</option>
                                                    <option>y</option>
                                                    <option>z</option>
                                                </datalist>
                                            </div>
                                        </div>
                                        <div class = "col-sm-6">
                                            <div class = "form-group">
                                                <label>Email <span class = "text-danger">*</span></label>
                                                <input class = "form-control" type = "email" value = "<?php echo $row['email']; ?>" required readonly>
                                            </div>
                                        </div>
                                        <div class = "col-sm-6">
                                            <div class = "form-group">
                                                <label>Password <span class = "text-danger">*</span></label>
                                                <input class = "form-control" type = "text" name = "password" value = "<?php echo $row['password']; ?>" required>
                                            </div>
                                        </div>
                                        <div class = "col-sm-6">
                                            <div class = "form-group">
                                                <label>Date of Birth <span class = "text-danger">*</span></label>
                                                <div class = "cal-icon">
                                                    <input type = "text" class = "form-control datetimepicker" name = "birthday" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class = "col-sm-6">
                                            <div class = "form-group gender-select">
                                                <label class = "gen-label">Gender: <span class = "text-danger">*</span></label>
                                                <div class = "form-check-inline">
                                                    <label class = "form-check-label">
                                                        <input type = "radio" class = "form-check-input" value = "Male" name = "gender" required>Male
                                                    </label>
                                                </div>
                                                <div class = "form-check-inline">
                                                    <label class = "form-check-label">
                                                        <input type = "radio" class = "form-check-input" value = "Female" name = "gender">Female
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class = "col-sm-12">
                                            <div class = "row">
                                                <div class = "col-sm-12">
                                                    <div class = "form-group">
                                                        <label>Address <span class = "text-danger">*</span></label>
                                                        <input type = "text" class = "form-control" name = "address" required>
                                                    </div>
                                                </div>
                                                <div class = "col-sm-12">
                                                    <div class = "form-group">
                                                        <label> Experience/Previous Service</label>
                                                        <input type = "text" class = "form-control" name = "experience" >
                                                    </div>
                                                </div>
                                                <div class = "col-sm-6 col-md-6 col-lg-3">
                                                    <div class = "form-group">
                                                        <label>Country <span class = "text-danger">*</span></label>
                                                        <select class = "form-control select" name = "country" required>
                                                            <?php include '../countries.php';
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-3">
                                                    <div class="form-group">
                                                        <label>City <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="city" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-3">
                                                    <div class="form-group">
                                                        <label>State/Province</label>
                                                        <input type="text" class="form-control" name="state">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-3">
                                                    <div class="form-group">
                                                        <label>Postal Code <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="postal_code" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Phone <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="phone" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Avatar[150*150] <span class="text-danger">*</span></label>
                                                <div class="profile-upload">
                                                    <div class="upload-img">
                                                        <img alt="" src="assets/img/user.jpg" id="output">
                                                    </div>
                                                    <div class="upload-input">
                                                        <input type="file" accept="image/*" class="form-control" onchange="loadFile(event)" name="propic" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                                var loadFile = function (event) {
                                                    var output = document.getElementById('output');
                                                    output.src = URL.createObjectURL(event.target.files[0]);
                                                };
                                            </script>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Medical Degrees<span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="3" cols="30" required name="degree"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Short Biography <span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="3" cols="30" required name="biography"></textarea>
                                    </div>
                                    <div class="m-t-20 text-center">
                                        <button class="btn btn-primary submit-btn" type="submit" name="save">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php include './parts/messages.php'; ?>
                </div>
            <?php } ?>
        </div>
        <!--scripts-->
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