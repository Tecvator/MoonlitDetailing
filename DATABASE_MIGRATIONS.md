# Database Migrations

This document tracks all database schema changes made to the Moonlit Detailing application.

---

## Migration #1: Add Missing Booking Columns
**Date:** 2025-11-12
**Status:** ✅ Applied

### Problem
The application code expected `callout_fee` and `car_info` columns in the `bookings` table, but they were missing from the database schema. This caused a fatal error:

```
Fatal error: Uncaught mysqli_sql_exception: Unknown column 'callout_fee' in 'field list'
in /var/www/src/functions/booking_functions.php:354
```

### Impact
- ❌ Dashboard homepage crashed
- ❌ Booking statistics couldn't be calculated
- ❌ New bookings couldn't be created with callout fees
- ❌ Car information couldn't be stored with bookings

### Solution
Added two missing columns to the `bookings` table:

#### SQL Migration
```sql
ALTER TABLE bookings
ADD COLUMN callout_fee DECIMAL(10,2) DEFAULT 0.00 AFTER price,
ADD COLUMN car_info TEXT AFTER washing_time;
```

### Column Details

#### `callout_fee`
- **Type:** `DECIMAL(10,2)`
- **Default:** `0.00`
- **Nullable:** YES
- **Purpose:** Store the mileage/distance-based fee for mobile detailing service
- **Position:** After `price` column

**Usage in Code:**
- Calculated based on distance from business location to customer address
- Added to base price to get total booking cost
- Displayed separately on invoices and booking details
- Used in dashboard statistics (total revenue calculations)

#### `car_info`
- **Type:** `TEXT`
- **Default:** NULL
- **Nullable:** YES
- **Purpose:** Store additional car information as JSON or serialized data
- **Position:** After `washing_time` column

**Usage in Code:**
- Stores car name, type, and other vehicle details
- Passed from frontend during booking creation
- Displayed on invoices and booking details

### Updated Table Structure

**Before:**
```
bookings
├── id
├── booking_id
├── car_type_id
├── product_id
├── price
├── location_type
├── customer_id
├── washing_date
├── washing_time
├── payment_receipt
├── payment_method
├── payment_status
├── created_at
└── updated_at
```

**After:**
```
bookings
├── id
├── booking_id
├── car_type_id
├── product_id
├── price
├── callout_fee         ← NEW
├── location_type
├── customer_id
├── washing_date
├── washing_time
├── car_info            ← NEW
├── payment_receipt
├── payment_method
├── payment_status
├── created_at
└── updated_at
```

### Files Updated

1. **Database** (live)
   - Altered `bookings` table using MySQL CLI

2. **`docker/mysql/init/moonlit.sql`**
   - Updated `CREATE TABLE` statement to include new columns
   - Updated sample `INSERT` statements to include new columns with default values

### How to Apply (If Needed)

If you're setting up a new database or need to manually apply this migration:

```bash
# Connect to MySQL container
docker exec -it moonlit_db mysql -uroot -p[PASSWORD] moonlit

# Run migration
ALTER TABLE bookings
ADD COLUMN callout_fee DECIMAL(10,2) DEFAULT 0.00 AFTER price,
ADD COLUMN car_info TEXT AFTER washing_time;

# Verify
DESCRIBE bookings;
```

### Rollback (If Needed)

⚠️ **Warning:** This will remove the columns and all data in them!

```sql
ALTER TABLE bookings
DROP COLUMN callout_fee,
DROP COLUMN car_info;
```

### Testing

After applying the migration:

```bash
# Test 1: Dashboard loads without errors
curl http://localhost:8080/dashboard/
# Expected: HTTP 302 redirect to login (no fatal errors)

# Test 2: Get booking stats (uses callout_fee in SUM)
# (requires authentication)

# Test 3: Create new booking with callout fee
# (test via booking flow with distance calculation)
```

### Code References

