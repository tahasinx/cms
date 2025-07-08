<?php
session_id("session1");
session_start();
require_once '../auth/Login.php';
$result = '';

if (isset($_SESSION['admin_id'])) {
    header('location:../../dashboard/admin/index.php');
}

$login = new Login();

if (isset($_POST['login'])) {

    $result = $login->adminLogin($_POST);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>CMS</title>
        <?php include '../parts/links.php'; ?>
    </head>
    <body>
        <div class="main-wrapper account-wrapper">
            <div class="row">
                <div class="col-sm-4">
                    <center>
                        <a href="../../home/">
                            <h2>
                                <b>Project CMS</b>
                            </h2>
                        </a>
                    </center>
                </div>
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <h4 style="text-align: center"><a href="../admin/" style="color:orangered">Admin Portal</a>&emsp;||&emsp;<a href="../doctor/"  class="active">Doctors Portal</a></h4>
                </div>
            </div>
            <div class="account-page">
                <div class="account-center">
                    <div class="account-box">
                        <form method="POST" action="" class="form-signin" autocomplete="off">
                            <div class="account-logo">
                                <h1>Admin Portal</h1>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Enter username" autocomplete="nope" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter password" autocomplete="new-password" required>
                            </div>
                            <div class="form-group text-right">
                                <a href="forgot-password.php">Forgot your password?</a>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" name="login" class="btn btn-primary account-btn">Login</button>
                            </div>
                            <?php echo $result ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include '../parts/scripts.php'; ?>
    </body>

</html>