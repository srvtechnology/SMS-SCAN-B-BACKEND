-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2023 at 06:16 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `school_id`, `name`, `status`, `created_by`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 4, '8', 'active', 5, '0', '2023-06-06 10:07:08', '2023-06-06 10:07:08'),
(2, 4, '9', 'active', 5, '0', '2023-06-06 10:07:37', '2023-06-06 10:07:37'),
(3, 4, '10', 'active', 5, '0', '2023-06-06 10:07:37', '2023-06-06 10:07:37'),
(4, 4, '6th', 'active', 5, '0', '2023-06-06 10:53:32', '2023-06-06 10:53:32'),
(5, 4, '7th', 'active', 5, '0', '2023-06-06 10:53:32', '2023-06-06 10:53:32');

-- --------------------------------------------------------

--
-- Table structure for table `class_assign_sections`
--

CREATE TABLE `class_assign_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `class_assign_sections`
--

INSERT INTO `class_assign_sections` (`id`, `school_id`, `class_id`, `section_id`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 3, '2023-06-06 10:07:37', '2023-06-06 10:07:37'),
(2, 4, 1, 4, '2023-06-06 10:07:37', '2023-06-06 10:07:37'),
(3, 4, 2, 4, '2023-06-06 10:07:37', '2023-06-06 10:07:37'),
(4, 4, 3, 8, '2023-06-06 10:07:37', '2023-06-06 10:07:37'),
(5, 4, 1, 8, '2023-06-06 10:08:40', '2023-06-06 10:08:40'),
(6, 4, 4, 1, '2023-06-06 10:53:32', '2023-06-06 10:53:32'),
(7, 4, 4, 2, '2023-06-06 10:53:32', '2023-06-06 10:53:32'),
(8, 4, 4, 13, '2023-06-06 10:53:32', '2023-06-06 10:53:32'),
(9, 4, 5, 3, '2023-06-06 10:53:32', '2023-06-06 10:53:32'),
(10, 4, 5, 4, '2023-06-06 10:53:32', '2023-06-06 10:53:32');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(10, '2022_10_19_125905_create_roles_table', 1),
(11, '2022_10_19_142014_add_role_to_users_table', 1),
(12, '2022_10_21_073030_create_permissions_table', 1),
(13, '2022_10_21_104024_create_permission_roles_table', 1),
(14, '2023_06_02_144624_create_schools_table', 1),
(15, '2023_06_06_081732_create_sections_table', 2),
(16, '2023_06_06_112651_create_subjects_table', 3),
(17, '2023_06_06_145311_create_classes_table', 4),
(18, '2023_06_06_145312_create_class_assign_sections_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Manage Roles', '2023-06-05 09:02:28', '2023-06-05 09:02:28'),
(2, 'Manage Users', '2023-06-05 09:02:28', '2023-06-05 09:02:28'),
(3, 'Manage Permissions', '2023-06-05 09:02:28', '2023-06-05 09:02:28');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `role_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2023-06-05 09:02:28', '2023-06-05 09:02:28'),
(2, 1, 2, '2023-06-05 09:02:28', '2023-06-05 09:02:28'),
(3, 1, 3, '2023-06-05 09:02:28', '2023-06-05 09:02:28'),
(4, 2, 1, '2023-06-05 09:02:28', '2023-06-05 09:02:28'),
(5, 2, 2, '2023-06-05 09:02:28', '2023-06-05 09:02:28'),
(6, 2, 3, '2023-06-05 09:02:28', '2023-06-05 09:02:28');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'SuperAdmin', '2023-06-05 09:02:28', '2023-06-05 09:02:28'),
(2, 'SchoolAdmin', '2023-06-05 09:02:28', '2023-06-05 09:02:28');

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `landline_number` varchar(255) NOT NULL,
  `affilliation_number` varchar(255) NOT NULL,
  `board` varchar(255) NOT NULL,
  `type` enum('secondary','higher_secondary') NOT NULL,
  `medium` enum('english','bhutness','both') NOT NULL,
  `address` longtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` enum('active','pending','blocked') NOT NULL DEFAULT 'active',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `created_by`, `username`, `name`, `email`, `password`, `contact_number`, `landline_number`, `affilliation_number`, `board`, `type`, `medium`, `address`, `image`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 'iSDKEA4S', 'Timothy Carney', 'tegi@mailinator.com', '$2y$10$n9xN60hMFJ3F459zPyMgKOW1lldXRBrtCAQAG60l1EKcFwvndkOg6', '708', '520', '470', 'Aspernatur esse exe', 'secondary', 'english', 'Aut ut est repellend', '11685973769.png', 'active', '0', '2023-06-05 09:02:49', '2023-06-05 09:02:49'),
(2, 1, 'GhzNmUvH', 'Sade Best', 'byfuxul@mailinator.com', '$2y$10$1mU1wAT/x9jpDoakTXvflek4LHMS/UquofVBx71AhVl.1bBvJc/4O', '311', '284', '346', 'Voluptatem esse rer', 'secondary', 'english', 'Sapiente aut numquam', '11685974093.png', 'active', '0', '2023-06-05 09:08:13', '2023-06-05 09:08:13'),
(3, 1, '6Nv0xtgi', 'Carly Wright Hello', 'bilal@mailinator.com', '$2y$10$JHkpV5Fcr3qmJwr3U.oprewrq/uzeglAabNwuhx1JS5HSUA4I1s86', '0300000000', '871', '68', 'Ex temporibus lorem', 'higher_secondary', 'both', 'https://meet.google.com/vbj-wrzk-hiohttps://meet.google.com/vbj-wrzk-hiohttps://meet.google.com/vbj-wrzk-hiohttps://meet.google.com/vbj-wrzk-hio', '11685976674.png', 'active', '0', '2023-06-05 09:51:14', '2023-06-05 09:53:07'),
(4, 1, '12345678', 'Best School', 'b@gmail.com', '$2y$10$py88qmgWFkTr3QVIAbMXWe9S2vlI62.b.1751BQe0/MfoAwMICA3S', '0300000000', '871', '274', 'Lahore Board', 'secondary', 'english', 'Test Address', '11686037811.png', 'active', '0', '2023-06-05 10:03:55', '2023-06-06 02:50:11');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `school_id`, `name`, `status`, `created_by`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 4, 'Green', 'active', 5, '0', '2023-06-06 03:25:27', '2023-06-06 06:20:33'),
(2, 4, 'Red', 'active', 5, '0', '2023-06-06 03:25:27', '2023-06-06 03:41:50'),
(3, 4, 'A', 'active', 5, '0', '2023-06-06 08:01:28', '2023-06-06 08:01:28'),
(4, 4, 'B', 'active', 5, '0', '2023-06-06 08:01:28', '2023-06-06 08:01:28'),
(5, 4, 'C', 'active', 5, '0', '2023-06-06 08:01:28', '2023-06-06 08:01:28'),
(8, 4, 'D', 'active', 5, '0', '2023-06-06 08:04:32', '2023-06-06 08:04:32'),
(9, 4, 'E1', 'active', 5, '0', '2023-06-06 10:47:26', '2023-06-06 10:47:43'),
(10, 4, 'F', 'active', 5, '0', '2023-06-06 10:47:27', '2023-06-06 10:47:27'),
(11, 4, 'Super', 'active', 5, '0', '2023-06-06 10:48:54', '2023-06-06 10:48:54'),
(12, 4, 'Blue', 'active', 5, '0', '2023-06-06 10:48:54', '2023-06-06 10:48:54'),
(13, 4, 'Yellow', 'active', 5, '0', '2023-06-06 10:51:15', '2023-06-06 10:51:15'),
(14, 4, 'White Update', 'active', 5, '1', '2023-06-06 10:51:15', '2023-06-06 10:51:51');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `school_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `school_id`, `name`, `status`, `created_by`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 4, 'English', 'active', 5, '1', '2023-06-06 06:35:27', '2023-06-06 06:45:47'),
(2, 4, 'Urdu', 'active', 5, '0', '2023-06-06 06:35:27', '2023-06-06 06:35:27'),
(3, 4, 'Hindi', 'active', 5, '0', '2023-06-06 08:07:08', '2023-06-06 08:07:08'),
(4, 4, 'Math', 'active', 5, '0', '2023-06-06 10:52:16', '2023-06-06 10:52:16'),
(5, 4, 'Chemistry Update', 'active', 5, '1', '2023-06-06 10:52:16', '2023-06-06 10:52:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `type` enum('admin','school') NOT NULL DEFAULT 'admin',
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `orgnization` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('active','pending','blocked') NOT NULL DEFAULT 'active',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `type`, `first_name`, `last_name`, `orgnization`, `phone_number`, `address`, `image`, `status`, `is_deleted`, `remember_token`, `created_at`, `updated_at`, `role_id`) VALUES
(1, 'Admin', NULL, 'admin@gmail.com', NULL, '$2y$10$9q2cQED/Cl/ESbj.n90jB..YKUfk/8nh9nPPyQpc4HO4fcEJ19BtK', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, 'active', '0', 'jwh1a3vY6msNzHguFUsHXx9vjyJpVEFBx1QSeIwG8veEstZ23Mr3mcqA8o7L', '2023-06-05 09:02:28', '2023-06-05 10:11:29', 1),
(2, 'Timothy Carney', 'iSDKEA4S', 'tegi@mailinator.com', NULL, '$2y$10$n9xN60hMFJ3F459zPyMgKOW1lldXRBrtCAQAG60l1EKcFwvndkOg6', 'school', NULL, NULL, NULL, NULL, NULL, NULL, 'active', '0', NULL, '2023-06-05 09:02:49', '2023-06-05 09:02:49', 2),
(3, 'Sade Best', 'GhzNmUvH', 'byfuxul@mailinator.com', NULL, '$2y$10$1mU1wAT/x9jpDoakTXvflek4LHMS/UquofVBx71AhVl.1bBvJc/4O', 'school', NULL, NULL, NULL, NULL, NULL, NULL, 'active', '0', NULL, '2023-06-05 09:08:13', '2023-06-05 09:08:13', 2),
(4, 'Carly Wright Hello', '6Nv0xtgi', 'bilal@mailinator.com', NULL, '$2y$10$JHkpV5Fcr3qmJwr3U.oprewrq/uzeglAabNwuhx1JS5HSUA4I1s86', 'school', NULL, NULL, NULL, NULL, NULL, NULL, 'active', '0', NULL, '2023-06-05 09:51:14', '2023-06-05 09:53:07', 2),
(5, 'Best School', '12345678', 'b@gmail.com', NULL, '$2y$10$9q2cQED/Cl/ESbj.n90jB..YKUfk/8nh9nPPyQpc4HO4fcEJ19BtK', 'school', NULL, NULL, NULL, NULL, NULL, NULL, 'active', '0', NULL, '2023-06-05 10:03:55', '2023-06-06 02:50:11', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classes_school_id_foreign` (`school_id`),
  ADD KEY `classes_created_by_foreign` (`created_by`);

--
-- Indexes for table `class_assign_sections`
--
ALTER TABLE `class_assign_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_assign_sections_school_id_foreign` (`school_id`),
  ADD KEY `class_assign_sections_class_id_foreign` (`class_id`),
  ADD KEY `class_assign_sections_section_id_foreign` (`section_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`),
  ADD KEY `permission_role_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schools_created_by_foreign` (`created_by`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sections_school_id_foreign` (`school_id`),
  ADD KEY `sections_created_by_foreign` (`created_by`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subjects_school_id_foreign` (`school_id`),
  ADD KEY `subjects_created_by_foreign` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `class_assign_sections`
--
ALTER TABLE `class_assign_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `classes_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `class_assign_sections`
--
ALTER TABLE `class_assign_sections`
  ADD CONSTRAINT `class_assign_sections_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_assign_sections_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_assign_sections_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `schools`
--
ALTER TABLE `schools`
  ADD CONSTRAINT `schools_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `sections_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sections_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subjects_school_id_foreign` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
