<?php

session_start();
$adminid = $_SESSION['admin_id'];

if (!isset($_SESSION["admin_id"])) {
    header("location:logout.php");
}

require_once './classes/Server.php';
$result = "";
$message = "";
$delete ="";
$data = "";
$data2 = "";

$server = new Server();
$result = $server->adminData();
$data = $server->eventData();
$data2 = $server->eventData();


if (isset($_POST['create'])) {
    $message = $server->addEvent($_POST);
}
if (isset($_POST['delete'])) {
    $message = $server->deleteEvent($_POST);
}
if (isset($_POST['change'])) {
    $message = $server->ChangeEventStatus($_POST);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>CMS</title>
        <link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">
        <?php
        include './parts/css-links.php';
        ?>
        <style>
            form,h4{
                font-family: 'Ubuntu', sans-serif;
                font-size: 15px;
            }

        </style>
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
            <div class="page-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-sm-4 col-3">
                            <form method="POST" action="doctor-info.php">
                                <table>
                                    <td><input type="" placeholder="Event ID..." name="event_id" list="ID" class="form-control" style="min-width: 200px" autocomplete="off" required></td>
                                    <td><input type="submit" value="Search" class="btn btn-primary" style="height: 40px"></td>
                                    <td><?php echo $delete ?></td>
                                    <datalist id="ID">
                                        <?php while ($row = $data2->fetch_assoc()) { ?>
                                        <option value="<?php echo $row['event_id'] ?>">Title: <?php echo $row['event_title'] ?></option>
                                        <?php } ?>
                                    </datalist>
                                </table>
                            </form>
                        </div>
                        <div class="col-sm-8 col-9 text-right m-b-20">
                            <a href="add-event.php" class="btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Create Event</a>
                        </div>
                    </div>
                    <div class="row doctor-grid">
                        <?php
                        if ($data->num_rows > 0) {
                            while ($row = $data->fetch_assoc()) {
                                ?>
                                <div class="col-md-4 col-sm-4  col-lg-3">
                                    <div class="profile-widget"><br>
                                        <div>
                                            <a href="#">
                                                <img alt="" style="height: 100px;width: 100%" src="<?php echo $row['event_banner'] ?>" onerror="this.onerror=null; this.src='../gallery/propic/doctors/default.jpg'" alt="">
                                            </a>
                                        </div>
                                        <div class="dropdown profile-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <form method="POST" action="update-event.php" >
                                                    <input type="hidden" value="<?php echo $row['event_id'] ?>" name="event_id"/>
                                                    <button type="submit" class="dropdown-item" name="show" style="border: none;background: none;outline: none;width:100%;cursor: pointer" />
                                                    <i class="fa fa-user m-r-5"></i> Details
                                                    </button>
                                                </form>
                                                <form method="POST" action="update-event.php">
                                                    <input type="hidden" value="<?php echo $row['event_id'] ?>" name="event_id"/>
                                                    <button type="submit" class="dropdown-item" name="show" style="border: none;background: none;outline: none;width:100%;cursor: pointer" />
                                                    <i class="fa fa-pencil m-r-5"></i> Edit
                                                    </button>
                                                </form>
                                                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
                                                    <input type="hidden" value="<?php echo $row['event_id'] ?>" name="event_id"/>
                                                    <?php if ($row['status'] == 1) { ?>
                                                        <input type="hidden" value="0" name="status"/>
                                                        <button type="submit" class="dropdown-item" name="change" style="border: none;background: none;outline: none;width:100%;cursor: pointer" />
                                                        <i class="fa fa-lock m-r-5"></i> Unpublished
                                                        </button>
                                                    <?php } else {
                                                        ?>
                                                        <input type="hidden" value="1" name="status"/>
                                                        <button type="submit" class="dropdown-item" name="change"  style="border: none;background: none;outline: none;width:100%;cursor: pointer" />
                                                        <i class="fa fa-unlock m-r-5"></i> Publish
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
                                        <h4 class="doctor-name text-ellipsis"><a href=""><?php echo $row['event_title'] ?></a></h4>
                                        <div class="doc-prof"><?php echo $row['date'] ?> &nbsp;<?php echo $row['month'] ?>,<?php echo $row['year'] ?></div>
                                        <?php if ($row['status'] == 1) { ?>
                                            Status: <span style="color:green">PUBLISHED</span>
                                        <?php } else {
                                            ?>
                                            Status: <span style="color:red">UNPUBLISHED</span>
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