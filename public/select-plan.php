<?php
require_once __DIR__ . '/../src/config/init.php';

// Check if user came from car selection page
if (!isset($_SESSION['booking_data'])) {
  header('Location: index.php');
  exit();
}

$carID = $_SESSION['booking_data']['carId'];

$categoriesResponse = fetchFromApi("get_categories", ["limit" => 1000]);
if ($categoriesResponse['status'] === true) {
  $categories = $categoriesResponse['data'];
} else {
  $categories = [];
}

$planResponse = fetchFromApi("get_products", ["limit" => 1000, "carID" => $carID]);
if ($planResponse['status'] === true) {
  $plans = $planResponse['data'];
} else {
  $plans = [];
}

// Get selected car from session
$selectedCarId = isset($_SESSION['booking_data']['carId']) ? $_SESSION['booking_data']['carId'] : null;

// Helper function to determine plan label based on features
function getPlanLabel($features)
{
  $types = array_unique(array_column($features, 'type'));
  $hasExterior = in_array('exterior', $types);
  $hasInterior = in_array('interior', $types);
  $hasLimited = in_array('limited', $types);
  $hasInclusive = in_array('inclusive', $types);

  if ($hasExterior && $hasInterior) {
    return 'Interior + Exterior';
  } elseif ($hasExterior) {
    return 'Exterior Only';
  } elseif ($hasInterior) {
    return 'Interior Only';
  } elseif ($hasLimited && $hasInclusive) {
    return 'Limited + Inclusive';
  } elseif ($hasLimited) {
    return 'Limited Package';
  } elseif ($hasInclusive) {
    return 'Inclusive Package';
  }
  return 'Standard Package';
}

