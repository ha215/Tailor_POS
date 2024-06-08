-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2024 at 04:53 PM
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
-- Database: `tailorpos3`
--

-- --------------------------------------------------------

--
-- Table structure for table `branch_ledgers`
--

CREATE TABLE `branch_ledgers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `bank_opening_balance` double(15,2) DEFAULT NULL,
  `cash_opening_balance` double(15,2) DEFAULT NULL,
  `bank_closing_balance` double(15,2) DEFAULT NULL,
  `cash_closing_balance` double(15,2) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `last_name` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone_number_1` varchar(191) NOT NULL,
  `phone_number_2` varchar(191) DEFAULT NULL,
  `address` longtext DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `date`, `name`, `phone_number_1`, `phone_number_2`, `address`, `branch_id`, `is_active`, `created_by`, `created_at`, `updated_at`) VALUES
(1, '2024-06-08', 'test', '98765434', NULL, NULL, NULL, 1, 1, '2024-06-08 10:48:34', '2024-06-08 10:48:34');

-- --------------------------------------------------------

--
-- Table structure for table `customer_groups`
--

CREATE TABLE `customer_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_groups`
--

INSERT INTO `customer_groups` (`id`, `name`, `is_active`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'xzxzx', 1, 1, '2024-05-29 18:57:42', '2024-05-29 18:57:42');

-- --------------------------------------------------------

--
-- Table structure for table `customer_measurements`
--

CREATE TABLE `customer_measurements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `measurement_id` bigint(20) UNSIGNED DEFAULT NULL,
  `unit` int(11) NOT NULL,
  `notes` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_measurement_details`
--

CREATE TABLE `customer_measurement_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `attribute_id` bigint(20) UNSIGNED DEFAULT NULL,
  `value` double(20,2) DEFAULT NULL,
  `unit` int(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_measurement_details`
--

INSERT INTO `customer_measurement_details` (`id`, `customer_id`, `attribute_id`, `value`, `unit`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 12.00, 1, '2024-06-08 11:01:22', '2024-06-08 11:01:22');

-- --------------------------------------------------------

--
-- Table structure for table `customer_payment_discounts`
--

CREATE TABLE `customer_payment_discounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date` date NOT NULL,
  `amount` double(20,2) NOT NULL,
  `financial_year_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `expense_head_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` double(15,2) NOT NULL,
  `payment_mode` int(11) DEFAULT NULL,
  `tax_included` int(11) NOT NULL,
  `tax_percentage` double(6,2) DEFAULT NULL,
  `note` longtext DEFAULT NULL,
  `financial_year_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expense_heads`
--

CREATE TABLE `expense_heads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `type` int(11) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `financial_years`
--

CREATE TABLE `financial_years` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `year` varchar(191) NOT NULL,
  `starting_date` date DEFAULT NULL,
  `ending_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `financial_years`
--

INSERT INTO `financial_years` (`id`, `year`, `starting_date`, `ending_date`, `created_at`, `updated_at`) VALUES
(1, '2024', '2024-05-01', '2025-05-31', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `invoice_number` varchar(191) NOT NULL,
  `customer_name` varchar(191) DEFAULT NULL,
  `customer_phone` varchar(191) DEFAULT NULL,
  `customer_address` varchar(191) DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `salesman_id` bigint(20) UNSIGNED DEFAULT NULL,
  `discount` double(20,2) NOT NULL,
  `sub_total` double(20,2) NOT NULL,
  `total` double(20,2) NOT NULL,
  `notes` longtext DEFAULT NULL,
  `total_quantity` int(11) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `financial_year_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `delivery_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `date`, `invoice_number`, `customer_name`, `customer_phone`, `customer_address`, `customer_id`, `salesman_id`, `discount`, `sub_total`, `total`, `notes`, `total_quantity`, `created_by`, `financial_year_id`, `branch_id`, `created_at`, `updated_at`, `status`, `delivery_date`) VALUES
(1, '2024-06-08 13:49:12', 'INV-1', 'test', '98765434', NULL, 1, 1, 10.00, 120.00, 110.00, NULL, 1, 1, 1, 1, '2024-06-08 10:49:12', '2024-06-08 10:49:13', 2, '2024-06-25'),
(2, '2024-06-08 13:52:16', 'INV-2', 'test', '98765434', NULL, 1, 1, 0.00, 120.00, 120.00, NULL, 1, 1, 1, 1, '2024-06-08 10:52:16', '2024-06-08 10:52:16', 2, '2024-06-12'),
(3, '2024-06-08 13:58:36', 'INV-3', 'test', '98765434', NULL, 1, 1, 0.00, 120.00, 120.00, NULL, 1, 1, 1, 1, '2024-06-08 10:58:36', '2024-06-08 10:58:39', 2, '2024-06-19'),
(4, '2024-06-08 17:14:05', 'INV-4', 'test', '98765434', NULL, 1, 1, 0.00, 120.00, 120.00, NULL, 1, 1, 1, 1, '2024-06-08 14:14:05', '2024-06-08 14:51:38', 4, '2024-06-19');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_details`
--

