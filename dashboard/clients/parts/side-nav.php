<?php $url = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']); ?>

<div class="sidebar-inner slimscroll">
    <div id="sidebar-menu" class="sidebar-menu">
        <ul>
            <li class="<?php if ($url == 'index.php') {
                echo 'active';
            } ?>">
                <a href="index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
            </li>
            <li class="submenu">
                <a href="#"><i class="fa fa-user"></i> <span> Profile </span> <span class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a href="profile.php" class="<?php if ($url == 'profile.php') {
                            echo 'active';
                        } ?>">My Profile</a></li>
                    <li><a href="update-profile.php" class="<?php if ($url == 'update-profile.php') {
                            echo 'active';
                        } ?>">Edit Profile</a></li>
                </ul>
            </li>
            <li class="<?php if ($url == 'doctors.php' || $url == 'doctor-profile.php') {
                echo 'active';
            } ?>">
                <a href="doctors.php"><i class="fa fa-user-md"></i> <span>Doctors</span></a>
            </li>
            <li class="<?php if ($url == 'departments.php' || $url == 'department-details.php') {
                echo 'active';
            } ?>">
                <a href="departments.php"><i class="fa fa-home"></i> <span>Departments</span></a>
            </li>
            <li class="submenu">
                <a href="#"><i class="fa fa-book"></i><span>Appointments</span><span class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a href="appointment-step1.php"
                           class="<?php if ($url == 'appointment-step1.php' || $url == 'appointment-step2.php' || $url == 'appointment-step3.php' || $url == 'appointment-finalstep.php' || $url == 'pay-online.php') {
                               echo 'active';
                           } ?>">Create</a></li>
                    <li><a href="appointment-history.php" class="<?php if ($url == 'appointment-history.php') {
                            echo 'active';
                        } ?>">History</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="fa fa-medkit"></i> <span>Pharmacy & Lab</span> <span
                            class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a href="request-drugs.php" class="<?php if ($url == 'request-drugs.php') {
                            echo 'active';
                        } ?>">Request Drugs </a></li>
                    <li><a href="request-tests.php" class="<?php if ($url == 'request-tests.php') {
                            echo 'active';
                        } ?>">Request Tests</a></li>
                    <li><a href="" class="<?php if ($url == '') {
                            echo 'active';
                        } ?>">Feedback</a></li>
                </ul>
            </li>
            <li>
                <a href="chat.php"><i class="fa fa-comments"></i> <span>Chat</span>
                    <span class="menu-arrow"></span>
                </a>
            </li>

        </ul>
    </div>
</div>