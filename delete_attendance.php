<?php
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['attendance_id'])) {
  $attendanceId = intval($_POST['attendance_id']);

  $stmt = $conn->prepare("DELETE FROM attendance WHERE id = ?");
  $stmt->bind_param("i", $attendanceId);

  if ($stmt->execute()) {
    header("Location: admin_dashboard.php"); // or wherever your page is
    exit();
  } else {
    echo "Failed to delete attendance.";
  }

  $stmt->close();
  $conn->close();
} else {
  echo "Invalid request.";
}
