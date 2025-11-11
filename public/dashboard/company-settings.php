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
		<meta name="author" content="Dreams Technologies">
		<meta name="robots" content="index, follow">
		<title><?php echo $siteinfo['site_name'];?>  -  Admin Dashboard Template</title>
		

		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

		<!-- Apple Touch Icon -->
		<link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
		
		<!-- animation CSS -->
        <link rel="stylesheet" href="assets/css/animate.css">

		<!-- Select2 CSS -->
		<link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">

	

		<!-- Datetimepicker CSS -->
		<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">

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
		<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    </head>
    <body>
		
		<div id="global-loader" >
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
				<div class="content settings-content">
					<div class="page-header settings-pg-header">
						<div class="add-item d-flex">
							<div class="page-title">
								<h4>Settings</h4>
								<h6>Manage your settings on portal</h6>
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
					</div>
					<div class="row">
						<div class="col-xl-12">
							 <div class="settings-wrapper d-flex">
							
							 
								<div class="card flex-fill mb-0">
									<div class="card-header">
										<h4 class="fs-18 fw-bold">Company Settings</h4>
									</div>
									<div class="card-body">
										<form id="siteInfoForm" enctype="multipart/form-data">

											<div class="border-bottom mb-3">
												<div class="card-title-head">
													<h6 class="fs-16 fw-bold mb-2">
														<span class="fs-16 me-2"><i class="ti ti-building"></i></span> 
														Company Information
													</h6>
												</div>
												<div class="row">
															<div class="col-xl-6 col-lg-6 col-md-6">
														<div class="mb-3">
															<label class="form-label">
																Company Currency  <span class="text-danger">*</span>
															</label>
															<input type="text" class="form-control"
															 value="<?php echo $siteinfo['site_currency'];?>" name="site_currency">
														</div>
													</div>
													<div class="col-xl-6 col-lg-6 col-md-6">
														<div class="mb-3">
															<label class="form-label">
																Price Per Millage<span class="text-danger">*</span>
															</label>
															<input type="text" name="site_millage_price" class="form-control"  value="<?php echo $siteinfo['site_mileage_price'];?>">
														</div>
													</div>
												</div>
												<div class="row">
											
													<div class="col-xl-4 col-lg-6 col-md-4">
														<div class="mb-3">
															<label class="form-label">
																Company Name  <span class="text-danger">*</span>
															</label>
															<input type="text" class="form-control"
															 value="<?php echo $siteinfo['site_name'];?>" name="site_name">
														</div>
													</div>
													<div class="col-xl-4 col-lg-6 col-md-4">
														<div class="mb-3">
															<label class="form-label">
																Company Email Address  <span class="text-danger">*</span>
															</label>
															<input type="email" name="site_email" class="form-control"  value="<?php echo $siteinfo['site_email'];?>">
														</div>
													</div>
													<div class="col-md-4">
														<div class="mb-3">
															<label class="form-label">
																Phone Number <span class="text-danger">*</span>
															</label>
															<input type="text" name="site_phone" class="form-control"  value="<?php echo $siteinfo['site_phone'];?>">
														</div>
													</div>
											
												
												</div>
											</div>
											<div class="border-bottom mb-3 pb-3">
												<div class="card-title-head">
													<h6 class="fs-16 fw-bold mb-2">
														<span class="fs-16 me-2"><i class="ti ti-photo"></i></span> 
														Company Logo
													</h6>
												</div>
												<div class="row align-items-center gy-3">
													<div class="col-xl-9">
														<div class="row gy-3 align-items-center">
															<div class="col-lg-4">
																<div class="logo-info">
																	<h6 class="fw-medium">Company Icon</h6>
																	<p>Upload Icon of your Company</p>
																</div>
															</div>
															<div class="col-lg-8">
																<div class="profile-pic-upload mb-0 justify-content-lg-end">
																	<div class="new-employee-field">
																		<div class="mb-0">
																			<div class="image-upload mb-0">
																				<input type="file" name="site_logo">
																				<div class="image-uploads">
																					<h4><i class="ti ti-upload me-1"></i>Upload Image</h4>
																				</div>
																			</div>
																			<span class="mt-1">Recommended size is 450px x 450px. Max size 5mb.</span>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="col-xl-3">
														<div class="new-logo ms-xl-auto">
															<a href="#">
																<img src="<?php echo $siteinfo['site_logo'];?>" alt="Logo">
																<span><i class="ti ti-x"></i></span>
															</a>
														</div>
													</div>
												
												
												</div>
											</div>
											<div class="company-address">
												<div class="card-title-head">
													<h6 class="fs-16 fw-bold mb-2">
														<span class="fs-16 me-2"><i class="ti ti-map-pin"></i></span> 
														Address Information
													</h6>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="mb-3">
															<label class="form-label">
																Address <span class="text-danger">*</span>
															</label>
															<input  id="autocomplete" type="text" name="site_address" class="form-control"  value="<?php echo $siteinfo['site_address'];?>">
														</div>
													</div>
												
												<div class="col-md-6">
													<div class="mb-3">
														<label class="form-label">
															State <span class="text-danger">*</span>
														</label>
														<input id="site_state"  readonly  type="text" name="site_state" class="form-control" value="<?php echo $siteinfo['site_state'];?>">
													</div>
												</div>
												<div class="col-md-6">
													<div class="mb-3">
														<label class="form-label">
															City <span class="text-danger">*</span>
														</label>
														<input id="site_city" readonly  type="text" name="site_city" class="form-control" value="<?php echo $siteinfo['site_city'];?>">
													</div>
												</div>
												<input type="hidden" id="site_lon" name="site_lon" value="<?php echo $siteinfo['site_lon']; ?>">
												<input type="hidden" id="site_lat" name="site_lat" value="<?php echo $siteinfo['site_lat']; ?>">

												</div>
											</div>
											<div class="company-address">
												<div class="card-title-head">
													<h6 class="fs-16 fw-bold mb-2">
														<span class="fs-16 me-2"><i class="ti ti-book"></i></span> 
														Terms
													</h6>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="mb-3">
															<label class="form-label">
																Note <span class="text-danger">*</span>
															</label>
															<input  type="text" name="site_note" class="form-control" 
															 value="<?php echo $siteinfo['site_note'];?>">
														</div>
													</div>
													<div class="col-md-12">
														<div class="mb-3">
															<label class="form-label">
																Terms <span class="text-danger">*</span>
															</label>
															<textarea name="site_terms" class="form-control"><?php echo $siteinfo['site_terms'];?></textarea>
														
														</div>
													</div>
									
												</div>
											</div>
											<div class="text-end settings-bottom-btn mt-0">
												<button type="button" class="btn btn-secondary me-2">Cancel</button>
												<button type="submit" class="btn btn-primary" id="saveBtn">Save Changes</button>
											</div>
										</form>
									</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
							<?php require_once __DIR__ . "/../../src/views/footer.php";?>

			</div>
        </div>
		<!-- /Main Wrapper -->
		  		 <!-- Toast Container (top-right corner) -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
  <div id="toastMessage" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div id="toastText" class="toast-body">
        <!-- Message will appear here -->
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>


		<!-- jQuery -->
        <script src="assets/js/jquery-3.7.1.min.js" type="e801496cd9c52f594b01b48a-text/javascript"></script>
