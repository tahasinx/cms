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
$result2 = $server->ViewAllClients();
$data = $server->adminData();

if (isset($_POST['view'])) {
    $result = $server->ClientDataByID($_POST);
}

if (isset($_POST['delete'])) {
    $delete = $server->deleteDoctor($_POST);
}

if (isset($_POST['change'])) {
    $change = $server->doctorChangeStatus($_POST);
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

            <?php echo $change; ?>
            <div class="page-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-sm-4 col-3">
                            <form method="POST" action="client-search-result.php">
                                <table>
                                    <td><input type="" placeholder="Client's ID..." name="client_id" list="ID" class="form-control" style="min-width: 200px" autocomplete="off" required></td>
                                    <td><input type="submit" name="view" value="Search" class="btn btn-primary" style="height: 40px"></td>
                                    <td><?php echo $delete ?></td>
                                    <datalist id="ID">
                                        <?php while ($row = $result2->fetch_assoc()) { ?>
                                            <option value="<?php echo $row['client_id'] ?>"><?php echo $row['first_name'] . " " . $row['last_name'] ?></option>
                                        <?php } ?>
                                    </datalist>
                                </table>
                            </form>
                        </div>
                        <div class="col-sm-8 col-9 text-right m-b-20">
                            <a href="" class="btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Doctor</a>
                        </div>
                    </div>
                    <h4>Search Result:</h4>
                    <div class="row doctor-grid">
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
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
                                                <a href="client-profile.php?client_id=<?php echo $row['client_id'] ?>">
                                                    <span class="dropdown-item">
                                                    <i class="fa fa-user m-r-5"></i> Profile
                                                    </span>
                                                </a>
                                                
                                                <form method="POST" action="update-doctor.php">
                                                    <input type="hidden" value="<?php echo $row['client_id'] ?>" name="doctor_id"/>
                                                    <button type="submit" class="dropdown-item" name="show" style="border: none;background: none;outline: none;width:100%;cursor: pointer" />
                                                    <i class="fa fa-pencil m-r-5"></i> Edit
                                                    </button>
                                                </form>
                                                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
                                                    <input type="hidden" value="<?php echo $row['client_id'] ?>" name="client_id"/>
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
                                                    <button type="submit" class="dropdown-item" name="delete" style="border: none;background: none;outline: none;width:100%;cursor: pointer" onclick="return confirm('Are you sure?');">
                                                        <i class="fa fa-trash-o m-r-5"></i> Delete
                                                    </button>
                                                </form>

                                            </div>
                                        </div>
                                        <h4 class="doctor-name text-ellipsis"><a href="profile.html"><?php echo $row['first_name'] . " " . $row['last_name'] ?></a></h4>
                                        <div class="doc-prof"><?php echo $row['country'] ?></div>
                                        <br/>
                                        <?php if ($row['status'] == 1) { ?>
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

        <!--scripts-->
        <?php include './parts/js-links.php'; ?>

    </body>


</html>