<?php

class Server
{

    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli('localhost', 'root', '', 'cms');
        mysqli_query($this->conn, 'SET CHARACTER SET utf8');
        mysqli_query($this->conn, "SET SESSION collation_connection ='utf8_general_ci'");
    }

    public function viewData()
    {

        $clientid = $_SESSION['client_id'];
        $sql = "SELECT *FROM `clients` WHERE client_id = '$clientid' ";

        $data = $this->conn->query($sql);
        return $data;
    }

    public function updateProfile($data)
    {

        $clientid = $_SESSION['client_id'];
        $directory = '../gallery/propic/clients/';

        if ($_FILES['propic']['name'] == "") {
            $propic = $_SESSION['oldpic'];
        } else {
            $propic = $directory . basename($_FILES['propic']['name']);
            move_uploaded_file($_FILES['propic']['tmp_name'], $propic);
        }


        $sql = "UPDATE `clients` SET "
            . "`first_name`='$data[first_name]',"
            . "`last_name`='$data[last_name]',"
            . "`birthday`='$data[birthday]',"
            . "`gender`='$data[gender]',"
            . "`address`='$data[address]',"
            . "`country`='$data[country]',"
            . "`city`='$data[city]',"
            . "`state`='$data[state]',"
            . "`postal_code`='$data[postal_code]',"
            . "`propic`='$propic',"
            . "`phone`='$data[phone]',"
            . "`email`='$data[email]',"
            . "`username`='$data[username]',"
            . "`password`='$data[password]'"
            . "WHERE `client_id`='$clientid'";

        if ($this->conn->query($sql) === TRUE) {
            $success = "<script type='text/javascript'>alert('DATA RECEIVED SUCCESSFULLY');document.location='profile.php';</script>";
            return $success;
        } else {
            return $message = 'ERROR:' . $this->conn->error;
        }
    }

//Doctors

    public function viewDoctorData($data)
    {

        $sql = "SELECT *FROM `doctors` WHERE user_id = '$data[doctor_id]'";
        $result = $this->conn->query($sql);

        return $result;
    }

    public function allDoctors()
    {

        $sql = "SELECT *FROM `doctors` WHERE profile_status = 1 AND doctor_status = 1";
        $result = $this->conn->query($sql);

        return $result;
    }

    public function six_doctors()
    {

        $sql = "SELECT *FROM `doctors` WHERE profile_status = 1 AND doctor_status = 1 limit 6";
        $result = $this->conn->query($sql);

        return $result;
    }

    public function DoctorsByID($id)
    {

        $sql = "SELECT *FROM `doctors` WHERE client_id ='$id'";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return $row['dept_name'];
            }
        } else {

        }
    }

    public function TotalDoctorsBy_Dept()
    {
        $deptID = $_GET['dept_id'];
        $query = "SELECT COUNT(id) FROM `doctors` WHERE department_id = '$deptID' AND profile_status = 1 AND doctor_status = 1 ";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

    public function DoctorsByDept()
    {
        $deptID = $_GET['dept_id'];
        $sql = "SELECT *FROM `doctors` WHERE department_id = '$deptID' AND profile_status = 1 AND doctor_status = 1";
        $result = $this->conn->query($sql);

        return $result;
    }

    public function doctorName_byID($doctor_id)
    {
        $sql = "SELECT `first_name`, `last_name` FROM `doctors` WHERE user_id = '$doctor_id'";
        $result = $this->conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            return $row['first_name'] . ' ' . $row['last_name'];
        }
    }

    public function doctorImage_byID($doctor_id)
    {
        $sql = "SELECT `propic` FROM `doctors` WHERE user_id = '$doctor_id'";
        $result = $this->conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            return $row['propic'];
        }
    }

    public function doctorDept_byID($doctor_id)
    {
        $sql = "SELECT department_id FROM `doctors` WHERE user_id = '$doctor_id'";
        $result = $this->conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            return $row['department_id'];
        }
    }

    public function doctorPosition_byID($doctor_id)
    {
        $sql = "SELECT position FROM `doctors` WHERE user_id = '$doctor_id'";
        $result = $this->conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            return $row['position'];
        }
    }

    public function top_doctors()
    {
        $sql = "SELECT SUM(rating_point) as total FROM rating GROUP BY doctor_id";
        $result = $this->conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            return $row['total'];
        }
    }

