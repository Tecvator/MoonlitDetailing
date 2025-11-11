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

function addProduct($conn, $categoryId, $name, $description, $prices,  $max_hours, $admin) {
    try {
        $slug = "PROD-" . rand(100000, 999999);
        $description = cleanDescription($description);

        $stmt = $conn->prepare("INSERT INTO " . PRODUCTS . " 
            (product_unique_id, category_id, product_name, product_description, product_added_by,  max_hours) 
            VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("sissis", $slug, $categoryId, $name, $description, $admin,  $max_hours);
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
        print_r($e);
        return false;
    }
}
function addProductFeature($conn, $productId, $featureType, $feature) {
    try {
        // Determine which column should be true
        $isInterior = ($featureType === 'interior') ? 1 : 0;
        $isExterior = ($featureType === 'exterior') ? 1 : 0;
        $isLimited  = ($featureType === 'limited') ? 1 : 0;
        $isIncluded = ($featureType === 'inclusive') ? 1 : 0;

        // Prepare SQL query
        $stmt = $conn->prepare("
            INSERT INTO " . PRODUCTFEATURES . " 
            (product_id, feature, is_interior, is_exterior, is_limited, is_included, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())
        ");

        $stmt->bind_param(
            "ssiiii",
            $productId,
            $feature,
            $isInterior,
            $isExterior,
            $isLimited,
            $isIncluded
        );

        $stmt->execute();
        $stmt->close();

        return true;
    } catch (Exception $e) {
        error_log("Error adding product feature: " . $e->getMessage());
        return false;
    }
}
function fetchAllProductFeatures($conn, $productId = null) {
    try {
        $query = "
            SELECT 
                pf.*, 
                p.id AS product_id, 
                p.product_name 
            FROM " . PRODUCTFEATURES . " pf
            JOIN " . PRODUCTS . " p 
                ON pf.product_id = p.id
        ";

        // Optional filter for a specific product
        if ($productId) {
            $query .= " WHERE pf.product_id = ?";
        }

        $query .= " ORDER BY pf.created_at DESC";

        $stmt = $conn->prepare($query);

        if ($productId) {
            $stmt->bind_param("i", $productId);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $features = [];
        while ($row = $result->fetch_assoc()) {
            $features[] = $row;
        }

        $stmt->close();
        return $features;
    } catch (Exception $e) {
        error_log("Error fetching all product features: " . $e->getMessage());
        return [];
    }
}

function updateProductFeature($conn, $id, $feature) {
    try {
        $featureType = 'a';
        $isInterior = ($featureType === 'interior') ? 1 : 0;
        $isExterior = ($featureType === 'exterior') ? 1 : 0;
        $isLimited  = ($featureType === 'limited') ? 1 : 0;
        $isIncluded = ($featureType === 'inclusive') ? 1 : 0;

        $stmt = $conn->prepare("
            UPDATE " . PRODUCTFEATURES . " 
            SET feature = ?, 
                updated_at = NOW()
            WHERE id = ?
        ");

        $stmt->bind_param("si", $feature, $id);
        $stmt->execute();
        $stmt->close();

        return true;
    } catch (Exception $e) {
        error_log("Error updating product feature: " . $e->getMessage());
        return false;
    }
}

function deleteProductFeature($conn, $id) {
    try {
        $stmt = $conn->prepare("DELETE FROM " . PRODUCTFEATURES . " WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        return true;
    } catch (Exception $e) {
        error_log("Error deleting product feature: " . $e->getMessage());
        return false;
    }
}

function fetchProductFeatureById($conn, $id) {
    try {
        $stmt = $conn->prepare("
            SELECT 
                pf.*, 
                p.id AS product_id, 
                p.product_name 
            FROM " . PRODUCTFEATURES . " pf
            JOIN " . PRODUCTS . " p 
                ON pf.product_id = p.id
            WHERE pf.id = ?
            LIMIT 1
        ");

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $feature = $result->fetch_assoc();
        $stmt->close();

        return $feature ?: null;
    } catch (Exception $e) {
        error_log('Error fetching product feature by ID: ' . $e->getMessage());
        return null;
    }
}



function updateProduct($conn, $id, $categoryId, $name, $description, $prices,  $max_hours, $admin) {
    try {
        $description = cleanDescription($description);

        $stmt = $conn->prepare("UPDATE " . PRODUCTS . " 
            SET category_id=?, product_name=?, product_description=? ,  max_hours = ?
            WHERE id=?");
        $stmt->bind_param("isssi", $categoryId, $name, $description, $max_hours,  $id);
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
    $stmt = $conn->prepare("SELECT p.id, p.product_unique_id, p.product_name, p.max_hours,  p.product_description,
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

function getFeatureType($featureRow) {
    if ($featureRow['is_interior']) return "interior";
    if ($featureRow['is_exterior']) return "exterior";
    if ($featureRow['is_limited']) return "limited";
    if ($featureRow['is_included']) return "inclusive";
    return "unknown";
}

function getProductPlans($conn) {
    // Step 1: Fetch all products
    $sql = "SELECT 
                p.id AS product_id,
                p.product_name,
                p.product_description,
                p.product_unique_id,
                p.max_hours,
                c.category_name AS category,
                a.username AS added_by
            FROM " . PRODUCTS . " p
            JOIN " . CAT . " c ON p.category_id = c.category_id 
            JOIN " . ADMINS . " a ON p.product_added_by = a.id
            ORDER BY p.id DESC";

    $result = $conn->query($sql);

    if (!$result || $result->num_rows === 0) {
        return [];
    }

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $productId = (int) $row['product_id'];

        /* ------------------------------
           STEP 2: FETCH FEATURES
        ------------------------------ */
        $features = [];
        $featureQuery = "
            SELECT 
                feature,
                is_interior,
                is_exterior,
                is_limited,
                is_included
            FROM " . PRODUCTFEATURES . "
            WHERE product_id = ?
            ORDER BY id ASC
        ";

        $stmt = $conn->prepare($featureQuery);
        if ($stmt) {
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $featureResult = $stmt->get_result();

            while ($f = $featureResult->fetch_assoc()) {
                $features[] = [
                    "feature" => $f['feature'],
                    "type" => getFeatureType($f)
                ];
            }

            $stmt->close();
        }

        /* ------------------------------
           STEP 3: FETCH PRICES
        ------------------------------ */
        $prices = [];
        $priceQuery = "
            SELECT 
                pp.car_type_id, 
                ct.car_name, 
                pp.price
            FROM product_prices pp
            JOIN car_types ct ON pp.car_type_id = ct.car_id
            WHERE pp.product_id = ?
            ORDER BY ct.car_name ASC
        ";

        $stmt = $conn->prepare($priceQuery);
        if ($stmt) {
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $priceResult = $stmt->get_result();

            while ($p = $priceResult->fetch_assoc()) {
                $prices[] = [
                    "car_id" => $p['car_type_id'],
                    "car_name" => $p['car_name'],
                    "price" => $p['price']
                ];
            }

            $stmt->close();
        }

        /* ------------------------------
           STEP 4: COMBINE EVERYTHING
        ------------------------------ */
        $row['features'] = $features;
        $row['prices'] = $prices;
        $products[] = $row;
    }

    return $products;
}


function getProductPlansTwo($conn, $carId) {
    // Step 1: Fetch all products
    $sql = "SELECT 
                p.id AS product_id,
                p.product_name,
                p.product_description,
                p.product_unique_id,
                p.max_hours,
                c.category_name AS category,
                c.category_id AS categoryID,
                a.username AS added_by
            FROM " . PRODUCTS . " p
            JOIN " . CAT . " c ON p.category_id = c.category_id 
            JOIN " . ADMINS . " a ON p.product_added_by = a.id
            ORDER BY p.id DESC";

    $result = $conn->query($sql);

    if (!$result || $result->num_rows === 0) {
        return [];
    }

    $products = [];

    while ($row = $result->fetch_assoc()) {
        $productId = (int) $row['product_id'];

        /* ------------------------------
           STEP 2: FETCH FEATURES
        ------------------------------ */
        $features = [];
        $featureQuery = "
            SELECT 
                feature,
                is_interior,
                is_exterior,
                is_limited,
                is_included
            FROM " . PRODUCTFEATURES . "
            WHERE product_id = ?
            ORDER BY id ASC
        ";

        $stmt = $conn->prepare($featureQuery);
        if ($stmt) {
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $featureResult = $stmt->get_result();

            while ($f = $featureResult->fetch_assoc()) {
                $features[] = [
                    "feature" => $f['feature'],
                    "type" => getFeatureType($f)
                ];
            }

            $stmt->close();
        }

        /* ------------------------------
           STEP 3: FETCH PRICES (for this car only)
        ------------------------------ */
        $prices = [];
        $priceQuery = "
            SELECT 
                pp.car_type_id, 
                ct.car_name, 
                pp.price
            FROM product_prices pp
            JOIN car_types ct ON pp.car_type_id = ct.car_id
            WHERE pp.product_id = ? AND pp.car_type_id = ?
        ";

        $stmt = $conn->prepare($priceQuery);
        if ($stmt) {
            $stmt->bind_param("ii", $productId, $carId);
            $stmt->execute();
            $priceResult = $stmt->get_result();

            while ($p = $priceResult->fetch_assoc()) {
                $prices[] = [
                    "car_id" => $p['car_type_id'],
                    "car_name" => $p['car_name'],
                    "price" => $p['price']
                ];
            }

            $stmt->close();
        }

        /* ------------------------------
           STEP 4: COMBINE EVERYTHING
        ------------------------------ */
        $row['features'] = $features;
        $row['prices'] = $prices;
        $products[] = $row;
    }

    return $products;
}
