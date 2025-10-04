	<div class="sidebar" id="sidebar">
			<!-- Logo -->
			<div class="sidebar-logo active">
				<a href="index.php" class="logo logo-normal">
					<img src="assets/img/logo.svg" alt="Img">
				</a>
				<a href="index.php" class="logo logo-white">
					<img src="assets/img/logo-white.svg" alt="Img">
				</a>
				<a href="index.php" class="logo-small">
					<img src="assets/img/logo-small.png" alt="Img">
				</a>
				<a id="toggle_btn" href="javascript:void(0);">
					<i data-feather="chevrons-left" class="feather-16"></i>
				</a>
			</div>
			<!-- /Logo -->
			<div class="modern-profile p-3 pb-0">
				<div class="text-center rounded bg-light p-3 mb-4 user-profile">
					<div class="avatar avatar-lg online mb-3">
						<img src="assets/img/customer/customer15.jpg" alt="Img" class="img-fluid rounded-circle">
					</div>
					<h6 class="fs-14 fw-bold mb-1">Adrian Herman</h6>
					<p class="fs-12 mb-0">System Admin</p>
				</div>
				<div class="sidebar-nav mb-3">
					<ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified bg-transparent" role="tablist">
						<li class="nav-item"><a class="nav-link active border-0" href="#">Menu</a></li>
						<li class="nav-item"><a class="nav-link border-0" href="chat.php">Chats</a></li>
						<li class="nav-item"><a class="nav-link border-0" href="email.php">Inbox</a></li>
					</ul>
				</div>
			</div>
			<div class="sidebar-header p-3 pb-0 pt-2">
				<div class="text-center rounded bg-light p-2 mb-4 sidebar-profile d-flex align-items-center">
					<div class="avatar avatar-md onlin">
						<img src="assets/img/customer/customer15.jpg" alt="Img" class="img-fluid rounded-circle">
					</div>
					<div class="text-start sidebar-profile-info ms-2">
						<h6 class="fs-14 fw-bold mb-1">Adrian Herman</h6>
						<p class="fs-12">System Admin</p>
					</div>
				</div>
				<div class="d-flex align-items-center justify-content-between menu-item mb-3">
					<div>
						<a href="index.php" class="btn btn-sm btn-icon bg-light">
							<i class="ti ti-layout-grid-remove"></i>
						</a>
					</div>
					<div>
						<a href="chat.php" class="btn btn-sm btn-icon bg-light">
							<i class="ti ti-brand-hipchat"></i>
						</a>
					</div>
					<div>
						<a href="email.php" class="btn btn-sm btn-icon bg-light position-relative">
							<i class="ti ti-message"></i>
						</a>
					</div>
					<div class="notification-item">
						<a href="activities.php" class="btn btn-sm btn-icon bg-light position-relative">
							<i class="ti ti-bell"></i>
							<span class="notification-status-dot"></span>
						</a>
					</div>
					<div class="me-0">
						<a href="general-settings.php" class="btn btn-sm btn-icon bg-light">
							<i class="ti ti-settings"></i>
						</a>
					</div>
				</div>
			</div>
			<div class="sidebar-inner slimscroll">
				<div id="sidebar-menu" class="sidebar-menu">
					<ul>
						<li class="submenu-open">
							<h6 class="submenu-hdr">Main</h6>
							<ul>
							
                            <li><a href="./" class="subdrop active"><i class="ti ti-layout-grid fs-16 me-2" data-feather="box"></i><span>Admin Dashboard</span></a></li>

								<li class="submenu" style="display: none">
									<a href="javascript:void(0);"><i class="ti ti-user-edit fs-16 me-2"></i><span>Super Admin</span><span class="menu-arrow"></span></a>
									<ul>
										<li><a href="dashboard.php">Dashboard</a></li>
										<li><a href="companies.php">Companies</a></li>
										<li><a href="subscription.php">Subscriptions</a></li>
										<li><a href="packages.php">Packages</a></li>
										<li><a href="domain.php">Domain</a></li>
										<li><a href="purchase-transaction.php">Purchase Transaction</a></li>
									</ul>
								</li>
						
							</ul>
						</li>
						<li class="submenu-open">
							<h6 class="submenu-hdr">Product/Category</h6>
							<ul>
                                <li><a href="car-types-list.php"><i class="ti ti-car fs-16 me-2"></i><span>Car Types</span></a></li>
								<li><a href="product-list.php"><i data-feather="box"></i><span>Products</span></a></li>
								<li><a href="add-product.php"><i class="ti ti-table-plus fs-16 me-2"></i><span>Create Product</span></a></li>
								<li><a href="category-list.php"><i class="ti ti-list-details fs-16 me-2"></i><span>Category</span></a></li>
								<!--li><a href="sub-categories.php"><i class="ti ti-carousel-vertical fs-16 me-2"></i><span>Sub Category</span></a></li>
								<li><a href="brand-list.php"><i class="ti ti-triangles fs-16 me-2"></i><span>Product Features</span></a></li>
