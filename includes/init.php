<?php
   //$conn = mysqli_connect("localhost", "root", "", "moonlit");
       $conn = mysqli_connect("localhost", "trustti1_moonlit", "2025@moon", "trustti1_moonlit");
    require_once (__DIR__."/tables.php");
    require_once (__DIR__."/admin_functions.php");
    require_once (__DIR__."/product_functions.php");
    require_once (__DIR__."/category_functions.php");
    require_once (__DIR__."/car_functions.php");
    require_once (__DIR__."/customer_functions.php");
    require_once (__DIR__."/booking_functions.php");
    $siteinfo = getSiteInfo($conn);
    $sitebank = getSiteBank($conn);

if (!$siteinfo) {
    echo "No site info found.";
}

?>