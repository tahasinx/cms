<?php

class Server
{

    private $conn;

    public function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'cms');
        mysqli_query($this->conn, 'SET CHARACTER SET utf8');
        mysqli_query($this->conn, "SET SESSION collation_connection ='utf8_general_ci'");
    }

    public function adminData()
    {
        $adminid = $_SESSION['admin_id'];
        $sql = "SELECT *FROM admin WHERE admin_id = '$adminid' AND type='admin'";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function updateAdmin($data)
    {
        $adminid = $_SESSION['admin_id'];
        $directory = '../gallery/propic/admin/';

        if ($_FILES['propic']['name'] == "") {
            $propic = $_SESSION['oldpic'];
        } else {
            $propic = $directory . basename($_FILES['propic']['name']);
            move_uploaded_file($_FILES['propic']['tmp_name'], $propic);
        }


        $sql = "UPDATE `admin` SET "
            . "`first_name`='$data[first_name]',"
            . "`last_name`='$data[last_name]',"
            . "`email`='$data[email]',"
            . "`phone`='$data[phone]',"
            . "`admin_id`='$data[admin_id]',"
            . "`username`='$data[username]',"
            . "`password`='$data[password]',"
            . "`propic`='$propic'"
            . " WHERE admin_id = '$adminid'";

        if ($this->conn->query($sql) === TRUE) {
            echo "<script type='text/javascript'>alert('DATA UPDATED SUCCESSFULLY');document.location='profile.php';</script>";
        } else {
            return $message = 'ERROR:' . $this->conn->error;
        }
    }

//    Doctors
    public function doctorAuthData()
    {

        $fname = $_POST['first_name'];
        $lname = $_POST['last_name'];

        $username = $_POST['username'];
        $userid = $_POST['user_id'];
        $password = $_POST['password'];
        $email = $_POST['email'];

        $sql = "INSERT INTO `doctors`(`first_name`,`last_name`, `username`, `user_id`, `password`, `email`, `doctor_status`) VALUES ('$fname','$lname','$username','$userid','$password','$email','1')";

        if ($this->conn->query($sql) === TRUE) {
            $message = '<span style="color:green">Data saved successfully.</span>';
            return $message;
        } else {
            $message = '<span style="color:red">Authentication Data already exist!</span>';
            return $message;
        }
    }

    public function viewDoctorlist()
    {

        $sql = "SELECT *FROM `doctors`";
        $result = $this->conn->query($sql);

        return $result;
    }

    public function deleteDoctor($data)
    {

        $sql = "DELETE FROM `doctors` WHERE id = '$data[serial]'";

        if ($this->conn->query($sql) === TRUE) {

        } else {

        }
    }

    public function doctorChangeStatus($data)
    {
        $sql = "UPDATE `doctors` SET `doctor_status`='$data[status]' WHERE user_id = '$data[doctor_id]' ";
        if ($this->conn->query($sql) === TRUE) {
            echo "<script type='text/javascript'>alert('UPDATED!');document.location='doctors.php';</script>";
        } else {
            return $message = 'ERROR:' . $this->conn->error;
        }
    }

    public function DoctorsByDept()
    {
        $deptID = $_GET['dept_id'];
        $sql = "SELECT *FROM `doctors` WHERE department_id = '$deptID'";
        $result = $this->conn->query($sql);

        return $result;
    }

    public function TotalDoctorsBy_Dept()
    {
        $deptID = $_GET['dept_id'];
        $query = "SELECT COUNT(id) FROM `doctors` WHERE department_id = '$deptID' ";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

    public function TotalDoctors()
    {
        $query = "SELECT COUNT(id) FROM `doctors`";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

    public function viewDoctorData($data)
    {

        $sql = "SELECT *FROM `doctors` WHERE user_id = '$data[doctor_id]'";
        $result = $this->conn->query($sql);

        return $result;
    }

    public function updateDoctor($data)
    {

        $directory = '../gallery/propic/doctors/';

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
            . "`profile_status`='1',"
            . "`doctor_status`='1'"
            . " WHERE user_id = '$data[doctor_id]'";

        if ($this->conn->query($sql) === TRUE) {
            echo "<script type='text/javascript'>alert('DATA UPDATED SUCCESSFULLY');document.location='doctors.php';</script>";
        } else {
            return $message = 'ERROR:' . $this->conn->error;
        }
    }

    public function update_visiting_price($data)
    {

        $sql = "UPDATE `doctors` SET `cost_bdt`='$data[cost_bdt]',`cost_usd`='$data[cost_usd]' WHERE user_id = '$data[doctor_id]'";
        if ($this->conn->query($sql) === TRUE) {
            echo "<script type='text/javascript'>alert('UPDATED!');document.location='';</script>";
        } else {
            return $message = 'ERROR:' . $this->conn->error;
        }

    }

    public function average_ratingPoint($doctor_id)
    {

        $sql = "SELECT AVG(rating_point) as average FROM rating WHERE doctor_id = '$doctor_id'";
        $result = $this->conn->query($sql);
        while ($row = $result->fetch_assoc()){
            return $row['average'];
        }
    }
    //clients

    public function ViewAllClients()
    {

        $sql = "SELECT `first_name`, `last_name`,`gender`,`country`,`propic`,`client_id`,`status` FROM `clients`";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function ClientDataByID($data)
    {

        $sql = "SELECT `first_name`, `last_name`,`gender`,`country`,`propic`,`client_id`,`status` FROM `clients` WHERE client_id = '$data[client_id]'";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function getClientData()
    {

        $clientID = $_GET['client_id'];
        $sql = "SELECT *FROM `clients` WHERE client_id = '$clientID'";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function UpdateClientData($data)
    {

        $directory = '../gallery/propic/clients/';

        if ($_FILES['propic']['name'] == "") {
            $propic = $_SESSION['oldpic'];
        } else {
            $propic = $directory . basename($_FILES['propic']['name']);
            move_uploaded_file($_FILES['propic']['tmp_name'], $propic);
        }

        $sql = "UPDATE `clients` SET `first_name`='$data[first_name]',`last_name`='$data[last_name]',`birthday`='$data[birthday]',`gender`='$data[gender]',`address`='$data[address]',`country`='$data[country]',`city`='$data[city]',`state`='$data[state]',`postal_code`='$data[postal_code]',`propic`='$propic',`phone`='$data[phone]',`email`='$data[email]',`username`='$data[username]',`password`='$data[password]' WHERE client_id = '$data[client_id]'";
        if ($this->conn->query($sql) === TRUE) {
            echo "<script type='text/javascript'>alert('DATA UPDATED SUCCESSFULLY');document.location='client-profile.php?client_id=" . $data[client_id] . "';</script>";
        } else {
            return $message = 'ERROR:' . $this->conn->error;
        }
    }

    public function TotalClients()
    {
        $query = "SELECT COUNT(id) FROM `clients`";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

    public function ChangeClientStatus($data)
    {
        $sql = "UPDATE `clients` SET `status`='$data[status]' WHERE client_id = '$data[client_id]' ";
        if ($this->conn->query($sql) === TRUE) {
            echo "<script type='text/javascript'>alert('UPDATED!');document.location='clients.php';</script>";
        } else {
            $message = 'Error:' . $this->conn->error;
            return $message;
        }
    }

    public function DeleteClient($data)
    {
        $sql = "DELETE FROM `clients` WHERE client_id = '$data[client_id]' ";
        if ($this->conn->query($sql) === TRUE) {
            echo "<script type='text/javascript'>alert('Deleted!');document.location='clients.php';</script>";
        } else {
            $message = 'Error:' . $this->conn->error;
            return $message;
        }
    }

    public function getClient_NameByID($client_id)
    {
        $sql = "SELECT first_name,last_name FROM `clients` WHERE client_id = '$client_id'";
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
        $sql = "SELECT propic FROM `clients` WHERE client_id = '$client_id'";
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

    //department

    public function addDept($data)
    {

        if ($_FILES['picture']['name'] == "") {
            $picture = '';
        } else {
            $directory = '../gallery/departments/';
            $picture = $directory . basename($_FILES['picture']['name']);
            move_uploaded_file($_FILES['picture']['tmp_name'], $picture);
        }

        $sql = "INSERT INTO `department`(`dept_id`, `dept_name`, `picture`, `created_on`, `description`, `status`) VALUES ('$data[dept_id]','$data[dept_name]','$picture','$data[created_on]','$data[description]','$data[status]')";

        if ($this->conn->query($sql) === TRUE) {
            $message = "Department Data Saved Successfully.";
            return $message;
        } else {
            $message = 'Error:' . $this->conn->error;
            return $message;
        }
    }

    public function viewDeptData()
    {

        $sql = "SELECT *FROM `department`";
        $result = $this->conn->query($sql);

        return $result;
    }

    public function ActiveDeptData()
    {

        $sql = "SELECT *FROM `department` WHERE status = 1";
        $result = $this->conn->query($sql);

        return $result;
    }

    public function getDeptDataByID()
    {
        $dept_id = $_GET['dept_id'];
        $sql = "SELECT *FROM `department` WHERE dept_id = '$dept_id'";
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

    public function DeptDataByID($data)
    {
        $sql = "SELECT *FROM `department` WHERE dept_id = '$data[dept_id]'";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function updateDeptData($data)
    {

        if ($_FILES['picture']['name'] == "") {
            $picture = $_SESSION['picture'];
        } else {
            $directory = '../gallery/departments/';
            $picture = $directory . basename($_FILES['picture']['name']);
            move_uploaded_file($_FILES['picture']['tmp_name'], $picture);
        }


        $sql = "UPDATE `department` SET "
            . "`dept_id`='$data[dept_id]',"
            . "`dept_name`='$data[dept_name]',"
            . "`picture`='$picture',"
            . "`created_on`='$data[created_on]',"
            . "`description`='$data[description]',"
            . "`status`='$data[status]' "
            . "WHERE id = '$data[id]'";


        if ($this->conn->query($sql) === TRUE) {
            echo "<script type='text/javascript'>alert('UPDATED!');document.location='update-department.php?dept_id=" . $data[dept_id] . "';</script>";
        } else {
            $message = 'Error:' . $this->conn->error;
            return $message;
        }
    }

    public function ChangeDeptStatus($data)
    {
        $sql = "UPDATE `department` SET `status`='$data[status]' WHERE dept_id = '$data[dept_id]' ";
        if ($this->conn->query($sql) === TRUE) {
            echo "<script type='text/javascript'>alert('UPDATED!');document.location='departments.php';</script>";
        } else {
            $message = 'Error:' . $this->conn->error;
            return $message;
        }
    }

    public function deleteDept($data)
    {
        $sql = "DELETE FROM `department` WHERE id = '$data[serial]'";
        if ($this->conn->query($sql) === TRUE) {
            echo "<script type='text/javascript'>alert('DELETED!');document.location='departments.php';</script>";
        } else {
            $message = 'Error:' . $this->conn->error;
            return $message;
        }
    }

    public function getDpetNameByID($id)
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

    public function TotalDept()
    {
        $query = "SELECT COUNT(id) FROM `department`";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

//    Schedule
    public function addSchedule($data)
    {
        $sql = "SELECT doctor_id FROM `schedule` WHERE doctor_id = '$data[doctor_id]'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $message = '1';
            return $message;
        } else {

            $sql = "INSERT INTO `schedule`(`doctor_id`,`day_1`, `day1_time`, `day1_status`, `day_2`, `day2_time`, `day2_status`, `day_3`, `day3_time`, `day3_status`, `day_4`, `day4_time`, `day4_status`, `day_5`, `day5_time`, `day5_status`, `day_6`, `day6_time`, `day6_status`, `day_7`, `day7_time`, `day7_status`) VALUES "
                . "('$data[doctor_id]','$data[day_1]','$data[day1_time]','$data[day1_status]','$data[day_2]','$data[day2_time]','$data[day2_status]','$data[day_3]','$data[day3_time]','$data[day3_status]','$data[day_4]','$data[day4_time]','$data[day4_status]','$data[day_5]','$data[day5_time]','$data[day5_status]','$data[day_6]','$data[day6_time]','$data[day6_status]','$data[day_7]','$data[day7_time]','$data[day7_status]')";

            if ($this->conn->query($sql)) {
                $message = '<span style="color:green">SCHEDULE CREATED SUCCESSFULLY.</span>';
                return $message;
            } else {
                $message = '<span style="color:red">ERROR:' . $this->conn->error . '</span>';
                return $message;
            }
        }
    }

    public function ScheduleData($data)
    {
        $sql = "SELECT *FROM `schedule` WHERE doctor_id = '$data[doctor_id]'";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function updateSchedule($data)
    {

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
            . " WHERE `doctor_id` = '$data[doctor_id]'";

        if ($this->conn->query($sql) == TRUE) {
            echo '<script>alert("UPDATED");document.location="add-schedule.php";</script>';
        } else {
            echo 'ERROR:' . $this->conn->error;
        }
    }

    public function DeleteSchedule($data)
    {
        $sql = "DELETE FROM `schedule` WHERE doctor_id = '$data[doctor_id]'";
        if ($this->conn->query($sql) == TRUE) {
            echo '<script>alert("DELETED");document.location="add-schedule.php";</script>';
        } else {
            echo 'ERROR:' . $this->conn->error;
        }
    }

//    Appointments

    public function PendingAppointments()
    {

        $sql = "SELECT *FROM `appointment` WHERE request_status = 1 ORDER BY id DESC";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function ApprovedAppointments()
    {

        $sql = "SELECT *FROM `appointment` WHERE status = 1 OR is_visited = 1 ORDER BY id DESC";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function TotalRequest()
    {
        $query = "SELECT COUNT(id) FROM `appointment` WHERE request_status = 1";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

    public function TotalApproved()
    {
        $query = "SELECT COUNT(id) FROM `appointment` WHERE status = 1";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

    public function AcceptAppointment($data)
    {
        $appointment_date = $data['appointment_date'];
        $client_id = $data['client_id'];
        $doctor_id = $data['doctor_id'];

        date_default_timezone_set('Asia/Dhaka');
        $notification_id = "notification@" . date("Y-m-d") . '?' . date("H:i:s");

        $date = strtotime(str_replace("/", "-", $appointment_date));
        $today = strtotime(date('d-m-Y'));


        $time = date("l ,F j, Y, g:i a");

        $month = date('F');
        $year = date('Y');

        if ($date < $today) {
            echo "<script type='text/javascript'>alert('SORRY! THE SELECTED DATE IS INVALID!');document.location='';</script>";
        } else {

            $sql = "UPDATE `appointment` SET `appointment_date`='$data[appointment_date]',`month`='$month',`year`='$year',`request_status`='0',`status`='1' WHERE appointment_id = '$data[id]' ";
            if ($this->conn->query($sql) === TRUE) {
                $sql = "INSERT INTO `notifications`(`notification_id`, `notification_to`, `notification_from`, `notification_type`, `notification_about`, `notification_time`) VALUES "
                    . "('$notification_id','$client_id','admin','appointment','accepted your appointment request.','$time')";
                if ($this->conn->query($sql) === TRUE) {
                    $sql = "INSERT INTO `notifications`(`notification_id`, `notification_to`, `notification_from`, `notification_type`, `notification_about`, `notification_time`) VALUES "
                        . "('$notification_id','$doctor_id','admin','appointment','You have got a new appoinment.','$time')";
                    if ($this->conn->query($sql) === TRUE) {
                        echo "<script type='text/javascript'>alert('UPDATED!');document.location='';</script>";
                    } else {
                        echo $this->conn->error;
                    }
                } else {
                    echo $this->conn->error;
                }
            } else {
                $message = 'Error:' . $this->conn->error;
                return $message;
            }
        }
    }

    public function UpdateAppointment($data)
    {

        $appointment_date = $data['appointment_date'];
        date_default_timezone_set('Asia/Dhaka');

        $date = strtotime(str_replace("/", "-", $appointment_date));
        $today = strtotime(date('d-m-Y'));

        if ($date < $today) {
            echo "<script type='text/javascript'>alert('SORRY! THE SELECTED DATE IS INVALID!');document.location='';</script>";
        } else {
            if ($data['is_visited'] == 0) {
                $sql = "UPDATE `appointment` SET `appointment_date`='$data[appointment_date]' WHERE appointment_id = '$data[id]' ";
            } elseif ($date < $today && $data['is_visited'] == 1) {
                echo "<script type='text/javascript'>alert('SORRY! THE SELECTED DATE IS INVALID!');document.location='';</script>";
            } else {
                $sql = "UPDATE `appointment` SET `appointment_date`='$data[appointment_date]',`is_visited`='1',`status`='0' WHERE appointment_id = '$data[id]' ";
            }

            if ($this->conn->query($sql) === TRUE) {
                echo "<script type='text/javascript'>alert('UPDATED!');document.location='';</script>";
            } else {
                $message = 'Error:' . $this->conn->error;
                return $message;
            }
        }
    }

    public function CancelAppointment($data)
    {

        $client_id = $data['client_id'];

        date_default_timezone_set('Asia/Dhaka');
        $notification_id = "notification@" . date("Y-m-d") . '?' . date("H:i:s");
        $time = date("l ,F j, Y, g:i a");

        $sql = "UPDATE `appointment` SET `cancelled_cause`='$data[cancelled_cause]',`request_status`='0',`is_cancelled`='1',`status`='0' WHERE appointment_id = '$data[id]' ";
        if ($this->conn->query($sql) === TRUE) {
            $sql = "INSERT INTO `notifications`(`notification_id`, `notification_to`, `notification_from`, `notification_type`, `notification_about`, `notification_time`) VALUES "
                . "('$notification_id','$client_id','admin','appointment','cancelled your appointment request.','$time')";
            if ($this->conn->query($sql) === TRUE) {
                echo "<script type='text/javascript'>alert('CANCELLED!');document.location='';</script>";
            } else {
                echo $this->conn->error;
            }
        } else {
            $message = 'Error:' . $this->conn->error;
            return $message;
        }
    }

//    Events

    public function addEvent($data)
    {

        $directory = '../gallery/events/banner/';
        $banner = $directory . basename($_FILES['event_banner']['name']);


        $directory = '../gallery/events/files/';
        $file = $directory . basename($_FILES['event_file']['name']);

        $date = date_default_timezone_set('Asia/Dhaka');
        $date = date('d-m-Y');
        $time = date("h:i:s");

        $event_id = "event?" . $date . '@' . $time;

        $sql = "INSERT INTO `events`(`event_id`, `event_title`, `event_description`, `event_link`, `event_banner`, `event_file`, `month`, `date`, `year`, `status`) VALUES "
            . "('$event_id','$data[event_title]','$data[event_description]','$data[event_link]','$banner','$file','$data[month]','$data[date]','$data[year]','$data[status]')";

        if ($this->conn->query($sql) === TRUE) {
            move_uploaded_file($_FILES['event_banner']['tmp_name'], $banner);
            move_uploaded_file($_FILES['event_file']['tmp_name'], $file);

            $message = '<span style="color:green">Event created successfully.</span>';
            return $message;
        } else {
            $message = '<span style="color:red">Error:' . $this->conn->error . '</span>';
            return $message;
        }
    }

    public function eventData()
    {
        $sql = "SELECT * FROM `events`";
        $data = $this->conn->query($sql);
        return $data;
    }

    public function eventDataByID($data)
    {
        $sql = "SELECT * FROM `events` WHERE event_id = '$data[event_id]'";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function deleteEvent($data)
    {
        $sql = "DELETE FROM `events` WHERE id = '$data[serial]'";
        if ($this->conn->query($sql) === TRUE) {

        } else {
            $message = 'Error:' . $this->conn->error;
            return $message;
        }
    }

    public function ChangeEventStatus($data)
    {
        $sql = "UPDATE `events` SET `status`='$data[status]' WHERE event_id = '$data[event_id]' ";
        if ($this->conn->query($sql) === TRUE) {
            echo "<script type='text/javascript'>alert('UPDATED!');document.location='events.php';</script>";
        } else {
            $message = 'Error:' . $this->conn->error;
            return $message;
        }
    }

    public function updateEvent($data)
    {

        if ($_FILES['event_banner']['name'] == "") {
            $banner = $_SESSION['oldpic'];
        } else {
            $directory = '../gallery/events/banner/';
            $banner = $directory . basename($_FILES['event_banner']['name']);
            move_uploaded_file($_FILES['event_banner']['tmp_name'], $banner);
        }

        if ($_FILES['event_file']['name'] == "") {
            $file = $_SESSION['oldfile'];
        } else {
            $directory = '../gallery/events/files/';
            $file = $directory . basename($_FILES['event_file']['name']);
            move_uploaded_file($_FILES['event_file']['tmp_name'], $file);
        }

        $sql = "UPDATE `events` SET "
            . "`event_title`='$data[event_title]',"
            . "`event_description`='$data[event_description]',"
            . "`event_link`='$data[event_link]',"
            . "`event_banner`='$banner' ,"
            . "`event_file`='$file',"
            . "`month`='$data[month]',"
            . "`date`='$data[date]',"
            . "`year`='$data[year]',"
            . "`status`='$data[status]'"
            . " WHERE event_id = '$data[event_id]' ";
        if ($this->conn->query($sql) === TRUE) {
            echo "<script type='text/javascript'>alert('UPDATED!');document.location='events.php';</script>";
        } else {
            return $message = 'Error:' . $this->conn->error;
        }
    }

    //Mail Sending
    public function doctor_AuthMail($data)
    {
        $sql = "SELECT email FROM `doctors` WHERE email = '$data[email]' OR username = '$data[username]'";
        $result = $this->conn->query($sql);
        if($result->num_rows > 0){
            header('location:add-doctor.php?message=Authentication Data already exist!&type=error');
        }else{
            require("../../mailer/PHPMailer/src/PHPMailer.php");
            require("../../mailer/PHPMailer/src/SMTP.php");

            $mail = new PHPMailer\PHPMailer\PHPMailer();
            $mail->IsSMTP(); // enable SMTP

            $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
            $mail->SMTPAuth = true; // authentication enabled
            $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 465; // or 587
            $mail->IsHTML(true);
            $mail->Username = "project.cms.39@gmail.com";
            $mail->Password = "project@cms39";
            $mail->SetFrom("xxxxxx@xxxxx.com");
            $mail->Subject = "Authentication Data";
            $mail->Body = " Hello $data[first_name] $data[last_name], <br><br>This is your username: $data[username] and password: $data[password].Please visit this link : <a href='http://localhost/cms/login/doctor/'>http://localhost/cms/login/doctor/</a> to login.<br><br>Thank you.";
            $mail->AddAddress("$data[email]");

            if (!$mail->Send()) {
                return "Mailer Error: " . $mail->ErrorInfo;
            } else {


                $fname = $_POST['first_name'];
                $lname = $_POST['last_name'];

                $username = $_POST['username'];
                $userid = $_POST['user_id'];
                $password = $_POST['password'];
                $email = $_POST['email'];

                $sql = "INSERT INTO `doctors`(`first_name`,`last_name`, `username`, `user_id`, `password`, `email`, `doctor_status`,`mail_status`) VALUES ('$fname','$lname','$username','$userid','$password','$email','1','1')";

                if ($this->conn->query($sql) === TRUE) {
                    header('location:add-doctor.php?message=DATA ADDED SUCCESSFULLY!');
                } else {

                }
            }
        }

    }

//    notifications

    public function get_notifications()
    {

        $sql = "SELECT * FROM `notifications` WHERE notification_to = 'admin'";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function notification_seen()
    {
        $sql = "UPDATE `notifications` SET `is_seen`='1' WHERE notification_to = 'admin' AND notification_type = 'appointment'";
        if ($this->conn->query($sql) === TRUE) {

        } else {

        }
    }

//    totals

    public function total_notification()
    {
        $query = "SELECT COUNT(id) FROM `notifications` WHERE notification_to = 'admin' AND is_seen = 0";
        $result = mysqli_query($this->conn, $query);
        $rows = mysqli_fetch_row($result);
        $count = $rows[0];
        return $count;
    }

    //drug test requests

    public function new_drug_requestS()
    {
        $sql = "SELECT id FROM `lab-requests` WHERE request_for ='drug'  AND is_pending = 1";
        $result = $this->conn->query($sql);
        return $result->num_rows;
    }

    public function total_drug_requestS()
    {
        $sql = "SELECT id FROM `lab-requests` WHERE request_for ='drug'";
        $result = $this->conn->query($sql);
        return $result->num_rows;
    }

    public function new_test_requestS()
    {
        $sql = "SELECT id FROM `lab-requests` WHERE request_for ='test' AND is_pending = 1 ";
        $result = $this->conn->query($sql);
        return $result->num_rows;
    }

    public function total_test_requestS()
    {
        $sql = "SELECT id FROM `lab-requests` WHERE request_for ='test'";
        $result = $this->conn->query($sql);
        return $result->num_rows;
    }

    public function view_drug_requests()
    {
        $sql = "SELECT *FROM `lab-requests` WHERE request_for ='drug' ORDER BY id DESC ";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function view_test_requests()
    {
        $sql = "SELECT *FROM `lab-requests` WHERE request_for ='test' ORDER BY id DESC  ";
        $result = $this->conn->query($sql);
        return $result;
    }

    public function cancel_request($data)
    {
        $sql = "UPDATE `lab-requests` SET is_pending = 0 ,is_feedbacked = 0 ,is_agreed = 0, is_cancelled = 1 WHERE id = '$data[serial_no]'";
        if ($this->conn->query($sql) === TRUE) {
            echo '<script>alert("Request has been cancelled.");document.location="";</script>';

        } else {
            return $this->conn->error;
        }
    }


    public function send_feedback($data)
    {

        $name = $data['item_name'];
        $price = $data['unit_price'];
        $request_id = $data['request_id'];
        $delivery_cost = $data['delivery_cost'];

        for ($i = 0; $i < count($name); $i++) {


            $names = $name[$i];
            $prices = $price[$i];

            $sql = "INSERT INTO `feedback`(`request_id`, `item_name`, `unit_price`, `delivery_cost`) VALUES 
                   ('$request_id','$names','$prices','$delivery_cost')";
            if ($this->conn->query($sql) === TRUE) {

                $sql = "UPDATE `lab-requests` SET is_pending = 0 , is_feedbacked = 1 WHERE request_id = '$data[request_id]'";
                if ($this->conn->query($sql) === TRUE) {

                    echo '<script>alert("Request has been feedbacked.");document.location="";</script>';

                } else {
                    return $this->conn->error;
                }
            } else {
                return $this->conn->error;
            }

        }
    }

    public function feedbacked_data($request_id)
    {

        $sql = "SELECT * FROM `feedback` WHERE request_id = '$request_id'";
        $result = $this->conn->query($sql);
        return $result;

    }

    public function update_feedback_data($data)
    {

        $sql = "UPDATE `feedback` SET `item_name`='$data[item_name]',`unit_price`='$data[unit_price]' WHERE id ='$data[id]'";

        if ($this->conn->query($sql) === TRUE) {

            echo '<script>alert("Data updated.");document.location="";</script>';

        } else {
            return $this->conn->error;
        }

    }

    public function update_delivery_cost($data)
    {

        $sql = "UPDATE `feedback` SET `delivery_cost`='$data[delivery_cost]'WHERE request_id = '$data[request_id]'";

        if ($this->conn->query($sql) === TRUE) {
            echo '<script>alert("Data updated.");document.location="";</script>';
        } else {
            return $this->conn->error;
        }
    }

    public function delete_feedback_data($data)
    {

        $sql = "DELETE FROM `feedback` WHERE id ='$data[id]'";

        if ($this->conn->query($sql) === TRUE) {

            echo '<script>alert("Removed!");document.location="";</script>';

        } else {
            return $this->conn->error;
        }

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

    public function mark_as_delivered($data)
    {
        date_default_timezone_set("Asia/Dhaka");
        $date = date("d-m-Y");

        $sql = "UPDATE `lab-requests` SET 
                `delivered_on`='$date',
                `is_pending`=0,
                `is_processing`=0,
                `is_feedbacked`=0,
                `is_delivered`=0,
                `is_agreed`=0,
                `is_delivered`=1
                WHERE  id = '$data[serial_no]'";

        if ($this->conn->query($sql) === TRUE) {
            echo '<script>alert("Confirmed!.");document.location="";</script>';
        } else {
            return $this->conn->error;
        }
    }


//    transactions

    public function from_physical($month, $year)
    {
        $sql = "SELECT SUM(cost_bdt) as total FROM `appointment` WHERE type='Physical' AND month = '$month' AND year = '$year' AND is_visited = 1";
        $result = $this->conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            return $row['total'];
        }
    }

    public function from_online($month, $year)
    {
        $sql = "SELECT SUM(cost_usd) as total FROM `appointment` WHERE type='Online' AND month = '$month' AND year = '$year' AND is_visited = 1";
        $result = $this->conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            return $row['total'];
        }
    }

    public function from_drugs($month, $year)
    {
        $sql = "SELECT SUM(total_cost) as total FROM `lab-requests` WHERE request_for='drug' AND month = '$month' AND year = '$year' AND ( is_delivered = 1 OR is_received = 1)";
        $result = $this->conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            return $row['total'];
        }
    }

    public function from_tests($month, $year)
    {
        $sql = "SELECT SUM(total_cost) as total FROM `lab-requests` WHERE request_for='test' AND month = '$month' AND year = '$year' AND ( is_delivered = 1 OR is_received = 1)";
        $result = $this->conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            return $row['total'];
        }
    }


}
