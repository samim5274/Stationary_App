-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 31, 2026 at 05:38 AM
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
-- Table structure for table `bank_details`
--

CREATE TABLE `bank_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `branch_name` varchar(255) DEFAULT NULL,
  `account_name` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `routing_number` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bank_details`
--

INSERT INTO `bank_details` (`id`, `bank_name`, `branch_name`, `account_name`, `account_number`, `routing_number`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 'Dutch-Bangla Bank Ltd', 'Motijheel Branch', 'Samim Enterprise', '12345678901', '090274658', 'Primary business account', '2026-01-29 22:44:12', '2026-01-29 22:44:12'),
(2, 'BRAC Bank Ltd', 'Gulshan Branch', 'Samim Enterprise', '22334455667', '060121456', 'Online transactions', '2026-01-29 22:44:12', '2026-01-29 22:44:12'),
(3, 'Islami Bank Bangladesh Ltd', 'Mirpur Branch', 'Samim Enterprise', '33445566778', '125263987', 'Savings account', '2026-01-29 22:44:12', '2026-01-29 22:44:12'),
(4, 'Sonali Bank Ltd', 'Dhanmondi Branch', 'Samim Enterprise', '44556677889', '200263548', 'Government payments', '2026-01-29 22:44:12', '2026-01-29 22:44:12'),
(5, 'City Bank Ltd', 'Uttara Branch', 'Samim Enterprise', '55667788990', '225264111', 'Card & POS settlements', '2026-01-29 22:44:12', '2026-01-29 22:44:12');

-- --------------------------------------------------------

--
-- Table structure for table `bank_transection_details`
--

CREATE TABLE `bank_transection_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bank_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(255) NOT NULL,
  `remarks` text NOT NULL DEFAULT 'N/A',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bank_transection_details`
--

