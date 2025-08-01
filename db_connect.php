<?php
$conn = new mysqli("localhost", "root", "", "geo_trackdtr");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
