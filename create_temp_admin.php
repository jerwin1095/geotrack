<?php
require_once 'db_connect.php';

// CHANGE THESE VALUES for your temporary admin
$username = 'tempadmin';
$password_plain = 'temp1234';

// Hash the password for security
$hashed_password = password_hash($password_plain, PASSWORD_DEFAULT);

// Insert the new admin user
$sql = "INSERT INTO admins (username, password) VALUES ($1, $2)";
$result = pg_query_params($conn, $sql, [$username, $hashed_password]);

if ($result) {
    echo "Temporary admin created!<br>";
    echo "Username: $username<br>";
    echo "Password: $password_plain<br>";
    echo "Delete this file after use for security.";
} else {
    echo "Error: " . pg_last_error($conn);
}
?>
