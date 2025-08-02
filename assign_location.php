<?php
require_once 'db_connect.php';
require 'PHPMailer/PHPMailerAutoload.php'; // Or use 'vendor/autoload.php' if installed via Composer

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $location_name = $_POST['location_name'] ?? '';
    $selected_users = $_POST['selected_users'] ?? [];
    if (empty($location_name) || empty($selected_users)) {
        $response['message'] = "Please provide a location and select at least one user.";
        echo json_encode($response);
        exit;
    }

    $errors = [];
    foreach ($selected_users as $user_id) {
        // Update user location in DB
        $update_res = pg_query_params($conn, "UPDATE users SET location=$1 WHERE id=$2", [$location_name, $user_id]);

        // Get user's email & name
        $user_res = pg_query_params($conn, "SELECT email, name FROM users WHERE id=$1", [$user_id]);
        if ($user_row = pg_fetch_assoc($user_res)) {
            $email = $user_row['email'];
            $name = $user_row['name'];

            // PHPMailer setup
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'capstoneprojecttwenty25@gmail.com'; // Your Gmail
            $mail->Password = 'Camins31'; // Use your Gmail or App password here
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('capstoneprojecttwenty25@gmail.com', 'Geo-TrackDTR');
            $mail->addAddress($email, $name);

            $mail->Subject = "You have been assigned a new location";
            $login_url = "http://yourdomain.com/login.php"; // <-- Replace with your actual domain and login path!
            $mail->Body = "Hello $name,\n\nYou have been assigned to location: $location_name.\n\nYou can time in at: $login_url\n\nThank you!";

            if(!$mail->send()) {
                $errors[] = "Mail error for $email: " . $mail->ErrorInfo;
            }
        }
    }
    $response['success'] = count($errors) === 0;
    $response['message'] = (count($errors) === 0)
        ? "Users assigned and email sent!"
        : implode("\n", $errors);
}
echo json_encode($response);
?>
