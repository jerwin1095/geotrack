<?php
$url = getenv("DATABASE_URL");

if (!$url) {
    die("❌ DATABASE_URL not set in environment.");
}

$parts = parse_url($url);
parse_str(parse_url($url, PHP_URL_QUERY), $query);

$host = $parts["host"] ?? null;
$port = $parts["port"] ?? 5432;
$user = $parts["user"] ?? null;
$pass = $parts["pass"] ?? null;
$dbname = ltrim($parts["path"] ?? '', '/');
$sslmode = $query["sslmode"] ?? "require";

$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$pass sslmode=$sslmode";

$conn = pg_connect($conn_string);

if (!$conn) {
    die("❌ Connection failed: " . pg_last_error());
}
?>
