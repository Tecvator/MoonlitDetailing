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
		
		<?php include ("../../src/views/header.php");?>
		<!-- /Header -->

		<!-- Sidebar -->
			<?php include ("../../src/views/sidemenu.php");?>
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
            <!-- Filter: Payment Status -->
            <div class="dropdown me-2">
                <a href="javascript:void(0);" class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center" data-bs-toggle="dropdown">
                    Payment Status
                </a>
                <ul class="dropdown-menu dropdown-menu-end p-3">
                    <li><a href="javascript:void(0);" class="dropdown-item rounded-1 filter-payment" data-status="all">All</a></li>
                    <li><a href="javascript:void(0);" class="dropdown-item rounded-1 filter-payment" data-status="paid">Paid</a></li>
                    <li><a href="javascript:void(0);" class="dropdown-item rounded-1 filter-payment" data-status="unpaid">Unpaid</a></li>
                </ul>
            </div>
            
            <!-- Filter: Wash Status -->
            <div class="dropdown me-2">
                <a href="javascript:void(0);" class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center" data-bs-toggle="dropdown">
                    Wash Status
                </a>
                <ul class="dropdown-menu dropdown-menu-end p-3">
                    <li><a href="javascript:void(0);" class="dropdown-item rounded-1 filter-wash" data-status="all">All</a></li>
                    <li><a href="javascript:void(0);" class="dropdown-item rounded-1 filter-wash" data-status="pending">Pending</a></li>
                    <li><a href="javascript:void(0);" class="dropdown-item rounded-1 filter-wash" data-status="completed">Completed</a></li>
                </ul>
            </div>
            
            <!-- Sort -->
            <div class="dropdown">
                <a href="javascript:void(0);" class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center" data-bs-toggle="dropdown">
                    Sort By
                </a>
                <ul class="dropdown-menu dropdown-menu-end p-3">
                    <li><a href="javascript:void(0);" class="dropdown-item rounded-1 sort-by" data-sort="recent">Recently Added</a></li>
                    <li><a href="javascript:void(0);" class="dropdown-item rounded-1 sort-by" data-sort="oldest">Oldest First</a></li>
                    <li><a href="javascript:void(0);" class="dropdown-item rounded-1 sort-by" data-sort="amount-high">Amount: High to Low</a></li>
                    <li><a href="javascript:void(0);" class="dropdown-item rounded-1 sort-by" data-sort="amount-low">Amount: Low to High</a></li>
                </ul>
            </div>
        </div>
    </div>
    

             <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table datatable" id="invoiceTable">
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
                        <th>Receipt URL</th>
                        <th>Callout Fee</th>
                        <th>Total Amount</th>
                        <th>Product</th>
                        <th>Payment Status</th>
                        <th>Wash Status</th>
                        <th class="no-sort">Actions</th>
                    </tr>
                </thead>
            <tbody>
    <?php
    $bookings = getAllBookings($conn);
    if (!empty($bookings)):
        foreach ($bookings as $booking): 
            $baseAmount = floatval($booking['price']) - floatval($booking['callout_fee'] ?? 0);
            $calloutFee = floatval($booking['callout_fee'] ?? 0);
            $totalAmount = floatval($booking['price']);
            $washStatus = $booking['washing_status'] ?? 'pending';
            $receiptInfo = $booking['payment_receipt'] ?? 'No Receipt';
            ?>
        <tr data-payment="<?php echo htmlspecialchars($booking['payment_status']); ?>" 
            data-wash="<?php echo htmlspecialchars($washStatus); ?>"
            data-amount="<?php echo $totalAmount; ?>"
            data-date="<?php echo strtotime($booking['created_at'] ?? date('Y-m-d')); ?>">
            <td>
                <label class="checkboxs">
                    <input type="checkbox" />
                    <span class="checkmarks"></span>
                </label>
            </td>
            <td>
                <a href="invoice-details.php?id=<?php echo $booking['id']; ?>">
                    INV<?php echo str_pad($booking['id'], 3, '0', STR_PAD_LEFT); ?>
                </a>
            </td>
            <td>
                <a href="javascript:void(0);"><?php echo htmlspecialchars($booking['customer_name']); ?></a>
            </td>
            <td><?php echo htmlspecialchars($booking['car_type']); ?></td>
            <td>
                <?php
                  if($receiptInfo){

                       if (!empty($receiptInfo) && strtolower($receiptInfo) !== 'no receipt' && strtolower($receiptInfo) !== 'no receipt uploaded') {

        // check path
        if (!preg_match('/^https?:\/\//', $receiptInfo) && !preg_match('/^uploads\//', $receiptInfo)) {
            $receipt = 'uploads/receipts/' . basename($receiptInfo);
        }

        echo '<a href="'.htmlspecialchars($receiptInfo).'" target="_blank" class="badge badge-soft-primary badge-xs">
                <i class="ti ti-file-text me-1"></i>View Receipt
              </a>';

    } else {
        echo '<span class="badge badge-soft-secondary badge-xs">No receipt uploaded</span>';
    }

                  }else{
                    echo "No Receipt";
                  }
              
                ?>
            </td>
            <td>
                <?php if ($calloutFee > 0): ?>
                    <span class="badge badge-soft-info badge-xs">
                        <?php echo $siteinfo['site_currency']." ".number_format($calloutFee, 2); ?>
                    </span>
                <?php else: ?>
                    <span class="text-muted">-</span>
                <?php endif; ?>
            </td>
            <td><strong><?php echo $siteinfo['site_currency']." ".number_format($totalAmount, 2); ?></strong></td>
            <td><?php echo htmlspecialchars($booking['product_name']); ?></td>
            <td>
                <?php if ($booking['payment_status'] === "paid"): ?>
                    <span class="badge badge-soft-success badge-xs shadow-none">
                        <i class="ti ti-point-filled me-1"></i>Paid
                    </span>
                <?php else: ?>
                    <span class="badge badge-soft-danger badge-xs shadow-none">
                        <i class="ti ti-point-filled me-1"></i>Unpaid
                    </span>
                    <a href="javascript:void(0);" 
                       class="ms-2 text-success update-payment-status" 
                       data-id="<?php echo $booking['id']; ?>"
                       title="Mark as Paid">
                        <i class="ti ti-circle-check fs-18"></i>
                    </a>
                <?php endif; ?>
            </td>
            <td>
                <?php if ($washStatus === "completed"): ?>
                    <span class="badge badge-soft-success badge-xs shadow-none">
                        <i class="ti ti-point-filled me-1"></i>Completed
                    </span>
                <?php else: ?>
                    <span class="badge badge-soft-warning badge-xs shadow-none">
                        <i class="ti ti-point-filled me-1"></i>Pending
                    </span>
                    <a href="javascript:void(0);" 
                       class="ms-2 text-primary update-wash-status" 
                       data-id="<?php echo $booking['id']; ?>"
                       title="Mark as Completed">
                        <i class="ti ti-checks fs-18"></i>
                    </a>
                <?php endif; ?>
            </td>
            <td>
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
        <tr><td colspan="11" class="text-center">No bookings found</td></tr>
    <?php endif; ?>
