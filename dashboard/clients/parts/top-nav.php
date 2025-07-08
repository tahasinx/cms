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
                    $notifications = $server->get_notifications();

                    while ($row2 = $notifications->fetch_assoc()) {
                        $client_id = $row2['notification_from'];
                        ?>
                        <li class="notification-message">
                            <a 
                            <?php if ($row2['notification_type'] === 'appointment') { ?>
                                    href="appointment-history.php"
                                <?php } ?>
                                >
                                <div class="media">
                                    <span class="avatar">
                                        <img alt="Admin" src="assets/img/user.jpg" class="img-fluid">
                                    </span>
                                    <div class="media-body">
                                        <p class="noti-details"><span class="noti-title"><?php echo $row2['notification_from'] ?></span>&nbsp;<span class="noti-title"><?php echo $row2['notification_about'] ?></span></p>
                                        <p class="noti-time"><span class="notification-time"><?php echo $row2['notification_time'] ?></span></p>
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
        <a href="javascript:void(0);" id="open_msg_box" class="hasnotifications nav-link"><i class="fa fa-comment-o"></i> <span class="badge badge-pill bg-danger float-right"><div id="message_count"><?php echo $server->total_message(); ?></div></span></a>
    </li>
    <li class="nav-item dropdown has-arrow">
        <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
            <span class="user-img">
                <img class="rounded-circle" style="height: 40px;width: 40px" src="<?php echo $row['propic']; ?>" width="24" onerror="this.onerror=null; this.src='assets/img/user.jpg'" alt="">
                <span class="status online"></span>
            </span>
            <span><?php echo $row['first_name']; ?></span>
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