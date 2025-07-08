<?php

session_start();

if (!isset($_SESSION["client_id"])) {
    header("location:logout.php");
}

$client_id = $_SESSION['client_id'];

require_once './classes/Server.php';
$result = "";

$server = new Server();
$result = $server->viewData();
$output = $server->appointment_with();
$output2 = $server->appointed_with();
$message_to = "";

if (!isset($_GET['message_to'])) {

} else {
    $_SESSION["message_to"] = $_GET["message_to"];
    $message_to = $_SESSION["message_to"];
    $seen = $server->message_seen($_GET['message_to']);
}

if (isset($_POST['upload'])) {

    $server->upload_file();
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

        .blink_me {
            animation: blinker 2s linear infinite;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
    </style>
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
    <?php } ?>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div class="sidebar-menu">
                <ul>
                    <li>
                        <a href="index.php"><i class="fa fa-home back-icon"></i> <span>Back to Home</span></a>
                    </li>
                    <li class="menu-title">Appointment With<a href="appointment-step1.php" class="add-user-icon"><i
                                    class="fa fa-plus"></i></a></li>
                    <?php
                    if ($output->num_rows > 0) {
                        while ($row = $output->fetch_assoc()) {
                            ?>
                            <li>
                                <a href="chat.php?message_to=<?php echo $row['doctor_id'] ?>&status=1"><span
                                            class="chat-avatar-sm user-img"><img
                                                src="<?php echo $server->doctorImage_byID($row['doctor_id']); ?>" alt=""
                                                class="rounded-circle" style="height:25px;width:25px"><span
                                                class="status online"></span></span> <?php echo $server->doctorName_byID($row['doctor_id']); ?>
                                    <span class="badge badge-pill bg-danger float-right">1</span></a>
                            </li>
                            <?php
                        }
                    } else {
                        ?>
                        <center>
                            <tt style="color:red;text-transform: uppercase">No appointments</tt>
                        </center>
                    <?php } ?>
                    <li class="menu-title">Appointed Doctors</li>
                    <?php
                    if ($output2->num_rows > 0) {
                        while ($row = $output2->fetch_assoc()) {
                            ?>
                            <li>
                                <a href="chat.php?message_to=<?php echo $row['doctor_id'] ?>"><span
                                            class="chat-avatar-sm user-img"><img
                                                src="<?php echo $server->doctorImage_byID($row['doctor_id']); ?>"
                                                style="height:25px;width:25px" alt="" class="rounded-circle"><span
                                                class="status online"></span></span> <?php echo $server->doctorName_byID($row['doctor_id']); ?>
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
                                            <a href="doctor-profile.php?doctor_id=<?php echo $message_to ?>"
                                               title="<?php echo $server->doctorName_byID($message_to); ?> "><img
                                                        src="<?php echo $server->doctorImage_byID($message_to); ?>"
                                                        alt="" class="w-40 rounded-circle"
                                                        style="height:40px;width:40px"><span
                                                        class="status online"></span></a>
                                        </div>
                                        <div class="user-info float-left">
                                            <a href="profile.html"><span
                                                        class="font-bold"><?php echo $server->doctorName_byID($message_to); ?></span></a>
                                            <span class="last-seen">
                                                        <?php
                                                        $department = $server->doctorDept_byID($message_to);
                                                        echo $server->doctorPosition_byID($message_to) . ',&nbsp;' . $server->getDeptNameByID($department);
                                                        ?>
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

                                                        if ($row['message_from'] === $client_id && $row['message_to'] === $message_to) {
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
                                                        <?php } else if ($row['message_from'] === $message_to && $row['message_to'] === $client_id) {
                                                            ?>
                                                            <div class="chat chat-left">
                                                                <div class="chat-avatar">
                                                                    <a href="profile.html" class="avatar">
                                                                        <img alt=""
                                                                             src="<?php echo $server->doctorImage_byID($message_to); ?>"
                                                                             style="width:40px;height: 40px;">
                                                                    </a>
                                                                </div>
                                                                <div class="chat-body">
                                                                    <div class="chat-bubble">
                                                                        <div class="chat-content">
                                                                            <p><?= $row['message_body'] ?></p>
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
                                                                            <span class="chat-time"><?= $row['message_time'] ?></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                } else {
echo '';
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
                                                            <img src="<?= $server->doctorImage_byID($message_to) ?>"
                                                                 style="height: 130px;width: 130px" alt="">
                                                        </div>
                                                        <h3 class="user-name m-t-10 mb-0"><?= $server->doctorName_byID($message_to) ?></h3>
                                                        <?php
                                                        $department = $server->doctorDept_byID($message_to);
                                                        echo $server->doctorPosition_byID($message_to) . ',&nbsp;' . $server->getDeptNameByID($department);
                                                        ?>
                                                    </div>
                                                    <div style="padding: 5%;margin-top: 50%" id="room">
                                                        <center>
                                                            <?php if (isset($_GET['status'])) {
                                                                if ($server->check_chat_room() == "") { ?>
                                                                    <span class="text-danger">No chat room for video chatting is not available. Please wait for doctor's response.</span>
                                                                <?php } else {
                                                                    ?>

                                                                    <span class="text-danger blink_me">Doctor is waiting for you.</span>
                                                                    <a href="waiting-room.php?url=<?= $server->check_chat_room() ?>"
                                                                       class="btn btn-outline-primary " target="_blank">
                                                                        CLICK TO JOIN.
                                                                    </a>
                                                                <?php }
                                                            } ?>
                                                        </center>
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
            </div>
        </div>
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
                            <input type="file" class="form-control" name="file_name" accept="image/x-png,image/jpeg"/>
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
        room();
    });


    function load() {
        setTimeout(function () {
            messages();
            load();
        }, 200);
    }

    function room() {
        setTimeout(function () {
            chat_room();
            room();
        }, 3000);
    }


    function messages() {
        $('#data').load(window.location.href + " #data");

    }

    function chat_room() {
        $('#room').load(window.location.href + " #room");
    }
</script>
</body>
</html>