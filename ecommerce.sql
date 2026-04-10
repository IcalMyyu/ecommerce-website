-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2026 at 10:16 AM
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
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `recipient_name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `full_address` text NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `recipient_name`, `phone_number`, `full_address`, `is_default`, `created_at`, `updated_at`) VALUES
(12, 13, 'faisal', '000000', 'Jln. Kemarin Jaya, Citra Negara', 1, '2026-04-09 17:36:44', '2026-04-09 17:36:44'),
(17, 21, 'bu ayu', '0000000', 'Jln. Kemiri Jaya, Citra Negara', 1, '2026-04-10 02:28:15', '2026-04-10 02:28:15');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-faisal1|127.0.0.1', 'i:2;', 1775781619),
('laravel-cache-faisal1|127.0.0.1:timer', 'i:1775781619;', 1775781619);

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
-- Table structure for table `customer_reports`
--

CREATE TABLE `customer_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('pending','forwarded','resolved') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_reports`
--

INSERT INTO `customer_reports` (`id`, `user_id`, `name`, `email`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 13, 'faisal samy', 'faisalsamy1@gmail.com', NULL, 'halo semuanya', 'resolved', '2026-04-09 17:53:53', '2026-04-10 00:58:19'),
(2, NULL, 'faisal samy', 'faisalsamy1@gmail.com', NULL, 'halo semuanya', 'resolved', '2026-04-10 00:59:08', '2026-04-10 01:01:18');

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
(4, '2026_04_07_043707_create_products_table', 1),
(5, '2026_04_07_043708_create_addresses_table', 1),
(6, '2026_04_07_043709_create_orders_table', 1),
(7, '2026_04_07_043717_create_order_items_table', 1),
(8, '2026_04_08_183239_add_rating_sold_to_products_table', 2),
(9, '2026_04_08_185847_add_shipping_cost_to_orders_table', 3),
(10, '2026_04_08_194705_add_payment_proof_to_orders_table', 4),
(11, '2026_04_09_060424_create_customer_reports_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'belum-bayar',
  `total_amount` decimal(12,2) NOT NULL,
  `shipping_cost` decimal(12,2) NOT NULL DEFAULT 0.00,
  `payment_bank` varchar(255) DEFAULT NULL,
  `payment_proof` varchar(255) DEFAULT NULL,
  `shipping_courier` varchar(255) DEFAULT NULL,
  `tracking_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `address_id`, `status`, `total_amount`, `shipping_cost`, `payment_bank`, `payment_proof`, `shipping_courier`, `tracking_number`, `created_at`, `updated_at`) VALUES
