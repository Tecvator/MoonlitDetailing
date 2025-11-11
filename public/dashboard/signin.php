<?php 
require_once __DIR__ . "/../../src/config/init.php";
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
		<title><?php echo $siteinfo['site_name'];?> -Admin Dashboard </title>

		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

		<!-- Apple Touch Icon -->
		<link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
		
        <!-- Fontawesome CSS -->
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

         <!-- Tabler Icon CSS -->
	    <link rel="stylesheet" href="assets/plugins/tabler-icons/tabler-icons.min.css">

	    <!-- Main CSS -->
        <link rel="stylesheet" href="assets/css/style.css">
		
    </head>
    <body class="account-page bg-white">

        <div id="global-loader" >
			<div class="whirly-loader"> </div>
		</div>
	
		<!-- Main Wrapper -->
        <div class="main-wrapper">
			<div class="account-content">
				<div class="login-wrapper login-new">
                    <div class="row w-100">
                        <div class="col-lg-5 mx-auto">
                            <div class="login-content user-login">
                                <div class="login-logo">
                                    <img src="<?php echo $siteinfo['site_logo'];?>" alt="img">
                                    <a href="./" class="login-logo logo-white">
                                        <img src="assets/img/logo-white.svg"  alt="Img">
                                    </a>
                                </div>
                          <form id="loginForm">
    <div class="card">
        <div class="card-body p-5">        


            <div class="login-userheading">
                <h3>Sign In</h3>
                <h4>Access the <?php echo $siteinfo['site_name'];?> panel using your email and passcode.</h4>
            </div>

            <div class="mb-3">
                <label class="form-label">Email <span class="text-danger"> *</span></label>
                <div class="input-group">
                    <input type="text" id="email" name="email" class="form-control border-end-0">
                    <span class="input-group-text border-start-0">
                        <i class="ti ti-mail"></i>
                    </span>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Password <span class="text-danger"> *</span></label>
                <div class="pass-group">
                    <input type="password" id="password" name="password" class="pass-input form-control">
                    <span class="ti toggle-password ti-eye-off text-gray-9"></span>
                </div>
            </div>

            <div class="form-login">
           <button type="submit" id="loginBtn" class="btn btn-primary w-100">
    <span class="btn-text">Sign In</span>
    <span class="spinner-border spinner-border-sm ms-2 d-none" role="status"></span>
</button>

            </div>
        </div>
    </div>
</form>


                            </div>
                            <div class="my-4 d-flex justify-content-center align-items-center copyright-text">
                                <p>Copyright &copy; 2025 <?php echo $siteinfo['site_name'];?></p>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
        </div>
		<!-- /Main Wrapper -->
<!-- Toast Container (Top Right) -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1055">
  <div id="toastMessage" class="toast align-items-center text-white border-0" role="alert">
    <div class="d-flex">
      <div class="toast-body" id="toastText"></div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>

<script>
document.querySelector("#loginForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const loginBtn = document.getElementById("loginBtn");
    const btnText = loginBtn.querySelector(".btn-text");
    const spinner = loginBtn.querySelector(".spinner-border");
    const toastEl = document.getElementById("toastMessage");
    const toastText = document.getElementById("toastText");

    // Show processing
    btnText.textContent = "Processing...";
    spinner.classList.remove("d-none");
    loginBtn.disabled = true;

    let email = document.querySelector("#email").value;
    let password = document.querySelector("#password").value;

    fetch("process/login.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: new URLSearchParams({email, password})
    })
    .then(res => res.json())
    .then(data => {
        // Reset button
        btnText.textContent = "Sign In";
        spinner.classList.add("d-none");
        loginBtn.disabled = false;

        // Show toast at top
        toastEl.className = `toast align-items-center text-white border-0 ${data.status === "success" ? "bg-success" : "bg-danger"}`;
        toastText.textContent = data.message;

        const bsToast = new bootstrap.Toast(toastEl, { delay: 2500 });
        bsToast.show();

        if (data.status === "success") {
            setTimeout(() => {
                window.location.href = "./";
            }, 1500);
        }
    })
    .catch(() => {
        btnText.textContent = "Sign In";
        spinner.classList.add("d-none");
        loginBtn.disabled = false;

        toastEl.className = "toast align-items-center text-white border-0 bg-danger";
        toastText.textContent = "An error occurred. Please try again.";
        const bsToast = new bootstrap.Toast(toastEl, { delay: 2500 });
        bsToast.show();
    });
});
</script>



		<!-- jQuery -->
        <script src="assets/js/jquery-3.7.1.min.js" type="53890b83355bc4c60f203776-text/javascript"></script>

         <!-- Feather Icon JS -->
		<script src="assets/js/feather.min.js" type="53890b83355bc4c60f203776-text/javascript"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="assets/js/bootstrap.bundle.min.js" type="53890b83355bc4c60f203776-text/javascript"></script>
		
		<!-- Custom JS -->
        <script src="assets/js/script.js" type="53890b83355bc4c60f203776-text/javascript"></script>

    <script src="../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" 
    data-cf-settings="53890b83355bc4c60f203776-|49" defer></script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" ></script>
</body>

</html>