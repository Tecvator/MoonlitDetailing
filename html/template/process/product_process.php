<?php
include "./../../../includes/session.php";
$action = $_POST['action'] ?? '';

switch ($action) {
    case "fetch":
        $products = getProducts($conn);
        echo json_encode(["status" => "success", "data" => $products]);
        break;

    case "add":
        $name = trim($_POST['product_name']);
        $max_hours = trim($_POST['product_hours']);
        $categoryId = intval($_POST['category_id']);
        $description = $_POST['description'] ?? '';
        $prices = $_POST['prices'] ?? [];

        if (empty($name) || empty($categoryId) || empty($max_hours)) {
            echo json_encode(["status" => "error", "message" => "All fields required"]);
            exit;
        }

        // Store as entered (e.g. "2:30" or "2")
        $maxHoursToSave = $max_hours;

        if (addProduct($conn, $categoryId, $name, $description, $prices, $maxHoursToSave, $admin['id'])) {
            echo json_encode(["status" => "success", "message" => "Product added"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to add product"]);
        }
        exit;
        break;

    case "edit":
        $id = intval($_POST['product_id']);
        $name = trim($_POST['product_name']);
        $categoryId = intval($_POST['category_id']);
        $description = $_POST['description'] ?? '';
        $prices = $_POST['prices'] ?? [];
        $max_hours = trim($_POST['product_hours']);

        // Store as entered (keep format like "2:30")
        $maxHoursToSave = $max_hours;

        if (updateProduct($conn, $id, $categoryId, $name, $description, $prices, $maxHoursToSave, $admin['id'])) {
            echo json_encode(["status" => "success", "message" => "Product updated"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Update failed"]);
        }
        exit;
        break;

    case "delete":
        $id = intval($_POST['id']);
        if (deleteProduct($conn, $id)) {
            echo json_encode(["status" => "success", "message" => "Product deleted"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Delete failed"]);
        }
        exit;
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Invalid action"]);
        exit;
}
?>
