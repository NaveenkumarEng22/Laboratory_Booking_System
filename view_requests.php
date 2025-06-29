<?php
session_start();
if (!isset($_SESSION['User_ID']) || ($_SESSION['Role'] != 'Instructor' && $_SESSION['Role'] != 'Lecture in Charge')) {
    header("Location: index.html");
    exit();
}
include 'db_connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_id = $_POST['request_id'];
    $action = $_POST['action'];
    $status = ($action == 'approve') ? 'Approved' : 'Rejected';
    $stmt = $conn->prepare("UPDATE lab_booking_request SET Status = ? WHERE Request_ID = ?");
    $stmt->bind_param("ss", $status, $request_id);
    $stmt->execute();
    header("Location: view_requests.php");
    exit();
}
$result = $conn->query("SELECT * FROM lab_booking_request WHERE Status = 'Pending'");
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Booking Requests</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Pending Booking Requests</h2>
        <table border="1">
            <tr>
                <th>Request ID</th>
                <th>User ID</th>
                <th>Lab ID</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['Request_ID'] ?></td>
                    <td><?= $row['User_ID'] ?></td>
                    <td><?= $row['Lab_ID'] ?></td>
                    <td><?= $row['Requested_Date'] ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="request_id" value="<?= $row['Request_ID'] ?>">
                            <button type="submit" name="action" value="approve">Approve</button>
                            <button type="submit" name="action" value="reject">Reject</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <br><a href="instructor_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>