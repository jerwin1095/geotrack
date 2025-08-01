<?php
$host = 'localhost';
$user = 'root';
$password = 'your_password_here';
$dbname = 'geo_trackdtr';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
