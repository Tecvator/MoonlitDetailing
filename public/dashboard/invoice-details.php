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
      content="<?php echo $siteinfo['site_name'];?>  is a powerful Bootstrap based Inventory Management Admin Template designed for businesses, offering seamless invoicing, project tracking, and estimates."
    />
    <meta
      name="keywords"
      content="inventory management, admin dashboard, bootstrap template, invoicing, estimates, business management, responsive admin, POS system"
    />
    <meta name="author" content="Dreams Technologies" />
    <meta name="robots" content="index, follow" />
    <title><?php echo $siteinfo['site_name'];?> - Admin Dashboard Template</title>



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

    <!-- animation CSS -->
    <link rel="stylesheet" href="assets/css/animate.css" />

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css" />

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap5.min.css" />

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css" />

    <!-- Quill CSS -->
    <link rel="stylesheet" href="assets/plugins/quill/quill.snow.css" />

    <!-- Fontawesome CSS -->
    <link
      rel="stylesheet"
      href="assets/plugins/fontawesome/css/fontawesome.min.css"
    />
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css" />

    <!-- Tabler Icon CSS -->
    <link
      rel="stylesheet"
      href="assets/plugins/tabler-icons/tabler-icons.min.css"
    />

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
      <div class="header">
        <div class="main-header">
          <!-- Logo -->
          <div class="header-left active">
            <a href="index.php" class="logo logo-normal">
              <img src="assets/img/logo.svg" alt="Img" />
            </a>
            <a href="index.php" class="logo logo-white">
              <img src="assets/img/logo-white.svg" alt="Img" />
            </a>
            <a href="index.php" class="logo-small">
              <img src="assets/img/logo-small.png" alt="Img" />
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
                <form action="#" class="dropdown">
                  <div
                    class="searchinputs input-group dropdown-toggle"
                    id="dropdownMenuClickable"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside"
                  >
                    <input type="text" placeholder="Search" />
                    <div class="search-addon">
                      <span><i class="ti ti-search"></i></span>
                    </div>
                    <span class="input-group-text">
                      <kbd class="d-flex align-items-center"
                        ><img
                          src="assets/img/icons/command.svg"
                          alt="img"
                          class="me-1"
                        />K</kbd
                      >
                    </span>
                  </div>
                  <div
                    class="dropdown-menu search-dropdown"
                    aria-labelledby="dropdownMenuClickable"
                  >
                    <div class="search-info">
                      <h6>
                        <span
                          ><i
                            data-feather="search"
                            class="feather-16"
                          ></i></span
                        >Recent Searches
                      </h6>
                      <ul class="search-tags">
                        <li><a href="javascript:void(0);">Products</a></li>
                        <li><a href="javascript:void(0);">Sales</a></li>
                        <li><a href="javascript:void(0);">Applications</a></li>
                      </ul>
                    </div>
                    <div class="search-info">
                      <h6>
                        <span
                          ><i
                            data-feather="help-circle"
                            class="feather-16"
                          ></i></span
                        >Help
                      </h6>
                      <p>
                        How to Change Product Volume from 0 to 200 on Inventory
                        management
                      </p>
                      <p>Change Product Name</p>
                    </div>
                    <div class="search-info">
                      <h6>
                        <span
                          ><i data-feather="user" class="feather-16"></i></span
                        >Customers
                      </h6>
                      <ul class="customers">
                        <li>
                          <a href="javascript:void(0);"
                            >Aron Varu<img
                              src="assets/img/profiles/avator1.jpg"
                              alt="Img"
                              class="img-fluid"
                          /></a>
                        </li>
                        <li>
                          <a href="javascript:void(0);"
                            >Jonita<img
                              src="assets/img/profiles/avatar-01.jpg"
                              alt="Img"
                              class="img-fluid"
                          /></a>
                        </li>
                        <li>
                          <a href="javascript:void(0);"
                            >Aaron<img
                              src="assets/img/profiles/avatar-10.jpg"
                              alt="Img"
                              class="img-fluid"
                          /></a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </form>
              </div>
            </li>
            <!-- /Search -->

            <!-- Select Store -->
            <li
              class="nav-item dropdown has-arrow main-drop select-store-dropdown"
            >
              <a
                href="javascript:void(0);"
                class="dropdown-toggle nav-link select-store"
                data-bs-toggle="dropdown"
              >
                <span class="user-info">
                  <span class="user-letter">
                    <img
                      src="assets/img/store/store-01.png"
                      alt="Store Logo"
                      class="img-fluid"
                    />
                  </span>
                  <span class="user-detail">
                    <span class="user-name">Freshmart</span>
                  </span>
                </span>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <a href="javascript:void(0);" class="dropdown-item">
                  <img
                    src="assets/img/store/store-01.png"
                    alt="Store Logo"
                    class="img-fluid"
                  />Freshmart
                </a>
                <a href="javascript:void(0);" class="dropdown-item">
                  <img
                    src="assets/img/store/store-02.png"
                    alt="Store Logo"
                    class="img-fluid"
                  />Grocery Apex
                </a>
                <a href="javascript:void(0);" class="dropdown-item">
                  <img
                    src="assets/img/store/store-03.png"
                    alt="Store Logo"
                    class="img-fluid"
                  />Grocery Bevy
                </a>
                <a href="javascript:void(0);" class="dropdown-item">
                  <img
                    src="assets/img/store/store-04.png"
                    alt="Store Logo"
                    class="img-fluid"
                  />Grocery Eden
                </a>
              </div>
            </li>
            <!-- /Select Store -->

            <li class="nav-item dropdown link-nav">
              <a
                href="javascript:void(0);"
                class="btn btn-primary btn-md d-inline-flex align-items-center"
                data-bs-toggle="dropdown"
              >
                <i class="ti ti-circle-plus me-1"></i>Add New
              </a>
              <div class="dropdown-menu dropdown-xl dropdown-menu-center">
                <div class="row g-2">
                  <div class="col-md-2">
                    <a href="category-list.php" class="link-item">
                      <span class="link-icon">
                        <i class="ti ti-brand-codepen"></i>
                      </span>
                      <p>Category</p>
                    </a>
                  </div>
                  <div class="col-md-2">
                    <a href="add-product.php" class="link-item">
                      <span class="link-icon">
                        <i class="ti ti-square-plus"></i>
                      </span>
                      <p>Product</p>
                    </a>
                  </div>
                  <div class="col-md-2">
                    <a href="category-list.php" class="link-item">
                      <span class="link-icon">
                        <i class="ti ti-shopping-bag"></i>
                      </span>
                      <p>Purchase</p>
                    </a>
                  </div>
                  <div class="col-md-2">
                    <a href="online-orders.php" class="link-item">
                      <span class="link-icon">
                        <i class="ti ti-shopping-cart"></i>
                      </span>
                      <p>Sale</p>
                    </a>
                  </div>
                  <div class="col-md-2">
                    <a href="expense-list.php" class="link-item">
                      <span class="link-icon">
                        <i class="ti ti-file-text"></i>
                      </span>
                      <p>Expense</p>
                    </a>
                  </div>
                  <div class="col-md-2">
                    <a href="quotation-list.php" class="link-item">
                      <span class="link-icon">
                        <i class="ti ti-device-floppy"></i>
                      </span>
                      <p>Quotation</p>
                    </a>
                  </div>
                  <div class="col-md-2">
                    <a href="sales-returns.php" class="link-item">
                      <span class="link-icon">
                        <i class="ti ti-copy"></i>
                      </span>
                      <p>Return</p>
                    </a>
                  </div>
                  <div class="col-md-2">
                    <a href="users.php" class="link-item">
                      <span class="link-icon">
                        <i class="ti ti-user"></i>
                      </span>
                      <p>User</p>
                    </a>
                  </div>
                  <div class="col-md-2">
                    <a href="customers.php" class="link-item">
                      <span class="link-icon">
                        <i class="ti ti-users"></i>
                      </span>
                      <p>Customer</p>
                    </a>
                  </div>
                  <div class="col-md-2">
                    <a href="sales-report.php" class="link-item">
                      <span class="link-icon">
                        <i class="ti ti-shield"></i>
                      </span>
                      <p>Biller</p>
                    </a>
                  </div>
                  <div class="col-md-2">
                    <a href="suppliers.php" class="link-item">
                      <span class="link-icon">
                        <i class="ti ti-user-check"></i>
                      </span>
                      <p>Supplier</p>
                    </a>
                  </div>
                  <div class="col-md-2">
                    <a href="stock-transfer.php" class="link-item">
                      <span class="link-icon">
                        <i class="ti ti-truck"></i>
                      </span>
                      <p>Transfer</p>
                    </a>
                  </div>
                </div>
              </div>
            </li>

            <li class="nav-item pos-nav">
              <a
                href="pos.php"
                class="btn btn-dark btn-md d-inline-flex align-items-center"
              >
                <i class="ti ti-device-laptop me-1"></i>POS
              </a>
            </li>

            <!-- Flag -->
            <li class="nav-item dropdown has-arrow flag-nav nav-item-box">
              <a
                class="nav-link dropdown-toggle"
                data-bs-toggle="dropdown"
                href="javascript:void(0);"
                role="button"
              >
                <img
                  src="assets/img/flags/us-flag.svg"
                  alt="Language"
                  class="img-fluid"
                />
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <a href="javascript:void(0);" class="dropdown-item">
                  <img
                    src="assets/img/flags/english.svg"
                    alt="Img"
                    height="16"
                  />English
                </a>
                <a href="javascript:void(0);" class="dropdown-item">
                  <img
                    src="assets/img/flags/arabic.svg"
                    alt="Img"
                    height="16"
                  />Arabic
                </a>
              </div>
            </li>
            <!-- /Flag -->

            <li class="nav-item nav-item-box">
              <a href="javascript:void(0);" id="btnFullscreen">
                <i class="ti ti-maximize"></i>
              </a>
            </li>
            <li class="nav-item nav-item-box">
              <a href="email.php">
                <i class="ti ti-mail"></i>
                <span class="badge rounded-pill">1</span>
              </a>
            </li>
            <!-- Notifications -->
            <li class="nav-item dropdown nav-item-box">
              <a
                href="javascript:void(0);"
                class="dropdown-toggle nav-link"
                data-bs-toggle="dropdown"
              >
                <i class="ti ti-bell"></i>
              </a>
              <div class="dropdown-menu notifications">
                <div class="topnav-dropdown-header">
                  <h5 class="notification-title">Notifications</h5>
                  <a href="javascript:void(0)" class="clear-noti"
                    >Mark all as read</a
                  >
                </div>
                <div class="noti-content">
                  <ul class="notification-list">
                    <li class="notification-message">
                      <a href="activities.php">
                        <div class="media d-flex">
                          <span class="avatar flex-shrink-0">
                            <img
                              alt="Img"
                              src="assets/img/profiles/avatar-13.jpg"
                            />
                          </span>
                          <div class="flex-grow-1">
                            <p class="noti-details">
                              <span class="noti-title">James Kirwin</span>
                              confirmed his order. Order No: #78901.Estimated
                              delivery: 2 days
                            </p>
                            <p class="noti-time">4 mins ago</p>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li class="notification-message">
                      <a href="activities.php">
                        <div class="media d-flex">
                          <span class="avatar flex-shrink-0">
                            <img
                              alt="Img"
                              src="assets/img/profiles/avatar-03.jpg"
                            />
                          </span>
                          <div class="flex-grow-1">
                            <p class="noti-details">
                              <span class="noti-title">Leo Kelly</span>
                              cancelled his order scheduled for 17 Jan 2025
                            </p>
                            <p class="noti-time">10 mins ago</p>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li class="notification-message">
                      <a href="activities.php" class="recent-msg">
                        <div class="media d-flex">
                          <span class="avatar flex-shrink-0">
                            <img
                              alt="Img"
                              src="assets/img/profiles/avatar-17.jpg"
                            />
                          </span>
                          <div class="flex-grow-1">
                            <p class="noti-details">
                              Payment of $50 received for Order #67890 from
                              <span class="noti-title">Antonio Engle</span>
                            </p>
                            <p class="noti-time">05 mins ago</p>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li class="notification-message">
                      <a href="activities.php" class="recent-msg">
                        <div class="media d-flex">
                          <span class="avatar flex-shrink-0">
                            <img
                              alt="Img"
                              src="assets/img/profiles/avatar-02.jpg"
                            />
                          </span>
                          <div class="flex-grow-1">
                            <p class="noti-details">
                              <span class="noti-title">Andrea</span> confirmed
                              his order. Order No: #73401.Estimated delivery: 3
                              days
                            </p>
                            <p class="noti-time">4 mins ago</p>
                          </div>
                        </div>
                      </a>
                    </li>
                  </ul>
                </div>
                <div
                  class="topnav-dropdown-footer d-flex align-items-center gap-3"
                >
                  <a href="#" class="btn btn-secondary btn-md w-100">Cancel</a>
                  <a href="activities.php" class="btn btn-primary btn-md w-100"
                    >View all</a
                  >
                </div>
              </div>
            </li>
            <!-- /Notifications -->

            <li class="nav-item nav-item-box">
              <a href="general-settings.php"><i class="ti ti-settings"></i></a>
            </li>
            <li class="nav-item dropdown has-arrow main-drop profile-nav">
              <a
                href="javascript:void(0);"
                class="nav-link userset"
                data-bs-toggle="dropdown"
              >
                <span class="user-info p-0">
                  <span class="user-letter">
                    <img
                      src="assets/img/profiles/avator1.jpg"
                      alt="Img"
                      class="img-fluid"
                    />
                  </span>
                </span>
              </a>
              <div class="dropdown-menu menu-drop-user">
                <div class="profileset d-flex align-items-center">
                  <span class="user-img me-2">
                    <img src="assets/img/profiles/avator1.jpg" alt="Img" />
                  </span>
                  <div>
                    <h6 class="fw-medium">John Smilga</h6>
                    <p>Admin</p>
                  </div>
                </div>
                <a class="dropdown-item" href="profile.php"
                  ><i class="ti ti-user-circle me-2"></i>MyProfile</a
                >
                <a class="dropdown-item" href="sales-report.php"
                  ><i class="ti ti-file-text me-2"></i>Reports</a
                >
                <a class="dropdown-item" href="general-settings.php"
                  ><i class="ti ti-settings-2 me-2"></i>Settings</a
                >
                <hr class="my-2" />
                <a class="dropdown-item logout pb-0" href="signin.php"
                  ><i class="ti ti-logout me-2"></i>Logout</a
                >
              </div>
            </li>
          </ul>
          <!-- /Header Menu -->

          <!-- Mobile Menu -->
          <div class="dropdown mobile-user-menu">
            <a
              href="javascript:void(0);"
              class="nav-link dropdown-toggle"
              data-bs-toggle="dropdown"
              aria-expanded="false"
              ><i class="fa fa-ellipsis-v"></i
            ></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="profile.php">My Profile</a>
              <a class="dropdown-item" href="general-settings.php">Settings</a>
              <a class="dropdown-item" href="signin.php">Logout</a>
            </div>
          </div>
          <!-- /Mobile Menu -->
        </div>
      </div>
      <!-- /Header -->


			<!-- Header -->

		<?php include ("../../src/views/header.php");?>
		<!-- /Header -->

		<!-- Sidebar -->
			<?php include ("../../src/views/sidemenu.php");

      ?>
		<!-- /Sidebar -->

      <div class="page-wrapper">
        <div class="content">
          <div class="page-header">
            <div class="add-item d-flex">
              <div class="page-title">
                <h4>Invoice Details</h4>
              </div>
            </div>
            <ul class="table-top-head">
              <li>
    <a href="#" class="action-btn" data-action="pdf" data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf">
      <img src="assets/img/icons/pdf.svg" alt="img" />
    </a>
  </li>
  <li>
    <a href="#" class="action-btn" data-action="print" data-bs-toggle="tooltip" data-bs-placement="top" title="Print">
      <i data-feather="printer" class="feather-rotate-ccw"></i>
    </a>
  </li>


            </ul>
            <div class="page-btn">
              <a href="invoice.php" class="btn btn-primary"
                ><i data-feather="arrow-left" class="me-2"></i>Back to
                Invoices</a
              >
            </div>
          </div>
  <?php
  if (isset($_GET['id'])) {
    $booking_id = intval($_GET['id']);
    $booking = getBookingById($conn, $booking_id);

    if ($booking) {
        echo "<pre>";

        echo "</pre>";
    } else {
        echo "Booking not found.";
    }
} else {
    header("Location: index.php");
    exit;
}
  ?><?php
