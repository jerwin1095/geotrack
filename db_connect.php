<?php
$url = getenv("DATABASE_URL");

// Parse the URL parts
$parts = parse_url($url);

// Check if all necessary parts exist
if (!isset($parts["host"], $parts["user"], $parts["pass"], $parts["path"])) {
    die("❌ Database connection details are incomplete.");
}

$host = $parts["host"];
$user = $parts["user"];
$pass = $parts["pass"];
$dbname = ltrim($parts["path"], "/");
$port = isset($parts["port"]) ? $parts["port"] : 5432;

// Connect using key=value format (required by pg_connect)
$conn_str = "host=$host port=$port dbname=$dbname user=$user password=$pass sslmode=require";

$conn = pg_connect($conn_str);

if (!$conn) {
    die("❌ Connection failed: " . pg_last_error());
}
?>
