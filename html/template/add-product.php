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
							<h4 class="fw-bold">Create Product</h4>
							<h6>Create new product</h6>
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
											<div class="col-sm-12 col-12">
												<div class="mb-3">
													<label class="form-label">Product Name<span class="text-danger ms-1">*</span></label>
													<input type="text" class="form-control">
												</div>
											</div>
											<div class="col-sm-6 col-12">
												<div class="mb-3">
													<label class="form-label">Category<span class="text-danger ms-1">*</span></label>
													<select class="select">
														<option>Select</option>
														<option>Electro Mart</option>
														<option>Quantum Gadgets</option>
													</select>
												</div>
											</div>
											<div class="col-sm-6 col-12">
												<?php 
													   $cartypes = getCarTypes($conn);
												?>
												<div class="mb-3">
													<label class="form-label">Car Type<span class="text-danger ms-1">*</span></label>
													<select class="select">
														<option>Select</option>
														<option>EdgeWare Solutions</option>
													</select>
												</div>
											</div>
										</div>
									
									
										<!-- Editor -->
										<div class="col-lg-12">
											<div class="summer-description-box">
												<label class="form-label">Description</label>
												<div class="editor pages-editor"></div>
												<p class="fs-14 mt-1">Maximum 60 Words</p>
											</div>
										</div>
										<!-- /Editor -->
									</div>
								</div>
							</div>
							<div class="accordion-item border mb-4"> 
								<h2 class="accordion-header" id="headingSpacingTwo">
									<div class="accordion-button collapsed bg-white" data-bs-toggle="collapse" data-bs-target="#SpacingTwo" aria-expanded="true" aria-controls="SpacingTwo">
										<div class="d-flex align-items-center justify-content-between flex-fill">
										<h5 class="d-flex align-items-center"><i data-feather="life-buoy" class="text-primary me-2"></i><span>Pricing & Stocks</span></h5>
										</div>
									</div>
								</h2>
								<div id="SpacingTwo" class="accordion-collapse collapse show" aria-labelledby="headingSpacingTwo">
									<div class="accordion-body border-top">
										<div class="mb-3s">
											<label class="form-label">Product Type<span class="text-danger ms-1">*</span></label>
											<div class="single-pill-product mb-3">
												<ul class="nav nav-pills" id="pills-tab1" role="tablist">
													<li class="nav-item" role="presentation">
														<span class="custom_radio me-4 mb-0 active" id="pills-home-tab" data-bs-toggle="pill"
														data-bs-target="#pills-home"  role="tab" aria-controls="pills-home" aria-selected="true">
															<input type="radio" class="form-control" name="payment">
														<span class="checkmark"></span> Single Product</span>
													</li>
													<li class="nav-item" role="presentation">
														<span  class="custom_radio me-2 mb-0" id="pills-profile-tab" data-bs-toggle="pill"
														data-bs-target="#pills-profile"  role="tab" aria-controls="pills-profile" aria-selected="false">
														<input type="radio" class="form-control" name="sign">
														<span class="checkmark"></span> Variable Product</span>
													</li>
												</ul>
											</div>
										</div>
										<div class="tab-content" id="pills-tabContent">
											<div class="tab-pane fade show active" id="pills-home" role="tabpanel"
												aria-labelledby="pills-home-tab">
												<div class="single-product">
												<div class="row">
													<div class="col-lg-4 col-sm-6 col-12">
														<div class="mb-3">
															<label class="form-label">Quantity<span class="text-danger ms-1">*</span></label>
															<input type="text" class="form-control">
														</div>
													</div>
													<div class="col-lg-4 col-sm-6 col-12">
														<div class="mb-3">
															<label class="form-label">Price<span class="text-danger ms-1">*</span></label>
															<input type="text" class="form-control">
														</div>
													</div>
													<div class="col-lg-4 col-sm-6 col-12">
														<div class="mb-3">
															<label class="form-label">Tax Type<span class="text-danger ms-1">*</span></label>
															<select class="select">
																<option>Select</option>
																<option>Exclusive</option>
																	<option>Inclusive</option>
																</select>
															</div>
														</div>
														<div class="col-lg-4 col-sm-6 col-12">
															<div class="mb-3">
																<label class="form-label">Tax<span class="text-danger ms-1">*</span></label>
																<select class="select">
																	<option>Select</option>
																	<option>IGST (8%)</option>
																	<option>GST (5%)</option>
																	<option>SGST (4%)</option>
																	<option>CGST (16%)</option>
																<option>Gst 18%</option>
															</select>
														</div>
													</div>
									
													<div class="col-lg-4 col-sm-6 col-12">
														<div class="mb-3">
															<label class="form-label">Discount Type<span class="text-danger ms-1">*</span></label>
															<select class="select">
																<option>Select</option>
																<option>Percentage</option>
																	<option>Fixed</option>
															</select>
														</div>
													</div>
													<div class="col-lg-4 col-sm-6 col-12">
														<div class="mb-3">
															<label class="form-label">Discount Value<span class="text-danger ms-1">*</span></label>
															<input class="form-control" type="text">
														</div>
													</div>
													<div class="col-lg-4 col-sm-6 col-12">
														<div class="mb-3">
															<label class="form-label">Quantity Alert<span class="text-danger ms-1">*</span></label>
															<input type="text" class="form-control">
														</div>
													</div>
												</div>
											</div>		
											</div>
											<div class="tab-pane fade" id="pills-profile" role="tabpanel"
											aria-labelledby="pills-profile-tab">
											<div class="row select-color-add">
												<div class="col-lg-6 col-sm-6 col-12">
													<div class="mb-3">
														<label class="form-label">Variant Attribute <span class="text-danger ms-1">*</span></label>
														<div class="row">
															<div class="col-lg-10 col-sm-10 col-10">
																<select class="form-control variant-select select-option" id="colorSelect">
																	<option >Choose</option>
																	<option >Color</option>
																	<option value="red" >Red</option>
																	<option value="black">Black</option>
																</select>
															</div>
															<div class="col-lg-2 col-sm-2 col-2 ps-0">
																<div class="add-icon tab">
																	<a class="btn btn-filter" data-bs-toggle="modal" data-bs-target="#add-product-category"><i class="feather feather-plus-circle"></i></a>
																</div>
															</div>
														</div>
													</div>
													<div class="selected-hide-color" id="input-show">
														<label class="form-label">Variant Attribute <span class="text-danger ms-1">*</span></label>
														<div class="row align-items-center" >
															<div class="col-lg-10 col-sm-10 col-10">
																<div class="mb-3">
																	<input class="input-tags form-control" id="inputBox" type="text" data-role="tagsinput"  name="specialist" value="red, black" >
																</div>
															</div>
															<div class="col-lg-2 col-sm-2 col-2 ps-0">
																<div class="mb-3 ">
																	<a href="javascript:void(0);" class="remove-color"><i class="far fa-trash-alt"></i></a>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="modal-body-table border" id="variant-table">
												<div class="table-responsive">
													<table class="table border">
														<thead>
															<tr>
																<th>Variantion</th>
																<th>Variant Value</th>
																<th>SKU</th>
																<th>Quantity</th>
																<th>Price</th>
																<th class="no-sort"></th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>
																	<div class="add-product">
																		<input type="text" class="form-control" value="color">
																	</div>												
																</td>
																<td>
																	<div class="add-product">
																		<input type="text" class="form-control" value="red">
																	</div>
																</td>
																<td>
																	<div class="add-product">
																		<input type="text" class="form-control" value="1234">
																	</div>
																</td>
																<td>
																	<div class="product-quantity">
																		<span class="quantity-btn"><i data-feather="minus-circle" class="feather-search"></i></span>
																		<input type="text" class="quntity-input form-control" value="2">
																		<span class="quantity-btn">+<i data-feather="plus-circle" class="plus-circle"></i></span>
																	</div>
																</td>
																<td>
																	<div class="add-product">
																		<input type="text" class="form-control" value="50000">
																	</div>
																</td>
																<td class="action-table-data">
																	<div class="edit-delete-action">
																		<div class="input-block add-lists">
																			<label class="checkboxs">
																				<input type="checkbox" checked>
																				<span class="checkmarks"></span>
																			</label>
																		</div>
																		<a class="me-2 p-2" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#add-variation">
																			<i data-feather="plus" class="feather-edit"></i>
																		</a>
																		<a data-bs-toggle="modal" data-bs-target="#delete-modal" class="p-2" href="javascript:void(0);">
																			<i data-feather="trash-2" class="feather-trash-2"></i>
																		</a>
																	</div>
																	
																</td>
															</tr>
															<tr>
																<td>
																	<div class="add-product">
																		<input type="text" class="form-control" value="color">
																	</div>												
																</td>
																<td>
																	<div class="add-product">
																		<input type="text" class="form-control" value="black">
																	</div>
																</td>
																<td>
																	<div class="add-product">
																		<input type="text" class="form-control" value="2345">
																	</div>
																</td>
																<td>
																	<div class="product-quantity">
																		<span class="quantity-btn"><i data-feather="minus-circle" class="feather-search"></i></span>
																		<input type="text" class="quntity-input form-control" value="3">
																		<span class="quantity-btn">+<i data-feather="plus-circle" class="plus-circle"></i></span>
																	</div>
																</td>
																<td>
																	<div class="add-product">
																		<input type="text" class="form-control" value="50000">
																	</div>
																</td>
																<td class="action-table-data">
																	<div class="edit-delete-action">
																		<div class="input-block add-lists">
																			<label class="checkboxs">
																				<input type="checkbox" checked>
																				<span class="checkmarks"></span>
																			</label>
																		</div>
																		<a class="me-2 p-2" href="#" data-bs-toggle="modal" data-bs-target="#add-variation">
																			<i data-feather="plus" class="feather-edit"></i>
																		</a>
																		<a data-bs-toggle="modal" data-bs-target="#delete-modal" class="p-2" href="javascript:void(0);">
																			<i data-feather="trash-2" class="feather-trash-2"></i>
																		</a>
																	</div>													
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>

											</div>	
										</div>
									</div>
								</div>
							</div>
							<div class="accordion-item border mb-4">
								<h2 class="accordion-header" id="headingSpacingThree">
									<div class="accordion-button collapsed bg-white" data-bs-toggle="collapse" data-bs-target="#SpacingThree" aria-expanded="true" aria-controls="SpacingThree">
										<div class="d-flex align-items-center justify-content-between flex-fill">
										<h5 class="d-flex align-items-center"><i data-feather="image" class="text-primary me-2"></i><span>Images</span></h5>
										</div>
									</div>
								</h2>
								<div id="SpacingThree" class="accordion-collapse collapse show" aria-labelledby="headingSpacingThree">
									<div class="accordion-body border-top">
										<div class="text-editor add-list add">
											<div class="col-lg-12">
												<div class="add-choosen">
													<div class="mb-3">
													<div class="image-upload image-upload-two">
															<input type="file">
															<div class="image-uploads">
																<i data-feather="plus-circle" class="plus-down-add me-0"></i>
																<h4>Add Images</h4>
															</div>
														</div>
													</div>
													<div class="phone-img">
														<img src="assets/img/products/phone-add-2.png" alt="image">
														<a href="javascript:void(0);"><i data-feather="x" class="x-square-add remove-product"></i></a>
													</div>
		
													<div class="phone-img">
														<img src="assets/img/products/phone-add-1.png" alt="image">
														<a href="javascript:void(0);"><i data-feather="x" class="x-square-add remove-product"></i></a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="accordion-item border mb-4">
								<h2 class="accordion-header" id="headingSpacingFour">
									<div class="accordion-button collapsed bg-white" data-bs-toggle="collapse" data-bs-target="#SpacingFour" aria-expanded="true" aria-controls="SpacingFour">
										<div class="d-flex align-items-center justify-content-between flex-fill">
										<h5 class="d-flex align-items-center"><i data-feather="list" class="text-primary me-2"></i><span>Custom Fields</span></h5>
										</div>
									</div>
								</h2>
								<div id="SpacingFour" class="accordion-collapse collapse show" aria-labelledby="headingSpacingFour">
									<div class="accordion-body border-top">
										<div>
											<div class="p-3 bg-light rounded d-flex align-items-center border mb-3">
												<div class=" d-flex align-items-center">
													<div class="form-check form-check-inline">
														<input class="form-check-input" type="checkbox" id="warranties" value="option1">
														<label class="form-check-label" for="warranties">Warranties</label>
													</div>
													<div class="form-check form-check-inline">
														<input class="form-check-input" type="checkbox" id="manufacturer" value="option2">
														<label class="form-check-label" for="manufacturer">Manufacturer</label>
													</div>
													<div class="form-check form-check-inline">
														<input class="form-check-input" type="checkbox" id="expiry" value="option2">
														<label class="form-check-label" for="expiry">Expiry</label>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-6 col-12">
													<div class="mb-3">
														<label class="form-label">Warranty<span class="text-danger ms-1">*</span></label>
														<select class="select">
															<option>Select</option>
															<option>Replacement Warranty</option>
															<option>On-Site Warranty</option>
															<option>Accidental Protection Plan</option>
														</select>
													</div>
												</div>
												<div class="col-sm-6 col-12">
													<div class="mb-3 add-product">
														<label class="form-label">Manufacturer<span class="text-danger ms-1">*</span></label>
														<input type="text" class="form-control">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-6 col-12">
													<div class="mb-3">
														<label class="form-label">Manufactured Date<span class="text-danger ms-1">*</span></label>
				
														<div class="input-groupicon calender-input">
															<i data-feather="calendar" class="info-img"></i>
															<input type="text" class="datetimepicker form-control" placeholder="dd/mm/yyyy">
														</div>
													</div>
												</div>
												<div class="col-sm-6 col-12">
													<div class="mb-3">
														<label class="form-label">Expiry On<span class="text-danger ms-1">*</span></label>
				
														<div class="input-groupicon calender-input">
															<i data-feather="calendar" class="info-img"></i>
															<input type="text" class="datetimepicker form-control" placeholder="dd/mm/yyyy">
														</div>
													</div>
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
							<button type="submit" class="btn btn-primary">Add Product</button>
						</div>
					</div>
				</form>
			</div>
			<div class="footer d-sm-flex align-items-center justify-content-between border-top bg-white p-3">
				<p class="mb-0 text-gray-9">2014 - 2025 &copy; DreamsPOS. All Right Reserved</p>
				<p>Designed &amp; Developed by <a href="javascript:void(0);" class="text-primary">Dreams</a></p>
			</div>
		</div>
	</div>
	<!-- /Main Wrapper -->

	<!-- Add Category -->
	<div class="modal fade" id="add-product-category">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<div class="page-title">
						<h4>Add Category</h4>
					</div>
					<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<label class="form-label">Category<span class="ms-1 text-danger">*</span></label>
					<input type="text" class="form-control">
				</div>
				<div class="modal-footer">
					<a href="javascript:void(0);" class="btn me-2 btn-secondary fs-13 fw-medium p-2 px-3 shadow-none" data-bs-dismiss="modal">Cancel</a>
					<a href="add-product.php" class="btn btn-primary text-white fs-13 fw-medium p-2 px-3">Submit</a>
				</div>
			</div>
		</div>
	</div>
	<!-- /Add Category -->

	<!-- Add Variatent -->
	<div class="modal fade" id="add-variation">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<div class="page-title">
						<h4>Add Variant</h4>
					</div>
					<button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">	
					<div class="new-employee-field">	
						<div class="modal-title-head people-cust-avatar">
							<h6>Variant Thumbnail</h6>
						</div>
						<div class="profile-pic-upload mb-3">
							<div class="profile-pic brand-pic">
								<span><i data-feather="plus-circle" class="plus-down-add"></i> Add Image</span>
							</div>
							<div>
								<div class="image-upload mb-0">
									<input type="file">
									<div class="image-uploads">
										<h4>Upload Image</h4>
									</div>
								</div>
								<p class="mt-2">JPEG, PNG up to 2 MB</p>
							</div>
						</div>
					</div>	
					<div class="row">
						<div class="col-lg-6 pe-0">
							<div class="mb-3">
								<label class="form-label">Barcode Symbology<span class="text-danger ms-1">*</span></label>
								<select class="select">
									<option>Select</option>
									<option>Code 128</option>
									<option>Code 39</option>
									<option>UPC-A</option>
									<option>UPC_E</option>
									<option>EAN-8</option>
									<option>EAN-13</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="mb-3">
								<div class="mb-3 add-product list position-relative">
									<label class="form-label">Item Code<span class="text-danger ms-1">*</span></label>
									<input type="text" class="form-control list" value="">
									<button type="submit" class="btn btn-primaryadd">
										Generate
									</button>
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="input-blocks mb-3 image-upload-down">
								<div class="image-upload download">
									<input type="file">
									<div class="image-uploads">
										<img src="assets/img/download-img.png" alt="img">
										<h4>Drag and drop a <span>file to upload</span></h4>
									</div>
								</div>
							</div>
							<div class="accordion-body">
								<div class="text-editor add-list add">
									<div class="col-lg-12">
										<div class="add-choosen mb-3">
											<div class="phone-img ms-0">
												<img src="assets/img/products/laptop.png" alt="image">
												<a href="javascript:void(0);"><i data-feather="x" class="x-square-add remove-product"></i></a>
											</div>

											<div class="phone-img">
												<img src="assets/img/products/laptop-2.png" alt="image">
												<a href="javascript:void(0);"><i data-feather="x" class="x-square-add remove-product"></i></a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="mb-3">
								<label class="form-label">Quantity<span class="text-danger ms-1">*</span></label>
								<input type="text" class="form-control">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="mb-3">
								<label class="form-label">Quantity Alert<span class="text-danger ms-1">*</span></label>
								<input type="text" class="form-control">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="mb-3">
								<label class="form-label">Tax Type<span class="text-danger ms-1">*</span></label>
								<select class="select">
									<option>Select</option>
									<option>Exclusive</option>
									<option>Inclusive</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="mb-3">
								<label class="form-label">Tax<span class="text-danger ms-1">*</span></label>
								<select class="select">
									<option>Select</option>
									<option>No Tax</option>
									<option>10%</option>
									<option>15%</option>
									<option>20%</option>
									<option>Gst 18%</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="mb-3">
								<label class="form-label">Discount Type<span class="text-danger ms-1">*</span> </label>
								<select class="select">
									<option>Select</option>
									<option>Percentage</option>
									<option>Flat</option>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div >
								<label class="form-label">Discount Value<span class="text-danger ms-1">*</span></label>
								<input type="text" class="form-control">
							</div>
						</div>								
					</div>
				</div>
				<div class="modal-footer">
					<a href="javascript:void(0);" class="btn me-1 btn-secondary fs-13 fw-medium p-2 px-3 shadow-none" data-bs-dismiss="modal">Cancel</a>
					<a href="add-product.php" class="btn btn-primary fs-13 fw-medium p-2 px-3">Submit</a>
				</div>
			</div>
		</div>
	</div>
	<!-- /Add Variatent -->

	<!-- delete modal -->
	<div class="modal fade" id="delete-modal">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="page-wrapper-new p-0">
					<div class="content p-5 px-3 text-center">
							<span class="rounded-circle d-inline-flex p-2 bg-danger-transparent mb-2"><i class="ti ti-trash fs-24 text-danger"></i></span>
							<h4 class="fs-20 fw-bold mb-2 mt-1">Delete Attribute</h4>
							<p class="mb-0 fs-16">Are you sure you want to delete Attribute?</p>
							<div class="modal-footer-btn mt-3 d-flex justify-content-center">
								<button type="button" class="btn me-2 btn-secondary fs-13 fw-medium p-2 px-3 shadow-none" data-bs-dismiss="modal">Cancel</button>
								<button type="submit" class="btn btn-primary fs-13 fw-medium p-2 px-3">Yes Delete</button>
							</div>						
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
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

	<!-- Datetimepicker JS -->
	<script src="assets/js/moment.min.js" type="712042956002651bb9418e95-text/javascript"></script>
	<script src="assets/js/bootstrap-datetimepicker.min.js" type="712042956002651bb9418e95-text/javascript"></script>

	<!-- Bootstrap Tagsinput JS -->
	<script src="assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js" type="712042956002651bb9418e95-text/javascript"></script>

	<!-- Color Picker JS -->
	<script src="assets/plugins/%40simonwep/pickr/pickr.es5.min.js" type="712042956002651bb9418e95-text/javascript"></script>

	<!-- Custom JS -->
	<script src="assets/js/theme-colorpicker.js" type="712042956002651bb9418e95-text/javascript"></script>
	<script src="assets/js/script.js" type="712042956002651bb9418e95-text/javascript"></script>


<script src="../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="712042956002651bb9418e95-|49" defer></script><script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"98610c03fd3def4a","version":"2025.9.1","serverTiming":{"name":{"cfExtPri":true,"cfEdge":true,"cfOrigin":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}' crossorigin="anonymous"></script>
</body>


<!-- Mirrored from dreamspos.dreamstechnologies.com/html/template/add-product.php by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 28 Sep 2025 06:07:11 GMT -->
</html>