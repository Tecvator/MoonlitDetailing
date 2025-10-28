<?php
session_start();

// Check if user came from plan selection page
if (!isset($_SESSION['booking_data'])) {
    header('Location: index.php');
    exit();
}

require_once('init.php');

// Get booking data from session
$bookingData = $_SESSION['booking_data'];
$planName = isset($bookingData['planName']) ? $bookingData['planName'] : 'Package';
$carName = isset($bookingData['carName']) ? $bookingData['carName'] : 'Car';
$address = isset($bookingData['address']) ? $bookingData['address'] : 'Car';
$carID = isset($bookingData['carId']) ? $bookingData['carId'] : 'Car';
$price = isset($bookingData['planPrice']) ? $bookingData['planPrice'] : '0';
$category = isset($bookingData['planCategory']) ? $bookingData['planCategory'] : '0';
$planID = isset($bookingData['planId']) ? $bookingData['planId'] : '0';
$latitude = isset($bookingData['latitude']) ? $bookingData['latitude'] : '0';
$longitude = isset($bookingData['longitude']) ? $bookingData['longitude'] : '0';


$priceResponse = fetchFromApi("get_price", ["product_id" => $planID, "car_type_id"=> $carID,
 "lat"=> $latitude, "lng"=> $longitude,]);
if (!empty($priceResponse['status']) && ($priceResponse['status'] === true || $priceResponse['status'] === 'success')) {
    $priceData = $priceResponse;
} else {
    $priceData = [];
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pamper Your Ride</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;500;700&display=swap" rel="stylesheet">
  <link href="assets/css/finally.css" rel="stylesheet">
</head>
<body>


    <div class="row">
      
      <!-- Left Section (Car Image) -->
      <div class="col-md-6 ob-book-left d-none d-md-block"></div>

      <!-- Right Section (Form) -->
      <div class="col-md-6 ob-right d-flex align-items-center justify-content-center">
        <div class="ob-form-box text-center">
          <div class="row mb-4 align-items-center">
            <div class="col-2 back-div"> 
              <img src="./assets/images/back.png" class="ml-2" alt="back icon"/>
            </div>
            <div class="col-10 text-start">
<h2 class="ob-title" style="display: flex; align-items: center; gap: 10px;">
  Finally!
  <div style="width: 87px; height: 3px; background-color: #a29d9d;"></div>
</h2>
              <p class="text-hash">Choose The Location – <span class="text-white">No Worries, The Price Stays The Same</span></p>
            </div>
          </div>

          <div class="ob-summary text-start mb-4">
            <p><strong>Car Type</strong> <br><span class="text-white-50"><?php echo $carName;?></span></p>
            <p><strong><?php echo $category;?></strong> <br><span class="text-white-50"><?php echo $planName;?></span>
             <span class="float-end"><?php echo $priceData['base_price'];?></span></p>
            <p><strong>Call Out Fee</strong> <br>
            <span class="text-white-50"><?php echo $address;?></span> 
            <span class="float-end"><?php echo $priceData['callout_fee'];?></span></p>
            <hr class="border-secondary">
            <p class="fw-bold fs-5">Total <span class="float-end text-white"><?php echo $priceData['total_price'];?></span></p>
          </div>

          <div class="ob-inputs text-start mb-4">
            <label>Your Information</label>
            <input type="text" placeholder="Your Name" class="ob-input mb-2" id="fullname">
            <input type="email" placeholder="Email" class="ob-input mb-2" id="email">
            <input type="tel" placeholder="Phone Number" class="ob-input mb-2" id="phone_number">
            <input type="text" placeholder="Your Car Make And Model" class="ob-input" id="car_make">
          </div>

          <div class="d-flex justify-content-center gap-3">
            <button class="btn ob-btn" onclick="goToPayNow()">Pay Now <span class="ob-select-icon-two">✓</span></button>
            <button class="btn ob-btn-outline active" onclick="goToBookingPlace()">Pay After Wash <span class="ob-select-icon-two">✓</span></button>
          </div>

        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/js/script.js"></script>
</body>
</html>
