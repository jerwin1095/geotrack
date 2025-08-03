<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

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

        // From email (must be verified in Brevo)
        $mail->setFrom('capstoneprojecttwenty25@gmail.com', 'GeoTrack Mailer');
        $mail->addAddress($to_email, $to_name);

        // Email content
        $mail->Subject = "📍 New Location Assigned to You";
        $mail->Body    = "Hi $to_name,\n\nYou’ve been assigned a new location:\nLatitude: $lat\nLongitude: $lng\n\nPlease check your GeoTrack dashboard.";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}
