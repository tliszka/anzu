<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/src/db.php';

// Ensure this is a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit();
}

// Get form data
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    header('Location: index.php?error=empty_fields');
    exit();
}

try {
    $pdo = get_pdo_connection();

    // Find the user by their email address
    $stmt = $pdo->prepare("SELECT id, name, password_hash FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Verify the user exists and the password is correct
    if ($user && password_verify($password, $user['password_hash'])) {
        // Login successful: regenerate session ID for security
        session_regenerate_id();

        // Store user data in the session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];

        // Redirect to the user's dashboard
        header('Location: dashboard.php');
        exit();
    } else {
        // Login failed: redirect back with an error message
        header('Location: index.php?error=invalid_credentials');
        exit();
    }

} catch (PDOException $e) {
    // Database error: redirect back with a generic error
    header('Location: index.php?error=db_error');
    exit();
}