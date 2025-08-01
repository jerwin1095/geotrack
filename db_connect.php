<?php
$url = getenv("DATABASE_URL");
$parts = parse_url($url);

$host = $parts["host"];
$user = $parts["user"];
$pass = $parts["pass"];
$dbname = ltrim($parts["path"], "/");
$port = isset($parts["port"]) ? $parts["port"] : 5432;

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$pass");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}
?>
