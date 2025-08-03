<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function send_notification($location, $ip, $mac) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'capstoneprojecttwenty25@gmail.com';
        $mail->Password   = 'your_app_password_here'; // Use actual App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('capstoneprojecttwenty25@gmail.com', 'GeoTrack Mailer');
        $mail->addAddress('recipient@example.com', 'Recipient Name');

        $mail->Subject = "GeoTrack Location Assigned";
        $mail->Body    = "Location: $location\nIP: $ip\nMAC: $mac";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}
?>
