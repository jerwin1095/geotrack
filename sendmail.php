<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// USER email details — update dynamically from database if needed
$to_email = "luchiloo10@gmail.com";   // Recipient email (user)
$to_name = "Luchiloo";                // Recipient name

// Create PHPMailer instance
$mail = new PHPMailer(true);

try {
    // SMTP Configuration
    $mail->SMTPDebug = 2;  // Set to 0 in production
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'capstoneprojecttwenty25@gmail.com';  // Admin sender
    $mail->Password   = 'Camins31'; // Use App Password if 2FA is enabled
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Sender and Recipient Info
    $mail->setFrom('capstoneprojecttwenty25@gmail.com', 'Geo-TrackDTR'); // Admin info
    $mail->addAddress($to_email, $to_name);                               // User info

    // Email Content
    $mail->Subject = 'Welcome to Geo-TrackDTR!';
    $mail->Body    = "Hi $to_name,\n\nYou're now successfully registered in our system. Reach out if you need help.\n\nBest regards,\nGeo-TrackDTR Admin";

    // Send the email
    $mail->send();
    echo '✅ Message sent successfully to ' . $to_email;
} catch (Exception $e) {
    echo "❌ Mailer Exception: " . $e->getMessage() . "<br>";
    echo "📄 PHPMailer Info: " . $mail->ErrorInfo;
}
?>
