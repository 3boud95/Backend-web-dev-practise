<?php

session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once "../config/db.php";

if (!isset($_GET["id"])) {
    die("Nostudent ID provided.");
}

$id = $_GET["id"];

// prepare and execute delete statement
$stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: index.php");
exit;
?>