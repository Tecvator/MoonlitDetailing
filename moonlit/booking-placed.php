<?php
require_once('init.php');

// Check if user came from car selection page
if (!isset($_GET['booking_id'])) {
    header('Location: index.php');
    exit();
}

$bookingID = $_GET['booking_id'];

$getBooking = fetchFromApi("get_booking", ["booking_id" => $bookingID]);
if ($getBooking['status'] === true) {
    $booking = $getBooking['data'];
} else {
    $booking = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking Confirmation - Moonlit</title>
  <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/booking_status.css">
</head>
<body>

  <div class="ob-confirm-page">
    <div class="ob-overlay"></div>

    <div class="ob-content ">
        <h1 class="ob-title">
  Thanks For Booking With <?php echo ucfirst($siteInfo['name']);?> 
  <span class="ob-title-line"></span>
</h1>

      <p class="ob-subtitle">Your Shine Is Loading...</p>

      <div class="ob-status-card">
        <div class="mt-3">
        <span class="ob-status-title">Your Booking Status • <span id="bookingId"><?php echo ucfirst($booking['payment_status']); ?>
</span></span>

        </div>
 <div class="mt-10"></div>
        <div class="ob-status-item mt-3">
          <img src="assets/images/tick.png" alt="received" class="ob-status-icon">
          <div>
            <h5>Booking Request Received</h5>
            <p>We have got your booking details safely.</p>
          </div>
        </div>

        <div class="ob-status-item">
          <img src="assets/images/clock.png" alt="review" class="ob-status-icon">
          <div>
            <h5>Payment Received Under Review</h5>
            <p>Our team is checking your proof of payment.</p>
          </div>
        </div>

        <div class="ob-status-item">
          <img src="assets/images/pending.png" alt="pending" class="ob-status-icon pending">
          <div>
            <h5>Confirmation Pending</h5>
            <p>You’ll get an SMS/WhatsApp within 10 mins.</p>
          </div>
        </div>

        <p class="ob-note">No worries — if anything’s missing, we’ll contact you directly.</p>
      </div>
    </div>
  </div>

</body>
</html>
