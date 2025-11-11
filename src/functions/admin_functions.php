<?php
function getSiteInfo($conn) {
    $sql = "SELECT * FROM ".SITEINFO." ORDER BY id ASC LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return null; // no record found
    }
}
function getSiteBank($conn) {
    $sql = "SELECT * FROM ".BANKS." ORDER BY id ASC LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return null; // no record found
    }
}

function updateSiteInfo($conn, $data) {
    $stmt = $conn->prepare("UPDATE " . SITEINFO . " 
        SET site_name=?, site_email=?, site_phone=?, site_logo=?, site_address=?, site_state=?, site_city=?, site_currency=?, site_mileage_price=?, site_lon=?, site_lat=?
      , site_terms=?, site_note=?  WHERE id=1");
    $stmt->bind_param(
        "ssssssssissss",
        $data['site_name'],
        $data['site_email'],
        $data['site_phone'],
        $data['site_logo'],
        $data['site_address'],
        $data['site_state'],
        $data['site_city'],
        $data['site_currency'],
        $data['site_millage_price'],
        $data['site_lon'],
        $data['site_lat'],
        $data['site_terms'],
        $data['site_note'],
    );
    return $stmt->execute();
}


function loginAdmin($conn, $email, $password) {
    $sql = "SELECT * FROM ".ADMINS." WHERE email = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result && mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);

        // assuming password is hashed in DB
        if (password_verify($password, $admin['password'])) {
            return [
                "status" => "success",
                "message" => "Login successful",
                "admin" => $admin
            ];
        } else {
            return ["status" => "error", "message" => "Invalid password"];
        }
    }
    return ["status" => "error", "message" => "Admin not found"];
}

function getAdminInfo($conn) {
    session_start();

    if (isset($_SESSION['admin_id'])) {
        $adminId = $_SESSION['admin_id'];

        $sql = "SELECT * FROM ".ADMINS." WHERE id = ? LIMIT 1";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $adminId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
    }
    return false; // not logged in or invalid session
}



function getWorkingHours($conn) {
    $sql = "SELECT c.*, a.username 
            FROM ".WORKINGHOURS." c
            LEFT JOIN " . ADMINS . "  a ON c.added_by = a.id
            ORDER BY c.created_at DESC";
    $result = mysqli_query($conn, $sql);

    $working_hours = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $working_hours[] = $row;
        }
    }
    return $working_hours;
}
function updateWorkingHours($conn, $data) {
    $stmt = $conn->prepare("
        UPDATE " . WORKINGHOURS . " 
        SET open_time = ?, close_time = ? 
        WHERE id = ?
    ");
    $stmt->bind_param("ssi", $data['open_time'], $data['close_time'], $data['id']);
    return $stmt->execute();
}



function updateBankInfo($conn, $data) {
    $stmt = $conn->prepare("UPDATE " . BANKS . " 
        SET bank_name=?, account_number=?, account_name=?
        WHERE id=1");
    $stmt->bind_param(
        "sss",
        $data['bank'],
        $data['account'],
        $data['accountName'],
    
    );
    return $stmt->execute();
}
function updateAdminSignature($conn, $data) {
    $stmt = $conn->prepare("UPDATE " . ADMINS . " SET signature_url = ? WHERE id = ?");
    
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        return false;
    }

    $stmt->bind_param("si", $data['admin_signature'], $data['admin_id']);

    return $stmt->execute();
}


function updateAdminPass($conn, $data) {
    $stmt = $conn->prepare("UPDATE " . ADMINS . " SET password = ? WHERE id = ?");
    
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        return false;
    }

    $stmt->bind_param("si", $data['newpass'], $data['admin_id']);

    return $stmt->execute();
}


?>
