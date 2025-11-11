<?php
include "./../../../includes/session.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oldPass       = $_POST['old_password'] ?? '';
    $newPass       = $_POST['new_password'] ?? '';
    $confirmNewPass = $_POST['confirm_password'] ?? ''; // corrected: use a different input name
    $adminID       = $admin['id'];
    $currentHash   = $admin['password']; // stored password hash from session or DB

    // ✅ 1. Basic validation
    if (empty($oldPass) || empty($newPass) || empty($confirmNewPass)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    if ($newPass !== $confirmNewPass) {
        echo json_encode(['success' => false, 'message' => 'New password and confirmation do not match.']);
        exit;
    }

    // ✅ 2. Verify old password
    if (!password_verify($oldPass, $currentHash)) {
        echo json_encode(['success' => false, 'message' => 'Old password is incorrect.']);
        exit;
    }

    // ✅ 3. Hash new password
    $hashedNewPass = password_hash($newPass, PASSWORD_DEFAULT);

    // ✅ 4. Prepare data and update
    $data = [
        'newpass'   => $hashedNewPass,
        'admin_id'  => $adminID
    ];

    $updated = updateAdminPass($conn, $data);

    echo json_encode([
        'success' => $updated,
        'message' => $updated ? 'Password updated successfully!' : 'Failed to update password.'
    ]);
}
?>
