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
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome <?php echo $_SESSION['Name']; ?> (Student)</h2>
        <a href="logout.php">Logout</a><br><br>
        <a href="book_lab.php">Book a Lab</a> | <a href="booking_history.php">Booking History</a>
    </div>
</body>
</html>