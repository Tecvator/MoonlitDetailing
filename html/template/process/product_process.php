<?php
include "./../../../includes/session.php";


header("Content-Type: application/json");

$action = $_POST['action'] ?? '';

switch ($action) {
    case "fetch":
        $products = getProducts($conn);
        echo json_encode(["status" => "success", "data" => $products]);
        break;

    case "add":
        $name = trim($_POST['product_name']);
        $categoryId = intval($_POST['category_id']);
        $description = $_POST['description'] ?? '';
        $prices = $_POST['prices'] ?? [];

        if (empty($name) || empty($categoryId)) {
            echo json_encode(["status" => "error", "message" => "All fields required"]);
            exit;
        }

        if (addProduct($conn, $categoryId, $name, $description, $prices, $admin['id'])) {
            echo json_encode(["status" => "success", "message" => "Product added"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to add product"]);
        }
        break;

    case "edit":
        $id = intval($_POST['id']);
        $name = trim($_POST['product_name']);
        $categoryId = intval($_POST['category_id']);
        $description = $_POST['description'] ?? '';
        $prices = $_POST['prices'] ?? [];

        if (updateProduct($conn, $id, $categoryId, $name, $description, $prices)) {
            echo json_encode(["status" => "success", "message" => "Product updated"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Update failed"]);
        }
        break;

    case "delete":
        $id = intval($_POST['id']);
        if (deleteProduct($conn, $id)) {
            echo json_encode(["status" => "success", "message" => "Product deleted"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Delete failed"]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Invalid action"]);
}
