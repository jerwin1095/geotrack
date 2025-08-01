<?php
require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $emp_id = trim($_POST['emp_id']);
    $name = trim($_POST['name']);

    if (!empty($emp_id) && !empty($name)) {
        $stmt = $conn->prepare("INSERT INTO users (emp_id, name) VALUES (?, ?)");
        $stmt->bind_param("ss", $emp_id, $name);
        $stmt->execute();

        header("Location: user.php");
        exit;
    } else {
        echo "User ID and Name are required.";
    }
}
?>
