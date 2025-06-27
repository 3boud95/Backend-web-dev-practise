<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "student_panel";

//create connection with MySQL

$conn = new mysqli($host, $user, $password, $db);

// Check connection
if($conn->connect_error) {
    die("connection failed: " . $conn->connect_error);
}
?>