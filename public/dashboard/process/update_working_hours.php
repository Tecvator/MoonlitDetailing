<?php
include "./../../../includes/session.php";


header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id']) || !is_array($_POST['id'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid data received.']);
        exit;
    }

    $successCount = 0;

    foreach ($_POST['id'] as $index => $id) {
        $data = [
            'id'         => (int)$id,
            'open_time'  => $_POST['open_time'][$index] ?? null,
            'close_time' => $_POST['close_time'][$index] ?? null
        ];

        if (updateWorkingHours($conn, $data)) {
            $successCount++;
        }
    }

    echo json_encode([
        'success' => true,
        'message' => "Updated working hours successfully."
    ]);
}
?>
