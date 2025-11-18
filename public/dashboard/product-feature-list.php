<?php 
require_once __DIR__ . "/../../src/config/session.php";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Meta Tags -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="<?php echo $siteinfo['site_name'];?> is a powerful Bootstrap based Inventory Management Admin Template designed for businesses, offering seamless invoicing, project tracking, and estimates."
    />
    <meta
      name="keywords"
      content="inventory management, admin dashboard, bootstrap template, invoicing, estimates, business management, responsive admin, POS system"
    />
    <meta name="author" content="Dreams Technologies" />
    <meta name="robots" content="index, follow" />
    <title><?php echo $siteinfo['site_name'];?>  -  Admin Dashboard Template</title>

 

    <!-- Favicon -->
    <link
      rel="shortcut icon"
      type="image/x-icon"
      href="assets/img/favicon.png"
    />

    <!-- Apple Touch Icon -->
    <link
      rel="apple-touch-icon"
      sizes="180x180"
      href="assets/img/apple-touch-icon.png"
    />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css" />

    <!-- animation CSS -->
    <link rel="stylesheet" href="assets/css/animate.css" />

    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="assets/css/feather.css" />

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css" />

    <!-- Quill CSS -->
    <link rel="stylesheet" href="assets/plugins/quill/quill.snow.css" />

    <!-- Bootstrap Tagsinput CSS -->
    <link
      rel="stylesheet"
      href="assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css"
    />

    <!-- Tabler Icon CSS -->
    <link
      rel="stylesheet"
      href="assets/plugins/tabler-icons/tabler-icons.min.css"
    />

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap5.min.css" />

    <!-- Fontawesome CSS -->
    <link
      rel="stylesheet"
      href="assets/plugins/fontawesome/css/fontawesome.min.css"
    />
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css" />

    <!-- Color Picker Css -->
    <link
      rel="stylesheet"
      href="assets/plugins/%40simonwep/pickr/themes/nano.min.css"
    />

    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css" />
  </head>
  <body>
    <div id="global-loader">
      <div class="whirly-loader"></div>
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
                <h4 class="fw-bold">Product Feature List</h4>
                <h6>Manage your product Features</h6>
              </div>
            </div>

            <div class="page-btn">
              <a href="add-product-feature.php" class="btn btn-primary"
                ><i class="ti ti-circle-plus me-1"></i>Add New Product Feature</a
              >
            </div>
       
          </div>

          <!-- /product list -->
          <div class="card">
            <div
              class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3"
            >
              <div class="search-set">
                <div class="search-input">
                  <span class="btn-searchset"
                    ><i class="ti ti-search fs-14 feather-search"></i
                  ></span>
                </div>
              </div>
              <div
                class="d-flex table-dropdown my-xl-auto right-content align-items-center flex-wrap row-gap-3"
              >
             
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
                         <th>Product Feature</th>
                      <th>Product Name</th>
                   
                      <th>Type</th>
                 
                      <th class="no-sort"></th>
                    </tr>
                  </thead>
                  <tbody>
                     <?php 
                             $products = fetchAllProductFeatures($conn);
                     if (!empty($products)): ?>
   																 <?php foreach ($products as $product): ?>
                    <tr>
                      <td>
                        <label class="checkboxs">
                          <input type="checkbox" />
                          <span class="checkmarks"></span>
                        </label>
                      </td>
                      <td><?php echo $product['feature'];?></td>
                      <td>
                        <div class="d-flex align-items-center">
                          <a
                            href="javascript:void(0);"
                            class="avatar avatar-md me-2"
                          >
                            <!--img
                              src="assets/img/products/stock-img-01.png"
                              alt="product"
                            /-->
                          </a>
                          <a href="javascript:void(0);"><?php echo $product['product_name'];?></a>
                        </div>
                      </td>
                    <td>
                        <?= $product['is_interior'] ? 'Interior' :
                            ($product['is_exterior'] ? 'Exterior' :
                            ($product['is_limited'] ? 'Limited' :
                            ($product['is_included'] ? 'Included' : 'N/A'))) ?>
                    </td>
                
              
                      <td class="action-table-data">
                        <div class="edit-delete-action">
                          <a
                            class="me-2 edit-icon p-2"
                            href="edit-product-feature.php?id=<?php echo $product['id'];?>"
                          >
                            <i data-feather="eye" class="feather-eye"></i>
                          </a>
                      
                          <a
                            data-bs-toggle="modal"
                            data-bs-target="#delete-modal"
                            class="p-2"
                            href="javascript:void(0);"
                            onclick="setDeleteID(<?php echo $product['id'];?>)"
                          >
                            <i
                              data-feather="trash-2"
                              class="feather-trash-2"
                            ></i>
                          </a>
                        </div>
                      </td>
                    </tr>
         	  <?php endforeach; ?>
															<?php else: ?>
																<p>No Feature Products.</p>
															<?php endif; ?>
                  </tbody>
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
                Delete Product
              </h4>
              <p class="text-gray-6 mb-0 fs-16">
                Are you sure you want to delete product?
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
    <script>
      function setDeleteID(productID){
        var inputElement =  document.getElementById("itemToDelete");
        inputElement.value= productID;
      }  


      
    // Delete Category
   // Delete Product
document.addEventListener("click", function(e) {
    if (e.target.closest(".deleteBtn")) {
        e.preventDefault();
        let id = document.getElementById("itemToDelete").value;

        fetch("process/product_feature_process.php", {
            method: "POST",
            headers: {"Content-Type": "application/x-www-form-urlencoded"},
            body: new URLSearchParams({ action: "delete", id })
        })
        .then(res => res.json())
        .then(data => {
            showToast(data.message, data.status);
            if (data.status == "success") {
                bootstrap.Modal.getInstance(document.getElementById("delete-modal")).hide();
                //windows.reload();
            }
        })
        .catch(error => {
            console.error("Error:", error);
            showToast("An error occurred", "error");
        });
    }
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
    <!-- jQuery -->
    <script
      src="assets/js/jquery-3.7.1.min.js"
      
    ></script>

    <!-- Bootstrap Core JS -->
    <script
      src="assets/js/bootstrap.bundle.min.js"
      
    ></script>

    <!-- Feather Icon JS -->
    <script
      src="assets/js/feather.min.js"
      
    ></script>

    <!-- Slimscroll JS -->
    <script
      src="assets/js/jquery.slimscroll.min.js"
      
    ></script>

    <!-- Datatable JS -->
    <script
      src="assets/js/jquery.dataTables.min.js"
      
    ></script>
    <script
      src="assets/js/dataTables.bootstrap5.min.js"
      
    ></script>

    <!-- Quill JS -->
    <script
      src="assets/plugins/quill/quill.min.js"
      
    ></script>

    <!-- Select2 JS -->
    <script
      src="assets/plugins/select2/js/select2.min.js"
      
    ></script>

    <!-- Datetimepicker JS -->
    <script
      src="assets/js/moment.min.js"
      
    ></script>
    <script
      src="assets/js/bootstrap-datetimepicker.min.js"
      
    ></script>

    <!-- Bootstrap Tagsinput JS -->
    <script
      src="assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"
      
    ></script>

    <!-- Color Picker JS -->
    <script
      src="assets/plugins/%40simonwep/pickr/pickr.es5.min.js"
      
    ></script>

    <!-- Custom JS -->
    <script
      src="assets/js/theme-colorpicker.js"
      
    ></script>
    <script
      src="assets/js/script.js"
      
    ></script>

    <script
      data-cf-settings="9c1987c811a42ee0412dcfad-|49"
      defer
    ></script>
    <script
   
    ></script>
  </body>

</html>
