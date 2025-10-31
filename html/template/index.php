<?php 
include "../../includes/session.php";
$booking_stats = getBookingStats($conn);
$nextschedule = getNextScheduledBooking($conn);
$dashboard = getDashboardStats($conn);

?>
<!DOCTYPE html>
<html lang="en" data-layout-mode="light_mode">


<head>

	<!-- Meta Tags -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php echo $siteinfo['site_name'];?> is a powerful Bootstrap based Inventory Management Admin Template designed for businesses, offering seamless invoicing, project tracking, and estimates.">
	<meta name="keywords" content="inventory management, admin dashboard, bootstrap template, invoicing, estimates, business management, responsive admin, POS system">
	<meta name="author" content="Dreams Technologies">
	<meta name="robots" content="index, follow">
	<title><?php echo $siteinfo['site_name'];?> -  Admin Dashboard </title>


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

	<!-- Select2 CSS -->
	<link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">

	<!-- Daterangepikcer CSS -->
	<link rel="stylesheet" href="assets/plugins/daterangepicker/daterangepicker.css">

	<!-- Tabler Icon CSS -->
	<link rel="stylesheet" href="assets/plugins/tabler-icons/tabler-icons.min.css">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

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

		<!-- Header -->
		
		<?php include ("../../includes/header.php");?>
		<!-- /Header -->

		<!-- Sidebar -->
			<?php include ("../../includes/sidemenu.php");?>
		<!-- /Sidebar -->

	
		<div class="page-wrapper">
			<div class="content">

				<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-2">
					<div class="mb-3">
						<h1 class="mb-1">Welcome, <?php echo $admin['username'];?></h1>
						<p class="fw-medium">You have <span class="text-primary fw-bold"><?php echo $booking_stats['pending_today'];?></span> Pending booking today</p>
					</div>
					<div class="input-icon-start position-relative mb-3">
					
					
					</div>
				</div>

				<div class="alert bg-orange-transparent alert-dismissible fade show mb-4">
					<div>
						<span><i class="ti ti-info-circle fs-14 text-orange me-2"></i>Next Pending Schedule is </span>
						 <span class="text-orange fw-semibold"> <?php echo $nextschedule['washing_date']?>  </span>By <?php echo $nextschedule['washing_time_formatted']?> 
						 <a href="invoice-details.php?id=<?php echo $nextschedule['id'];?>" class="link-orange text-decoration-underline fw-semibold" >View Invoice</a>
					</div>
					<button type="button" class="btn-close text-gray-9 fs-14" data-bs-dismiss="alert" aria-label="Close"><i class="ti ti-x"></i></button>
				</div>

				<div class="row">
					<div class="col-xl-3 col-sm-6 col-12 d-flex">
						<div class="card bg-primary sale-widget flex-fill">
							<div class="card-body d-flex align-items-center">
								<span class="sale-icon bg-white text-primary">
									<i class="ti ti-file-text fs-24"></i>
								</span>
								<div class="ms-2">
									<p class="text-white mb-1">Total Bookings</p>
									<div class="d-inline-flex align-items-center flex-wrap gap-2">
										<h4 class="text-white"><?php echo $booking_stats['total_bookings'];?></h4>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-sm-6 col-12 d-flex">
						<div class="card bg-secondary sale-widget flex-fill">
							<div class="card-body d-flex align-items-center">
								<span class="sale-icon bg-white text-secondary">
									<i class="ti ti-chart-pie fs-24"></i>
								</span>
								<div class="ms-2">
									<p class="text-white mb-1">Pending Schedule</p>
									<div class="d-inline-flex align-items-center flex-wrap gap-2">
										<h4 class="text-white"><?php echo $booking_stats['total_pending'];?></h4>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-sm-6 col-12 d-flex">
						<div class="card bg-teal sale-widget flex-fill">
							<div class="card-body d-flex align-items-center">
								<span class="sale-icon bg-white text-teal">
									<i class="ti ti-clock fs-24"></i>
								</span>
								<div class="ms-2">
									<p class="text-white mb-1">Today Schedule</p>
									<div class="d-inline-flex align-items-center flex-wrap gap-2">
										<h4 class="text-white"><?php echo $booking_stats['pending_today'];?></h4>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-sm-6 col-12 d-flex">
						<div class="card bg-info sale-widget flex-fill">
							<div class="card-body d-flex align-items-center">
								<span class="sale-icon bg-white text-info">
									<i class="ti ti-brand-pocket fs-24"></i>
								</span>
								<div class="ms-2">
									<p class="text-white mb-1">Unpaid Invoice</p>
									<div class="d-inline-flex align-items-center flex-wrap gap-2">
										<h4 class="text-white"><?php echo $booking_stats['total_unpaid'];?></h4>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				
				<div class="row">

					<!-- Profit -->
					<div class="col-xl-3 col-sm-6 col-12 d-flex">
						<div class="card revenue-widget flex-fill">
							<div class="card-body">
								<div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
									<div>
										<h4 class="mb-1"><?php echo $booking_stats['total_products'];?></h4>
										<p>Total Products</p>
									</div>
									<span class="revenue-icon bg-cyan-transparent text-cyan">
										<i class="fa-solid fa-layer-group fs-16"></i>
									</span>
								</div>
								<div class="d-flex align-items-center justify-content-between">
									<p class="mb-0"></p>
									<a href="product-list.php" class="text-decoration-underline fs-13 fw-medium">View All</a>
								</div>
							</div>
						</div>
					</div>
					<!-- /Profit -->

					<!-- Invoice -->
					<div class="col-xl-3 col-sm-6 col-12 d-flex">
						<div class="card revenue-widget flex-fill">
							<div class="card-body">
								<div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
									<div>
										<h4 class="mb-1"><?php echo $booking_stats['total_customers'];?></h4>
										<p>Total Cstomers</p>
									</div>
									<span class="revenue-icon bg-teal-transparent text-teal">
										<i class="ti ti-users fs-16"></i>
									</span>
								</div>
								<div class="d-flex align-items-center justify-content-between">
									<div></div>
									<a href="customers.php" class="text-decoration-underline fs-13 fw-medium">View All</a>
								</div>
							</div>
						</div>
					</div>
					<!-- /Invoice -->

					<!-- Expenses -->
					<div class="col-xl-3 col-sm-6 col-12 d-flex d-none" >
						<div class="card revenue-widget flex-fill">
							<div class="card-body">
								<div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
									<div>
										<h4 class="mb-1">
											<?php// echo ucfirst($siteinfo['site_currency'])."". $booking_stats['total_callout_fee'];?></h4>
										<p>Total Callout Fee</p>
									</div>
									<span class="revenue-icon bg-orange-transparent text-orange">
										<i class="ti ti-lifebuoy fs-16"></i>
									</span>
								</div>
								<div class="d-flex align-items-center justify-content-between">
									
								</div>
							</div>
						</div>
					</div>
					<!-- /Expenses -->

					<!-- Returns -->
					<div class="col-xl-3 col-sm-6 col-12 d-flex">
						<div class="card revenue-widget flex-fill">
							<div class="card-body">
								<div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
									<div>
										<h4 class="mb-1"><?php echo ucfirst($siteinfo['site_currency'])."". $booking_stats['total_price'];?></h4>
										<p>Total Payment Returns</p>
									</div>
									<span class="revenue-icon bg-indigo-transparent text-indigo">
										<i class="ti ti-hash fs-16"></i>
									</span>
								</div>
								<div class="d-flex align-items-center justify-content-between">
									
								</div>
							</div>
						</div>
					</div>
					<!-- /Returns -->
					 <div class="row mt-4">

  <!-- Total Sales & Expenses Bar Chart -->
  <div class="col-xl-6 col-12 mb-4 d-none">
    <div class="card">
      <div class="card-header"><h5>Sales vs Expenses</h5></div>
      <div class="card-body">
        <canvas id="salesExpensesChart"></canvas>
      </div>
    </div>
  </div>

  <!-- Upcoming Bookings / Reminders -->
  <div class="col-xl-12 col-12 mb-4">
    <div class="card">
      <div class="card-header"><h5>Upcoming Bookings</h5></div>
      <div class="card-body">
        <ul class="list-group">
          <?php foreach ($dashboard['next_bookings'] as $b): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span>
                <strong><?= htmlspecialchars($b['customer_name']) ?></strong><br>
                <?= htmlspecialchars($b['product_name']) ?> - <?= htmlspecialchars($b['washing_date']) ?> <?= htmlspecialchars($b['washing_time']) ?>
              </span>
              <a href="calendar-view.php?date=<?= urlencode($b['washing_date']) ?>" class="btn btn-sm btn-outline-primary">View</a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>

