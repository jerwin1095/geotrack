<?php
// Neon/Postgres connection
// Update these variables to match your actual Neon connection details
$host = 'YOUR_NEON_HOST_URL';
$dbname = 'YOUR_DB_NAME';
$user = 'YOUR_DB_USER';
$password = 'YOUR_DB_PASSWORD';
$port = '5432'; // usually 5432 for Postgres

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
if (!$conn) {
    die('Connection failed: ' . pg_last_error());
}
?>
