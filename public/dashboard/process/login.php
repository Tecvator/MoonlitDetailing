<?php
include "./../../../includes/init.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        echo json_encode(["status" => "error", "message" => "All fields required"]);
        exit;
    }

    $login = loginAdmin($conn, $email, $password);

    // start session if login success
    if ($login['status'] === 'success') {
        session_start();
        $_SESSION['admin_id'] = $login['admin']['id'];
    }

    echo json_encode($login);
}
?>