</div>

<div class="row">
  <!-- Top Services -->
  <div class="col-xl-6 mb-4">
    <div class="card">
      <div class="card-header"><h5>Top Performing Services</h5></div>
      <div class="card-body">
        <ol>
          <?php foreach ($dashboard['top_services'] as $service): ?>
            <li><?= htmlspecialchars($service['product_name']) ?> — <?= $service['total_orders'] ?> Orders</li>
          <?php endforeach; ?>
        </ol>
      </div>
    </div>
  </div>

  <!-- Top Paying Customers -->
  <div class="col-xl-6 mb-4">
    <div class="card">
      <div class="card-header"><h5>Top Paying Customers</h5></div>
      <div class="card-body">
        <ol>
          <?php foreach ($dashboard['top_customers'] as $customer): ?>
            <li><?= htmlspecialchars($customer['name']) ?> — ₦<?= number_format($customer['total_spent'], 2) ?></li>
          <?php endforeach; ?>
        </ol>
      </div>
    </div>
  </div>
</div>


				</div>

			
				
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('salesExpensesChart').getContext('2d');
new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ['Total Sales', 'Total Expenses'],
    datasets: [{
      label: '₦',
      data: [<?= $dashboard['total_sales'] ?>, <?= $dashboard['total_expenses'] ?>],
      backgroundColor: ['#198754', '#dc3545']
    }]
  },
  options: {
    responsive: true,
    plugins: { legend: { display: false } }
  }
});
</script>

		
				
				
			</div>
				<?php include "../../includes/footer.php";?>

		</div>

	</div>
	<!-- /Main Wrapper -->


	<!-- jQuery -->
	<script src="assets/js/jquery-3.7.1.min.js" type="51f3541cc98a5ff8cd8a93c1-text/javascript"></script>

	<!-- Feather Icon JS -->
	<script src="assets/js/feather.min.js" type="51f3541cc98a5ff8cd8a93c1-text/javascript"></script>

	<!-- Slimscroll JS -->
	<script src="assets/js/jquery.slimscroll.min.js" type="51f3541cc98a5ff8cd8a93c1-text/javascript"></script>

	<!-- Bootstrap Core JS -->
	<script src="assets/js/bootstrap.bundle.min.js" type="51f3541cc98a5ff8cd8a93c1-text/javascript"></script>

	<!-- ApexChart JS -->
	<script src="assets/plugins/apexchart/apexcharts.min.js" type="51f3541cc98a5ff8cd8a93c1-text/javascript"></script>
	<script src="assets/plugins/apexchart/chart-data.js" type="51f3541cc98a5ff8cd8a93c1-text/javascript"></script>

	<!-- Chart JS -->
	<script src="assets/plugins/chartjs/chart.min.js" type="51f3541cc98a5ff8cd8a93c1-text/javascript"></script>
	<script src="assets/plugins/chartjs/chart-data.js" type="51f3541cc98a5ff8cd8a93c1-text/javascript"></script>

	<!-- Daterangepikcer JS -->
	<script src="assets/js/moment.min.js" type="51f3541cc98a5ff8cd8a93c1-text/javascript"></script>
	<script src="assets/plugins/daterangepicker/daterangepicker.js" type="51f3541cc98a5ff8cd8a93c1-text/javascript"></script>

	<!-- Select2 JS -->
	<script src="assets/plugins/select2/js/select2.min.js" type="51f3541cc98a5ff8cd8a93c1-text/javascript"></script>

	<!-- Color Picker JS -->
	<script src="assets/plugins/%40simonwep/pickr/pickr.es5.min.js" type="51f3541cc98a5ff8cd8a93c1-text/javascript"></script>

	<!-- Custom JS -->
	<script src="assets/js/theme-colorpicker.js" type="51f3541cc98a5ff8cd8a93c1-text/javascript"></script>
	<script src="assets/js/script.js" type="51f3541cc98a5ff8cd8a93c1-text/javascript"></script>

	
<script src="../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="51f3541cc98a5ff8cd8a93c1-|49" defer></script><script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"98610ad76c8e9496","version":"2025.9.1","serverTiming":{"name":{"cfExtPri":true,"cfEdge":true,"cfOrigin":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}' crossorigin="anonymous"></script>
</body>


</html>