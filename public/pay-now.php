<?php require_once __DIR__ . '/../src/config/init.php';
session_start();

// Check if user came from car selection page
if (!isset($_SESSION['booking_data'])) {
    header('Location: index.php');
    exit();
}
$bookingData = $_SESSION['booking_data'];
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

  <div class="container-fluid ob-main-container">
    <div class="row">
      
      <!-- Left Section (Car Image) -->
      <div class="col-md-6 ob-paynow-left d-none d-md-block"></div>

      <!-- Right Section (Form) -->
      <div class="col-md-6 ob-right d-flex align-items-center justify-content-center">
        <div class="ob-form-box text-center">
          <div class="row mb-4 align-items-center">
        <div class="col-2 back-div" onclick="window.history.back()">
  <img src="./assets/images/back.png" class="ml-2" alt="back icon" />
</div>

            <div class="col-10 text-start d-flex justify-content-between align-items-center">
              <h2 class="ob-title mb-0">Secure Your<br>Booking</h2>
              <h2 class="ob-price mb-0 pay-price"><?php echo $bookingData['totalPrice'];?></h2>
            </div>
          </div>

          <div class="account-card mb-3 shadow">
            <div class="full-width"><b style="text-align: start;"><?php  echo $siteInfo['site_bank']['account_name'];?></b> </div>
            <div class="full-width"><b style="text-align: start;" class="mt-2"><?php echo $siteInfo['site_bank']['account_number'];?></b>
                 <button class="btn btn-sm btn-secondary copy-btn">Copy <img src="./assets/images/copy.png"/></button></div>
                    <div class="full-width">
                            <img src="./assets/images/bank.png" class="bank-icon"/>
                            <span class="bank-name" id="account_number"><?php echo $siteInfo['site_bank']['bank_name'];?></span>
                    </div>

                    <div class="full-width">
                            <span class="pay-inst-text">After you've paid, simply upload your receipt below 
                                <br/>
                                so we can confirm instantly.</span>
                    </div>

                    <div class="full-width mt-3">
                        <div class="upload-container">
                            <div class="upload-text-div">
                                    <span>Upload Proof of Payment</span>
                            </div>

                            <div class="upload-btn-div">
                                <button class="btn btn-dark upload-btn"> <span class="ob-select-icon-two-sm">✓</span> Upload </button>
                            </div>
                            
                        </div>
                    </div>
            </div>

          <div class="d-flex justify-content-center gap-3">
            <button class="btn ob-btn form-control" onclick="goToBookingPlace()">Yes, I've Paid — Confirm My Booking <span class="ob-select-icon">✓</span></button>
          </div>
              <div id="copiedBox" style="
                display: none;
                position: fixed;
                top: 10%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: rgba(245, 242, 242, 0.85);
                color: black;
                padding: 10px 20px;
                border-radius: 10px;
                font-size: 15px;
                z-index: 1000;
                text-align: center;
                box-shadow: 0 2px 8px rgba(0,0,0,0.3);
                width: 15%;
              ">
                Copied
              </div>

        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/js/script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <script>
    let uploadedFile = null;

// Handle copy button
document.querySelector('.copy-btn').addEventListener('click', function() {
  const bankNumber = document.getElementById('account_number').textContent.trim();
  const copiedBox = document.getElementById('copiedBox');

  if (navigator.clipboard && navigator.clipboard.writeText) {
    navigator.clipboard.writeText(bankNumber).then(() => {
      showCopiedBox(copiedBox);
    }).catch(err => {
      console.error('Clipboard write failed:', err);
      fallbackCopy(bankNumber, copiedBox);
    });
  } else {
    fallbackCopy(bankNumber, copiedBox);
  }
});

function fallbackCopy(text, copiedBox) {
  const textarea = document.createElement('textarea');
  textarea.value = text;
  document.body.appendChild(textarea);
  textarea.select();
  document.execCommand('copy');
  document.body.removeChild(textarea);
  showCopiedBox(copiedBox);
}

function showCopiedBox(copiedBox) {
  copiedBox.style.display = 'block';
  setTimeout(() => {
    copiedBox.style.display = 'none';
  }, 2000);
}

// Handle file upload button - SINGLE EVENT LISTENER ONLY
document.querySelector('.upload-btn').addEventListener('click', function () {
  const fileInput = document.createElement('input');
  fileInput.type = 'file';
  fileInput.accept = 'image/*,.pdf';
  fileInput.style.display = 'none';

  fileInput.addEventListener('change', function (event) {
    const file = event.target.files[0];
    if (file) {
      uploadedFile = file;
      document.querySelector('.upload-text-div span').textContent = file.name;
      console.log('File uploaded:', file.name);
    }
  });

  document.body.appendChild(fileInput);
  fileInput.click();
  
  // Clean up after file selection or cancel
  setTimeout(() => {
    document.body.removeChild(fileInput);
  }, 1000);
});

// Handle booking confirmation
function goToBookingPlace() {
  const bookingDataStr = sessionStorage.getItem('bookingData');
  if (!bookingDataStr) {
    Swal.fire({
      icon: 'error',
      title: 'Booking Data Missing',
      text: 'Please go back and fill in your booking details again.'
    });
    return;
  }

  if (!uploadedFile) {
    Swal.fire({
      icon: 'warning',
      title: 'Receipt Required',
      text: 'Please upload your payment receipt before confirming booking.'
    });
    return;
  }

  const bookingData = JSON.parse(bookingDataStr);
  const formData = new FormData();

  Object.entries(bookingData).forEach(([key, val]) => formData.append(key, val));
  formData.append('receipt', uploadedFile);

  Swal.fire({
    title: 'Processing...',
    text: 'Please wait while we confirm your booking.',
    allowOutsideClick: false,
    didOpen: () => Swal.showLoading()
  });

  fetch('confirm-booking.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    Swal.close();
    if (data.status === true) {
      Swal.fire({
        icon: 'success',
        title: 'Booking Confirmed!',
        text: 'Redirecting ......'
      }).then(() => {
        window.location.href = `booking-placed.php?booking_id=${encodeURIComponent(data.booking_id)}`;
      });
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Booking Failed',
        text: data.message || 'An error occurred while confirming booking.'
      });
    }
  })
  .catch(err => {
    Swal.close();
    Swal.fire({
      icon: 'error',
      title: 'Network Error',
      text: 'Something went wrong while confirming your booking.'
    });
  });
}
</script>

</body>
</html>