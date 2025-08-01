<?php
session_start();
include 'db_connect.php';

$username = $_POST['username'];
$password = $_POST['password'];
$hashed = hash('sha256', $password); // same as inserted

$sql = "SELECT * FROM admin_accounts WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $hashed);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $_SESSION['admin'] = $username;
    header("Location: dashboard.php"); // change to your main admin page
    exit();
} else {
    echo "<script>alert('Invalid login. Please try again.'); window.location.href='login.php';</script>";
}
?>
