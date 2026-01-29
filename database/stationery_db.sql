-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 29, 2026 at 06:13 AM
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
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reg` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` decimal(12,2) NOT NULL DEFAULT 1.00,
  `price` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 'EasyShopX Ltd', 'House 12, Road 5, Uttara, Dhaka', 'info@easyshopx.com', '01711111111', 'https://easyshopx.com', 'companies/logo1.png', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(2, 'Smart Tech Solution', 'Mirpur 10, Dhaka', 'contact@smarttech.com', '01822222222', 'https://smarttech.com', 'companies/logo2.png', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(3, 'NextGen IT', 'Dhanmondi, Dhaka', 'hello@nextgenit.com', '01933333333', 'https://nextgenit.com', 'companies/logo3.png', '2026-01-28 22:18:30', '2026-01-28 22:18:30');

-- --------------------------------------------------------

--
-- Table structure for table `excategories`
--

CREATE TABLE `excategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `excategories`
--

INSERT INTO `excategories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Writing Instruments', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(2, 'Paper Products', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(3, 'Office Supplies', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(4, 'School Supplies', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(5, 'Art & Craft', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(6, 'Files & Folders', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(7, 'Electronics', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(8, 'Printing & Accessories', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(9, 'Others', '2026-01-28 22:18:30', '2026-01-28 22:18:30');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `subcategory_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `remark` text NOT NULL DEFAULT 'N/A',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `category_id`, `subcategory_id`, `user_id`, `title`, `date`, `amount`, `remark`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 1, 'Sports Competition Notice', '2026-01-29', 1500.00, 'Surgon X3df#f', '2026-01-28 22:18:49', '2026-01-28 22:18:49'),
(2, 3, 16, 1, 'Bazar', '2026-01-29', 1800.00, 'Surgon X3df#f', '2026-01-28 22:21:55', '2026-01-28 22:21:55');

-- --------------------------------------------------------

--
-- Table structure for table `exsubcategories`
--

CREATE TABLE `exsubcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exsubcategories`
--

INSERT INTO `exsubcategories` (`id`, `category_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Ball Pen', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(2, 1, 'Gel Pen', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(3, 1, 'Pencil', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(4, 1, 'Marker', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(5, 1, 'Highlighter', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(6, 1, 'Eraser', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(7, 1, 'Sharpener', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(8, 2, 'A4 Paper', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(9, 2, 'A3 Paper', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(10, 2, 'Notebook', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(11, 2, 'Diary', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(12, 2, 'Drawing Paper', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(13, 2, 'Carbon Paper', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(14, 3, 'Stapler', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(15, 3, 'Staple Pin', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(16, 3, 'Paper Clip', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(17, 3, 'Calculator', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(18, 3, 'Glue', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(19, 3, 'Tape', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(20, 3, 'Punch Machine', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(21, 4, 'School Bag', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(22, 4, 'Geometry Box', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(23, 4, 'Color Pencil', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(24, 4, 'Crayons', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(25, 4, 'Scale', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(26, 4, 'Exam Pad', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(27, 5, 'Paint Brush', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(28, 5, 'Poster Color', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(29, 5, 'Water Color', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(30, 5, 'Canvas', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(31, 5, 'Craft Paper', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(32, 6, 'File Folder', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(33, 6, 'Ring File', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(34, 6, 'Document File', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(35, 6, 'Envelope', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(36, 7, 'Calculator', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(37, 7, 'Pen Drive', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(38, 7, 'Mouse', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(39, 7, 'Keyboard', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(40, 8, 'Printer Ink', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(41, 8, 'Toner', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(42, 8, 'Lamination Sheet', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(43, 8, 'Binding Comb', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(44, 9, 'Gift Item', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(45, 9, 'Miscellaneous', '2026-01-28 22:18:30', '2026-01-28 22:18:30');

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
(10, '2026_01_24_092430_create_pdr_stocks_table', 1),
(11, '2026_01_25_100856_create_payment_methods_table', 1),
(12, '2026_01_25_102637_create_carts_table', 1),
(13, '2026_01_25_102644_create_orders_table', 1),
(14, '2026_01_25_102655_create_payment_details_table', 1),
(15, '2026_01_27_084852_create_excategories_table', 1),
(16, '2026_01_27_084911_create_exsubcategories_table', 1),
(17, '2026_01_27_084933_create_expenses_table', 1);

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
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `reg` bigint(20) UNSIGNED NOT NULL,
  `total` decimal(12,2) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `customerName` varchar(255) NOT NULL DEFAULT 'Guest User',
  `customerPhone` varchar(255) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
-- Table structure for table `payment_details`
--

CREATE TABLE `payment_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `reg` bigint(20) UNSIGNED NOT NULL,
  `total` decimal(12,2) DEFAULT NULL,
  `discount` decimal(12,2) DEFAULT NULL,
  `vat` decimal(12,2) DEFAULT NULL,
  `payable` decimal(12,2) DEFAULT NULL,
  `pay` decimal(12,2) DEFAULT NULL,
  `due` decimal(12,2) DEFAULT NULL,
  `payment_method_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Cash', 'Cash Payment', 1, '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(2, 'Credit Card', 'Pay via credit/debit card', 1, '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(3, 'Bkash', 'Mobile banking payment', 1, '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(4, 'Nagad', 'Mobile banking payment', 1, '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(5, 'Rocket', 'Mobile banking payment', 1, '2026-01-28 22:18:30', '2026-01-28 22:18:30');

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
(1, 'Grocery', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(2, 'Beverage', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(3, 'Dairy', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(4, 'Bakery', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(5, 'Snacks', '2026-01-28 22:18:30', '2026-01-28 22:18:30');

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
(1, 1, 'Rice', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(2, 1, 'Oil', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(3, 1, 'Spices', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(4, 2, 'Soft Drink', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(5, 2, 'Juice', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(6, 2, 'Energy Drink', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(7, 3, 'Milk', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(8, 3, 'Butter', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(9, 3, 'Cheese', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(10, 4, 'Bread', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(11, 4, 'Cake', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(12, 4, 'Biscuit', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(13, 5, 'Chips', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(14, 5, 'Chocolate', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(15, 5, 'Noodles', '2026-01-28 22:18:30', '2026-01-28 22:18:30');

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
(1, 'Product 1', 'product-1-tnpu', 'SKU-EZZLX6L0', 2, 5, 109.00, 36.00, 388.00, 160, 14, 'pcs', '963g', NULL, 1, 1, '2025-11-18', '2026-06-11', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(2, 'Product 2', 'product-2-pdkq', 'SKU-PXS0KBJN', 1, 2, 198.00, 18.00, 295.00, 152, 13, 'pcs', '639g', NULL, 1, 1, '2025-12-15', '2026-05-03', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(3, 'Product 3', 'product-3-xic7', 'SKU-D61U2D8Y', 4, 11, 443.00, 11.00, 232.00, 145, 11, 'pcs', '424g', NULL, 1, 1, '2025-10-26', '2026-11-26', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(4, 'Product 4', 'product-4-3n43', 'SKU-IB41AGNY', 4, 10, 253.00, 18.00, 116.00, 119, 10, 'pcs', '331g', NULL, 1, 1, '2026-01-04', '2026-04-26', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(5, 'Product 5', 'product-5-waui', 'SKU-1P3XWW7Z', 1, 2, 190.00, 8.00, 369.00, 152, 9, 'pcs', '653g', NULL, 1, 1, '2025-12-27', '2026-12-05', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(6, 'Product 6', 'product-6-pcwo', 'SKU-OTBDUOYR', 4, 11, 143.00, 4.00, 362.00, 10, 11, 'pcs', '261g', NULL, 1, 1, '2025-11-04', '2026-07-09', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(7, 'Product 7', 'product-7-umyq', 'SKU-QI0CEAFF', 5, 15, 189.00, 45.00, 219.00, 95, 8, 'pcs', '553g', NULL, 1, 1, '2025-12-22', '2026-10-23', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(8, 'Product 8', 'product-8-dtop', 'SKU-4EGEQMP2', 5, 13, 298.00, 4.00, 59.00, 127, 9, 'pcs', '766g', NULL, 1, 1, '2025-11-15', '2026-08-06', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(9, 'Product 9', 'product-9-wtlu', 'SKU-3WFIOYWT', 4, 12, 490.00, 25.00, 57.00, 63, 12, 'pcs', '761g', NULL, 1, 1, '2025-10-26', '2026-11-20', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(10, 'Product 10', 'product-10-aluw', 'SKU-EOOIAZZM', 2, 5, 357.00, 29.00, 161.00, 98, 7, 'pcs', '439g', NULL, 1, 1, '2025-10-26', '2026-09-06', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(11, 'Product 11', 'product-11-gpdo', 'SKU-DTOG6CO3', 4, 10, 330.00, 16.00, 294.00, 147, 10, 'pcs', '454g', NULL, 1, 1, '2025-10-30', '2027-01-09', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(12, 'Product 12', 'product-12-nhfp', 'SKU-IJ79WIQ0', 2, 5, 493.00, 14.00, 186.00, 193, 17, 'pcs', '820g', NULL, 1, 1, '2025-11-17', '2026-12-16', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(13, 'Product 13', 'product-13-xuzk', 'SKU-WUZQFMUJ', 5, 14, 101.00, 3.00, 343.00, 36, 19, 'pcs', '322g', NULL, 1, 1, '2025-11-17', '2026-08-20', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(14, 'Product 14', 'product-14-mvku', 'SKU-DDB2XGCY', 5, 15, 248.00, 14.00, 275.00, 171, 5, 'pcs', '750g', NULL, 1, 1, '2026-01-05', '2026-11-02', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(15, 'Product 15', 'product-15-8mgc', 'SKU-UPTRT3BP', 1, 3, 153.00, 0.00, 294.00, 179, 15, 'pcs', '593g', NULL, 1, 1, '2025-12-03', '2026-06-04', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(16, 'Product 16', 'product-16-ko4v', 'SKU-KSVBMZ90', 3, 8, 208.00, 49.00, 276.00, 46, 15, 'pcs', '785g', NULL, 1, 1, '2025-11-04', '2026-05-15', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(17, 'Product 17', 'product-17-ajsb', 'SKU-XD5URNFA', 4, 10, 76.00, 11.00, 302.00, 198, 11, 'pcs', '403g', NULL, 1, 1, '2026-01-11', '2026-08-25', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(18, 'Product 18', 'product-18-ofze', 'SKU-PB9V5SJW', 4, 10, 73.00, 1.00, 92.00, 143, 17, 'pcs', '402g', NULL, 1, 1, '2025-11-19', '2026-03-05', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(19, 'Product 19', 'product-19-4rs4', 'SKU-7AK47POP', 3, 7, 371.00, 30.00, 133.00, 115, 12, 'pcs', '995g', NULL, 1, 1, '2025-12-14', '2026-07-13', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(20, 'Product 20', 'product-20-djsd', 'SKU-XRXJUYN9', 1, 3, 460.00, 5.00, 337.00, 75, 13, 'pcs', '428g', NULL, 1, 1, '2025-11-24', '2026-10-24', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(21, 'Product 21', 'product-21-vugf', 'SKU-AQ1FHCFG', 4, 10, 123.00, 24.00, 110.00, 80, 18, 'pcs', '357g', NULL, 1, 1, '2025-11-19', '2026-12-23', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(22, 'Product 22', 'product-22-j8cc', 'SKU-FPQ5I7BA', 3, 9, 433.00, 25.00, 236.00, 53, 15, 'pcs', '402g', NULL, 1, 1, '2025-12-06', '2026-09-30', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(23, 'Product 23', 'product-23-sxjz', 'SKU-PYHZM6IS', 2, 5, 168.00, 47.00, 76.00, 52, 17, 'pcs', '516g', NULL, 1, 1, '2026-01-15', '2026-11-08', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(24, 'Product 24', 'product-24-ekar', 'SKU-06GTAJBY', 4, 10, 106.00, 7.00, 311.00, 93, 6, 'pcs', '630g', NULL, 1, 1, '2026-01-07', '2027-01-05', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(25, 'Product 25', 'product-25-my59', 'SKU-OIBFDRZO', 4, 11, 81.00, 22.00, 400.00, 34, 17, 'pcs', '309g', NULL, 1, 1, '2025-11-19', '2026-05-08', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(26, 'Product 26', 'product-26-ekng', 'SKU-GNVEKWBD', 2, 6, 310.00, 5.00, 251.00, 48, 15, 'pcs', '391g', NULL, 1, 1, '2025-12-31', '2026-10-22', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(27, 'Product 27', 'product-27-b4kk', 'SKU-MSR42X5M', 2, 4, 206.00, 33.00, 228.00, 30, 17, 'pcs', '745g', NULL, 1, 1, '2025-12-03', '2026-03-29', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(28, 'Product 28', 'product-28-yynn', 'SKU-6D7V3K4N', 3, 7, 363.00, 36.00, 270.00, 146, 6, 'pcs', '385g', NULL, 1, 1, '2025-11-09', '2026-04-24', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(29, 'Product 29', 'product-29-2g58', 'SKU-8BBC7KXQ', 5, 13, 403.00, 27.00, 372.00, 165, 9, 'pcs', '406g', NULL, 1, 1, '2025-12-15', '2026-07-27', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(30, 'Product 30', 'product-30-nvf7', 'SKU-H1TKTWO1', 2, 5, 378.00, 5.00, 317.00, 187, 5, 'pcs', '513g', NULL, 1, 1, '2026-01-12', '2026-10-30', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(31, 'Product 31', 'product-31-1nnn', 'SKU-XAEVUBUQ', 5, 13, 250.00, 45.00, 327.00, 74, 20, 'pcs', '529g', NULL, 1, 1, '2026-01-14', '2027-01-26', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(32, 'Product 32', 'product-32-hf0g', 'SKU-V1CFPJHR', 3, 9, 460.00, 25.00, 162.00, 102, 12, 'pcs', '490g', NULL, 1, 1, '2025-11-30', '2026-07-12', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(33, 'Product 33', 'product-33-6ato', 'SKU-EYBAJQMR', 1, 3, 154.00, 4.00, 348.00, 33, 19, 'pcs', '908g', NULL, 1, 1, '2025-11-25', '2026-05-21', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(34, 'Product 34', 'product-34-cxuo', 'SKU-1EZT4AAT', 3, 7, 426.00, 27.00, 319.00, 150, 5, 'pcs', '680g', NULL, 1, 1, '2025-12-14', '2027-01-22', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(35, 'Product 35', 'product-35-5ge6', 'SKU-5ZFQHG1Q', 3, 8, 212.00, 8.00, 201.00, 10, 15, 'pcs', '835g', NULL, 1, 1, '2025-11-17', '2026-11-18', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(36, 'Product 36', 'product-36-gcqg', 'SKU-GEZ9CHPK', 3, 8, 406.00, 38.00, 141.00, 167, 11, 'pcs', '387g', NULL, 1, 1, '2025-11-21', '2026-10-31', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(37, 'Product 37', 'product-37-2rs6', 'SKU-5FGYR63F', 4, 12, 95.00, 29.00, 42.00, 24, 7, 'pcs', '781g', NULL, 1, 1, '2025-12-02', '2026-09-19', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(38, 'Product 38', 'product-38-vbdq', 'SKU-97ASDQ4C', 5, 14, 445.00, 37.00, 299.00, 89, 8, 'pcs', '724g', NULL, 1, 1, '2025-12-13', '2026-09-03', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(39, 'Product 39', 'product-39-gtbi', 'SKU-NUFPDABU', 5, 15, 226.00, 50.00, 355.00, 157, 17, 'pcs', '721g', NULL, 1, 1, '2025-12-05', '2026-07-17', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(40, 'Product 40', 'product-40-111c', 'SKU-W6K9ZOVR', 4, 10, 378.00, 6.00, 218.00, 62, 20, 'pcs', '903g', NULL, 1, 1, '2025-12-31', '2026-11-19', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(41, 'Product 41', 'product-41-wwel', 'SKU-2RP9P9RM', 4, 10, 122.00, 29.00, 331.00, 79, 17, 'pcs', '307g', NULL, 1, 1, '2025-12-25', '2026-05-13', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(42, 'Product 42', 'product-42-hffc', 'SKU-N1C4PCFS', 4, 11, 360.00, 7.00, 366.00, 14, 13, 'pcs', '323g', NULL, 1, 1, '2025-11-12', '2026-07-20', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(43, 'Product 43', 'product-43-oluq', 'SKU-S7IBXITP', 1, 3, 315.00, 31.00, 355.00, 156, 15, 'pcs', '818g', NULL, 1, 1, '2025-10-28', '2026-11-05', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(44, 'Product 44', 'product-44-d50n', 'SKU-ZYXUMNNT', 3, 8, 395.00, 7.00, 146.00, 87, 11, 'pcs', '360g', NULL, 1, 1, '2026-01-11', '2026-09-08', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(45, 'Product 45', 'product-45-ccrc', 'SKU-SEFHRIOI', 5, 15, 426.00, 31.00, 364.00, 103, 16, 'pcs', '911g', NULL, 1, 1, '2025-12-09', '2026-05-08', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(46, 'Product 46', 'product-46-p67g', 'SKU-ISX6QYNG', 4, 11, 88.00, 32.00, 54.00, 95, 7, 'pcs', '676g', NULL, 1, 1, '2025-12-01', '2026-12-04', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(47, 'Product 47', 'product-47-th0i', 'SKU-GRHWPJGS', 5, 15, 484.00, 47.00, 98.00, 47, 16, 'pcs', '811g', NULL, 1, 1, '2025-12-02', '2026-08-15', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(48, 'Product 48', 'product-48-u9tj', 'SKU-JBHXV9QW', 2, 4, 422.00, 0.00, 307.00, 115, 20, 'pcs', '366g', NULL, 1, 1, '2025-10-25', '2026-05-27', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(49, 'Product 49', 'product-49-khhc', 'SKU-XQNSNX1R', 2, 4, 144.00, 1.00, 306.00, 174, 19, 'pcs', '411g', NULL, 1, 1, '2026-01-12', '2026-04-18', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30'),
(50, 'Product 50', 'product-50-xsa5', 'SKU-UDJMACTS', 1, 2, 98.00, 26.00, 59.00, 26, 5, 'pcs', '575g', NULL, 1, 1, '2025-11-02', '2026-04-09', 'Seeder generated product', '2026-01-28 22:18:30', '2026-01-28 22:18:30');

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
(1, 'Rahim', 'Uddin', '2000-05-12', 'Male', 'A+', 'Islam', 'Bangladeshi', '1998123456789', '01711111111', 'rahim@example.com', '$2y$12$VSitdyi5ZJ8YffGJc/8a0ubnXLc0VvgJJhLojNl9KKAZHC4eJuzs.', 'Dhaka', 'Dhaka', 'Abdul Karim', '01722222222', 'Ayesha Begum', '01733333333', 'Abdul Karim', '01722222222', 'admin', 'active', '2024-01-29', 'Regular student', NULL, NULL, NULL, '2026-01-28 22:18:28', '2026-01-28 22:18:36', '127.0.0.1', 1, 'GPPXDS6CRxSCwRhS9f80BoZ1hTZwCtmZuUN240I50CT1tDFRCy1zhkIzfQJ0', NULL, '2026-01-28 22:18:36'),
(2, 'User', 'No2', '2001-01-01', 'Female', 'O+', 'Islam', 'Bangladeshi', '199900000002', '01500000002', 'user2@example.com', '$2y$12$17PPmgQQVaIUjaU5oY.ohOLYUyG8H7mPuuKpHuFHjSNr5L8toDB7i', 'Dhaka', 'Dhaka', 'Father 2', '01811111112', 'Mother 2', '01822222222', 'Guardian 2', '01833333332', 'admin', 'active', '2025-11-29', 'Seeder data', NULL, NULL, NULL, '2026-01-28 22:18:28', '2026-01-28 22:18:28', '127.0.0.1', 1, NULL, NULL, NULL),
(3, 'User', 'No3', '2001-01-01', 'Male', 'O+', 'Islam', 'Bangladeshi', '199900000003', '01500000003', 'user3@example.com', '$2y$12$ak.ubejoijJqXENnwM3o8u2X2Q3KqX8SFEtorWjpVKVvFSDNo5CMC', 'Dhaka', 'Dhaka', 'Father 3', '01811111113', 'Mother 3', '01822222223', 'Guardian 3', '01833333333', 'admin', 'active', '2025-10-29', 'Seeder data', NULL, NULL, NULL, '2026-01-28 22:18:29', '2026-01-28 22:18:29', '127.0.0.1', 1, NULL, NULL, NULL),
(4, 'User', 'No4', '2001-01-01', 'Female', 'O+', 'Islam', 'Bangladeshi', '199900000004', '01500000004', 'user4@example.com', '$2y$12$dhQwaDQuvkg4odzzZa8f..FSH8BIRtO8ieWKfGbkjL4yI6f5/5BgK', 'Dhaka', 'Dhaka', 'Father 4', '01811111114', 'Mother 4', '01822222224', 'Guardian 4', '01833333334', 'admin', 'active', '2025-09-29', 'Seeder data', NULL, NULL, NULL, '2026-01-28 22:18:29', '2026-01-28 22:18:29', '127.0.0.1', 1, NULL, NULL, NULL),
(5, 'User', 'No5', '2001-01-01', 'Male', 'O+', 'Islam', 'Bangladeshi', '199900000005', '01500000005', 'user5@example.com', '$2y$12$SFHaBVsTKMphhHvjr1r0C./SMPdObGW2lbc9LWHN7XmLcuJQjNw1e', 'Dhaka', 'Dhaka', 'Father 5', '01811111115', 'Mother 5', '01822222225', 'Guardian 5', '01833333335', 'admin', 'active', '2025-08-29', 'Seeder data', NULL, NULL, NULL, '2026-01-28 22:18:29', '2026-01-28 22:18:29', '127.0.0.1', 1, NULL, NULL, NULL),
(6, 'User', 'No6', '2001-01-01', 'Female', 'O+', 'Islam', 'Bangladeshi', '199900000006', '01500000006', 'user6@example.com', '$2y$12$eaIUvpowzPrK2.Wx8cGq5eQWfcb55.1OUt5/eivKdk8/c5FP74aJm', 'Dhaka', 'Dhaka', 'Father 6', '01811111116', 'Mother 6', '01822222226', 'Guardian 6', '01833333336', 'admin', 'active', '2025-07-29', 'Seeder data', NULL, NULL, NULL, '2026-01-28 22:18:29', '2026-01-28 22:18:29', '127.0.0.1', 1, NULL, NULL, NULL),
(7, 'User', 'No7', '2001-01-01', 'Male', 'O+', 'Islam', 'Bangladeshi', '199900000007', '01500000007', 'user7@example.com', '$2y$12$KDspf2SrTdKLt1.aza0uHObgzrkQlduMWb8M9N0G6ZYHElUUs3L6G', 'Dhaka', 'Dhaka', 'Father 7', '01811111117', 'Mother 7', '01822222227', 'Guardian 7', '01833333337', 'admin', 'active', '2025-06-29', 'Seeder data', NULL, NULL, NULL, '2026-01-28 22:18:29', '2026-01-28 22:18:29', '127.0.0.1', 1, NULL, NULL, NULL),
(8, 'User', 'No8', '2001-01-01', 'Female', 'O+', 'Islam', 'Bangladeshi', '199900000008', '01500000008', 'user8@example.com', '$2y$12$yOwuCgW/STLmo7m6SWqYcuo5UTWpw1KnwX7KkKh37wAmqLJ8IUPN.', 'Dhaka', 'Dhaka', 'Father 8', '01811111118', 'Mother 8', '01822222228', 'Guardian 8', '01833333338', 'admin', 'active', '2025-05-29', 'Seeder data', NULL, NULL, NULL, '2026-01-28 22:18:29', '2026-01-28 22:18:29', '127.0.0.1', 1, NULL, NULL, NULL),
(9, 'User', 'No9', '2001-01-01', 'Male', 'O+', 'Islam', 'Bangladeshi', '199900000009', '01500000009', 'user9@example.com', '$2y$12$PVGG/lrgUhT7yPNWa2p83uUZ5qcxoBLFJzaIxtPidRKRttGT3qrxW', 'Dhaka', 'Dhaka', 'Father 9', '01811111119', 'Mother 9', '01822222229', 'Guardian 9', '01833333339', 'admin', 'active', '2025-04-29', 'Seeder data', NULL, NULL, NULL, '2026-01-28 22:18:30', '2026-01-28 22:18:30', '127.0.0.1', 1, NULL, NULL, NULL),
(10, 'User', 'No10', '2001-01-01', 'Female', 'O+', 'Islam', 'Bangladeshi', '1999000000010', '015000000010', 'user10@example.com', '$2y$12$J4Vi8Sh4QoKIcc.dKT2umucRSmG5DjmabYfY4MRgqe1gaEFj3wE/q', 'Dhaka', 'Dhaka', 'Father 10', '018111111110', 'Mother 10', '018222222210', 'Guardian 10', '018333333310', 'admin', 'active', '2025-03-29', 'Seeder data', NULL, NULL, NULL, '2026-01-28 22:18:30', '2026-01-28 22:18:30', '127.0.0.1', 1, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_product_id_foreign` (`product_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `companies_email_unique` (`email`);

--
-- Indexes for table `excategories`
--
ALTER TABLE `excategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_category_id_foreign` (`category_id`),
  ADD KEY `expenses_subcategory_id_foreign` (`subcategory_id`),
  ADD KEY `expenses_user_id_foreign` (`user_id`);

--
-- Indexes for table `exsubcategories`
--
ALTER TABLE `exsubcategories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `exsubcategories_category_id_name_unique` (`category_id`,`name`);

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_reg_unique` (`reg`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_date_user_id_index` (`date`,`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_details_reg_unique` (`reg`),
  ADD KEY `payment_details_user_id_foreign` (`user_id`),
  ADD KEY `payment_details_order_id_foreign` (`order_id`),
  ADD KEY `payment_details_payment_method_id_foreign` (`payment_method_id`),
  ADD KEY `payment_details_date_user_id_order_id_index` (`date`,`user_id`,`order_id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_methods_name_unique` (`name`);

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
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `excategories`
--
ALTER TABLE `excategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `exsubcategories`
--
ALTER TABLE `exsubcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_details`
--
ALTER TABLE `payment_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pdr_categories`
--
ALTER TABLE `pdr_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pdr_stocks`
--
ALTER TABLE `pdr_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

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
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `excategories` (`id`),
  ADD CONSTRAINT `expenses_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `exsubcategories` (`id`),
  ADD CONSTRAINT `expenses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `exsubcategories`
--
ALTER TABLE `exsubcategories`
  ADD CONSTRAINT `exsubcategories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `excategories` (`id`);

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
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD CONSTRAINT `payment_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `payment_details_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`),
  ADD CONSTRAINT `payment_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

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
