<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Recipient details — update dynamically if pulling from database
$to_email = "luchiloo10@gmail.com";   // User email
$to_name = "Luchiloo";                // User name

// Create PHPMailer instance
$mail = new PHPMailer(true);

try {
    // SMTP Configuration
    $mail->SMTPDebug = 2;  // Debugging output; set to 0 in production
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;

    // Secure credentials from Render environment variables
    $mail->Username   = getenv('SMTP_USERNAME');   // Example: capstoneprojecttwenty25@gmail.com
    $mail->Password   = getenv('SMTP_PASSWORD');   // Your Gmail App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Sender and recipient
    $mail->setFrom($mail->Username, 'Geo-TrackDTR');    // Admin sender label
    $mail->addAddress($to_email, $to_name);             // User recipient

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
