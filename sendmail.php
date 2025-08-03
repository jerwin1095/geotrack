<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer classes
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Recipient info
$to_email = 'luchiloo10@gmail.com';  // You can change this to any test email
$to_name = 'Recipient Name';

$mail = new PHPMailer(true);

try {
    // SMTP Config
    $mail->SMTPDebug = 2; // Set to 0 to suppress debug output
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;

    // Gmail credentials
    $mail->Username   = 'capstoneprojecttwenty25@gmail.com';
    $mail->Password   = 'fhsy pvdl arkx wmdo';  // App password (keep secure!)

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Email content
    $mail->setFrom('capstoneprojecttwenty25@gmail.com', 'GeoTrack Mailer');
    $mail->addAddress($to_email, $to_name);
    $mail->Subject = '🚀 GeoTrack Test Email';
    $mail->Body    = "Hello $to_name,\n\nThis is a test email from GeoTrack deployed on Render.\n\nIf you're reading this, SMTP is working! 🎉";

    // Send it
    $mail->send();
    echo "✅ Message sent successfully to $to_email";
} catch (Exception $e) {
    echo "❌ Mailer Error: {$mail->ErrorInfo}";
}
?>
