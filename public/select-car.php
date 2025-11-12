<?php
require_once __DIR__ . '/../src/config/init.php';

// Check if user came from location selection page
if (!isset($_SESSION['booking_data'])) {
  header('Location: index.php');
  exit();
}

// Helper function to map car names to image files
function getCarImage($carName)
{
  $carName = strtolower($carName);

  if (strpos($carName, 'sedan') !== false || strpos($carName, 'coupe') !== false) {
    return 'sedan.jpg';
  } elseif (strpos($carName, 'suv') !== false || strpos($carName, 'bakkie') !== false) {
    return 'suv.jpg';
  } elseif (strpos($carName, 'van') !== false) {
    return 'van.jpg';
  }

  return 'sedan.jpg'; // default fallback
}

$carsResponse = fetchFromApi("get_cars", ["limit" => 10, "category" => "SUV"]);
if ($carsResponse['status'] === true) {
  $cars = $carsResponse['data'];

  // Add image URLs to each car
  foreach ($cars as &$car) {
    $car['img_url'] = getCarImage($car['car_name']);
  }
  unset($car); // break the reference
} else {
  echo $carsResponse['message'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Select Your Car</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@300;400;600;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/select_car.css">
  <style>
    /* Loading overlay */
    .loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.8);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }

    .loading-overlay.show {
      display: flex;
    }

    .loading-content {
      text-align: center;
      color: #fff;
    }

    .spinner {
      border: 4px solid rgba(255, 255, 255, 0.3);
      border-top: 4px solid #fff;
      border-radius: 50%;
      width: 50px;
      height: 50px;
      animation: spin 1s linear infinite;
      margin: 0 auto 20px;
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    .ob-car-card {
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .ob-car-card:hover {
      transform: scale(1.03);
    }
  </style>
</head>

<body>

  <!-- Loading overlay -->
  <div class="loading-overlay" id="loadingOverlay">
    <div class="loading-content">
      <div class="spinner"></div>
      <p>Saving your selection...</p>
    </div>
  </div>

  <section class="ob-car-selection d-flex align-items-center text-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <!-- Title + Subtitle -->
          <div class="text-start ob-title-wrap mb-5">
            <h1 class="ob-title">Select Your Car</h1>
            <p class="ob-subtitle">Big Or Small, We Bring The Same Premium Shine.</p>
          </div>

          <!-- Car Cards -->
          <div class="row justify-content-start">
            <?php if (!empty($cars)): ?>
              <?php foreach ($cars as $car): ?>
                <div class="col-md-4 col-sm-6 mb-4" data-carid="<?php echo e($car['car_id']); ?>"
                  data-carname="<?php echo e($car['car_name']); ?>"
                  data-carimage="assets/images/<?php echo e($car['img_url']); ?>">
                  <div class="ob-car-card">
                    <div class="ob-card-overlay-top"></div>
                    <div class="ob-card-overlay-bottom"></div>
                    <img src="assets/images/<?php echo e($car['img_url']); ?>" alt="<?php echo e($car['car_name']); ?>"
                      class="img-fluid">
                    <h5 class="ob-car-name"><?php echo e($car['car_name']); ?></h5>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="col-12">
                <p>No cars available.</p>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {

      // Get all car card containers
      const carCardContainers = document.querySelectorAll('[data-carid]');
      const loadingOverlay = document.getElementById('loadingOverlay');

      // Add click event to each card container
      carCardContainers.forEach(container => {
        container.addEventListener('click', function() {

          // Get car data from data attributes
          const carId = this.getAttribute('data-carid');
          const carName = this.getAttribute('data-carname');
          const carImage = this.getAttribute('data-carimage');

          // Show loading overlay
          loadingOverlay.classList.add('show');

          // Get booking data from sessionStorage
          const bookingDataStr = sessionStorage.getItem('bookingData');
          let bookingData = bookingDataStr ? JSON.parse(bookingDataStr) : {};

          // Add car data to booking
          bookingData.carId = carId;
          bookingData.carName = carName;
          bookingData.carImage = carImage;

          // Save to sessionStorage
          sessionStorage.setItem('bookingData', JSON.stringify(bookingData));

          // Make AJAX call to save to PHP session
          fetch('save-car-to-session.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
              },
              body: JSON.stringify(bookingData)
            })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                console.log('Car selection saved:', data);
                // Redirect to next page immediately
                window.location.href = 'select-plan.php';
              } else {
                throw new Error(data.message || 'Failed to save car selection');
              }
            })
            .catch(error => {
              console.error('Error:', error);
              loadingOverlay.classList.remove('show');
              alert('An error occurred. Please try again.');
            });
        });
      });
    });
  </script>
</body>

</html>
