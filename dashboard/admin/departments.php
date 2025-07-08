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
$result = $server->viewDeptData();
$result2 = $server->viewDeptData();
$data = $server->adminData();

if (isset($_POST['delete'])) {
    $delete = $server->deleteDept($_POST);
}
if (isset($_POST['change'])) {
    $change = $server->ChangeDeptStatus($_POST);
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

            <?php
            echo $change;
            echo $delete;
            ?>
            <div class="page-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-sm-4 col-3">
                            <form method="POST" action="dept-search-result.php">
                                <table>
                                    <td><input type="" placeholder="Department ID..." name="dept_id" list="id" class="form-control" style="min-width: 200px" autocomplete="off" required></td>
                                    <td><input type="submit" name="show" value="search" class="btn btn-primary" style="height: 40px"></td>
                                    <td><?php echo $delete ?></td>
                                    <datalist id="id">
                                        <?php while ($rows = $result2->fetch_assoc()) { ?>
                                            <option value="<?php echo $rows['dept_id'] ?>"><?php
                                                $deptid = $rows['dept_id'];
                                                echo $server->getDpetNameByID($deptid)
                                                ?></option>
                                        <?php } ?>
                                    </datalist>
                                </table>
                            </form>
                        </div>
                        <div class="col-sm-8 col-9 text-right m-b-20">
                            <a href="add-dept.php" class="btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add New</a>
                        </div>
                    </div>
                    <div class="row doctor-grid">
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <div class="col-md-4 col-sm-4  col-lg-3">
                                    <div class="profile-widget">
                                        <div class="doctor-img">
                                            <a class="avatar" href="#">
                                                <img alt="" src="<?php echo $row['picture'] ?>" onerror="this.onerror=null; this.src='assets/img/medical.jpg'" alt="">
                                            </a>
                                        </div>
                                        <div class="dropdown profile-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                
                                                <a class="dropdown-item" href="department-details.php?dept_id=<?php echo $row['dept_id'] ?>" />
                                                <i class="fa fa-book m-r-5"></i> Details
                                                </a>

                                                <a class="dropdown-item" href="update-department.php?dept_id=<?php echo $row['dept_id'] ?>" />
                                                <i class="fa fa-pencil m-r-5"></i> Edit
                                                </a>


                                                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
                                                    <input type="hidden" value="<?php echo $row['dept_id'] ?>" name="dept_id"/>
                                                    <?php if ($row['status'] == 1) { ?>
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
                                        <h4 class="doctor-name text-ellipsis"><a href="profile.html"><?php echo $row['dept_name']; ?></a></h4>
                                        <div class="doc-prof">Department ID: &nbsp;<?php echo $row['dept_id'] ?></div>
                                        <?php if ($row['status'] == 1) { ?>
                                            Status: <span style="color:green">ACTIVE</span>
                                        <?php } else {
                                            ?>
                                            Status: <span style="color:red">INACTIVE</span>
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

        <!--scripts-->
        <?php include './parts/js-links.php'; ?>

    </body>


</html>