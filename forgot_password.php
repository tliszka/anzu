<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/src/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit();
}

$email = trim($_POST['email'] ?? '');

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: index.php?error=invalid_email');
    exit();
}

try {
    $pdo = get_pdo_connection();
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // User exists, so we generate a token.
        $token = bin2hex(random_bytes(32));
        $expires = new DateTime('+1 hour');
        $expires_str = $expires->format('Y-m-d H:i:s');
        
        // Store token and expiry in the database for this user
        $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_token_expires_at = ? WHERE id = ?");
        $stmt->execute([$token, $expires_str, $user['id']]);
        
        // --- EMAIL SENDING LOGIC ---
        // For a real application, you would use a library like PHPMailer to send an email.
        // The email would contain a link like: https://anzu.hu/reset_password.php?token=...
        // We will implement the actual email sending in a later phase.
    }

    // IMPORTANT: Always redirect to a success page to prevent "email enumeration" attacks,
    // which would allow attackers to discover which emails are registered.
    header('Location: index.php?reset_sent=true');
    exit();

} catch (PDOException $e) {
    // A database error occurred.
    header('Location: index.php?error=db_error');
    exit();
}