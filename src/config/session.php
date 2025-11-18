<?php
/**
 * Session & Authentication Handler
 *
 * This file ensures the user is authenticated before accessing protected pages
 */

// Load application initialization
require_once __DIR__ . '/init.php';

// ================================
// CHECK AUTHENTICATION
// ================================
$admin = getAdminInfo($conn);

if (!$admin) {
    // User is not authenticated - redirect to signin
    header("Location: " . APP_URL . "/dashboard/signin.php");
    exit();
}

// ================================
// SET ADMIN SESSION VARIABLES
// ================================
// Make admin info available to all pages
$_SESSION['admin_logged_in'] = true;
$_SESSION['admin_data'] = $admin;

?>

