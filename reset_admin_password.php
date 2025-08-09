<?php
require_once 'db_connect.php';

$newPassword = 'admin1234';
$hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

$sql = "UPDATE admins SET password = $1 WHERE username = $2";
$result = pg_query_params($conn, $sql, [$hashedPassword, 'admin']);

if ($result && pg_affected_rows($result) === 1) {
    echo "✅ Password for 'admin' has been reset to 'admin1234'.";
} else {
    echo "❌ Failed to reset password.";
}
?>
