<?php
require 'db_connect.php';

$new_password = 'admin123'; // <== your new password here
$hashed = password_hash($new_password, PASSWORD_DEFAULT);

$sql = "UPDATE admins SET password = '$hashed' WHERE username = 'admin'";
if ($conn->query($sql)) {
    echo "Password updated successfully.";
} else {
    echo "Error: " . $conn->error;
}
$conn->close();
?>
