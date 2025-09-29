<?php
function getCarTypes($conn) {
    $sql = "SELECT c.*, a.username 
            FROM ".CARTYPE." c
            LEFT JOIN ADMINS a ON c.car_added_by = a.id
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
