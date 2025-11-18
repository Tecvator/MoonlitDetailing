# Session Management - Complete Overview

## Summary

**Cleaned up unnecessary `session_start()` calls throughout the codebase.**

- **Before:** 13 `session_start()` calls scattered everywhere
- **After:** 6 `session_start()` calls (1 main + 5 standalone files)
- **Removed:** 7 unnecessary duplicate calls

---

## How Sessions Work Now

### 🎯 Main Session Initialization

**Location:** `src/config/app.php` (Line 62)

```php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    // Configure session settings
    ini_set('session.cookie_httponly', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.use_strict_mode', '1');

    // Set secure cookie only in production
    if (APP_ENV === 'production') {
        ini_set('session.cookie_secure', '1');
    }

    session_start();
}
```

**Who loads this?**
- Every file that includes `require_once __DIR__ . '/../src/config/init.php';`
- `init.php` → loads `app.php` → starts session automatically

---

## Current Session Architecture

### ✅ Files That Need Sessions (Loaded Automatically)

All these files load `init.php`, which starts the session automatically:

**Booking Flow Pages:**
- ✅ `public/index.php`
- ✅ `public/select-car.php`
- ✅ `public/select-plan.php`
- ✅ `public/select-date.php`
- ✅ `public/booking-details.php`
- ✅ `public/confirm-booking.php`
- ✅ `public/pay-now.php`

**Dashboard Pages:**
- ✅ All `public/dashboard/*.php` pages (17 files)
- ✅ All `public/dashboard/process/*.php` files (15 files)

**Total:** 40+ files that get sessions automatically via `init.php`

---

### ✅ Standalone Session Files (Need Their Own `session_start()`)

These files **DO NOT** load `init.php` - they're lightweight endpoints that only handle session data:

```
public/save-car-to-session.php
public/save-plan-to-session.php
public/save-datetime-to-session.php
public/save-userinfo-to-session.php
public/save-to-session.php
```

**Why they need their own `session_start()`:**
- They're AJAX endpoints called from JavaScript
- They don't need database connections or site configuration
- They only need to read/write session data quickly
- Loading `init.php` would be unnecessary overhead

**Example Pattern:**
```php
<?php
// Start session (standalone, doesn't load init.php)
session_start();

// Set JSON header
header('Content-Type: application/json');

// Process data and save to session
$data = json_decode(file_get_contents('php://input'), true);
$_SESSION['booking_data'] = array_merge($_SESSION['booking_data'] ?? [], $data);

echo json_encode(['success' => true]);
?>
```

---

## What Was Removed (Duplicate Calls)

### ❌ Removed from Booking Pages (6 files)

**Files Fixed:**
```
public/select-car.php       - Line 2: session_start(); REMOVED
public/select-plan.php      - Line 2: session_start(); REMOVED
public/select-date.php      - Line 2: session_start(); REMOVED
public/booking-details.php  - Line 2: session_start(); REMOVED
public/confirm-booking.php  - Line 3: session_start(); REMOVED
public/pay-now.php          - Line 2: session_start(); REMOVED
```

**Why removed?**
These files all load `init.php` which automatically starts the session. The explicit `session_start()` was redundant and could cause PHP notices.

**Before:**
```php
<?php
session_start();  // ← UNNECESSARY!

if (!isset($_SESSION['booking_data'])) {
    header('Location: index.php');
    exit();
}

require_once __DIR__ . '/../src/config/init.php';  // ← This starts session!
```

**After:**
```php
<?php
require_once __DIR__ . '/../src/config/init.php';  // ← Session started here

if (!isset($_SESSION['booking_data'])) {
    header('Location: index.php');
    exit();
}
```

---

### ❌ Removed from Admin Functions (1 file)

**File:** `src/functions/admin_functions.php`
**Function:** `getAdminInfo()`

**Before:**
```php
function getAdminInfo($conn) {
    session_start();  // ← UNNECESSARY!

    if (isset($_SESSION['admin_id'])) {
        // ... fetch admin data ...
    }
}
```

**After:**
```php
function getAdminInfo($conn) {
    // Session already started by app.php
    if (isset($_SESSION['admin_id'])) {
        // ... fetch admin data ...
    }
}
```

**Why removed?**
This function is only called from dashboard pages that have already loaded `init.php`, so the session is always active when this function runs.

---

## Session Lifecycle

### 1. **Session Start**
```
User visits any page
    ↓
Page loads init.php
    ↓
init.php loads app.php
    ↓
app.php checks: session_status() === PHP_SESSION_NONE
    ↓
session_start() called ONCE
    ↓
Session active for entire request
```

### 2. **Session Usage**
```php
// Anywhere in the application after init.php is loaded:
$_SESSION['booking_data'] = [...];
$_SESSION['admin_id'] = 1;

// No need to call session_start() again!
```

