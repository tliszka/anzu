<?php
// --- DATABASE CREDENTIALS --- //
// Note: For a real application, you should use a more secure way to store credentials
// than hardcoding them, like environment variables.
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // Default XAMPP has no password for root
define('DB_NAME', 'anzuhuku_db');

// --- GOOGLE OAUTH CREDENTIALS --- //
// IMPORTANT: Paste your actual client ID and secret here.
define('GOOGLE_CLIENT_ID', '281930134970-rrdh3qflbr49jai3hmuubqg54vcrmm2m.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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');
define('GOOGLE_REDIRECT_URI', 'http://localhost/index.php'); // Must match the one in Google Cloud Console

// --- DATABASE CONNECTION --- //
// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    // In a real app, you'd want to log this error, not just display it.
    die("Connection failed: " . $conn->connect_error);
}
?>

