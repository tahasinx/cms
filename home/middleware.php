<?php

session_start();

if (!isset($_SESSION['logged_in'])) {
    echo '<script>if (window.confirm("You are not logged in. Please login to continue.")) {
        window.location.href = "../login/client/";

    } else {
        window.location.href = "index.php";
    }</script>';
} else {
    echo 'ok';
}
?>
