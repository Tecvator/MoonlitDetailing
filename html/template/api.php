<?php
include "../../includes/init.php";

// ✅ Allow cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Check action parameter
$action = $_GET['action'] ?? '';

// ✅ Handle actions cleanly
if ($action === 'get_site_info') {
    echo json_encode([
        "status" => true,
        "data" => [
            "name" => $siteinfo['site_name'],
            "logo" => $siteinfo['site_logo'],
            "state" => $siteinfo['site_state'],
            "address" => $siteinfo['site_address'],
            "city" => $siteinfo['site_city'],
            "mpkey" => $siteinfo['site_map_key'],
        ]
    ]);
} elseif ($action === 'get_cars') {
    $cars = getCarTypes($conn);
    echo json_encode([
        "status" => true,
        "data" => $cars
    ]);
} elseif ($action === 'get_categories') {
    $categories = getCategories($conn);
    echo json_encode([
        "status" => true,
        "data" => $categories
    ]);
} elseif ($action === 'get_products') {
    $carId = $_GET['carID'] ?? '';
    $products = getProductPlansTwo($conn, $carId);
    echo json_encode([
        "status" => true,
        "data" => $products,
    ]);
} elseif ($action === 'get_available_slots') {
    // ✅ Fetch POST parameters
    $productId   = intval($_GET['product_id'] ?? 0);
    $washingDate = trim($_GET['washingDate'] ?? '');

    if ($productId <= 0 || empty($washingDate)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
        exit;
    }

    try {
        // 1️⃣ Fetch product max_hours
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

        // Convert "2:30" → 150 mins
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

        // Parse open/close times to minutes
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
}  elseif ($action === 'get_price') {    
        $carTypeId = intval($_GET['car_type_id'] ?? 0);
        $productId = intval($_GET['product_id'] ?? 0);
        $lat       = isset($_GET['lat']) ? floatval($_GET['lat']) : null;
        $lng       = isset($_GET['lng']) ? floatval($_GET['lng']) : null;
        
$pricePerKm = $siteinfo['site_mileage_price'] ?? 4.76; // R4.76 per km (AA rate)
$siteLat = $siteinfo['site_lat'] ?? null;
$siteLng = $siteinfo['site_lon'] ?? null;
$includedAmount = 60; // R60 already included in base price

if ($carTypeId > 0 && $productId > 0) {
    // Fetch product base price
    $stmt = $conn->prepare("SELECT price FROM product_prices WHERE car_type_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $carTypeId, $productId);
    $stmt->execute();
    $stmt->bind_result($price);

    if ($stmt->fetch()) {
        $stmt->close();

        $basePrice = floatval($price);
        $totalPrice = $basePrice;
        $mileageCost = 0;
        $distance = 0;

        // If coordinates are provided, calculate distance and add mileage cost
        if ($lat && $lng && $siteLat && $siteLng && $pricePerKm > 0) {
            // Calculate one-way distance
            $distanceOneWay = haversineDistance($lat, $lng, $siteLat, $siteLng);
            
            // Calculate round trip distance (there and back)
            $distance = $distanceOneWay * 2;
            
            // Calculate mileage cost: (distance * rate) - R60 already included
            $mileageCost = ($distance * $pricePerKm) - $includedAmount;
            
            // Only add positive mileage costs (don't give discounts for close locations)
            if ($mileageCost > 0) {
                $totalPrice += $mileageCost;
            } else {
                $mileageCost = 0; // Don't show negative callout fees
            }
        }

        echo json_encode([
            'status' => true,
            'base_price' => $siteinfo['site_currency']." ". round($basePrice, 2),
            'total_price' => $siteinfo['site_currency']." ". round($totalPrice, 2),
            'price_per_km' => $pricePerKm,
            'callout_fee' => $siteinfo['site_currency']." ".round($mileageCost, 2),
            'distance_km' => round($distance, 2),
            'distance_one_way_km' => isset($distanceOneWay) ? round($distanceOneWay, 2) : 0,
            'included_amount' => $includedAmount
        ]);
    } else {
        $stmt->close();
        echo json_encode(['status' => 'error', 'message' => 'Price not found']);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
}


}else {
    echo json_encode([
        "status" => false,
        "message" => "Invalid request"
    ]);
}





/**
 * Calculate the distance between two coordinates using the Haversine formula
 * Returns distance in kilometers
 */
function haversineDistance($lat1, $lon1, $lat2, $lon2) {
    $earthRadius = 6371; // Earth radius in km

    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

    $a = sin($dLat / 2) * sin($dLat / 2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon / 2) * sin($dLon / 2);

    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return $earthRadius * $c; // distance in KM
}
?>