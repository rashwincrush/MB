<?php
// Error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Error logging
ini_set('log_errors', 1);
ini_set('error_log', dirname(__DIR__) . '/error.log');

// Site Configuration
define('SITE_NAME', 'Your Organization Name');

// Environment Configuration
$is_production = $_SERVER['HTTP_HOST'] !== 'localhost';

if ($is_production) {
    // Production Settings
    define('BASE_URL', 'https://yourdomain.org');
    define('DB_HOST', 'localhost');
    define('DB_USER', 'your_production_username');
    define('DB_PASS', 'your_production_password');
    define('DB_NAME', 'your_production_database');
} else {
    // Local Development Settings
    define('BASE_URL', 'http://localhost:8080');
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', 'root');
    define('DB_NAME', 'your_local_database');
}

define('DB_PORT', 3306);

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set timezone
date_default_timezone_set('Asia/Kolkata');

// Create database connection
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Select the database
    if (!$conn->select_db(DB_NAME)) {
        throw new Exception("Error selecting database: " . $conn->error);
    }
    
} catch (Exception $e) {
    error_log("Database Error: " . $e->getMessage());
    if ($is_production) {
        die("We're experiencing technical difficulties. Please try again later.");
    } else {
        die("Database Error: " . $e->getMessage());
    }
}

// Helper Functions
function get_base_url() {
    return BASE_URL;
}

function redirect($path) {
    header("Location: " . BASE_URL . $path);
    exit;
}

function is_logged_in() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function require_login() {
    if (!is_logged_in()) {
        redirect('/admin/login.php');
    }
}