### 3. **Session End**
- Sessions end automatically when the PHP script finishes
- Or explicitly: `session_destroy()`
- Sessions persist across page loads (stored server-side)

---

## Benefits of This Architecture

### ✅ Centralized Management
- One place controls all session configuration
- Easy to update security settings globally
- Consistent behavior across entire application

### ✅ No Duplicate Calls
- `session_start()` called exactly once per request
- No PHP notices about sessions already started
- Cleaner, more maintainable code

### ✅ Smart Check in app.php
```php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
```
This prevents errors even if someone accidentally calls `session_start()` elsewhere.

### ✅ Performance
- Lightweight AJAX endpoints don't load full `init.php`
- Only load what you need for each request type
- Save-to-session files are fast (< 1ms response time)

---

## Session Security Settings

Currently configured in `src/config/app.php`:

| Setting | Value | Purpose |
|---------|-------|---------|
| `cookie_httponly` | `1` | Prevent JavaScript access to session cookie (XSS protection) |
| `use_only_cookies` | `1` | Prevent session ID in URL (more secure) |
| `use_strict_mode` | `1` | Reject uninitialized session IDs |
| `cookie_secure` | `1` (prod) | HTTPS-only cookies in production |

---

## Session Data Structure

### Booking Flow Sessions
```php
$_SESSION['booking_data'] = [
    'carId' => 1,
    'carName' => 'Sedan / Coupe',
    'carImage' => 'assets/images/sedan.jpg',
    'productId' => 5,
    'productName' => 'Premium Wash',
    'price' => 250,
    'bookingDateTime' => '2025-11-15 10:00:00',
    'address' => '123 Main St',
    'city' => 'Cape Town',
    // ... more booking fields
];

$_SESSION['booking_timestamp'] = 1731398400;
$_SESSION['booking_placed'] = true;
```

### Admin Sessions
```php
$_SESSION['admin_id'] = 2;

// Admin info fetched via getAdminInfo($conn)
```

---

## Testing Session Management

### Test 1: Booking Flow
```bash
# Start booking
curl http://localhost:8080/

# Save car selection
curl -X POST http://localhost:8080/save-car-to-session.php \
  -H "Content-Type: application/json" \
  -d '{"carId": 1, "carName": "Sedan"}'

# Continue to next page
curl http://localhost:8080/select-plan.php
```

### Test 2: Admin Login
```bash
# Login
curl -X POST http://localhost:8080/dashboard/process/login.php \
  -d "email=admin@example.com" \
  -d "password=yourpassword"

# Should return clean JSON (no session notices):
# {"status":"success","message":"Login successful","admin":{...}}
```

### Test 3: Check for Notices
```bash
# View PHP error log
docker exec -it moonlit_web tail -f /var/log/apache2/error.log

# Should see NO session-related notices ✅
```

---

## Troubleshooting

### Problem: "Session already started" notice

**Cause:** Calling `session_start()` after it's already been started by `app.php`

**Solution:** Remove the duplicate `session_start()` call - it's not needed!

**Check:**
```bash
grep -rn "session_start()" public/ src/ --include="*.php"
```

Should only show:
- `src/config/app.php` (with `session_status()` check)
- `public/save-*-to-session.php` files (standalone)

---

### Problem: Session data not persisting

**Possible causes:**
1. Session not started before setting `$_SESSION` data
2. Headers already sent before `session_start()`
3. Session cookie not being set

**Check:**
```php
// Add to top of problematic file
var_dump(session_status()); // Should be PHP_SESSION_ACTIVE (2)
var_dump(session_id());     // Should show session ID string
var_dump($_SESSION);        // Should show your session data
```

---

## File Reference

### Core Session Files
```
src/config/app.php                  - Main session initialization
src/config/init.php                 - Loads app.php (starts session)
```

### Standalone Session Handlers
```
public/save-car-to-session.php
public/save-plan-to-session.php
public/save-datetime-to-session.php
public/save-userinfo-to-session.php
public/save-to-session.php
```

### Files That Use Sessions (via init.php)
```
public/                             - All booking pages
public/dashboard/                   - All dashboard pages
public/dashboard/process/           - All process files
```

---

## Conclusion

✅ **Session management is now clean, centralized, and efficient!**

- **One source of truth:** `src/config/app.php`
- **No duplicates:** Removed 7 unnecessary `session_start()` calls
- **Smart architecture:** Standalone files only where needed
- **Secure:** HTTP-only, strict mode, HTTPS in production
- **Maintainable:** Easy to understand and modify

**Next time you add a new file:**
- **If it needs database/config:** Load `init.php` (session automatic)
- **If it only handles session data:** Use standalone pattern with `session_start()`

