<?php
include "./../../../includes/session.php";
header('Content-Type: application/json');

$carTypeId = intval($_POST['car_type_id'] ?? 0);
$productId = intval($_POST['product_id'] ?? 0);
$lat       = isset($_POST['lat']) ? floatval($_POST['lat']) : null;
$lng       = isset($_POST['lng']) ? floatval($_POST['lng']) : null;

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
            'status' => 'success',
            'base_price' => round($basePrice, 2),
            'total_price' => round($totalPrice, 2),
            'price_per_km' => $pricePerKm,
            'callout_fee' => round($mileageCost, 2),
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