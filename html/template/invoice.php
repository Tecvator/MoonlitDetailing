<?php 
include "../../includes/session.php";



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
		<title><?php echo $siteinfo['site_name'];?> -Admin Dashboard Template</title>
		

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

		<!-- Quill CSS -->
    <link rel="stylesheet" href="assets/plugins/quill/quill.snow.css">

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
		
    </head>
    <body>
		
		<div id="global-loader" >
			<div class="whirly-loader"> </div>
		</div>

		<!-- Main Wrapper -->
        <div class="main-wrapper">
		
		
			
			<!-- Header -->
		
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
								<h4>Invoices</h4>
								<h6>Manage your  invoices</h6>
							</div>							
						</div>
						<ul class="table-top-head">
							<li>
								<a data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf"><img src="assets/img/icons/pdf.svg" alt="img"></a>
							</li>
							<li>
								<a data-bs-toggle="tooltip" data-bs-placement="top" title="Excel"><img src="assets/img/icons/excel.svg" alt="img"></a>
							</li>
							<li>
								<a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i class="ti ti-refresh"></i></a>
							</li>
							<li>
								<a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i class="ti ti-chevron-up"></i></a>
							</li>
						</ul>
					</div>
					
					<div class="card">
						<div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
							<div class="search-set">
								<div class="search-input">
									<span class="btn-searchset"><i class="ti ti-search fs-14 feather-search"></i></span>
								</div>
							</div>
							<div class="d-flex table-dropdown my-xl-auto right-content align-items-center flex-wrap row-gap-3">
								<div class="dropdown me-2">
									<a href="javascript:void(0);" class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center" data-bs-toggle="dropdown">
										Customer
									</a>
									<ul class="dropdown-menu  dropdown-menu-end p-3">
										<li>
											<a href="javascript:void(0);" class="dropdown-item rounded-1">Carl Evans</a>
										</li>
										<li>
											<a href="javascript:void(0);" class="dropdown-item rounded-1">Minerva Rameriz</a>
										</li>
										<li>
											<a href="javascript:void(0);" class="dropdown-item rounded-1">Robert Lamon</a>
										</li>
										<li>
											<a href="javascript:void(0);" class="dropdown-item rounded-1">Patricia Lewis</a>
										</li>
									</ul>
								</div>
								<div class="dropdown me-2">
									<a href="javascript:void(0);" class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center" data-bs-toggle="dropdown">
										Status
									</a>
									<ul class="dropdown-menu  dropdown-menu-end p-3">
										<li>
											<a href="javascript:void(0);" class="dropdown-item rounded-1">Paid</a>
										</li>
										<li>
											<a href="javascript:void(0);" class="dropdown-item rounded-1">Unpaid</a>
										</li>
										<li>
											<a href="javascript:void(0);" class="dropdown-item rounded-1">Overdue</a>
										</li>
									</ul>
								</div>
								<div class="dropdown">
									<a href="javascript:void(0);" class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center" data-bs-toggle="dropdown">
										Sort By : Last 7 Days
									</a>
									<ul class="dropdown-menu  dropdown-menu-end p-3">
										<li>
											<a href="javascript:void(0);" class="dropdown-item rounded-1">Recently Added</a>
										</li>
										<li>
											<a href="javascript:void(0);" class="dropdown-item rounded-1">Ascending</a>
										</li>
										<li>
											<a href="javascript:void(0);" class="dropdown-item rounded-1">Desending</a>
										</li>
										<li>
											<a href="javascript:void(0);" class="dropdown-item rounded-1">Last Month</a>
										</li>
										<li>
											<a href="javascript:void(0);" class="dropdown-item rounded-1">Last 7 Days</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="card-body p-0">
							<div class="table-responsive">
								<table class="table datatable">
  <thead class="thead-light">
    <tr>
      <th class="no-sort">
        <label class="checkboxs">
          <input type="checkbox" id="select-all" />
          <span class="checkmarks"></span>
        </label>
      </th>
      <th>Invoice No</th>
      <th>Customer</th>
      <th>Car Type</th>
      <th>Amount</th>
      <th>Product</th>
      <th>Status</th>
      <th class="no-sort"></th>
    </tr>
  </thead>
  <tbody>
    <?php
    $bookings = getAllBookings($conn); // 🔹 function to fetch all bookings
    if (!empty($bookings)):
      foreach ($bookings as $booking): ?>
        <tr>
          <td>
            <label class="checkboxs">
              <input type="checkbox" />
              <span class="checkmarks"></span>
            </label>
          </td>
          <td><a href="invoice-details.php?id=<?php echo $booking['id']; ?>">INV<?php echo str_pad($booking['id'], 3, '0', STR_PAD_LEFT); ?></a></td>
          <td>
            <div class="d-flex align-items-center">
            
              <a href="javascript:void(0);"><?php echo htmlspecialchars($booking['customer_name']); ?></a>
            </div>
          </td>
          <td><?php echo htmlspecialchars($booking['car_type']); ?></td>
          <td>₦<?php echo number_format($booking['price'], 2); ?></td>
          <td><?php echo htmlspecialchars($booking['product_name']); ?></td>
          <td>
            <?php if ($booking['payment_status'] === "paid"): ?>
              <span class="badge badge-soft-success badge-xs shadow-none"><i class="ti ti-point-filled me-1"></i>Paid</span>
            <?php else: ?>
              <span class="badge badge-soft-danger badge-xs shadow-none"><i class="ti ti-point-filled me-1"></i>Unpaid</span>
            <?php endif; ?>
          </td>
          <td class="d-flex">
            <div class="edit-delete-action d-flex align-items-center justify-content-center">
              <a class="me-2 p-2 d-flex align-items-center justify-content-between border rounded"
                 href="invoice-details.php?id=<?php echo $booking['id']; ?>">
                <i data-feather="eye" class="feather-eye"></i>
              </a>
              <a class="p-2 d-flex align-items-center justify-content-between border rounded deleteTrigger"
                 href="javascript:void(0);"
                 data-id="<?php echo $booking['id']; ?>"
                 data-bs-toggle="modal"
                 data-bs-target="#delete-modal">
                <i data-feather="trash-2" class="feather-trash-2"></i>
              </a>
            </div>
          </td>
        </tr>
      <?php endforeach;
    else: ?>
      <tr><td colspan="9" class="text-center">No bookings found</td></tr>
    <?php endif; ?>
  </tbody>
