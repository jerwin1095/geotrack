<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendAssignmentEmail($to_email, $to_name, $lat, $lng) {
    $mail = new PHPMailer(true);

    try {
        // Enable verbose debug output (0 = off, 2 = debug)
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = function($str, $level) {
            echo "SMTP Debug [$level]: $str<br>";
        };

        $mail->isSMTP();
        $mail->Host       = 'smtp-relay.brevo.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = '93d527001@smtp-brevo.com';
        $mail->Password   = 'bEgqyd3WImxRLGwD';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Set sender and recipient
        $mail->setFrom('capstoneprojecttwenty25@gmail.com', 'GeoTrack Mailer');
        $mail->addAddress($to_email, $to_name);

        // Email content
        $mail->Subject = "📍 New Location Assigned to You";
        $mail->Body    = "Hi $to_name,\n\nYou’ve been assigned a new location:\nLatitude: $lat\nLongitude: $lng\n\nPlease check your GeoTrack dashboard.";

        // Send email
        $mail->send();

        return true;

    } catch (Exception $e) {
        // Show error for debugging
        echo "Mailer Error: " . $mail->ErrorInfo;
        return false;
    }
}
?>
