<?php
$url = getenv("DATABASE_URL");

if (!$url) {
    die("❌ DATABASE_URL is not set.");
}

$parts = parse_url($url);

if (!isset($parts["host"], $parts["user"], $parts["pass"], $parts["path"])) {
    die("❌ Database connection details are incomplete.");
}

$host = $parts["host"];
$user = $parts["user"];
$pass = $parts["pass"];
$dbname = ltrim($parts["path"], "/");  // removes leading slash from /neondb
$port = isset($parts["port"]) ? $parts["port"] : 5432;

// Add SSL mode from query string
$sslmode = "require"; // default to require
if (isset($parts["query"])) {
    parse_str($parts["query"], $queryParams);
    if (isset($queryParams["sslmode"])) {
        $sslmode = $queryParams["sslmode"];
    }
}

// Connect using pg_connect
$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$pass sslmode=$sslmode";
$conn = pg_connect($conn_string);

if (!$conn) {
    die("❌ Failed to connect to database: " . pg_last_error());
}
?>
