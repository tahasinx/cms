<?php
session_start();
$userid = $_SESSION['user_id'];
require_once './classes/Server.php';

if (!isset($_SESSION["user_id"])) {
    header("location:logout.php");
}

require_once './classes/Server.php';
$result = "";
$link = "";
$server = new Server();
$result = $server->viewData();
$output = $server->appointment_with();
$output2 = $server->appointed_with();


if (!isset($_GET['message_to'])) {

} else {
    $_SESSION["message_to"] = $_GET["message_to"];
    $message_to = $_SESSION["message_to"];
    $seen = $server->message_seen($_GET['message_to']);
}


if (isset($_POST['upload'])) {
    $server->upload_file();
}

if (isset($_POST['done'])) {
    $server->is_done();
}

if (isset($_POST['send_link'])) {
    $link = $server->send_room_link($_POST);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <title>CMS</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <style>
        .cont {
            overflow-x: hidden;
            overflow-y: auto;
            transform: rotate(180deg);
            text-align: left;
        }

        .ul {
            overflow: hidden;
            transform: rotate(180deg);
        }

        .fieldset {
            border: 2px groove threedface;
            border-top: none;
            padding: 0.5em;
            margin: 1em 2px;
        }

        .fieldset > h1 {
            font: 1em normal;
            margin: -1em -0.5em 0;
        }

        .fieldset > h1 > span {
            float: left;
        }

        .fieldset > h1:before {
            border-top: 2px groove threedface;
            content: ' ';
            float: left;
            margin: 0.5em 2px 0 -1px;
            width: 0.75em;
        }

        .fieldset > h1:after {
            border-top: 2px groove threedface;
            content: ' ';
            display: block;
            height: 1.5em;
            left: 2px;
            margin: 0 1px 0 0;
            overflow: hidden;
            position: relative;
            top: 0.5em;
        }
    </style>
</head>

<body>
<div class="main-wrapper">
    <?php while ($row = $result->fetch_assoc()) { ?>
        <?php
        if ($row['doctor_status'] == 0) {
            echo "<script type='text/javascript'>alert('SORRY! YOU ARE BLOCKED!');document.location='logout.php';</script>";
        }
        ?>
        <div class="header">
            <?php include './parts/top-nav.php'; ?>
        </div>
    <?php } ?>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div class="sidebar-menu">
                <ul>
                    <li>
                        <a href="index.php"><i class="fa fa-home back-icon"></i> <span>Back to Home</span></a>
                    </li>
                    <li class="menu-title">Appointment With</li>
                    <?php
                    if ($output->num_rows > 0) {
                        while ($rows = $output->fetch_assoc()) {
                            ?>
                            <li>
                                <a href="chat.php?message_to=<?php echo $rows['client_id'] ?>&appointment_id=<?php echo $rows['appointment_id'] ?>&status=1"><span
                                            class="chat-avatar-sm user-img"><img
                                                src="<?php echo $server->getClient_ImageByID($rows['client_id']); ?>"
                                                alt="" class="rounded-circle" style="height:25px;width:25px"><span
                                                class="status online"></span></span> <?php echo $server->getClient_NameByID($rows['client_id']); ?>
                                </a>
                            </li>
                            <?php
                        }
                    } else {
                        ?>
                        <center>
                            <tt style="color:red;text-transform: uppercase">No appointments</tt>
                        </center>
                    <?php } ?>
                    <li class="menu-title">Appointed Patients</li>
                    <?php
                    if ($output2->num_rows > 0) {
                        while ($rowx = $output2->fetch_assoc()) {
                            ?>
                            <li>
                                <a href="chat.php?message_to=<?php echo $rowx['client_id'] ?>&appointment_id=<?php echo $rowx['appointment_id'] ?>"><span
                                            class="chat-avatar-sm user-img"><img
                                                src="<?php echo $server->getClient_ImageByID($rowx['client_id']); ?>"
                                                style="height:40px;width:40px" alt="" class="rounded-circle"><span
                                                class="status online"></span></span> <?php echo $server->getClient_NameByID($rowx['client_id']); ?>
                                </a>
                            </li>
                            <?php
                        }
                    } else {
                        ?>
                        <center>
                            <tt style="color:red;text-transform: uppercase">No appointments</tt>
                        </center>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="page-wrapper">
        <div class="chat-main-row">
            <div class="chat-main-wrapper">
                <div class="col-lg-9 message-view chat-view">
                    <div class="chat-window">
                        <div class="fixed-header">
                            <?php
                            if (!isset($_GET['message_to'])) {

                            } else {
                                ?>
                                <div class="navbar">
                                    <div class="user-details mr-auto">
                                        <div class="float-left user-img m-r-10">
                                            <a href=""
                                               title="<?php echo $server->getClient_NameByID($_GET["message_to"]); ?> "><img
                                                        src="<?php echo $server->getClient_ImageByID($_GET["message_to"]); ?>"
                                                        alt="" class="w-40 rounded-circle"
                                                        style="height:40px;width:40px"><span
                                                        class="status online"></span></a>
                                        </div>
                                        <div class="user-info float-left">
                                            <a href=""><span
                                                        class="font-bold"><?php echo $server->getClient_NameByID($message_to); ?></span></a>
                                            <span class="last-seen">

                                                    </span>
                                        </div>
                                    </div>

                                    <?php if (isset($_GET['status'])) { ?>
                                        <ul class="nav custom-menu">
                                            <li class="nav-item">
                                                <a href="#chat_sidebar"
                                                   class="nav-link task-chat profile-rightbar float-right"
                                                   id="task_chat"><i class="fa fa-user"></i></a>
                                            </li>
                                            <li class="nav-item">
                                                <form method="POST">
                                                    <button class="nav-link btn btn-outline-primary" name="done"
                                                            title="Mark as done"
                                                            onclick="return confirm('Are you sure to mark as complete?')">
                                                        <i class="fa fa-thumbs-up"></i>
                                                    </button>
                                                </form>
                                            </li>
                                            <li class="nav-item">
                                                <!-- <a class="nav-link"  href="skype:akter.uzzaman75?call"><i class="fa fa-video-camera"></i></a>-->
                                                <a class="nav-link" href="https://appr.tc" target="_blank"><i
                                                            class="fa fa-video-camera"></i></a>
                                            </li>
                                            <li class="nav-item dropdown dropdown-action">
                                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"
                                                   aria-expanded="false"><i class="fa fa-paperclip"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="javascript:void(0)"
                                                       style="color:blueviolet" data-toggle="modal"
                                                       data-target="#upload_pdf"><i class="fa fa-file-pdf-o"
                                                                                    aria-hidden="true"></i>&nbsp;Upload
                                                        PDF</a>
                                                    <a class="dropdown-item" href="javascript:void(0)"
                                                       style="color:blueviolet" data-toggle="modal"
                                                       data-target="#upload_image"><i class="fa fa-picture-o"
                                                                                      aria-hidden="true"></i>&nbsp;Upload
                                                        Iamge</a>
                                                </div>
                                            </li>
                                        </ul>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="chat-contents cont">
                            <div class="chat-content-wrap">
                                <div class="chat-wrap-inner">
                                    <div class="chat-box">
                                        <div class="chats ul">
                                            <div id="data">
                                                <?php
                                                $data = $server->chat_data();
                                                if ($data->num_rows > 0) {
                                                    while ($row = $data->fetch_assoc()) {

                                                        if ($row['message_from'] === $userid && $row['message_to'] === $message_to) {
                                                            ?>
                                                            <div class="chat chat-right">
                                                                <div class="chat-body">
                                                                    <div class="chat-bubble">
                                                                        <div class="chat-content">
                                                                            <p><?php echo $row['message_body'] ?></p>
                                                                            <?php if ($row['file_type'] === 'image') { ?>
                                                                                <a href="<?php echo $row['file_path'] ?>"
                                                                                   target="_blank">
                                                                                    <img src="<?php echo $row['file_path'] ?>"
                                                                                         style="height: 200px;width: 200px;border-radius: 3%"/>
                                                                                </a>
                                                                            <?php } elseif ($row['file_type'] === 'pdf') {
                                                                                ?>
                                                                                <a href="<?php echo $row['file_path'] ?>"
                                                                                   target="_blank">DOCUMENT.PDF</a>
                                                                            <?php }
                                                                            ?>
                                                                            <span class="chat-time"><?php echo $row['message_time'] ?></span>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        <?php } else if ($row['message_from'] === $message_to && $row['message_to'] === $userid) {
                                                            ?>
                                                            <div class="chat chat-left">
                                                                <div class="chat-avatar">
                                                                    <a href="profile.html" class="avatar">
                                                                        <img alt=""
                                                                             src="<?php echo $server->getClient_ImageByID($message_to); ?>"
                                                                             style="width:40px;height: 40px;">
                                                                    </a>
                                                                </div>
                                                                <div class="chat-body">
                                                                    <div class="chat-bubble">
                                                                        <div class="chat-content">
                                                                            <p><?php echo $row['message_body'] ?></p>
                                                                            <?php if ($row['file_type'] === 'image') { ?>
                                                                                <a href="<?php echo $row['file_path'] ?>"
                                                                                   target="_blank">
                                                                                    <img src="<?php echo $row['file_path'] ?>"
                                                                                         style="height: 200px;width: 200px;border-radius: 3%"/>
                                                                                </a>
                                                                            <?php } elseif ($row['file_type'] === 'pdf') {
                                                                                ?>
                                                                                <a href="<?php echo $row['file_path'] ?>"
                                                                                   target="_blank">DOCUMENT.PDF</a>
                                                                            <?php }
                                                                            ?>
                                                                            <span class="chat-time"><?php echo $row['message_time'] ?></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                } else {

                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="chat-footer" style="">
                            <div class="message-bar">
                                <div class="message-inner">
                                    <div
                                            class="">
                                        <?php if (isset($_GET['status'])) { ?>
                                            <div class="input-group">
                                                <textarea hidden="hidden" name="message_to"
                                                          id="message_to"><?php echo $message_to ?></textarea>
                                                <textarea class="form-control" placeholder="Type message..."
                                                          name="message" id="message" required></textarea>
                                                <span class="input-group-append">
                                                            <button class="btn btn-primary" type="submit" id="button"><i
                                                                        class="fa fa-send"></i></button>
                                                        </span>
                                            </div>
                                            <?php
                                        } else {

                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="col-lg-3 message-view chat-profile-view chat-sidebar" id="chat_sidebar">
                    <?php if (!isset($_GET['message_to'])) { ?>
                    <?php } else { ?>
                        <div class="chat-window video-window">
                            <div class="tab-content chat-contents">
                                <div class="content-full tab-pane show active" id="profile_tab">
                                    <div class="display-table">
                                        <div class="table-row">
                                            <div class="table-body">
                                                <div class="table-content">
                                                    <div class="chat-profile-img">
                                                        <div class="edit-profile-img">
                                                            <img src="<?= $server->getClient_ImageByID($message_to) ?>"
                                                                 alt="">
                                                        </div>
                                                        <h3 class="user-name m-t-10 mb-0"><?= $server->getClient_NameByID($message_to) ?></h3>
                                                    </div>
                                                    <div class="chat-profile-info">
                                                        <label><u style="color:orangered">PATIENT'S ISSUE / PROBLEM</u></label>
                                                        <textarea class="form-control"
                                                                  style="height: 170px">" <?= $server->appointment_issue(); ?> "</textarea>
                                                    </div>
                                                    <?php if (isset($_GET['status'])) { ?>
                                                        <div class="transfer-files" style="margin-top: 50px">
                                                            <center><span class="text-success"><?= $link; ?></span>
                                                            </center>
                                                            <div class="fieldset">
                                                                <h1><span><i class="fa fa-video-camera text-danger"></i>&emsp;Video Calling Link</span>
                                                                </h1>
                                                                <form method="POST" style="padding: 5%">
                                                                    <input type="text" name="room_link"
                                                                           class="form-control"
                                                                           style="border: 1px solid"
                                                                           placeholder="Paste link Here" required>
                                                                    <button name="send_link" class="btn btn-dark"
                                                                            style="width: 100%">
                                                                        SEND
                                                                    </button>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    <?php } ?>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php if (isset($_GET['status'])) { ?>
            <div id="upload_image" class="modal fade " role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title"><i class="fa fa-picture-o" aria-hidden="true"></i>&nbsp;<tt>Upload
                                    Image</tt></h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                  enctype="multipart/form-data">
                                <input type="file" class="form-control" name="file_name"
                                       accept="image/x-png,image/jpeg"/>
                                <input type="hidden" name="message_to" value="<?php echo $message_to ?>"/>
                                <input type="hidden" name="file_type" value="image"/>
                                <center>
                                    <input type="submit" class="btn btn-primary" style="width:100%" name="upload"/>
                                </center>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="upload_pdf" class="modal fade " role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;<tt>Upload
                                    PDF</tt></h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                  enctype="multipart/form-data">
                                <input type="file" class="form-control" name="file_name" accept="application/pdf"/>
                                <input type="hidden" name="message_to" value="<?php echo $message_to ?>"/>
                                <input type="hidden" name="file_type" value="pdf"/>
                                <center>
                                    <input type="submit" class="btn btn-primary" style="width:100%" name="upload"/>
                                </center>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<div class="sidebar-overlay" data-reff=""></div>
<script src="assets/js/jquery-3.2.1.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.slimscroll.js"></script>
<script src="assets/js/app.js"></script>
<script src="assets/js/auto-load.js"></script>


<script>

</script>
<script>
    $(document).ready(function () {
        $("#button").click(function () {
            var message_to = $("#message_to").val();
            var message = $("#message").val();
            $.ajax({
                url: 'insert.php',
                method: 'POST',
                data: {
                    message_to: message_to,
                    message: message
                },
                success: function (data) {
                    $("#message").val('');
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function () {
        load();

    });


    function load() {
        setTimeout(function () {
            messages();
            load();
        }, 200);
    }


    function messages() {
        $('#data').load(window.location.href + " #data");
    }
</script>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
</body>
</html>