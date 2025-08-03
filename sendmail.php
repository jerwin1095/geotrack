<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Email details
$to_email = "albertdelapena1095@gmail.com";
$to_name = "Admin";

$mail = new PHPMailer(true);

try {
    // SMTP Configuration
    $mail->SMTPDebug = 2;  // Show verbose debug output during development
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'capstoneprojecttwenty25@gmail.com';
    $mail->Password   = 'Camins31'; // Replace with your actual password or App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Sender and Recipient
    $mail->setFrom('capstoneprojecttwenty25@gmail.com', 'Geo-TrackDTR');
    $mail->addAddress($to_email, $to_name);

    // Email Content
    $mail->Subject = 'Test Email';
    $mail->Body    = "Hello $to_name, this is a test email from Geo-TrackDTR.";

    // Send Email
    $mail->send();
    echo '✅ Message sent successfully!';
} catch (Exception $e) {
    echo "❌ Mailer Error: {$mail->ErrorInfo}";
}
?>
