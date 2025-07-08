<?php

session_start();
$adminid = $_SESSION['admin_id'];

if (!isset($_SESSION["admin_id"])) {
    header("location:logout.php");
}

require_once './classes/Server.php';


$server = new Server();
$result = $server->adminData();
$data = $server->viewDoctorlist();
$total = $server->viewDoctorlist();

$output = "";

if (isset($_POST['update'])) {
    $output = $server->update_visiting_price($_POST);
}
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
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <input id="myInput" type="text" placeholder="Search ...." list="dept"
                                   style="height: 35px;width: 40%;border: 1px solid;text-align: center">
                            <datalist id="dept">
                                <?php
                                $dept = $server->viewDeptData();
                                while ($x = $dept->fetch_assoc()) {
                                    ?>
                                    <option><?= $x['dept_name'] ?></option>
                                    <?php
                                }
                                ?>
                            </datalist>

                            <a href="" class="btn btn-outline-dark float-right">
                                <span style="color:orangered ">
                                    Total Doctors: <?= $total->num_rows ?>
                                </span>
                            </a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">


                                <table class="table mb-0">

                                    <tbody id="myTable">
                                    <?php
                                    $i = 1;
                                    $j = 1;
                                    if ($data->num_rows > 0) {
                                        while ($row = $data->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td style="min-width: 200px;">
                                                    <a class="avatar"
                                                       href="doctor-profile.php?doctor_id=<?= $row['user_id'] ?>&view=">
                                                        <img src="<?= $row['propic'] ?>">
                                                    </a>
                                                    <h2>
                                                        <a href="doctor-profile.php?doctor_id=<?= $row['user_id'] ?>&view="><?= $row['first_name'] . '' . $row['last_name'] ?>
                                                            <span><?= $row['city'] . ',' . $row['country'] ?> </span></a>
                                                    </h2>
                                                </td>
                                                <td>
                                                    <h5 class="time-title p-0">Department</h5>
                                                    <p><?= $server->getDeptNameByID($row['department_id']) ?> </p>
                                                </td>
                                                <td>
                                                    <h5 class="time-title p-0">Position</h5>
                                                    <p><?= $row['position'] ?> </p>
                                                </td>
                                                <td>
                                                    <h5 class="time-title p-0">In BDT</h5>
                                                    <p><?= $row['cost_bdt'] ?> </p>
                                                </td>
                                                <td>
                                                    <h5 class="time-title p-0">In USD</h5>
                                                    <p><?= $row['cost_usd'] ?> </p>
                                                </td>
                                                <td class="text-right">
                                                    <button data-toggle="modal" data-target="#myModal<?= $i++ ?>"
                                                            class="btn btn-outline-primary take-btn">Update
                                                    </button>
                                                </td>
                                                <td>
                                                    <form method="POST">
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="myModal<?= $j++ ?>" role="dialog">
                                                            <div class="modal-dialog">

                                                                <!-- Modal content-->
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <a class="avatar"
                                                                           href="doctor-profile.php?doctor_id=<?= $row['user_id'] ?>&view=">
                                                                            <img src="<?= $row['propic'] ?>">
                                                                        </a>
                                                                        <h2>
                                                                            <a href="doctor-profile.php?doctor_id=<?= $row['user_id'] ?>&view="><?= $row['first_name'] . '' . $row['last_name'] ?>
                                                                                <span><?= $row['city'] . ',' . $row['country'] ?> </span></a>
                                                                        </h2>
                                                                        <button type="button" class="close text-danger"
                                                                                data-dismiss="modal">&times;
                                                                        </button>

                                                                    </div>
                                                                    <div class="modal-body">


                                                                        <input type="hidden" name="doctor_id"
                                                                               value="<?= $row['user_id'] ?>">

                                                                        <label>Cost In Taka</label>
                                                                        <input class="form-control" type="number"
                                                                               name="cost_bdt"
                                                                               value="<?= $row['cost_bdt'] ?>"
                                                                               min="1" required
                                                                               placeholder="Enter Visiting Price" step="any"
                                                                               style="border: 1px solid"><br>
                                                                        <label>Cost In USD</label>
                                                                        <input class="form-control" type="number" step="any"
                                                                               name="cost_usd"
                                                                               value="<?= $row['cost_usd'] ?>"
                                                                               min="1" required
                                                                               placeholder="Enter Visiting Price"
                                                                               style="border: 1px solid"><br><br>
                                                                        <button type="submit" name="update"
                                                                                class="form-control btn btn-primary take-btn">
                                                                            Update
                                                                        </button>


                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default"
                                                                                data-dismiss="modal">Close
                                                                        </button>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </form>
                                                </td>

                                            </tr>
                                            <?php
                                        }
                                    } else { ?>
                                        <tr>
                                            <td colspan="6">
                                                <center>
                                                     <span class="text-danger">
                                                          No Request Found !
                                                     </span>
                                                </center>
                                            </td>
                                        </tr>
                                    <?php } ?>
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