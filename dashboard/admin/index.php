<?php
session_start();
$adminid = $_SESSION['admin_id'];

if (!isset($_SESSION["admin_id"])) {
    header("location:logout.php");
}

require_once './classes/Server.php';
$result = "";
$totalDoc = "";
$totalDept = "";
$totalClient = "";

$server = new Server();
$result = $server->adminData();
$totalDoc = $server->TotalDoctors();
$totalDept = $server->TotalDept();
$totalClient = $server->TotalClients();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>CMS</title>

    <?php
    include './parts/css-links.php';
    ?>

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
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <a href="doctors.php">
                        <div class="dash-widget">
                            <span class="dash-widget-bg1"><i class="fa fa-stethoscope" aria-hidden="true"></i></span>
                            <div class="dash-widget-info text-right">
                                <h3><?php echo $totalDoc; ?></h3>
                                <span class="widget-title1">Doctors <i class="fa fa-check"
                                                                       aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <a href="clients.php">
                        <div class="dash-widget">
                            <span class="dash-widget-bg2"><i class="fa fa-user-o"></i></span>
                            <div class="dash-widget-info text-right">
                                <h3><?php echo $totalClient; ?></h3>
                                <span class="widget-title2">Clients <i class="fa fa-check"
                                                                       aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <a href="departments.php">
                        <div class="dash-widget">
                            <span class="dash-widget-bg3"><i class="fa fa-home" aria-hidden="true"></i></span>
                            <div class="dash-widget-info text-right">
                                <h3><?php echo $totalDept; ?></h3>
                                <span class="widget-title3">Departments <i class="fa fa-check"
                                                                           aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="dash-widget">
                        <span class="dash-widget-bg4"><i class="fa fa-heartbeat" aria-hidden="true"></i></span>
                        <div class="dash-widget-info text-right">
                            <h3>618</h3>
                            <span class="widget-title4">Pending <i class="fa fa-check" aria-hidden="true"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title d-inline-block">Total transactions in:<span
                                        style="color: orangered"><?= $year = date('Y') ?></span></h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead class="">
                                    <tr>
                                        <th></th>
                                        <th>January</th>
                                        <th>February</th>
                                        <th>March</th>
                                        <th>April</th>
                                        <th>May</th>
                                        <th>June</th>
                                        <th>July</th>
                                        <th>August</th>
                                        <th>September</th>
                                        <th>October</th>
                                        <th>November</th>
                                        <th>December</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <h2>Appointments <span>Physical</span><span style="color: orangered">BDT</span></h2>
                                        </td>
                                        <td>
                                            <p><?= $server->from_physical('January', $year); ?></p>
                                        <td>
                                            <p><?= $server->from_physical('February', $year); ?></p>
                                        </td>
                                        <td>
                                            <p><?= $server->from_physical('March', $year); ?></p>
                                        </td>
                                        <td>
                                            <p><?= $server->from_physical('April', $year); ?></p>
                                        </td>
                                        <td>
                                            <p><?= $server->from_physical('May', $year); ?></p>
                                        </td>
                                        <td>
                                            <p><?= $server->from_physical('June', $year); ?></p>
                                        </td>
                                        <td>
                                            <p><?= $server->from_physical('July', $year); ?></p>
                                        </td>
                                        <td>
                                            <p><?= $server->from_physical('August', $year); ?></p>
                                        </td>
                                        <td>
                                            <p><?= $server->from_physical('September', $year); ?></p>
                                        </td>
                                        <td>

                                            <p><?= $server->from_physical('October', $year); ?></p>
                                        </td>
                                        <td>

                                            <p><?= $server->from_physical('November', $year); ?></p>
                                        </td>
                                        <td>

                                            <p><?= $server->from_physical('December', $year); ?></p>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>
                                            <h2>Appointments <span>Online<span style="color: orangered">USD</span></span></h2>
                                        </td>
                                        <td>
                                            <p><?= $server->from_online('January', $year); ?></p>
                                        <td>
                                            <p><?= $server->from_online('February', $year); ?></p>
                                        </td>
                                        <td>
                                            <p><?= $server->from_online('March', $year); ?></p>
                                        </td>
                                        <td>
                                            <p><?= $server->from_online('April', $year); ?></p>
                                        </td>
                                        <td>
                                            <p><?= $server->from_online('May', $year); ?></p>
                                        </td>
                                        <td>
                                            <p><?= $server->from_online('June', $year); ?></p>
                                        </td>
                                        <td>
                                            <p><?= $server->from_online('July', $year); ?></p>
                                        </td>
                                        <td>
                                            <p><?= $server->from_online('August', $year); ?></p>
                                        </td>
                                        <td>
                                            <p><?= $server->from_online('September', $year); ?></p>
                                        </td>
                                        <td>

                                            <p><?= $server->from_online('October', $year); ?></p>
                                        </td>
                                        <td>

                                            <p><?= $server->from_online('November', $year); ?></p>
                                        </td>
                                        <td>

                                            <p><?= $server->from_online('December', $year); ?></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h2>Lab Requests <span>For Drugs</span><span style="color: orangered">BDT</span></h2>
                                        </td>
                                        <td>
                                            <p><?= $server->from_drugs('January', $year); ?></p>
                                        <td>
                                            <p><?= $server->from_drugs('February', $year); ?></p>
                                        </td>
                                        <td>
                                            <p><?= $server->from_drugs('March', $year); ?></p>
                                        </td>
                                        <td>
                                            <p><?= $server->from_drugs('April', $year); ?></p>
                                        </td>
                                        <td>
                                            <p><?= $server->from_drugs('May', $year); ?></p>
                                        </td>
                                        <td>
                                            <p><?= $server->from_drugs('June', $year); ?></p>
                                        </td>
                                        <td>
                                            <p><?= $server->from_drugs('July', $year); ?></p>
                                        </td>
                                        <td>
                                            <p><?= $server->from_drugs('August', $year); ?></p>
                                        </td>
                                        <td>
                                            <p><?= $server->from_drugs('September', $year); ?></p>
                                        </td>
                                        <td>

                                            <p><?= $server->from_drugs('October', $year); ?></p>
                                        </td>
                                        <td>

                                            <p><?= $server->from_drugs('November', $year); ?></p>
                                        </td>
                                        <td>

                                            <p><?= $server->from_drugs('December', $year); ?></p>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>
                                            <h2>Lab Requests <span>For Tests</span><span style="color: orangered">BDT</span></h2>
                                        </td>
                                        <td>
                                            <p><?= $server->from_tests('January', $year); ?></p>
                                        <td>
                                            <p><?= $server->from_tests('February', $year); ?></p>
                                        </td>
                                        <td>
                                            <p><?= $server->from_tests('March', $year); ?></p>
                                        </td>
                                        <td>
                                            <p><?= $server->from_tests('April', $year); ?></p>
                                        </td>
                                        <td>
                                            <p><?= $server->from_tests('May', $year); ?></p>
                                        </td>
                                        <td>
                                            <p><?= $server->from_tests('June', $year); ?></p>
                                        </td>
                                        <td>
                                            <p><?= $server->from_tests('July', $year); ?></p>
                                        </td>
                                        <td>
                                            <p><?= $server->from_tests('August', $year); ?></p>
                                        </td>
                                        <td>
                                            <p><?= $server->from_tests('September', $year); ?></p>
                                        </td>
                                        <td>

                                            <p><?= $server->from_tests('October', $year); ?></p>
                                        </td>
                                        <td>

                                            <p><?= $server->from_tests('November', $year); ?></p>
                                        </td>
                                        <td>

                                            <p><?= $server->from_tests('December', $year); ?></p>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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