//    Departments

    public function DeptData()
    {
        $sql = "SELECT *FROM department WHERE status = 1";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function getDeptNameByID($id)
    {
        $sql = "SELECT *FROM department WHERE dept_id = '$id'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return $row['dept_name'];
            }
        } else {

        }
    }

    public function getDeptDataByID()
    {
        $dept_id = $_GET['dept_id'];
        $sql = "SELECT *FROM `department` WHERE dept_id = '$dept_id'";
        $result = $this->conn->query($sql);
        return $result;
    }

//    Appointment

    public function appointment_Step1($data)
    {
        $clientid = $_SESSION['client_id'];
        date_default_timezone_set("Asia/Dhaka");
        $appointment_id = "appointment@" . date("Y-m-d") . '?' . date("H:i:s");

        $sql = "INSERT INTO `appointment`(`appointment_id`,`client_id`, `dept_id`, `doctor_type`, `issue`) VALUES"
            . " ('$appointment_id','$clientid','$data[dept_id]','$data[doctor_type]','$data[issue]')";

        if ($this->conn->query($sql)) {

            $id = "$appointment_id";
            $type = "$data[doctor_type]";
            $dept_id = "$data[dept_id]";

            $_SESSION['appointment_id'] = $id;
            $_SESSION['doctor_type'] = $type;
            $_SESSION['dept_id'] = $dept_id;
            header('location:appointment-step2.php');

        } else {
            $message = "ERROR:" . $this->conn->error;
            return $message;
        }
    }

    public function appointment_Step2($data)
    {
        $id = $_SESSION['appointment_id'];
        $sql = "UPDATE `appointment` SET `doctor_id`='$data[doctor_id]' WHERE appointment_id = '$id'";
        if ($this->conn->query($sql) === TRUE) {

            $bdt = "$data[cost_bdt]";
            $usd = "$data[cost_usd]";

            $_SESSION['cost_bdt'] = $bdt;
            $_SESSION['cost_usd'] = $usd;

            header('location:appointment-step3.php?doctor_id=' . $data['doctor_id']);
        } else {
            $result = $this->conn->query($sql);
            return $result;
        }
    }

    public function appointment_Step3($data)
    {
        $id = $_SESSION['appointment_id'];
        $sql = "UPDATE `appointment` SET `type`='$data[type]',`schedule`='$data[schedule]' WHERE appointment_id = '$id'";
        if ($this->conn->query($sql) === TRUE) {

            if ($data['type'] == 'Online') {

                $cost = $_SESSION['cost_usd'];
                $sql = "UPDATE `appointment` SET `cost_usd` = '$cost' WHERE appointment_id = '$id'";
                if ($this->conn->query($sql) === TRUE) {
                    header('location:online-payment.php');
                } else {
                    return $this->conn->query($sql);
                }

            } else {
                $cost = $_SESSION['cost_bdt'];
                $sql = "UPDATE `appointment` SET `cost_bdt`='$cost' WHERE appointment_id = '$id'";
                if ($this->conn->query($sql) === TRUE) {
                    header('location:appointment-finalstep.php');
                } else {

                    return $this->conn->query($sql);
                }

            }
        } else {
            $result = $this->conn->query($sql);
            return $result;
        }
    }

    public function appointment_StepFinal($data)
    {
        $id = $_SESSION['appointment_id'];
        $clientid = $_SESSION['client_id'];
        date_default_timezone_set('Asia/Dhaka');
        $date = date("d/m/Y");
        $time = date("H:i:s");
        $notification_id = "notification@" . date("Y-m-d") . '?' . date("H:i:s");
        $time = date("l ,F j, Y, g:i a");
        $sql = "UPDATE `appointment` SET `request_date`='$date',`request_time`='$time',`request_status`='1',`is_complete`='1' WHERE appointment_id = '$id'";
        if ($this->conn->query($sql) === TRUE) {

            $sql = "INSERT INTO `notifications`(`notification_id`, `notification_to`, `notification_from`, `notification_type`, `notification_about`, `notification_time`) VALUES "
                . "('$notification_id','admin','$clientid','appointment','sent an appointment request.','$time')";
            if ($this->conn->query($sql) === TRUE) {
                echo '<script>alert("Your request received.");document.location="appointment-history.php";</script>';
            } else {
                echo $this->conn->error;
            }
        } else {
            $result = $this->conn->query($sql);
            return $result;
        }
    }

    public function appointmentData()
    {
        $id = $_SESSION['appointment_id'];
        $sql = "SELECT *FROM `appointment` WHERE appointment_id = '$id'";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function Appointments()
    {

        $clientid = $_SESSION['client_id'];

        $sql = "SELECT *FROM `appointment` WHERE client_id ='$clientid' AND  is_complete = 1 ORDER BY id DESC ";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function upcoming_appoinment()
    {
        $clientid = $_SESSION['client_id'];

        $sql = "SELECT *FROM `appointment` WHERE client_id ='$clientid' AND is_visited = 0 AND is_complete = 0 AND status = 1 ORDER BY id DESC limit 1";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function cancelAppointment($data)
    {
        $sql = "DELETE FROM `appointment` WHERE appointment_id = '$data[appointment_id]'";
        if ($this->conn->query($sql) === TRUE) {
            $success = "<script type='text/javascript'>alert('CANCELLED!');document.location='appointment-step1.php';</script>";
            return $success;
        } else {
            return $message = 'ERROR:' . $this->conn->error;
        }
    }

//    Doctors

    public function ViewDoctorsByType()
    {

        $type = $_SESSION['doctor_type'];
        $dept_id = $_SESSION['dept_id'];

        $sql = "SELECT * FROM `doctors` WHERE category = '$type' AND department_id = '$dept_id' AND profile_status = 1 AND doctor_status = 1";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function ViewDoctorsBy_SessionID()
    {

        $id = $_SESSION['appointment_id'];
        $sql = "SELECT doctor_id FROM `appointment` WHERE appointment_id = '$id' ";
        $result = $this->conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $doctor_id = $row['doctor_id'];
        }
        $sql2 = "SELECT * FROM `doctors` WHERE user_id = '$doctor_id'";
        $output = $this->conn->query($sql2);
        return $output;
    }

    public function ScheduleData()
    {
        if (isset($_SESSION['doctor_id'])) {
            $doctor_id = $_SESSION['doctor_id'];
        } else {
            $doctor_id = "";
        }
        $sql = "SELECT *FROM `schedule` WHERE doctor_id = '$doctor_id'";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function get_ScheduleData()
    {
        $doctor_id = $_GET['doctor_id'];
        $sql = "SELECT *FROM `schedule` WHERE doctor_id = '$doctor_id'";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function average_ratingPoint($doctor_id)
    {

        $sql = "SELECT AVG(rating_point) as average FROM rating WHERE doctor_id = '$doctor_id'";
        $result = $this->conn->query($sql);
        while ($row = $result->fetch_assoc()){
            return $row['average'];
        }
     }

//    rating
    public function rate_doctor()
    {
        $clientid = $_SESSION['client_id'];

        $sql = "SELECT *FROM `appointment` WHERE client_id ='$clientid' AND is_visited = 1 AND is_rated = 0 ORDER BY id DESC limit 1";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function get_RatingPoint($data)
    {

        $clientid = $_SESSION['client_id'];

        $sql = "UPDATE `appointment` SET `is_rated`=1 WHERE appointment_id = '$data[appointment_id]'";
        if ($this->conn->query($sql) === TRUE) {
            $sql = "INSERT INTO `rating`(`appointment_id`, `doctor_id`, `rated_by`, `rating_point`) VALUES "
                . "('$data[appointment_id]', '$data[doctor_id]','$clientid','$data[point]')";
            if ($this->conn->query($sql) === TRUE) {
                echo '<script>alert("Thanks For Your Response.");document.location="";</script>';
            } else {
                return $this->conn->error;
            }
        } else {
            return $this->conn->error;
        }
    }

    //    notifications

    public function get_notifications()
    {

        $clientid = $_SESSION['client_id'];

        $sql = "SELECT * FROM `notifications` WHERE notification_to = '$clientid' and is_seen = 0";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function notification_seen()
    {
        $clientid = $_SESSION['client_id'];
        $sql = "UPDATE `notifications` SET `is_seen`='1' WHERE notification_to = '$clientid' AND notification_type = 'appointment'";
        if ($this->conn->query($sql) === TRUE) {

        } else {

        }
    }

//    totals

    public function total_notification()
    {
        $clientid = $_SESSION['client_id'];
        $query = "SELECT COUNT(id) FROM `notifications` WHERE notification_to = '$clientid' AND notification_type = 'appointment' AND  is_seen = 0";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

    public function total_message()
    {
        $clientid = $_SESSION['client_id'];
        $query = "SELECT COUNT(id) FROM `notifications` WHERE notification_to = '$clientid' AND notification_type = 'message' AND is_seen = 0";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

//    chats

    public function appointment_with()
    {
        $clientid = $_SESSION['client_id'];

        date_default_timezone_set("Asia/Dhaka");
        $today = date("d/m/Y");

        $sql = "SELECT doctor_id FROM `appointment` WHERE  appointment_date = '$today' AND client_id = '$clientid' AND type = 'online' AND status = 1 ";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function appointed_with()
    {
        $clientid = $_SESSION['client_id'];

        $sql = "SELECT doctor_id FROM `appointment` WHERE client_id = '$clientid' AND type = 'online' AND is_visited = 1";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function chat_data()
    {

        date_default_timezone_set("Asia/Dhaka");
        $client = $_SESSION['client_id'];
        if (!isset($_GET['message_to'])) {
            $doctor = "";
        } else {
            $doctor = $_GET['message_to'];
        }


        $sql = "SELECT * FROM `chats` WHERE message_from ='$client' AND message_to = '$doctor' OR message_from ='$doctor' AND message_to ='$client' ";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function upload_file()
    {

        $message_from = $_SESSION['client_id'];
        date_default_timezone_set("Asia/Dhaka");
        $date = date("d-m-Y");
        $time = date("l ,F j, Y, g:i a");
        $id = "message@chat#" . date("d-m-Y") . '?' . date("H:i:s");
        $key = "notification@" . date("d-m-Y") . '?' . date("H:i:s");


        $message_to = $_POST['message_to'];
        $file_type = $_POST['file_type'];

        $directory = '../gallery/chats/';


        if ($_FILES['file_name']['name'] == "") {

        } else {

            $file_path = $directory . basename($_FILES['file_name']['name']);

            $sql = "INSERT INTO `chats`(`message_id`, `message_from`, `message_to`, `file_path`, `file_type`, `message_date`, `message_time`) VALUES "
                . "('$id','$message_from','$message_to','$file_path','$file_type','$date','$time') ";

            if ($this->conn->query($sql)) {


                move_uploaded_file($_FILES['file_name']['tmp_name'], $file_path);

                $sql = "UPDATE `chats` SET `is_seen`= 1 WHERE message_from ='$message_to' AND message_to = '$message_from'";

                if ($this->conn->query($sql) === TRUE) {

                    $sql = "INSERT INTO `notifications`(`notification_id`, `notification_to`, `notification_from`, `notification_type`,`notification_about`,`notification_time`) VALUES "
                        . "('$key','$message_to','$message_from','Message','Sent you a new message.','$time')";

                    if ($this->conn->query($sql) === TRUE) {
                        header('location: chat.php?message_to=' . $message_to . '&status=1');
                    }
                } else {

                }
            } else {

            }
        }
    }

    public function message_notification()
    {
        $client_id = $_SESSION['client_id'];

        $sql = "SELECT * FROM `notifications` WHERE notification_to = '$client_id' AND notification_type = 'message' AND is_seen = 0 ORDER BY id DESC ";
        $result = $this->conn->query($sql);
        return $result;
    }

//    events
    public function eventData()
    {
        $sql = "SELECT * FROM `events` WHERE status = 1";
        $data = $this->conn->query($sql);
        return $data;
    }

    public function message_seen($person)
    {
        $client_id = $_SESSION['client_id'];
        $sql = "UPDATE `notifications` SET `is_seen`= 1 WHERE notification_to = '$client_id' AND notification_from = '$person'";
        if ($this->conn->query($sql) === TRUE) {

        } else {

        }
    }

    //lab requests

    public function order_drugs($data)
    {

        $client_id = $_SESSION['client_id'];

        date_default_timezone_set("Asia/Dhaka");
        $time = date("d-m-Y");
        $id = "request@" . date("dmY") . '?' . date("His");
        $directory = '../gallery/prescriptions/';
        $file_path = $directory . basename($_FILES['prescription_image']['name']);

        if (file_exists($file_path)) {
            echo '<script>alert("Sorry! The file name exist. Rename or choose another one.");document.location="request-drugs.php";</script>';
        } else {

            $sql = "INSERT INTO `lab-requests`(`request_id`,`requested_by`, `request_for`, `prescription_image`, `requested_on`) 
                    VALUES ('$id','$client_id','drug','$file_path','$time')";

            if ($this->conn->query($sql) === TRUE) {

                move_uploaded_file($_FILES['prescription_image']['tmp_name'], $file_path);
                echo '<script>alert("We have received your request.");document.location="request-drugs.php";</script>';

            } else {
                return $this->conn->error;
            }
        }

    }

    public function view_drug_requests()
    {

        $client_id = $_SESSION['client_id'];
        $sql = "SELECT * FROM `lab-requests` WHERE requested_by = '$client_id' AND request_for ='drug' ORDER BY id DESC";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function total_drug_requestS()
    {
        $client_id = $_SESSION['client_id'];
        $sql = "SELECT id FROM `lab-requests` WHERE requested_by = '$client_id' AND request_for ='drug' ";
        $result = $this->conn->query($sql);
        return $result->num_rows;
    }

    public function order_tests($data)
    {

        $client_id = $_SESSION['client_id'];

        date_default_timezone_set("Asia/Dhaka");
        $time = date("d-m-Y");
        $id = "request@" . date("dmY") . '?' . date("His");
        $directory = '../gallery/prescriptions/';
        $file_path = $directory . basename($_FILES['prescription_image']['name']);

        if (file_exists($file_path)) {
            echo '<script>alert("Sorry! The file name exist. Rename or choose another one.");document.location="request-drugs.php";</script>';
        } else {

            $sql = "INSERT INTO `lab-requests`(`request_id`,`requested_by`, `request_for`, `prescription_image`, `requested_on`) 
                    VALUES ('$id','$client_id','test','$file_path','$time')";

            if ($this->conn->query($sql) === TRUE) {

                move_uploaded_file($_FILES['prescription_image']['tmp_name'], $file_path);
                echo '<script>alert("We have received your request.");document.location="request-tests.php";</script>';

            } else {
                return $this->conn->error;
            }
        }

    }

    public function view_test_requests()
    {

        $client_id = $_SESSION['client_id'];
        $sql = "SELECT * FROM `lab-requests` WHERE requested_by = '$client_id' AND request_for ='test' ORDER BY id DESC ";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function total_test_requestS()
    {
        $client_id = $_SESSION['client_id'];
        $sql = "SELECT id FROM `lab-requests` WHERE requested_by = '$client_id' AND request_for ='test' ";
        $result = $this->conn->query($sql);
        return $result->num_rows;
    }

    public function cancel_request($data)
    {
        $sql = "UPDATE `lab-requests` SET
                `is_pending`=0,
                `is_processing`=0,
                `is_feedbacked`=0,
                `is_agreed`=0,
                 is_cancelled = 1
                WHERE id = '$data[serial_no]'";
        if ($this->conn->query($sql) === TRUE) {
            echo '<script>alert("Request has been cancelled.");document.location="";</script>';

        } else {
            return $this->conn->error;
        }
    }

    public function feedbacked_data($request_id)
    {

        $sql = "SELECT * FROM `feedback` WHERE request_id = '$request_id'";
        $result = $this->conn->query($sql);
        return $result;

    }

    public function total_price()
    {
        $request_id = $_GET['request_id'];
        $sql = "SELECT SUM(`unit_price`) as `total` FROM `feedback` WHERE request_id = '$request_id' ";
        $result = $this->conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            return $row['total'];
        }
    }

    public function delivery_cost()
    {
        $request_id = $_GET['request_id'];
        $sql = "SELECT delivery_cost FROM `feedback` WHERE request_id = '$request_id' ORDER BY id DESC limit 1 ";
        $result = $this->conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            return $row['delivery_cost'];
        }
    }

    public function confirm_feedback($data)
    {
        date_default_timezone_set("Asia/Dhaka");
        $month = date("F");
        $year = date("Y");

        $sql = "UPDATE `lab-requests` SET 
                `month`= '$month',
                `year`= '$year',
                `is_pending`=0,
                `is_processing`=0,
                `is_feedbacked`=0,
                `is_agreed`=1,
                `total_cost`='$data[total_cost]'
                 WHERE  request_id = '$data[request_id]'";

        if ($this->conn->query($sql) === TRUE) {

            $sql = "UPDATE `lab-requests` SET
                `total_cost`= '$data[total_cost]'
                  WHERE request_id = '$data[request_id]'";
            if ($this->conn->query($sql) === TRUE) {

                $url = $_GET['url'];
                echo '<script>alert("Confirmed!.");document.location="' . $url . '";</script>';

            } else {
                return $this->conn->error;
            }

        } else {
            return $this->conn->error;
        }
    }

    public function mark_as_received($data)
    {
        date_default_timezone_set("Asia/Dhaka");
        $date = date("d-m-Y");

        $sql = "UPDATE `lab-requests` SET 
                `received_on`='$date',
                `is_pending`=0,
                `is_processing`=0,
                `is_feedbacked`=0,
                `is_delivered`=0,
                `is_agreed`=0,
                `is_received`=1
                WHERE  id = '$data[serial_no]'";

        if ($this->conn->query($sql) === TRUE) {
            echo '<script>alert("Confirmed!.");document.location="";</script>';
        } else {
            return $this->conn->error;
        }
    }

    public function check_chat_room()
    {

        date_default_timezone_set("Asia/Dhaka");
        $date = date("d-m-Y");

        $client_id = $_SESSION['client_id'];
        $doctor_id = $_GET['message_to'];

        $sql = "SELECT * FROM `chat_rooms` WHERE client_id = '$client_id' AND doctor_id ='$doctor_id' AND date = '$date' AND is_joined= 0 ORDER BY id DESC LIMIT 1";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return $row['room_link'];
            }
        } else {

        }


    }

    public function is_joined()
    {
        $url = $_GET['url'];
        $sql = "UPDATE `chat_rooms` SET `is_joined`= 1 WHERE room_link = '$url'";
        if ($this->conn->query($sql) === TRUE) {
            header('location:' . $url);
        } else {
            return $this->conn->error;
        }

    }

//    appointment token

    public function appointment_data($id)
    {
        $sql = "SELECT * FROM `appointment` WHERE appointment_id = '$id'";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function doctor_profile($doctor_id)
    {
        $sql = "SELECT * FROM `doctors` WHERE user_id = '$doctor_id'";
        $result = $this->conn->query($sql);
        return $result;
    }
}
