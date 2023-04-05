<?php
$servername="localhost";
$user="root";
$pass="";
$database="gerodimos";

$conn = mysqli_connect($servername,$user,$pass,$database);

if (!$conn) {
    die("Connection failed:" .mysqli_connect_error());
}