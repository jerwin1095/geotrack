<?php
require_once 'db_connect.php';
// require_once 'mailer.php'; // optional for sending email notifications

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['location'], $_POST['ip'], $_POST['mac'])) {
    $location = $_POST['location'];
    $ip = $_POST['ip'];
    $mac = $_POST['mac'];

    $sql = "INSERT INTO location_logs (location, ip_address, mac_address) VALUES ($1, $2, $3)";
    $result = pg_query_params($conn, $sql, [$location, $ip, $mac]);

    if ($result) {
        // send_notification($location, $ip, $mac); // optional
        echo 'Location assigned successfully.';
    } else {
        echo 'Error assigning location.';
    }
} else {
    echo 'Missing parameters.';
}
?>
