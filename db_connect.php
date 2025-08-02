<?php
// Neon/Postgres connection (fill in your database credentials)
$host = 'ep-dawn-forest-12345.ap-southeast-1.aws.neon.tech'; // example Neon endpoint
$dbname = 'geotrack';
$user = 'jerwin1095';
$password = 'yourNeonPassword'; // <-- Put your actual Neon password here
$port = '5432'; // Neon/Postgres default

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
if (!$conn) {
    die('Connection failed: ' . pg_last_error());
}
?>