CREATE TABLE `invoice_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `type` int(11) DEFAULT NULL,
  `quantity` double(15,2) NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `item_name` varchar(191) NOT NULL,
  `rate` double(20,2) NOT NULL,
  `total` double(20,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `unit_type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_details`
--

INSERT INTO `invoice_details` (`id`, `invoice_id`, `type`, `quantity`, `item_id`, `item_name`, `rate`, `total`, `created_at`, `updated_at`, `unit_type`) VALUES
(1, 1, 1, 1.00, 1, 'Shirt', 120.00, 120.00, '2024-06-08 10:49:13', '2024-06-08 10:49:13', NULL),
(2, 2, 1, 1.00, 1, 'Shirt', 120.00, 120.00, '2024-06-08 10:52:16', '2024-06-08 10:52:16', NULL),
(3, 3, 1, 1.00, 1, 'Shirt', 120.00, 120.00, '2024-06-08 10:58:38', '2024-06-08 10:58:38', NULL),
(4, 4, 1, 1.00, 1, 'Shirt', 120.00, 120.00, '2024-06-08 14:14:05', '2024-06-08 14:14:05', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_payments`
--

CREATE TABLE `invoice_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` datetime DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(191) DEFAULT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `paid_amount` double(15,2) NOT NULL DEFAULT 0.00,
  `payment_mode` int(11) NOT NULL,
  `note` longtext DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `financial_year_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payment_type` int(11) NOT NULL DEFAULT 1,
  `voucher_no` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_payments`
--

INSERT INTO `invoice_payments` (`id`, `date`, `customer_id`, `customer_name`, `invoice_id`, `paid_amount`, `payment_mode`, `note`, `created_by`, `financial_year_id`, `branch_id`, `created_at`, `updated_at`, `payment_type`, `voucher_no`) VALUES
(1, '2024-06-08 17:14:05', 1, 'test', 4, 100.00, 1, NULL, 1, 1, 1, '2024-06-08 14:14:05', '2024-06-08 14:14:05', 1, '1'),
(2, '2024-06-08 17:51:38', 1, 'test', 4, 20.00, 1, NULL, 1, 1, 1, '2024-06-08 14:51:38', '2024-06-08 14:51:38', 1, '2');

-- --------------------------------------------------------

--
-- Table structure for table `master_settings`
--

CREATE TABLE `master_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `master_title` varchar(191) DEFAULT NULL,
  `master_value` longtext DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_settings`
--

INSERT INTO `master_settings` (`id`, `master_title`, `master_value`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'default_application_name', 'Tailor', 1, NULL, NULL),
(2, 'default_currency_code', 'KWD', 1, NULL, NULL),
(3, 'default_country_code', '+965', 1, NULL, NULL),
(4, 'default_printer', '1', 1, NULL, NULL),
(5, 'default_tax_name', 'TAX', 1, NULL, NULL),
(6, 'default_tax_percentage', '15', 1, NULL, NULL),
(7, 'qr_enabled', '0', 1, NULL, NULL),
(8, 'supplier_ledger', '0', 1, NULL, NULL),
(9, 'default_financial_year', '1', 1, NULL, NULL),
(10, 'default_currency_align', '1', 1, NULL, NULL),
(11, 'default_discount_type', '1', 1, NULL, NULL),
(12, 'purchase_add_list', '0', 1, NULL, NULL),
(13, 'valid_till', '', 1, NULL, NULL),
(14, 'default_tax_mode', '1', 1, NULL, NULL),
(15, 'purchase_payments', '0', 1, NULL, NULL),
(16, 'purchase_return', '0', 1, NULL, NULL),
(17, 'suppliers', '0', 1, NULL, NULL),
(18, 'stock_transfer', '0', 1, NULL, NULL),
(19, 'email_configuration', '0', 1, NULL, NULL),
(20, 'sms_configuration', '0', 1, NULL, NULL),
(21, 'banking', '0', 1, NULL, NULL),
(22, 'stock_adjustment', '0', 1, NULL, NULL),
(23, 'branches', '0', 1, NULL, NULL),
(24, 'staffs', '0', 1, NULL, NULL),
(25, 'allow_branches_to_create_products', '1', 1, NULL, NULL),
(26, 'allow_branches_to_create_materials', '1', 1, NULL, NULL),
(27, 'frontend_enabled', '1', 1, NULL, NULL),
(28, 'company_mobile', '66778899', 1, NULL, NULL),
(29, 'company_email', 'pos@gmail.com', 1, NULL, NULL),
(30, 'company_name', 'Tailor Company', 1, NULL, NULL),
(31, 'company_name_arabic', '', 1, NULL, NULL),
(32, 'company_landline', '', 1, NULL, NULL),
(33, 'company_tax_registration', '', 1, NULL, NULL),
(34, 'company_cr_number', '', 1, NULL, NULL),
(35, 'company_building_number', '12', 1, NULL, NULL),
(36, 'company_street_name', 'riggai', 1, NULL, NULL),
(37, 'company_district', 'Kuwait', 1, NULL, NULL),
(38, 'company_city_name', 'kuwait', 1, NULL, NULL),
(39, 'company_country', 'Kuwait', 1, NULL, NULL),
(40, 'company_postal_code', '1234', 1, NULL, NULL),
(41, 'company_additional_number', '', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `price` double(20,2) NOT NULL,
  `unit` int(11) DEFAULT NULL,
  `opening_stock` double DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `name`, `price`, `unit`, `opening_stock`, `is_active`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'shirt ', 10.00, 1, 10, 1, 1, '2024-06-02 06:43:16', '2024-06-02 06:43:16');

-- --------------------------------------------------------

--
-- Table structure for table `measurements`
--

CREATE TABLE `measurements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `products_id` int(100) NOT NULL,
  `measurement_attributes_id` int(191) NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `measurement_attributes`