$totalAmount = $booking['price'] + $booking['callout_fee'];
$amountInWords = numberToWords($totalAmount);
?>

          <!-- Invoices -->
          <div class="card" id="invoice-section">
            <div class="card-body">
              <div
                class="row justify-content-between align-items-center border-bottom mb-3"
              >
                <div class="col-md-6">
                  <div class="mb-2">
                    <img
                      src="<?php echo $siteinfo['site_logo'];?>"
                      width="50"
                      class="img-fluid"
                      alt="logo"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="text-end mb-3">
                    <h5 class="text-gray mb-1">
                      Invoice No <span class="text-primary">#<?php echo $booking['booking_id'];?></span>
                    </h5>
                    <p class="mb-1 fw-medium">
                      Created Date : <span class="text-dark"><?php echo $booking['created_at'];?></span>
                    </p>
                    <p class="fw-medium">
                      Due Date : <span class="text-dark"><?php echo $booking['washing_date'];?></span>
                    </p>
                  </div>
                </div>
              </div>
              <div class="row border-bottom mb-3">
                <div class="col-md-5">
                  <p class="text-dark mb-2 fw-semibold">From</p>
                  <div>
                    <h4 class="mb-1"><?php echo e($siteinfo['site_name'] ?? 'N/A');?></h4>
                    <p class="mb-1"><?php echo e($siteinfo['site_address'] ?? 'N/A');?></p>
                    <p class="mb-1">
                      Email :
                      <span class="text-dark"
                        ><a


                          ><?php echo e($siteinfo['site_email'] ?? 'N/A');?></a
                        ></span
                      >
                    </p>
                    <p>
                      Phone : <span class="text-dark"><?php echo e($siteinfo['site_phone'] ?? 'N/A');?></span>
                    </p>
                  </div>
                </div>
                <div class="col-md-5">
                  <p class="text-dark mb-2 fw-semibold">To</p>
                  <div>
                    <h4 class="mb-1"><?php echo e($booking['customer_name'] ?? 'N/A');?></h4>
                    <p class="mb-1"><?php echo e($booking['customer_address'] ?? 'N/A');?></p>
                    <p class="mb-1">
                      Email :
                      <span class="text-dark"
                        ><a


                          ><?php echo e($booking['customer_email'] ?? 'N/A');?></a
                        ></span
                      >
                    </p>
                    <p>
                      Phone : <span class="text-dark"><?php echo e($booking['customer_phone'] ?? 'N/A');?></span>
                    </p>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="mb-3">
                    <p class="text-title mb-2 fw-medium">Payment Status</p>
                 <?php
