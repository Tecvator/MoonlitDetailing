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

// Transform site info for booking pages (they expect keys without 'site_' prefix)
$siteInfo = [];
if ($siteinfo) {
    $siteInfo = [
        'name' => $siteinfo['site_name'] ?? '',
        'logo' => $siteinfo['site_logo'] ?? '',
        'address' => $siteinfo['site_address'] ?? '',
        'email' => $siteinfo['site_email'] ?? '',
        'phone' => $siteinfo['site_phone'] ?? '',
        'city' => $siteinfo['site_city'] ?? '',
        'state' => $siteinfo['site_state'] ?? '',
        'currency' => $siteinfo['site_currency'] ?? 'R',
        'mileage_price' => $siteinfo['site_mileage_price'] ?? '4.76',
        'mpkey' => $siteinfo['site_map_key'] ?? '',
        'lat' => $siteinfo['site_lat'] ?? '',
        'lon' => $siteinfo['site_lon'] ?? '',
    ];
}

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
// HELPER FUNCTION FOR BOOKING PAGES
// ================================

/**
 * Fetch data from API endpoint
 *
 * This function is used by booking pages to get data from the API.
 * In the monolithic setup, it calls the local API.
 *
 * @param string $endpoint API action name
 * @param array $params Query parameters
 * @return array API response
 */
function fetchFromApi($endpoint, $params = [])
{
    // Use internal URL when called from server-side (Docker container)
    // External URL uses port 8080, but inside container Apache runs on port 80
    $baseUrl = 'http://localhost/dashboard/api.php';

    // Build full URL with query parameters
    $url = $baseUrl . "?action=" . urlencode($endpoint);
    if (!empty($params)) {
        $url .= "&" . http_build_query($params);
    }

    // Initialize cURL
    $ch = curl_init();

    // Set cURL options
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => false, // Disable SSL verification for local development
        CURLOPT_CONNECTTIMEOUT => 5,
    ]);

    // Execute request
    $response = curl_exec($ch);

    // Handle cURL errors
    if (curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);
        error_log("API call failed: $error");
        return [
            "status" => false,
            "message" => "Unable to fetch data. Please try again."
        ];
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Check HTTP response code
    if ($httpCode !== 200) {
        error_log("API returned HTTP $httpCode for endpoint: $endpoint");
        return [
            "status" => false,
            "message" => "Service temporarily unavailable."
        ];
    }

    // Decode and return JSON response
    $data = json_decode($response, true);

    if (is_array($data)) {
        return $data;
    }

    error_log("Invalid API response for endpoint: $endpoint");
    return [
        "status" => false,
        "message" => "Invalid response received."
    ];
}

// ================================
// APPLICATION READY
// ================================
// Uncomment for debugging
// error_log("Application initialized successfully");