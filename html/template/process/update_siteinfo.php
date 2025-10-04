<?php
include "./../../../includes/session.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = "uploads/"; // make sure this folder exists & is writable
    $logoPath = "";

    if (isset($_FILES['site_logo']) && $_FILES['site_logo']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['site_logo']['tmp_name'];
        $fileName = time() . "_" . basename($_FILES['site_logo']['name']);
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($tmpName, $targetFile)) {
            $logoPath = $targetFile;
        }
    } else {
        // if no file uploaded, keep old logo
        $result = mysqli_query($conn, "SELECT site_logo FROM ".SITEINFO." WHERE id=1");
        $row = mysqli_fetch_assoc($result);
        $logoPath = $row['site_logo'];
    }

    $data = [
        'site_name'   => $_POST['site_name'],
        'site_email'  => $_POST['site_email'],
        'site_phone'  => $_POST['site_phone'],
        'site_logo'   => $logoPath,
        'site_address'=> $_POST['site_address'],
        'site_state'  => $_POST['site_state'],
        'site_city'   => $_POST['site_city']
    ];

    $updated = updateSiteInfo($conn, $data);

    echo json_encode([
        'success' => $updated,
        'message' => $updated ? 'Company info updated successfully!' : 'Failed to update company info.'
    ]);
}
