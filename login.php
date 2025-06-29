<?php
session_start();
include 'db_connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $stmt = $conn->prepare("SELECT User_ID, Name, Role, Password FROM user_accounts WHERE Email = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['Password']) || $password === $user['Password']) {
            $_SESSION['User_ID'] = $user['User_ID'];
            $_SESSION['Name'] = $user['Name'];
            $_SESSION['Role'] = $user['Role'];
            switch ($_SESSION['Role']) {
                case 'Student':
                    header("Location: student_dashboard.php");
                    break;
                case 'Instructor':
                    header("Location: instructor_dashboard.php");
                    break;
                case 'Lecture in Charge':
                    header("Location: lecture_in_charge_dashboard.php");
                    break;
                case 'Lab TO':
                    header("Location: labto_dashboard.php");
                    break;
                default:
                    header("Location: dashboard.php");
            }
            exit();
        } else {
            echo "<script>alert('Invalid credentials'); window.location.href='index.html';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Invalid credentials'); window.location.href='index.html';</script>";
        exit();
    }
} else {
    header("Location: index.html");
    exit();
}
?>