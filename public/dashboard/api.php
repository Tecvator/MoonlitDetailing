<?php
require_once __DIR__ . '/../../src/config/init.php';

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
            "site_bank" =>  $sitebank
        ]
    ]);
} elseif ($action === 'get_cars') {
    $cars = getCarTypes($conn);
    echo json_encode([
        "status" => true,
        "data" => $cars
    ]);
} elseif ($action === 'get_booking') {
    $bookingId = $_GET['booking_id'] ?? '';

    if (empty($bookingId)) {
        echo json_encode([
            "status" => false,
            "message" => "Missing booking ID"
        ]);
        exit;
    }

    try {
        // ✅ Prepare query (join bookings + customers + product + car_type)
        $stmt = $conn->prepare("
            SELECT
                b.booking_id,
                b.washing_date,
                b.washing_time,
                b.payment_method,
                b.payment_status,
                b.price,
                b.callout_fee,
                b.location_type,
                b.car_info,
                b.payment_receipt,
                b.created_at,

                c.name AS customer_name,
                c.email AS customer_email,
                c.phone AS customer_phone,
                c.address AS customer_address,

                p.product_name AS plan_name,
                p.product_description AS plan_description,

                ct.car_name AS car_type
            FROM bookings b
            LEFT JOIN customers c ON b.customer_id = c.id
            LEFT JOIN products p ON b.product_id = p.id
            LEFT JOIN car_types ct ON b.car_type_id = ct.car_id
            WHERE b.booking_id = ?
            LIMIT 1
        ");

        $stmt->bind_param("s", $bookingId);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res && $row = $res->fetch_assoc()) {
            echo json_encode([
                "status" => true,
                "message" => "Booking fetched successfully",
                "data" => [
                    "booking_id" => $row['booking_id'],
                    "washing_date" => $row['washing_date'],
                    "washing_time" => $row['washing_time'],
                    "payment_method" => $row['payment_method'],
                    "payment_status" => $row['payment_status'],
                    "base_price" => $row['price'],
                    "callout_fee" => $row['callout_fee'],
                    "total_price" => floatval($row['price']) + floatval($row['callout_fee']),
                    "location_type" => $row['location_type'],
                    "car_info" => $row['car_info'],
                    "payment_receipt" => $row['payment_receipt'],
                    "created_at" => $row['created_at'],

                    "customer" => [
                        "name" => $row['customer_name'],
                        "email" => $row['customer_email'],
                        "phone" => $row['customer_phone'],
                        "address" => $row['customer_address'],
                    ],

                    "plan" => [
                        "name" => $row['plan_name'],
                        "description" => $row['plan_description'],
                    ],

                    "car_type" => $row['car_type'],
                ]
            ]);
        } else {
            echo json_encode([
                "status" => false,
                "message" => "Booking not found"
            ]);
        }

        $stmt->close();
    } catch (Exception $e) {
        echo json_encode([
            "status" => false,
            "message" => "Server error: " . $e->getMessage()
        ]);
    }
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
            'booked_times' => array_map(function ($t) {
                $h = floor($t / 60);
                $m = $t % 60;
                return sprintf("%02d:%02d", $h, $m);
            }, $bookedTimes)
        ]);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()]);
    }
} elseif ($action === 'get_price') {
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
                'base_price' => $siteinfo['site_currency'] . " " . round($basePrice, 2),
                'total_price' => $siteinfo['site_currency'] . " " . round($totalPrice, 2),
                'price_per_km' => $pricePerKm,
                'callout_fee' => $siteinfo['site_currency'] . " " . round($mileageCost, 2),
                'callout_fee' => $siteinfo['site_currency'] . " " . round($mileageCost, 2),
                'callout_fee_amt' => round($mileageCost, 2),

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
} // ================================
// ✅ BOOKING CREATION HANDLER
// ================================
elseif ($action === 'create_booking') {
    addBookingApi($conn);
} else {
    echo json_encode([
        "status" => false,
        "message" => "Invalid request"
    ]);
}





/**
 * Calculate the distance between two coordinates using the Haversine formula
 * Returns distance in kilometers
 */
function haversineDistance($lat1, $lon1, $lat2, $lon2)
{
    $earthRadius = 6371; // Earth radius in km

    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

    $a = sin($dLat / 2) * sin($dLat / 2) +
        cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
        sin($dLon / 2) * sin($dLon / 2);

    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return $earthRadius * $c; // distance in KM
}

