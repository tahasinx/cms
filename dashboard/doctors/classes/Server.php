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

        $userid = $_SESSION['user_id'];
        $sql = "SELECT *FROM `doctors` WHERE user_id = '$userid' ";

        $data = $this->conn->query($sql);
        return $data;
    }

    public function completeProfile($data)
    {
        $userid = $_SESSION['user_id'];

        $file_directory = '../gallery/certificates/';

        $certificate = $file_directory . basename($_FILES['certificate']['name']);
        move_uploaded_file($_FILES['certificate']['tmp_name'], $certificate);

        $directory = '../gallery/propic/doctors/';
        $propic = $directory . basename($_FILES['propic']['name']);

        $sql = "UPDATE `doctors` SET "
            . "`first_name`='$data[first_name]',"
            . "`last_name`='$data[last_name]',"
            . "`username`='$data[username]',"
            . "`password`='$data[password]',"
            . "`category`='$data[category]',"
            . "`department_id`='$data[department_id]',"
            . "`position`='$data[position]',"
            . "`joining_date`='$data[joining_date]',"
            . "`birthday`='$data[birthday]',"
            . "`gender`='$data[gender]',"
            . "`religion`='$data[religion]',"
            . "`marital_status`='$data[marital_status]',"
            . "`age`='$data[age]',"
            . "`nationality`='$data[nationality]',"
            . "`interest`='$data[interest]',"
            . "`hobby`='$data[hobby]',"
            . "`blood_group`='$data[blood_group]',"
            . "`smoking`='$data[smoking]',"
            . "`address`='$data[address]',"
            . "`country`='$data[country]',"
            . "`city`='$data[city]',"
            . "`state`='$data[state]',"
            . "`postal_code`='$data[postal_code]',"
            . "`phone`='$data[phone]',"
            . "`biography`='$data[biography]',"
            . "`propic`= '$propic',"
            . "`edu_institution`='$data[edu_institution]',"
            . "`edu_subject`='$data[edu_subject]',"
            . "`pass_year`='$data[pass_year]',"
            . "`degree`='$data[degree]',"
            . "`grade`='$data[grade]',"
            . "`last_company`='$data[last_company]',"
            . "`last_clocation`='$data[last_clocation]',"
            . "`last_cposition`='$data[last_cposition]',"
            . "`last_cjoining`='$data[last_cjoining]',"
            . "`last_cleft`='$data[last_cleft]',"
            . "`experience`='$data[experience]',"
            . "`certificate`='$certificate',"
            . "`profile_status`='1',"
            . "`doctor_status`='1',"
            . "`is_certified`='1'"
            . " WHERE user_id = '$userid'";

        if ($this->conn->query($sql) === TRUE) {
            move_uploaded_file($_FILES['propic']['tmp_name'], $propic);
            $success = "<script type='text/javascript'>alert('DATA RECEIVED SUCCESSFULLY');document.location='index.php';</script>";
            return $success;
        } else {
            return $message = 'ERROR:' . $this->conn->error;
        }
    }

    public function updateProfile($data)
    {
        $userid = $_SESSION['user_id'];
        if ($_FILES['propic']['name'] == "") {
            $propic = $_SESSION['oldpic'];
        } else {
            $propic = $directory . basename($_FILES['propic']['name']);
            move_uploaded_file($_FILES['propic']['tmp_name'], $propic);
        }


        $sql = "UPDATE `doctors` SET "
            . "`first_name`='$data[first_name]',"
            . "`last_name`='$data[last_name]',"
            . "`username`='$data[username]',"
            . "`password`='$data[password]',"
            . "`category`='$data[category]',"
            . "`department_id`='$data[department_id]',"
            . "`position`='$data[position]',"
            . "`joining_date`='$data[joining_date]',"
            . "`birthday`='$data[birthday]',"
            . "`gender`='$data[gender]',"
            . "`religion`='$data[religion]',"
            . "`marital_status`='$data[marital_status]',"
            . "`age`='$data[age]',"
            . "`nationality`='$data[nationality]',"
            . "`interest`='$data[interest]',"
            . "`hobby`='$data[hobby]',"
            . "`blood_group`='$data[blood_group]',"
            . "`smoking`='$data[smoking]',"
            . "`address`='$data[address]',"
            . "`country`='$data[country]',"
            . "`city`='$data[city]',"
            . "`state`='$data[state]',"
            . "`postal_code`='$data[postal_code]',"
            . "`phone`='$data[phone]',"
            . "`biography`='$data[biography]',"
            . "`propic`= '$propic',"
            . "`edu_institution`='$data[edu_institution]',"
            . "`edu_subject`='$data[edu_subject]',"
            . "`pass_year`='$data[pass_year]',"
            . "`degree`='$data[degree]',"
            . "`grade`='$data[grade]',"
            . "`last_company`='$data[last_company]',"
            . "`last_clocation`='$data[last_clocation]',"
            . "`last_cposition`='$data[last_cposition]',"
            . "`last_cjoining`='$data[last_cjoining]',"
            . "`last_cleft`='$data[last_cleft]',"
            . "`experience`='$data[experience]'"
            . " WHERE user_id = '$userid'";

        if ($this->conn->query($sql) === TRUE) {
            $success = "<script type='text/javascript'>alert('DATA RECEIVED SUCCESSFULLY');document.location='profile.php';</script>";
            return $success;
        } else {
            return $message = 'ERROR:' . $this->conn->error;
        }
    }

