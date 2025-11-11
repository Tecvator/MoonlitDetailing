<?php 
require_once __DIR__ . "/../../src/config/session.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>

	<!-- Meta Tags -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php echo $siteinfo['site_name'];?> is a powerful Bootstrap based Inventory Management Admin Template designed for businesses, offering seamless invoicing, project tracking, and estimates.">
	<meta name="keywords" content="inventory management, admin dashboard, bootstrap template, invoicing, estimates, business management, responsive admin, POS system">
	<meta name="author" content="<?php echo $siteinfo['site_name'];?> Technologies">
	<meta name="robots" content="index, follow">
	<title><?php echo $siteinfo['site_name'];?> - Admin Dashboard Template</title>


	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

	<!-- Apple Touch Icon -->
	<link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<!-- Datetimepicker CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">

	<!-- animation CSS -->
	<link rel="stylesheet" href="assets/css/animate.css">

	<!-- Feathericon CSS -->
	<link rel="stylesheet" href="assets/css/feather.css">

	<!-- Quill CSS -->
    	<link rel="stylesheet" href="assets/plugins/quill/quill.snow.css">

	<!-- Select2 CSS -->
	<link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">

	<!-- Bootstrap Tagsinput CSS -->
	<link rel="stylesheet" href="assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">

	<!-- Datatable CSS -->
	<link rel="stylesheet" href="assets/css/dataTables.bootstrap5.min.css">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

	<!-- Tabler Icon CSS -->
	<link rel="stylesheet" href="assets/plugins/tabler-icons/tabler-icons.min.css">

	<!-- Color Picker Css -->
	<link rel="stylesheet" href="assets/plugins/%40simonwep/pickr/themes/nano.min.css">

	<!-- Main CSS -->
	<link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

	<div id="global-loader">
		<div class="whirly-loader"> </div>
	</div>

	<!-- Main Wrapper -->
	<div class="main-wrapper">

			
		<?php include ("../../includes/header.php");?>
		<!-- /Header -->

		<!-- Sidebar -->
			<?php include ("../../includes/sidemenu.php");?>
		<!-- /Sidebar -->

		<div class="page-wrapper">
			<div class="content">
				<div class="page-header">
					<div class="add-item d-flex">
						<div class="page-title">
							<h4 class="fw-bold">Create Booking </h4>
							<h6>Create new booking</h6>
						</div>
					</div>
					<ul class="table-top-head">
						<li>
							<a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i class="ti ti-refresh"></i></a>
						</li>
						<li>
							<a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i class="ti ti-chevron-up"></i></a>
						</li>
					</ul>
				
					<div class="page-btn mt-0">
						<a href="./" class="btn btn-secondary"><i data-feather="arrow-left" class="me-2"></i>Back to dashboard</a>
					</div>
				</div>
