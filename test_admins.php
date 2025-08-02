<?php
require_once 'db_connect.php';
$result = pg_query($conn, "SELECT * FROM admins");
if (!$result) {
    echo "Error: " . pg_last_error($conn);
    exit;
}
while ($row = pg_fetch_assoc($result)) {
    echo "Username: " . htmlspecialchars($row['username']) . "<br>";
    echo "Password hash: " . htmlspecialchars($row['password']) . "<br><br>";
}
?>
