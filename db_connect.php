<?php
$url = getenv("DATABASE_URL");

if (!$url) {
    die("DATABASE_URL is not set.");
}

$parts = parse_url($url);
parse_str($parts["query"] ?? "", $query);

$host = $parts["host"] ?? '';
$user = $parts["user"] ?? '';
$pass = $parts["pass"] ?? '';
$dbname = ltrim($parts["path"] ?? '', '/');
$port = $parts["port"] ?? 5432;
$sslmode = $query["sslmode"] ?? "require";

if (empty($host) || empty($user) || empty($pass) || empty($dbname)) {
    die("Database connection details are incomplete.");
}

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$pass sslmode=$sslmode");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}
?>
