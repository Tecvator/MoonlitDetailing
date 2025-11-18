

// Create Preloader
const preloader = document.createElement("div");
preloader.innerHTML = `
  <div id="preloader" style="
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(255,255,255,0.8);
    display: flex; align-items: center; justify-content: center;
    z-index: 9999;
  ">
    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>
`;
document.body.appendChild(preloader);

// Hide preloader after page load
window.addEventListener("load", () => {
  const preloader = document.getElementById("preloader");
  if (preloader) {
    preloader.style.opacity = "0";
    setTimeout(() => preloader.style.display = "none", 500);
  }
});







function goToPlan(){
            window.location = "./select-plan.html";

}

document.querySelectorAll('.ob-tab-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.ob-tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
  });
});

function storeUserInfor(redirectTo, paymentMethod) {
  const bookingDataStr = sessionStorage.getItem('bookingData');
  let bookingData = bookingDataStr ? JSON.parse(bookingDataStr) : {};

  const username = document.getElementById('fullname').value;
  const email = document.getElementById('email').value;
  const phoneNumber = document.getElementById('phone_number').value;
  const carMake = document.getElementById('car_make').value;
  const totalPrice = document.getElementById('total_price').value;
  const calloutFee = document.getElementById('callout_fee').value;

  // Update booking data
  bookingData.username = username;
  bookingData.email = email;
  bookingData.phoneNumber = phoneNumber;
  bookingData.carMake = carMake;
  bookingData.paymentMethod = paymentMethod;
  bookingData.totalPrice = totalPrice;
  bookingData.callout_fee = calloutFee;

  // Save to sessionStorage
  sessionStorage.setItem('bookingData', JSON.stringify(bookingData));

  // 🌀 Show processing Swal
  Swal.fire({
    title: 'Processing...',
    text: 'Please wait while we save your booking information.',
    allowOutsideClick: false,
    didOpen: () => Swal.showLoading()
  });

  // Save user info to PHP session
  fetch('save-userinfo-to-session.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(bookingData)
  })
  .then(response => response.json())
  .then(data => {
    if (!data.success) {
      Swal.close();
      Swal.fire({
        icon: 'error',
        title: 'Error Saving Info',
        text: data.message || 'Unable to save your booking information.'
      });
      return;
    }

    // ✅ If payment method is NOT pay_now, confirm booking automatically
    if (paymentMethod !== 'pay_now') {
      Swal.update({
        title: 'Confirming Booking...',
        text: 'Please wait while we finalize your booking.'
      });

      const formData = new FormData();
      Object.entries(bookingData).forEach(([key, val]) => formData.append(key, val));

      fetch('confirm-booking.php', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(apiData => {
        Swal.close();

        if (apiData.status === true) {
          Swal.fire({
            icon: 'success',
            title: 'Booking Confirmed!',
            text: 'Redirecting to your booking summary...'
          }).then(() => {
            window.location.href = `booking-placed.php?booking_id=${encodeURIComponent(apiData.booking_id)}`;
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Booking Failed',
            text: apiData.message || 'An error occurred while confirming your booking.'
          });
        }
      })
      .catch(err => {
        Swal.close();
        Swal.fire({
          icon: 'error',
          title: 'Network Error',
          text: 'Unable to complete your booking. Please try again.'
        });
        console.error(err);
      });

    } else {
      // ✅ For pay_now, just redirect to payment page
      Swal.close();
            window.location.href = redirectTo;

    }
  })
  .catch(error => {
    Swal.close();
    console.error('Error:', error);
    Swal.fire({
      icon: 'error',
      title: 'Network Error',
      text: 'An error occurred while saving your information. Please try again.'
    });
  });
}




function goToDate(){
            window.location = "./select-date.html";

}
function goToBookingPlace(){
    storeUserInfor("./booking-placed.php", "pay_after");


}
function goToPayNow(){
  storeUserInfor("./pay-now.php", "pay_now");

}
function goToBooking(){
            window.location = "./booking-placed.html";

}


function copyAccount() {
  const accountNumber = document.getElementById("accountNumber").innerText;
  navigator.clipboard.writeText(accountNumber);
  alert("Account number copied!");
}

function fileSelected() {
  const fileInput = document.getElementById("proof");
  const confirmBtn = document.getElementById("confirmBtn");
  const uploadBtn = document.getElementById("uploadBtn");

  if (fileInput.files.length > 0) {
    uploadBtn.innerText = "Uploaded ✓";
    confirmBtn.disabled = false;
  } else {
    uploadBtn.innerText = "Upload";
    confirmBtn.disabled = true;
  }
}