Files that use `callout_fee`:
- `src/functions/booking_functions.php` - createBooking(), getBookingStats()
- `public/dashboard/api.php` - get_bookings, calculate_price, create_booking
- `public/dashboard/process/booking_process.php` - booking creation
- `public/dashboard/process/get_price.php` - price calculation with distance
- `public/dashboard/index.php` - dashboard statistics
- `public/dashboard/invoice.php` - invoice generation
- `public/dashboard/invoice-details.php` - invoice display
- `public/booking-details.php` - customer booking summary

Files that use `car_info`:
- `src/functions/booking_functions.php` - createBooking()
- `public/dashboard/api.php` - get_bookings, create_booking

### Data Migration

**Existing bookings:** All existing bookings now have `callout_fee = 0.00` and `car_info = NULL`, which is correct since they were created before this feature was implemented.

**New bookings:** Will properly store callout fees and car information.

---

## Migration #2: Comprehensive Schema Audit - Add 7 Missing Columns
**Date:** 2025-11-12
**Status:** ✅ Applied

### Problem
Proactive schema audit revealed multiple missing columns that code expected but didn't exist in database:
- Code referenced columns that weren't in database schema
- Features couldn't function properly (invoices, signatures, booking status tracking)
- Potential for more fatal errors as features were used

### Root Cause
- Original database dump was incomplete/outdated
- Features were developed but schema wasn't fully updated
- No systematic validation between code and database schema

### Solution
Performed comprehensive codebase scan to identify all database column references, compared against actual schema, and added all missing columns.

#### SQL Migration
```sql
-- 1. BOOKINGS TABLE
ALTER TABLE bookings
ADD COLUMN washing_status VARCHAR(50) DEFAULT 'pending' AFTER payment_status;

-- 2. SITE_INFO TABLE
ALTER TABLE site_info
ADD COLUMN site_terms TEXT DEFAULT NULL AFTER site_state,
ADD COLUMN site_note TEXT DEFAULT NULL AFTER site_terms;

-- 3. ADMINS TABLE
ALTER TABLE admins
ADD COLUMN admin_signature VARCHAR(255) DEFAULT NULL AFTER admin_unique_id;

-- 4. PRODUCT_FEATURES TABLE
ALTER TABLE product_features
ADD COLUMN is_exterior ENUM('yes', 'no') DEFAULT 'no' AFTER is_interior,
ADD COLUMN is_included ENUM('yes', 'no') DEFAULT 'yes' AFTER is_exterior,
ADD COLUMN is_limited ENUM('yes', 'no') DEFAULT 'no' AFTER is_included;
```

### Columns Added

| Table | Column | Type | Purpose |
|-------|--------|------|---------|
| bookings | washing_status | VARCHAR(50) | Track booking fulfillment status |
| site_info | site_terms | TEXT | Terms & conditions for invoices |
| site_info | site_note | TEXT | Additional notes for invoices |
| admins | admin_signature | VARCHAR(255) | Admin signature image path |
| product_features | is_exterior | ENUM | Flag for exterior detailing features |
| product_features | is_included | ENUM | Flag for included vs add-on features |
| product_features | is_limited | ENUM | Flag for limited/premium features |

### Audit Methodology

1. **Scanned Codebase:**
   - Created PHP scanner to extract all database column references
   - Analyzed SQL queries, array access patterns, INSERT/UPDATE statements
   - Found 102 unique column references across 50+ files

2. **Schema Comparison:**
   - Retrieved current database schema from INFORMATION_SCHEMA
   - Mapped code references to appropriate tables
   - Filtered false positives (JOINed aliases, calculated fields, session vars)

3. **Identified Missing:**
   - 7 truly missing columns across 4 tables
   - Documented usage and purpose of each column

### Files Updated

1. **Database** (live)
   - Altered 4 tables: bookings, site_info, admins, product_features

2. **`docker/mysql/init/moonlit.sql`**
   - Updated all 4 CREATE TABLE statements
   - Updated INSERT statements for admins, bookings, site_info

3. **`add_missing_columns.sql`**
   - Created standalone migration script

4. **Documentation**
   - `SCHEMA_AUDIT_RESULTS.md` - Comprehensive audit report

### Data Migration

