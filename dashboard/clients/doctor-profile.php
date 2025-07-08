<?php

session_start();
require_once './classes/Server.php';

if (!isset($_SESSION["client_id"])) {
    header("location:logout.php");
}

$data = '';
$result = '';

$server = new Server();
$result = $server->viewData();

if (isset($_POST['view'])) {
    $data = $server->viewDoctorData($_POST);
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
            <?php while ($row = $data->fetch_assoc()) { ?>
                <div class="page-wrapper">
                    <div class="content">
                        <div class="row">
                            <div class="col-sm-4 col-3">
                                <h4 class="page-title">Doctor's Profile</h4>
                            </div>
                            <div class="col-sm-8 col-9 text-right m-b-20">
                                <a href="doctors.php" class="btn btn-primary btn-rounded float-right"><i class="fa fa-user-md"></i> All Doctors</a>
                            </div>
                        </div>
                        <div class="card-box profile-header">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="profile-view">
                                        <div class="profile-img-wrap">
                                            <div class="profile-img">
                                                <a href="#"><img class="" src="<?php echo $row['propic'] ?>" onerror="this.onerror=null; this.src='../gallery/propic/doctors/default.jpg'" alt=""></a>
                                            </div>
                                        </div>
                                        <div class="profile-basic">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="">
                                                        <h3 class="user-name m-t-0 mb-0"><?php echo $row['first_name'] . ' ' . $row['last_name'] ?></h3>
                                                        <small class="text-muted"><?php echo $row['position'] ?>[ <?php echo $row['category'] ?> ]</small><br>
                                                        <small class="text-muted">Department: <?php echo $row['department_id'] ?></small><br>
                                                    </div>
                                                    <br>
                                                    <?php if ($server->average_ratingPoint($row['user_id']) == 0) { ?>
                                                        <span class="fa fa-star"></span>
                                                        <span class="fa fa-star"></span>
                                                        <span class="fa fa-star"></span>
                                                        <span class="fa fa-star"></span>
                                                        <span class="fa fa-star"></span>
                                                    <?php } elseif ($server->average_ratingPoint($row['user_id']) == 1) { ?>
                                                        <span class="fa fa-star checked text-danger"></span>
                                                        <span class="fa fa-star"></span>
                                                        <span class="fa fa-star"></span>
                                                        <span class="fa fa-star"></span>
                                                        <span class="fa fa-star"></span>
                                                    <?php } elseif ($server->average_ratingPoint($row['user_id']) == 2) { ?>
                                                        <span class="fa fa-star checked text-danger"></span>
                                                        <span class="fa fa-star checked text-danger"></span>
                                                        <span class="fa fa-star"></span>
                                                        <span class="fa fa-star"></span>
                                                        <span class="fa fa-star"></span>
                                                    <?php } elseif ($server->average_ratingPoint($row['user_id']) == 3) { ?>
                                                        <span class="fa fa-star checked text-danger"></span>
                                                        <span class="fa fa-star checked text-danger"></span>
                                                        <span class="fa fa-star checked text-danger"></span>
                                                        <span class="fa fa-star"></span>
                                                        <span class="fa fa-star"></span>
                                                    <?php } elseif ($server->average_ratingPoint($row['user_id']) == 4) { ?>
                                                        <span class="fa fa-star checked text-danger"></span>
                                                        <span class="fa fa-star checked text-danger"></span>
                                                        <span class="fa fa-star checked text-danger"></span>
                                                        <span class="fa fa-star checked text-danger"></span>
                                                        <span class="fa fa-star"></span>
                                                    <?php } elseif ($server->average_ratingPoint($row['user_id']) == 5) { ?>
                                                        <span class="fa fa-star checked text-danger"></span>
                                                        <span class="fa fa-star checked text-danger"></span>
                                                        <span class="fa fa-star checked text-danger"></span>
                                                        <span class="fa fa-star checked text-danger"></span>
                                                        <span class="fa fa-star checked text-danger"></span>
                                                    <?php } ?>
                                                </div>
                                                <div class="col-md-7">
                                                    <ul class="personal-info">
                                                        <li>
                                                            <span class="title">Phone:</span>
                                                            <span class="text"><a href="#"><?php echo $row['phone'] ?></a></span>
                                                            <?php
                                                            if ($row['phone'] == "") {
                                                                echo "<br>";
                                                            }
                                                            ?>
                                                        </li>
                                                        <li>
                                                            <span class="title">Email:</span>
                                                            <span class="text"><a href="mailto:<?php echo $row['email'] ?>?Subject=" target="_top"><?php echo $row['email'] ?></a></span>
                                                            <?php
                                                            if ($row['email'] == "") {
                                                                echo "<br>";
                                                            }
                                                            ?>  
                                                        </li>
                                                        <li>
                                                            <span class="title">Birthday:</span>
                                                            <span class="text"><?php echo $row['birthday'] ?></span>
                                                            <?php
                                                            if ($row['birthday'] == "") {
                                                                echo "<br>";
                                                            }
                                                            ?>
                                                        </li>
                                                        <li>
                                                            <span class="title">Gender:</span>
                                                            <span class="text"><?php echo $row['gender'] ?></span>
                                                            <?php
                                                            if ($row['gender'] == "") {
                                                                echo "<br>";
                                                            }
                                                            ?>
                                                        </li>
                                                        <li>
                                                            <span class="title">Religion:</span>
                                                            <span class="text"><?php echo $row['religion'] ?></span>
                                                            <?php
                                                            if ($row['religion'] == "") {
                                                                echo "<br>";
                                                            }
                                                            ?>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-tabs">
                            <ul class="nav nav-tabs nav-tabs-bottom">
                                <li class="nav-item"><a class="nav-link active" href="#about-cont" data-toggle="tab">About</a></li>
                                <li class="nav-item"><a class="nav-link" href="#bottom-tab1" data-toggle="tab">Job Information</a></li>
                                <li class="nav-item"><a class="nav-link" href="#bottom-tab2" data-toggle="tab">Biography</a></li>
                                <li class="nav-item"><a class="nav-link" href="#bottom-tab3" data-toggle="tab">Contact & Authentication</a></li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane show active" id="about-cont">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card-box">
                                                <h3 class="card-title">Personal Information</h3>
                                                <ul class="personal-info">
                                                    <li>
                                                        <span class="title">Marital Status:</span>
                                                        <span class="text"><?php echo $row['marital_status'] ?></span>
                                                        <?php
                                                        if ($row['marital_status'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Nationality:</span>
                                                        <span class="text"><?php echo $row['nationality'] ?></span>
                                                        <?php
                                                        if ($row['nationality'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Age:</span>
                                                        <span class="text"><?php echo $row['age'] ?></span>
                                                        <?php
                                                        if ($row['age'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Blood Group:</span>
                                                        <span class="text"><?php echo $row['blood_group'] ?></span>
                                                        <?php
                                                        if ($row['blood_group'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Smoking Habit:</span>
                                                        <span class="text"><?php echo $row['smoking'] ?></span>
                                                        <?php
                                                        if ($row['smoking'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Hobby:</span>
                                                        <span class="text"><?php echo $row['hobby'] ?></span>
                                                        <?php
                                                        if ($row['hobby'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Interest:</span>
                                                        <span class="text"><?php echo $row['interest'] ?></span>
                                                        <?php
                                                        if ($row['interest'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card-box">
                                                <h3 class="card-title">Highest Educational Information</h3>
                                                <ul class="personal-info">
                                                    <li>
                                                        <span class="title">Institute Name:</span>
                                                        <span class="text"><?php echo $row['edu_institution'] ?></span>
                                                        <?php
                                                        if ($row['edu_institution'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Subject:</span>
                                                        <span class="text"><?php echo $row['edu_subject'] ?></span>
                                                        <?php
                                                        if ($row['edu_subject'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Passing Year:</span>
                                                        <span class="text"><?php echo $row['pass_year'] ?></span>
                                                        <?php
                                                        if ($row['pass_year'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Degree:</span>
                                                        <span class="text"><?php echo $row['degree'] ?></span>
                                                        <?php
                                                        if ($row['degree'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Grade:</span>
                                                        <span class="text"><?php echo $row['grade'] ?></span>
                                                        <?php
                                                        if ($row['grade'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                        <br>
                                                        <br>
                                                        <br>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane" id="bottom-tab1">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card-box">
                                                <h3 class="card-title">Present Job Information</h3>
                                                <ul class="personal-info">
                                                    <li>
                                                        <span class="title">Department:</span>
                                                        <span class="text"><?php echo $server->getDeptNameByID($row['department_id']); ?></span>
                                                        <?php
                                                        if ($row['department_id'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Category:</span>
                                                        <span class="text"><?php echo $row['category'] ?></span>
                                                        <?php
                                                        if ($row['category'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Position:</span>
                                                        <span class="text"><?php echo $row['position'] ?></span>
                                                        <?php
                                                        if ($row['position'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Joining Date:</span>
                                                        <span class="text"><?php echo $row['joining_date'] ?></span>
                                                        <?php
                                                        if ($row['joining_date'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                        <br>
                                                        <br>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card-box">
                                                <h3 class="card-title">Previous Job Information</h3>
                                                <ul class="personal-info">
                                                    <li>
                                                        <span class="title">Previous Company:</span>
                                                        <span class="text"><?php echo $row['last_clocation'] ?></span>
                                                        <?php
                                                        if ($row['edu_institution'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Position:</span>
                                                        <span class="text"><?php echo $row['last_cposition'] ?></span>
                                                        <?php
                                                        if ($row['last_cposition'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Joining Date:</span>
                                                        <span class="text"><?php echo $row['last_cjoining'] ?></span>
                                                        <?php
                                                        if ($row['last_cjoining'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Leaving Date:</span>
                                                        <span class="text"><?php echo $row['last_cleft'] ?></span>
                                                        <?php
                                                        if ($row['last_cleft'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Experience:</span>
                                                        <span class="text"><?php echo $row['experience'] ?></span>
                                                        <?php
                                                        if ($row['experience'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane" id="bottom-tab2">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card-box">
                                                <h3 class="card-title">Short Biography</h3>
                                                <div class="experience-box">
                                                    <ul class="experience-list">
                                                        <li>
                                                            <div class="experience-user">
                                                                <div class="before-circle"></div>
                                                            </div>
                                                            <div class="experience-content">
                                                                <?php echo $row['biography'] ?>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="bottom-tab3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card-box">
                                                <h3 class="card-title">Contact Information</h3>
                                                <ul class="personal-info">
                                                    <li>
                                                        <span class="title">Country:</span>
                                                        <span class="text"><?php echo $row['country'] ?></span>
                                                        <?php
                                                        if ($row['country'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">City:</span>
                                                        <span class="text"><?php echo $row['city'] ?></span>
                                                        <?php
                                                        if ($row['city'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">State:</span>
                                                        <span class="text"><?php echo $row['state'] ?></span>
                                                        <?php
                                                        if ($row['state'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Address:</span>
                                                        <span class="text"><?php echo $row['address'] ?></span>
                                                        <?php
                                                        if ($row['address'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
                                                    </li>
                                                    <li>
                                                        <span class="title">Post Code:</span>
                                                        <span class="text"><?php echo $row['postal_code'] ?></span>
                                                        <?php
                                                        if ($row['postal_code'] == "") {
                                                            echo "<br>";
                                                        }
                                                        ?>
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
            <?php } ?>
        </div>
        <div class="sidebar-overlay" data-reff=""></div>
        <script src="assets/js/jquery-3.2.1.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/app.js"></script>
    </body>


    <!-- Mirrored from dreamguys.co.in/preclinic/template/profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 18 Nov 2019 07:31:33 GMT -->
</html>