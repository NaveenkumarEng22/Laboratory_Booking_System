<?php
session_start();
if (!isset($_SESSION['User_ID']) || $_SESSION['Role'] != 'Lecture in Charge') {
    header("Location: index.html");
    exit();
}
include 'db_connect.php';
if (isset($_GET['id'])) {
    $log_id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM lab_usage_log WHERE Log_ID = ?");
    $stmt->bind_param("s", $log_id);
    $stmt->execute();
}
header("Location: lab_usage_log.php");
exit();
?>