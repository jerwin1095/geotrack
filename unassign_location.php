<?php
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']);
    $stmt = $conn->prepare("UPDATE users SET location = NULL WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        header("Location: user.php"); // or wherever you came from
    } else {
        echo "Error removing location.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
