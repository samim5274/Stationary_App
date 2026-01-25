-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 25, 2026 at 09:16 AM
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
-- Database: `stationery_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `address`, `email`, `phone`, `website`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'EasyShopX Ltd', 'House 12, Road 5, Uttara, Dhaka', 'info@easyshopx.com', '01711111111', 'https://easyshopx.com', 'companies/logo1.png', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(2, 'Smart Tech Solution', 'Mirpur 10, Dhaka', 'contact@smarttech.com', '01822222222', 'https://smarttech.com', 'companies/logo2.png', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(3, 'NextGen IT', 'Dhanmondi, Dhaka', 'hello@nextgenit.com', '01933333333', 'https://nextgenit.com', 'companies/logo3.png', '2026-01-24 03:48:16', '2026-01-24 03:48:16');

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
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_01_23_052954_create_permission_tables', 1),
(6, '2026_01_24_071110_create_companies_table', 1),
(7, '2026_01_24_092402_create_pdr_categories_table', 1),
(8, '2026_01_24_092408_create_pdr_sub_categories_table', 1),
(9, '2026_01_24_092416_create_products_table', 1),
(10, '2026_01_24_092430_create_pdr_stocks_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `pdr_categories`
--

CREATE TABLE `pdr_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pdr_categories`
--

INSERT INTO `pdr_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Grocery', '2026-01-24 03:48:16', '2026-01-25 02:16:26'),
(2, 'Beverage', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(3, 'Dairy', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(4, 'Bakery', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(5, 'Snacks', '2026-01-24 03:48:16', '2026-01-24 03:48:16');

-- --------------------------------------------------------

--
-- Table structure for table `pdr_stocks`
--

CREATE TABLE `pdr_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `ref` varchar(60) DEFAULT NULL,
  `date` date NOT NULL,
  `type` enum('IN','OUT','ADJUST') NOT NULL DEFAULT 'IN',
  `qty` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `remark` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pdr_stocks`
--

INSERT INTO `pdr_stocks` (`id`, `product_id`, `ref`, `date`, `type`, `qty`, `remark`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 53, 'OPEN-20260125053649-TAZG', '2026-01-25', 'IN', 15, 'Opening stock added at product create', NULL, '2026-01-24 23:36:49', '2026-01-24 23:36:49'),
(2, 54, 'OPEN-20260125053735-I5E4', '2026-01-25', 'IN', 15, 'Opening stock added at product create', '1', '2026-01-24 23:37:35', '2026-01-24 23:37:35'),
(3, 53, 'ADJ-20260125064807-GOJQ', '2026-01-25', 'IN', 3, 'Stock adjusted from edit', '1', '2026-01-25 00:48:07', '2026-01-25 00:48:07');

-- --------------------------------------------------------

--
-- Table structure for table `pdr_sub_categories`
--

CREATE TABLE `pdr_sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pdr_sub_categories`
--

INSERT INTO `pdr_sub_categories` (`id`, `category_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Rice', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(2, 1, 'Oil', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(3, 1, 'Spices', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(4, 2, 'Soft Drink', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(5, 2, 'Juice', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(6, 2, 'Energy Drink', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(7, 3, 'Milk', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(8, 3, 'Butter', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(9, 3, 'Cheese', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(10, 4, 'Bread', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(11, 4, 'Cake', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(12, 4, 'Biscuit', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(13, 5, 'Chips', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(14, 5, 'Chocolate', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(15, 5, 'Noodles', '2026-01-24 03:48:16', '2026-01-24 03:48:16');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `sku` varchar(50) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `subcategory_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `cost_price` decimal(12,2) DEFAULT NULL,
  `stock` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `min_stock` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `unit` varchar(30) DEFAULT NULL,
  `size` varchar(60) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `availability` tinyint(1) NOT NULL DEFAULT 1,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `manufactured_at` date DEFAULT NULL,
  `expired_at` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `sku`, `category_id`, `subcategory_id`, `price`, `discount`, `cost_price`, `stock`, `min_stock`, `unit`, `size`, `image`, `availability`, `status`, `manufactured_at`, `expired_at`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Product 1', 'product-1-9h2n', 'SKU-TODPC6FS', 2, 4, 359.00, 7.00, 189.00, 53, 11, 'pcs', '585g', NULL, 1, 1, '2025-12-15', '2026-08-12', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(2, 'Product 2', 'product-2-ytjw', 'SKU-YWYUXK1M', 1, 3, 185.00, 39.00, 172.00, 142, 6, 'pcs', '764g', NULL, 1, 1, '2025-11-04', '2026-12-27', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(3, 'Product 3', 'product-3-zfiw', 'SKU-BWVGZYLT', 1, 1, 415.00, 21.00, 143.00, 43, 14, 'pcs', '891g', NULL, 1, 1, '2025-10-31', '2026-04-14', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(4, 'Product 4', 'product-4-971l', 'SKU-0DKA3MRR', 4, 10, 90.00, 23.00, 259.00, 64, 20, 'pcs', '371g', NULL, 1, 1, '2025-10-25', '2026-05-07', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(5, 'Product 5', 'product-5-i7wy', 'SKU-3HB26LXF', 4, 12, 136.00, 16.00, 181.00, 155, 10, 'pcs', '951g', NULL, 1, 1, '2025-11-19', '2026-03-30', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(6, 'Product 6', 'product-6-vnpn', 'SKU-TUUR8WOF', 5, 15, 326.00, 3.00, 279.00, 134, 18, 'pcs', '865g', NULL, 1, 1, '2025-12-26', '2026-05-27', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(7, 'Product 7', 'product-7-f8bq', 'SKU-4BZUKQH6', 5, 15, 371.00, 24.00, 122.00, 7, 14, 'pcs', '295g', NULL, 1, 1, '2025-10-20', '2026-05-12', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(8, 'Product 8', 'product-8-njk4', 'SKU-HWTAFARP', 4, 10, 364.00, 28.00, 240.00, 72, 7, 'pcs', '559g', NULL, 1, 1, '2026-01-12', '2026-10-06', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(9, 'Product 9', 'product-9-yyta', 'SKU-JPPMP8MZ', 1, 2, 149.00, 9.00, 362.00, 102, 20, 'pcs', '491g', NULL, 1, 1, '2025-12-11', '2026-09-05', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(10, 'Product 10', 'product-10-r0he', 'SKU-FHQXPBCO', 5, 15, 160.00, 9.00, 49.00, 86, 15, 'pcs', '711g', NULL, 1, 1, '2025-12-02', '2026-03-25', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(11, 'Product 11', 'product-11-4bqf', 'SKU-L4B0CPHJ', 1, 3, 270.00, 37.00, 39.00, 159, 13, 'pcs', '275g', NULL, 1, 1, '2025-11-06', '2026-11-04', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(12, 'Product 12', 'product-12-suho', 'SKU-FF4G2CBZ', 3, 8, 164.00, 14.00, 399.00, 143, 13, 'pcs', '281g', NULL, 1, 1, '2025-11-28', '2026-03-31', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(13, 'Product 13', 'product-13-p5pl', 'SKU-RH1SDIKC', 3, 8, 207.00, 20.00, 219.00, 184, 6, 'pcs', '488g', NULL, 1, 1, '2025-11-13', '2026-08-22', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(14, 'Product 14', 'product-14-c0xt', 'SKU-TQMS82WS', 2, 4, 362.00, 33.00, 58.00, 200, 13, 'pcs', '361g', NULL, 1, 1, '2025-11-19', '2026-03-28', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(15, 'Product 15', 'product-15-qxar', 'SKU-EVDXBFWP', 1, 1, 401.00, 10.00, 333.00, 81, 19, 'pcs', '884g', NULL, 1, 1, '2026-01-09', '2026-05-01', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(16, 'Product 16', 'product-16-2urz', 'SKU-SRSY282P', 4, 10, 169.00, 31.00, 252.00, 121, 13, 'pcs', '706g', NULL, 1, 1, '2025-10-22', '2026-05-22', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(17, 'Product 17', 'product-17-pnzw', 'SKU-HPQZTYBH', 1, 3, 208.00, 0.00, 174.00, 183, 12, 'pcs', '313g', NULL, 1, 1, '2025-11-28', '2026-10-07', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(18, 'Product 18', 'product-18-9zxu', 'SKU-XEX9TUXN', 5, 13, 342.00, 24.00, 154.00, 171, 7, 'pcs', '599g', NULL, 1, 1, '2025-10-26', '2026-12-05', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(19, 'Product 19', 'product-19-jok5', 'SKU-Y45QCI8R', 2, 4, 224.00, 30.00, 61.00, 42, 18, 'pcs', '281g', NULL, 1, 1, '2025-11-28', '2027-01-12', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(20, 'Product 20', 'product-20-vx4c', 'SKU-WGBEQEZ3', 1, 3, 357.00, 14.00, 385.00, 101, 10, 'pcs', '995g', NULL, 1, 1, '2025-10-26', '2026-03-28', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(21, 'Product 21', 'product-21-bhdc', 'SKU-YBVOR0EI', 5, 14, 167.00, 44.00, 179.00, 182, 18, 'pcs', '699g', NULL, 1, 1, '2025-12-03', '2026-05-20', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(22, 'Product 22', 'product-22-scgi', 'SKU-P05ARNRL', 1, 2, 118.00, 21.00, 217.00, 146, 17, 'pcs', '803g', NULL, 1, 1, '2025-10-17', '2027-01-14', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(23, 'Product 23', 'product-23-4bmd', 'SKU-VPYU2SSH', 2, 6, 246.00, 5.00, 187.00, 91, 6, 'pcs', '329g', NULL, 1, 1, '2025-10-28', '2026-07-12', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(24, 'Product 24', 'product-24-a335', 'SKU-MFNA6VV2', 5, 15, 143.00, 47.00, 45.00, 33, 15, 'pcs', '604g', NULL, 1, 1, '2025-11-08', '2026-10-14', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(25, 'Product 25', 'product-25-gehv', 'SKU-4ORE0OR1', 1, 2, 242.00, 45.00, 398.00, 47, 17, 'pcs', '262g', NULL, 1, 1, '2025-11-17', '2026-07-15', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(26, 'Product 26', 'product-26-xnyv', 'SKU-64MUSTWA', 5, 15, 118.00, 19.00, 212.00, 97, 11, 'pcs', '529g', NULL, 1, 1, '2025-11-16', '2027-01-07', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(27, 'Product 27', 'product-27-mh5h', 'SKU-IG9XC6PM', 2, 5, 285.00, 26.00, 52.00, 184, 13, 'pcs', '565g', NULL, 1, 1, '2025-10-25', '2026-09-21', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(28, 'Product 28', 'product-28-jj9j', 'SKU-F0GMBNSR', 3, 9, 123.00, 32.00, 164.00, 85, 7, 'pcs', '968g', NULL, 1, 1, '2025-12-07', '2026-05-12', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(29, 'Product 29', 'product-29-vigw', 'SKU-BABCQ9D8', 4, 10, 203.00, 18.00, 213.00, 102, 10, 'pcs', '812g', NULL, 1, 1, '2025-11-01', '2027-01-23', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(30, 'Product 30', 'product-30-jyob', 'SKU-TO1Y26FA', 5, 15, 498.00, 5.00, 212.00, 51, 16, 'pcs', '504g', NULL, 1, 1, '2025-10-28', '2026-04-04', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(31, 'Product 31', 'product-31-mmjf', 'SKU-DH9TAOTJ', 2, 5, 153.00, 9.00, 317.00, 145, 20, 'pcs', '498g', NULL, 1, 1, '2025-10-31', '2026-04-05', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(32, 'Product 32', 'product-32-x9qf', 'SKU-IHGKDNQR', 4, 11, 282.00, 48.00, 300.00, 94, 18, 'pcs', '385g', NULL, 1, 1, '2025-11-29', '2026-07-02', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(33, 'Product 33', 'product-33-3gca', 'SKU-DKQCGDEA', 2, 5, 411.00, 33.00, 305.00, 126, 7, 'pcs', '859g', NULL, 1, 1, '2025-12-14', '2026-04-15', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(34, 'Product 34', 'product-34-epok', 'SKU-IT6AIAYL', 3, 8, 195.00, 33.00, 282.00, 80, 10, 'pcs', '567g', NULL, 1, 1, '2025-12-19', '2026-06-23', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(35, 'Product 35', 'product-35-7v5t', 'SKU-EGJKGT3K', 1, 2, 94.00, 26.00, 109.00, 141, 6, 'pcs', '870g', NULL, 1, 1, '2025-11-09', '2026-06-28', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(36, 'Product 36', 'product-36-i9yy', 'SKU-0P16SUC9', 2, 4, 86.00, 17.00, 210.00, 138, 17, 'pcs', '971g', NULL, 1, 1, '2026-01-09', '2026-07-13', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(37, 'Product 37', 'product-37-6yuq', 'SKU-D5XXCCJW', 5, 14, 388.00, 23.00, 148.00, 79, 14, 'pcs', '870g', NULL, 1, 1, '2025-11-04', '2026-08-26', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(38, 'Product 38', 'product-38-6dvy', 'SKU-DCYUI0SV', 3, 9, 216.00, 3.00, 338.00, 42, 16, 'pcs', '906g', NULL, 1, 1, '2025-10-18', '2026-10-12', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(39, 'Product 39', 'product-39-lxs1', 'SKU-YJKCYG32', 5, 13, 71.00, 3.00, 246.00, 28, 16, 'pcs', '534g', NULL, 1, 1, '2026-01-04', '2026-05-27', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(40, 'Product 40', 'product-40-h6ub', 'SKU-IZQILDIF', 1, 2, 464.00, 12.00, 306.00, 22, 7, 'pcs', '784g', NULL, 1, 1, '2025-11-28', '2026-06-25', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(41, 'Product 41', 'product-41-xc3b', 'SKU-TXYPUJSO', 5, 15, 150.00, 2.00, 331.00, 1, 7, 'pcs', '260g', NULL, 1, 1, '2025-12-05', '2026-10-27', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(42, 'Product 42', 'product-42-zxzq', 'SKU-ETZJGFMO', 2, 5, 119.00, 26.00, 144.00, 101, 19, 'pcs', '878g', NULL, 1, 1, '2025-12-11', '2026-07-03', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(43, 'Product 43', 'product-43-a6sw', 'SKU-3QQCQHM2', 2, 4, 430.00, 6.00, 143.00, 191, 10, 'pcs', '656g', NULL, 1, 1, '2025-11-02', '2026-08-22', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(44, 'Product 44', 'product-44-lwwt', 'SKU-PEPWFBOF', 4, 12, 415.00, 32.00, 189.00, 132, 15, 'pcs', '820g', NULL, 1, 1, '2025-12-09', '2026-11-01', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(45, 'Product 45', 'product-45-uqi7', 'SKU-2FS8VYHJ', 3, 7, 454.00, 45.00, 349.00, 26, 8, 'pcs', '558g', NULL, 1, 1, '2025-11-04', '2026-07-25', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(46, 'Product 46', 'product-46-gbiu', 'SKU-A9QBSCHP', 4, 11, 184.00, 12.00, 200.00, 29, 5, 'pcs', '647g', NULL, 1, 1, '2025-12-04', '2026-10-12', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(47, 'Product 47', 'product-47-cad4', 'SKU-MWQW59IW', 1, 1, 403.00, 12.00, 169.00, 87, 7, 'pcs', '335g', NULL, 1, 1, '2025-11-19', '2026-07-12', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(48, 'Product 48', 'product-48-lojb', 'SKU-I6R5BGZK', 4, 12, 361.00, 39.00, 294.00, 104, 5, 'pcs', '362g', NULL, 1, 1, '2025-11-20', '2027-01-20', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(49, 'Product 49', 'product-49-fznk', 'SKU-WVDSTUPH', 4, 10, 279.00, 25.00, 237.00, 36, 6, 'pcs', '645g', NULL, 1, 1, '2025-11-07', '2027-01-14', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(50, 'Product 50', 'product-50-mf2w', 'SKU-0IEVFOMV', 4, 12, 110.00, 49.00, 330.00, 118, 14, 'pcs', '985g', NULL, 1, 1, '2025-12-29', '2026-06-14', 'Seeder generated product', '2026-01-24 03:48:16', '2026-01-24 03:48:16'),
(53, 'A4 Paper 80gsm', 'a4-paper-80gsm-pzrc', 'A4PAPER8-5969', 1, 2, 450.00, 50.00, NULL, 3, 5, 'pcs', NULL, 'pdr_1769319409_GfPxr8x1.jpg', 1, 1, NULL, NULL, 'Printers in the 1500s scrambled the words from Cicero\'s \"De Finibus Bonorum et Malorum\'\' after mixing the words in each sentence. The familiar \"lorem ipsum dolor sit amet\" text emerged when 16th-century printers adapted Cicero\'s original work, beginning with the phrase \"dolor sit amet consectetur.\"', '2026-01-24 23:36:49', '2026-01-25 00:48:07'),
(54, 'A4 Paper 80gsm', 'a4-paper-80gsm-tzik', 'A4PAPER8-3300', 2, 6, 450.00, 50.00, NULL, 0, 5, 'pcs', NULL, 'pdr_1769319455_1O2w8c8w.jpg', 1, 1, NULL, NULL, 'Printers in the 1500s scrambled the words from Cicero\'s \"De Finibus Bonorum et Malorum\'\' after mixing the words in each sentence. The familiar \"lorem ipsum dolor sit amet\" text emerged when 16th-century printers adapted Cicero\'s original work, beginning with the phrase \"dolor sit amet consectetur.\"', '2026-01-24 23:37:35', '2026-01-24 23:37:35'),
(55, 'A4 Paper 80gsm', 'a4-paper-80gsm-dohq', 'a4pager', 2, 6, 450.00, 50.00, NULL, 15, 5, 'pcs', NULL, 'pdr_1769323392_gBXTEoWR.jpg', 1, 1, NULL, NULL, 'Printers in the 1500s scrambled the words from Cicero\'s \"De Finibus Bonorum et Malorum\'\' after mixing the words in each sentence. The familiar \"lorem ipsum dolor sit amet\" text emerged when 16th-century printers adapted Cicero\'s original work, beginning with the phrase \"dolor sit amet consectetur.\"', '2026-01-24 23:39:08', '2026-01-25 00:43:12');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `blood_group` enum('A+','A-','B+','B-','AB+','AB-','O+','O-') DEFAULT NULL,
  `religion` varchar(50) DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `national_id` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `present_address` text DEFAULT NULL,
  `parmanent_address` text DEFAULT NULL,
  `father_name` varchar(255) DEFAULT NULL,
  `father_contact` varchar(20) DEFAULT NULL,
  `mother_name` varchar(255) DEFAULT NULL,
  `mother_contact` varchar(20) DEFAULT NULL,
  `guardian_name` varchar(255) DEFAULT NULL,
  `guardian_contact` varchar(20) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'admin',
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `joining_date` date DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `otp` varchar(10) DEFAULT NULL,
  `otp_expires_at` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `last_login_ip` varchar(45) DEFAULT NULL,
  `is_profile_completed` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `dob`, `gender`, `blood_group`, `religion`, `nationality`, `national_id`, `phone`, `email`, `password`, `present_address`, `parmanent_address`, `father_name`, `father_contact`, `mother_name`, `mother_contact`, `guardian_name`, `guardian_contact`, `role`, `status`, `joining_date`, `remark`, `photo`, `otp`, `otp_expires_at`, `email_verified_at`, `last_login_at`, `last_login_ip`, `is_profile_completed`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Rahim', 'Uddin', '2000-05-12', 'Male', 'A+', 'Islam', 'Bangladeshi', '1998123456789', '01711111111', 'rahim@example.com', '$2y$12$U5rp1J1WT/Xbx589WinCxOSaU8VXAOnsWN5rD/DMAE.uoPGNZeFG6', 'Dhaka', 'Dhaka', 'Abdul Karim', '01722222222', 'Ayesha Begum', '01733333333', 'Abdul Karim', '01722222222', 'admin', 'active', '2024-01-24', 'Regular student', NULL, NULL, NULL, '2026-01-24 03:48:14', '2026-01-24 22:36:34', '127.0.0.1', 1, 'xCqQpar8P8wj6luVZoLvOUgpQg7NPgMFYB57rTf4XzLQj9FzOH3pneOfOg4d', NULL, '2026-01-24 22:36:34'),
(2, 'User', 'No2', '2001-01-01', 'Female', 'O+', 'Islam', 'Bangladeshi', '199900000002', '01500000002', 'user2@example.com', '$2y$12$h.lzxmrfKZFSXrvgXXdc1OE6daB0BKkfQAYFnuYGbw8eC9anh70Za', 'Dhaka', 'Dhaka', 'Father 2', '01811111112', 'Mother 2', '01822222222', 'Guardian 2', '01833333332', 'admin', 'active', '2025-11-24', 'Seeder data', NULL, NULL, NULL, '2026-01-24 03:48:15', '2026-01-24 03:48:15', '127.0.0.1', 1, NULL, NULL, NULL),
(3, 'User', 'No3', '2001-01-01', 'Male', 'O+', 'Islam', 'Bangladeshi', '199900000003', '01500000003', 'user3@example.com', '$2y$12$mi5HMMtz4WSZ/hqrmpK.p.9VzLIqLRSQHHyrKrTVIICsykS/iFqTS', 'Dhaka', 'Dhaka', 'Father 3', '01811111113', 'Mother 3', '01822222223', 'Guardian 3', '01833333333', 'admin', 'active', '2025-10-24', 'Seeder data', NULL, NULL, NULL, '2026-01-24 03:48:15', '2026-01-24 03:48:15', '127.0.0.1', 1, NULL, NULL, NULL),
(4, 'User', 'No4', '2001-01-01', 'Female', 'O+', 'Islam', 'Bangladeshi', '199900000004', '01500000004', 'user4@example.com', '$2y$12$ueq2fyOdtRI0Bm2kiaUM0uCjwRNcWfRYbGg0pd.zyORl.u9XqJszm', 'Dhaka', 'Dhaka', 'Father 4', '01811111114', 'Mother 4', '01822222224', 'Guardian 4', '01833333334', 'admin', 'active', '2025-09-24', 'Seeder data', NULL, NULL, NULL, '2026-01-24 03:48:15', '2026-01-24 03:48:15', '127.0.0.1', 1, NULL, NULL, NULL),
(5, 'User', 'No5', '2001-01-01', 'Male', 'O+', 'Islam', 'Bangladeshi', '199900000005', '01500000005', 'user5@example.com', '$2y$12$CgZNmPhvccqjj3qaqvrokObGeADqruyv7YhRRCYPeaNxcQdTCln5K', 'Dhaka', 'Dhaka', 'Father 5', '01811111115', 'Mother 5', '01822222225', 'Guardian 5', '01833333335', 'admin', 'active', '2025-08-24', 'Seeder data', NULL, NULL, NULL, '2026-01-24 03:48:15', '2026-01-24 03:48:15', '127.0.0.1', 1, NULL, NULL, NULL),
(6, 'User', 'No6', '2001-01-01', 'Female', 'O+', 'Islam', 'Bangladeshi', '199900000006', '01500000006', 'user6@example.com', '$2y$12$l7YO3utnH42RUzmxpJtouuu8JcV08RHi5jLGEL6GD4zqvsAxoxt72', 'Dhaka', 'Dhaka', 'Father 6', '01811111116', 'Mother 6', '01822222226', 'Guardian 6', '01833333336', 'admin', 'active', '2025-07-24', 'Seeder data', NULL, NULL, NULL, '2026-01-24 03:48:15', '2026-01-24 03:48:15', '127.0.0.1', 1, NULL, NULL, NULL),
(7, 'User', 'No7', '2001-01-01', 'Male', 'O+', 'Islam', 'Bangladeshi', '199900000007', '01500000007', 'user7@example.com', '$2y$12$ZCQDxsBnDll0XFgV7njWjOONttcWMdwMW3VUsynNddeOxc1OVnC.6', 'Dhaka', 'Dhaka', 'Father 7', '01811111117', 'Mother 7', '01822222227', 'Guardian 7', '01833333337', 'admin', 'active', '2025-06-24', 'Seeder data', NULL, NULL, NULL, '2026-01-24 03:48:16', '2026-01-24 03:48:16', '127.0.0.1', 1, NULL, NULL, NULL),
(8, 'User', 'No8', '2001-01-01', 'Female', 'O+', 'Islam', 'Bangladeshi', '199900000008', '01500000008', 'user8@example.com', '$2y$12$wQEXZoGpt3LZd/TkRvkkged202hKCtzrcim3LQOdF5.lpOC2Ppc7.', 'Dhaka', 'Dhaka', 'Father 8', '01811111118', 'Mother 8', '01822222228', 'Guardian 8', '01833333338', 'admin', 'active', '2025-05-24', 'Seeder data', NULL, NULL, NULL, '2026-01-24 03:48:16', '2026-01-24 03:48:16', '127.0.0.1', 1, NULL, NULL, NULL),
(9, 'User', 'No9', '2001-01-01', 'Male', 'O+', 'Islam', 'Bangladeshi', '199900000009', '01500000009', 'user9@example.com', '$2y$12$0DqvAdyiyEsbiXTcpQkbf.G9X4HE7IDUdzDKxLOfPjBlllBRxZ9DK', 'Dhaka', 'Dhaka', 'Father 9', '01811111119', 'Mother 9', '01822222229', 'Guardian 9', '01833333339', 'admin', 'active', '2025-04-24', 'Seeder data', NULL, NULL, NULL, '2026-01-24 03:48:16', '2026-01-24 03:48:16', '127.0.0.1', 1, NULL, NULL, NULL),
(10, 'User', 'No10', '2001-01-01', 'Female', 'O+', 'Islam', 'Bangladeshi', '1999000000010', '015000000010', 'user10@example.com', '$2y$12$vitYeCCUTqpjfBMtjh/PlO2BZ3DIl3dz3VwCmrTtxq0OuKOrDR1qC', 'Dhaka', 'Dhaka', 'Father 10', '018111111110', 'Mother 10', '018222222210', 'Guardian 10', '018333333310', 'admin', 'active', '2025-03-24', 'Seeder data', NULL, NULL, NULL, '2026-01-24 03:48:16', '2026-01-24 03:48:16', '127.0.0.1', 1, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `companies_email_unique` (`email`);

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
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pdr_categories`
--
ALTER TABLE `pdr_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pdr_categories_name_unique` (`name`);

--
-- Indexes for table `pdr_stocks`
--
ALTER TABLE `pdr_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pdr_stocks_product_id_foreign` (`product_id`);

--
-- Indexes for table `pdr_sub_categories`
--
ALTER TABLE `pdr_sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pdr_sub_categories_name_unique` (`name`),
  ADD KEY `pdr_sub_categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_subcategory_id_foreign` (`subcategory_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pdr_categories`
--
ALTER TABLE `pdr_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pdr_stocks`
--
ALTER TABLE `pdr_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pdr_sub_categories`
--
ALTER TABLE `pdr_sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pdr_stocks`
--
ALTER TABLE `pdr_stocks`
  ADD CONSTRAINT `pdr_stocks_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `pdr_sub_categories`
--
ALTER TABLE `pdr_sub_categories`
  ADD CONSTRAINT `pdr_sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `pdr_categories` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `pdr_categories` (`id`),
  ADD CONSTRAINT `products_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `pdr_sub_categories` (`id`);

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
