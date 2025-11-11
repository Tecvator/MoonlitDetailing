<?php
include "./../../../includes/session.php";
header("Content-Type: application/json");

$action = $_POST['action'] ?? '';

switch ($action) {

    case "add_booking":
        $car_type_id    = intval($_POST['car_type_id']);
        $product_id     = intval($_POST['product_id']);
        $frontend_price = floatval($_POST['price']); // frontend price (for reference)
        $location_type  = trim($_POST['location_type']);
        $customer_name  = trim($_POST['customer_name']);
        $carInfo = trim($_POST['car_make']);
        $customer_email = trim($_POST['customer_email']);
        $washing_time   = trim($_POST['selected_time']);
        $customer_phone = trim($_POST['customer_phone']);
        $customer_addr  = $_POST['customer_address'] ?? null;
        $washing_date   = $_POST['washing_date'];
        $payment_method = $_POST['payment_method'];
        $payment_status = $_POST['payment_status'] ?? "pending";
        $lat            = isset($_POST['site_lat']) ? floatval($_POST['site_lat']) : null;
        $lng            = isset($_POST['site_lon']) ? floatval($_POST['site_lon']) : null;

        // ✅ Validation
        if (empty($car_type_id) || empty($product_id) || empty($customer_name) || empty($washing_date)) {
            echo json_encode(["status" => "error", "message" => "Please fill all required fields"]);
            exit;
        }

        // ✅ Securely fetch base price from DB
        $verified_base_price = getProductPrice($conn, $car_type_id, $product_id);
        if ($verified_base_price <= 0) {
            echo json_encode(["status" => "error", "message" => "Invalid price for selected car type and product"]);
            exit;
        }

        // ✅ Get site info for mileage calculation
        $pricePerKm = $siteinfo['site_mileage_price'] ?? 4.76; // R4.76 per km (AA rate)
        $siteLat = isset($siteinfo['site_lat']) ? floatval($siteinfo['site_lat']) : null;
        $siteLng = isset($siteinfo['site_lon']) ? floatval($siteinfo['site_lon']) : null;
        $includedAmount = 60; // R60 already included in base price

        // ✅ Calculate total price including mileage
        $basePrice = floatval($verified_base_price);
        $totalPrice = $basePrice;
        $callout_fee = 0;
        $distance = 0;

        // Calculate callout fee if customer location is provided
        if ($lat && $lng && $siteLat && $siteLng && $pricePerKm > 0) {
            // Calculate one-way distance
            $distanceOneWay = haversineDistance($lat, $lng, $siteLat, $siteLng);
            
            // Calculate round trip distance (there and back)
            $distance = $distanceOneWay * 2;
            
            // Calculate mileage cost: (distance * rate) - R60 already included
            $mileageCost = ($distance * $pricePerKm) - $includedAmount;
            
            // Only add positive mileage costs (don't give discounts for close locations)
            if ($mileageCost > 0) {
                $callout_fee = $mileageCost;
                $totalPrice += $callout_fee;
            }
        }

        // ✅ Add or update customer
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

        // ✅ Record booking with callout fee
        if (addBooking(
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
            round($callout_fee, 2)  // Pass callout fee as separate parameter
            ,  $carInfo
        )) {
            echo json_encode([
                "status" => "success",
                "message" => "Booking recorded successfully",
                "base_price" => round($basePrice, 2),
                "callout_fee" => round($callout_fee, 2),
                "total_price" => round($totalPrice, 2),
                "distance_km" => round($distance, 2),
                "price_per_km" => $pricePerKm
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to record booking"]);
        }
        break;

    case "update_booking":
        $id = intval($_POST['id']);
        $car_type_id = intval($_POST['car_type_id']);
        $product_id  = intval($_POST['product_id']);
        $washing_date  = $_POST['washing_date'];
        $location_type = trim($_POST['location_type']);
        $payment_method = $_POST['payment_method'];
        $payment_status = $_POST['payment_status'];

        // Verify updated price
        $verified_price = getProductPrice($conn, $car_type_id, $product_id);
        if ($verified_price <= 0) {
            echo json_encode(["status" => "error", "message" => "Invalid price for selected car type and product"]);
            exit;
        }

        if (updateBooking($conn, $id, $car_type_id, $product_id, $verified_price, $location_type, $washing_date, $payment_method, $payment_status)) {
            echo json_encode(["status" => "success", "message" => "Booking updated successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Update failed"]);
        }
        break;

    case "delete_booking":
        $id = intval($_POST['id']);
        if (deleteBooking($conn, $id)) {
            echo json_encode(["status" => "success", "message" => "Booking deleted"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Delete failed"]);
        }
        break;

    case "fetch_booking":
        $id = intval($_POST['id']);
        $data = getBookingById($conn, $id);
        if ($data) {
            echo json_encode(["status" => "success", "data" => $data]);
        } else {
            echo json_encode(["status" => "error", "message" => "Booking not found"]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Invalid action"]);
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