<?php
session_start();
if (!isset($_SESSION['User_ID'])) {
    header("Location: index.html");
    exit();
}
include 'db_connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['Role'] == 'Lecture in Charge') {
    $lab_id = $_POST['lab_id'];
    $usage_date = $_POST['usage_date'];
    $activity = $_POST['activity'];
    $log_id = 'LOG' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
    $stmt = $conn->prepare("INSERT INTO lab_usage_log (Log_ID, Lab_ID, Usage_Date, Activity) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $log_id, $lab_id, $usage_date, $activity);
    $stmt->execute();
    header("Location: lab_usage_log.php");
    exit();
}
$result = $conn->query("SELECT * FROM lab_usage_log");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Usage Log</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Lab Usage Log</h2>
        <?php if ($_SESSION['Role'] == 'Lecture in Charge') { ?>
            <form method="POST">
                <label>Lab ID:</label>
                <input type="text" name="lab_id" required><br>
                <label>Access Date:</label>
                <input type="date" name="Access_date" required><br>
                <label>Equipment Used:</label>
                <input type="text" name="Equipment_Used" required><br>
				<label>Remarks:</label>
                <input type="text" name="Remarks" required><br>
                <button type="submit">Add Log</button>
            </form>
        <?php } ?>
        <h3>Existing Logs</h3>
        <table border="1">
            <tr>
                <th>Log ID</th>
                <th>Lab ID</th>
                <th>Date</th>
                <th>Equpiment Used</th>
				<th>Remarks</th>
                <?php if ($_SESSION['Role'] == 'Lecture in Charge') { ?>
                    <th>Actions</th>
                <?php } ?>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['Log_ID'] ?></td>
                    <td><?= $row['Lab_ID'] ?></td>
                    <td><?= $row['Access_Date'] ?></td>
                    <td><?= $row['Equipment_Used'] ?></td>
					<td><?= $row['Remarks'] ?></td>
                    <?php if ($_SESSION['Role'] == 'Lecture in Charge') { ?>
                        <td>
                            <a href="edit_log.php?id=<?= $row['Log_ID'] ?>">Edit</a> |
                            <a href="delete_log.php?id=<?= $row['Log_ID'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </table>
        <br><a href="<?php echo $_SESSION['Role'] == 'Student' ? 'student_dashboard.php' : ($_SESSION['Role'] == 'Lab TO' ? 'labto_dashboard.php' : ($_SESSION['Role'] == 'Lecture in Charge' ? 'lecture_in_charge_dashboard.php' : 'instructor_dashboard.php')); ?>">Back to Dashboard</a>
    </div>
</body>
</html>