<?php
require_once __DIR__ . "/../../../src/config/session.php";
$action = $_POST['action'] ?? '';

switch ($action) {
    case "fetch":
        $products = fetchAllProductFeatures($conn);
        echo json_encode(["status" => "success", "data" => $products]);
        break;

    case "add":
        $feature = trim($_POST['feature']);
        $feature_type = trim($_POST['feature_type']);
        $product_id = intval($_POST['product_id']);
      

        if (empty($feature) || empty($feature_type) || empty($product_id)) {
            echo json_encode(["status" => "error", "message" => "All fields required"]);
            exit;
        }

   

        if (addProductFeature($conn, $product_id, $feature_type, $feature )) {
            echo json_encode(["status" => "success", "message" => "Product Feature added"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to add product feature"]);
        }
        exit;
        break;

    case "edit":
        $id = intval($_POST['id']);
         $feature = trim($_POST['feature']);
      //  $feature_type = trim($_POST['feature_type']);
      //  $product_id = intval($_POST['product_id']);
      
       if (empty($feature)) {
            echo json_encode(["status" => "error", "message" => "All fields required"]);
            exit;
        }

        if (updateProductFeature($conn, $id, $feature)) {
            echo json_encode(["status" => "success", "message" => "Product Feature updated"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Update failed"]);
        }
        exit;
        break;

    case "delete":
        $id = intval($_POST['id']);
        if (deleteProductFeature($conn, $id)) {
            echo json_encode(["status" => "success", "message" => "Product Feature deleted"]);
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
