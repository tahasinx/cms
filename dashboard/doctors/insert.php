<?php

session_start();
$conn = new mysqli("localhost", "root", "", "cms");

$message_from = $_SESSION['user_id'];
date_default_timezone_set("Asia/Dhaka");
$date = date("d-m-Y");
$time = date("l ,F j, Y, g:i a");
$id = "message@chat#" . date("d-m-Y") . '?' . date("H:i:s");
$key = "notification@" . date("d-m-Y") . '?' . date("H:i:s");


$message_to = $_POST['message_to'];
$message = $_POST['message'];

if (empty($message)) {
    
} else {
    $sql = "INSERT INTO `chats`(`message_id`, `message_from`, `message_to`, `message_body`, `message_date`, `message_time`) VALUES "
            . "('$id','$message_from','$message_to','$message','$date','$time') ";

    if ($conn->query($sql)) {
        $sql = "UPDATE `chats` SET `is_seen`= 1 WHERE message_from ='$message_to' AND message_to = '$message_from'";

        if ($conn->query($sql) === TRUE) {

            $sql = "INSERT INTO `notifications`(`notification_id`, `notification_to`, `notification_from`, `notification_type`,`notification_about`,`notification_time`) VALUES "
                    . "('$key','$message_to','$message_from','message','sent you a new message.','$time')";

            if ($conn->query($sql) === TRUE) {
                
            } else {
                
            }
        } else {
            
        }
    } else {
        
    }
}

 

