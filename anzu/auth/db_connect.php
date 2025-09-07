<?php
// auth/db_connect.php

$db_host = 'localhost'; // Usually 'localhost'
$db_name = 'your_database_name'; // Replace with your database name
$db_user = 'your_username'; // Replace with your database username
$db_pass = 'your_password'; // Replace with your database password

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass, $options);
} catch (\PDOException $e) {
    // In a real application, you would log this error and show a generic message
    // For debugging, it's fine to show the error.
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}