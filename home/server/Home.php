<?php

class Home
{

    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli('localhost', 'root', '', 'cms');
        mysqli_query($this->conn, 'SET CHARACTER SET utf8');
        mysqli_query($this->conn, "SET SESSION collation_connection ='utf8_general_ci'");
    }


    public function eventData()
    {
        $sql = "SELECT * FROM `events` WHERE status = 1";
        $data = $this->conn->query($sql);
        return $data;
    }
}