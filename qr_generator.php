<?php

// Include the QR code library from its new folder
require_once __DIR__ . '/src/phpqrcode/qrlib.php';

// Get the pass code from the URL
$passCode = $_GET['data'] ?? null;

if (empty($passCode)) {
    // Exit if no data is provided
    http_response_code(400);
    exit('Error: No data provided.');
}

// Generate and output the QR code directly
// Format: QRcode::png('text', 'filename', 'error_correction', 'size', 'margin');
// We set filename to false to output directly to the browser.
QRcode::png($passCode, false, 'H', 10, 2);