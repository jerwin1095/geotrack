<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/Exception.php';
require __DIR__ . '/PHPMailer/PHPMailer.php';
require __DIR__ . '/PHPMailer/SMTP.php';

$to_email = 'luchiloo10@gmail.com'; // recipient email
$to_name  = 'Recipient Name';

$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug  = 0; // 2 for debug output
    $mail->isSMTP();
    $mail->Host       = 'smtp-relay.brevo.com';  // Brevo SMTP server
    $mail->SMTPAuth   = true;
    $mail->Username   = '93d527001@smtp-brevo.com'; // Your Brevo SMTP login
    $mail->Password   = 'bEgqyd3WImxRLGwD';          // Your Brevo SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('93d527001@smtp-brevo.com', 'GeoTrack Mailer'); // Sender email from Brevo
    $mail->addAddress($to_email, $to_name);

    $mail->Subject = '🚀 GeoTrack SMTP Test';
    $mail->Body    = "Hello $to_name,\n\nThis is a test email sent from GeoTrack using PHPMailer and Brevo SMTP.\n\nIf you're seeing this, SMTP is working correctly! 🎉";

    $mail->send();
    echo "✅ Message sent successfully to $to_email";
} catch (Exception $e) {
    echo "❌ Mailer Error: {$mail->ErrorInfo}";
}
