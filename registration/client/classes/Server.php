<?php

class Server {

    private $conn;

    public function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'cms');
        mysqli_query($this->conn, 'SET CHARACTER SET utf8');
        mysqli_query($this->conn, "SET SESSION collation_connection ='utf8_general_ci'");
    }

    public function registration($data) {

        $directory = '../../dashboard/gallery/propic/clients/';
        $propic = $directory . basename($_FILES['propic']['name']);


        $clientid = "client@" . date("Y-m-d") . '?' . date("H:i:s");

        $sql = "INSERT INTO `clients`(`first_name`, `last_name`, `birthday`, `gender`, `address`, `country`, `city`, `state`, `postal_code`,`propic`, `phone`, `email`, `username`, `client_id`, `password`) VALUES "
                . "('$data[first_name]','$data[last_name]','$data[birthday]','$data[gender]','$data[address]','$data[country]','$data[city]','$data[state]','$data[postal_code]','$propic','$data[phone]','$data[email]','$data[username]','$clientid','$data[password]')";

        if ($this->conn->query($sql) === TRUE) {
            move_uploaded_file($_FILES['propic']['tmp_name'], $propic);
            $success = '<span style="color:green">REGISTATION COMPLETED SUCCESSFULLY.</span>DO YOU WNAT TO <a href="../../login/client/">LOGIN?</a> ';
            return $success;
        } else {
            return $message = '<span style="color:red">ERROR:' . $this->conn->error . '</span>';
        }
    }
}