<?php
// auth/forgot_password.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user) {
        // Generate a secure token
        $token = bin2hex(random_bytes(32));
        $expires = new DateTime('+1 hour');
        $expires_str = $expires->format('Y-m-d H:i:s');
        
        // Store token in database
        $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_token_expires_at = ? WHERE id = ?");
        $stmt->execute([$token, $expires_str, $user['id']]);
        
        // --- SEND EMAIL ---
        // This part will NOT work without configuring your SMTP settings.
        $mail = new PHPMailer(true);
        $reset_link = "http://your-website.com/auth/reset_password.php?token=" . $token;

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.example.com'; // Your SMTP server
            $mail->SMTPAuth   = true;
            $mail->Username   = 'user@example.com'; // Your SMTP username
            $mail->Password   = 'secret';           // Your SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Recipients
            $mail->setFrom('no-reply@your-website.com', 'Your App');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = "Please click the following link to reset your password: <a href='{$reset_link}'>{$reset_link}</a>";
            $mail->AltBody = "Please copy and paste this URL into your browser to reset your password: {$reset_link}";

            $mail->send();
        } catch (Exception $e) {
            // You can log this error: "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"
        }
    }
    
    // IMPORTANT: Always show a generic success message to prevent email enumeration attacks.
    header('Location: ../index.php?reset_sent=true');
    exit();
}