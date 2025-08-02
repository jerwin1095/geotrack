<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// require 'vendor/autoload.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Email details
$to_email = "albertdelapena1095@gmail.com";
$to_name = "Admin";

$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = 2; // For debugging
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'capstoneprojecttwenty25@gmail.com';
    $mail->Password   = 'Camins31'; // Use app password if 2FA is enabled
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // The "From" address and username must be the same!
    $mail->setFrom('capstoneprojecttwenty25@gmail.com', 'Geo-TrackDTR');
    $mail->addAddress($to_email, $to_name);

    $mail->Subject = 'Test Email';
    $mail->Body    = "Hello $to_name, this is a test email from Geo-TrackDTR.";

    $mail->send();
    echo 'Message sent!';
} catch (Exception $e) {
    echo "Mailer Error: {$mail->ErrorInfo}";
}
?>
