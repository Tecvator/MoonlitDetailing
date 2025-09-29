<?php
    $conn = mysqli_connect("localhost", "root", "", "moonlit");
    require_once (__DIR__."/tables.php");
    require_once (__DIR__."/admin_functions.php");
    require_once (__DIR__."/product_functions.php");
    require_once (__DIR__."/category_functions.php");
    require_once (__DIR__."/car_functions.php");
    $siteinfo = getSiteInfo($conn);

if (!$siteinfo) {
    echo "No site info found.";
}

?>