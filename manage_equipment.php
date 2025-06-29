<?php
session_start();
if (!isset($_SESSION['User_ID']) || $_SESSION['Role'] != 'Lab TO') {
    header("Location: index.html");
    exit();
}
include 'db_connect.php';

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $equipment_id = $_POST['equipment_id'];
    $status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE lab_equipment SET Status = ? WHERE Equipment_ID = ?");
    $stmt->bind_param("ss", $status, $equipment_id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_equipment.php");
    exit();
}

// Fetch all equipment
$result = $conn->query("SELECT e.Equipment_ID, e.Equipment_Name, e.Lab_ID, e.Quantity, e.Status, l.Lab_Type 
                        FROM lab_equipment e 
                        JOIN lab l ON e.Lab_ID = l.Lab_ID");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Equipment</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Manage Lab Equipment</h2>
        <table border="1">
            <tr>
                <th>Equipment ID</th>
                <th>Equipment Name</th>
                <th>Lab</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['Equipment_ID']) ?></td>
                    <td><?= htmlspecialchars($row['Equipment_Name']) ?></td>
                    <td><?= htmlspecialchars($row['Lab_Type'] . ' (' . $row['Lab_ID'] . ')') ?></td>
                    <td><?= htmlspecialchars($row['Quantity']) ?></td>
                    <td><?= htmlspecialchars($row['Status']) ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="equipment_id" value="<?= $row['Equipment_ID'] ?>">
                            <select name="status" required>
                                <option value="Limited" <?= $row['Status'] == 'Limited' ? 'selected' : '' ?>>Limited</option>
                                <option value="Functional" <?= $row['Status'] == 'Functional' ? 'selected' : '' ?>>Functional</option>
                                <option value="Out of Order" <?= $row['Status'] == 'Out of Order' ? 'selected' : '' ?>>Out of Order</option>
                            </select>
                            <button type="submit">Update</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <br><a href="labto_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
<?php $conn->close(); ?>