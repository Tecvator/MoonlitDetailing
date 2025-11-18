-- ============================================================================
-- DATABASE SCHEMA FIXES - Add Missing Columns
-- Generated: 2025-11-12
-- ============================================================================

USE moonlit;

-- ============================================================================
-- 1. BOOKINGS TABLE
-- ============================================================================
-- Add washing_status column (tracks booking fulfillment status)
ALTER TABLE bookings
ADD COLUMN washing_status VARCHAR(50) DEFAULT 'pending' AFTER payment_status;

-- ============================================================================
-- 2. SITE_INFO TABLE
-- ============================================================================
-- Add site_terms column (Terms and Conditions for invoices)
ALTER TABLE site_info
ADD COLUMN site_terms TEXT DEFAULT NULL AFTER site_state;

-- Add site_note column (Additional notes for invoices)
ALTER TABLE site_info
ADD COLUMN site_note TEXT DEFAULT NULL AFTER site_terms;

-- ============================================================================
-- 3. ADMINS TABLE
-- ============================================================================
-- Add admin_signature column (stores path to admin signature image)
ALTER TABLE admins
ADD COLUMN admin_signature VARCHAR(255) DEFAULT NULL AFTER admin_unique_id;

-- ============================================================================
-- 4. PRODUCT_FEATURES TABLE
-- ============================================================================
-- Add is_exterior column (indicates if feature is for exterior detailing)
ALTER TABLE product_features
ADD COLUMN is_exterior ENUM('yes', 'no') DEFAULT 'no' AFTER is_interior;

-- Add is_included column (indicates if feature is included in base price)
ALTER TABLE product_features
ADD COLUMN is_included ENUM('yes', 'no') DEFAULT 'yes' AFTER is_exterior;

-- Add is_limited column (indicates if feature has limited availability)
ALTER TABLE product_features
ADD COLUMN is_limited ENUM('yes', 'no') DEFAULT 'no' AFTER is_included;

-- ============================================================================
-- VERIFICATION QUERIES
-- ============================================================================
-- Uncomment to verify after running migration:

-- DESCRIBE bookings;
-- DESCRIBE site_info;
-- DESCRIBE admins;
-- DESCRIBE product_features;

-- SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE, COLUMN_DEFAULT
-- FROM INFORMATION_SCHEMA.COLUMNS
-- WHERE TABLE_SCHEMA = 'moonlit'
-- AND COLUMN_NAME IN ('washing_status', 'site_terms', 'site_note', 'admin_signature', 'is_exterior', 'is_included', 'is_limited');

