<?php
// CUSTOMER FUNCTIONS

function addCustomer($conn, $name, $email, $phone, $address = null) {
    $query = "INSERT INTO customers (name, email, phone, address, created_at) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $name, $email, $phone, $address);
    return $stmt->execute();
}

function updateCustomer($conn, $id, $name, $email, $phone, $address = null) {
    $query = "UPDATE customers SET name=?, email=?, phone=?, address=?, updated_at=NOW() WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $name, $email, $phone, $address, $id);
    return $stmt->execute();
}

function deleteCustomer($conn, $id) {
    $query = "DELETE FROM customers WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function getCustomerById($conn, $id) {
    $query = "SELECT * FROM customers WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}
?>
