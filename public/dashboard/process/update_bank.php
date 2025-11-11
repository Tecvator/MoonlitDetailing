<?php
include "./../../../includes/session.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bank = $_POST['bank_name'];
    $accountNumber = $_POST['account_number'];
    $accountName = $_POST['account_name'];

    $data = [
        'bank'   =>  $bank,
        'account'   =>  $accountNumber,
        'accountName'   => $accountName
    ];

         $updated = updateBankInfo($conn, $data);

    echo json_encode([
        'success' => $updated,
        'message' => $updated ? 'Bank info updated successfully!' : 'Failed to update bank info.'
    ]);
}
