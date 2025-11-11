<?php
function getCarTypes($conn) {
    $sql = "SELECT c.*, a.username 
            FROM ".CARTYPE." c
            LEFT JOIN " . ADMINS . "  a ON c.car_added_by = a.id
            ORDER BY c.created_at DESC";
    $result = mysqli_query($conn, $sql);

    $categories = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row;
        }
    }
    return $categories;
}
function getCustomers($conn) {
    $sql = "SELECT * FROM ".CUSTOMERS." ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);

    $customers = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $customers[] = $row;
        }
    }
    return $customers;
}
function getCarTypesWithPrices($conn) {
    // Fetch all car types and the admin who added them
    $sql = "SELECT c.*, a.username 
            FROM " . CARTYPE . " c
            LEFT JOIN " . ADMINS . " a ON c.car_added_by = a.id
            ORDER BY c.created_at DESC";

    $result = mysqli_query($conn, $sql);
    $carTypes = [];

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $carTypeId = $row['car_id'];

            // Fetch all prices linked to this car type
            $priceQuery = "
                SELECT p.id, p.price_unique_id, p.product_id, p.car_type_id, p.price, pr.product_name 
                FROM product_prices p
                LEFT JOIN " . PRODUCTS . " pr ON p.product_id = pr.id
                WHERE p.car_type_id = ?
            ";

            $stmt = $conn->prepare($priceQuery);
            $stmt->bind_param("i", $carTypeId);
            $stmt->execute();
            $priceResult = $stmt->get_result();

            $prices = [];
            while ($priceRow = $priceResult->fetch_assoc()) {
                $prices[] = $priceRow;
            }
            $stmt->close();

            // Attach prices to this car type
            $row['prices'] = $prices;
            $carTypes[] = $row;
        }
    }

    return $carTypes;
}


function addCarType($conn, $name, $status, $adminId) {
     $slug = "Car-".rand(000000,999999);
    $sql = "INSERT INTO ".CARTYPE." (car_name, car_uniqe_id, car_added_by, created_at, updated_at, status) 
            VALUES (?, ?, ?, NOW(), NOW(), ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssis", $name, $slug, $adminId, $status);
    return mysqli_stmt_execute($stmt);
}

function updateCarType($conn, $id, $name,  $status) {
    $sql = "UPDATE ".CARTYPE." SET car_name=?,  status=?, updated_at=NOW() WHERE car_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $name, $status, $id);
    return mysqli_stmt_execute($stmt);
}

function deleteCarType($conn, $id) {
    $sql = "DELETE FROM ".CARTYPE." WHERE car_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    return mysqli_stmt_execute($stmt);
}
?>
