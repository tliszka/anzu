<?php

// Include Composer's autoloader to access the library
require_once __DIR__ . '/vendor/autoload.php';

// Import the necessary classes from the library
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\ErrorCorrectionLevel;

// Get the pass code from the URL
$passCode = $_GET['data'] ?? null;

if (empty($passCode)) {
    // Exit if no data is provided
    http_response_code(400);
    exit('Error: No data provided for QR code generation.');
}

try {
    // Create a new QR code object using the constructor
    $qrCode = new QrCode($passCode);

    // Set the options on the object
    $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::High);
    $qrCode->setSize(300);
    $qrCode->setMargin(10);

    // Create a writer to generate the PNG image
    $writer = new PngWriter();
    $result = $writer->write($qrCode);

    // Output the QR code image directly to the browser
    header('Content-Type: '.$result->getMimeType());
    echo $result->getString();

} catch (Exception $e) {
    http_response_code(500);
    exit('Error generating QR code: ' . $e->getMessage());
}