--

CREATE TABLE `measurement_attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `measurement_attributes`
--

INSERT INTO `measurement_attributes` (`id`, `name`, `is_active`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'width', 1, 1, '2024-06-08 10:48:16', '2024-06-08 10:48:16');

-- --------------------------------------------------------

--
-- Table structure for table `measurement_details`
--

CREATE TABLE `measurement_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `measurement_id` bigint(20) UNSIGNED DEFAULT NULL,
  `measurement_attributes_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_07_02_184435_create_financial_years_table', 1),
(6, '2022_07_02_184436_create_master_settings_table', 1),
(7, '2022_07_02_184437_create_measurement_attributes_table', 1),
(8, '2022_07_02_184438_create_measurements_table', 1),
(9, '2022_07_02_184526_create_measurement_details_table', 1),
(10, '2022_07_02_184828_create_products_table', 1),
(11, '2022_07_02_185907_create_customer_groups_table', 1),
(12, '2022_07_02_190659_create_expense_heads_table', 1),
(13, '2022_07_02_190706_create_expenses_table', 1),
(14, '2022_07_03_161552_add_branch_id_to_users_table', 1),
(15, '2022_07_04_091542_create_customers_table', 1),
(16, '2022_07_04_100556_create_materials_table', 1),
(17, '2022_07_04_105718_create_suppliers_table', 1),
(18, '2022_07_04_121759_create_purchases_table', 1),
(19, '2022_07_04_122144_create_purchase_details_table', 1),
(20, '2022_07_04_122520_create_invoices_table', 1),
(21, '2022_07_04_122544_create_invoice_details_table', 1),
(22, '2022_07_04_122909_create_invoice_payments_table', 1),
(23, '2022_07_04_122916_create_supplier_payments_table', 1),
(24, '2022_07_04_233445_create_purchase_returns_table', 1),
(25, '2022_07_04_233539_create_purchase_return_details_table', 1),
(26, '2022_07_05_121425_add_status_in_invoice', 1),
(27, '2022_07_05_140920_create_customer_measurements_table', 1),
(28, '2022_07_05_141007_create_customer_measurement_details_table', 1),
(29, '2022_07_05_211128_create_customer_payment_discounts_table', 1),
(30, '2022_07_06_061008_add_payment_type_to_invoicepayments_table', 1),
(31, '2022_07_06_124803_add_unit_to_type_invoice_details', 1),
(32, '2022_07_07_100708_create_branch_ledgers_table', 1),
(33, '2022_07_12_062926_create_translations_table', 1),
(34, '2022_07_13_093110_create_stock_adjustments_table', 1),
(35, '2022_07_13_093507_create_stock_adjustment_details_table', 1),
(36, '2022_07_13_093637_create_stock_transfers_table', 1),
(37, '2022_07_13_093649_create_stock_transfer_details_table', 1),
(38, '2022_07_14_034236_add_total_items_in_stock_transfer_table', 1),
(39, '2022_07_26_131037_add_voucher_no_field_to_invoice_payments_table', 1),
(40, '2022_07_27_140327_create_sales_returns_table', 1),
(41, '2022_07_27_140409_create_sales_return_details_table', 1),
(42, '2022_08_01_142923_add_fields_to_sales_return_table', 1),
(43, '2022_08_01_152656_create_sales_return_payments_table', 1),
(44, '2022_08_04_103619_add_voucher_no_to_sales_return_payments_table', 1),
(45, '2022_08_08_102940_add_title_to_expenses_table', 1),
(46, '2023_09_27_064351_add_fields_to_products_table', 1),
(47, '2023_09_27_071243_create_sliders_table', 1),
(48, '2023_09_28_081200_create_offers_table', 1),
(49, '2023_10_02_104007_add_item_code_column_to_products_table', 1),
(50, '2023_10_16_113947_create_online_customers_table', 1),
(51, '2023_10_16_145600_create_online_orders_table', 1),
(52, '2023_10_16_145621_create_online_order_details_table', 1),
(53, '2023_10_17_124828_create_online_appointments_table', 1),
(54, '2023_10_18_065748_create_online_customer_measurements_table', 1),
(55, '2023_10_18_065753_create_online_customer_measurement_details_table', 1),
(56, '2023_10_18_124947_create_contact_messages_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `image` varchar(191) NOT NULL,
  `url` varchar(191) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `online_appointments`
--

CREATE TABLE `online_appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `notes` longtext DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `online_customers`
--

