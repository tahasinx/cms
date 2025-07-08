<div class="header-left">
    <a href="index.html" class="logo">
        <img src="assets/img/logo.png" width="35" height="35" alt=""> <span>CMS</span>
    </a>
</div>
<a id="toggle_btn" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
<a id="mobile_btn" class="mobile_btn float-left" href="#sidebar"><i class="fa fa-bars"></i></a>
<ul class="nav user-menu float-right">
    <li class="nav-item dropdown d-none d-sm-block">
        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"><i class="fa fa-bell-o"></i> <span class="badge badge-pill bg-danger float-right"><div id="notification_count"><?php echo $server->total_notification(); ?></div></span></a>
        <div class="dropdown-menu notifications">
            <div class="topnav-dropdown-header">
                <span>Notifications</span>
            </div>
            <div class="drop-scroll" id="notifications">
                <ul class="notification-list">
                    <?php
                    $server = new Server();
                    $notifications = $server->get_notifications();

                    while ($row = $notifications->fetch_assoc()) {
                        $client_id = $row['notification_from'];
                        ?>
                        <li class="notification-message">
                            <a 
                            <?php if ($row['notification_type'] === 'appointment') { ?>
                                    href="appointment-requests.php"
                                    <?php } ?>
                                    >
                                    <div class="media" style="background-color:<?php if($row['is_seen'] == 0){echo 'yellow';} ?> " >
                                        <span class="avatar">
                                            <img alt="John Doe" src="<?php echo $server->getClient_ImageByID($client_id) ?>" class="img-fluid">
                                        </span>
                                        <div class="media-body">
                                            <p class="noti-details"><span class="noti-title"><?php echo $server->getClient_NameByID($client_id) ?></span>&nbsp;<span class="noti-title"><?php echo $row['notification_about'] ?></span></p>
                                            <p class="noti-time"><span class="notification-time"><?php echo $row['notification_time'] ?></span></p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="topnav-dropdown-footer">
                    
                </div>
            </div>
        </li>
        <li class="nav-item dropdown d-none d-sm-block">
            <a href="javascript:void(0);" id="open_msg_box" class="hasnotifications nav-link"><i class="fa fa-comment-o"></i> <span class="badge badge-pill bg-danger float-right">0</span></a>
        </li>
        <li class="nav-item dropdown has-arrow">
            <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                <span class="user-img">
                    <img class="rounded-circle" style="height: 40px;width: 40px" src="<?php echo $row['propic'] ?>" onerror="this.onerror=null; this.src='assets/img/user.jpg'" width="24" alt="">
                <span class="status online"></span>
            </span>
            <span>Admin</span>
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="profile.php">My Profile</a>
            <a class="dropdown-item" href="update-profile.php">Edit Profile</a>
            <a class="dropdown-item" href="settings.html">Settings</a>
            <a class="dropdown-item" href="logout.php">Logout</a>
        </div>
    </li>
</ul>
<div class="dropdown mobile-user-menu float-right">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
    <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="profile.php">My Profile</a>
        <a class="dropdown-item" href="update-profile.php">Edit Profile</a>
        <a class="dropdown-item" href="settings.html">Settings</a>
        <a class="dropdown-item" href="logout.php">Logout</a>
    </div>
</div>