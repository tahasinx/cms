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
            <li class="submenu">
                <a href="#"><i class="fa fa-user-md"></i> <span> Doctors </span> <span class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a href="doctors.php" class="<?php if($url =='doctors.php' || $url =='doctor-profile.php'){echo 'active';}?>">All Doctors</a></li>
                    <li><a href="add-doctor.php" class="<?php if($url =='add-doctor.php'){echo 'active';}?>">New Doctor</a></li>
                    <li><a href="doctor-price.php" class="<?php if($url =='doctor-price.php'){echo 'active';}?>">Visiting Price</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="fa fa-users"></i> <span> Clients </span> <span class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a href="clients.php" class="<?php if($url =='clients.php'){echo 'active';}?>">All Clients</a></li>
                    <?php if($url =='client-profile.php'){?>
                    <li><a href="" class="<?php if($url =='client-profile.php'){echo 'active';}?>">Client Profile</a></li>
                    <?php } ?>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="fa fa-hospital-o"></i><span> Departments </span> <span class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a href="departments.php" class="<?php if($url =='departments.php'){echo 'active';}?>">All Departments</a></li>
                    <li><a href="add-dept.php" class="<?php if($url =='add-dept.php'){echo 'active';}?>">New Department</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="fa fa-book"></i> <span> Appointments </span> <span class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a href="approved-appoinments.php" class="<?php if($url =='approved-appoinments.php'){echo 'active';}?>">Approved</a></li>
                    <li><a href="appointment-requests.php" class="<?php if($url =='appointment-requests.php'){echo 'active';}?>">Requests[<span id="request" style="color:red"><?php echo $requests; ?></span> ]</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="fa fa-clock-o"></i> <span> Doctor Schedule </span> <span class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a href="add-schedule.php" class="<?php if($url =='add-schedule.php'){echo 'active';}?>">Create Schedule</a></li>
                    <li><a href="update-schedule.php" class="<?php if($url =='update-schedule.php'){echo 'active';}?>">Manage Schedule</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="fa fa-flask"></i> <span> Lab Requests </span> <span class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a href="requested-drugs.php" class="<?php if($url =='requested-drugs.php'){echo 'active';}?>">Drug Requests [ <span class="text-danger"><?= $server->new_drug_requestS() ?></span> ]</a></li>
                    <li><a href="requested-tests.php" class="<?php if($url =='requested-tests.php'){echo 'active';}?>">Test Requests [ <span class="text-danger"><?= $server->new_test_requestS() ?></span> ]</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="#"><i class="fa fa-calendar"></i> <span> Events </span> <span class="menu-arrow"></span></a>
                <ul style="display: none;">
                    <li><a href="events.php" class="<?php if($url =='events.php'){echo 'active';}?>">Event List</a></li>
                    <li><a href="add-event.php" class="<?php if($url =='add-event.php'){echo 'active';}?>">New Event</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-comments"></i> <span>Chat</span> <span class="badge badge-pill bg-primary float-right">0</span></a>
            </li>

            <li>
                <a href="#"><i class="fa fa-cog"></i> <span>Settings</span></a>
            </li>
        </ul>
    </div>
</div>