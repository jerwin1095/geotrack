<?php
$host = "your_host";
$port = "5432";
$dbname = "your_dbname";
$user = "your_username";
$password = "your_password";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
if (!$conn) {
    die("❌ Connection failed: " . pg_last_error());
}
?>