//    appointments

    public function UpcomingAppointment()
    {
        $userid = $_SESSION['user_id'];

        date_default_timezone_set('Asia/Dhaka');
        $today = date('d/m/Y');

        $sql = "SELECT * FROM `appointment` WHERE appointment_date <= '$today' AND doctor_id = '$userid' AND status = 1";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function AppointmentHistory()
    {
        $userid = $_SESSION['user_id'];
        $sql = "SELECT * FROM `appointment` WHERE doctor_id = '$userid' AND is_complete = 1 ORDER BY id DESC";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function CancelAppointment($data)
    {

        $sql = "UPDATE `appointment` SET `cancelled_cause`='$data[cancelled_cause]',`request_status`='0',`is_cancelled`='1',`status`='0' WHERE appointment_id = '$data[id]' ";
        if ($this->conn->query($sql) === TRUE) {
            echo "<script type='text/javascript'>alert('CANCELLED!');document.location='';</script>";
        } else {
            $message = 'Error:' . $this->conn->error;
            return $message;
        }
    }

//   clients

    public function getClient_NameByID($client_id)
    {
        $sql = "SELECT first_name,last_name FROM `clients` WHERE client_id = '$client_id' ";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return $row['first_name'] . ' ' . $row['last_name'];
            }
        } else {

        }
    }

    public function getClient_ImageByID($client_id)
    {
        $sql = "SELECT propic FROM `clients` WHERE client_id = '$client_id' ";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return $row['propic'];
            }
        } else {

        }
    }

    public function getClient_AddressByID($client_id)
    {
        $sql = "SELECT country,city FROM `clients` WHERE client_id = '$client_id' ";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return $row['city'] . ',' . $row['country'];
            }
        } else {

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
        $query = "SELECT COUNT(id) FROM `doctors` WHERE department_id = '$deptID' AND profile_status = 1 AND doctor_status = 1";
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

    public function average_ratingPoint($doctor_id)
    {

        $sql = "SELECT AVG(rating_point) as average FROM rating WHERE doctor_id = '$doctor_id'";
        $result = $this->conn->query($sql);
        while ($row = $result->fetch_assoc()){
            return $row['average'];
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

//    Schedule
    public function addSchedule($data)
    {
        $userid = $_SESSION['user_id'];
        $sql = "SELECT doctor_id FROM `schedule` WHERE doctor_id = '$userid'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $message = '1';
            return $message;
        } else {

            $sql = "INSERT INTO `schedule`(`doctor_id`,`day_1`, `day1_time`, `day1_status`, `day_2`, `day2_time`, `day2_status`, `day_3`, `day3_time`, `day3_status`, `day_4`, `day4_time`, `day4_status`, `day_5`, `day5_time`, `day5_status`, `day_6`, `day6_time`, `day6_status`, `day_7`, `day7_time`, `day7_status`) VALUES "
                . "('$userid','$data[day_1]','$data[day1_time]','$data[day1_status]','$data[day_2]','$data[day2_time]','$data[day2_status]','$data[day_3]','$data[day3_time]','$data[day3_status]','$data[day_4]','$data[day4_time]','$data[day4_status]','$data[day_5]','$data[day5_time]','$data[day5_status]','$data[day_6]','$data[day6_time]','$data[day6_status]','$data[day_7]','$data[day7_time]','$data[day7_status]')";

            if ($this->conn->query($sql)) {
                $message = '<span style="color:green">SCHEDULE CREATED SUCCESSFULLY.</span>';
                return $message;
            } else {
                $message = '<span style="color:red">ERROR:' . $this->conn->error . '</span>';
                return $message;
            }
        }
    }

    public function ScheduleData()
    {
        $userid = $_SESSION['user_id'];
        $sql = "SELECT *FROM `schedule` WHERE doctor_id = '$userid'";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function updateSchedule($data)
    {
        $userid = $_SESSION['user_id'];
        $sql = "UPDATE `schedule` SET "
            . "`day_1`='$data[day_1]',"
            . "`day1_time`='$data[day1_time]',"
            . "`day1_status`='$data[day1_status]',"
            . "`day_2`='$data[day_2]',"
            . "`day2_time`='$data[day2_time]',"
            . "`day2_status`='$data[day2_status]',"
            . "`day_3`='$data[day_3]',"
            . "`day3_time`='$data[day3_time]',"
            . "`day3_status`='$data[day3_status]',"
            . "`day_4`='$data[day_4]',"
            . "`day4_time`='$data[day4_time]',"
            . "`day4_status`='$data[day4_status]',"
            . "`day_5`='$data[day_5]',"
            . "`day5_time`='$data[day5_time]',"
            . "`day5_status`='$data[day5_status]',"
            . "`day_6`='$data[day_6]',"
            . "`day6_time`='$data[day6_time]',"
            . "`day6_status`='$data[day6_status]',"
            . "`day_7`='$data[day_7]',"
            . "`day7_time`='$data[day7_time]',"
            . "`day7_status`='$data[day7_status]'"
            . " WHERE `doctor_id` = '$userid'";

        if ($this->conn->query($sql) == TRUE) {
            echo '<script>alert("UPDATED");document.location="update-schedule.php";</script>';
        } else {
            echo 'ERROR:' . $this->conn->error;
        }
    }

    //    notifications

    public function get_notifications()
    {
        $userid = $_SESSION['user_id'];
        $sql = "SELECT * FROM `notifications` WHERE notification_to = '$userid' AND notification_type <> 'message' AND is_seen = 0";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function notification_seen()
    {
        $userid = $_SESSION['user_id'];
        $sql = "UPDATE `notifications` SET `is_seen`='1' WHERE notification_to = '$userid' AND notification_type = 'appointment'";
        if ($this->conn->query($sql) === TRUE) {

        } else {

        }
    }

//    totals

    public function total_notification()
    {
        $userid = $_SESSION['user_id'];
        $query = "SELECT COUNT(id) FROM `notifications` WHERE notification_to = '$userid' AND notification_type =! 'message' AND  is_seen = 0";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

    public function total_message()
    {
        $userid = $_SESSION['user_id'];
        $query = "SELECT COUNT(id) FROM `notifications` WHERE notification_to = '$userid' AND notification_type = 'message' AND is_seen = 0";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

    //    chats

    public function appointment_with()
    {
        $userid = $_SESSION['user_id'];

        date_default_timezone_set("Asia/Dhaka");
        $today = date("d/m/Y");

        $sql = "SELECT appointment_id,client_id FROM `appointment` WHERE  appointment_date = '$today' AND doctor_id = '$userid' AND type = 'online' AND status = 1 ";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function appointment_issue()
    {
        $appointment_id = $_GET['appointment_id'];

        date_default_timezone_set("Asia/Dhaka");
        $today = date("d/m/Y");

        $sql = "SELECT issue FROM `appointment` WHERE  appointment_id = '$appointment_id' ";
        $result = $this->conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            return $row['issue'];
        }
    }


    public function is_done()
    {
        $appointment_id = $_GET['appointment_id'];
        $sql = "UPDATE `appointment` SET is_visited = 1, status = 0  WHERE  appointment_id = '$appointment_id'";
        if ($this->conn->query($sql) === TRUE) {
            header('location:chat.php');
        } else {

        }
    }


    public function appointed_with()
    {
        $userid = $_SESSION['user_id'];
        $sql = "SELECT appointment_id,client_id FROM `appointment` WHERE doctor_id = '$userid' AND type = 'online' AND is_visited = 1 GROUP BY client_id";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function chat_data()
    {

        date_default_timezone_set("Asia/Dhaka");
        $userid = $_SESSION['user_id'];
        if (!isset($_GET['message_to'])) {
            $client = "";
        } else {
            $client = $_GET['message_to'];
        }


        $sql = "SELECT * FROM `chats` WHERE message_from ='$client' AND message_to = '$userid' OR message_from ='$userid' AND message_to ='$client' ";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function upload_file()
    {

        $message_from = $_SESSION['user_id'];
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
                        . "('$key','$message_to','$message_from','message','sent you a new message.','$time')";

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
        $doctor_id = $_SESSION['user_id'];

        $sql = "SELECT * FROM `notifications` WHERE notification_to = '$doctor_id' AND notification_type = 'message' AND is_seen = 0 ORDER BY id DESC ";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function message_seen($person)
    {
        $doctor_id = $_SESSION['user_id'];
        $sql = "UPDATE `notifications` SET `is_seen`= 1 WHERE notification_to = '$doctor_id' AND notification_from = '$person'";
        if ($this->conn->query($sql) === TRUE) {

        } else {

        }
    }

//    events
    public function eventData()
    {
        $sql = "SELECT * FROM `events` WHERE status = 1";
        $data = $this->conn->query($sql);
        return $data;
    }

    //chat rooms
    public function send_room_link($data)
    {
        date_default_timezone_set("Asia/Dhaka");
        $date = date("d-m-Y");

        $doctor_id = $_SESSION['user_id'];
        $client_id = $_GET['message_to'];


        $sql = "INSERT INTO `chat_rooms`(`room_link`, `doctor_id`, `client_id`,`date`) VALUES 
                ('$data[room_link]','$doctor_id','$client_id','$date')";
        if ($this->conn->query($sql) === TRUE) {
            return $message = "Link sent to the client.";
        } else {
            return $this->conn->error;
        }
    }

}

