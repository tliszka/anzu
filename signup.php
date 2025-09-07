<?php

session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/src/db.php';
require_once __DIR__ . '/src/passes.php';

// Ensure this is a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit();
}

// Get form data and perform basic validation
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$pass_id = $_POST['pass_id'] ?? '';

if (empty($name) || empty($email) || empty($password) || empty($pass_id) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Redirect back with an error for invalid input
    header('Location: index.php?error=invalid_input');
    exit();
}

$pdo = get_pdo_connection();

// Use a transaction to ensure both user and pass are created successfully
$pdo->beginTransaction();

try {
    // 1. Check if user already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        throw new Exception("email_exists");
    }

    // 2. Create the new user
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $password_hash]);
    $user_id = $pdo->lastInsertId();

    // 3. Get the details of the pass they are purchasing
    $stmt = $pdo->prepare("SELECT ticket_count, validity_days FROM passes WHERE id = ?");
    $stmt->execute([$pass_id]);
    $pass_details = $stmt->fetch();

    if (!$pass_details) {
        throw new Exception("invalid_pass");
    }

    // 4. Create the user's new pass
    $pass_code = generate_pass_code();
    $expiry_date = (new DateTime())->modify('+' . $pass_details['validity_days'] . ' days')->format('Y-m-d');
    
    $stmt = $pdo->prepare(
        "INSERT INTO user_passes (user_id, pass_id, pass_code, tickets_remaining, expiry_date) VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->execute([$user_id, $pass_id, $pass_code, $pass_details['ticket_count'], $expiry_date]);

    // If everything worked, commit the changes to the database
    $pdo->commit();

    // 5. Log the new user in and redirect to their dashboard
    session_regenerate_id();
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_name'] = $name;

    header('Location: dashboard.php');
    exit();

} catch (Exception $e) {
    // If anything went wrong, roll back the transaction
    $pdo->rollBack();

    // Redirect with an error message
    $error_code = $e->getMessage();
    header('Location: index.php?error=' . urlencode($error_code));
    exit();
}