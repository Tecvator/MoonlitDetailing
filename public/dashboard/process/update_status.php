<?php
include "./../../../includes/session.php";
header("Content-Type: application/json");

$action = $_POST['action'] ?? '';

switch ($action) {
    
    case "update_payment_status":
        $id = intval($_POST['id']);
        $status = trim($_POST['status']);
        
        // Validate status
        if (!in_array($status, ['paid', 'unpaid'])) {
            echo json_encode(["status" => "error", "message" => "Invalid payment status"]);
            exit;
        }
        
        // Update payment status
        $stmt = $conn->prepare("UPDATE bookings SET payment_status = ?, updated_at = NOW() WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        
        if ($stmt->execute()) {
            echo json_encode([
                "status" => "success", 
                "message" => "Payment status updated to " . ucfirst($status)
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update payment status"]);
        }
        $stmt->close();
        break;
        
    case "update_wash_status":
        $id = intval($_POST['id']);
        $status = trim($_POST['status']);
        
        // Validate status
        if (!in_array($status, ['pending', 'completed'])) {
            echo json_encode(["status" => "error", "message" => "Invalid wash status"]);
            exit;
        }
        
        // Update wash status
        $stmt = $conn->prepare("UPDATE bookings SET washing_status = ?, updated_at = NOW() WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        
        if ($stmt->execute()) {
            echo json_encode([
                "status" => "success", 
                "message" => "Wash status updated to " . ucfirst($status)
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update wash status"]);
        }
        $stmt->close();
        break;
        
    default:
        echo json_encode(["status" => "error", "message" => "Invalid action"]);
}
?>