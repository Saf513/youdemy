<?php
// General settings
define('APP_NAME', 'Youdemy');
define('BASE_URL', '/'); // Change to your actual base URL if different

// File upload settings
define('UPLOAD_DIR', dirname(__DIR__) . '/public/uploads/');
define('COURSE_UPLOAD_DIR', UPLOAD_DIR . 'courses/');

// Security settings
define('CSRF_TOKEN_LENGTH', 32);

// Debugging (set to false in production)
define('DEBUG', true);

if (DEBUG) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}