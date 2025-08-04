<?php
// Include DB connection and mailer
require_once 'db_connect.php';
require_once 'mailer.php';

// Check if required POST parameters are set
if (isset($_POST['user_id'], $_POST['location'], $_POST['email'])) {
    $user_id = $_POST['user_id'];
    $location = $_POST['location'];
    $email = $_POST['email'];

    // Prepare SQL query
    $query = "UPDATE users SET location = $1 WHERE id = $2";
    $result = pg_query_params($conn, $query, [$location, $user_id]);

    if ($result) {
        // Send confirmation email
        $subject = '📍 Location Assigned – GeoTrack';
        $body = "Hello! Your location has been successfully assigned to: <strong>$location</strong>. You may now proceed with validation.";

        $mailResult = sendEmail($email, $subject, $body);

        if ($mailResult === true) {
            echo "Location assigned and email sent successfully.";
        } else {
            echo "Location assigned, but email failed: " . $mailResult;
        }

    } else {
        echo "❌ Failed to assign location.";
    }
} else {
    echo "❗ Missing parameters.";
}
?>
