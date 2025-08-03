<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Require PHPMailer files — adjust paths if needed
require __DIR__ . '/PHPMailer/Exception.php';
require __DIR__ . '/PHPMailer/PHPMailer.php';
require __DIR__ . '/PHPMailer/SMTP.php';

// Function to send email
function sendEmail($to, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration (Brevo)
        $mail->isSMTP();
        $mail->Host       = 'smtp-relay.brevo.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = '93d527001@smtp-brevo.com';   // Brevo SMTP login
        $mail->Password   = 'bEgqyd3WImxRLGwD';            // Brevo SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Sender identity
        $mail->setFrom('capstoneprojecttwenty25@gmail.com', 'GeoTrack Mailer');

        // Recipient
        $mail->addAddress($to); // Optionally add name as 2nd argument

        // Email content
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->isHTML(false); // Set to true if sending HTML emails

        $mail->send();
        return true;

    } catch (Exception $e) {
        return "Mailer Error: " . $mail->ErrorInfo;
    }
}
?>
