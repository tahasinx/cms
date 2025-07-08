<?php

session_start();
if (!isset($_SESSION["client_id"])) {
    header("location:logout.php");
}

require_once './classes/Server.php';
$result = "";
$cancel = "";

$server = new Server();
$result = $server->viewData();

if (isset($_POST['cancel'])) {
    $cancel = $server->cancelAppointment($_POST);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <title>CMS</title>
    <?php include './parts/css-links.php'; ?>
    <style>
        .content {
            font-family: 'Titillium Web', sans-serif;
        }

        form {
            font-size: 15px
        }

        .blink_me {
            animation: blinker 2s linear infinite;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }

        @import url(https://fonts.googleapis.com/css?family=Roboto);

        .sign-box {
            position: relative;
            display: block;
            width: 600px;
            margin: 50px auto;
            background-color: #FFF;
            padding: 10px;
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2);
            color: #444;
        }

        .sign-box .title {
            font-size: 22px;
            text-transform: uppercase;
            margin: 15px 0;
            display: block;
            font-weight: 600;
            text-align: center;
        }

        .sign-box .input-field,
        .sign-box .checkbox-field {
            width: 300px;
            margin: 15px auto;
            position: relative;
        }

        .sign-box .input-field label.label {
            position: absolute;
            left: 15px;
            top: 15px;
            font-size: 14px;
            color: #ABABAB;
            font-weight: normal;
            transition: all ease-in-out 0.2s;
        }

        .sign-box .input-field input.input {
            width: 100%;
            padding: 0 15px;
            height: 45px;
            line-height: 50px;
            margin: 0;
            font-size: 14px;
            box-sizing: border-box;
            border: 2px solid #ABABAB;
            outline: none;
            color: #555;
        }

        .sign-box .input-field input.input:focus,
        .sign-box .input-field input.input.has-value {
            border-color: #3F51B5;
        }

        .sign-box .input-field input.input:focus + label.label,
        .sign-box .input-field input.input.has-value + label.label {
            top: -6px;
            left: 12px;
            font-size: 13px;
            background-color: #FFF;
            padding: 0 4px;
            color: #3F51B5;
        }

        .sign-box .checkbox-field input.checkbox {
            position: absolute;
            left: -9999px;
        }

        .sign-box .checkbox-field label.label {
            padding-left: 28px;
            font-size: 14px;
            color: #444;
            cursor: pointer;
        }

        .sign-box .checkbox-field label.label:before,
        .sign-box .checkbox-field label.label:after {
            content: '';
            position: absolute;
            -webkit-transition: all;
            -o-transition: all;
            transition: all;
            -webkit-transition-duration: 250ms;
            transition-duration: 250ms;
            -webkit-backface-visibility: hidden;
        }

        .sign-box .checkbox-field label.label:before {
            left: 0;
            top: 1px;
            height: 15px;
            width: 15px;
            border: 1px solid #ABABAB;
        }

        .sign-box .checkbox-field input.checkbox:checked + label.label:before {
            -webkit-transform: scale(0);
            -ms-transform: scale(0);
            -o-transform: scale(0);
            transform: scale(0);
        }

        .sign-box .checkbox-field label.label:after {
            left: 2px;
            top: 2px;
            opacity: 0;
            -webkit-transform: scale(0) rotate(80deg);
            -ms-transform: scale(0) rotate(80deg);
            -o-transform: scale(0) rotate(80deg);
            transform: scale(0) rotate(80deg);
            width: 18px;
            height: 7px;
            border-bottom: 2px solid #3F51B5;
            border-left: 2px solid #3F51B5;
            border-bottom-left-radius: 2px;
        }

        .sign-box .checkbox-field input.checkbox:checked + label.label:after {
            -webkit-transform: scale(1) rotate(-50deg);
            -ms-transform: scale(1) rotate(-50deg);
            -o-transform: scale(1) rotate(-50deg);
            transform: scale(1) rotate(-50deg);
            opacity: 1;
        }

        .sign-box .input-field.right {
            text-align: right;
        }

        .sign-box .input-field .btn {
            min-width: 110px;
            font-size: 14px;
            padding: 8px 0;
            background: #3F51B5;
            color: #FFF;
            border: none;
            text-transform: uppercase;
            box-shadow: 0 1px 5px 0 rgba(0, 0, 0, 0.2);
        }

        .sign-box .input-field .btn:hover {
            background-color: #354497;
        }
    </style>
</head>

<body>
<div class="main-wrapper">
    <?php while ($row = $result->fetch_assoc()) { ?>
        <?php
        if ($row['status'] == 0) {
            echo "<script type='text/javascript'>alert('SORRY! YOU ARE BLOCKED!');document.location='logout.php';</script>";
        }
        ?>
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
                <div class="col-sm-7 col-6">
                    <h4 class="page-title"><u>Create Appointment:</u><span style="color:orangered">&emsp;STEP-4</span>:Online
                        Payment<?php echo $cancel; ?></h4>
                </div>

                <div class="col-sm-5 col-6 text-right m-b-30">
                    <form method="POST">
                        <?php $appointment_id = $_SESSION['appointment_id'] ?>
                        <input type="hidden" name="appointment_id" value="<?php echo $appointment_id ?>"/>
                        <button class="btn btn-danger" type="submit" name="cancel"
                                onclick="return confirm('Are sure to cancel?');">
                            <i class="fa fa-times"></i> Cancel
                        </button>
                    </form>
                </div>
            </div>
            <br>
            <div class="row doctor-grid">
                <div class="card col-sm-12" style="min-height: 250px;">
                    <div class="row">

                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content" style="background: none;border:none">
                                    <div class="modal-body">
                                        <div class="sign-box">
                                            <button type="button" class="close" data-dismiss="modal" style="outline: none">&times;</button>
                                            <h1 class="title" style="color:blueviolet">PAYMENT GATEWAY <i class="fa fa-cc-paypal"></i>&nbsp;<i class="fa fa-cc-mastercard"></i>&nbsp;<i class="fa fa-cc-visa"></i></h1>
                                            <form action="appointment-finalstep.php" method="get" autocomplete="off">
                                                <div class="input-field">
                                                    <input id="email" type="number" name="card" class="input" required>
                                                    <label for="email" class="label">Credit / Devid Card Number <span
                                                                class="text-danger">*</span>
                                                    </label>
                                                </div>
                                                <center>
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                <div class="input-field" style="width: 150px">
                                                                    <input id="month" name="month" type="number" min="1"
                                                                           list="months" class="input" required>
                                                                    <label for="month" class="label">
                                                                        Expiry Month
                                                                    </label>
                                                                </div>
                                                                <datalist id="months">
                                                                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                                                                        <option><?= $i; ?></option>
                                                                    <?php } ?>
                                                                </datalist>
                                                            </td>
                                                            <td>
                                                                <div class="input-field" style="width: 150px">
                                                                    <input id="year" type="text" name="year" min="2020" list="years"
                                                                           class="input" required>
                                                                    <label for="year" class="label">
                                                                        Expiry Year
                                                                    </label>
                                                                </div>
                                                                <datalist id="years">
                                                                    <?php for ($i = 2020; $i <= 2050; $i++) { ?>
                                                                        <option><?= $i; ?></option>
                                                                    <?php } ?>
                                                                </datalist>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div class="input-field">
                                                        <input id="cvc" type="number" name="cvv" min="100" class="input" required>
                                                        <label for="cvc" class="label">CVV Code
                                                            <span class="text-danger">*</span></label>
                                                    </div>
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                <div>
                                                                    <button class="btn btn-dark" style="width: 150px"><?= $_SESSION['cost_usd'] ?> USD</button>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div style="width: 150px">
                                                                    <button type="submit" class="btn btn-success" style="width: 150px;"><i class="fa fa-money"></i>&emsp;Pay Now</button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </center>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                data-target="#myModal">Checkout / Pay
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php include './parts/messages.php'; ?>
    </div>

</div>
<?php include './parts/js-links.php'; ?>

<script>
    $('.input-field .input').blur(function () {
        if (!this.value) {
            $(this).removeClass('has-value');
        } else {
            $(this).addClass('has-value');
        }
    });
</script>
</body>
</html>