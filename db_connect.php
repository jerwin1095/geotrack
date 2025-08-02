<?php
$host = 'ep-dawn-forest-12345.ap-southeast-1.aws.neon.tech';
$dbname = 'neondb';
$user = 'jerwin1095';
$password = 'npg_xD48zaycMqfl';
$port = '5432';

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password sslmode=require");
if (!$conn) {
    die('Connection failed: ' . pg_last_error($conn));
}
?>