**site_info table:** Added default values for new columns
```sql
UPDATE site_info SET
  site_terms = 'All services are subject to availability and scheduling...',
  site_note = 'Please ensure the vehicle is accessible...'
WHERE id = 1;
```

### Impact

**Functionality Restored:**
- ✅ Invoice generation now shows terms and conditions
- ✅ Booking status lifecycle tracking enabled
- ✅ Admin signature uploads functional
- ✅ Product feature categorization complete

**Files Now Functional:**
- `public/dashboard/company-settings.php` - Can edit terms/notes
- `public/dashboard/invoice-details.php` - Shows complete invoice data
- `public/dashboard/process/update_status.php` - Can update booking status
- `public/dashboard/profile.php` - Can upload admin signature
- `public/dashboard/product-feature-list.php` - Shows all feature flags

### Testing

```bash
# Test 1: Schema verification
docker exec -i moonlit_db mysql -uroot -p[PASSWORD] moonlit <<'EOF'
SELECT TABLE_NAME, COLUMN_NAME
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_SCHEMA = 'moonlit'
AND COLUMN_NAME IN ('washing_status', 'site_terms', 'site_note',
                     'admin_signature', 'is_exterior', 'is_included', 'is_limited');
EOF
# ✅ Expected: All 7 columns present

# Test 2: Company settings page loads
curl http://localhost:8080/dashboard/company-settings.php
# ✅ Expected: HTTP 200, shows terms and notes fields

# Test 3: Invoice displays properly
# ✅ Expected: Invoice shows terms and conditions section

# Test 4: No database errors in logs
docker logs moonlit_web --tail 50 | grep -i "error\|fatal"
# ✅ Expected: No missing column errors
```

### Rollback (If Needed)

⚠️ **Warning:** This will remove columns and all data in them!

```sql
ALTER TABLE bookings DROP COLUMN washing_status;
ALTER TABLE site_info DROP COLUMN site_terms, DROP COLUMN site_note;
ALTER TABLE admins DROP COLUMN admin_signature;
ALTER TABLE product_features
  DROP COLUMN is_exterior,
  DROP COLUMN is_included,
  DROP COLUMN is_limited;
```

### Lessons Learned

1. **Proactive Auditing:** Regular schema audits prevent runtime errors
2. **Automation:** Automated scanning is more reliable than manual review
3. **Documentation:** Comprehensive docs help prevent future issues
4. **Testing:** Always test affected features after schema changes

---

## Future Migrations

Add new migrations below with incrementing numbers...

### Template

```markdown
## Migration #N: [Title]
**Date:** YYYY-MM-DD
**Status:** ✅ Applied / ❌ Pending / 🔄 In Progress

### Problem
[Describe the issue]

### Solution
[SQL commands]

### Files Updated
[List of files]

### Testing
[How to verify]
```

---

## Migration Best Practices

1. **Always backup** the database before applying migrations
2. **Test migrations** on development environment first
3. **Update SQL dump file** (`moonlit.sql`) to include schema changes
4. **Document rollback procedures** for each migration
5. **Never delete migrations** from this file (even if rolled back)
6. **Use transactions** for complex migrations when possible
7. **Verify data integrity** after applying migrations

---

## Database Backup Commands

### Create Backup
```bash
# Full database backup
docker exec moonlit_db mysqldump -uroot -p[PASSWORD] moonlit > backup_$(date +%Y%m%d_%H%M%S).sql

# Bookings table only
docker exec moonlit_db mysqldump -uroot -p[PASSWORD] moonlit bookings > bookings_backup_$(date +%Y%m%d_%H%M%S).sql
```

### Restore Backup
```bash
# Restore full database
docker exec -i moonlit_db mysql -uroot -p[PASSWORD] moonlit < backup_YYYYMMDD_HHMMSS.sql

# Restore single table
docker exec -i moonlit_db mysql -uroot -p[PASSWORD] moonlit < bookings_backup_YYYYMMDD_HHMMSS.sql
```

---

## Current Database Version

**Schema Version:** 1.2
**Last Migration:** #2 (2025-11-12)
**Next Migration Number:** 3
**Total Columns Added:** 9 (2 from migration #1, 7 from migration #2)

