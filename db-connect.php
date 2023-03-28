<?php

$server = 'localhost';
$database = 'login';
$user = 'root';
$password = 'root';

$con = new mysqli($server, $user, $password, $database);

if($con->connect_error){
    die("Connection failed: " . $con->connect_error);
}