<?php
// auth/oauth_callback.php

session_start();
require_once __DIR__ . '/../vendor/autoload.php';
require_once 'db_connect.php';

// (Include the same $providers array from oauth.php here)
$providers = [ ... ]; // Copy from above

$providerName = $_GET['provider'] ?? '';

// Security check: state should match
if (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
    unset($_SESSION['oauth2state']);
    die('Invalid state.');
}

try {
    // (Instantiate the $provider again just like in oauth.php)
    if ($providerName === 'Google') {
        $provider = new League\OAuth2\Client\Provider\Google($providers[$providerName]);
    } elseif ($providerName === 'Facebook') {
        $provider = new League\OAuth2\Client\Provider\Facebook($providers[$providerName]);
    } else {
        die('Invalid provider.');
    }

    // Step 2: Get an access token
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);
    
    // Step 3: Get user details
    $ownerDetails = $provider->getResourceOwner($token);
    
    $oauth_uid = $ownerDetails->getId();
    $name = $ownerDetails->getName();
    $email = $ownerDetails->getEmail();

    // Check if user exists in our database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // User exists, log them in
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
    } else {
        // New user, create an account
        $stmt = $pdo->prepare("INSERT INTO users (name, email, oauth_provider, oauth_uid) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $providerName, $oauth_uid]);
        $user_id = $pdo->lastInsertId();
        
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $name;
    }
    
    // Redirect to dashboard
    header('Location: ../dashboard.php');
    exit();

} catch (Exception $e) {
    // Failed to get access token or user details
    die('Something went wrong: ' . $e->getMessage());
}