<?php
// Simple PHP contact form handler
// - Returns plain text 'OK' on success to match assets/vendor/php-email-form/validate.js
// - Replace $receiving_email_address with your real email
// NOTE: This works only when the site is hosted on a PHP-enabled server. GitHub Pages does not run PHP.

$receiving_email_address = 'ukashakhan7198@gmail.com';

// Basic validation
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$subject = isset($_POST['subject']) ? trim($_POST['subject']) : 'New contact message';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

if (empty($name) || empty($email) || empty($message)) {
    http_response_code(400);
    echo 'Please complete the form and try again.';
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo 'Please provide a valid email address.';
    exit;
}

// Build email
$email_subject = '[' . htmlspecialchars($subject) . '] Message from ' . htmlspecialchars($name);
$email_body = "Name: " . htmlspecialchars($name) . "\n";
$email_body .= "Email: " . htmlspecialchars($email) . "\n\n";
$email_body .= "Message:\n" . htmlspecialchars($message) . "\n";

// Headers
$headers = 'From: ' . $name . ' <' . $email . "\r\n";
$headers .= 'Reply-To: ' . $email . "\r\n";
$headers .= 'Content-Type: text/plain; charset=UTF-8' . "\r\n";

// Send email
try {
    $sent = mail($receiving_email_address, $email_subject, $email_body, $headers);
    if ($sent) {
        echo 'OK';
    } else {
        http_response_code(500);
        echo 'Failed to send message. Please try again later.';
    }
} catch (Exception $e) {
    http_response_code(500);
    echo 'Server error: ' . $e->getMessage();
}

?>
