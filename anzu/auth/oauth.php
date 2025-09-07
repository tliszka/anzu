<?php
// auth/oauth.php

session_start();
require_once __DIR__ . '/../vendor/autoload.php'; // Composer's autoloader

// IMPORTANT: Replace with your actual credentials
$providers = [
    'Google' => [
        'clientId'     => 'YOUR_GOOGLE_CLIENT_ID',
        'clientSecret' => 'YOUR_GOOGLE_CLIENT_SECRET',
        'redirectUri'  => 'http://your-website.com/auth/oauth_callback.php?provider=Google',
    ],
    'Facebook' => [
        'clientId'     => 'YOUR_FACEBOOK_CLIENT_ID',
        'clientSecret' => 'YOUR_FACEBOOK_CLIENT_SECRET',
        'redirectUri'  => 'http://your-website.com/auth/oauth_callback.php?provider=Facebook',
        'graphApiVersion' => 'v2.10',
    ],
];

$providerName = $_GET['provider'] ?? '';

if (!isset($providers[$providerName])) {
    die('Invalid provider specified.');
}

$providerConfig = $providers[$providerName];

if ($providerName === 'Google') {
    $provider = new League\OAuth2\Client\Provider\Google($providerConfig);
} elseif ($providerName === 'Facebook') {
    $provider = new League\OAuth2\Client\Provider\Facebook($providerConfig);
}

if (!isset($_GET['code'])) {
    // Step 1: Get authorization code
    $authUrl = $provider->getAuthorizationUrl([
        'scope' => ($providerName === 'Facebook') ? ['email', 'public_profile'] : ['email', 'profile'],
    ]);
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: ' . $authUrl);
    exit;
}