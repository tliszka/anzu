<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function is_user_logged_in() {
    return isset($_SESSION['user_id']);
}