</tbody>
            </table>
        </div>
    </div>
</div>


</table>

							</div>
						</div>
					</div>
					<!-- /product list -->
				</div>
			<?php require_once __DIR__ . "/../../src/views/footer.php";?>
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
<!-- ✅ Mark as Paid Modal -->
<div class="modal fade" id="markPaidModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="page-wrapper-new p-0">
        <div class="content p-5 px-3 text-center">
          <span class="rounded-circle d-inline-flex p-2 bg-success-transparent mb-2">
            <i class="ti ti-circle-check fs-24 text-success"></i>
          </span>
          <h4 class="fs-20 text-gray-9 fw-bold mb-2 mt-1">
            Mark Invoice as Paid
          </h4>
          <p class="text-gray-6 mb-0 fs-16">
            Are you sure you want to mark this invoice as <strong>Paid</strong>?
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
              class="btn btn-success fs-13 fw-medium p-2 px-3 markPaidBtn"
            >
              Yes, Mark Paid
            </button>
            <input id="invoiceToMarkPaid" type="hidden" />
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

    <!-- ✅ Complete Wash Modal -->
<div class="modal fade" id="completeWashModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="page-wrapper-new p-0">
        <div class="content p-5 px-3 text-center">
          <span class="rounded-circle d-inline-flex p-2 bg-primary-transparent mb-2">
            <i class="ti ti-checks fs-24 text-primary"></i>
          </span>
          <h4 class="fs-20 text-gray-9 fw-bold mb-2 mt-1">
            Mark Wash as Completed
          </h4>
          <p class="text-gray-6 mb-0 fs-16">
            Are you sure you want to mark this wash as completed?
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
              class="btn btn-primary fs-13 fw-medium p-2 px-3 completeWashBtn"
            >
              Yes, Mark Completed
            </button>
            <input id="washToComplete" type="hidden" />
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
        <script src="assets/js/jquery-3.7.1.min.js" ></script>


