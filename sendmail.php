<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Require PHPMailer files (adjust the path if needed)
require __DIR__ . '/PHPMailer/Exception.php';
require __DIR__ . '/PHPMailer/PHPMailer.php';
require __DIR__ . '/PHPMailer/SMTP.php';

// Function to send email
function sendMail($to_email, $to_name, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp-relay.brevo.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = '93d527001@smtp-brevo.com';  // Your Brevo SMTP login
        $mail->Password   = 'bEgqyd3WImxRLGwD';           // Your Brevo SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Sender info
        $mail->setFrom('capstoneprojecttwenty25@gmail.com', 'GeoTrack Mailer');

        // Recipient
        $mail->addAddress($to_email, $to_name);

        // Email content
        $mail->Subject = $subject;
        $mail->Body    = $body;

        // Send email
        $mail->send();
        return true;

    } catch (Exception $e) {
        // You can log the error: $mail->ErrorInfo
        return "Mailer Error: " . $mail->ErrorInfo;
    }
}

// Example usage:
$to_email = 'luchiloo10@gmail.com';
$to_name  = 'Recipient Name';
$subject  = '🚀 GeoTrack SMTP Test';
$body     = "Hello $to_name,\n\nThis is a test email sent from GeoTrack using PHPMailer and Brevo SMTP.\n\nIf you're seeing this, SMTP is working correctly! 🎉";

$result = sendMail($to_email, $to_name, $subject, $body);

if ($result === true) {
    echo "✅ Message sent successfully to $to_email";
} else {
    echo "❌ $result";
}
