<?php
// BOOKING FUNCTIONS

function getProductPrice($conn, $car_type_id, $product_id) {
    $query = "SELECT price FROM product_prices WHERE car_type_id=? AND product_id=? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $car_type_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        return floatval($row['price']);
    }
    return 0;
}

function addBooking($conn, $car_type_id, $product_id, $price, $location_type, $customer_id, $washing_date, $payment_method, $payment_status) {
    
       $booking_code = "INV-".rand(000000,999999)."-".rand(000000,999999);
    $query = "INSERT INTO bookings 
        (booking_id,car_type_id, product_id, price, location_type, customer_id, washing_date, payment_method, payment_status, created_at) 
        VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("siidsssss", $booking_code, $car_type_id, $product_id, $price, $location_type, $customer_id, $washing_date, $payment_method, $payment_status);
    return $stmt->execute();
}

function updateBooking($conn, $id, $car_type_id, $product_id, $price, $location_type, $washing_date, $payment_method, $payment_status) {
    $query = "UPDATE bookings 
              SET car_type_id=?, product_id=?, price=?, location_type=?, washing_date=?, payment_method=?, payment_status=?, updated_at=NOW() 
              WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iidssssi", $car_type_id, $product_id, $price, $location_type, $washing_date, $payment_method, $payment_status, $id);
    return $stmt->execute();
}

function deleteBooking($conn, $id) {
    $query = "DELETE FROM bookings WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}



function getAllBookings($conn) {
    $query = "
        SELECT 
            b.id,
            b.booking_id,
            b.car_type_id,
            ct.car_name AS car_type,
            b.product_id,
            p.product_name AS product_name,
            b.price,
            b.location_type,
            b.washing_date,
            b.payment_method,
            b.payment_status,
            b.created_at,
            c.name AS customer_name,
            c.email AS customer_email,
            c.phone AS customer_phone,
            c.address AS customer_address
        FROM bookings b
        LEFT JOIN customers c ON b.customer_id = c.id
        LEFT JOIN car_types ct ON b.car_type_id = ct.car_id
        LEFT JOIN products p ON b.product_id = p.id
        ORDER BY b.id DESC
    ";

    $result = $conn->query($query);
    $bookings = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $bookings[] = $row;
        }
    }

    return $bookings;
}

function getBookingById($conn, $id) {
    $query = "
        SELECT 
            b.id,
            b.booking_id,
            b.car_type_id,
            ct.car_name AS car_type,
            b.product_id,
            p.product_name AS product_name,
            b.price,
            b.location_type,
            b.washing_date,
            b.payment_method,
            b.payment_status,
            b.created_at,
            c.name AS customer_name,
            c.email AS customer_email,
            c.phone AS customer_phone,
            c.address AS customer_address
        FROM bookings b
        LEFT JOIN customers c ON b.customer_id = c.id
        LEFT JOIN car_types ct ON b.car_type_id = ct.car_id
        LEFT JOIN products p ON b.product_id = p.id
        WHERE b.id = ?
        LIMIT 1
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return null; // if no booking found
}


?>
