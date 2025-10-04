<?php

function cleanDescription($description) {
    // Extract only the content inside <div class="ql-editor"> ... </div>
    if (preg_match('/<div class="ql-editor"[^>]*>(.*?)<\/div>/is', $description, $matches)) {
        $description = $matches[1]; // keep only inner HTML
    }

    // Remove Quill extra attributes like class, style, aria-...
    $description = preg_replace('/\s?(class|style|role|aria-[a-z]+)="[^"]*"/i', '', $description);

    return trim($description);
}

function addProduct($conn, $categoryId, $name, $description, $prices, $admin) {
    try {
        $slug = "PROD-" . rand(100000, 999999);
        $description = cleanDescription($description);

        $stmt = $conn->prepare("INSERT INTO " . PRODUCTS . " 
            (product_unique_id, category_id, product_name, product_description, product_added_by) 
            VALUES (?,?,?,?,?)");
        $stmt->bind_param("sissi", $slug, $categoryId, $name, $description, $admin);
        $stmt->execute();
        $productId = $stmt->insert_id;
        $stmt->close();

        foreach ($prices as $carTypeId => $price) {
            if (!empty($price)) {
                $priceslug = "PRi-" . $carTypeId . rand(10000, 99999);
                $stmt = $conn->prepare("INSERT INTO product_prices 
                    (price_unique_id, product_id, car_type_id, price, price_added_by) 
                    VALUES (?,?,?,?,?)");
                $stmt->bind_param("siidi", $priceslug, $productId, $carTypeId, $price, $admin);
                $stmt->execute();
                $stmt->close();
            }
        }

        return true;
    } catch (Exception $e) {
        return false;
    }
}

function updateProduct($conn, $id, $categoryId, $name, $description, $prices, $admin) {
    try {
        $description = cleanDescription($description);

        $stmt = $conn->prepare("UPDATE " . PRODUCTS . " 
            SET category_id=?, product_name=?, product_description=? 
            WHERE id=?");
        $stmt->bind_param("issi", $categoryId, $name, $description, $id);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare("DELETE FROM product_prices WHERE product_id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        foreach ($prices as $carTypeId => $price) {
            if (!empty($price)) {
                $priceslug = "PRi-" . $carTypeId . rand(10000, 99999);
                $stmt = $conn->prepare("INSERT INTO product_prices 
                    (price_unique_id, product_id, car_type_id, price, price_added_by) 
                    VALUES (?,?,?,?,?)");
                $stmt->bind_param("siidi", $priceslug, $id, $carTypeId, $price, $admin);
                $stmt->execute();
                $stmt->close();
            }
        }

        return true;
    } catch (Exception $e) {
        return false;
    }
}

function deleteProduct($conn, $id) {
    try {
        $stmt = $conn->prepare("DELETE FROM product_prices WHERE product_id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare("DELETE FROM " . PRODUCTS . " WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    } catch (Exception $e) {
        return false;
    }
}

function getProducts($conn) {
    $sql = "SELECT p.id, p.product_name, p.product_description, p.product_unique_id, 
                   c.category_name AS category, a.username AS addedby
            FROM " . PRODUCTS . " p
            JOIN " . CAT . " c ON p.category_id = c.category_id 
            JOIN " . ADMINS . " a ON p.product_added_by = a.id
            ORDER BY p.id DESC";
    $result = $conn->query($sql);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

function getProductById($conn, $id) {
    $stmt = $conn->prepare("SELECT p.id, p.product_unique_id, p.product_name, p.product_description,
                                   p.category_id, c.category_name, a.username AS addedby
                            FROM " . PRODUCTS . " p
                            JOIN " . CAT . " c ON p.category_id = c.category_id
                            JOIN " . ADMINS . " a ON p.product_added_by = a.id
                            WHERE p.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();

    if ($product) {
        $stmt = $conn->prepare("SELECT car_type_id, price FROM product_prices WHERE product_id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $pricesResult = $stmt->get_result();
        $product['prices'] = $pricesResult->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    }

    return $product;
}
