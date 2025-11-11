<?php
include "./../../../includes/session.php";
header('Content-Type: application/json');

$productId   = intval($_POST['product_id'] ?? 0);
$washingDate = trim($_POST['washingDate'] ?? '');

if ($productId <= 0 || empty($washingDate)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
    exit;
}

try {
    // 1️⃣ Fetch product max_hours (can be like "2:30" or "2")
    $stmt = $conn->prepare("SELECT max_hours FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if (!$product) {
        echo json_encode(['status' => 'error', 'message' => 'Product not found']);
        exit;
    }

    $maxHoursStr = trim($product['max_hours']);

    // 🕒 Convert "2:30" → 150 mins (2 * 60 + 30)
    if (strpos($maxHoursStr, ':') !== false) {
        [$h, $m] = array_map('intval', explode(':', $maxHoursStr));
        $maxMinutes = $h * 60 + $m;
    } else {
        $maxMinutes = floatval($maxHoursStr) * 60;
    }

    // 2️⃣ Determine weekday name
    $dayName = strtolower(date('l', strtotime($washingDate)));

    // 3️⃣ Fetch working hours for that day
    $stmt = $conn->prepare("SELECT open_time, close_time FROM working_hours WHERE day = ?");
    $stmt->bind_param("s", $dayName);
    $stmt->execute();
    $result = $stmt->get_result();
    $workingHours = $result->fetch_assoc();

    if (!$workingHours || empty($workingHours['open_time']) || empty($workingHours['close_time'])) {
        echo json_encode(['status' => 'error', 'message' => 'No working hours found for this day']);
        exit;
    }

    // Parse open/close times to minutes since midnight
    $openParts  = explode(':', (string)$workingHours['open_time']);
    $closeParts = explode(':', (string)$workingHours['close_time']);

    $openMinutes  = intval($openParts[0]) * 60 + intval($openParts[1]);
    $closeMinutes = intval($closeParts[0]) * 60 + intval($closeParts[1]);

    // 4️⃣ Fetch already booked times
    $stmt = $conn->prepare("SELECT washing_time FROM bookings WHERE washing_date = ?");
    $stmt->bind_param("s", $washingDate);
    $stmt->execute();
    $bookedResult = $stmt->get_result();

    $bookedTimes = [];
    while ($row = $bookedResult->fetch_assoc()) {
        if (!empty($row['washing_time'])) {
            $parts = explode(':', (string)$row['washing_time']);
            $bookedTimes[] = intval($parts[0]) * 60 + intval($parts[1]);
        }
    }

    // 5️⃣ Generate available slots
    $availableTimes = [];
    for ($time = $openMinutes; $time + $maxMinutes <= $closeMinutes; $time += $maxMinutes) {
        if (!in_array($time, $bookedTimes)) {
            $hour = floor($time / 60);
            $minute = $time % 60;
            $availableTimes[] = sprintf("%02d:%02d", $hour, $minute);
        }
    }

    echo json_encode([
        'status' => 'success',
        'message' => 'Available times fetched successfully',
        'available_times' => $availableTimes,
        'booked_times' => array_map(function($t) {
            $h = floor($t / 60);
            $m = $t % 60;
            return sprintf("%02d:%02d", $h, $m);
        }, $bookedTimes)
    ]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()]);
}
