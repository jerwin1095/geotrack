<?php
$host = 'ep-ancient-tree-af3pt6am-pooler.c-2.us-west-2.aws.neon.tech';
$dbname = 'neondb';
$user = 'neondb_owner';
$password = 'npg_xD48zaycMqfl';
$port = '5432';

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password sslmode=require");
if (!$conn) {
    die('Connection failed: ' . pg_last_error($conn));
}
?>