</table>

							</div>
						</div>
					</div>
					<!-- /product list -->
				</div>
			<?php include "../../includes/footer.php";?>
			</div>
        </div>
		<!-- /Main Wrapper -->
 <!-- delete modal -->
    <div class="modal fade" id="delete-modal">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="page-wrapper-new p-0">
            <div class="content p-5 px-3 text-center">
              <span
                class="rounded-circle d-inline-flex p-2 bg-danger-transparent mb-2"
                ><i class="ti ti-trash fs-24 text-danger"></i
              ></span>
              <h4 class="fs-20 text-gray-9 fw-bold mb-2 mt-1">
                Delete Invoice
              </h4>
              <p class="text-gray-6 mb-0 fs-16">
                Are you sure you want to delete this invoice?
              </p>
              <div class="modal-footer-btn mt-3 d-flex justify-content-center">
                <button
                  type="button"
                  class="btn me-2 btn-secondary fs-13 fw-medium p-2 px-3 shadow-none"
                  data-bs-dismiss="modal"
                >
                  Cancel
                </button>
             <button
          type="button"
          class="btn btn-primary fs-13 fw-medium p-2 px-3 deleteBtn"
        >
          Yes Delete
        </button>

                <input id="itemToDelete" style="display: none"/>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
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
        <script src="assets/js/jquery-3.7.1.min.js" type="3027f72734665fe206ae152a-text/javascript"></script>
<script>
	
