<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$to_email = 'luchiloo10@gmail.com';
$to_name = 'Recipient Name';

$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = 2; // Set to 0 for production
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;

    // ✅ Hardcoded credentials (for testing only!)
    $mail->Username   = 'capstoneprojecttwenty25@gmail.com';
    $mail->Password   = 'fhsy pvdl arkx wmdo'; // Gmail App Password

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Sender and recipient
    $mail->setFrom('capstoneprojecttwenty25@gmail.com', 'GeoTrack Mailer');
    $mail->addAddress($to_email, $to_name);

    // Email content
    $mail->Subject = '🚀 GeoTrack SMTP Test';
    $mail->Body    = "Hello $to_name,\n\nThis is a test email sent from GeoTrack using PHPMailer and Gmail SMTP.\n\nIf you're seeing this, SMTP is working correctly! 🎉";

    $mail->send();
    echo "✅ Message sent successfully to $to_email";
} catch (Exception $e) {
    echo "❌ Mailer Error: {$mail->ErrorInfo}";
}
?>
