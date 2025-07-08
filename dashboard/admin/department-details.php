<?php

session_start();
$adminid = $_SESSION['admin_id'];

if (!isset($_SESSION["admin_id"])) {
    header("location:logout.php");
}

require_once './classes/Server.php';
$output = "";
$result = "";
$data = "";
$totalDoc ="";

$server = new Server();
$data = $server->adminData();

$result = $server->getDeptDataByID();
$output = $server->DoctorsByDept();
$totalDoc = $server->TotalDoctorsBy_Dept();



if (isset($_POST['update'])) {
    $output = $server->updateDeptData($_POST);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">
        <title>CMS</title>
        <?php include './parts/css-links.php'; ?>
        <style>
            h4{
                font-family: 'Ubuntu', sans-serif;
            }

        </style>
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
            <div class="page-wrapper">
                <div class="content">
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <div class="row">
                            <div class="col-sm-8 col-3">
                                <h4><u>Department Details:</u><mark><?php echo $row['dept_name'] ?></mark></h4>
                            </div>
                            <div class="col-sm-4 col-9 text-right m-b-20">
                                <a href="add-dept.php" class="btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add New</a>
                                <a href="departments.php" class="btn btn-primary btn-rounded float-right"><i class="fa fa-book"></i> View All</a>
                            </div>
                        </div>
                        <div class="card-box">
                            <h3 class="card-title"></h3>
                            <div class="row">
                                <div class="col-sm-2">
                                    <img alt="" src="<?php echo $row['picture'] ?>" style="height: 150px;width:150px" onerror="this.onerror=null; this.src='assets/img/medical.jpg'" alt="">
                                </div>
                                <div class="col-sm-4">
                                    <h4><b>Basic Informations</b></h4>
                                    <table>
                                        <tr>
                                            <td>Name:</td>
                                            <td><?php echo $row['dept_name'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>ID:</td>
                                            <td><?php echo $row['dept_id']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Status:</td>
                                            <td>
                                                <?php
                                                if ($row['status'] == 1) {
                                                    echo '<span style="color:green">Active</span>';
                                                } else {
                                                    echo '<span style="color:red">Inactive</span>';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ratings:</td>
                                            <td>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-sm-6">
                                    <h4><b>Short Description</b></h4>
                                    <?php echo $row['description'] ?>
                                </div>


                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <h4><mark><b>Department Doctors&nbsp;[&nbsp;<span style="color:orangered"> <?php echo $totalDoc; ?></span> &nbsp;]</b></mark></h4>
                    <div class="row doctor-grid">
                        <?php
                        if ($output->num_rows > 0) {
                            while ($row = $output->fetch_assoc()) {
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
                                                <form method="GET" action="doctor-profile.php" >
                                                    <input type="hidden" value="<?php echo $row['user_id'] ?>" name="doctor_id"/>
                                                    <button type="submit" class="dropdown-item" name="view" style="border: none;background: none;outline: none;width:100%;cursor: pointer" />
                                                    <i class="fa fa-user m-r-5"></i> Profile
                                                    </button>
                                                </form>
                                                <form method="POST" action="update-doctor.php">
                                                    <input type="hidden" value="<?php echo $row['user_id'] ?>" name="doctor_id"/>
                                                    <button type="submit" class="dropdown-item" name="show" style="border: none;background: none;outline: none;width:100%;cursor: pointer" />
                                                    <i class="fa fa-pencil m-r-5"></i> Edit
                                                    </button>
                                                </form>
                                                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
                                                    <input type="hidden" value="<?php echo $row['user_id'] ?>" name="doctor_id"/>
                                                    <?php if ($row['doctor_status'] == 1) { ?>
                                                        <input type="hidden" value="0" name="status"/>
                                                        <button type="submit" class="dropdown-item" name="change" style="border: none;background: none;outline: none;width:100%;cursor: pointer" />
                                                        <i class="fa fa-lock m-r-5"></i> Block
                                                        </button>
                                                    <?php } else {
                                                        ?>
                                                        <input type="hidden" value="1" name="status"/>
                                                        <button type="submit" class="dropdown-item" name="change"  style="border: none;background: none;outline: none;width:100%;cursor: pointer" />
                                                        <i class="fa fa-unlock m-r-5"></i> Unblock
                                                        </button>
                                                    <?php }
                                                    ?>
                                                </form>
                                                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
                                                    <input type="hidden" value="<?php echo $row['id'] ?>" name="serial"/>
                                                    <button type="submit" class="dropdown-item" name="delete" style="border: none;background: none;outline: none;width:100%;cursor: pointer" onclick="return confirm('Are you sure?');">
                                                        <i class="fa fa-trash-o m-r-5"></i> Delete
                                                    </button>
                                                </form>

                                            </div>
                                        </div>
                                        <h4 class="doctor-name text-ellipsis"><a href="profile.html"><?php echo $row['first_name'] . " " . $row['last_name'] ?></a></h4>
                                        <div class="doc-prof"><?php echo $row['category'] ?></div>
                                        <?php if ($row['profile_status'] == 1) { ?>
                                            Profile Status: <span style="color:green">COMPLETE</span>
                                        <?php } else {
                                            ?>
                                            Status: <span style="color:red">INCOMPLETE</span>
                                        <?php }
                                        ?>
                                        <br/>
                                        <?php if ($row['doctor_status'] == 1) { ?>
                                            Profile Status: <span style="color:green">ACTIVE</span>
                                        <?php } else {
                                            ?>
                                            Status: <span style="color:red">BLOCKED</span>
                                        <?php }
                                        ?>

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