<form class="add-booking-form">
  	<div class="add-product">
    <div class="accordions-items-seperate" id="accordionSpacingExample">
      
      <!-- 1. Booking Info -->
      <div class="accordion-item border mb-4">
        <h2 class="accordion-header" id="headingSpacingOne">
          <div class="accordion-button collapsed bg-white" data-bs-toggle="collapse" data-bs-target="#SpacingOne" aria-expanded="true" aria-controls="SpacingOne">
            <div class="d-flex align-items-center justify-content-between flex-fill">
              <h5 class="d-flex align-items-center">
                <i data-feather="info" class="text-primary me-2"></i>
                <span>Booking Information</span>
              </h5>
            </div>
          </div>
        </h2>
        <div id="SpacingOne" class="accordion-collapse collapse show" aria-labelledby="headingSpacingOne">
          <div class="accordion-body border-top">

     <div class="row">
  <!-- Car Type -->
  <div class="col-sm-6 col-12">
    <div class="mb-3">
      <label class="form-label">Car Type<span class="text-danger ms-1">*</span></label>
      <select class="select" name="car_type_id" id="carTypeSelect" required onchange="fetchPrice()">
        <option value="">Select Car Type</option>
        <?php  
          $cartypes = getCarTypesWithPrices($conn);
          if (!empty($cartypes)):
            foreach ($cartypes as $cartype): 
        ?>
          <option value="<?php echo $cartype['car_id']; ?>">
            <?php echo $cartype['car_name']; ?>
          </option>
        <?php 
            endforeach; 
          else: 
            echo "<option disabled>No Car Types Found</option>";
          endif;
        ?>
      </select>
    </div>
  </div>

  <!-- Product -->
  <div class="col-sm-6 col-12">
    <div class="mb-3">
      <label class="form-label">Service Product<span class="text-danger ms-1">*</span></label>
      <select class="select" name="product_id" id="productSelect" required onchange="fetchPrice()">
        <option value="">Select Product</option>
        <?php  
          $products = getProducts($conn);
          if (!empty($products)):
            foreach ($products as $product): 
        ?>
          <option value="<?php echo $product['id']; ?>">
            <?php echo $product['product_name']; ?>
          </option>
        <?php 
            endforeach; 
          else: 
            echo "<option disabled>No Products Found</option>";
          endif;
        ?>
      </select>
    </div>
  </div>

  <!-- Price Display -->
  <div class="col-sm-6 col-12">
    <div class="mb-3">
      <label class="form-label">Service Price<span class="text-danger ms-1">*</span></label>
      <input type="text" class="form-control" id="carPrice" name="price" placeholder="Price auto-loads" readonly>
    
      <span class="text-danger">Callout fee *: <b id="callout_fee">0.00</b></span>
    </div>
  </div>
    <!-- Location Type -->
              <div class="col-sm-6 col-12">
                <div class="mb-3">
                  <label class="form-label">Location Type<span class="text-danger ms-1">*</span></label>
                  <select class="select" name="location_type" id="locationType" required onchange="toggleAddressField()">
                    <option value="">Select</option>
                    <option value="moonlit"><?php echo $siteinfo['site_name'];?> Address</option>
                    <option value="customer">Customer Location</option>
                  </select>
                </div>
              </div>
</div>



            <div class="row">
            

              <!-- Customer Address -->
              <div class="col-sm-12 col-12 d-none" id="customerAddressSection">
                
<input type="hidden" id="site_lon" name="site_lon" value="<?php echo $siteinfo['site_lon']; ?>">
<input type="hidden" id="site_lat" name="site_lat" value="<?php echo $siteinfo['site_lat']; ?>">

                <div class="mb-3">
                  <label class="form-label">Customer Address<span class="text-danger ms-1">*</span></label>
                  <input type="text" class="form-control" name="customer_address" id="autocomplete" placeholder="Enter customer address">
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <!-- 2. Customer Info -->
      <div class="accordion-item border mb-4">
        <h2 class="accordion-header" id="headingSpacingTwo">
          <div class="accordion-button collapsed bg-white" data-bs-toggle="collapse" data-bs-target="#SpacingTwo" aria-expanded="false" aria-controls="SpacingTwo">
            <div class="d-flex align-items-center justify-content-between flex-fill">
              <h5 class="d-flex align-items-center">
                <i data-feather="user" class="text-primary me-2"></i>
                <span>Customer Information</span>
              </h5>
            </div>
          </div>
        </h2>
        <div id="SpacingTwo" class="accordion-collapse collapse show" aria-labelledby="headingSpacingTwo">
          <div class="accordion-body border-top">
            <div class="row">
              <div class="col-lg-6 col-sm-6 col-12">
                <div class="mb-3">
                  <label class="form-label">Full Name<span class="text-danger ms-1">*</span></label>
                  <input type="text" class="form-control" name="customer_name" required>
                </div>
              </div>
              <div class="col-lg-6 col-sm-6 col-12">
                <div class="mb-3">
                  <label class="form-label">Email<span class="text-danger ms-1">*</span></label>
                  <input type="email" class="form-control" name="customer_email" required>
                </div>
              </div>
              <div class="col-lg-6 col-sm-6 col-12">
                <div class="mb-3">
                  <label class="form-label">Phone Number<span class="text-danger ms-1">*</span></label>
                  <input type="tel" class="form-control" name="customer_phone" required>
                </div>
              </div>
              <div class="col-lg-6 col-sm-6 col-12">
                <div class="mb-3">
                  <label class="form-label">Car Make and  Model<span class="text-danger ms-1">*</span></label>
                  <input type="text" class="form-control" name="car_make" required>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- 3. Payment -->
   <div class="accordion-item border mb-4">
  <h2 class="accordion-header" id="headingSpacingThree">
    <div class="accordion-button collapsed bg-white" data-bs-toggle="collapse" data-bs-target="#SpacingThree" aria-expanded="false" aria-controls="SpacingThree">
      <div class="d-flex align-items-center justify-content-between flex-fill">
        <h5 class="d-flex align-items-center">
          <i data-feather="credit-card" class="text-primary me-2"></i>
          <span>Payment Method / Schedule</span>
        </h5>
      </div>
    </div>
  </h2>
  <div id="SpacingThree" class="accordion-collapse collapse show" aria-labelledby="headingSpacingThree">
    <div class="accordion-body border-top">
      <div class="row">

        <!-- Payment Method -->
        <div class="col-lg-6 col-sm-12">
          <div class="mb-3">
            <label class="form-label">Select Payment Method<span class="text-danger ms-1">*</span></label>
            <select class="select" name="payment_method" required>
              <option value="">Select</option>
              <option value="pay_now">Pay Now (Save 2%)</option>
              <option value="pay_after">Pay After Washing</option>
            </select>
          </div>
        </div>

        <!-- Washing Date -->
        <div class="col-lg-6 col-sm-12">
          <div class="mb-3">
            <label class="form-label">Washing Date<span class="text-danger ms-1">*</span></label>
            <input type="date" class="form-control" name="washing_date" id="washingDate" required >
          </div>
        </div>

        <div class="col-lg-6 col-sm-12 ">
          <div class="mb-3">
            <label class="form-label">Washing Time<span class="text-danger ms-1">*<span style="font-size: 10px; color: red">(product and washing date must be selected to view available time)</span></span></label>
            <select class="select" name="selected_time" id="wash_time">
              <option value="">Select</option>
           
            </select>
          </div>
        </div>


        <div class="col-lg-6 col-sm-12 d-none" id="paymentStatusSection">
          <div class="mb-3">
            <label class="form-label">Payment Status<span class="text-danger ms-1">*</span></label>
            <select class="select" name="payment_status" id="paymentStatus">
              <option value="">Select</option>
              <option value="paid">Paid</option>
              <option value="unpaid">Unpaid</option>
            </select>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>


    </div>
  </div>


  

  <div class="col-lg-12">
    <div class="d-flex align-items-center justify-content-end mb-4">
      <button type="button" class="btn btn-secondary me-2">Cancel</button>
      <button type="submit" class="btn btn-primary">Confirm Booking</button>
    </div>
  </div>
