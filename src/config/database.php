<?php
/**
 * Database Configuration
 *
 * This file handles database connection using environment variables
 * for better security and environment flexibility.
 */

// ================================
// GET ENVIRONMENT VARIABLES
// ================================
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_name = getenv('DB_NAME') ?: 'moonlit';
$db_user = getenv('DB_USER') ?: 'root';
$db_password = getenv('DB_PASSWORD') ?: '';
$db_port = getenv('DB_PORT') ?: '3306';

// ================================
// CREATE DATABASE CONNECTION
// ================================
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name, $db_port);

// ================================
// CHECK CONNECTION
// ================================
if (!$conn) {
    // Log the error (don't expose details to users)
    error_log("Database connection failed: " . mysqli_connect_error());

    // Display generic error message
    die("
        <div style='font-family: Arial; padding: 50px; text-align: center;'>
            <h1 style='color: #d32f2f;'>Database Connection Error</h1>
            <p>Unable to connect to the database. Please try again later.</p>
            <p style='color: #666; font-size: 12px;'>Error details have been logged.</p>
        </div>
    ");
}

// ================================
// SET CHARACTER SET
// ================================
mysqli_set_charset($conn, "utf8mb4");

// ================================
// OPTIONAL: SET TIMEZONE
// ================================
mysqli_query($conn, "SET time_zone = '+02:00'"); // South Africa timezone (SAST)

// ================================
// CONNECTION ESTABLISHED
// ================================
// Uncomment for debugging (remove in production)
// error_log("Database connected successfully to: {$db_name} on {$db_host}");

?>

