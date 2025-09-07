<?php

// A function to establish a database connection (PDO)
function get_pdo_connection() {
    // Data Source Name (DSN)
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        return new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (\PDOException $e) {
        // In a real production app, you would log this error and show a generic message
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}