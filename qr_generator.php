<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include Composer's autoloader to access the library
require_once __DIR__ . '/vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;

// Get the pass code from the URL, with basic sanitization
$passCode = filter_input(INPUT_GET, 'data', FILTER_SANITIZE_STRING);

if (empty($passCode)) {
    // Exit if no data is provided
    http_response_code(400);
    exit('Error: No data provided for QR code generation.');
}

try {
    // Build the QR code
    $result = Builder::create()
        ->writer(new PngWriter())
        ->writerOptions([])
        ->data($passCode)
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel(ErrorCorrectionLevel::High)
        ->size(300)
        ->margin(10)
        ->build();

    // Output the QR code image directly to the browser
    header('Content-Type: '.$result->getMimeType());
    echo $result->getString();

} catch (Exception $e) {
    http_response_code(500);
    exit('Error generating QR code: ' . $e->getMessage());
}