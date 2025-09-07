<?php

// Generates a random 7-character alphanumeric string for the pass code.
// In a large-scale app, you'd also check the database to ensure it's truly unique.
function generate_pass_code() {
    $characters = '123456789ABCDEFGHJKLMNPQRSTUVWXYZ';
    $code = '';
    for ($i = 0; $i < 7; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $code;
}