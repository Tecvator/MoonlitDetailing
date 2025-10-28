

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
  // Show loading overlay
  const loadingOverlay = document.querySelector('.loading-overlay');
  if (loadingOverlay) loadingOverlay.classList.add('show');

  // Get booking data from sessionStorage
  const bookingDataStr = sessionStorage.getItem('bookingData');
  let bookingData = bookingDataStr ? JSON.parse(bookingDataStr) : {};
  var username = document.getElementById('fullname').value;
  var email = document.getElementById('email').value;
  var phoneNumber = document.getElementById('phone_number').value;
  var carMake = document.getElementById('car_make').value;
  // Add car data
  bookingData.username = username;
  bookingData.email = email;
  bookingData.phoneNumber = phoneNumber;
  bookingData.carMake = carMake;
  bookingData.paymentMethod = paymentMethod;

  // Save to sessionStorage
  sessionStorage.setItem('bookingData', JSON.stringify(bookingData));

  // Send to PHP session
  fetch('save-userinfo-to-session.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(bookingData)
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      window.location.href = redirectTo;
    } else {
   console.error('Error:', error);
    if (loadingOverlay) loadingOverlay.classList.remove('show');
    alert(data.message);    }
  })
  .catch(error => {
    console.error('Error:', error);
    if (loadingOverlay) loadingOverlay.classList.remove('show');
    alert('An error occurred. Please try again.');
  });
}


function goToDate(){
            window.location = "./select-date.html";

}
function goToBooking(){
            window.location = "./booking-details.html";

}
function goToPayNow(){
  storeUserInfor("./pay-now.php", "pay_now");

}
function goToBookingPlace(){
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