document.addEventListener("DOMContentLoaded", () => {
  const deleteModal = document.getElementById("delete-modal");
  const deleteBtn = deleteModal.querySelector(".deleteBtn");
  const itemInput = document.getElementById("itemToDelete");
  let isDeleting = false; // 🔹 Prevent double submission

  // Use event delegation on parent table (prevents duplication)
  document.querySelector('.table.datatable tbody').addEventListener("click", function(e) {
    const deleteTrigger = e.target.closest(".deleteTrigger");
    if (deleteTrigger) {
      e.preventDefault(); // 🔹 Stop event propagation
      const id = deleteTrigger.getAttribute("data-id");
      itemInput.value = id;
    }
  });

  // Confirm deletion (with safeguard)
  deleteBtn.addEventListener("click", function (e) {
    e.preventDefault(); // 🔹 Prevent form submission
    
    if (isDeleting) return; // 🔹 Already processing, ignore
    
    const id = itemInput.value;
    if (!id) return showToast("error", "No record selected!");

    isDeleting = true; // 🔹 Lock deletion
    deleteBtn.disabled = true;
    deleteBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>Deleting...`;

    fetch("process/booking_process.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: new URLSearchParams({ action: "delete_booking", id }),
    })
      .then(res => res.json())
      .then(data => {
        if (data.status === "success") {
          showToast("success", data.message || "Booking deleted!");
          // Remove row from table
          const row = document.querySelector(`.deleteTrigger[data-id="${id}"]`)?.closest("tr");
          if (row) row.remove();
          
          // Close modal
          const modalInstance = bootstrap.Modal.getInstance(deleteModal);
          if (modalInstance) modalInstance.hide();
        } else {
          showToast("error", data.message || "Failed to delete booking!");
        }
      })
      .catch(() => showToast("error", "Something went wrong!"))
      .finally(() => {
        isDeleting = false; // 🔹 Unlock deletion
        deleteBtn.disabled = false;
        deleteBtn.innerHTML = "Yes Delete";
      });
  }, { once: false }); // 🔹 Don't remove listener after first click

  // Toast helper
  function showToast(type, message) {
    const bg = type === "success" ? "bg-success" : "bg-danger";
    const toast = document.createElement("div");
    toast.className = `toast align-items-center text-white ${bg} border-0 position-fixed bottom-0 end-0 m-3 show`;
    toast.role = "alert";
    toast.style.zIndex = "9999";
    toast.innerHTML = `
      <div class="d-flex">
        <div class="toast-body">${message}</div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>`;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
  }
});

</script>

        <!-- Feather Icon JS -->
		<script src="assets/js/feather.min.js" type="3027f72734665fe206ae152a-text/javascript"></script>

		<!-- Slimscroll JS -->
		<script src="assets/js/jquery.slimscroll.min.js" type="3027f72734665fe206ae152a-text/javascript"></script>

		<!-- Datatable JS -->
		<script src="assets/js/jquery.dataTables.min.js" type="3027f72734665fe206ae152a-text/javascript"></script>
		<script src="assets/js/dataTables.bootstrap5.min.js" type="3027f72734665fe206ae152a-text/javascript"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="assets/js/bootstrap.bundle.min.js" type="3027f72734665fe206ae152a-text/javascript"></script>
		
		<!-- Datetimepicker JS -->
		<script src="assets/js/moment.min.js" type="3027f72734665fe206ae152a-text/javascript"></script>
		<script src="assets/js/bootstrap-datetimepicker.min.js" type="3027f72734665fe206ae152a-text/javascript"></script>

		<!-- Quill JS -->
    <script src="assets/plugins/quill/quill.min.js" type="3027f72734665fe206ae152a-text/javascript"></script>

		<!-- Select2 JS -->
		<script src="assets/plugins/select2/js/select2.min.js" type="3027f72734665fe206ae152a-text/javascript"></script>

		<!-- Color Picker JS -->
		<script src="assets/plugins/%40simonwep/pickr/pickr.es5.min.js" type="3027f72734665fe206ae152a-text/javascript"></script>

		<!-- Custom JS -->
		<script src="assets/js/theme-colorpicker.js" type="3027f72734665fe206ae152a-text/javascript"></script>
		<script src="assets/js/script.js" type="3027f72734665fe206ae152a-text/javascript"></script>

	
    <script src="../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="3027f72734665fe206ae152a-|49" defer></script><script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"98610ce06c98ef4a","version":"2025.9.1","serverTiming":{"name":{"cfExtPri":true,"cfEdge":true,"cfOrigin":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}' crossorigin="anonymous"></script>
</body>

</html>