// Border colors for cards (cycles through them)
$borderColors = ['border-green', 'border-yellow', 'border-purple', 'border-skyblue'];
$bgColors = ['bg-green', 'bg-yellow', 'bg-purple', 'bg-skyblue'];

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Select Plan</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- League Spartan -->
  <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="./assets/css/select_plan.css">

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

    .ob-plan-card {
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .ob-plan-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
    }

    /* Border colors */
    .border-green {
      border: 1px solid #27C840 !important;
    }

    .border-yellow {
      border: 1px solid #FF8D28 !important;
    }

    .border-purple {
      border: 1px solid conic-gradient(from 35.98deg at 50% 50%, #CB30E0 0deg, #6F1A7A 360deg) !important;
    }

    .border-skyblue {
      border: 1px solid #00C0E8 !important;
    }

    .bg-green {
      background-color: #27C840 !important;
    }

    .bg-yellow {
      background-color: #FF8D28 !important;
    }

    .bg-purple {
      background: linear-gradient(135deg, #CB30E0 0%, #6F1A7A 100%) !important;
    }

    .bg-skyblue {
      background-color: #00C0E8 !important;
    }

    /* Feature type colors */
    .text-exterior {
      color: #28a745 !important;
    }

    .text-interior {
      color: #ffc107 !important;
    }

    .text-limited {
      color: #9b59b6 !important;
    }

    .text-inclusive {
      color: #3498db !important;
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

  <main class="ob-select-plan">
    <div class="container">

      <!-- Title -->
      <div class="text-center mb-4">
        <h1 class="ob-title">Pick Your Shine. Pick Your Vibe.<span class="ob-title-line"></span></h1>
        <p class="ob-subtitle">Select Your Package. Same Premium Team, Different Levels Of Care.</p>
      </div>

      <!-- Tabs -->
      <div class="d-flex justify-content-center ob-plan-tabs-wrap mb-5">
        <div class="plan-tab" role="tablist" aria-label="Plan frequency">
          <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $index => $category): ?>
              <button class="ob-tab-btn <?php echo $index === 0 ? 'active' : ''; ?>"
                data-tab="<?php echo strtolower(str_replace(' ', '-', $category['category_name'])); ?>">
                <?php echo e($category['category_name']); ?>
              </button>
            <?php endforeach; ?>
          <?php else: ?>
            <p>No category available.</p>
          <?php endif; ?>
        </div>
      </div>

      <!-- Plan Cards -->
      <div class="row justify-content-center ob-plans">
        <?php if (!empty($plans)): ?>
          <?php
          $cardIndex = 0;
          foreach ($plans as $plan):
            // Find price for selected car
            $planPrice = 0;
            if ($selectedCarId && !empty($plan['prices'])) {
              foreach ($plan['prices'] as $priceObj) {
                if ($priceObj['car_id'] == $selectedCarId) {
                  $planPrice = $priceObj['price'];
                  break;
                }
              }
            }
            // If no price found, use first available price
            if ($planPrice == 0 && !empty($plan['prices'])) {
              $planPrice = $plan['prices'][0]['price'];
            }

            // Get plan label
            $planLabel = getPlanLabel($plan['features']);
            $colorIndex = $cardIndex % count($borderColors);

            // Get border color (cycles through colors)
            $borderClass = $borderColors[$cardIndex % count($borderColors)];
            $bgClass = $bgColors[$colorIndex];

            $cardIndex++;
          ?>

            <div class="col-md-3 col-sm-6 mb-4 plan-card-wrap"
              data-frequency="<?php echo strtolower(str_replace(' ', '-', $plan['category'])); ?>"
              data-plan-id="<?php echo e($plan['product_id']); ?>" data-plan-name="<?php echo e($plan['product_name']); ?>"
              data-plan-category="<?php echo e($plan['category']); ?>"
              data-category-id="<?php echo e($plan['categoryID']); ?>"
              data-plan-category="<?php echo e($plan['category']); ?>" data-plan-price="<?php echo e($planPrice); ?>"
              data-plan-hours="<?php echo e($plan['max_hours']); ?>"
              data-plan-description="<?php echo e(strip_tags($plan['product_description'] ?? '')); ?>">

              <div class="ob-plan-card <?php echo $borderClass; ?>">
                <span class="ob-plan-name">
                  <?php echo e($plan['product_name']); ?><br />
                  <b class="ob-section-title"> <?php echo e($planLabel); ?></b>
                </span>

                <!-- Group Features by Type -->
                <?php
                $featureGroups = [
                  'exterior' => [],
                  'interior' => [],
                  'limited' => [],
                  'inclusive' => []
                ];
                foreach ($plan['features'] as $feature) {
                  $featureGroups[$feature['type']][] = $feature['feature'];
                }
                ?>

                <?php foreach ($featureGroups as $type => $features): ?>
                  <?php if (!empty($features)): ?>
                    <div class="ob-card-ft">
                      <span class="text-<?php echo $type; ?> text-capitalize"><?php echo $type; ?></span>
                      <ul class="ob-plan-features">
                        <?php foreach ($features as $feature): ?>
                          <li>
                            <img src="assets/images/white-tick.png" style="height: 15px; margin-right: 5px" />
                            <?php echo e($feature); ?>
                          </li>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                  <?php endif; ?>
                <?php endforeach; ?>

                <div class="ob-plan-bottom <?php echo $bgClass; ?>">
                  <div class="ob-plan-price text-dark">
                    R <?php echo number_format($planPrice, 2); ?>
                  </div>
                  <div class="ob-plan-next">
                    <i class="bi bi-arrow-right"></i>
                  </div>
                </div>

              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="col-12 text-center">
            <p>No plans available at the moment.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const tabButtons = document.querySelectorAll(".ob-tab-btn");
      const planCards = document.querySelectorAll(".plan-card-wrap");
      const loadingOverlay = document.getElementById('loadingOverlay');

      // Tab switching functionality
      function showTab(tab) {
        tabButtons.forEach(btn => btn.classList.toggle("active", btn.dataset.tab === tab));
        planCards.forEach(card => {
          card.classList.toggle("d-none", card.dataset.frequency !== tab);
        });
      }

      tabButtons.forEach(btn => {
        btn.addEventListener("click", () => showTab(btn.dataset.tab));
      });

      // Show first tab by default
      if (tabButtons.length > 0) {
        showTab(tabButtons[0].dataset.tab);
      }

      // Plan card click handler
      planCards.forEach(card => {
        card.addEventListener('click', function() {
          // Get plan data from data attributes
          const planId = this.getAttribute('data-plan-id');
          const planName = this.getAttribute('data-plan-name');
          const planCategory = this.getAttribute('data-plan-category');
          const planPrice = this.getAttribute('data-plan-price');
          const planHours = this.getAttribute('data-plan-hours');
          const planDescription = this.getAttribute('data-plan-description');
          const categoryId = this.getAttribute('data-category-id');

          // Show loading overlay
          loadingOverlay.classList.add('show');

          // Get booking data from sessionStorage
          const bookingDataStr = sessionStorage.getItem('bookingData');
          let bookingData = bookingDataStr ? JSON.parse(bookingDataStr) : {};

          // Add plan data to booking
          bookingData.planId = planId;
          bookingData.planName = planName;
          bookingData.planCategory = planCategory;
          bookingData.planPrice = planPrice;
          bookingData.planHours = planHours;
          bookingData.planDescription = planDescription;
          bookingData.categoryId = categoryId;

          // Save to sessionStorage
          sessionStorage.setItem('bookingData', JSON.stringify(bookingData));

          // Make AJAX call to save to PHP session
          fetch('save-plan-to-session.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
              },
              body: JSON.stringify(bookingData)
            })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                console.log('Plan selection saved:', data);
                // Redirect to date selection page
                window.location.href = 'select-date.php';
              } else {
                throw new Error(data.message || 'Failed to save plan selection');
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
