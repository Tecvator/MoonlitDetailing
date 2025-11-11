<?php
include "./../../../includes/session.php";

header("Content-Type: application/json");

$action = $_POST['action'] ?? '';
switch ($action) {
    case "fetch":
        $customers = getCustomers($conn);
        echo json_encode(["status" => "success", "data" => $customers]);
        break;

    case "add":
        $name = trim($_POST['name']);
        $status = ($_POST['status'] === "1") ? "Active" : "Inactive";

        if (empty($name)) {
            echo json_encode(["status" => "error", "message" => "All fields required"]);
            exit;
        }

        if (addCarType($conn, $name, $status, $admin['id'])) {
            echo json_encode(["status" => "success", "message" => "Category added"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to add Car type "]);
        }
        break;

    case "edit":
        $id = intval($_POST['id']);
        $name = trim($_POST['name']);
        $status = ($_POST['status'] === "1") ? "Active" : "Inactive";
        
        if (updateCarType($conn, $id, $name, $status)) {
            echo json_encode(["status" => "success", "message" => "Car type updated"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Update failed"]);
        }
        break;

    case "delete":
        $id = intval($_POST['id']);
        if (deleteCarType($conn, $id)) {
            echo json_encode(["status" => "success", "message" => "Car type  deleted"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Delete failed"]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Invalid action"]);
}
