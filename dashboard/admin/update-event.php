<?php

session_start();
$adminid = $_SESSION['admin_id'];

if (!isset($_SESSION["admin_id"])) {
    header("location:logout.php");
}

require_once './classes/Server.php';
$result = "";
$message = "";
$data = "";

$server = new Server();
$result = $server->adminData();
if (isset($_POST['update'])) {
    $message = $server->updateEvent($_POST);
}
if (isset($_POST['show'])) {
    $data = $server->eventDataByID($_POST);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>CMS</title>
        <link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">
        <script src="../ckeditor/ckeditor.js"></script>
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
                        <div class="col-sm-2"><?php echo $message; ?></div>
                        <div class="col-sm-8">
                            <form method="post" action="" enctype="multipart/form-data" autocomplete="nope">

                                <?php while ($row = $data->fetch_assoc()) { ?>
                                    <input type="hidden" name="event_id" value="<?php echo $row['event_id'] ?>" />
                                    <div class="form-group">
                                        <label>Event Title<span style="color:red">*</span></label>
                                        <input type="text" class="form-control" name="event_title" value="<?php echo $row['event_title'] ?>" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Event Description<span style="color:red">*</span></label>
                                        <textarea name="event_description" id="editor1"><?php echo $row['event_description'] ?></textarea>
                                        <script>
                                            CKEDITOR.replace('editor1');
                                        </script>
                                    </div>
                                    <div>
                                        Banner:<br>
                                        <img src="<?php echo $row['event_banner'] ?>" style="height: 200px;width: 350px" id="output"/>
                                    </div>
                                    <script>
                                        var loadFile = function (event) {
                                            var output = document.getElementById('output');
                                            output.src = URL.createObjectURL(event.target.files[0]);
                                        };
                                    </script>
                                    <div class="form-group">
                                        <label>Event Banner<span style="color:red">*</span></label>
                                        <input type="file" onchange="loadFile(event)" class="form-control" name="event_banner" autocomplete="off" accept="image/*" >
                                    </div>
                                    <?php
                                    $oldpic = $row['event_banner'];
                                    $_SESSION['oldpic'] = $oldpic;
                                    ?>
                                    <div class="form-group">
                                        <label>Related File[Previous:<a href="<?php echo $row['event_file']; ?>" target="_blank">&nbsp; click</a>]</label>
                                        <input type="file" class="form-control" name="event_file" autocomplete="off">
                                    </div>
                                    <?php
                                    $oldfile = $row['event_file'];
                                    $_SESSION['oldfile'] = $oldfile;
                                    ?>
                                    <div class="form-group">
                                        <label>Related Link</label>
                                        <input type="text" class="form-control" value="<?php echo $row['event_link']; ?>" name="event_link"  placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <table>
                                            <tr>
                                                <td style="width: 230px">
                                                    <label>Event Month</label>
                                                    <select class="form-control" name="month" required>Month
                                                        <option><?php echo $row['month'] ?></option>
                                                        <option disabled>Select</option>
                                                        <option>January</option>
                                                        <option>February</option>
                                                        <option>March</option>
                                                        <option>April</option>
                                                        <option>May</option>
                                                        <option>June</option>
                                                        <option>July</option>
                                                        <option>August</option>
                                                        <option>September</option>
                                                        <option>October</option>
                                                        <option>November</option>
                                                        <option>December</option>
                                                    </select>
                                                </td>
                                                <td style="width: 220px">
                                                    <label>Event Date</label>
                                                    <select class="form-control" name="date" required>Day
                                                        <option><?php echo $row['date'] ?></option>
                                                        <option disabled>Select</option>
                                                        <?php for ($i = 1; $i <= 31; $i++) { ?>
                                                            <option><?php echo $i; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td style="width: 230px">
                                                    <label>Event Year</label>
                                                    <select class="form-control" name="year" required>Year
                                                        <option><?php echo $row['year'] ?></option>
                                                        <option disabled>Select</option>
                                                        <?php
                                                        for ($i = 2019; $i <= 3000; $i++) {
                                                            ?>
                                                            <option><?php echo $i; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="form-group">
                                        <label>Publication Status<span style="color:red">*</span></label>
                                        <select type="text" class="form-control" name="status" >
                                            <?php if ($row['status'] == 1) { ?>
                                                <option value="1" selected="">Published</option>
                                                <option value="0">Unpublished</option>
                                            <?php } else {
                                                ?>
                                                <option value="1">Published</option>
                                                <option value="0" selected="">Unpublished</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div>
                                        <input type="submit" value="Update" name="update" class="btn btn-lg btn-dark" style="height: 50px;width: 100%">
                                    </div>

                                <?php } ?>
                            </form>
                        </div>
                        <div class="col-sm-2"></div>
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