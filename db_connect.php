<?php
$url = getenv("DATABASE_URL");

if (!$url) {
    die("DATABASE_URL not found.");
}

$parts = parse_url($url);

if (!$parts || !isset($parts["host"], $parts["user"], $parts["pass"], $parts["path"])) {
    die("Database connection details are incomplete.");
}

$host = $parts["host"];
$user = $parts["user"];
$pass = $parts["pass"];
$dbname = ltrim($parts["path"], '/');
$port = $parts["port"] ?? 5432;

// Optional: parse additional options
$query = [];
if (isset($parts["query"])) {
    parse_str($parts["query"], $query);
}
$sslmode = $query["sslmode"] ?? "require";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$pass sslmode=$sslmode");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}
?>
