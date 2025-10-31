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
$price = isset($bookingData['planPrice']) ? $bookingData['planPrice'] : '0';
$category = isset($bookingData['planCategory']) ? $bookingData['planCategory'] : '0';
$planID = isset($bookingData['planId']) ? $bookingData['planId'] : '0';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Select Date & Time</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;500;700&display=swap" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="assets/css/select_date.css" rel="stylesheet">
  
  <style>
    /* Loading overlay */
    .loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.8);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }

    .loading-overlay.show {
      display: flex;
    }

    .spinner {
      border: 4px solid rgba(255, 255, 255, 0.3);
      border-top: 4px solid #fff;
      border-radius: 50%;
      width: 50px;
      height: 50px;
      animation: spin 1s linear infinite;
      margin: 0 auto 20px;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  </style>
</head>
<body>

<!-- Loading overlay -->
<div class="loading-overlay" id="loadingOverlay">
  <div class="loading-content text-center text-white">
    <div class="spinner"></div>
    <p id="loadingText">Loading available times...</p>
  </div>
</div>

<div class="container-fluid ob-main-container">
  <div class="row">
    
    <!-- Left Section (Car Image) -->
    <div class="col-md-6 ob-date-left d-none d-md-block"></div>

    <!-- Right Section (Form) -->
    <div class="col-md-6 ob-right d-flex align-items-center justify-content-center" style="padding-top: 30px;">
      
      <div class="ob-form-box text-center">
        <div class="row mb-3 align-items-center">
          <div class="col-2 back-div">
            <a href="select-plan.php">
              <img src="./assets/images/back.png" class="img-fluid" style="max-width: 30px; cursor: pointer;"/>
            </a>
          </div>
          <div class="col-10">
            <button class="btn btn-primary form-control btn-for-info">
              You selected <?php echo htmlspecialchars($category); ?> - <?php echo htmlspecialchars($planName); ?> - <?php echo htmlspecialchars($carName); ?> 
              <b>R <?php echo number_format($price, 2); ?></b>
            </button>
          </div>
        </div>

        <h1 class="ob-title">Lock In Your Detailing Slot<span class="ob-title-line"></span></h1>
        <span class="text-hash">
          Choose A Time That Suits You - 
          <span class="text-white">Our Team Will Be There, Ready To Make Your Car Shine Like New.</span>
        </span>
    
        <div class="mt-10"></div>

        <div class="container">
          <div class="ob-schedule-container">
            <!-- Calendar Section -->
            <div class="ob-calendar" id="calender-box">
              <div class="ob-calendar-header">
                <button id="prevMonth"><</button>
                <span id="monthYear"></span>
                <button id="nextMonth">></button>
              </div>

              <div class="ob-weekdays">
                <div>SUN</div><div>MON</div><div>TUE</div>
                <div>WED</div><div>THU</div><div>FRI</div><div>SAT</div>
              </div>
              <div id="calendarDays" class="ob-days"></div>

              <div class="ob-timezone">
                <span>🌍 Central Africa Time</span>
              </div>
            </div>

            <!-- Time Selection Section -->
            <div class="ob-times" id="timeList">
              <h4 id="selectedDateText"></h4>
              <div id="timesContainer" class="hidden">
                <!-- Times will be loaded via AJAX -->
              </div>
            </div>
          </div>
        </div>

        <button class="btn ob-btn-outline mt-4" id="proceedBtn" style="display: none;">
          Proceed <span class="ob-select-icon-two">✓</span>
        </button>

      </div>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
const calendarDays = document.getElementById("calendarDays");
const monthYear = document.getElementById("monthYear");
const timesContainer = document.getElementById("timesContainer");
const selectedDateText = document.getElementById("selectedDateText");
const proceedBtn = document.getElementById("proceedBtn");
const loadingOverlay = document.getElementById("loadingOverlay");
const loadingText = document.getElementById("loadingText");
const calendarSection = document.querySelector(".ob-calendar");
const timesSection = document.querySelector(".ob-times");
timesSection.display = "none";
let date = new Date();
let currentMonth = date.getMonth();
let currentYear = date.getFullYear();
let selectedDate = null;
let selectedTime = null;

function renderCalendar(month, year) {
  const firstDay = new Date(year, month).getDay();
  const daysInMonth = new Date(year, month + 1, 0).getDate();
  const today = new Date();
  today.setHours(0, 0, 0, 0);

  const monthNames = [
    "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
  ];
  
  monthYear.textContent = monthNames[month] + " " + year;
  calendarDays.innerHTML = "";

  // Empty cells for alignment
  for (let i = 0; i < firstDay; i++) {
    calendarDays.innerHTML += "<div></div>";
  }

  // Days of the month
  for (let d = 1; d <= daysInMonth; d++) {
    const day = document.createElement("div");
    const dayDate = new Date(year, month, d);
    dayDate.setHours(0, 0, 0, 0);
    
    day.textContent = d;
    
    // Disable past dates
    if (dayDate < today) {
      day.classList.add("disabled");
    } else {
      day.addEventListener("click", () => selectDate(d, month, year));
    }
    
    calendarDays.appendChild(day);
  }
}

function selectDate(day, month, year) {
  document.querySelectorAll(".ob-days div").forEach(d => d.classList.remove("active"));
  event.target.classList.add("active");
  
  selectedDate = new Date(year, month, day);
  const dateStr = selectedDate.toISOString().split('T')[0];
  
  selectedDateText.textContent = selectedDate.toDateString();
  selectedTime = null;
  proceedBtn.style.display = 'none';
  
  loadingOverlay.classList.add('show');
  loadingText.textContent = 'Loading available times...';
  
  const productId = '<?php echo $planID; ?>';
  
  fetch('get-available-times.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ date: dateStr, productId: productId })
  })
  .then(response => response.json())
  .then(data => {
    loadingOverlay.classList.remove('show');
    
    document.getElementById('calender-box').display = "none";

    if (data.status === 'success' && data.available_times && data.available_times.length > 0) {
      calendarSection.style.display = 'none';
      timesSection.style.flex = '1';
      timesSection.style.maxWidth = '100%';
      displayTimes(data.available_times);
    } else {
      timesContainer.innerHTML = '<p class="text-white text-center">No available times for this date</p>';
      timesContainer.classList.remove("hidden");
    }
  })
  .catch(error => {
    console.error('Error:', error);
    loadingOverlay.classList.remove('show');
    alert('Failed to load available times. Please try again.');
  });
}

