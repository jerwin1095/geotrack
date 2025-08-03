<?php
require 'mailer.php';  // Your PHPMailer email function

// DB connection (you can also require your db_connect.php if you have one)
$host = 'ep-ancient-tree-af3pt6am-pooler.c-2.us-west-2.aws.neon.tech';
$dbname = 'neondb';
$user = 'neondb_owner';
$password = 'npg_xD48zaycMqfl';
$port = '5432';

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password sslmode=require");
if (!$conn) {
    die('Connection failed: ' . pg_last_error());
}

// Assume you get user_id and location from POST
$userId = $_POST['user_id'] ?? null;
$locationLat = $_POST['lat'] ?? null;
$locationLng = $_POST['lng'] ?? null;

if (!$userId || !$locationLat || !$locationLng) {
    die('Missing parameters');
}

// Fetch user email and name from DB
$result = pg_query_params($conn, "SELECT email, name FROM users WHERE id = $1", array($userId));
if (!$result || pg_num_rows($result) === 0) {
    die('User not found');
}
$user = pg_fetch_assoc($result);
$userEmail = $user['email'];
$userName = $user['name'];

// Insert your logic here to save the assigned location in the database
// Example:
// $insert = pg_query_params($conn, "INSERT INTO user_locations(user_id, lat, lng) VALUES ($1, $2, $3)", array($userId, $locationLat, $locationLng));

// Compose email
$subject = "New Location Assigned";
$body = "
    <h3>Hello $userName,</h3>
    <p>You have been assigned to a new location:</p>
    <ul>
        <li>Latitude: $locationLat</li>
        <li>Longitude: $locationLng</li>
    </ul>
    <p>Please check your dashboard for more details.</p>
";

// Send email
if (sendEmail($userEmail, $subject, $body)) {
    echo "User assigned and email sent successfully.";
} else {
    echo "User assigned but failed to send email.";
}

pg_close($conn);
?>