<script>
document.querySelector("#siteInfoForm").addEventListener("submit", function(e) {
    e.preventDefault();

    let form = this;
    let formData = new FormData(form);
    let submitBtn = document.querySelector("#saveBtn");
    let originalText = submitBtn.innerHTML;

    // Show processing
    submitBtn.disabled = true;
    submitBtn.innerHTML = "Processing...";

    fetch("process/update_siteinfo.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
			                    showToast(data.message, "success");

        } else {
			                    showToast(data.message, "error");

        }
    })
    .catch(() => toastr.error("Something went wrong!"))
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });

	
});

    // Reusable Toast
    function showToast(message, status) {
        const toastEl = document.getElementById("toastMessage");
        const toastText = document.getElementById("toastText");
        toastEl.className = `toast align-items-center text-white border-0 ${status === "success" ? "bg-success" : "bg-danger"}`;
        toastText.textContent = message;
        new bootstrap.Toast(toastEl, { delay: 2000 }).show();
    }
</script>


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

    document.getElementById('site_state').value = state;
    document.getElementById('site_city').value = city;
    document.getElementById('site_lat').value = place.geometry.location.lat();
    document.getElementById('site_lon').value = place.geometry.location.lng();
	console.log(place.geometry.location.lng());
	console.log(place.geometry.location.lat());
}

window.onload = initAutocomplete;
</script>
        <!-- Feather Icon JS -->
		<script src="assets/js/feather.min.js" type="e801496cd9c52f594b01b48a-text/javascript"></script>

		<!-- Slimscroll JS -->
		<script src="assets/js/jquery.slimscroll.min.js" type="e801496cd9c52f594b01b48a-text/javascript"></script>

		<!-- Datatable JS -->
		<script src="assets/js/jquery.dataTables.min.js" type="e801496cd9c52f594b01b48a-text/javascript"></script>
		<script src="assets/js/dataTables.bootstrap5.min.js" type="e801496cd9c52f594b01b48a-text/javascript"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="assets/js/bootstrap.bundle.min.js" type="e801496cd9c52f594b01b48a-text/javascript"></script>
		
		<!-- Datetimepicker JS -->
		<script src="assets/js/moment.min.js" type="e801496cd9c52f594b01b48a-text/javascript"></script>
		<script src="assets/js/bootstrap-datetimepicker.min.js" type="e801496cd9c52f594b01b48a-text/javascript"></script>

		<!-- Quill JS -->
    <script src="assets/plugins/quill/quill.min.js" type="e801496cd9c52f594b01b48a-text/javascript"></script>

		<!-- Select2 JS -->
		<script src="assets/plugins/select2/js/select2.min.js" type="e801496cd9c52f594b01b48a-text/javascript"></script>

		<!-- Sticky-sidebar -->
		<script src="assets/plugins/theia-sticky-sidebar/ResizeSensor.js" type="e801496cd9c52f594b01b48a-text/javascript"></script>
		<script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js" type="e801496cd9c52f594b01b48a-text/javascript"></script>


		<!-- Color Picker JS -->
		<script src="assets/plugins/%40simonwep/pickr/pickr.es5.min.js" type="e801496cd9c52f594b01b48a-text/javascript"></script>

		<!-- Custom JS -->
		<script src="assets/js/theme-colorpicker.js" type="e801496cd9c52f594b01b48a-text/javascript"></script>
		<script src="assets/js/script.js" type="e801496cd9c52f594b01b48a-text/javascript"></script>
			   
		   
    <script src="../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="e801496cd9c52f594b01b48a-|49" defer></script><script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"98610d973cbf7725","version":"2025.9.1","serverTiming":{"name":{"cfExtPri":true,"cfEdge":true,"cfOrigin":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}' crossorigin="anonymous"></script>
</body>

</html>