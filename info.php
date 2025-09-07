<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$to = "tliszka@gmail.com";
$subject = "Test Mail from Anzu.hu";
$message = "This is a test to see if the PHP mail() function is working on the server.";
$headers = "From: no-reply@anzu.hu";

if (mail($to, $subject, $message, $headers)) {
    echo "Test email sent successfully to " . htmlspecialchars($to);
} else {
    echo "Failed to send the test email.";
}
?>