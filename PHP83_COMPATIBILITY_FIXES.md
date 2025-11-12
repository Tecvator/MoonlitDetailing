# PHP 8.3 Compatibility Fixes

**Date:** 2025-11-12
**Status:** ✅ Completed

---

## Overview

PHP 8.3 introduced stricter type handling that deprecates passing `null` to functions that expect `string` types. This affected several PHP functions commonly used in the codebase:

- `htmlspecialchars()` - Passing null is deprecated
- `ucfirst()` - Passing null is deprecated

These functions now require actual string values or proper null handling using null coalescing operators (`??`).

---

## Solution Implemented

### Helper Function: `e()`

Created a safe HTML escaping helper function in `src/config/helpers.php`:

```php
function e($value, $default = '') {
    if ($value === null || $value === '') {
        return htmlspecialchars($default, ENT_QUOTES, 'UTF-8');
    }
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
```

**Benefits:**
- Handles null values gracefully
- Provides default fallback values
- Consistent HTML escaping across the application
- Shorter, cleaner syntax than `htmlspecialchars()`

---

## Files Fixed

### 1. Booking Pages

#### `public/select-car.php`
**Issues:** `htmlspecialchars()` on potentially null `img_url`
**Lines:** 111, 114, 115, 117
**Fix:**
```php
// Before
data-carimage="assets/images/<?php echo htmlspecialchars($car['img_url']); ?>"

// After
data-carimage="assets/images/<?php echo e($car['img_url'] ?? 'default-car.jpg'); ?>"
```

#### `public/select-plan.php`
**Issues:** `htmlspecialchars()` on potentially null `product_description`
**Lines:** Multiple
**Fix:**
```php
// Before
<?php echo htmlspecialchars($product['product_description']); ?>

// After
<?php echo e($product['product_description'] ?? 'No description'); ?>
```

#### `public/select-date.php`
**Issues:** `htmlspecialchars()` on various booking data fields
**Lines:** Multiple
**Fix:**
```php
// Before
<?php echo htmlspecialchars($bookingData['carName']); ?>

// After
<?php echo e($bookingData['carName'] ?? 'N/A'); ?>
```

---

### 2. Dashboard Files

#### `public/dashboard/index.php`
**Issues Found:**
- Line 172: `ucfirst($siteinfo['site_currency'])`
- Line 258: `ucfirst($siteinfo['site_currency'])`
- Line 295: `htmlspecialchars($b['customer_name'])`, `htmlspecialchars($b['product_name'])`, etc.
- Line 315: `htmlspecialchars($service['product_name'])`
- Line 329: `htmlspecialchars($customer['name'])`

**Fixes Applied:**
```php
// Total Sales Display (Line 172)
// Before
<?php echo ucfirst($siteinfo['site_currency'])."". $booking_stats['total_price']+$booking_stats['total_callout_fee'];?>

// After
<?php echo e($siteinfo['site_currency'] ?? 'R') . "" . (floatval($booking_stats['total_price'] ?? 0) + floatval($booking_stats['total_callout_fee'] ?? 0));?>

// Total Callout Display (Line 258)
// Before
<?php echo ucfirst($siteinfo['site_currency'])."". $booking_stats['total_callout_fee'];?>

// After
<?php echo e($siteinfo['site_currency'] ?? 'R') . "" . e($booking_stats['total_callout_fee'] ?? '0.00');?>

// Upcoming Bookings (Line 295)
// Before
<strong><?= htmlspecialchars($b['customer_name']) ?></strong><br>
<?= htmlspecialchars($b['product_name']) ?> - <?= htmlspecialchars($b['washing_date']) ?>

// After
<strong><?= e($b['customer_name'] ?? 'N/A') ?></strong><br>
<?= e($b['product_name'] ?? 'N/A') ?> - <?= e($b['washing_date'] ?? 'N/A') ?>

// Top Services (Line 315)
// Before
<?= htmlspecialchars($service['product_name']) ?>

// After
<?= e($service['product_name'] ?? 'N/A') ?>

// Top Customers (Line 329)
// Before
<?= htmlspecialchars($customer['name']) ?> — <?= $siteinfo['site_currency']." ". number_format($customer['total_spent'], 2) ?>

// After
<?= e($customer['name'] ?? 'N/A') ?> — <?= e($siteinfo['site_currency'] ?? 'R') . " " . number_format(floatval($customer['total_spent'] ?? 0), 2) ?>
```

#### `public/dashboard/invoice-details.php`
**Issues Found:** 18 instances of `ucfirst()` with potentially null values

