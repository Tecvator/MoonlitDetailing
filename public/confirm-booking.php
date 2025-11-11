<?php
require_once __DIR__ . '/../src/config/init.php';
session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$apiUrl = "https://moonlit.trusttino.com/html/template/api.php?action=create_booking";

if (empty($_SESSION['booking_data'])) {
    echo json_encode(['status' => false, 'message' => 'No booking data found']);
    exit;
}

$bookingData = $_SESSION['booking_data'];

// Handle file upload
$fileField = $_FILES['receipt'] ?? null;
$postFields = $bookingData;

if ($fileField && $fileField['error'] === UPLOAD_ERR_OK) {
    $postFields['receipt'] = new CURLFile($fileField['tmp_name'], $fileField['type'], $fileField['name']);
}

// Send to main API
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);
$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(['status' => false, 'message' => curl_error($ch)]);
    curl_close($ch);
    exit;
}
curl_close($ch);

echo $response;