function addBookingApi($conn)
{
    header("Content-Type: application/json");

    // Collect POST data
    $input = $_POST;
    $receiptFile = $_FILES['receipt'] ?? null;

    // Validate required fields
    $required = [
        'carId',
        'planId',
        'planPrice',
        'locationType',
        'username',
        'email',
        'phoneNumber',
        'bookingDate',
        'paymentMethod',
        'bookingTime'
    ];
    foreach ($required as $field) {
        if (empty($input[$field])) {
            echo json_encode(['status' => false, 'message' => "Missing required field: $field"]);
            return;
        }
    }

    // Handle file upload
    $receiptPath = null;
    if ($receiptFile && $receiptFile['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/uploads/receipts/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $fileName = time() . '_' . basename($receiptFile['name']);
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($receiptFile['tmp_name'], $filePath)) {
            $receiptPath = 'uploads/receipts/' . $fileName;
        }
    }

    // Basic info
    $car_type_id    = intval($input['carId']);
    $product_id     = intval($input['planId']);
    $basePrice      = floatval($input['planPrice']);
    $location_type  = (trim($input['locationType']) == 'myPlace') ? 'customer' : 'moonlit';

    $customer_name  = trim($input['username']);
    $customer_email = trim($input['email']);
    $customer_phone = trim($input['phoneNumber']);
    $customer_addr  = $input['address'] ?? null;
    $washing_date   = $input['bookingDate'];
    $payment_method = $input['paymentMethod'];
    $washing_time   = trim($input['bookingTime']);
    $payment_status = $input['payment_status'] ?? 'pending';
    $carInfo        = $input['carMake'] ?? '';
    $lat            = isset($input['latitude']) ? floatval($input['latitude']) : null;
    $lng            = isset($input['longitude']) ? floatval($input['longitude']) : null;

    // ✅ Get verified base price
    $verified_base_price = getProductPrice($conn, $car_type_id, $product_id);
    if ($verified_base_price <= 0) {
        echo json_encode(["status" => false, "message" => "Invalid price for selected car type and product"]);
        return;
    }

    // ✅ Calculate callout fee
    global $siteinfo;
    $pricePerKm = $siteinfo['site_mileage_price'] ?? 4.76;
    $siteLat = isset($siteinfo['site_lat']) ? floatval($siteinfo['site_lat']) : null;
    $siteLng = isset($siteinfo['site_lon']) ? floatval($siteinfo['site_lon']) : null;
    $includedAmount = 60;
    $basePrice = floatval($verified_base_price);
    $totalPrice = $basePrice;
    $callout_fee = 0;
    $distance = 0;

    if ($lat && $lng && $siteLat && $siteLng && $pricePerKm > 0) {
        $distanceOneWay = haversineDistance($lat, $lng, $siteLat, $siteLng);
        $distance = $distanceOneWay * 2;
        $mileageCost = ($distance * $pricePerKm) - $includedAmount;

        if ($mileageCost > 0) {
            $callout_fee = $mileageCost;
            $totalPrice += $callout_fee;
        }
    }

    // ✅ Check if customer exists
    $checkQuery = $conn->prepare("SELECT id FROM customers WHERE email=? OR phone=? LIMIT 1");
    $checkQuery->bind_param("ss", $customer_email, $customer_phone);
    $checkQuery->execute();
    $result = $checkQuery->get_result();
    $customer = $result->fetch_assoc();

    if ($customer) {
        $customer_id = $customer['id'];
        updateCustomer($conn, $customer_id, $customer_name, $customer_email, $customer_phone, $customer_addr);
    } else {
        addCustomer($conn, $customer_name, $customer_email, $customer_phone, $customer_addr);
        $customer_id = $conn->insert_id;
    }

    // ✅ Add booking
    $bookingAdded = addBooking(
        $conn,
        $car_type_id,
        $product_id,
        round($basePrice, 2),
        $location_type,
        $customer_id,
        $washing_date,
        $payment_method,
        $payment_status,
        $washing_time,
        round($callout_fee, 2),
        $carInfo
    );

    if ($bookingAdded) {

        // ✅ Get the booking ID from last inserted booking
        $stmt = $conn->prepare("SELECT booking_id FROM bookings WHERE customer_id=? ORDER BY id DESC LIMIT 1");
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $latest_booking_id = null;
        if ($res && $row = $res->fetch_assoc()) {
            $latest_booking_id = $row['booking_id'];
        }
        $stmt->close();

        // ✅ Update receipt if uploaded
        if ($receiptPath && $latest_booking_id) {
            $stmt = $conn->prepare("UPDATE bookings SET payment_receipt=? WHERE booking_id=?");
            $stmt->bind_param("ss", $receiptPath, $latest_booking_id);
            $stmt->execute();
            $stmt->close();
        }

        // ✅ Return booking ID in response
        echo json_encode([
            "status" => true,
            "message" => "Booking recorded successfully",
            "booking_id" => $latest_booking_id,
            "base_price" => round($basePrice, 2),
            "callout_fee" => round($callout_fee, 2),
            "total_price" => round($totalPrice, 2),
            "distance_km" => round($distance, 2),
            "price_per_km" => $pricePerKm,
            "receipt" => $receiptPath
        ]);
    } else {
        echo json_encode(["status" => false, "message" => "Failed to record booking"]);
    }
}
