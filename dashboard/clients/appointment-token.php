<?php

session_start();
if (!isset($_SESSION["client_id"])) {
    header("location:logout.php");
}

$conn = new mysqli("localhost", "root", "", "cms");
require_once './classes/Server.php';


$server = new Server();
$result = $server->viewData();

$data = $server->appointment_data($_GET['appointment_id']);

while ($row = $data->fetch_assoc()) {

    $doctor_id = $row['doctor_id'];
    $type = $row['type'];
    $schedule = $row['schedule'];
    $date = $row['appointment_date'];

}

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+39+Extended&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Play&display=swap" rel="stylesheet">
    <title>CMS</title>
    <?php include './parts/css-links.php'; ?>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Play', sans-serif;
        }
        @media print {
            #printPageButton {
                display: none;
            }
        }

        @page {
            size: auto;   /* auto is the initial value */
            margin: 0;  /* this affects the margin in the printer settings */
        }

        @media print {
            #downloadPageButton {
                display: none;
            }
        }

        @media print
        {
            a[href]:after { content: none !important; }
            img[src]:after { content: none !important; }
        }
        @media print { .no_print { display: none; }
    </style>
</head>
<body>
<div class="row">
   <div class="col-sm-12">
        <div class="dash-widget" style="margin-right: 20%;margin-top:5%;margin-left: 20%;border: 1px solid">
            <a href="#" class="no_print btn btn-outline-primary"  onClick="window.print();">
                <i class="fa fa-print"></i>Print
            </a>
            <div class="chart-title">
                <center>
                    <h2><u>PROJECT CMS</u></h2>
                    <h4>Appointment Token</h4>
                    <h5 style="font-family: 'Libre Barcode 39 Extended', cursive;font-size: 30px">xxxxxx</h5>
                </center>
            </div>
            <div class="dash-widget-info">
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10">
                        <h4><b>Client Profile:</b></h4>
                    </div>
                    <div class="col-sm-2"></div>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="col-sm-2">
                            <img alt="" src="<?= $row['propic'] ?>"
                                 onerror="this.onerror=null; this.src='../gallery/propic/doctors/default.jpg'"
                                 alt="" style="height: 150px;width: 150px;border: 1px solid">
                        </div>
                        <div class="col-sm-2"></div>
                        <div class="col-sm-5">
                            <table>
                                <tr>
                                    <td style="color:orangered">Client Name:</td>
                                    <td><?= $row['first_name'] . '' . $row['last_name'] ?></td>
                                </tr>
                                <tr>
                                    <td style="color:orangered">Country:</td>
                                    <td><?= $row['country'] ?></td>
                                </tr>
                                <tr>
                                    <td style="color:orangered">City:</td>
                                    <td><?= $row['city'] ?></td>
                                </tr>
                                <tr>
                                    <td style="color:orangered">Address:</td>
                                    <td><?= $row['address'] ?></td>
                                </tr>
                                <tr>
                                    <td style="color:orangered">Contact NO:</td>
                                    <td><?= $row['phone'] ?></td>
                                </tr>
                                <tr>
                                    <td style="color:orangered">Email:</td>
                                    <td><?= $row['email'] ?></td>
                                </tr>
                            </table>
                        </div>
                    <?php } ?>

                    <div class="col-sm-12">
                        <hr>
                        <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">
                                <h4><b>Appointment With:</b></h4>
                            </div>
                            <div class="col-sm-2"></div>
                            <?php
                            $doctor = $server->doctor_profile($doctor_id);

                            while ($row = $doctor->fetch_assoc()) {
                                ?>
                                <div class="col-sm-2">
                                    <img alt="" src="<?= $row['propic'] ?>"
                                         onerror="this.onerror=null; this.src='../gallery/propic/doctors/default.jpg'"
                                         alt="" style="height: 150px;width: 150px;border: 1px solid">
                                </div>
                                <div class="col-sm-2"></div>
                                <div class="col-sm-5">
                                    <table>
                                        <tr>
                                            <td style="color:orangered">Name:</td>
                                            <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="color:orangered">Type:</td>
                                            <td><?php echo $row['category']; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="color:orangered">Degree:</td>
                                            <td><?php echo $row['degree']; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="color:orangered">Position:</td>
                                            <td><?php echo $row['position']; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="color:orangered">Ratings:</td>
                                            <td >
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star checked"></span>
                                                <span class="fa fa-star"></span>
                                                <span class="fa fa-star"></span>
                                            </td>
                                        </tr>

                                        <?php
                                        if ($type == 'Online') {
                                            $cost =  $row['cost_usd'].'&nbsp; USD';
                                        } elseif ($type == 'Physical') {
                                            $cost = $row['cost_bdt'].'&nbsp; BDT';
                                        }
                                        ?>
                                    </table>

                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <hr>
                        <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10" style="height: 100px">
                                <table>
                                    <tr>
                                        <td style="color:blue">Appointment Date:</td>
                                        <td>&emsp;<?= $date; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="color:blue">Schedule:</td>
                                        <td>&emsp;<?= $schedule; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="color:blue">Visiting Cost:</td>
                                        <td>&emsp;<?= $cost; ?></td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</body>
</html>

