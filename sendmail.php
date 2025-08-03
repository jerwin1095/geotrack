<?php
require_once 'mailer.php';

// Fetch these dynamically from your database or user management system
$to_email = 'luchiloo10@gmail.com';
$to_name  = 'albert';
$lat      = '7.1867';
$lng      = '125.4752';

// Send the email
if (sendAssignmentEmail($to_email, $to_name, $lat, $lng)) {
    echo "✅ Email sent successfully to $to_name ($to_email)";
} else {
    echo "❌ Failed to send email";
}
?>