-->
							</ul>
						</li>
					
						<li class="submenu-open">
							<h6 class="submenu-hdr">Sales</h6>
							<ul>
							
								<li><a href="online-orders.php"><i class="ti ti-layout-grid fs-16 me-2"></i><span>Online Orders</span></a></li>
								<li><a href="invoice.php"><i class="ti ti-file-invoice fs-16 me-2"></i><span>Invoices</span></a></li>

							</ul>
						</li>
						<li class="submenu-open" style="display: none!important">
							<h6 class="submenu-hdr">Promo</h6>
							<ul>
								<li><a href="coupons.php"><i class="ti ti-ticket fs-16 me-2"></i><span>Coupons</span></a></li>
								<li><a href="gift-cards.php"><i class="ti ti-cards fs-16 me-2"></i><span>Gift Cards</span></a></li>
								<li class="submenu">
									<a href="javascript:void(0);"><i class="ti ti-file-percent fs-16 me-2"></i><span>Discount</span><span class="menu-arrow"></span></a>
									<ul>
										<li><a href="discount-plan.php">Discount Plan</a></li>
										<li><a href="discount.php">Discount</a></li>
									</ul>
								</li>
							</ul>
						</li>
					
						<li class="submenu-open">
							<h6 class="submenu-hdr">Peoples</h6>
							<ul>
								<li><a href="customers.php"><i class="ti ti-users-group fs-16 me-2"></i><span>Customers</span></a></li>
							
							</ul>
						</li>
						
						<li class="submenu-open" style="display: none">
							<h6 class="submenu-hdr">Reports</h6>
							<ul>
								<li class="submenu">
									<a href="javascript:void(0);"><i class="ti ti-chart-bar fs-16 me-2"></i><span>Sales Report</span><span class="menu-arrow"></span></a>
									<ul>
										<li><a href="sales-report.php">Sales Report</a></li>
										<li><a href="best-seller.php">Best Seller</a></li>
									</ul>
								</li>
								<li><a href="purchase-report.php"><i class="ti ti-chart-pie-2 fs-16 me-2"></i><span>Purchase report</span></a></li>
								<li class="submenu">
									<a href="javascript:void(0);"><i class="ti ti-triangle-inverted fs-16 me-2"></i><span>Inventory Report</span><span class="menu-arrow"></span></a>
									<ul>
										<li><a href="inventory-report.php">Inventory Report</a></li>
										<li><a href="stock-history.php">Stock History</a></li>
										<li><a href="sold-stock.php">Sold Stock</a></li>
									</ul>
								</li>
								<li><a href="invoice-report.php"><i class="ti ti-businessplan fs-16 me-2"></i><span>Invoice Report</span></a></li>
								<li class="submenu">
									<a href="javascript:void(0);"><i class="ti ti-user-star fs-16 me-2"></i><span>Supplier Report</span><span class="menu-arrow"></span></a>
									<ul>
										<li><a href="supplier-report.php">Supplier Report</a></li>
										<li><a href="supplier-due-report.php">Supplier Due Report</a></li>
									</ul>
								</li>
								<li class="submenu">
									<a href="javascript:void(0);"><i class="ti ti-report fs-16 me-2"></i><span>Customer Report</span><span class="menu-arrow"></span></a>
									<ul>
										<li><a href="customer-report.php">Customer Report</a></li>
										<li><a href="customer-due-report.php">Customer Due Report</a></li>
									</ul>
								</li>
								<li class="submenu">
									<a href="javascript:void(0);"><i class="ti ti-report-analytics fs-16 me-2"></i><span>Product Report</span><span class="menu-arrow"></span></a>
									<ul>
										<li><a href="product-report.php">Product Report</a></li>
										<li><a href="product-expiry-report.php">Product Expiry Report</a></li>
										<li><a href="product-quantity-alert.php">Product Quantity Alert</a></li>
									</ul>
								</li>
								<li><a href="expense-report.php"><i class="ti ti-file-vector fs-16 me-2"></i><span>Expense Report</span></a></li>
								<li><a href="income-report.php"><i class="ti ti-chart-ppf fs-16 me-2"></i><span>Income Report</span></a></li>
								<li><a href="tax-reports.php"><i class="ti ti-chart-dots-2 fs-16 me-2"></i><span>Tax Report</span></a></li>
								<li><a href="profit-and-loss.php"><i class="ti ti-chart-donut fs-16 me-2"></i><span>Profit & Loss</span></a></li>
								<li><a href="annual-report.php"><i class="ti ti-report-search fs-16 me-2"></i><span>Annual Report</span></a></li>
							</ul>
						</li>
					
						<li class="submenu-open">
							<h6 class="submenu-hdr">Settings</h6>
							<ul>
								<li class="submenu">
									<a href="javascript:void(0);"><i class="ti ti-settings fs-16 me-2"></i><span>General Settings</span><span class="menu-arrow"></span></a>
									<ul>
										<li><a href="general-settings.php">Profile</a></li>
										<li><a href="security-settings.php">Security</a></li>
									
									</ul>
								</li>
							<li>
									<a href="company-settings.php"><i class="ti ti-world fs-16 me-2"></i><span>Company Settings</span> </a>
								</li>
								
								<li>
									<a href="signin.php"><i class="ti ti-logout fs-16 me-2"></i><span>Logout</span> </a>
								</li>
							</ul>
						</li>
					
					</ul>
				</div>
			</div>
		</div>