('INV/20260410/236617', 13, 12, 'dikonfirmasi', 930000.00, 150000.00, 'bca', 'proofs/amN5oAptxGAONH8EETF4Ikil7C77DMo9rbfrHV6c.jpg', 'jnt', NULL, '2026-04-10 02:38:35', '2026-04-10 03:10:09'),
('INV/20260410/362896', 13, 12, 'selesai', 2650000.00, 150000.00, 'bca', 'proofs/iQ3mWfRrdulfq9EQLT77cvh3lvAKS4ThhHgWHAh5.jpg', 'jnt', NULL, '2026-04-09 17:36:57', '2026-04-09 17:42:49'),
('INV/20260410/588318', 21, 17, 'selesai', 7300000.00, 150000.00, 'bni', 'proofs/h1675Uu5RWFMMETu4aEuwCx7ucXrqHypVaCd0HQB.jpg', 'jnt', NULL, '2026-04-10 02:28:49', '2026-04-10 02:30:59');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_at_purchase` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price_at_purchase`, `created_at`, `updated_at`) VALUES
(34, 'INV/20260410/362896', 1, 2, 1250000.00, '2026-04-09 17:36:57', '2026-04-09 17:36:57'),
(44, 'INV/20260410/588318', 9, 1, 4500000.00, '2026-04-10 02:28:49', '2026-04-10 02:28:49'),
(45, 'INV/20260410/588318', 6, 1, 2650000.00, '2026-04-10 02:28:49', '2026-04-10 02:28:49'),
(46, 'INV/20260410/236617', 2, 1, 780000.00, '2026-04-10 02:38:35', '2026-04-10 02:38:35');

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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(12,2) NOT NULL,
  `rating` decimal(3,1) NOT NULL DEFAULT 0.0,
  `reviews_count` int(11) NOT NULL DEFAULT 0,
  `sold_count` int(11) NOT NULL DEFAULT 0,
  `stock` int(11) NOT NULL DEFAULT 0,
  `image_url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `rating`, `reviews_count`, `sold_count`, `stock`, `image_url`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Nordic Lounge Chair', 'Kursi lounge gaya Skandinavia yang modern dan minimalis. Cocok untuk bersantai dengan elegan di ruang keluarga.', 1250000.00, 3.8, 29, 349, 22, 'https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?q=80&w=800&h=800&auto=format&fit=crop', 1, '2026-04-08 11:33:45', '2026-04-10 01:28:15'),
(2, 'Kruzo Aero Chair', 'Sofa bertekstur nyaman yang menambah kesan estetik ruangan. Dibuat dengan material premium untuk kenyamanan maksimal.', 780000.00, 4.8, 71, 227, 1, 'https://images.unsplash.com/photo-1503602642458-232111445657?q=80&w=800&h=800&auto=format&fit=crop', 1, '2026-04-08 11:33:45', '2026-04-10 02:38:35'),
(3, 'Ergonomic Desk Chair', 'Kursi kerja ergonomis dengan dukungan lumbar untuk kenyamanan ekstra selama Anda bekerja atau belajar di rumah.', 1430000.00, 3.7, 45, 153, 31, 'https://images.unsplash.com/photo-1505843490538-5133c6c7d0e1?q=80&w=800&h=800&auto=format&fit=crop', 1, '2026-04-08 11:33:45', '2026-04-09 16:21:28'),
(4, 'Classic Leather Armchair', 'Kursi kulit klasik untuk nuansa mewah berkelas. Terbuat dari kulit asli berkualitas tinggi yang awet dan tahan lama.', 3100000.00, 4.6, 70, 50, 10, 'https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?q=80&w=800&h=800&auto=format&fit=crop', 1, '2026-04-08 11:33:45', '2026-04-08 11:33:45'),
(5, 'Minimalist Wooden Stool', 'Bangku mini minimalis tanpa sandaran. Bahan material kayu pinus solid yang kuat dan serbaguna.', 320000.00, 4.9, 39, 26, 80, 'https://images.unsplash.com/photo-1524758631624-e2822e304c36?q=80&w=800&h=800&auto=format&fit=crop', 1, '2026-04-08 11:33:45', '2026-04-08 11:33:45'),
(6, 'Outdoor Patio Couch', 'Sofa santai tahan cuaca yang sempurna untuk bersantai di area outdoor, teras, atau taman rumah Anda.', 2650000.00, 3.5, 76, 319, 16, 'https://images.unsplash.com/photo-1541004995602-b3e898709909?q=80&w=800&h=800&auto=format&fit=crop', 1, '2026-04-08 11:33:45', '2026-04-10 02:28:49'),
(7, 'Velvet Accent Chair', 'Kursi aksen berbahan velvet yang elegan, sangat lembut saat disentuh, memberikan sentuhan glamor.', 1500000.00, 3.5, 25, 183, 12, 'https://images.unsplash.com/photo-1519947486511-46149fa0a254?q=80&w=800&h=800&auto=format&fit=crop', 1, '2026-04-08 11:33:45', '2026-04-08 11:33:45'),
(8, 'Mid-Century Dining Chair', 'Kursi ruang makan berdesain Mid-Century klasik kayu pohon oak kuat.', 680000.00, 4.3, 17, 151, 60, 'https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?q=80&w=800&h=800&auto=format&fit=crop', 1, '2026-04-08 11:33:45', '2026-04-08 11:33:45'),
(9, 'Modern Fabric Sofa', 'Sofa 3 dudukan berbalut kain woven berkualitas, dirancang untuk ruang tamu kontemporer Anda.', 4500000.00, 4.0, 43, 330, 2, 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?q=80&w=800&h=800&auto=format&fit=crop', 1, '2026-04-08 11:33:45', '2026-04-10 02:28:49'),
(10, 'Industrial Bar Stool', 'Kursi konter/bar ala industrial dengan dudukan kayu solid dan rangka metal hitan kokoh.', 550000.00, 4.6, 12, 100, 35, 'https://images.unsplash.com/photo-1533090481720-856c6e3c1fdc?q=80&w=800&h=800&auto=format&fit=crop', 1, '2026-04-08 11:33:45', '2026-04-08 11:33:45'),
(11, 'Wicker Rattan Chair', 'Kursi rotan anyam yang menghadirkan nuansa tropis, cocok untuk sudut baca atau area santai pinggir kolam.', 1100000.00, 3.9, 117, 200, 18, 'https://images.unsplash.com/photo-1592078615290-033ee584e267?q=80&w=800&h=800&auto=format&fit=crop', 1, '2026-04-08 11:33:45', '2026-04-08 11:33:45'),
(12, 'Plush Bean Bag', 'Bean bag empuk nan premium. Sangat sempurna untuk rebahan, bermain game, dan menonton film.', 950000.00, 4.2, 94, 363, 50, 'https://images.unsplash.com/photo-1598300056393-4aac492f4344?q=80&w=800&h=800&auto=format&fit=crop', 1, '2026-04-08 11:33:45', '2026-04-08 11:33:45');

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
('GVXPzooyGglp6IFQXVT83tQtHFR7XI9O6xbuBnRJ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiREMxUmpZblZmSnBWMmtBTHVXZ2lHZXhJRGdOaURHV2d5SDVIeVFBViI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi1wZXR1Z2FzL3JlcG9ydHMvY3VzdG9tZXIiO3M6NToicm91dGUiO3M6MjI6ImFkbWluLnJlcG9ydHMuY3VzdG9tZXIiO31zOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==', 1775794363),
('XQ4cFCO4Y1c7K6PWtgewjoIhhO8toHH48OPrgaKs', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWjBvSnlQc0c5RUE1MVJ5ZzA0amhCV2lhckVpUkU1eU5oSU41RVJNQSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi1wZXR1Z2FzL2Rhc2hib2FyZCI7czo1OiJyb3V0ZSI7czoxNToiYWRtaW4uZGFzaGJvYXJkIjt9czo1MjoibG9naW5fYWRtaW5fNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo2O30=', 1775804536);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(5, 'Administrator Utama', 'admin', 'admin@furni.com', 'admin', NULL, '$2y$12$GbwCYLBstR6TjC1QimejxeKcjYPKrNX1ytV/q2mVmidLaqsKNmDni', NULL, '2026-04-07 17:21:46', '2026-04-10 08:14:10'),
(6, 'Petugas Operasional', 'petugas', 'petugas@furni.com', 'staff', NULL, '$2y$12$OjxA4NWwLac6bwGRTm8O4.FG6XufgwAHIqegELzyyGdDOYOzgB3X6', NULL, '2026-04-07 17:21:46', '2026-04-10 08:14:10'),
(13, 'faisal', 'faisal', 'faisalsamy1@gmail.com', 'user', NULL, '$2y$12$gQUNH/wGCSCG6.mFY6jaIelyk2xY60OJ4KjZZd3tDVugsCSpWAoAC', NULL, '2026-04-09 17:35:25', '2026-04-09 17:35:25'),
(21, 'bu ayu', 'bu ayu', 'buayu1@gmail.com', 'user', NULL, '$2y$12$qDWvktku/a1tSoc4m66DPe2q6ImY7p3sOJc6xlwhhE4MTReGLhYH6', NULL, '2026-04-10 02:26:35', '2026-04-10 02:26:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `customer_reports`
--
ALTER TABLE `customer_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_reports_user_id_foreign` (`user_id`);

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_address_id_foreign` (`address_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `customer_reports`
--
ALTER TABLE `customer_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_reports`
--
ALTER TABLE `customer_reports`
  ADD CONSTRAINT `customer_reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
