<?php

$server = 'localhost';
$username = 'root';
$password = '';
$database = 'cms';

$conn = new mysqli($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed:".$conn->connect_error);
}else{

}
