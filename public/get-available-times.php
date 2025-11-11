<?php
   require_once('init.php');
   header('Content-Type: application/json');
$json = file_get_contents('php://input');
$data = json_decode($json, true);

   $productId   = intval($data['productId'] ?? 0);
    $washingDate = trim($data['date'] ?? '');

    if ($productId <= 0 || empty($washingDate)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
        exit;
    }


$avaliableSlotRequest = fetchFromApi("get_available_slots", ["product_id" => $productId, "washingDate"=> $washingDate]);
echo json_encode($avaliableSlotRequest);


?>