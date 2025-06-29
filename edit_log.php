<?php
session_start();
if (!isset($_SESSION['User_ID']) || $_SESSION['Role'] != 'Lecture in Charge') {
    header("Location: index.html");
    exit();
}
include 'db_connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['log_id'];
    $activity = $_POST['activity'];
    $stmt = $conn->prepare("UPDATE lab_usage_log SET Activity = ? WHERE Log_ID = ?");
    $stmt->bind_param("ss", $activity, $id);
    $stmt->execute();
    header("Location: lab_usage_log.php");
    exit();
}
if (!isset($_GET['id'])) {
    echo "No Log ID specified.";
    exit();
}
$log_id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM lab_usage_log WHERE Log_ID = ?");
$stmt->bind_param("s", $log_id);
$stmt->execute();
$log = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head><title>Edit Log</title></head>
<body>
<h2>Edit Lab Log</h2>
<form method="POST">
    <input type="hidden" name="log_id" value="<?= $log['Log_ID'] ?>">
    Lab ID: <?= $log['Lab_ID'] ?><br>
    Date: <?= $log['Usage_Date'] ?><br>
    Activity: <input type="text" name="activity" value="<?= htmlspecialchars($log['Activity']) ?>"><br>
    <button type="submit">Update</button>
</form>
<a href="lab_usage_log.php">Cancel</a>
</body>
</html>