</form>


			</div>
					<?php require_once __DIR__ . "/../../src/views/footer.php";?>

		</div>
	</div>
	
	
	<!-- jQuery -->
	<script src="assets/js/jquery-3.7.1.min.js" type="712042956002651bb9418e95-text/javascript"></script>


		<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $siteinfo['site_map_key'];?>&libraries=places"></script>

<script>
 
 

let autocomplete;

function initAutocomplete() {
  const input = document.getElementById('autocomplete');
  autocomplete = new google.maps.places.Autocomplete(input, {
    types: ['geocode'],
    componentRestrictions: { country: 'za' } // Restrict to South Africa
  });

  autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
  const place = autocomplete.getPlace();

  // Store selected coordinates
  document.getElementById('site_lat').value = place.geometry.location.lat();
  document.getElementById('site_lon').value = place.geometry.location.lng();

  // Fetch price with the new coordinates
  fetchPriceWithCoordinates();
}

window.onload = initAutocomplete;

// ✅ This runs for car type or product changes
function fetchPrice() {
  const carTypeSelect = document.getElementById('carTypeSelect');
  const productSelect = document.getElementById('productSelect');
  const carPriceInput = document.getElementById('carPrice');
  const userLat = document.getElementById('site_lat').value;
  const userLng = document.getElementById('site_lon').value;

  const carTypeId = carTypeSelect.value;
  const productId = productSelect.value;

  fetchAvailableTimes();

  if (carTypeId && productId) {
    let bodyData = `car_type_id=${carTypeId}&product_id=${productId}`;

    // ✅ include coordinates if available
    if (userLat && userLng) {
      bodyData += `&lat=${userLat}&lng=${userLng}`;
    }

    fetch('process/get_price.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: bodyData
    })
    .then(res => res.json())
    .then(data => {
      if (data.status === 'success') {
        carPriceInput.value = data.base_price;
        document.getElementById('callout_fee').value = data.callout_fee;

        
      } else {
        carPriceInput.value = '';
        alert(data.message || 'Price not found');
      }
    })
    .catch(err => {
      console.error(err);
      alert('Error fetching price');
    });
  } else {
    carPriceInput.value = '';
  }
}

