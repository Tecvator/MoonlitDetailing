<?php
require_once __DIR__ . "/../../../src/config/session.php";

header("Content-Type: application/json");

$action = $_POST['action'] ?? '';
switch ($action) {
    case "fetch":
        $categories = getCategories($conn);
        echo json_encode(["status" => "success", "data" => $categories]);
        break;

    case "add":
        $name = trim($_POST['name']);
        $status = ($_POST['status'] === "1") ? "Active" : "Inactive";

        if (empty($name)) {
            echo json_encode(["status" => "error", "message" => "All fields required"]);
            exit;
        }

        if (addCategory($conn, $name, $status, $admin['id'])) {
            echo json_encode(["status" => "success", "message" => "Category added"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to add category"]);
        }
        break;

    case "edit":
        $id = intval($_POST['id']);
        $name = trim($_POST['name']);
        $status = ($_POST['status'] === "1") ? "Active" : "Inactive";

        if (updateCategory($conn, $id, $name, $status)) {
            echo json_encode(["status" => "success", "message" => "Category updated"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Update failed"]);
        }
        break;

    case "delete":
        $id = intval($_POST['id']);
        if (deleteCategory($conn, $id)) {
            echo json_encode(["status" => "success", "message" => "Category deleted"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Delete failed"]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Invalid action"]);
}
