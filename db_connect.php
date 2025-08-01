<?php
$url = getenv("DATABASE_URL");
$parts = parse_url($url);

// Parse query parameters
parse_str($parts["query"] ?? "", $query);

$host = $parts["host"];
$user = $parts["user"];
$pass = $parts["pass"];
$dbname = ltrim($parts["path"], "/");
$port = $parts["port"] ?? 5432;
$sslmode = $query["sslmode"] ?? "require";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$pass sslmode=$sslmode");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}
?>
