<?php 

require_once __DIR__ . "/../../src/config/session.php";

  if (isset($_GET['id'])) {
    $productID = intval($_GET['id']);
    $product = getProductById($conn, $productID);

    if (!$product)  {
        echo "product not found.";
    }
} else {
    header("Location: index.php");
    exit;
}
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
							<h4 class="fw-bold">Edit Product</h4>
							<h6>edit this product </h6>
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
						<a href="product-list.php" class="btn btn-secondary"><i data-feather="arrow-left" class="me-2"></i>Back to Product</a>
					</div>
				</div>
				<form  class="add-product-form">
					<div class="add-product">
						<div class="accordions-items-seperate" id="accordionSpacingExample">
							<div class="accordion-item border mb-4">
								<h2 class="accordion-header" id="headingSpacingOne">
									<div class="accordion-button collapsed bg-white" data-bs-toggle="collapse" data-bs-target="#SpacingOne" aria-expanded="true" aria-controls="SpacingOne">
										<div class="d-flex align-items-center justify-content-between flex-fill">
										<h5 class="d-flex align-items-center"><i data-feather="info" class="text-primary me-2"></i><span>Product Information</span></h5>
										</div>
									</div>
								</h2>
								<div id="SpacingOne" class="accordion-collapse collapse show" aria-labelledby="headingSpacingOne">
									<div class="accordion-body border-top">
										
									<div class="row">
											<div class="col-sm-4 col-12">
												<div class="mb-3">
													<label class="form-label">Product Name<span class="text-danger ms-1">*</span></label>
													<input type="text" value="<?php echo $product['product_name'];?>" class="form-control" name="product_name" required>
													<input type="text" value="<?php echo $product['id'];?>" hidden class="form-control" name="product_id" required>
												</div>
											</div>
											<div class="col-sm-4 col-12">
												<div class="mb-3">
													<label class="form-label">Washing Hours
														 <span class="text-muted">(write the number only)<span class="text-danger ms-1">*</span></label>
													<input type="text" class="form-control" name="product_hours" value="<?php echo $product['max_hours'];?>"  required>
												</div>
											</div>
											<div class="col-sm-4 col-12">
												<div class="mb-3">
                                                  
													<label class="form-label">Category<span class="text-danger ms-1">*</span></label>
															<select class="select" name="category_id" required>
														<option>Select</option>
														<?php        $categories = getCategories($conn);?>

															  <?php if (!empty($categories)): ?>
   																 <?php foreach ($categories as $category): ?>
														<option value="<?php echo $category['category_id'];?>"
                                                         <?php if($product['category_id'] == $category['category_id']){echo "selected";}?> >
															<?php echo $category['category_name'];?></option>
														    <?php endforeach; ?>
															<?php else: ?>
																<p>No category.</p>
															<?php endif; ?>

													</select>
												</div>
											</div>
										
										</div>
									
															<!-- Editor Box -->
						<div class="col-lg-12">
						<div class="summer-description-box">
							<label class="form-label">Description</label>
							<div class="editor pages-editor"><?php echo($product['product_description']); ?></div>
							<p class="fs-14 mt-1">Maximum 60 Words</p>
						</div>
						</div>

						<!-- Hidden textarea for backend -->
						<textarea name="description" id="description" hidden></textarea>


									</div>
								</div>
							</div>
							<div class="accordion-item border mb-4"> 
								<h2 class="accordion-header" id="headingSpacingTwo">
									<div class="accordion-button collapsed bg-white" data-bs-toggle="collapse" data-bs-target="#SpacingTwo" aria-expanded="true" aria-controls="SpacingTwo">
										<div class="d-flex align-items-center justify-content-between flex-fill">
										<h5 class="d-flex align-items-center">
											<i data-feather="life-buoy" class="text-primary me-2"></i><span>Pricing based on car type</span></h5>
										</div>
									</div>
								</h2>
								<div id="SpacingTwo" class="accordion-collapse collapse show" aria-labelledby="headingSpacingTwo">
									<div class="accordion-body border-top">
										
										<div class="tab-content" id="pills-tabContent">
											<div class="tab-pane fade show active" id="pills-home" role="tabpanel"
												aria-labelledby="pills-home-tab">
												<div class="single-product">
										<div class="row">
    <?php 
        $cartypes = getCarTypes($conn);
        // Create a map of car_type_id => price from the existing product prices
        $existingPrices = [];
        if (!empty($product['prices'])) {
            foreach ($product['prices'] as $price) {
                $existingPrices[$price['car_type_id']] = $price['price'];
            }
        }
    ?>

    <?php if (!empty($cartypes)): ?>
        <?php foreach ($cartypes as $cartype): 
            $carId = $cartype['car_id'];
            $priceValue = isset($existingPrices[$carId]) ? $existingPrices[$carId] : '';
        ?>
            <div class="col-lg-4 col-sm-6 col-12">
                <div class="mb-3">
                    <label class="form-label">
                        <?php echo htmlspecialchars($cartype['car_name']); ?>
                        <span class="text-danger ms-1">*</span>
                    </label>
                    <input 
                        type="number" 
                        step="0.01" 
                        class="form-control"
                        name="prices[<?php echo $carId; ?>]"
                        value="<?php echo htmlspecialchars($priceValue); ?>"
                    >
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No Car types.</p>
    <?php endif; ?>
