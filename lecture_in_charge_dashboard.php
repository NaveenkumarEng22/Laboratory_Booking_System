<?php
session_start();
if (!isset($_SESSION['User_ID']) || $_SESSION['Role'] != 'Lecture in Charge') {
    header("Location: index.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecture in Charge Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome <?php echo $_SESSION['Name']; ?> (Lecture in Charge)</h2>
        <a href="logout.php">Logout</a><br><br>
        <a href="view_requests.php">View Booking Requests</a> | <a href="lab_usage_log.php">Log Lab Usage</a>
    </div>
</body>
</html>