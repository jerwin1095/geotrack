<?php
// Include your DB connection
include 'db_connect.php';

// Include PHPMailer and mailer function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Define the email sending function
function sendAssignmentEmail($to_email, $to_name, $lat, $lng) {
    $mail = new PHPMailer(true);
    try {
        // Brevo SMTP settings
        $mail->isSMTP();
        $mail->Host       = 'smtp-relay.brevo.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = '93d527001@smtp-brevo.com';  // Your Brevo SMTP login
        $mail->Password   = 'bEgqyd3WImxRLGwD';          // Your Brevo SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('capstoneprojecttwenty25@gmail.com', 'GeoTrack Mailer');
        $mail->addAddress($to_email, $to_name);

        $mail->Subject = "📍 New Location Assigned to You";
        $mail->Body    = "Hi $to_name,\n\nYou’ve been assigned a new location:\nLatitude: $lat\nLongitude: $lng\n\nPlease check your GeoTrack dashboard.";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data (adjust field names to your form)
    $user_id = $_POST['user_id'] ?? null;
    $lat = $_POST['lat'] ?? null;
    $lng = $_POST['lng'] ?? null;

    if ($user_id && $lat && $lng) {
        // Update user location assignment in DB
        $stmt = $conn->prepare("UPDATE users SET assigned_lat = ?, assigned_lng = ? WHERE id = ?");
        $stmt->bind_param("ddi", $lat, $lng, $user_id);

        if ($stmt->execute()) {
            // Fetch user info to get email and name
            $user_stmt = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
            $user_stmt->bind_param("i", $user_id);
            $user_stmt->execute();
            $user_result = $user_stmt->get_result();

            if ($user_result->num_rows === 1) {
                $user = $user_result->fetch_assoc();
                $to_email = $user['email'];
                $to_name = $user['name'];

                // Send notification email
                if (sendAssignmentEmail($to_email, $to_name, $lat, $lng)) {
                    echo "✅ Location assigned and email sent to $to_name";
                } else {
                    echo "⚠️ Location assigned but failed to send email.";
                }
            } else {
                echo "❌ User not found.";
            }
        } else {
            echo "❌ Failed to assign location.";
        }
    } else {
        echo "❌ Missing required fields.";
    }
} else {
    echo "❌ Invalid request method.";
}
?>
