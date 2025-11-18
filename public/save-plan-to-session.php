<?php
// Start session
session_start();

// Set header to return JSON
header('Content-Type: application/json');

// Get JSON data from request body
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Check if data was received
if ($data && is_array($data)) {
    
    // Validate that plan data exists
    if (!isset($data['planId']) || !isset($data['planName'])) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Plan information is missing'
        ]);
        exit();
    }
    
    // Check if booking data already exists in session
    if (isset($_SESSION['booking_data'])) {
        // Merge with existing booking data
        $_SESSION['booking_data'] = array_merge($_SESSION['booking_data'], $data);
    } else {
        // Create new booking data
        $_SESSION['booking_data'] = $data;
    }
    
    // Update timestamp
    $_SESSION['booking_timestamp'] = time();
    
    // Return success response
    echo json_encode([
        'success' => true,
        'message' => 'Plan selection saved successfully',
        'data' => $_SESSION['booking_data'],
        'session_id' => session_id()
    ]);
    
} else {
    // No data received or invalid format
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'No valid data received'
    ]);
}
?>