function displayTimes(times) {
  timesContainer.innerHTML = '';
  
  times.forEach(time => {
    const btn = document.createElement('button');
    btn.className = 'ob-time-btn';
    btn.textContent = time;
    btn.addEventListener('click', () => selectTime(time, btn));
    timesContainer.appendChild(btn);
  });
  
  timesContainer.classList.remove("hidden");
}

function selectTime(time, button) {
  document.querySelectorAll(".ob-time-btn").forEach(b => b.classList.remove("active"));
  button.classList.add("active");
  
  selectedTime = time;
  proceedBtn.style.display = 'block';
}

// === 🗓️ Function to create calendar event file ===
function createCalendarEvent(title, description, startDateTime, endDateTime) {
  const icsContent = `
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//YourWebsite//EN
BEGIN:VEVENT
SUMMARY:${title}
DESCRIPTION:${description}
DTSTART:${startDateTime}
DTEND:${endDateTime}
BEGIN:VALARM
TRIGGER:-PT10M
DESCRIPTION:Reminder
ACTION:DISPLAY
END:VALARM
END:VEVENT
END:VCALENDAR
`.trim();

  const blob = new Blob([icsContent], { type: 'text/calendar;charset=utf-8' });
  const link = document.createElement('a');
  link.href = URL.createObjectURL(blob);
  link.download = 'booking-reminder.ics';
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}

// Month navigation
document.getElementById("prevMonth").addEventListener("click", () => {
  currentMonth--;
  if (currentMonth < 0) {
    currentMonth = 11;
    currentYear--;
  }
  renderCalendar(currentMonth, currentYear);
});

document.getElementById("nextMonth").addEventListener("click", () => {
  currentMonth++;
  if (currentMonth > 11) {
    currentMonth = 0;
    currentYear++;
  }
  renderCalendar(currentMonth, currentYear);
});

// Proceed button
proceedBtn.addEventListener('click', function() {
  if (!selectedDate || !selectedTime) {
    alert('Please select both date and time');
    return;
  }
  
  loadingOverlay.classList.add('show');
  loadingText.textContent = 'Saving your booking...';
  proceedBtn.disabled = true;
  
  const bookingDataStr = sessionStorage.getItem('bookingData');
  let bookingData = bookingDataStr ? JSON.parse(bookingDataStr) : {};
  
  bookingData.bookingDate = selectedDate.toISOString().split('T')[0];
  bookingData.bookingTime = selectedTime;
  bookingData.bookingDateTime = selectedDate.toDateString() + ' at ' + selectedTime;
  
  sessionStorage.setItem('bookingData', JSON.stringify(bookingData));
  
  fetch('save-datetime-to-session.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(bookingData)
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      console.log('Date & time saved:', data);
      
      // === 🕓 Create calendar reminder event ===
      const title = "Booking Reminder";
      const description = "Your booking on " + bookingData.bookingDateTime;
      const start = new Date(selectedDate);
      const [hours, minutes] = selectedTime.split(':');
      start.setHours(hours, minutes, 0);
      const end = new Date(start.getTime() + 60 * 60 * 1000);

      const toICSFormat = date => date.toISOString().replace(/[-:]/g, "").split(".")[0] + "Z";
      createCalendarEvent(title, description, toICSFormat(start), toICSFormat(end));

      // Redirect after saving
      window.location.href = 'booking-details.php';
    } else {
      throw new Error(data.message || 'Failed to save date & time');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    loadingOverlay.classList.remove('show');
    alert('An error occurred. Please try again.');
    proceedBtn.disabled = false;
  });
});

// Initialize calendar
renderCalendar(currentMonth, currentYear);
</script>


</body>
</html>