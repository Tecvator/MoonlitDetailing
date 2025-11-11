<?php
include "./../../../includes/session.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = "uploads/"; // make sure this folder exists & is writable
    $logoPath = "";
    $adminID =  $admin['id'];
    if (isset($_FILES['admin_signature']) && $_FILES['admin_signature']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['admin_signature']['tmp_name'];
        $fileName = time() . "_" . basename($_FILES['admin_signature']['name']);
        $targetFile = $uploadDir . $fileName;
       $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];

// Automatically detect the current directory relative to the web root
$currentDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');

// Build the base URL dynamically
$baseUrl = $protocol . "://" . $host . $currentDir . "/";


        if (move_uploaded_file($tmpName, $targetFile)) {
            $logoPath = $targetFile;

        }
    } else {
        // if no file uploaded, keep old logo
        $result = mysqli_query($conn, "SELECT signature_url FROM ".ADMINS." WHERE id=". $adminID."");
        $row = mysqli_fetch_assoc($result);
        $baseUrl ="";

        $logoPath = $row['admin_signature'];
    }

    $data = [
        'admin_signature'   => $baseUrl .$logoPath,
        'admin_id' => $adminID
    ];

    $updated = updateAdminSignature($conn, $data);

    echo json_encode([
        'success' => $updated,
        'message' => $updated ? 'Signature updated successfully!' : 'Failed to update signatuure.'
    ]);
}
