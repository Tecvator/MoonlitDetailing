<?php
/**
 * Application Configuration
 *
 * Central configuration file for application-wide settings
 */

// ================================
// ENVIRONMENT SETTINGS
// ================================
define('APP_ENV', getenv('APP_ENV') ?: 'development');
define('APP_DEBUG', filter_var(getenv('APP_DEBUG'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? true);
define('APP_URL', getenv('APP_URL') ?: 'http://localhost:8080');

// ================================
// API SETTINGS
// ================================
define('API_BASE_URL', getenv('API_BASE_URL') ?: 'http://localhost:8080/dashboard/api.php');

// ================================
// PATH SETTINGS
// ================================
// Root directory (one level up from src)
define('ROOT_PATH', dirname(__DIR__, 2));

// Public directory (web accessible)
define('PUBLIC_PATH', ROOT_PATH . '/public');

// Source directory (not web accessible)
define('SRC_PATH', ROOT_PATH . '/src');

// Uploads directory
define('UPLOADS_PATH', PUBLIC_PATH . '/uploads');
define('UPLOADS_URL', APP_URL . '/uploads');

// ================================
// ERROR REPORTING
// ================================
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
} else {
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
    ini_set('log_errors', '1');
}

// ================================
// SESSION SETTINGS
// ================================
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', '1');
    ini_set('session.use_strict_mode', '1');

    // Set secure cookie only in production
    if (APP_ENV === 'production') {
        ini_set('session.cookie_secure', '1');
    }

    session_start();
}

// ================================
// TIMEZONE
// ================================
date_default_timezone_set('Africa/Johannesburg');

// ================================
// SITE SETTINGS (Loaded from Database)
// ================================
// These will be populated after database connection
$siteinfo = [];
$sitebank = [];

// ================================
// HELPER FUNCTIONS
// ================================

/**
 * Get asset URL
 *
 * @param string $path Path to asset (relative to public directory)
 * @return string Full URL to asset
 */
function asset($path) {
    return APP_URL . '/' . ltrim($path, '/');
}

/**
 * Redirect to URL
 *
 * @param string $url URL to redirect to
 * @param int $code HTTP status code
 */
function redirect($url, $code = 302) {
    header("Location: " . $url, true, $code);
    exit();
}

/**
 * Check if user is authenticated
 *
 * @return bool
 */
function isAuthenticated() {
    return isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']);
}

/**
 * Require authentication (redirect if not authenticated)
 *
 * @param string $redirect_url URL to redirect to if not authenticated
 */
function requireAuth($redirect_url = '/dashboard/signin.php') {
    if (!isAuthenticated()) {
        redirect($redirect_url);
    }
}

/**
 * Sanitize output for HTML
 *
 * @param string $string String to sanitize
 * @return string Sanitized string
 */
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Debug dump (only in development)
 *
 * @param mixed $data Data to dump
 */
function dd($data) {
    if (APP_ENV === 'development') {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        die();
    }
}

?>

