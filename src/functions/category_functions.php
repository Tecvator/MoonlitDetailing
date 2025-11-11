<?php
function getCategories($conn) {
    $sql = "SELECT c.*, a.username 
            FROM ".CAT." c
            LEFT JOIN " . ADMINS . "  a ON c.category_added_by = a.id
            ORDER BY c.created_at DESC";
    $result = mysqli_query($conn, $sql);

    $categories = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row;
        }
    }
    return $categories;
}

function addCategory($conn, $name, $status, $adminId) {
     $slug = "Cat-".rand(000000,999999);
    $sql = "INSERT INTO ".CAT." (category_name, category_unique_id, category_added_by, created_at, updated_at, status) 
            VALUES (?, ?, ?, NOW(), NOW(), ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssis", $name, $slug, $adminId, $status);
    return mysqli_stmt_execute($stmt);
}

function updateCategory($conn, $id, $name,  $status) {
    $sql = "UPDATE ".CAT." SET category_name=?,  status=?, updated_at=NOW() WHERE category_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $name, $status, $id);
    return mysqli_stmt_execute($stmt);
}

function deleteCategory($conn, $id) {
    $sql = "DELETE FROM ".CAT." WHERE category_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    return mysqli_stmt_execute($stmt);
}
?>
