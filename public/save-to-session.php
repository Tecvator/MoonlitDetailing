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
    
    // Validate required fields based on location type
    if (isset($data['locationType'])) {
        
        if ($data['locationType'] === 'myPlace') {
            // Validate myPlace data
            if (empty($data['address']) || empty($data['latitude']) || empty($data['longitude'])) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'Missing required address information'
                ]);
                exit();
            }
        }
        
        // Save to PHP session
        $_SESSION['booking_data'] = $data;
        $_SESSION['booking_timestamp'] = time();
        
        // Return success response
        echo json_encode([
            'success' => true,
            'message' => 'Booking data saved to session successfully',
            'data' => $data,
            'session_id' => session_id()
        ]);
        
    } else {
        // Missing location type
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Location type is required'
        ]);
    }
    
} else {
    // No data received or invalid format
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'No valid data received'
    ]);
}
?>