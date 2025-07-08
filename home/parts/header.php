<?php $url = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']); ?>

<div class="container">
    <div class="row">
        <div class="col-md-4">

            <!-- MENU -->
            <nav>

                <a class="mobile-menu-button" href="#"><i class="fa fa-bars"></i></a>

                <ul class="menu clearfix" id="menu-left">
                    <li class="<?php if($url =='index.php'){echo 'active';}?>">
                        <a href="index.php" >Home</a>
                    </li>
                    <li class="<?php if($url =='about.php'){echo 'active';}?>">
                        <a href="about.php" >About</a>
                    </li>
                    <li class="<?php if($url =='services.php'){echo 'active';}?>">
                        <a href="services.php" >Services</a>
                    </li>
                    <li class="<?php if($url =='events.php'){echo 'active';}?>">
                        <a href="events.php" >Events</a>
                    </li>
                </ul>

            </nav>

        </div><!-- col -->
        <div class="col-md-4">

            <!-- LOGO -->
            <center>
                <a href="index.php">
                   <h2>
                       <b style="color: white;">Project CMS</b>
                    </h2>
                </a>
            </center><!-- LOGO -->

        </div><!-- col -->
        <div class="col-md-4">

            <!-- MENU -->
            <nav>

                <ul class="menu clearfix" id="menu-right">
                    <li >
                        <a href="#">News</a>
                    </li>
                    <li class="<?php if($url =='contact.php'){echo 'active';}?>">
                        <a href="contact.php">Contact</a>
                    </li>
                    <li>
                        <a href="../registration/client/">Sign up</a>
                    </li>
                    <li>
                        <a href="../login/client/">Sign in</a>
                    </li>
                </ul>

            </nav>

        </div><!-- col -->
    </div><!-- row -->
</div><!-- container -->