<?php
/**
 * Central Initialization File
 *
 * This file bootstraps the entire application by loading:
 * - Configuration
 * - Database connection
 * - All function libraries
 * - Site settings
 */

// ================================
// LOAD APPLICATION CONFIGURATION
// ================================
require_once __DIR__ . '/app.php';

// ================================
// LOAD DATABASE CONNECTION
// ================================
require_once __DIR__ . '/database.php';

// ================================
// LOAD ALL FUNCTION LIBRARIES
// ================================
require_once SRC_PATH . '/functions/tables.php';
require_once SRC_PATH . '/functions/admin_functions.php';
require_once SRC_PATH . '/functions/product_functions.php';
require_once SRC_PATH . '/functions/category_functions.php';
require_once SRC_PATH . '/functions/car_functions.php';
require_once SRC_PATH . '/functions/customer_functions.php';
require_once SRC_PATH . '/functions/booking_functions.php';

// ================================
// LOAD SITE INFORMATION FROM DATABASE
// ================================
$siteinfo = getSiteInfo($conn);
$sitebank = getSiteBank($conn);

// ================================
// VALIDATE SITE INFO
// ================================
if (!$siteinfo) {
    if (APP_DEBUG) {
        die("
            <div style='font-family: Arial; padding: 50px; text-align: center;'>
                <h1 style='color: #d32f2f;'>Configuration Error</h1>
                <p>No site information found in database.</p>
                <p style='color: #666;'>Please ensure the database is properly initialized.</p>
            </div>
        ");
    } else {
        error_log("Site information not found in database");
        die("Site configuration error. Please contact support.");
    }
}

// ================================
// APPLICATION READY
// ================================
// Uncomment for debugging
// error_log("Application initialized successfully");

?>