<script>
document.addEventListener("DOMContentLoaded", () => {


    // ========== FILTERING ==========
    
    // Payment Status Filter
    document.querySelectorAll('.filter-payment').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const status = this.dataset.status;
            
            if (status === 'all') {
                table.column(8).search('').draw();
            } else {
                table.column(8).search(status).draw();
            }
        });
    });
    
    // Wash Status Filter
    document.querySelectorAll('.filter-wash').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const status = this.dataset.status;
            
            if (status === 'all') {
                table.column(9).search('').draw();
            } else {
                table.column(9).search(status).draw();
            }
        });
    });
    
    // ========== SORTING ==========
    
    document.querySelectorAll('.sort-by').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const sortType = this.dataset.sort;
            
            switch(sortType) {
                case 'recent':
                    table.order([1, 'desc']).draw();
                    break;
                case 'oldest':
                    table.order([1, 'asc']).draw();
                    break;
                case 'amount-high':
                    table.order([6, 'desc']).draw();
                    break;
                case 'amount-low':
                    table.order([6, 'asc']).draw();
                    break;
            }
        });
    });

    // ========== UPDATE PAYMENT STATUS ==========
document.addEventListener('click', function (e) {
  const btn = e.target.closest('.update-payment-status');
  if (!btn) return;

  e.preventDefault();

  const invoiceId = btn.dataset.id;
  const markPaidModal = new bootstrap.Modal(document.getElementById('markPaidModal'));
  const hiddenInput = document.getElementById('invoiceToMarkPaid');
  hiddenInput.value = invoiceId;

  markPaidModal.show();

  const confirmBtn = document.querySelector('#markPaidModal .markPaidBtn');
  confirmBtn.onclick = function () {
    confirmBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
    confirmBtn.disabled = true;

    fetch('process/update_status.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams({
        action: 'update_payment_status',
        id: invoiceId,
        status: 'paid'
      })
    })
      .then(res => res.json())
      .then(data => {
        if (data.status === 'success') {
          showToast('success', 'Payment status updated to Paid!');
          markPaidModal.hide();
          setTimeout(() => location.reload(), 1000);
        } else {
          showToast('error', data.message || 'Failed to update status');
          confirmBtn.innerHTML = 'Yes, Mark Paid';
          confirmBtn.disabled = false;
        }
      })
      .catch(() => {
        showToast('error', 'Something went wrong!');
        confirmBtn.innerHTML = 'Yes, Mark Paid';
        confirmBtn.disabled = false;
      });
  };
});

    // ========== UPDATE WASH STATUS ==========
    
  document.addEventListener('click', function (e) {
  const btn = e.target.closest('.update-wash-status');
  if (!btn) return;

  e.preventDefault();

  const washId = btn.dataset.id;
  const completeModal = new bootstrap.Modal(document.getElementById('completeWashModal'));
  const hiddenInput = document.getElementById('washToComplete');
  hiddenInput.value = washId;

  completeModal.show();

  const confirmBtn = document.querySelector('#completeWashModal .completeWashBtn');
  confirmBtn.onclick = function () {
    confirmBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
    confirmBtn.disabled = true;

    fetch('process/update_status.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams({
        action: 'update_wash_status',
        id: washId,
        status: 'completed'
      })
    })
      .then(res => res.json())
      .then(data => {
        if (data.status === 'success') {
          showToast('success', 'Wash status updated to Completed!');
          completeModal.hide();
          setTimeout(() => location.reload(), 1000);
        } else {
          showToast('error', data.message || 'Failed to update status');
          confirmBtn.innerHTML = 'Yes, Mark Completed';
          confirmBtn.disabled = false;
        }
      })
      .catch(() => {
        showToast('error', 'Something went wrong!');
        confirmBtn.innerHTML = 'Yes, Mark Completed';
        confirmBtn.disabled = false;
      });
  };
});


    // ========== DELETE BOOKING ==========
    
    const deleteModal = document.getElementById("delete-modal");
    const deleteBtn = deleteModal.querySelector(".deleteBtn");
    const itemInput = document.getElementById("itemToDelete");
    let isDeleting = false;

    document.querySelector('.table.datatable tbody').addEventListener("click", function(e) {
        const deleteTrigger = e.target.closest(".deleteTrigger");
        if (deleteTrigger) {
            e.preventDefault();
            const id = deleteTrigger.getAttribute("data-id");
            itemInput.value = id;
        }
    });

    deleteBtn.addEventListener("click", function (e) {
        e.preventDefault();
        
        if (isDeleting) return;
        
        const id = itemInput.value;
        if (!id) return showToast("error", "No record selected!");

        isDeleting = true;
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
                const row = document.querySelector(`.deleteTrigger[data-id="${id}"]`)?.closest("tr");
                if (row) {
                    table.row(row).remove().draw();
                }
                const modalInstance = bootstrap.Modal.getInstance(deleteModal);
                if (modalInstance) modalInstance.hide();
            } else {
                showToast("error", data.message || "Failed to delete booking!");
            }
        })
        .catch(() => showToast("error", "Something went wrong!"))
        .finally(() => {
            isDeleting = false;
            deleteBtn.disabled = false;
            deleteBtn.innerHTML = "Yes Delete";
        });
    });

    // ========== TOAST HELPER ==========
    
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
    
    window.showToast = showToast;
});
</script>

        <!-- Feather Icon JS -->
		<script src="assets/js/feather.min.js" ></script>

		<!-- Slimscroll JS -->
		<script src="assets/js/jquery.slimscroll.min.js" ></script>

		<!-- Datatable JS -->
		<script src="assets/js/jquery.dataTables.min.js" ></script>
		<script src="assets/js/dataTables.bootstrap5.min.js" ></script>
		
		<!-- Bootstrap Core JS -->
        <script src="assets/js/bootstrap.bundle.min.js" ></script>
		
		<!-- Datetimepicker JS -->
		<script src="assets/js/moment.min.js" ></script>
		<script src="assets/js/bootstrap-datetimepicker.min.js" ></script>

		<!-- Quill JS -->
    <script src="assets/plugins/quill/quill.min.js" ></script>

		<!-- Select2 JS -->
		<script src="assets/plugins/select2/js/select2.min.js" ></script>

		<!-- Color Picker JS -->
		<script src="assets/plugins/%40simonwep/pickr/pickr.es5.min.js" ></script>

		<!-- Custom JS -->
		<script src="assets/js/theme-colorpicker.js" ></script>
		<script src="assets/js/script.js" ></script>

	
</body>

</html>