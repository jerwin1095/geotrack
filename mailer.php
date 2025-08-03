<?php
// Load PHPMailer classes
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Send email via Brevo SMTP using PHPMailer
 * 
 * @param string $to Recipient email address
 * @param string $subject Email subject
 * @param string $body Email HTML body content
 * @return bool True on success, False on failure
 */
function sendEmail($to, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp-relay.brevo.com';    // Brevo SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = '93d527001@smtp-brevo.com';  // Your Brevo SMTP login
        $mail->Password   = 'bEgqyd3WImxRLGwD';          // Your Brevo SMTP password
        $mail->SMTPSecure = 'tls';                        // Encryption - tls or ssl
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('capstoneprojecttwenty25@gmail.com', 'GeoTrack Mailer'); // Verified sender email & name
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

// Example usage (remove this when integrating into your system)
if (php_sapi_name() !== 'cli') {
    $testRecipient = 'luchiloo10@gmail.com';
    $testSubject = 'GeoTrack SMTP Test';
    $testBody = "
        <p>Hello Recipient Name,</p>
        <p>This is a test email sent from GeoTrack using PHPMailer and Brevo SMTP.</p>
        <p>If you're seeing this, SMTP is working correctly! 🎉</p>
    ";

    if (sendEmail($testRecipient, $testSubject, $testBody)) {
        echo 'Test email sent successfully!';
    } else {
        echo 'Failed to send test email.';
    }
}
?>