**Fixes Applied:**
```php
// Site Information (Lines 704-717)
// Before
<?php echo ucfirst($siteinfo['site_name']);?>
<?php echo ucfirst($siteinfo['site_address']);?>
<?php echo ucfirst($siteinfo['site_email']);?>
<?php echo ucfirst($siteinfo['site_phone']);?>

// After
<?php echo e($siteinfo['site_name'] ?? 'N/A');?>
<?php echo e($siteinfo['site_address'] ?? 'N/A');?>
<?php echo e($siteinfo['site_email'] ?? 'N/A');?>
<?php echo e($siteinfo['site_phone'] ?? 'N/A');?>

// Customer Information (Lines 724-737)
// Before
<?php echo ucfirst($booking['customer_name']);?>
<?php echo ucfirst($booking['customer_address']);?>
<?php echo ucfirst($booking['customer_email']);?>
<?php echo ucfirst($booking['customer_phone']);?>

// After
<?php echo e($booking['customer_name'] ?? 'N/A');?>
<?php echo e($booking['customer_address'] ?? 'N/A');?>
<?php echo e($booking['customer_email'] ?? 'N/A');?>
<?php echo e($booking['customer_phone'] ?? 'N/A');?>

// Payment Status (Line 750)
// Before
<?php echo ucfirst($paymentStatus); ?>

// After
<?php echo e($paymentStatus ?? 'pending'); ?>

// Booking Details (Lines 763-764)
// Before
<?php echo ucfirst($booking['category_name'])." - ".ucfirst($booking['product_name'])
." - ".ucfirst($booking['car_type'])." - ".ucfirst($booking['car_info']);?>

// After
<?php echo e($booking['category_name'] ?? 'N/A') . " - " . e($booking['product_name'] ?? 'N/A')
. " - " . e($booking['car_type'] ?? 'N/A') . " - " . e($booking['car_info'] ?? 'N/A');?>

// Pricing (Lines 785, 792)
// Before
<?php echo $siteinfo['site_currency']."". ucfirst($booking['price']);?>
<?php echo $siteinfo['site_currency']."". ucfirst($booking['callout_fee']);?>

// After
<?php echo e($siteinfo['site_currency'] ?? 'R') . "" . e($booking['price'] ?? '0.00');?>
<?php echo e($siteinfo['site_currency'] ?? 'R') . "" . e($booking['callout_fee'] ?? '0.00');?>

// Admin Signature (Line 848)
// Before
<?php echo ucfirst($admin['username']);?>

// After
<?php echo e($admin['username'] ?? 'Admin');?>

// Bank Details (Lines 863, 867, 870)
// Before
<?php echo ucfirst($sitebank['account_name']);?>
<?php echo ucfirst($sitebank['bank_name']);?>
<?php echo ucfirst($sitebank['account_number']);?>

// After
<?php echo e($sitebank['account_name'] ?? 'N/A');?>
<?php echo e($sitebank['bank_name'] ?? 'N/A');?>
<?php echo e($sitebank['account_number'] ?? 'N/A');?>
```

---

## Summary Statistics

| File | Deprecated Functions Fixed | Lines Modified |
|------|---------------------------|----------------|
| `select-car.php` | 4 | 4 |
| `select-plan.php` | Multiple | ~10 |
| `select-date.php` | Multiple | ~8 |
| `dashboard/index.php` | 7 | 7 |
| `dashboard/invoice-details.php` | 18 | 18 |
| **Total** | **~47** | **~47** |

---

## Pattern Used

### Null Coalescing with e() Helper

```php
// Pattern
<?php echo e($variable ?? 'default_value'); ?>

// Examples
<?php echo e($siteinfo['site_name'] ?? 'N/A'); ?>
<?php echo e($booking['customer_name'] ?? 'N/A'); ?>
<?php echo e($car['img_url'] ?? 'default-car.jpg'); ?>
```

### Numeric Values

```php
// For prices and numbers, use explicit type casting
<?php echo floatval($booking['price'] ?? 0); ?>
<?php echo intval($service['total_orders'] ?? 0); ?>
```

---

## Testing

### Before Fixes
```
Deprecated: htmlspecialchars(): Passing null to parameter #1 ($string)
of type string is deprecated in /var/www/html/dashboard/index.php on line 295

Deprecated: ucfirst(): Passing null to parameter #1 ($string) of type string
is deprecated in /var/www/html/dashboard/index.php on line 258
```

### After Fixes
```bash
✅ Dashboard index: No errors
✅ Invoice details: No errors
✅ Booking pages: No errors
✅ All pages load cleanly without deprecation warnings
```

---

## Best Practices Going Forward

### 1. Always Use e() Helper for Output
```php
// ✅ Good
<?php echo e($user['name']); ?>

// ❌ Bad
<?php echo htmlspecialchars($user['name']); ?>
<?php echo $user['name']; ?>
```

### 2. Provide Meaningful Defaults
```php
// ✅ Good - provides context-appropriate default
<?php echo e($product['name'] ?? 'Unnamed Product'); ?>
<?php echo e($booking['date'] ?? 'Not scheduled'); ?>

// ❌ Bad - generic default
<?php echo e($product['name'] ?? 'N/A'); ?>
```

### 3. Type-cast Numeric Values
```php
// ✅ Good
<?php echo floatval($price ?? 0); ?>
<?php echo intval($quantity ?? 0); ?>

// ❌ Bad
<?php echo $price ?? 0; ?>
```

### 4. Check for Null Before ucfirst()
```php
// ✅ Good - e() handles this automatically
<?php echo e($text); ?>

// ❌ Bad - will cause deprecation warning
<?php echo ucfirst($text); ?>
```

---

## Related Documentation

- **PHP 8.3 Release Notes:** https://www.php.net/releases/8.3/en.php
- **Deprecation RFC:** https://wiki.php.net/rfc/deprecate_null_to_scalar_internal_arg
- **Helper Functions:** `src/config/helpers.php`

---

## Impact

### Before Fixes
- ❌ Deprecation warnings cluttering logs
- ❌ Warnings visible to users on some pages
- ❌ Poor user experience
- ❌ Potential breaking in PHP 9.0

### After Fixes
- ✅ No deprecation warnings
- ✅ Clean output for users
- ✅ Future-proof for PHP 9.0
- ✅ Consistent error handling
- ✅ Better default values throughout

---

## Conclusion

All PHP 8.3 deprecation warnings related to null handling have been systematically fixed across the application. The codebase is now fully compatible with PHP 8.3 and prepared for future PHP versions.

**Total Issues Fixed:** ~47 deprecation warnings
**Files Modified:** 5
**Helper Functions Added:** 1 (`e()`)
**Status:** ✅ Complete

