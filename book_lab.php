<?php
session_start();
if (!isset($_SESSION['User_ID'])) {
    header("Location: index.html");
    exit();
}
include 'db_connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lab_id = $_POST['lab_id'];
    $request_id = 'R' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
    $user_id = $_SESSION['User_ID'];
    $req_date = $_POST['date'];
    $status = 'Pending';
    $stmt = $conn->prepare("INSERT INTO lab_booking_request (Request_ID, User_ID, Lab_ID, Requested_Date, Status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $request_id, $user_id, $lab_id, $req_date, $status);
    $stmt->execute();
    echo "<script>alert('Request submitted!'); window.location.href='student_dashboard.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book Lab</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Book a Lab</h2>
        <form method="post">
            <label>Choose Lab:</label>
            <select name="lab_id" required>
                <?php
                $labs = $conn->query("SELECT * FROM lab WHERE Availability_Status='Available'");
                while ($row = $labs->fetch_assoc()) {
                    echo "<option value='{$row['Lab_ID']}'>{$row['Lab_Type']} ({$row['Lab_ID']})</option>";
                }
                ?>
            </select><br><br>
            <label>Date:</label>
            <input type="date" name="date" required><br><br>
            <button type="submit">Submit Request</button>
        </form>
    </div>
</body>
</html>