CREATE TABLE `online_customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `avatar` varchar(191) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `online_customer_measurements`
--

CREATE TABLE `online_customer_measurements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `measurement_id` bigint(20) UNSIGNED DEFAULT NULL,
  `unit` int(11) NOT NULL,
  `notes` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `online_customer_measurement_details`
--

CREATE TABLE `online_customer_measurement_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_measurement_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `attribute_id` bigint(20) UNSIGNED DEFAULT NULL,
  `value` double(20,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `online_orders`
--

CREATE TABLE `online_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `order_number` varchar(191) NOT NULL,
  `customer_name` varchar(191) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `country` varchar(191) DEFAULT NULL,
  `state` varchar(191) DEFAULT NULL,
  `city` varchar(191) DEFAULT NULL,
  `zip_code` varchar(191) DEFAULT NULL,
  `preferred_delivery_time` datetime DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `tax_type` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `sub_total` double(20,2) NOT NULL,
  `tax_percentage` double(15,2) DEFAULT NULL,
  `tax_amount` double(15,2) DEFAULT NULL,
  `taxable_amount` double(20,2) DEFAULT NULL,
  `total` double(20,2) NOT NULL,
  `notes` longtext DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `financial_year_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `online_order_details`
--

CREATE TABLE `online_order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `tax_amount` double(20,2) DEFAULT NULL,
  `quantity` double(15,2) NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `item_name` varchar(191) NOT NULL,
  `rate` double(20,2) NOT NULL,
  `total` double(20,2) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `image` varchar(191) DEFAULT NULL,
  `stitching_cost` double(15,2) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_featured` int(11) DEFAULT 0,
  `description` longtext DEFAULT NULL,
  `item_code` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `image`, `stitching_cost`, `is_active`, `created_by`, `created_at`, `updated_at`, `is_featured`, `description`, `item_code`) VALUES
(1, 'Shirt', '/uploads/product/1717843686.jpg', 120.00, 1, 1, '2024-06-08 10:48:06', '2024-06-08 10:48:06', 0, '', '123');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `purchase_number` varchar(191) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `sub_total` double(15,2) DEFAULT NULL,
  `discount` double(15,2) DEFAULT NULL,
  `tax_percentage` double(15,2) DEFAULT NULL,
  `tax_amount` double(15,2) DEFAULT NULL,
  `total_quantity` double DEFAULT NULL,
  `service_charge` double(15,2) DEFAULT NULL,
  `total` double(15,2) DEFAULT NULL,
  `financial_year_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `purchase_type` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED DEFAULT NULL,
  `material_id` bigint(20) UNSIGNED DEFAULT NULL,
  `material_name` varchar(191) DEFAULT NULL,
  `material_unit` int(11) DEFAULT NULL,
  `purchase_quantity` double(15,2) DEFAULT NULL,
  `purchase_price` double(15,2) DEFAULT NULL,
  `tax_amount` double(15,2) DEFAULT NULL,
  `purchase_item_total` double(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_returns`
--

CREATE TABLE `purchase_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `purchase_id` bigint(20) UNSIGNED DEFAULT NULL,
  `purchase_return_number` varchar(191) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `debit_value` double(15,2) DEFAULT NULL,
  `return_quantity` int(11) NOT NULL,
  `financial_year_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return_details`
--

CREATE TABLE `purchase_return_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_return_id` bigint(20) UNSIGNED DEFAULT NULL,
  `material_id` bigint(20) UNSIGNED DEFAULT NULL,
  `material_name` varchar(191) DEFAULT NULL,
  `material_unit` int(11) DEFAULT NULL,
  `purchase_return_quantity` int(11) DEFAULT NULL,
  `purchase_return_price` double(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_returns`
--

CREATE TABLE `sales_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `sales_return_number` varchar(191) DEFAULT NULL,
  `customer_name` varchar(191) DEFAULT NULL,
  `customer_phone` varchar(191) DEFAULT NULL,
  `customer_address` varchar(191) DEFAULT NULL,
  `customer_file_number` varchar(191) DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `tax_type` int(11) DEFAULT NULL,
  `sub_total` double(20,2) DEFAULT NULL,
  `tax_percentage` double(15,2) DEFAULT NULL,
  `tax_amount` double(15,2) DEFAULT NULL,
  `taxable_amount` double(20,2) DEFAULT NULL,
  `total` double(20,2) NOT NULL,
  `total_quantity` int(11) DEFAULT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `financial_year_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `invoice_number` varchar(191) DEFAULT NULL,
  `discount` double(20,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_return_details`
--

CREATE TABLE `sales_return_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sales_return_id` bigint(20) UNSIGNED NOT NULL,
  `type` int(11) DEFAULT NULL,
  `tax_amount` double(20,2) DEFAULT NULL,
  `quantity` double(15,2) NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_detail_id` bigint(20) UNSIGNED NOT NULL,
  `item_name` varchar(191) NOT NULL,
  `rate` double(20,2) NOT NULL,
  `total` double(20,2) NOT NULL,
  `unit_type` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_return_payments`
--

CREATE TABLE `sales_return_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` datetime DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(191) DEFAULT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `paid_amount` double(15,2) NOT NULL DEFAULT 0.00,
  `note` longtext DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `sales_return_id` bigint(20) UNSIGNED DEFAULT NULL,
  `financial_year_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `voucher_no` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `image` varchar(191) NOT NULL,
  `url` varchar(191) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_adjustments`
--

CREATE TABLE `stock_adjustments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `total_items` bigint(20) DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_adjustment_details`
--

CREATE TABLE `stock_adjustment_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_adjustment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `material_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT 1,
  `unit` int(11) DEFAULT NULL,
  `quantity` double(20,2) DEFAULT NULL,
  `material_name` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfers`
--

CREATE TABLE `stock_transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` datetime NOT NULL,
  `warehouse_from` bigint(20) UNSIGNED DEFAULT NULL,
  `warehouse_to` bigint(20) UNSIGNED DEFAULT NULL,
  `total_quantity` double(15,2) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `financial_year_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total_items` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfer_details`
--

CREATE TABLE `stock_transfer_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_transfer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `material_id` bigint(20) UNSIGNED DEFAULT NULL,
  `material_name` varchar(191) DEFAULT NULL,
  `material_unit` int(11) DEFAULT NULL,
  `quantity` double(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `phone` varchar(191) NOT NULL,
  `tax_number` varchar(191) DEFAULT NULL,
  `supplier_address` varchar(191) DEFAULT NULL,
  `opening_balance` double(20,2) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_payments`
--

CREATE TABLE `supplier_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_name` varchar(191) DEFAULT NULL,
  `phone_number` varchar(191) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `paid_amount` double(15,2) DEFAULT NULL,
  `payment_mode` int(11) NOT NULL,
  `reference_number` longtext DEFAULT NULL,
  `financial_year_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `data` longtext NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `is_rtl` int(11) NOT NULL DEFAULT 0,
  `default` int(11) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `user_type` int(11) NOT NULL,
  `auth_token` longtext DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `avatar` varchar(191) DEFAULT NULL,
  `address` longtext DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 0,
  `parent_id` int(11) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `user_type`, `auth_token`, `phone`, `avatar`, `address`, `is_active`, `parent_id`, `created_by`, `created_at`, `updated_at`, `branch_id`) VALUES
(1, 'admin', 'admin@admin.com', NULL, '$2y$10$BYo7ykTKDJzY4paWJmVYtODPif0ZhSMrr6gQl7GOMtH/jT8tCpSWG', 2, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2024-05-29 17:31:25', '2024-05-29 17:31:26', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch_ledgers`
--
ALTER TABLE `branch_ledgers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_groups`
--
ALTER TABLE `customer_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_measurements`
--
ALTER TABLE `customer_measurements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_measurement_details`
--
ALTER TABLE `customer_measurement_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_payment_discounts`
--
ALTER TABLE `customer_payment_discounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_heads`
--
ALTER TABLE `expense_heads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `financial_years`
--
ALTER TABLE `financial_years`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_payments`
--
ALTER TABLE `invoice_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_settings`
--
ALTER TABLE `master_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `measurements`
--
ALTER TABLE `measurements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `measurement_attributes`
--
ALTER TABLE `measurement_attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `measurement_details`
--
ALTER TABLE `measurement_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_appointments`
--
ALTER TABLE `online_appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_customers`
--
ALTER TABLE `online_customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `online_customers_email_unique` (`email`);

--
-- Indexes for table `online_customer_measurements`
--
ALTER TABLE `online_customer_measurements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_customer_measurement_details`
--
ALTER TABLE `online_customer_measurement_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_orders`
--
ALTER TABLE `online_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_order_details`
--
ALTER TABLE `online_order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_return_details`
--
ALTER TABLE `purchase_return_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_returns`
--
ALTER TABLE `sales_returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_return_details`
--
ALTER TABLE `sales_return_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_return_payments`
--
ALTER TABLE `sales_return_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_adjustments`
--
ALTER TABLE `stock_adjustments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_adjustment_details`
--
ALTER TABLE `stock_adjustment_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_transfers`
--
ALTER TABLE `stock_transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_transfer_details`
--
ALTER TABLE `stock_transfer_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_payments`
--
ALTER TABLE `supplier_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `branch_ledgers`
--
ALTER TABLE `branch_ledgers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_groups`
--
ALTER TABLE `customer_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_measurements`
--
ALTER TABLE `customer_measurements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_measurement_details`
--
ALTER TABLE `customer_measurement_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_payment_discounts`
--
ALTER TABLE `customer_payment_discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_heads`
--
ALTER TABLE `expense_heads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `financial_years`
--
ALTER TABLE `financial_years`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `invoice_details`
--
ALTER TABLE `invoice_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `invoice_payments`
--
ALTER TABLE `invoice_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `master_settings`
--
ALTER TABLE `master_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `measurements`
--
ALTER TABLE `measurements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `measurement_attributes`
--
ALTER TABLE `measurement_attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `measurement_details`
--
ALTER TABLE `measurement_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_appointments`
--
ALTER TABLE `online_appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_customers`
--
ALTER TABLE `online_customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_customer_measurements`
--
ALTER TABLE `online_customer_measurements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_customer_measurement_details`
--
ALTER TABLE `online_customer_measurement_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_orders`
--
ALTER TABLE `online_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `online_order_details`
--
ALTER TABLE `online_order_details`
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_return_details`
--
ALTER TABLE `purchase_return_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_returns`
--
ALTER TABLE `sales_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_return_details`
--
ALTER TABLE `sales_return_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_return_payments`
--
ALTER TABLE `sales_return_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_adjustments`
--
ALTER TABLE `stock_adjustments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_adjustment_details`
--
ALTER TABLE `stock_adjustment_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_transfers`
--
ALTER TABLE `stock_transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_transfer_details`
--
ALTER TABLE `stock_transfer_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier_payments`
--
ALTER TABLE `supplier_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