function fetchPriceWithCoordinates() {
  const carTypeSelect = document.getElementById('carTypeSelect');
  const productSelect = document.getElementById('productSelect');
  const carPriceInput = document.getElementById('carPrice');
  const carTypeId = carTypeSelect.value;
  const productId = productSelect.value;
  const userLat = document.getElementById('site_lat').value;
  const userLng = document.getElementById('site_lon').value;

  fetchAvailableTimes();

  if (carTypeId && productId && userLat && userLng) {
    fetch('process/get_price.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `car_type_id=${carTypeId}&product_id=${productId}&lat=${userLat}&lng=${userLng}`
    })
    .then(res => res.json())
    .then(data => {
      if (data.status === 'success') {
        carPriceInput.value = data.base_price;
document.getElementById('callout_fee').innerHTML = data.callout_fee;

      } else {
        carPriceInput.value = '';
        alert(data.message || 'Price not found');
      }
    })
    .catch(err => {
      console.error(err);
      alert('Error fetching price');
    });
  } else {
    carPriceInput.value = '';
  }
}

// ✅ Fetch available times when date changes
const washingDateInput = document.getElementById("washingDate");
washingDateInput.addEventListener("change", fetchAvailableTimes);

function fetchAvailableTimes() {
  const selectedDate = washingDateInput.value;
  const productSelect = document.getElementById('productSelect');
  const productId = productSelect.value;

  if (!selectedDate || !productId) return;

  fetch("process/check_available_times.php", {
    method: "POST",
    body: new URLSearchParams({
      product_id: productId,
      washingDate: selectedDate
    })
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === "success") {
      showAvailableTimes(data.available_times);
    } else {
      showToast("error", data.message);
    }
  })
  .catch(err => {
    console.error("Error fetching times:", err);
    showToast("error", "Failed to fetch available times");
  });
}

// ✅ Show AM/PM formatted times from "HH:MM"
function showAvailableTimes(times) {
  const select = document.getElementById("wash_time");
  const containerCol = select.closest(".col-lg-6");

  select.innerHTML = '<option value="">Select Time</option>';

  if (times.length > 0) {
    times.forEach(timeStr => {
      // timeStr format: "14:30"
      const [hourStr, minuteStr] = timeStr.split(':');
      const hour = parseInt(hourStr, 10);
      const minute = parseInt(minuteStr, 10);

      const period = hour >= 12 ? "PM" : "AM";
      const displayHour = hour % 12 || 12;
      const formattedTime = `${displayHour}:${minuteStr.padStart(2, "0")} ${period}`;

      const option = document.createElement("option");
      option.value = timeStr; // real value (e.g. "14:30")
      option.textContent = formattedTime; // display (e.g. "2:30 PM")
      select.appendChild(option);
    });
    containerCol.classList.remove("d-none");
  } else {
    containerCol.classList.add("d-none");
    showToast("error", "No available times for the selected date.");
  }
}



