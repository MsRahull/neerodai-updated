-- ============================================================================
-- Neerodai — database upgrade (25 Nov 2026)
-- Same changes as the two 2026_11_25_* migrations. Use this in phpMyAdmin
-- ONLY if you cannot run `php artisan migrate --force` on the server.
-- Take a database backup (Export) first. Run it once.
-- ============================================================================

-- 1) Donations: store GST / 80G / PAN details (they were silently dropped before)
ALTER TABLE `donations`
  ADD `base_amount`  DECIMAL(10,2) NOT NULL DEFAULT 0 AFTER `amount`,
  ADD `gst_amount`   DECIMAL(10,2) NOT NULL DEFAULT 0 AFTER `base_amount`,
  ADD `eighty_g_amt` DECIMAL(10,2) NOT NULL DEFAULT 0 AFTER `gst_amount`,
  ADD `wants_gst`    TINYINT(1)    NOT NULL DEFAULT 0 AFTER `eighty_g_amt`,
  ADD `gst_number`   VARCHAR(20)   NULL AFTER `wants_gst`,
  ADD `company_name` VARCHAR(100)  NULL AFTER `gst_number`,
  ADD `pan`          VARCHAR(10)   NULL AFTER `pincode`,
  ADD `mode`         VARCHAR(10)   NOT NULL DEFAULT 'live' AFTER `status`,
  ADD UNIQUE KEY `donations_order_id_unique` (`order_id`),
  ADD UNIQUE KEY `donations_payment_id_unique` (`payment_id`),
  ADD KEY `donations_status_created_at_index` (`status`, `created_at`);

UPDATE `donations`
   SET `base_amount` = `amount`, `eighty_g_amt` = ROUND(`amount` * 0.5)
 WHERE `base_amount` = 0;

-- 2) Blogs: language option (both | en | ta), English fields optional for Tamil-only posts
ALTER TABLE `blogs`
  ADD `language` ENUM('both','en','ta') NOT NULL DEFAULT 'both' AFTER `id`;

UPDATE `blogs` SET `language` = 'en';
UPDATE `blogs` SET `language` = 'both'
 WHERE `title_tamil` IS NOT NULL AND `title_tamil` <> ''
   AND `content_tamil` IS NOT NULL AND `content_tamil` <> '';

ALTER TABLE `blogs` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

ALTER TABLE `blogs`
  MODIFY `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  MODIFY `title` VARCHAR(255) NULL,
  MODIFY `content` LONGTEXT NULL,
  ADD KEY `blogs_status_homeflag_created_at_index` (`status`, `homeflag`, `created_at`);

-- 3) Contacts: track admin replies (Email / WhatsApp buttons on the Customers page)
ALTER TABLE `contacts`
  ADD `replied_at`  TIMESTAMP NULL AFTER `message`,
  ADD `replied_via` VARCHAR(20) NULL AFTER `replied_at`,
  ADD `reply_count` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `replied_via`,
  ADD KEY `contacts_created_at_index` (`created_at`);

-- 4) Tell Laravel these migrations are done (so `artisan migrate` never re-runs them)
INSERT INTO `migrations` (`migration`, `batch`) VALUES
  ('2026_11_25_000001_add_gst_80g_columns_to_donations_table', 7),
  ('2026_11_25_000002_create_or_update_blogs_table', 7),
  ('2026_11_25_000003_add_reply_columns_to_contacts_table', 7);