</div>

											</div>		
											</div>
											<div class="tab-pane fade" id="pills-profile" role="tabpanel"
											aria-labelledby="pills-profile-tab">
											<div class="row select-color-add">
											
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
							<button type="submit" class="btn btn-primary">Update Product</button>
						</div>
					</div>
				</form>
			</div>
            <!-- Toast Container -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
  <div id="toastMessage" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div id="toastText" class="toast-body"></div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>

					<?php require_once __DIR__ . "/../../src/views/footer.php";?>

		</div>
	</div>
<script>
$(document).ready(function () {
    // Init Summernote
    $('.pages-editor').summernote({
        placeholder: 'Enter product description...',
        tabsize: 2,
        height: 150
    });

    // Extra safety: update textarea before form submit
    document.querySelector(".add-product-form").addEventListener("submit", function() {
        let content = document.querySelector(".summer-description-box").innerHTML;
        document.getElementById("description").value = content;
    });
});
</script>

<script>
// Handle form submit
document.querySelector(".add-product-form").addEventListener("submit", function(e) {
    e.preventDefault();

    let form = this;
    let submitBtn = form.querySelector("button[type='submit']");
    let formData = new FormData(form);

    // Add action=add
    formData.append("action", "edit");

    // Replace description with summer-description-box innerHTML
    let descriptionHTML = document.querySelector(".summer-description-box").innerHTML;
    formData.set("description", descriptionHTML);

    // Change button to processing state
    let originalBtnText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = "Processing...";

    fetch("process/product_process.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
            console.log("Response length:", data.status);

        if(data.status === "success") {
            showToast("success", data.message);
           // $('.pages-editor').summernote('reset'); // clear editor
        } else {
            showToast("error", data.message);
        }
    })
    .catch(() => {
        showToast("error", "Something went wrong!");
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
    });
});

function showToast(type, message) {
    let bg = type === "success" ? "bg-success" : "bg-danger";
    let toastEl = document.getElementById("toastMessage");
    let toastText = document.getElementById("toastText");

    if (!toastEl || !toastText) {
        console.error("Toast elements not found in DOM");
        return;
    }

    // Reset background classes
    toastEl.classList.remove("bg-success", "bg-danger");
    toastEl.classList.add(bg);

    toastText.textContent = message;

    // Recreate toast (to reset any previous state)
    let toast = bootstrap.Toast.getInstance(toastEl);
    if (toast) toast.dispose();

    // Initialize a fresh Bootstrap toast
    toast = new bootstrap.Toast(toastEl, { delay: 3000 });
    toast.show();
}

</script>

	
	<!-- jQuery -->
	<script src="assets/js/jquery-3.7.1.min.js" type="712042956002651bb9418e95-text/javascript"></script>

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