document.addEventListener("DOMContentLoaded", () => {

// Toggle address visibility
window.toggleAddressField = function() {
  const locationType = document.getElementById("locationType").value;
  const customerAddressSection = document.getElementById("customerAddressSection");
  const siteLat = document.getElementById("site_lat");
  const siteLon = document.getElementById("site_lon");
  const addressInput = document.getElementById("autocomplete");
  
  if (locationType === "customer") {
    customerAddressSection.classList.remove("d-none");
  } else {
    customerAddressSection.classList.add("d-none");
    
    // Clear the values when switching back to moonlit address
    if (siteLat) siteLat.value = '';
    if (siteLon) siteLon.value = '';
    if (addressInput) addressInput.value = '';
    
    // Optionally re-fetch price with default coordinates
    fetchPrice();
  }
};

  // Handle date change for showing payment status
  const washingDateInput = document.getElementById("washingDate");
  const paymentStatusSection = document.getElementById("paymentStatusSection");

  washingDateInput.addEventListener("change", function () {
    const selectedDate = new Date(this.value);
    const today = new Date();
    const isToday =
      selectedDate.getDate() === today.getDate() &&
      selectedDate.getMonth() === today.getMonth() &&
      selectedDate.getFullYear() === today.getFullYear();

    if (isToday) {
      paymentStatusSection.classList.remove("d-none");
    } else {
      paymentStatusSection.classList.add("d-none");
      document.getElementById("paymentStatus").value = "";
    }
  });


});
</script>
<script>
  // Handle booking form submission
  document.querySelector(".add-booking-form").addEventListener("submit", function (e) {
    e.preventDefault();

    const form = this;
    const submitBtn = form.querySelector("button[type='submit']");
    const formData = new FormData(form);

    formData.append("action", "add_booking");

    // Button processing state
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Processing...`;

    fetch("process/booking_process.php", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.status === "success") {
          showToast("success", data.message || "Booking added successfully!");
          form.reset();
          // Hide conditional section if visible
          paymentStatusSection.classList.add("d-none");
           setTimeout(() => {
        window.location.reload();
    }, 800); 
        } else {
          showToast("error", data.message || "Failed to add booking!");
        }
      })
      .catch(() => {
        showToast("error", "Something went wrong! Please try again.");
      })
      .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
      });
  });

  // Toast function
  window.showToast = function (type, message) {
    const bg = type === "success" ? "bg-success" : "bg-danger";
    const toast = document.createElement("div");
    toast.className = `toast align-items-center text-white ${bg} border-0 position-fixed bottom-0 end-0 m-3 show`;
    toast.role = "alert";
    toast.style.zIndex = "9999";
    toast.innerHTML = `
      <div class="d-flex">
        <div class="toast-body">${message}</div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    `;
    document.body.appendChild(toast);

    setTimeout(() => {
      toast.classList.remove("show");
      toast.remove();
    }, 3000);
  };
	</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const washingDateInput = document.getElementById('washingDate');
  const paymentStatusSection = document.getElementById('paymentStatusSection');

  washingDateInput.addEventListener('change', function () {
    const selectedDate = new Date(this.value);
    const today = new Date();

    // Compare dates without time part
    const isToday =
      selectedDate.getDate() === today.getDate() &&
      selectedDate.getMonth() === today.getMonth() &&
      selectedDate.getFullYear() === today.getFullYear();
      paymentStatusSection.classList.remove('d-none');
/*
    if (isToday) {
      paymentStatusSection.classList.remove('d-none');
    } else {
      paymentStatusSection.classList.add('d-none');
      document.getElementById('paymentStatus').value = ''; // clear when hidden
    }
	  */
  });
});
</script>



	<!-- Feather Icon JS -->
	<script src="assets/js/feather.min.js" type="712042956002651bb9418e95-text/javascript"></script>

	<!-- Slimscroll JS -->
	<script src="assets/js/jquery.slimscroll.min.js" type="712042956002651bb9418e95-text/javascript"></script>

	<!-- Datatable JS -->
	<script src="assets/js/jquery.dataTables.min.js" type="712042956002651bb9418e95-text/javascript"></script>
	<script src="assets/js/dataTables.bootstrap5.min.js" type="712042956002651bb9418e95-text/javascript"></script>

	<!-- Bootstrap Core JS -->
	<script src="assets/js/bootstrap.bundle.min.js" type="712042956002651bb9418e95-text/javascript"></script>

	<!-- Select2 JS -->
	<script src="assets/plugins/select2/js/select2.min.js" type="712042956002651bb9418e95-text/javascript"></script>

	<!-- Quill JS -->
    <script src="assets/plugins/quill/quill.min.js" type="712042956002651bb9418e95-text/javascript"></script>


	<!-- Bootstrap Tagsinput JS -->
	<script src="assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js" type="712042956002651bb9418e95-text/javascript"></script>

	<!-- Color Picker JS -->
	<script src="assets/plugins/%40simonwep/pickr/pickr.es5.min.js" type="712042956002651bb9418e95-text/javascript"></script>

	<!-- Custom JS -->
	<script src="assets/js/theme-colorpicker.js" type="712042956002651bb9418e95-text/javascript"></script>
	<script src="assets/js/script.js" type="712042956002651bb9418e95-text/javascript"></script>


<script src="../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="712042956002651bb9418e95-|49" defer></script><script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"98610c03fd3def4a","version":"2025.9.1","serverTiming":{"name":{"cfExtPri":true,"cfEdge":true,"cfOrigin":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}' crossorigin="anonymous"></script>
</body>


</html>