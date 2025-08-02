<?php
require_once 'db_connect.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $location_name = $_POST['location_name'] ?? '';
    $selected_users = $_POST['selected_users'] ?? [];
    if (empty($location_name) || empty($selected_users)) {
        $response['message'] = "Please provide a location and select at least one user.";
        echo json_encode($response);
        exit;
    }

    foreach ($selected_users as $user_id) {
        // Update user location in DB
        $res = pg_query_params($conn, "UPDATE users SET location=$1 WHERE id=$2", [$location_name, $user_id]);

        // Get user's email
        $user_res = pg_query_params($conn, "SELECT email, name FROM users WHERE id=$1", [$user_id]);
        if ($user_row = pg_fetch_assoc($user_res)) {
            $email = $user_row['email'];
            $name = $user_row['name'];
            // Prepare and send email
            $subject = "You have been assigned a new location";
            $login_url = "http://yourdomain.com/login.php"; // <-- CHANGE TO YOUR REAL LOGIN URL!
            $message = "Hello $name,\n\nYou have been assigned to location: $location_name.\n\nYou can time in at: $login_url\n\nThank you!";
            $headers = "From: noreply@yourdomain.com";
            mail($email, $subject, $message, $headers); // Send the email!
        }
    }

    $response['success'] = true;
    $response['message'] = "Users assigned and notified via email!";
}

echo json_encode($response);
