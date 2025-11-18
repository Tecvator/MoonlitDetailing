<?php require_once __DIR__ . '/../src/config/init.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pamper Your Ride</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@400;500;700&display=swap" rel="stylesheet">
  <link href="./assets/css/style.css" rel="stylesheet">
  <style>
#addressSection,
#ourAddressSection {
  max-height: 0;
  overflow: hidden;
  opacity: 0;
  transition: all 0.4s ease;
}

/* When "show" class is added */
#addressSection.show,
#ourAddressSection.show {
  max-height: 300px;
  opacity: 1;
}

  </style>

</head>
<body>

  <div class="container-fluid ob-main-container">
    <div class="row">

      <!-- Left Section (Car Image) -->
      <div class="col-md-6 ob-left d-none d-md-block"></div>

      <!-- Right Section (Form) -->
      <div class="col-md-6 ob-right d-flex align-items-center justify-content-center">
        <div class="ob-form-box text-center">
          <h2 class="title-text"><strong>Where Should We Pamper Your Ride?</strong></h2>
          <p class="title-description">
            We Currently Serve The <?php echo $siteInfo['city'];?> Region, <?php echo $siteInfo['state'];?> & Nearby Areas.
          </p>
            <div class="mt-10"></div>

         <div class="d-flex justify-content-center gap-3 my-4">
              <button class="btn ob-btn-outline" id="myPlaceBtn">
                <img src="assets/images/tick.png" style="width: 20px;" class="tick d-none" id="myTick"/> My Place
              </button>
              <button class="btn ob-btn-outline" id="ourHubBtn">
                <img src="assets/images/tick.png" style="width: 20px;" class="tick d-none" id="hubTick"/> Our Hub At <?php echo $siteInfo['name'];?>
              </button>
          </div>

            <div class="mt-10"></div>
<!-- Hidden by default -->
 <div id="addressSection" class="d-nonep">
      <div class="row mt-10">
                  <div class="col-2"></div>
                   <div class="col-10"> <div>
                <input type="text" class="form-control ob-input" placeholder="Type Your Address" id="autocomplete">
                <input type="hidden" id="site_lon" name="latitude">
                <input type="hidden" id="site_city" name="city" >
								<input type="hidden" id="site_lat" name="longitude">

         </div>

        <div class="mt-10"></div>

              <div class="row">
                        <div class="col-12">
                                  <div class="form-check mt-3 ob-custom-check d-flex align-items-center">
                                    <input class="form-check-input me-1" type="checkbox" id="confirmCheck">
                                    <label class="form-check-label toc-text mb-0" for="confirmCheck"> Please Confirm You Can Provide Water And Electricity </label>
                                </div>
                          </div>
                  </div>
     </div>
                <div class="col-2"></div>
      </div>
    </div>



            <div id="ourAddressSection" class="d-nonep">
              <div class="row">
                <div class="col-2"></div>
              <div class="col-9">
      <div class="card p-3 animate__animated animate__fadeIn position-relative">
  <p class="mb-0"><?php echo $siteInfo['address']; ?></p>
  <button class="copy-btn btn btn-sm btn-outline-primary position-absolute" style="bottom: 10px; right: 10px;">
    Copy
  </button>
</div>

                <div class="mt-10"></div>
              </div>

            </div>

        </div>


          <button class="btn ob-btn-outline mt-4" id="continueBtn">
            Continue <img src="assets/images/white-tick.png" style="width: 20px;"/>
          </button>
                                          <div class="mt-10"></div>
                    <div>
                        <span class="toc-text"> Travel fees only apply outside the <?php echo $siteInfo['city'];?>  free zone. Transparent. No surprises.</span>
                    </div>

        </div>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  		<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $siteInfo['mpkey'];?>&libraries=places"></script>

  <script src="assets/js/script.js"></script>
<script>
// Initialize variables
let selectedLocation = null;
let autocomplete;

// Load saved data on page load
window.onload = function() {
  initAutocomplete();
  loadSavedData();
};

// Initialize Google Places Autocomplete
function initAutocomplete() {
  const input = document.getElementById('autocomplete');
  autocomplete = new google.maps.places.Autocomplete(input, {
    types: ['geocode'],
    componentRestrictions: { country: 'za' }
  });

  autocomplete.addListener('place_changed', fillInAddress);
}

// Fill in address details
function fillInAddress() {
  const place = autocomplete.getPlace();
  let state = '';
  let city = '';

  if (place.address_components) {
    place.address_components.forEach(component => {
      if (component.types.includes('administrative_area_level_1')) {
        state = component.long_name;
      }
      if (component.types.includes('locality')) {
        city = component.long_name;
      }
    });
  }

  const addressData = {
    address: document.getElementById('autocomplete').value,
    state: state,
    city: city,
    latitude: place.geometry.location.lat(),
    longitude: place.geometry.location.lng()
  };

  // Save to sessionStorage
  sessionStorage.setItem('selectedAddress', JSON.stringify(addressData));

  document.getElementById('site_city').value = city;
  document.getElementById('site_lat').value = place.geometry.location.lat();
  document.getElementById('site_lon').value = place.geometry.location.lng();
}

