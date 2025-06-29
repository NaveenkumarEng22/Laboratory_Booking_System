<?php
session_start();
if (!isset($_SESSION['User_ID']) || $_SESSION['Role'] != 'Student') {
    header("Location: index.html");
    exit();
}
include 'db_connect.php';
$user_id = $_SESSION['User_ID'];
$stmt = $conn->prepare("SELECT * FROM lab_booking_request WHERE User_ID = ?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Booking History</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Your Booking History</h2>
        <table border="1">
            <tr>
                <th>Request ID</th>
                <th>Lab ID</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['Request_ID'] ?></td>
                    <td><?= $row['Lab_ID'] ?></td>
                    <td><?= $row['Requested_Date'] ?></td>
                    <td><?= $row['Status'] ?></td>
                </tr>
            <?php } ?>
        </table>
        <br><a href="student_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>