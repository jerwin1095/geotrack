<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Use absolute paths relative to this file
require __DIR__ . '/PHPMailer/Exception.php';
require __DIR__ . '/PHPMailer/PHPMailer.php';
require __DIR__ . '/PHPMailer/SMTP.php';

// Recipient info
$to_email = 'luchiloo10@gmail.com';
$to_name  = 'Recipient Name';

$mail = new PHPMailer(true);

try {
    // SMTP configuration
    $mail->SMTPDebug  = 0;
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'capstoneprojecttwenty25@gmail.com';
    $mail->Password   = 'wcqhdqyfghhgygkcb'; // Your app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Sender and recipient
    $mail->setFrom('capstoneprojecttwenty25@gmail.com', 'GeoTrack Mailer');
    $mail->addAddress($to_email, $to_name);

    // Email content
    $mail->Subject = '🚀 GeoTrack SMTP Test';
    $mail->Body    = "Hello $to_name,\n\nThis is a test email sent from GeoTrack using PHPMailer and Gmail SMTP.\n\nIf you're seeing this, SMTP is working correctly! 🎉";

    // Send email
    $mail->send();
    echo "✅ Message sent successfully to $to_email";
} catch (Exception $e) {
    echo "❌ Mailer Error: {$mail->ErrorInfo}";
}
