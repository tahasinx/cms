<?php
session_start();

require_once './server/Home.php';

$server = new Home();

$data = $server->eventData();
?>
<!doctype html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0, shrink-to-fit=no">
        <meta name="keywords" content="">
        <meta name="description" content="">
      

        <?php include './parts/css-links.php'; ?>
    </head>

    <body class="sticky-header header-classic footer-parallax">

        <div id="main-container">

            <!-- HEADER -->
            <header id="header">
                <?php include './parts/header.php'; ?>
            </header>
            <!-- HEADER -->


            <!-- PAGE CONTENT -->
            <div id="page-content">

                <div id="page-header" class="parallax" data-stellar-background-ratio="0.3"
                     style="background-image: url(images/backgrounds/page-header-4.jpg);">

                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">

                                <h1>Events</h1>

                            </div><!-- col -->
                        </div><!-- row -->
                    </div><!-- container -->

                </div><!-- page-header -->

                <div class="container">
                    <div class="row">
                        <div class="col-md-8 ml-auto mr-auto">
                            <?php
                            if ($data->num_rows > 0) {
                                while ($row = $data->fetch_assoc()) {
                                    ?>
                                    <div class="blog-article">

                                        <div class="blog-article-thumbnail">

                                            <a class="date" href="#">
                                                <small><?php echo $row['month'] ?></small>
                                                <span><?php echo $row['date'] ?></span>
                                                <small><?php echo $row['year'] ?></small>
                                            </a>
                                            <a href="news-single.html"><img src="../dashboard/<?php echo substr($row['event_banner'],3) ?>" alt=""></a>

                                        </div><!-- blog-article-thumbnail -->

                                        <h4 class="blog-article-title"><?php echo $row['event_title'] ?></h4>

                                        <div class="blog-article-details">
                                            By <a class="author" href="#">Admin</a>
                                            Date <a class="category" href="#"><?php echo $row['date'] ?>&nbsp;<?php echo $row['month'] ?>,<?php echo $row['year'] ?></a>
                                        </div><!-- blog-article-details -->

                                        <div class="blog-article-content">

                                            <p><?php echo $row['event_description'] ?></p>

                                        </div><!-- blog-article-content -->

                                    </div><!-- blog-article -->

                                <?php }
                                
                            } else {
                                
                            }?>
                                </div><!-- col -->
                            </div><!-- row -->
                        </div><!-- container -->

                    </div><!-- PAGE CONTENT -->


                    <!-- FOOTER -->
                    <footer id="footer-container">

                        <div id="footer">

                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="widget widget-text">

                                            <div class="text-center">

                                                <p><img src="assets/images/logo-white.png" alt=""></p>
                                                <p class="text-uppercase">Best medical solutions</p>

                                            </div>

                                        </div><!-- widget-text -->

                                        <div class="widget widget-contact">

                                            <ul class="inline">
                                                <li>
                                                    <i class="fa fa-map-marker"></i>
                                                    4453 Meadow Lane, San Jose, CA 95134
                                                </li>
                                                <li>
                                                    <i class="fa fa-phone"></i>
                                                    315-411-8716
                                                </li>
                                                <li>
                                                    <i class="fa fa-envelope-o"></i>
                                                    <a href="mailto:info@smart-pixel.xyz">info@smart-pixel.xyz</a>
                                                </li>
                                            </ul>

                                        </div><!-- widget-contact -->

                                        

                                        

                                    </div><!-- col -->
                                </div><!-- row -->
                            </div><!-- container -->

                        </div><!-- footer -->

                    </footer><!-- FOOTER -->

                </div><!-- MAIN CONTAINER -->


                <!-- SCROLL UP -->
                <a id="scroll-up" class="waves"><i class="fa fa-angle-up"></i></a>


                <!-- THEME OPTIONS -->
                <div id="theme-options"></div>


                <?php include './parts/scripts.php'; ?>

    </body>

</html>