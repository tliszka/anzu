<?php
// auth/signup.php

session_start();
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Basic validation
    if (empty($name) || empty($email) || empty($password) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Handle error - redirect back with a message
        header('Location: ../index.php?error=invalid_input');
        exit();
    }

    // Check if email already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        // Email is already registered
        header('Location: ../index.php?error=email_exists');
        exit();
    }

    // Hash the password for security
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user into the database
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
    if ($stmt->execute([$name, $email, $password_hash])) {
        // Registration successful, log the user in
        $user_id = $pdo->lastInsertId();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $name;

        // Redirect to a dashboard or home page
        header('Location: ../dashboard.php'); // Create a dashboard.php file for logged-in users
        exit();
    } else {
        // Handle database insertion error
        header('Location: ../index.php?error=db_error');
        exit();
    }
}