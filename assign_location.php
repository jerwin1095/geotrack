<?php
// Show errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Error handlers
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => "PHP Error [$errno]: $errstr in $errfile on line $errline"
    ]);
    exit;
});
set_exception_handler(function($e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => "Uncaught Exception: " . $e->getMessage()
    ]);
    exit;
});

// Include database connection
require_once 'db_connect.php';

// Include PHPMailer
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$response = ['success' => false, 'message' => 'Unknown error'];

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
        // Update DB
        $update_res = pg_query_params($conn, "UPDATE users SET location=$1 WHERE id=$2", [$location_name, $user_id]);
        if (!$update_res) {
            $errors[] = "DB error for user $user_id: " . pg_last_error($conn);
            continue;
        }

        // Get user email and name
        $user_q = pg_query_params($conn, "SELECT email, name FROM users WHERE id=$1", [$user_id]);
        $user = pg_fetch_assoc($user_q);
        if (!$user) {
            $errors[] = "User not found for ID $user_id.";
            continue;
        }

        // Send email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'YOUR_GMAIL@gmail.com';         // <-- Replace with your Gmail address
            $mail->Password = 'YOUR_GMAIL_APP_PASSWORD';      // <-- Replace with your Gmail App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('YOUR_GMAIL@gmail.com', 'Geo-TrackDTR'); // <-- Replace with your Gmail address
            $mail->addAddress($user['email'], $user['name']);

            // Content
            $mail->isHTML(false);
            $mail->Subject = "You have been assigned a new location";
            $login_url = "https://geotrack-wclf.onrender.com/login.php";
            $mail->Body = "Hello {$user['name']},\n\nYou have been assigned to location: $location_name.\n\nYou can time in at: $login_url\n\nThank you!";

            $mail->send();
        } catch (Exception $e) {
            $errors[] = "Mail error for {$user['email']}: " . $mail->ErrorInfo;
        }
    }

    if (count($errors) === 0) {
        $response['success'] = true;
        $response['message'] = "Users assigned and email sent!";
    } else {
        $response['message'] = implode("\n", $errors);
    }
    echo json_encode($response);
    exit;
}

// If not POST
$response['message'] = "Invalid request method.";
echo json_encode($response);
exit;
?>
