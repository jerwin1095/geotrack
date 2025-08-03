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
    $mail->SMTPDebug = 2; // Set to 0 to suppress output
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;

    // Use environment variables for secure config
    $mail->Username = getenv('SMTP_USERNAME');  // e.g., capstoneprojecttwenty25@gmail.com
    $mail->Password = getenv('SMTP_PASSWORD');  // App Password, NOT Gmail login

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom(getenv('SMTP_USERNAME'), 'Geo-TrackDTR');
    $mail->addAddress($to_email, $to_name);
    $mail->Subject = 'Test Email';
    $mail->Body = "Hello $to_name, this is a test email from Geo-TrackDTR.";

    $mail->send();
    echo '✅ Message sent successfully.';
} catch (Exception $e) {
    echo "❌ Mailer Error: {$mail->ErrorInfo}";
}
?>
