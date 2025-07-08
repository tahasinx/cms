<?php $url = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']); ?>

<div class="sidebar-inner slimscroll">
    <div id="sidebar-menu" class="sidebar-menu">
        <ul>
            <li class="<?php if($url =='index.php'){echo 'active';}?>" >
                <a href="index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
            </li>
            <li class="submenu">
                <a href="#"><i class="fa fa-user"></i> <span> Profile </span> <span class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a href="profile.php" class="<?php if($url =='profile.php'){echo 'active';}?>">My Profile</a></li>
                    <li><a href="update-profile.php" class="<?php if($url =='update-profile.php'){echo 'active';}?>">Edit Profile</a></li>
                </ul>
            </li>
            <li class="<?php if($url =='doctors.php' || $url =='doctor-profile.php'){echo 'active';}?>">
                <a href="doctors.php"><i class="fa fa-user-md"></i> <span>Doctors</span></a>
            </li>
            <li class="<?php if($url =='departments.php' || $url =='department-details.php'){echo 'active';}?>">
                <a href="departments.php"><i class="fa fa-home"></i> <span>Departments</span></a>
            </li>
            <li class="submenu">
                <a href="#"><i class="fa fa-users"></i> <span> Appointments </span> <span class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a href="appointments.php" class="<?php if($url =='appointments.php'){echo 'active';}?>">Upcoming</a></li>
                    <li><a href="appoinment-history.php" class="<?php if($url =='appoinment-history.php'){echo 'active';}?>">History</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="fa fa-users"></i> <span> Schedule </span> <span class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a href="add-schedule.php" class="<?php if($url =='add-schedule.php'){echo 'active';}?>">My schedule</a></li>
                    <li><a href="update-schedule.php" class="<?php if($url =='update-schedule.php'){echo 'active';}?>">Update Schedule</a></li>
                </ul>
            </li>
            <li>
                <a href="chat.php"><i class="fa fa-comments"></i> <span>Chat</span> <span class="menu-arrow"></span></a>
            </li>
         </ul>
    </div>
</div>