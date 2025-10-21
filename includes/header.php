	<div class="header">
			<div class="main-header">
				<!-- Logo -->
				<div class="header-left active">
					<a href="index.php" class="logo logo-normal " style="height: 40px !important; weight: 40px">
						<img src="<?php echo $siteinfo['site_logo'];?>" alt="Img" style="height: 40px !important; weight: 40px">
					</a>
					<a href="index.php" class="logo logo-white" style="height: 40px !important; weight: 40px">
						<img src="<?php echo $siteinfo['site_logo'];?>" alt="Img" style="height: 40px !important; weight: 40px">
					</a>
					<a href="index.php" class="logo-small" style="height: 40px !important; weight: 40px">
						<img src="<?php echo $siteinfo['site_logo'];?>" alt="Img" style="height: 40px !important; weight: 40px">
					</a>
				</div>
				<!-- /Logo -->
				<a id="mobile_btn" class="mobile_btn" href="#sidebar">
					<span class="bar-icon">
						<span></span>
						<span></span>
						<span></span>
					</span>
				</a>

				<!-- Header Menu -->
				<ul class="nav user-menu">

					<!-- Search -->
					<li class="nav-item nav-searchinputs">
						<div class="top-nav-search">
							<a href="javascript:void(0);" class="responsive-search">
								<i class="fa fa-search"></i>
							</a>
						
						</div>
					</li>
					<!-- /Search -->

				


					<li class="nav-item nav-item-box">
						<a href="javascript:void(0);" id="btnFullscreen">
							<i class="ti ti-maximize"></i>
						</a>
					</li>
				

				
					<li class="nav-item dropdown has-arrow main-drop profile-nav">
						<a href="javascript:void(0);" class="nav-link userset" data-bs-toggle="dropdown">
							<span class="user-info p-0">
								<span class="user-letter">
									<img src="<?php echo $siteinfo['site_logo'];?>" alt="Img" class="img-fluid">
								</span>
							</span>
						</a>
						<div class="dropdown-menu menu-drop-user">
							<div class="profileset d-flex align-items-center">
								<span class="user-img me-2">
									<img src="<?php echo $siteinfo['site_logo'];?>" alt="Img">
								</span>
								<div>
									<h6 class="fw-medium"><?php echo($admin['username']);?></h6>
									<p><?php if($admin['is_super_admin']== "yes"){
                                        echo "Super Admin";
                                    }else{
                                           echo "Admin";
                                    }?></p>
								</div>
							</div>
							<a class="dropdown-item" href="profile.php"><i class="ti ti-user-circle me-2"></i>MyProfile</a>
							<!--a class="dropdown-item" href="sales-report.php"><i class="ti ti-file-text me-2"></i>Reports</a>
							<a class="dropdown-item" href="general-settings.php"><i class="ti ti-settings-2 me-2"></i>Settings</a-->
							<hr class="my-2">
							<a class="dropdown-item logout pb-0" href="signin.php"><i class="ti ti-logout me-2"></i>Logout</a>
						</div>
					</li>
				</ul>
				<!-- /Header Menu -->

				<!-- Mobile Menu -->
				<div class="dropdown mobile-user-menu">
					<a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
						aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
					<div class="dropdown-menu dropdown-menu-right">
						<a class="dropdown-item" href="profile.php">My Profile</a>
						<a class="dropdown-item" href="general-settings.php">Settings</a>
						<a class="dropdown-item" href="signin.php">Logout</a>
					</div>
				</div>
				<!-- /Mobile Menu -->
			</div>
		</div>