<?php
// auth/login.php

session_start();
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        header('Location: ../index.php?error=empty_fields');
        exit();
    }

    // Find user by email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Verify user and password
    if ($user && password_verify($password, $user['password_hash'])) {
        // Password is correct, log the user in
        session_regenerate_id(); // Security measure
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        
        // Redirect to the dashboard
        header('Location: ../dashboard.php');
        exit();
    } else {
        // Invalid credentials
        header('Location: ../index.php?error=invalid_credentials');
        exit();
    }
}