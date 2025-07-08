<?php 
require_once '../auth/Login.php';
$result = '';

$login = new Login();

if(isset($_POST['login'])){
    
    $result = $login->doctorLogin($_POST);
    
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
            <div class="account-page">
                <div class="account-center">
                    <div class="account-box">
                        <form method="POST" action="" class="form-signin" autocomplete="off">
                            <div class="account-logo">
                                <a href="index.html"><img src="../assets/img/logo-dark.png" alt=""></a>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" autocomplete="nope">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" autocomplete="new-password">
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