INSERT INTO `bank_transection_details` (`id`, `bank_id`, `user_id`, `amount`, `date`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 450.00, '2026-01-30', 'Deposit', 'Surgon X3df#f', '2026-01-29 23:57:37', '2026-01-29 23:57:37'),
(2, 2, 1, 1500.00, '2026-01-30', 'Deposit', 'Mini', '2026-01-30 00:00:08', '2026-01-30 00:00:08'),
(3, 1, 1, 400.00, '2026-01-30', 'Withdraw', 'Transfer to Bank ID: 3. ', '2026-01-30 00:01:46', '2026-01-30 00:01:46'),
(5, 1, 1, 50.00, '2026-01-30', 'Withdraw', 'N/A', '2026-01-30 02:35:53', '2026-01-30 02:35:53'),
(6, 2, 1, 4500.00, '2026-01-31', 'Deposit', 'N/A', '2026-01-30 22:16:32', '2026-01-30 22:16:32'),
(7, 1, 1, 5000.00, '2026-01-31', 'Deposit', 'Surgon X3df#f', '2026-01-30 22:17:03', '2026-01-30 22:17:03'),
(8, 1, 1, 2000.00, '2026-01-31', 'Withdraw', 'N/A', '2026-01-30 22:17:14', '2026-01-30 22:17:14'),
(9, 2, 1, 2000.00, '2026-01-31', 'Withdraw', 'N/A', '2026-01-30 22:20:43', '2026-01-30 22:20:43'),
(10, 1, 1, 1000.00, '2026-01-31', 'Withdraw', 'Transfer to Bank ID: 4. ', '2026-01-30 22:21:17', '2026-01-30 22:21:17'),
(11, 4, 1, 1000.00, '2026-01-31', 'Deposit', 'Transfer from Bank ID: 1. ', '2026-01-30 22:21:17', '2026-01-30 22:21:17');

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
(1, 'EasyShopX Ltd', 'House 12, Road 5, Uttara, Dhaka', 'info@easyshopx.com', '01711111111', 'https://easyshopx.com', 'companies/logo1.png', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(2, 'Smart Tech Solution', 'Mirpur 10, Dhaka', 'contact@smarttech.com', '01822222222', 'https://smarttech.com', 'companies/logo2.png', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(3, 'NextGen IT', 'Dhanmondi, Dhaka', 'hello@nextgenit.com', '01933333333', 'https://nextgenit.com', 'companies/logo3.png', '2026-01-29 02:21:51', '2026-01-29 02:21:51');

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
(1, 'Writing Instruments', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(2, 'Paper Products', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(3, 'Office Supplies', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(4, 'School Supplies', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(5, 'Art & Craft', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(6, 'Files & Folders', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(7, 'Electronics', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(8, 'Printing & Accessories', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(9, 'Others', '2026-01-29 02:21:51', '2026-01-29 03:36:58');

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
(3, 2, 13, 1, 'Bazar', '2026-01-30', 540.00, 'Surgon X3df#f', '2026-01-29 22:29:51', '2026-01-29 22:29:51'),
(4, 2, 12, 1, 'Midterm Exam Schedule', '2026-01-30', 150.00, 'Surgon X3df#f', '2026-01-29 22:33:06', '2026-01-29 22:33:06');

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
(1, 1, 'Black & White Print A', '2026-01-29 02:21:51', '2026-01-29 04:03:26'),
(2, 1, 'Gel Pen', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(3, 1, 'Pencil', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(4, 1, 'Marker', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(5, 1, 'Highlighter', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(6, 1, 'Eraser', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(7, 1, 'Sharpener', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(8, 2, 'A4 Paper', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(9, 2, 'A3 Paper', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(10, 2, 'Notebook', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(11, 2, 'Diary', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(12, 2, 'Drawing Paper', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(13, 2, 'Carbon Paper', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(14, 3, 'Stapler', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(15, 3, 'Staple Pin', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(16, 3, 'Paper Clip', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(17, 3, 'Calculator', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(18, 3, 'Glue', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(19, 3, 'Tape', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(20, 3, 'Punch Machine', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(21, 4, 'School Bag', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(22, 4, 'Geometry Box', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(23, 4, 'Color Pencil', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(24, 4, 'Crayons', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(25, 4, 'Scale', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(26, 4, 'Exam Pad', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(27, 5, 'Paint Brush', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(28, 5, 'Poster Color', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(29, 5, 'Water Color', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(30, 5, 'Canvas', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(31, 5, 'Craft Paper', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(32, 6, 'File Folder', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(33, 6, 'Ring File', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(34, 6, 'Document File', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(35, 6, 'Envelope', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(36, 7, 'Calculator', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(37, 7, 'Pen Drive', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(38, 7, 'Mouse', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(39, 7, 'Keyboard', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(40, 8, 'Printer Ink', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(41, 8, 'Toner', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(42, 8, 'Lamination Sheet', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(43, 8, 'Binding Comb', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(44, 9, 'Gift Item', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(45, 9, 'Miscellaneous', '2026-01-29 02:21:51', '2026-01-29 02:21:51');

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
-- Table structure for table `incomes`
--

CREATE TABLE `incomes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `subcategory_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `income_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `incomes`
--

INSERT INTO `incomes` (`id`, `category_id`, `subcategory_id`, `user_id`, `title`, `description`, `amount`, `income_date`, `created_at`, `updated_at`) VALUES
(5, 1, 2, 1, 'Sports Competition Notice', NULL, 123.00, '2026-01-29', '2026-01-29 02:52:50', '2026-01-29 02:52:50'),
(6, 3, 13, 1, 'Bazar', NULL, 150.00, '2026-01-29', '2026-01-29 02:53:01', '2026-01-29 02:53:01'),
(7, 5, 21, 1, 'Sports Competition Notice', 'asdf', 123.00, '2026-01-29', '2026-01-29 04:48:38', '2026-01-29 04:48:38');

-- --------------------------------------------------------

--
-- Table structure for table `income_categories`
--

CREATE TABLE `income_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `income_categories`
--

INSERT INTO `income_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Printing & Photocopy', '2026-01-29 02:27:46', '2026-01-29 02:27:46'),
(2, 'Stationery Services', '2026-01-29 02:27:46', '2026-01-29 02:27:46'),
(3, 'Commission Income', '2026-01-29 02:27:46', '2026-01-29 02:27:46'),
(4, 'Educational Services', '2026-01-29 02:27:47', '2026-01-29 02:27:47'),
(5, 'Other Income', '2026-01-29 02:27:47', '2026-01-29 02:27:47');

-- --------------------------------------------------------

--
-- Table structure for table `income_sub_categories`
--

CREATE TABLE `income_sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `income_sub_categories`
--

INSERT INTO `income_sub_categories` (`id`, `category_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Black & White Print', '2026-01-29 02:27:46', '2026-01-29 04:06:44'),
(2, 1, 'Color Print', '2026-01-29 02:27:46', '2026-01-29 02:27:46'),
(3, 1, 'Photocopy', '2026-01-29 02:27:46', '2026-01-29 02:27:46'),
(4, 1, 'Scanning', '2026-01-29 02:27:46', '2026-01-29 02:27:46'),
(5, 1, 'Lamination', '2026-01-29 02:27:46', '2026-01-29 02:27:46'),
(6, 1, 'Binding', '2026-01-29 02:27:46', '2026-01-29 02:27:46'),
(7, 2, 'Document Typing', '2026-01-29 02:27:46', '2026-01-29 02:27:46'),
(8, 2, 'Online Form Fill-up', '2026-01-29 02:27:46', '2026-01-29 02:27:46'),
(9, 2, 'Photo Print', '2026-01-29 02:27:46', '2026-01-29 02:27:46'),
(10, 2, 'Passport Size Photo', '2026-01-29 02:27:46', '2026-01-29 02:27:46'),
(11, 3, 'Bkash Commission', '2026-01-29 02:27:46', '2026-01-29 02:27:46'),
(12, 3, 'Nagad Commission', '2026-01-29 02:27:46', '2026-01-29 02:27:46'),
(13, 3, 'Rocket Commission', '2026-01-29 02:27:47', '2026-01-29 02:27:47'),
(14, 4, 'Assignment Print', '2026-01-29 02:27:47', '2026-01-29 02:27:47'),
(15, 4, 'Project Print', '2026-01-29 02:27:47', '2026-01-29 02:27:47'),
(16, 4, 'Thesis Print', '2026-01-29 02:27:47', '2026-01-29 02:27:47'),
(17, 4, 'Question Paper Print', '2026-01-29 02:27:47', '2026-01-29 02:27:47'),
(18, 5, 'Delivery Charge', '2026-01-29 02:27:47', '2026-01-29 02:27:47'),
(19, 5, 'Service Charge', '2026-01-29 02:27:47', '2026-01-29 02:27:47'),
(20, 5, 'Miscellaneous Income', '2026-01-29 02:27:47', '2026-01-29 02:27:47'),
(21, 5, 'other', '2026-01-29 03:57:04', '2026-01-29 03:57:04');

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
(17, '2026_01_27_084933_create_expenses_table', 1),
(18, '2026_01_29_081359_create_income_categories_table', 1),
(19, '2026_01_29_081414_create_income_sub_categories_table', 1),
(20, '2026_01_29_081425_create_incomes_table', 1),
(21, '2026_01_30_043434_create_bank_details_table', 2),
(22, '2026_01_30_043445_create_bank_transection_details_table', 2);

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
(1, 'Cash', 'Cash Payment', 1, '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(2, 'Credit Card', 'Pay via credit/debit card', 1, '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(3, 'Bkash', 'Mobile banking payment', 1, '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(4, 'Nagad', 'Mobile banking payment', 1, '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(5, 'Rocket', 'Mobile banking payment', 1, '2026-01-29 02:21:51', '2026-01-29 02:21:51');

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
(1, 'Grocery', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(2, 'Beverage', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(3, 'Dairy', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(4, 'Bakery', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(5, 'Snacks', '2026-01-29 02:21:51', '2026-01-29 02:21:51');

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
(1, 1, 'Rice', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(2, 1, 'Oil', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(3, 1, 'Spices', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(4, 2, 'Soft Drink', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(5, 2, 'Juice', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(6, 2, 'Energy Drink', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(7, 3, 'Milk', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(8, 3, 'Butter', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(9, 3, 'Cheese', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(10, 4, 'Bread', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(11, 4, 'Cake', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(12, 4, 'Biscuit', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(13, 5, 'Chips', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(14, 5, 'Chocolate', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(15, 5, 'Noodles', '2026-01-29 02:21:51', '2026-01-29 02:21:51');

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
(1, 'Product 1', 'product-1-b6lc', 'SKU-TQXSRTOA', 4, 11, 213.00, 45.00, 90.00, 75, 15, 'pcs', '561g', NULL, 1, 1, '2025-11-19', '2026-07-10', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(2, 'Product 2', 'product-2-rzpo', 'SKU-TTEETAJR', 1, 2, 320.00, 25.00, 302.00, 85, 8, 'pcs', '423g', NULL, 1, 1, '2026-01-13', '2026-05-23', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(3, 'Product 3', 'product-3-2qmj', 'SKU-DZJWNVQB', 1, 2, 119.00, 3.00, 239.00, 92, 6, 'pcs', '794g', NULL, 1, 1, '2025-12-19', '2026-07-15', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(4, 'Product 4', 'product-4-irxl', 'SKU-6VH7XFF2', 5, 15, 146.00, 14.00, 150.00, 160, 6, 'pcs', '847g', NULL, 1, 1, '2025-11-14', '2026-08-24', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(5, 'Product 5', 'product-5-nc9a', 'SKU-AMIPVDOB', 4, 10, 417.00, 39.00, 151.00, 66, 20, 'pcs', '984g', NULL, 1, 1, '2025-12-20', '2026-11-23', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(6, 'Product 6', 'product-6-hlvx', 'SKU-XH31LB19', 5, 13, 343.00, 34.00, 68.00, 179, 16, 'pcs', '971g', NULL, 1, 1, '2025-10-29', '2026-05-16', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(7, 'Product 7', 'product-7-qemt', 'SKU-JFYSX5CR', 2, 5, 107.00, 44.00, 64.00, 112, 14, 'pcs', '399g', NULL, 1, 1, '2025-11-25', '2026-07-22', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(8, 'Product 8', 'product-8-wjvw', 'SKU-7WMBK8VB', 3, 7, 377.00, 32.00, 125.00, 120, 9, 'pcs', '355g', NULL, 1, 1, '2025-11-06', '2027-01-06', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(9, 'Product 9', 'product-9-5i5h', 'SKU-VIMJRHPU', 3, 7, 453.00, 3.00, 336.00, 173, 12, 'pcs', '534g', NULL, 1, 1, '2025-12-13', '2026-12-14', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(10, 'Product 10', 'product-10-8ikd', 'SKU-PARJDJKF', 3, 8, 130.00, 47.00, 98.00, 135, 8, 'pcs', '447g', NULL, 1, 1, '2026-01-11', '2026-07-20', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(11, 'Product 11', 'product-11-0s7v', 'SKU-H7OXPJRB', 4, 10, 418.00, 29.00, 128.00, 17, 19, 'pcs', '970g', NULL, 1, 1, '2025-12-16', '2026-07-02', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(12, 'Product 12', 'product-12-xoq3', 'SKU-MN88S9VY', 2, 5, 411.00, 22.00, 52.00, 27, 10, 'pcs', '909g', NULL, 1, 1, '2026-01-10', '2026-10-23', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(13, 'Product 13', 'product-13-cac6', 'SKU-N9ZDK9GC', 1, 1, 492.00, 48.00, 98.00, 103, 15, 'pcs', '781g', NULL, 1, 1, '2026-01-10', '2026-07-20', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(14, 'Product 14', 'product-14-36ac', 'SKU-XINNW2O5', 5, 14, 475.00, 0.00, 277.00, 154, 16, 'pcs', '801g', NULL, 1, 1, '2025-11-14', '2026-05-25', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(15, 'Product 15', 'product-15-46my', 'SKU-UUJWMZTL', 2, 5, 429.00, 12.00, 370.00, 178, 12, 'pcs', '956g', NULL, 1, 1, '2025-12-23', '2026-06-04', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(16, 'Product 16', 'product-16-2qd4', 'SKU-DE1FJMGG', 2, 5, 410.00, 21.00, 350.00, 99, 11, 'pcs', '333g', NULL, 1, 1, '2025-10-25', '2026-10-19', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(17, 'Product 17', 'product-17-dexo', 'SKU-V0IE2OVU', 1, 3, 257.00, 2.00, 48.00, 187, 18, 'pcs', '814g', NULL, 1, 1, '2026-01-03', '2027-01-26', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(18, 'Product 18', 'product-18-rdzl', 'SKU-0U417MAG', 4, 12, 137.00, 33.00, 153.00, 162, 9, 'pcs', '253g', NULL, 1, 1, '2025-11-11', '2026-06-13', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(19, 'Product 19', 'product-19-gx6a', 'SKU-UXAA6QNY', 5, 15, 136.00, 31.00, 293.00, 10, 15, 'pcs', '746g', NULL, 1, 1, '2025-11-02', '2026-09-01', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(20, 'Product 20', 'product-20-nnmy', 'SKU-5IC650VJ', 5, 13, 213.00, 36.00, 150.00, 127, 6, 'pcs', '288g', NULL, 1, 1, '2025-12-06', '2026-03-17', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(21, 'Product 21', 'product-21-5s8t', 'SKU-IZPO9NSN', 5, 13, 460.00, 35.00, 168.00, 200, 6, 'pcs', '532g', NULL, 1, 1, '2026-01-13', '2026-09-13', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(22, 'Product 22', 'product-22-trpg', 'SKU-R8WVDODF', 2, 4, 498.00, 46.00, 361.00, 28, 16, 'pcs', '669g', NULL, 1, 1, '2026-01-13', '2027-01-06', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(23, 'Product 23', 'product-23-0c91', 'SKU-CUDGRERA', 5, 14, 155.00, 33.00, 34.00, 50, 6, 'pcs', '510g', NULL, 1, 1, '2025-11-09', '2026-05-24', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(24, 'Product 24', 'product-24-bjmy', 'SKU-DX2HYULL', 2, 5, 364.00, 5.00, 156.00, 125, 7, 'pcs', '260g', NULL, 1, 1, '2025-11-24', '2026-05-03', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(25, 'Product 25', 'product-25-efe2', 'SKU-GRIYFZX7', 5, 14, 413.00, 43.00, 234.00, 54, 19, 'pcs', '434g', NULL, 1, 1, '2025-11-20', '2026-05-05', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(26, 'Product 26', 'product-26-eixc', 'SKU-7VMJIS8T', 5, 14, 279.00, 13.00, 359.00, 133, 13, 'pcs', '432g', NULL, 1, 1, '2025-10-26', '2026-04-27', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(27, 'Product 27', 'product-27-w5t3', 'SKU-MCSHQSKV', 1, 1, 396.00, 17.00, 192.00, 198, 9, 'pcs', '725g', NULL, 1, 1, '2026-01-11', '2027-01-26', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(28, 'Product 28', 'product-28-cypt', 'SKU-OACDKQZD', 4, 12, 56.00, 29.00, 84.00, 59, 14, 'pcs', '807g', NULL, 1, 1, '2025-11-03', '2026-06-11', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(29, 'Product 29', 'product-29-unim', 'SKU-L9GIB1QE', 2, 4, 408.00, 46.00, 289.00, 120, 9, 'pcs', '909g', NULL, 1, 1, '2026-01-08', '2026-05-24', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(30, 'Product 30', 'product-30-m3r8', 'SKU-WWCLDNBQ', 1, 1, 472.00, 42.00, 168.00, 21, 11, 'pcs', '401g', NULL, 1, 1, '2026-01-03', '2026-06-15', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(31, 'Product 31', 'product-31-i8c6', 'SKU-1BXGSSBB', 1, 2, 355.00, 39.00, 368.00, 32, 7, 'pcs', '791g', NULL, 1, 1, '2026-01-12', '2026-04-01', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(32, 'Product 32', 'product-32-eytt', 'SKU-MSZMEY6E', 5, 13, 58.00, 28.00, 58.00, 158, 14, 'pcs', '986g', NULL, 1, 1, '2025-10-22', '2026-03-11', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(33, 'Product 33', 'product-33-zp8p', 'SKU-5PMR0RPG', 4, 10, 111.00, 50.00, 269.00, 124, 17, 'pcs', '602g', NULL, 1, 1, '2025-12-20', '2026-08-15', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(34, 'Product 34', 'product-34-d1hq', 'SKU-CQJVVTTO', 4, 12, 367.00, 43.00, 358.00, 103, 20, 'pcs', '755g', NULL, 1, 1, '2025-10-25', '2026-06-26', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(35, 'Product 35', 'product-35-y6b3', 'SKU-Z9EP6OEZ', 1, 3, 137.00, 1.00, 245.00, 19, 13, 'pcs', '739g', NULL, 1, 1, '2025-11-07', '2026-09-15', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(36, 'Product 36', 'product-36-kqib', 'SKU-XOWAOFRV', 5, 15, 233.00, 7.00, 338.00, 83, 20, 'pcs', '740g', NULL, 1, 1, '2026-01-10', '2026-04-23', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(37, 'Product 37', 'product-37-mdyv', 'SKU-LBF5PBM1', 2, 4, 294.00, 0.00, 161.00, 118, 12, 'pcs', '555g', NULL, 1, 1, '2026-01-08', '2026-05-08', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(38, 'Product 38', 'product-38-qg4w', 'SKU-OTQFNP4X', 5, 15, 160.00, 33.00, 286.00, 105, 5, 'pcs', '862g', NULL, 1, 1, '2025-10-27', '2026-06-09', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(39, 'Product 39', 'product-39-8yxf', 'SKU-ZC0BGFM3', 2, 5, 201.00, 14.00, 76.00, 46, 12, 'pcs', '534g', NULL, 1, 1, '2025-12-29', '2026-04-10', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(40, 'Product 40', 'product-40-cxcy', 'SKU-WV4HVNNO', 4, 12, 172.00, 37.00, 174.00, 52, 9, 'pcs', '850g', NULL, 1, 1, '2025-12-20', '2026-04-03', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(41, 'Product 41', 'product-41-ojf2', 'SKU-D3CJN5IB', 2, 6, 405.00, 25.00, 208.00, 168, 6, 'pcs', '860g', NULL, 1, 1, '2025-12-25', '2026-08-13', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(42, 'Product 42', 'product-42-6cji', 'SKU-ELVNJUKX', 3, 8, 427.00, 35.00, 263.00, 116, 13, 'pcs', '402g', NULL, 1, 1, '2025-10-29', '2026-11-30', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(43, 'Product 43', 'product-43-4ocl', 'SKU-LLEWNML3', 5, 15, 193.00, 3.00, 146.00, 172, 9, 'pcs', '883g', NULL, 1, 1, '2025-11-25', '2026-06-03', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(44, 'Product 44', 'product-44-59qa', 'SKU-OHJYMMLL', 5, 13, 200.00, 31.00, 181.00, 127, 15, 'pcs', '946g', NULL, 1, 1, '2025-12-15', '2026-12-31', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(45, 'Product 45', 'product-45-ubpm', 'SKU-UPK0F5SW', 5, 15, 67.00, 22.00, 219.00, 5, 6, 'pcs', '353g', NULL, 1, 1, '2025-12-09', '2026-08-16', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(46, 'Product 46', 'product-46-ynm6', 'SKU-NDI4CYGI', 3, 8, 486.00, 43.00, 310.00, 77, 17, 'pcs', '434g', NULL, 1, 1, '2025-11-11', '2026-07-16', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(47, 'Product 47', 'product-47-qez9', 'SKU-X76SLNSG', 1, 3, 126.00, 18.00, 106.00, 93, 12, 'pcs', '545g', NULL, 1, 1, '2025-11-18', '2026-08-02', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(48, 'Product 48', 'product-48-orxl', 'SKU-Q4ZNUDJ1', 1, 3, 206.00, 24.00, 383.00, 125, 17, 'pcs', '781g', NULL, 1, 1, '2025-12-14', '2026-10-04', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(49, 'Product 49', 'product-49-wwri', 'SKU-0MUTQCUP', 3, 9, 92.00, 21.00, 371.00, 12, 5, 'pcs', '948g', NULL, 1, 1, '2026-01-03', '2026-07-06', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51'),
(50, 'Product 50', 'product-50-qcg4', 'SKU-KYCVZWID', 5, 14, 369.00, 49.00, 115.00, 79, 14, 'pcs', '793g', NULL, 1, 1, '2025-11-25', '2026-03-23', 'Seeder generated product', '2026-01-29 02:21:51', '2026-01-29 02:21:51');

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
(1, 'Rahim', 'Uddin', '2000-05-12', 'Male', 'A+', 'Islam', 'Bangladeshi', '1998123456789', '01711111111', 'rahim@example.com', '$2y$12$Q9DM.DCL.8/oSzbnFv/29O6.gsiNdvgb3XSpD3S293WUU7JC2h/dC', 'Dhaka', 'Dhaka', 'Abdul Karim', '01722222222', 'Ayesha Begum', '01733333333', 'Abdul Karim', '01722222222', 'admin', 'active', '2024-01-29', 'Regular student', NULL, NULL, NULL, '2026-01-29 02:21:49', '2026-01-29 22:29:21', '127.0.0.1', 1, 'p8QMJdf7DcVq7CAdiFZSBnACFBzRzUTonvegGCAFg6LmTAYtDjDM19n8kZGS', NULL, '2026-01-29 22:29:21'),
(2, 'User', 'No2', '2001-01-01', 'Female', 'O+', 'Islam', 'Bangladeshi', '199900000002', '01500000002', 'user2@example.com', '$2y$12$pdkj8PiY5FNVmvW8vVOhSuBt5x2Eoy.TAttyrt/RYfcuyET.Wnk8S', 'Dhaka', 'Dhaka', 'Father 2', '01811111112', 'Mother 2', '01822222222', 'Guardian 2', '01833333332', 'admin', 'active', '2025-11-29', 'Seeder data', NULL, NULL, NULL, '2026-01-29 02:21:49', '2026-01-29 02:21:49', '127.0.0.1', 1, NULL, NULL, NULL),
(3, 'User', 'No3', '2001-01-01', 'Male', 'O+', 'Islam', 'Bangladeshi', '199900000003', '01500000003', 'user3@example.com', '$2y$12$cENVuZEm8BmFWRukp9SRqOtBhmjVbZbN4nJ4vCpvu.tSjBs.MRxOm', 'Dhaka', 'Dhaka', 'Father 3', '01811111113', 'Mother 3', '01822222223', 'Guardian 3', '01833333333', 'admin', 'active', '2025-10-29', 'Seeder data', NULL, NULL, NULL, '2026-01-29 02:21:49', '2026-01-29 02:21:49', '127.0.0.1', 1, NULL, NULL, NULL),
(4, 'User', 'No4', '2001-01-01', 'Female', 'O+', 'Islam', 'Bangladeshi', '199900000004', '01500000004', 'user4@example.com', '$2y$12$xlFaoV.c.PlbQNoQflLYsuCp21t25DYjjywvqFxbEpdwi73aD4Lzy', 'Dhaka', 'Dhaka', 'Father 4', '01811111114', 'Mother 4', '01822222224', 'Guardian 4', '01833333334', 'admin', 'active', '2025-09-29', 'Seeder data', NULL, NULL, NULL, '2026-01-29 02:21:49', '2026-01-29 02:21:49', '127.0.0.1', 1, NULL, NULL, NULL),
(5, 'User', 'No5', '2001-01-01', 'Male', 'O+', 'Islam', 'Bangladeshi', '199900000005', '01500000005', 'user5@example.com', '$2y$12$gEUu9f1wySoNDvayMLFeuubjz/Tfd4B1wU7vu4N64OfQ1EgsSHJLa', 'Dhaka', 'Dhaka', 'Father 5', '01811111115', 'Mother 5', '01822222225', 'Guardian 5', '01833333335', 'admin', 'active', '2025-08-29', 'Seeder data', NULL, NULL, NULL, '2026-01-29 02:21:50', '2026-01-29 02:21:50', '127.0.0.1', 1, NULL, NULL, NULL),
(6, 'User', 'No6', '2001-01-01', 'Female', 'O+', 'Islam', 'Bangladeshi', '199900000006', '01500000006', 'user6@example.com', '$2y$12$6iBDddEzytELcEwH9Jk.pO1M/hqdvtWOLPrGfhvijvlgbMu9eO8nK', 'Dhaka', 'Dhaka', 'Father 6', '01811111116', 'Mother 6', '01822222226', 'Guardian 6', '01833333336', 'admin', 'active', '2025-07-29', 'Seeder data', NULL, NULL, NULL, '2026-01-29 02:21:50', '2026-01-29 02:21:50', '127.0.0.1', 1, NULL, NULL, NULL),
(7, 'User', 'No7', '2001-01-01', 'Male', 'O+', 'Islam', 'Bangladeshi', '199900000007', '01500000007', 'user7@example.com', '$2y$12$ZGgYicGCO5fCa.E2bPtT5OgXueP4IfCeSbDZJameijDDuNX4/AuyC', 'Dhaka', 'Dhaka', 'Father 7', '01811111117', 'Mother 7', '01822222227', 'Guardian 7', '01833333337', 'admin', 'active', '2025-06-29', 'Seeder data', NULL, NULL, NULL, '2026-01-29 02:21:50', '2026-01-29 02:21:50', '127.0.0.1', 1, NULL, NULL, NULL),
(8, 'User', 'No8', '2001-01-01', 'Female', 'O+', 'Islam', 'Bangladeshi', '199900000008', '01500000008', 'user8@example.com', '$2y$12$F2uvqu.PKieMR3SbHu56wOSMcPai1p2kFumyYupNF0GYpvcONqffq', 'Dhaka', 'Dhaka', 'Father 8', '01811111118', 'Mother 8', '01822222228', 'Guardian 8', '01833333338', 'admin', 'active', '2025-05-29', 'Seeder data', NULL, NULL, NULL, '2026-01-29 02:21:50', '2026-01-29 02:21:50', '127.0.0.1', 1, NULL, NULL, NULL),
(9, 'User', 'No9', '2001-01-01', 'Male', 'O+', 'Islam', 'Bangladeshi', '199900000009', '01500000009', 'user9@example.com', '$2y$12$8fWagmHwVH4EfxHu4m4ckO2gm28x4.6G5jdf0WMhHP5eQwXNTmYpW', 'Dhaka', 'Dhaka', 'Father 9', '01811111119', 'Mother 9', '01822222229', 'Guardian 9', '01833333339', 'admin', 'active', '2025-04-29', 'Seeder data', NULL, NULL, NULL, '2026-01-29 02:21:50', '2026-01-29 02:21:50', '127.0.0.1', 1, NULL, NULL, NULL),
(10, 'User', 'No10', '2001-01-01', 'Female', 'O+', 'Islam', 'Bangladeshi', '1999000000010', '015000000010', 'user10@example.com', '$2y$12$onVcyo68PO9RcKcKbt.65uTbWpNQdLwXLWHNv/dVMGrpFS6T172Ki', 'Dhaka', 'Dhaka', 'Father 10', '018111111110', 'Mother 10', '018222222210', 'Guardian 10', '018333333310', 'admin', 'active', '2025-03-29', 'Seeder data', NULL, NULL, NULL, '2026-01-29 02:21:51', '2026-01-29 02:21:51', '127.0.0.1', 1, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank_details`
--
ALTER TABLE `bank_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bank_details_account_number_unique` (`account_number`);

--
-- Indexes for table `bank_transection_details`
--
ALTER TABLE `bank_transection_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_transection_details_bank_id_foreign` (`bank_id`),
  ADD KEY `bank_transection_details_user_id_foreign` (`user_id`);

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
-- Indexes for table `incomes`
--
ALTER TABLE `incomes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `incomes_category_id_foreign` (`category_id`),
  ADD KEY `incomes_subcategory_id_foreign` (`subcategory_id`),
  ADD KEY `incomes_user_id_foreign` (`user_id`);

--
-- Indexes for table `income_categories`
--
ALTER TABLE `income_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `income_categories_name_unique` (`name`);

--
-- Indexes for table `income_sub_categories`
--
ALTER TABLE `income_sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `income_sub_categories_category_id_foreign` (`category_id`);

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
-- AUTO_INCREMENT for table `bank_details`
--
ALTER TABLE `bank_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bank_transection_details`
--
ALTER TABLE `bank_transection_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- AUTO_INCREMENT for table `incomes`
--
ALTER TABLE `incomes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `income_categories`
--
ALTER TABLE `income_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `income_sub_categories`
--
ALTER TABLE `income_sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
-- Constraints for table `bank_transection_details`
--
ALTER TABLE `bank_transection_details`
  ADD CONSTRAINT `bank_transection_details_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `bank_details` (`id`),
  ADD CONSTRAINT `bank_transection_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

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
-- Constraints for table `incomes`
--
ALTER TABLE `incomes`
  ADD CONSTRAINT `incomes_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `income_categories` (`id`),
  ADD CONSTRAINT `incomes_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `income_sub_categories` (`id`),
  ADD CONSTRAINT `incomes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `income_sub_categories`
--
ALTER TABLE `income_sub_categories`
  ADD CONSTRAINT `income_sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `income_categories` (`id`);

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
