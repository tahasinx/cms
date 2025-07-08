<?php

session_start();
$adminid = $_SESSION['admin_id'];

if (!isset($_SESSION["admin_id"])) {
    header("location:logout.php");
}

require_once './classes/Server.php';
$result = "";
$message = "";

$server = new Server();
$result = $server->adminData();


if (isset($_POST['create'])) {
    $message = $server->addEvent($_POST);
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
                        <div class="col-sm-2"></div>
                        <div class="col-sm-8">
                            <form method="post" enctype="multipart/form-data" autocomplete="nope">
                                <div class="form-group">
                                    <label>Event Title<span style="color:red">*</span><?php echo $message; ?></label>
                                    <input type="text" class="form-control" name="event_title" placeholder="" required="">
                                </div>
                                <div class="form-group">
                                    <label>Event Description<span style="color:red">*</span></label>
                                    <textarea name="event_description" id="editor1"></textarea>
                                    <script>
                                        CKEDITOR.replace('editor1');
                                    </script>
                                </div>
                                <div class="form-group">
                                    <label>Event Banner<span style="color:red">*</span></label>
                                    <input type="file" class="form-control" name="event_banner" autocomplete="off" accept="image/*" required>
                                </div>
                                <div class="form-group">
                                    <label>Related File</label>
                                    <input type="file" class="form-control" name="event_file" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label>Related Link</label>
                                    <input type="text" class="form-control" name="event_link"  placeholder="">
                                </div>
                                <div class="form-group">
                                    <table>
                                        <tr>
                                            <td style="width: 230px">
                                                <label>Event Month</label>
                                                <select class="form-control" name="month" required>Month
                                                    <option value=""></option>
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
                                                    <option value=""></option>
                                                    <?php for ($i = 1; $i <= 31; $i++) { ?>
                                                        <option><?php echo $i; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                            <td style="width: 230px">
                                                <label>Event Year</label>
                                                <select class="form-control" name="year" required>Year
                                                    <option value=""></option>
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
                                    <input type="text" class="form-control" name="status" list="status">
                                    <datalist id="status">
                                        <option value="1">Published</option>
                                        <option value="0">Unpublished</option>
                                    </datalist>
                                </div>
                                <div>
                                    <input type="submit" value="CREATE" name="create" class="btn btn-lg btn-dark" style="height: 50px;width: 100%">
                                </div>
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