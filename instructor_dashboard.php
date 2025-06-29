<?php
session_start();
if (!isset($_SESSION['User_ID'])) {
    header("Location: index.html");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Instructor Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome <?php echo $_SESSION['Name']; ?> (<?php echo $_SESSION['Role']; ?>)</h2>
        <a href="logout.php">Logout</a><br><br>
        <a href="view_requests.php">View Booking Requests</a> | <a href="lab_usage_log.php">Log Lab Usage</a>
    </div>
</body>
</html>