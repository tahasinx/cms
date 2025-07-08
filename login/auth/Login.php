<?php

class Login {

    private $conn;

    public function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'cms');
        mysqli_query($this->conn, 'SET CHARACTER SET utf8');
        mysqli_query($this->conn, "SET SESSION collation_connection ='utf8_general_ci'");
    }


    public function adminLogin($data) {

        $sql = "SELECT *FROM `admin` WHERE username = '$data[username]' AND password = '$data[password]'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['status'] == 0) {
                    return $message = '<center><span style="color:red">Sorry! You are not authorized!</span></center>';
                } else {
                    $adminid = $row['admin_id'];
                    $_SESSION['admin_id'] = $adminid;
                    header('location:../../dashboard/admin/index.php');
                }
            }
        } else {
            return $message = '<center><span style="color:red">Incorrect Login Details!</span></center>';
        }
    }

    public function doctorLogin($data) {

        $sql = "SELECT `id`, `first_name`,`last_name`, `username`, `user_id`, `password`, `profile_status`, `doctor_status` FROM `doctors` WHERE username = '$data[username]' AND password = '$data[password]'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                if ($row['profile_status'] == 0) {
                    $userid = $row['user_id'];
                    $_SESSION['user_id'] = $userid;
                    header('location:../../dashboard/doctors/complete-profile.php');
                } elseif ($row['doctor_status'] == 0) {
                    return $message = '<center><span style="color:red">Sorry! You are not authorized!</span></center>';
                } else {
                    $userid = $row['user_id'];
                    $_SESSION['user_id'] = $userid;
                    header('location:../../dashboard/doctors/index.php');
                }
            }
        } else {
            return $message = '<center><span style="color:red;">Incorrect Login Details!</span></center>';
        }
    }

    public function clientLogin($data) {

        $sql = "SELECT *FROM `clients` WHERE username = '$data[username]' AND password = '$data[password]'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if($row['status'] == 0) {
                    return $message = '<center><span style="color:red">Sorry! You are not authorized!</span></center>';
                } else {
                    $clientid = $row['client_id'];
                    $_SESSION['client_id'] = $clientid;
                    header('location:../../dashboard/clients/index.php');
                }
            }
        } else {
            return $message = '<center><span style="color:red;">Incorrect Login Details!</span></center>';
        }
    }

}
