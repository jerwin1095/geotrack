<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer classes with absolute path, adjust if needed
require __DIR__ . '/PHPMailer/Exception.php';
require __DIR__ . '/PHPMailer/PHPMailer.php';
require __DIR__ . '/PHPMailer/SMTP.php';

// Recipient info (you can replace these or make dynamic)
$to_email = 'luchiloo10@gmail.com';
$to_name  = 'Recipient Name';

$mail = new PHPMailer(true);

try {
    // SMTP configuration for Brevo
    $mail->isSMTP();
    $mail->Host       = 'smtp-relay.brevo.com';         // Brevo SMTP server
    $mail->SMTPAuth   = true;
    $mail->Username   = 'your-brevo-smtp-login';        // Your Brevo SMTP username
    $mail->Password   = 'your-brevo-smtp-password';     // Your Brevo SMTP password (API key)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use TLS encryption
    $mail->Port       = 587;

    // Sender and recipient
    $mail->setFrom('your-email@domain.com', 'GeoTrack Mailer'); // Your sender email & name
    $mail->addAddress($to_email, $to_name);

    // Email content
    $mail->Subject = '🚀 GeoTrack SMTP Test';
    $mail->Body    = "Hello $to_name,\n\nThis is a test email sent from GeoTrack using PHPMailer and Brevo SMTP.\n\nIf you're seeing this, SMTP is working correctly! 🎉";

    // Send email
    $mail->send();
    echo "✅ Message sent successfully to $to_email";
} catch (Exception $e) {
    echo "❌ Mailer Error: {$mail->ErrorInfo}";
}
