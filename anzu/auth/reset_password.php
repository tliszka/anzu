<?php
// auth/reset_password.php
require_once 'db_connect.php';

$token = $_GET['token'] ?? '';
$error = '';
$success = '';

if (empty($token)) {
    die("Invalid reset link.");
}

// Find user by token, ensuring it's not expired
$stmt = $pdo->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_token_expires_at > NOW()");
$stmt->execute([$token]);
$user = $stmt->fetch();

if (!$user) {
    die("This password reset link is invalid or has expired.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if ($password !== $password_confirm) {
        $error = "Passwords do not match.";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long.";
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        // Update password and nullify the token
        $stmt = $pdo->prepare("UPDATE users SET password_hash = ?, reset_token = NULL, reset_token_expires_at = NULL WHERE id = ?");
        $stmt->execute([$password_hash, $user['id']]);
        
        $success = "Your password has been reset successfully! You can now <a href='../index.php'>login</a>.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <style>
        body { background-color: #f5f5f5; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .reset-card { max-width: 450px; width: 100%; }
    </style>
</head>
<body>
    <div class="reset-card card">
        <div class="card-content">
            <span class="card-title">Choose a New Password</span>
            <?php if ($success): ?>
                <p class="green-text"><?= htmlspecialchars($success) ?></p>
            <?php else: ?>
                <form method="POST" action="reset_password.php?token=<?= htmlspecialchars($token) ?>">
                    <div class="input-field">
                        <input id="password" type="password" name="password" required>
                        <label for="password">New Password</label>
                    </div>
                    <div class="input-field">
                        <input id="password_confirm" type="password" name="password_confirm" required>
                        <label for="password_confirm">Confirm New Password</label>
                    </div>
                    <?php if ($error): ?>
                        <p class="red-text"><?= htmlspecialchars($error) ?></p>
                    <?php endif; ?>
                    <button type="submit" class="btn waves-effect waves-light" style="width: 100%;">Reset Password</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>