// Load saved data from sessionStorage
function loadSavedData() {
  const savedLocation = sessionStorage.getItem('selectedLocation');
  const savedAddress = sessionStorage.getItem('selectedAddress');
  const savedCheckbox = sessionStorage.getItem('confirmWaterElectricity');

  if (savedLocation) {
    selectedLocation = savedLocation;
    if (savedLocation === 'myPlace') {
      document.getElementById('myPlaceBtn').click();
    } else if (savedLocation === 'ourHub') {
      document.getElementById('ourHubBtn').click();
    }
  }

  if (savedAddress) {
    const addressData = JSON.parse(savedAddress);
    document.getElementById('autocomplete').value = addressData.address;
    document.getElementById('site_city').value = addressData.city;
    document.getElementById('site_lat').value = addressData.latitude;
    document.getElementById('site_lon').value = addressData.longitude;
  }

  if (savedCheckbox === 'true') {
    document.getElementById('confirmCheck').checked = true;
  }
}

// My Place Button
document.getElementById('myPlaceBtn').addEventListener('click', function() {
  selectedLocation = 'myPlace';
  sessionStorage.setItem('selectedLocation', 'myPlace');

  this.classList.add('active');
  document.getElementById('myTick').classList.remove('d-none');

  document.getElementById('ourHubBtn').classList.remove('active');
  document.getElementById('hubTick').classList.add('d-none');

  document.getElementById('addressSection').classList.add('show');
  document.getElementById('ourAddressSection').classList.remove('show');
});

// Our Hub Button
document.getElementById('ourHubBtn').addEventListener('click', function() {
  selectedLocation = 'ourHub';
  sessionStorage.setItem('selectedLocation', 'ourHub');

  this.classList.add('active');
  document.getElementById('hubTick').classList.remove('d-none');

  document.getElementById('myPlaceBtn').classList.remove('active');
  document.getElementById('myTick').classList.add('d-none');

  document.getElementById('ourAddressSection').classList.add('show');
  document.getElementById('addressSection').classList.remove('show');
});

// Checkbox change event
document.getElementById('confirmCheck').addEventListener('change', function() {
  sessionStorage.setItem('confirmWaterElectricity', this.checked);
});

// Copy button functionality
document.querySelector('.copy-btn').addEventListener('click', function() {
  const addressText = this.previousElementSibling.textContent;

  navigator.clipboard.writeText(addressText).then(() => {
    const originalText = this.textContent;
    this.textContent = 'Copied!';
    this.style.backgroundColor = '#28a745';

    setTimeout(() => {
      this.textContent = originalText;
      this.style.backgroundColor = 'black';
    }, 2000);
  }).catch(err => {
    console.error('Failed to copy:', err);
    alert('Failed to copy address');
  });
});

// Continue Button with AJAX call
document.getElementById('continueBtn').addEventListener('click', function() {
  if (!selectedLocation) {
    alert('Please select a location option');
    return;
  }

  let bookingData = {};

  if (selectedLocation === 'myPlace') {
    const address = document.getElementById('autocomplete').value;
    const latitude = document.getElementById('site_lat').value;
    const longitude = document.getElementById('site_lon').value;
    const confirmed = document.getElementById('confirmCheck').checked;

    if (!address || !latitude || !longitude) {
      alert('Please enter your address');
      return;
    }

    if (!confirmed) {
      alert('Please confirm you can provide water and electricity');
      return;
    }

    bookingData = {
      locationType: 'myPlace',
      address: address,
      city: document.getElementById('site_city').value,
      latitude: latitude,
      longitude: longitude,
      waterElectricityConfirmed: true
    };
  } else {
    bookingData = {
      locationType: 'ourHub'
    };
  }

  // Show loading state
  const continueBtn = document.getElementById('continueBtn');
  const originalText = continueBtn.innerHTML;
  continueBtn.disabled = true;
  continueBtn.innerHTML = 'Please wait...';

  // Save to sessionStorage
  sessionStorage.setItem('bookingData', JSON.stringify(bookingData));

  // Make AJAX call to save to PHP session
  fetch('save-to-session.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(bookingData)
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      console.log('Session saved successfully:', data);
      // Redirect to next page
      window.location.href = 'select-car.php';
    } else {
      throw new Error(data.message || 'Failed to save session');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('An error occurred. Please try again.');
    // Restore button state
    continueBtn.disabled = false;
    continueBtn.innerHTML = originalText;
  });
});
</script>

</body>
</html>
