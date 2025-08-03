<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Recipient info
$to_email = 'luchiloo10@gmail.com';
$to_name  = 'Recipient Name';

$mail = new PHPMailer(true);

try {
    // SMTP configuration
    $mail->SMTPDebug  = 0;
    $mail->isSMTP();
    $mail->Host       = 'smtp-relay.brevo.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = '93d527001@smtp-brevo.com';   // From Brevo dashboard
    $mail->Password   = 'bEgqyd3WImxRLGwD';           // From Brevo dashboard
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Sender and recipient
    $mail->setFrom('capstoneprojecttwenty25@gmail.com', 'GeoTrack Mailer'); // Must be verified in Brevo
    $mail->addAddress($to_email, $to_name);

    // Email content
    $mail->Subject = '🚀 GeoTrack SMTP Test (via Brevo)';
    $mail->Body    = "Hello $to_name,\n\nThis is a test email sent from GeoTrack using PHPMailer and Brevo SMTP.\n\nIf you're seeing this, SMTP is working correctly! 🎉";

    // Send email
    $mail->send();
    echo "✅ Message sent successfully to $to_email";
} catch (Exception $e) {
    echo "❌ Mailer Error: {$mail->ErrorInfo}";
}
?>
