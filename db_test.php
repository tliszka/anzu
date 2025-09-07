<?php
// db_test.php

// Use the exact same config file as your main application
require_once __DIR__ . '/config.php';

echo "<h2>Testing Database Connection...</h2>";
echo "<p>Host: " . DB_HOST . "</p>";
echo "<p>Database: " . DB_NAME . "</p>";
echo "<p>User: " . DB_USER . "</p>";

try {
    // Attempt to create a new PDO connection
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $options = [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ];
    
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

    // If the line below shows up, the connection was successful
    echo '<p style="color:green; font-weight:bold;">✅ Success! Connection to the database was established.</p>';

} catch (\PDOException $e) {
    // If it fails, it will catch the error and display it
    echo '<p style-="color:red; font-weight:bold;">❌ Error! Connection failed.</p>';
    echo "<p><strong>Error Details:</strong> " . $e->getMessage() . "</p>";
}