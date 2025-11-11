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
										<h4 class="fs-18 fw-bold">Working Hours</h4>
									</div>
									<div class="card-body">
											
										<form id="siteInfoForm" enctype="multipart/form-data">
											<?php 
$workingHours = getWorkingHours($conn);

if (!empty($workingHours)) {
    $dayOrder = [
        'Sunday' => 1,
        'Monday' => 2,
        'Tuesday' => 3,
        'Wednesday' => 4,
        'Thursday' => 5,
        'Friday' => 6,
        'Saturday' => 7
    ];

    usort($workingHours, function ($a, $b) use ($dayOrder) {
        $dayA = ucfirst(strtolower($a['day']));
        $dayB = ucfirst(strtolower($b['day']));
        return $dayOrder[$dayA] <=> $dayOrder[$dayB];
    });
}
?>

	<?php if (!empty($workingHours)): ?>
    <?php foreach ($workingHours as $workingHour): ?>
		            <input type="hidden" name="id[]" value="<?php echo $workingHour['id']; ?>">

        <div class="border-bottom mb-3">
            <div class="card-title-head">
                <h6 class="fs-16 fw-bold mb-2">
                    <span class="fs-16 me-2"><i class="ti ti-clock"></i></span> 
                    <?php echo $workingHour['day']; ?>
                </h6>
            </div>
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Opening<span class="text-danger">*</span></label>
                        <input type="time" class="form-control"
                            value="<?php echo $workingHour['open_time']; ?>" 
                                                    name="open_time[]">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Closing<span class="text-danger">*</span></label>
                        <input type="time" class="form-control"
                            value="<?php echo $workingHour['close_time']; ?>" 
                             name="close_time[]">
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No working hours.</p>
<?php endif; ?>

											
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

    fetch("process/update_working_hours.php", {
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