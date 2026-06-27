-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 27, 2026 at 07:46 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rental-management`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `property_id` bigint(20) UNSIGNED NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `total_days` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `user_id`, `property_id`, `check_in`, `check_out`, `total_days`, `total_amount`, `payment_method`, `created_at`, `updated_at`) VALUES
(20, 6, 9, '2026-06-28', '2026-06-30', 2, 1200.00, 'Cash', '2026-06-26 23:14:02', '2026-06-26 23:14:02'),
(21, 6, 2, '2026-07-01', '2026-07-15', 14, 11666.67, 'UPI', '2026-06-26 23:14:45', '2026-06-26 23:14:45');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_06_26_052125_user', 2),
(5, '2026_06_26_070020_property', 3),
(6, '2026_06_26_122128_booking', 4),
(7, '2026_06_27_035326_payment', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `payment_status` enum('pending','success','failed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `booking_id`, `user_id`, `amount`, `payment_method`, `payment_status`, `created_at`, `updated_at`) VALUES
(6, 20, 6, 1200.00, 'Cash', 'pending', '2026-06-26 23:14:02', '2026-06-26 23:14:02'),
(7, 21, 6, 11666.67, 'UPI', 'success', '2026-06-26 23:14:45', '2026-06-26 23:14:45');

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

CREATE TABLE `property` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `rent_price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('available','rented') NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`id`, `title`, `slug`, `location`, `rent_price`, `image`, `description`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Luxury 2BHK Room', 'luxury-2bhk-room', 'Ahmedabad', 25000.00, NULL, 'Fully furnished 2BHK room with modular kitchen, balcony, parking, lift and 24x7 security.', 'rented', '2026-06-26 03:32:08', '2026-06-26 23:14:45'),
(3, 'Deluxe Single Room', 'deluxe-single-room', 'Ahmedabad', 12000.00, NULL, 'Spacious single room with attached bathroom, fan, wardrobe and free WiFi.', 'available', '2026-06-26 03:33:03', '2026-06-26 05:28:48'),
(4, 'Standard Double Room', 'standard-double-room', 'Surat', 10000.00, NULL, 'Double sharing room with attached bathroom, balcony and parking.', 'available', '2026-06-26 03:33:40', '2026-06-26 23:09:38'),
(5, 'Premium AC Room', 'premium-ac-room', 'Vadodara', 16000.00, NULL, 'Fully furnished AC room with TV, WiFi, cupboard and attached bathroom.', 'available', '2026-06-26 03:34:07', '2026-06-26 05:28:25'),
(6, 'Budget Single Room', 'budget-single-room', 'Rajkot', 9000.00, NULL, 'Affordable single room suitable for students and working professionals.', 'available', '2026-06-26 03:34:33', '2026-06-26 05:28:11'),
(7, 'Family Room', 'family-room', 'Surat', 14000.00, NULL, 'Spacious family room with two beds, attached bathroom and kitchen access.', 'available', '2026-06-26 03:35:08', '2026-06-26 03:35:08'),
(8, 'Studio Room', 'studio-room', 'Bhavnagar', 16000.00, NULL, 'Fully furnished studio room with kitchenette and attached bathroom.', 'available', '2026-06-26 03:35:33', '2026-06-26 05:27:36'),
(9, 'Premium Sharing Room', 'premium-sharing-room', 'Ahmedabad', 18000.00, NULL, 'Comfortable sharing room with WiFi, cupboard, study table and parking.', 'rented', '2026-06-26 03:36:04', '2026-06-26 23:14:02');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('gGn5F8fuCCL4pPLMoeAiq1MovqY6lmFsdaKcS8YV', NULL, '127.0.0.1', 'Symfony', 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoiYWhyemxzQ3RkN1Nxcm9BVzhGdDdFdk9jVjBTaTJKbGJ2b2dVRFRmVCI7czo3OiJ1c2VyX2lkIjtpOjI7czo5OiJ1c2VyX25hbWUiO3M6NToiU2FoaWwiO3M6MTA6InVzZXJfZW1haWwiO3M6MjU6InNhaGlscGF0ZWw1NTUwMEBnbWFpbC5jb20iO3M6MTA6InVzZXJfcGhvbmUiO3M6MTA6Ijc2MjI5MjA1NTkiO3M6OToidXNlcl9yb2xlIjtzOjU6ImFkbWluIjtzOjc6InN1Y2Nlc3MiO3M6MjU6IkFkbWluIExvZ2luIFN1Y2Nlc3NmdWxseSEiO3M6NjoiX2ZsYXNoIjthOjI6e3M6MzoibmV3IjthOjA6e31zOjM6Im9sZCI7YToxOntpOjA7czo3OiJzdWNjZXNzIjt9fX0=', 1782536162),
('qc3bvPLi7GKxqcJhS3ZREap5BUdPhXmtJGUJqExq', NULL, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64; rv:152.0) Gecko/20100101 Firefox/152.0', 'YTo4OntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im5ldyI7YTowOnt9czozOiJvbGQiO2E6MDp7fX1zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czoyOToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3Byb2ZpbGUiO3M6NToicm91dGUiO3M6MTI6InVzZXIucHJvZmlsZSI7fXM6NjoiX3Rva2VuIjtzOjQwOiJleTFtdXRMWDhNQkk2TFFTa1RMWlNOWWc1eDhsQUI5SGVYZHNUWHA5IjtzOjc6InVzZXJfaWQiO2k6NjtzOjk6InVzZXJfbmFtZSI7czo1OiJTYWhpbCI7czoxMDoidXNlcl9lbWFpbCI7czoxNToic2FoaWxAZ21haWwuY29tIjtzOjEwOiJ1c2VyX3Bob25lIjtzOjEwOiI2MzU5OTUwODI5IjtzOjk6InVzZXJfcm9sZSI7czo0OiJ1c2VyIjt9', 1782537858),
('v20OI1bBR9JgdyYlqqt3fTGzie92LoIwjC3siJuX', NULL, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64; rv:152.0) Gecko/20100101 Firefox/152.0', 'YTo4OntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im5ldyI7YTowOnt9czozOiJvbGQiO2E6MDp7fX1zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozMzoiaHR0cDovL2xvY2FsaG9zdDo4MDAwL2FkbWluL3VzZXJzIjtzOjU6InJvdXRlIjtzOjExOiJhZG1pbi51c2VycyI7fXM6NjoiX3Rva2VuIjtzOjQwOiJnZTFWb3VNY1Q1UUlSdkhoWnQ0QTM0ckJXMVpBd2RrT0owQWpQbUZlIjtzOjc6InVzZXJfaWQiO2k6MjtzOjk6InVzZXJfbmFtZSI7czo1OiJTYWhpbCI7czoxMDoidXNlcl9lbWFpbCI7czoyNToic2FoaWxwYXRlbDU1NTAwQGdtYWlsLmNvbSI7czoxMDoidXNlcl9waG9uZSI7czoxMDoiNzYyMjkyMDU1OSI7czo5OiJ1c2VyX3JvbGUiO3M6NToiYWRtaW4iO30=', 1782539115),
('YgoVx1dKoqceCwCeq4DuXyKLvLcUmIIzan3GcWhE', NULL, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64; rv:152.0) Gecko/20100101 Firefox/152.0', 'YTo4OntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im5ldyI7YTowOnt9czozOiJvbGQiO2E6MDp7fX1zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2Rhc2hib2FyZCI7czo1OiJyb3V0ZSI7czoxNDoidXNlci5kYXNoYm9hcmQiO31zOjY6Il90b2tlbiI7czo0MDoiMEpHcG96Q2pWTE9Ud0VaVDFqNWFKb0JsSmlDMkFoVEdmVjZCN3BVOSI7czo3OiJ1c2VyX2lkIjtpOjY7czo5OiJ1c2VyX25hbWUiO3M6NToiU2FoaWwiO3M6MTA6InVzZXJfZW1haWwiO3M6MTU6InNhaGlsQGdtYWlsLmNvbSI7czoxMDoidXNlcl9waG9uZSI7czoxMDoiNjM1OTk1MDgyOSI7czo5OiJ1c2VyX3JvbGUiO3M6NDoidXNlciI7fQ==', 1782539170);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `phone`, `password`, `role`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Sahil', 'sahilpatel55500@gmail.com', '7622920559', '123456', 'admin', 'active', NULL, NULL, NULL),
(6, 'Sahil', 'sahil@gmail.com', '6359950829', '$2y$12$c76wo/US0FS4yyyXOf7QaeMmrRzefhWsBmceGhGic9jAz4BdctyBe', 'user', 'active', NULL, '2026-06-26 01:05:52', '2026-06-27 00:15:10'),
(8, 'Dhruvi', 'dhruvi@gmail.com', '9586325698', '$2y$12$lq7823caZLej1t0ff/R1n.rW3xi33GhHiy/.Qmj7gNZlVhndKKP6C', 'user', 'active', NULL, '2026-06-26 01:08:53', '2026-06-26 01:08:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_user_id_foreign` (`user_id`),
  ADD KEY `booking_property_id_foreign` (`property_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_booking_id_foreign` (`booking_id`),
  ADD KEY `payment_user_id_foreign` (`user_id`);

--
-- Indexes for table `property`
--
ALTER TABLE `property`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `property_slug_unique` (`slug`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `property`
--
ALTER TABLE `property`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_property_id_foreign` FOREIGN KEY (`property_id`) REFERENCES `property` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payment_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