$paymentStatus = strtolower($booking['payment_status']); // normalize case
$statusClass = $paymentStatus === 'paid' ? 'bg-success text-white' : 'bg-warning text-dark';
?>
<span class="<?php echo $statusClass; ?> fs-10 px-1 rounded">
  <i class="ti ti-point-filled"></i>
  <?php echo e($paymentStatus ?? 'pending'); ?>
</span>

                    <div class="mt-3">

                  </div>
                  </div>
                </div>
              </div>
              <div>
                <p class="fw-medium">
                  Invoice For :
                  <span class="text-dark fw-medium"
                    ><?php echo e($booking['category_name'] ?? 'N/A') . " - " . e($booking['product_name'] ?? 'N/A')
                    . " - " . e($booking['car_type'] ?? 'N/A') . " - " . e($booking['car_info'] ?? 'N/A');?></span
                  >
                </p>
                <div class="table-responsive mb-3">
                  <table class="table">
                    <thead class="thead-light">
                      <tr>
                        <th>Sevice Description</th>
                        <th class="text-end"></th>
                        <th class="text-end"></th>
                        <th class="text-end"></th>
                        <th class="text-end">Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><h6><?php echo e($booking['product_name'] ?? 'N/A');?></h6></td>
                        <td class="text-gray-9 fw-medium text-end"></td>
                        <td class="text-gray-9 fw-medium text-end"></td>
                        <td class="text-gray-9 fw-medium text-end"></td>
                        <td class="text-gray-9 fw-medium text-end">
                          <?php echo e($siteinfo['site_currency'] ?? 'R') . "" . e($booking['price'] ?? '0.00');?></td>
                      </tr>
                      <tr>
                        <td><h6>Call Out Fee</h6></td>
                        <td class="text-gray-9 fw-medium text-end"></td>
                        <td class="text-gray-9 fw-medium text-end"></td>
                        <td class="text-gray-9 fw-medium text-end"></td>
                        <td class="text-gray-9 fw-medium text-end"><?php echo e($siteinfo['site_currency'] ?? 'R') . "" . e($booking['callout_fee'] ?? '0.00');?></td>
                      </tr>




                    </tbody>
                  </table>
                </div>
              </div>
              <div class="row border-bottom mb-3">
                <div class="col-md-5 ms-auto mb-3">






                  <div
                    class="d-flex justify-content-between align-items-center mb-2 pe-3"
                  >
                    <h5>Total Amount</h5>
                    <h5><?php echo $siteinfo['site_currency'] . number_format($totalAmount, 2); ?></h5>
                  </div>
                  <p class="fs-12">
                    Amount in Words : <?php echo   $amountInWords; ?>
                  </p>
                </div>
              </div>
              <div class="row align-items-center border-bottom mb-3">
                <div class="col-md-7">
                  <div>
                    <div class="mb-3">
                      <h6 class="mb-1">Terms and Conditions</h6>
                      <p>
                        <?php echo $siteinfo['site_terms']; ?>

                      </p>
                    </div>
                    <div class="mb-3">
                      <h6 class="mb-1">Notes</h6>
                      <p> <?php echo $siteinfo['site_note']; ?></p>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <?php if (!empty($admin['admin_signature'])): ?>
                  <div class="text-end">
                    <img
                      src="<?php echo e($admin['admin_signature']);?>"
                      class="img-fluid"
                      alt="sign"
                      style="width: 120px; height: 40px;"
                    />
                  </div>
                  <?php endif; ?>
                  <div class="text-end mb-3">
                    <h6 class="fs-14 fw-medium pe-3"><?php echo e($admin['username'] ?? 'Admin');?></h6>
                    <p><?php echo e(($admin['is_super_admin'] ?? 'no') === 'yes' ? 'Super Admin' : 'Administrator');?></p>
                  </div>
                </div>
              </div>
              <div class="text-center">
                <div class="mb-3">
                  <img
                    src="<?php echo ($siteinfo['site_logo']);?>"
                    width="130"
                    class="img-fluid"
                    alt="logo"
                  />
                </div>
                <p class="text-dark mb-1">
                  Payment Made Via bank transfer / Cheque in the name of <?php echo e($sitebank['account_name'] ?? 'N/A');?>
                </p>
                <div class="d-flex justify-content-center align-items-center">
                  <p class="fs-12 mb-0 me-3">
                    Bank Name : <span class="text-dark"> <?php echo e($sitebank['bank_name'] ?? 'N/A');?></span>
                  </p>
                  <p class="fs-12 mb-0 me-3">
                    Account Number : <span class="text-dark"> <?php echo e($sitebank['account_number'] ?? 'N/A');?></span>
                  </p>
                  <p class="fs-12 d-none">
                    IFSC : <span class="text-dark">HDFC0018159</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
          <!-- /Invoices -->

          <div class="d-flex justify-content-center align-items-center mb-4">


  <a
    href="#"
    class="btn btn-primary d-flex justify-content-center align-items-center me-2 print-btn"
  >              <i class="ti ti-printer me-2"></i>Print Invoice</a
            >


          </div>
        </div>
       	<?php include ("../../src/views/footer.php");?>
      </div>
    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script
      data-cfasync="false"
      src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"
    ></script>
    <script
      src="assets/js/jquery-3.7.1.min.js"

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

    <!-- Datetimepicker JS -->
    <script
      src="assets/js/moment.min.js"

    ></script>
    <script
      src="assets/js/bootstrap-datetimepicker.min.js"

    ></script>

    <!-- Bootstrap Core JS -->
    <script
      src="assets/js/bootstrap.bundle.min.js"

    ></script>

    <!-- Quill JS -->
    <script
      src="assets/plugins/quill/quill.min.js"

    ></script>

    <!-- Select2 JS -->
    <script
      src="assets/plugins/select2/js/select2.min.js"

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
      data-cf-settings="273dda1991057fa509273705-|49"
      defer
    ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
document.addEventListener('click', function(e) {
  const btn = e.target.closest('.action-btn, .print-btn');
  if (!btn) return;

  e.preventDefault();

  const action = btn.dataset.action || 'print'; // default print for .print-btn

  if (action === 'print') {
    window.print();
  }

  if (action === 'pdf') {
    const element = document.getElementById('invoice-section');
    const opt = {
      margin:       0.5,
      filename:     '#<?php echo $booking['booking_id'];?>-invoice.pdf',
      image:        { type: 'jpeg', quality: 0.98 },
      html2canvas:  { scale: 2 },
      jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
    };
    html2pdf().from(element).set(opt).save();
  }
});
</script>



  </body>


  </html>
