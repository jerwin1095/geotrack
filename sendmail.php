<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Recipient details
$to_email = "luchiloo10@gmail.com";   // User email
$to_name  = "Luchiloo";               // User name

$mail = new PHPMailer(true);

try {
    // SMTP Configuration
    $mail->SMTPDebug = 2;  // Set to 0 for production
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;

    // Secure credentials from environment
    $mail->Username   = getenv('SMTP_USERNAME');
    $mail->Password   = getenv('SMTP_PASSWORD');

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Sender and recipient
    $mail->setFrom($mail->Username, 'Geo-TrackDTR');
    $mail->addAddress($to_email, $to_name);

    // Email content
    $mail->Subject = 'Welcome to Geo-TrackDTR!';
    $mail->Body    = "Hi $to_name,\n\nYou're now successfully registered in our system.\n\nBest,\nGeo-TrackDTR Admin";

    // Send the email
    $mail->send();
    echo '✅ Message sent successfully to ' . $to_email;
} catch (Exception $e) {
    echo "❌ Mailer Exception: " . $e->getMessage() . "<br>";
    echo "📄 PHPMailer Info: " . $mail->ErrorInfo;
}
?>
