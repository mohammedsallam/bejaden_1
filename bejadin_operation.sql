-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2020 at 04:31 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bejadin_operation`
--

-- --------------------------------------------------------

--
-- Table structure for table `activitytypes`
--

CREATE TABLE `activitytypes` (
  `ID_No` int(10) UNSIGNED NOT NULL,
  `Actvty_No` int(11) DEFAULT NULL,
  `Name_Ar` varchar(50) DEFAULT NULL,
  `Name_En` varchar(50) DEFAULT NULL,
  `NofCmp` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activitytypes`
--

INSERT INTO `activitytypes` (`ID_No`, `Actvty_No`, `Name_Ar`, `Name_En`, `NofCmp`, `created_at`, `updated_at`) VALUES
(13, 1, 'مقاولات', 'مقاولات', NULL, '2019-12-24 10:23:41', '2019-12-24 10:23:41'),
(14, 2, 'صيانه و تشغيل', 'صيانه و تشغيل', NULL, '2019-12-24 10:23:49', '2019-12-24 10:23:49'),
(15, 3, 'عمره', 'عمره', NULL, '2019-12-24 10:23:55', '2019-12-24 10:23:55');

-- --------------------------------------------------------

--
-- Table structure for table `activity_type`
--

CREATE TABLE `activity_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `name_ar` varchar(191) NOT NULL,
  `name_en` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `branches_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `branches_id`, `company_id`, `remember_token`, `created_at`, `updated_at`, `image`) VALUES
(1, 'Sallam', 'admin@admin.com', '$2y$10$aR8mcx0gfVugvBZEoEIOBuhkBmNlYSnbYLo9whF6Lb5jXKB4.Czp.', 1, 1, 'sO1XU6H1zYcwyTDgAkIFpcWlcK2l08TDqhWelwy1favRUFHQX5Csz7F4R9zq', NULL, NULL, NULL),
(2, 'infosas', 'infosas2019@infosasics.com', '$2y$10$s2n7qt59H4VEVrLMU9RhGOFnzDaa1HzduodXxWzbeWRWFDCWhq8fu', 1, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `astcurncy`
--

CREATE TABLE `astcurncy` (
  `ID_No` int(10) UNSIGNED NOT NULL,
  `Curncy_No` int(11) DEFAULT NULL,
  `Curncy_NmAr` varchar(15) DEFAULT NULL,
  `Curncy_NmEn` varchar(15) DEFAULT NULL,
  `Curncy_Rate` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `astcurncy`
--

INSERT INTO `astcurncy` (`ID_No`, `Curncy_No`, `Curncy_NmAr`, `Curncy_NmEn`, `Curncy_Rate`, `created_at`, `updated_at`) VALUES
(1, 1, 'ريال سعودى', 'SR', 5.00, NULL, NULL),
(2, 2, 'دولار', 'Dollar', 16.00, NULL, NULL),
(3, 3, 'يورو', 'Euro', 20.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `astmarket`
--

CREATE TABLE `astmarket` (
  `ID_No` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `Mrkt_No` int(11) DEFAULT NULL,
  `Brn_No` int(11) DEFAULT NULL,
  `Mrkt_NmEn` varchar(191) DEFAULT NULL,
  `Mrkt_NmAr` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `astmarket`
--

INSERT INTO `astmarket` (`ID_No`, `created_at`, `updated_at`, `Mrkt_No`, `Brn_No`, `Mrkt_NmEn`, `Mrkt_NmAr`) VALUES
(3, '2019-12-18 07:24:27', '2019-12-18 07:24:27', 1, 2, 'Ali Mahmoud Ali', 'على محمود على'),
(4, '2019-12-18 07:25:00', '2019-12-18 07:25:00', 2, 4, 'Mohamed AbdElhamed Hamed', 'محمد عبد الحميد حامد');

-- --------------------------------------------------------

--
-- Table structure for table `astsalesman`
--

CREATE TABLE `astsalesman` (
  `ID_No` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `Slm_No` int(11) DEFAULT NULL,
  `Brn_No` int(11) DEFAULT NULL,
  `Mark_No` int(11) DEFAULT NULL,
  `StoreNo` int(11) DEFAULT NULL,
  `Slm_NmEn` varchar(191) DEFAULT NULL,
  `Slm_NmAr` varchar(191) DEFAULT NULL,
  `Target` decimal(8,2) DEFAULT NULL,
  `Slm_Tel` varchar(20) DEFAULT NULL,
  `Slm_Active` tinyint(1) DEFAULT NULL,
  `Opn_Date` date DEFAULT NULL,
  `Opn_Time` datetime DEFAULT NULL,
  `User_ID` varchar(191) DEFAULT NULL,
  `Updt_Date` date DEFAULT NULL,
  `Cmp_No` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `astsalesman`
--

INSERT INTO `astsalesman` (`ID_No`, `created_at`, `updated_at`, `Slm_No`, `Brn_No`, `Mark_No`, `StoreNo`, `Slm_NmEn`, `Slm_NmAr`, `Target`, `Slm_Tel`, `Slm_Active`, `Opn_Date`, `Opn_Time`, `User_ID`, `Updt_Date`, `Cmp_No`) VALUES
(3, '2019-12-18 07:19:42', '2019-12-18 07:19:42', 1, 2, NULL, 2, 'Ahmed Mohamed Ali', 'احمد محمد على', '500000.00', '01001246546', 1, NULL, NULL, NULL, NULL, 2),
(4, '2019-12-18 07:20:18', '2019-12-18 07:20:18', 2, 4, NULL, 4, 'Mahmoud Allam', 'محمود علام', '500000.00', '01001246546', NULL, NULL, NULL, NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `astsupctgs`
--

CREATE TABLE `astsupctgs` (
  `ID_No` int(10) UNSIGNED NOT NULL,
  `Supctg_No` int(11) DEFAULT NULL,
  `Supctg_Nmar` varchar(191) DEFAULT NULL,
  `Supctg_Nmen` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `astsupctgs`
--

INSERT INTO `astsupctgs` (`ID_No`, `Supctg_No`, `Supctg_Nmar`, `Supctg_Nmen`, `created_at`, `updated_at`) VALUES
(1, 1, 'class A', 'class A', '2019-12-09 10:17:43', '2019-12-09 10:17:43');

-- --------------------------------------------------------

--
-- Table structure for table `blog_entries`
--

CREATE TABLE `blog_entries` (
  `id` int(10) UNSIGNED NOT NULL,
  `blog` varchar(191) NOT NULL DEFAULT 'main',
  `publish_after` timestamp NULL DEFAULT NULL,
  `slug` varchar(191) NOT NULL,
  `title` varchar(191) NOT NULL,
  `author_name` varchar(191) DEFAULT NULL,
  `author_email` varchar(191) DEFAULT NULL,
  `author_url` varchar(191) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `content` text NOT NULL,
  `summary` text DEFAULT NULL,
  `page_title` varchar(191) DEFAULT NULL,
  `description` varchar(191) DEFAULT NULL,
  `meta_tags` text DEFAULT NULL,
  `display_full_content_in_feed` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(10) UNSIGNED NOT NULL,
  `name_ar` varchar(191) NOT NULL,
  `name_en` varchar(191) NOT NULL,
  `addriss` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `name_ar`, `name_en`, `addriss`, `created_at`, `updated_at`) VALUES
(1, 'الفرع الرئيسى', 'Personal Branche', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `branche_employee`
--

CREATE TABLE `branche_employee` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `branche_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(10) UNSIGNED NOT NULL,
  `city_name_ar` varchar(191) NOT NULL,
  `city_name_en` varchar(191) NOT NULL,
  `country_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `contractors`
--

CREATE TABLE `contractors` (
  `id` int(10) UNSIGNED NOT NULL,
  `name_ar` varchar(191) DEFAULT NULL,
  `name_en` varchar(191) DEFAULT NULL,
  `contractor_type_id` int(10) UNSIGNED DEFAULT NULL,
  `address` text DEFAULT NULL,
  `tree_id` int(10) UNSIGNED DEFAULT NULL,
  `operation_id` int(10) UNSIGNED NOT NULL DEFAULT 10,
  `country_id` int(10) UNSIGNED DEFAULT NULL,
  `currency` varchar(191) DEFAULT NULL,
  `credit_limit` varchar(191) DEFAULT NULL,
  `account_number` int(11) DEFAULT NULL,
  `debtor` int(11) NOT NULL DEFAULT 0,
  `creditor` int(11) NOT NULL DEFAULT 0,
  `status` varchar(191) NOT NULL DEFAULT '2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `contractors_types`
--

CREATE TABLE `contractors_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name_ar` varchar(191) NOT NULL,
  `name_en` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `id` int(10) UNSIGNED NOT NULL,
  `section_id` int(10) UNSIGNED DEFAULT NULL,
  `date` varchar(191) DEFAULT NULL,
  `higri_date` varchar(191) DEFAULT NULL,
  `project_id` int(10) UNSIGNED DEFAULT NULL,
  `contractor_id` int(10) UNSIGNED DEFAULT NULL,
  `Contract_reference` int(11) DEFAULT NULL,
  `contract_number` int(11) DEFAULT NULL,
  `subscriber_id` int(10) UNSIGNED DEFAULT NULL,
  `statement_ar` varchar(191) DEFAULT NULL,
  `statement_en` varchar(191) DEFAULT NULL,
  `contract_date` varchar(191) DEFAULT NULL,
  `contract_start` varchar(191) DEFAULT NULL,
  `contract_end` varchar(191) DEFAULT NULL,
  `contract_period` varchar(191) DEFAULT NULL,
  `implementation_start` varchar(191) DEFAULT NULL,
  `implementation_end` varchar(191) DEFAULT NULL,
  `warranty_start` varchar(191) DEFAULT NULL,
  `warranty_end` varchar(191) DEFAULT NULL,
  `employees_number` int(11) DEFAULT NULL,
  `employee_hour_work` int(11) DEFAULT NULL,
  `months_number` int(11) DEFAULT NULL,
  `monthly_payment` int(11) DEFAULT NULL,
  `contract_value` int(11) DEFAULT NULL,
  `estimated_value` int(11) DEFAULT NULL,
  `deviation_value` int(11) DEFAULT NULL,
  `downpayment` int(11) DEFAULT NULL,
  `warranty_expenses` int(11) DEFAULT NULL,
  `insurance_value` int(11) DEFAULT NULL,
  `contract_value_customer` int(11) DEFAULT NULL,
  `subcontracts_value` int(11) DEFAULT NULL,
  `total_payments` int(11) DEFAULT NULL,
  `current_balance` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `country_name_ar` varchar(191) NOT NULL,
  `country_name_en` varchar(191) NOT NULL,
  `mob` varchar(191) DEFAULT NULL,
  `code` varchar(191) DEFAULT NULL,
  `logo` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country_name_ar`, `country_name_en`, `mob`, `code`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'السعوديه', 'saudi arabia', '0020', '20', 'https://cdn3.volusion.com/jhqje.emawp/v/vspfiles/photos/Saudi-Arabia-Flag-2.gif?1355398483', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(10) UNSIGNED NOT NULL,
  `branch_id` int(10) UNSIGNED DEFAULT NULL,
  `dep_name_ar` varchar(191) NOT NULL,
  `dep_name_en` varchar(191) NOT NULL,
  `code` varchar(191) DEFAULT NULL,
  `levelType` enum('1','2','3','4') NOT NULL DEFAULT '1',
  `level_id` int(10) UNSIGNED DEFAULT NULL,
  `type` enum('0','1') DEFAULT NULL,
  `status` enum('0','1') DEFAULT NULL,
  `category` enum('0','1') DEFAULT NULL,
  `operation_id` int(10) UNSIGNED DEFAULT NULL,
  `cc_id` int(10) UNSIGNED DEFAULT NULL,
  `cc_type` varchar(191) NOT NULL DEFAULT '0',
  `budget` enum('0','1','2','3') DEFAULT NULL,
  `creditor` varchar(191) NOT NULL DEFAULT '0',
  `debtor` varchar(191) NOT NULL DEFAULT '0',
  `estimite` varchar(191) DEFAULT NULL,
  `description` varchar(191) DEFAULT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(10) UNSIGNED NOT NULL,
  `name_ar` varchar(191) NOT NULL,
  `name_en` varchar(191) NOT NULL,
  `beginning_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `renew_date` date DEFAULT NULL,
  `salary_type` enum('0','1') DEFAULT NULL,
  `salary` varchar(191) DEFAULT NULL,
  `transition_allowance` varchar(191) DEFAULT NULL,
  `housing_allowance` varchar(191) DEFAULT NULL,
  `food_allowance` varchar(191) DEFAULT NULL,
  `other_allowances` varchar(191) DEFAULT NULL,
  `work_type` enum('0','1','2','3') DEFAULT NULL,
  `number_rest` varchar(191) DEFAULT NULL,
  `work_status` enum('0','1','2') DEFAULT NULL,
  `payment_methods` enum('0','1','2') DEFAULT NULL,
  `workhour_count` varchar(191) DEFAULT NULL,
  `hour_payment` varchar(191) DEFAULT NULL,
  `employee_ticket` varchar(191) DEFAULT NULL,
  `ticket_class` varchar(191) DEFAULT NULL,
  `children_ticket` varchar(191) DEFAULT NULL,
  `sales_officer` tinyint(4) NOT NULL DEFAULT 0,
  `sales_number` int(11) DEFAULT NULL,
  `percentage` varchar(191) DEFAULT NULL,
  `branches_id` int(10) UNSIGNED DEFAULT NULL,
  `companybanks_id` int(10) UNSIGNED DEFAULT NULL,
  `company_banks_num` varchar(191) DEFAULT NULL,
  `employeebanks_id` int(10) UNSIGNED DEFAULT NULL,
  `employee_banks_num` varchar(191) DEFAULT NULL,
  `employee_banks_branches` varchar(191) DEFAULT NULL,
  `debtor` varchar(191) NOT NULL DEFAULT '0',
  `creditor` varchar(191) NOT NULL DEFAULT '0',
  `accounts_receivable` varchar(191) DEFAULT NULL,
  `tree_id` int(10) UNSIGNED DEFAULT NULL,
  `operation_id` int(10) UNSIGNED NOT NULL DEFAULT 5,
  `status` varchar(191) NOT NULL DEFAULT '1',
  `statusreport` varchar(191) NOT NULL DEFAULT '3',
  `cc_id` int(10) UNSIGNED DEFAULT NULL,
  `cc_type` varchar(191) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `size` varchar(191) NOT NULL,
  `file` varchar(191) NOT NULL,
  `path` varchar(191) NOT NULL,
  `full_file` varchar(191) NOT NULL,
  `mime_type` varchar(191) NOT NULL,
  `file_type` varchar(191) NOT NULL,
  `relation_id` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `glaccbnk`
--

CREATE TABLE `glaccbnk` (
  `Cmp_No` int(11) DEFAULT NULL,
  `ID_No` int(10) UNSIGNED NOT NULL,
  `Ln_No` int(11) DEFAULT NULL,
  `Acc_No` bigint(20) DEFAULT NULL,
  `Acc_NmAr` varchar(50) DEFAULT NULL,
  `Acc_NmEn` varchar(50) DEFAULT NULL,
  `Acc_Bank_No` varchar(15) DEFAULT NULL,
  `RcpCsh_Voucher` int(11) DEFAULT 0,
  `RcpChk_Voucher` int(11) DEFAULT 0,
  `PymCsh_voucher` int(11) DEFAULT 0,
  `PymChk_Voucher` int(11) DEFAULT 0,
  `Cash_Rpt` int(11) DEFAULT 0,
  `DB_Note` int(11) DEFAULT 0,
  `CR_Note` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `glaccbnk`
--

INSERT INTO `glaccbnk` (`Cmp_No`, `ID_No`, `Ln_No`, `Acc_No`, `Acc_NmAr`, `Acc_NmEn`, `Acc_Bank_No`, `RcpCsh_Voucher`, `RcpChk_Voucher`, `PymCsh_voucher`, `PymChk_Voucher`, `Cash_Rpt`, `DB_Note`, `CR_Note`, `created_at`, `updated_at`) VALUES
(2, 12, NULL, 1010101, 'الصندوق الرئيسى', 'الصندوق الرئيسى', NULL, 1, 1, 1, 1, 0, 0, 0, '2019-12-16 09:27:15', '2019-12-16 09:27:15'),
(2, 13, NULL, 1010201, 'البنك الراجحي', 'البنك الراجحي', NULL, 1, 1, 1, 1, 0, 0, 0, '2019-12-16 09:27:29', '2019-12-16 09:27:29'),
(2, 14, NULL, 1010202, 'البنك الاهلي', 'البنك الاهلي', NULL, 1, 1, 1, 1, 0, 0, 0, '2019-12-16 09:27:41', '2019-12-16 09:27:41'),
(2, 16, NULL, 1010203, 'بنك البلاد', 'بنك البلاد', NULL, 1, 1, 1, 1, 0, 0, 0, '2019-12-31 08:43:31', '2019-12-31 08:43:31');

-- --------------------------------------------------------

--
-- Table structure for table `glastjrntyp`
--

CREATE TABLE `glastjrntyp` (
  `ID_NO` int(10) UNSIGNED NOT NULL,
  `Jr_Ty` bigint(20) DEFAULT NULL,
  `Jrty_NmAr` varchar(30) DEFAULT NULL,
  `Jrty_NmEn` varchar(30) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `glastjrntyp`
--

INSERT INTO `glastjrntyp` (`ID_NO`, `Jr_Ty`, `Jrty_NmAr`, `Jrty_NmEn`, `active`, `created_at`, `updated_at`) VALUES
(1, 1, 'قيد إفتتاحى', 'Open JV', 1, '2020-01-04 11:27:32', '2020-01-04 12:32:28'),
(2, 2, 'قبض نقدى', 'Recipet Voucher', 1, '2020-01-04 11:31:08', '2020-01-04 12:32:30'),
(3, 3, 'قبض شيك', 'Recipet Voucher', 1, '2020-01-04 11:31:16', '2020-01-04 12:32:30'),
(4, 4, 'صرف نقدى', 'Payment Cash', 1, '2020-01-04 12:13:26', '2020-01-04 12:32:31'),
(5, 5, 'صرف شيك', 'Cheque Voucher', 1, '2020-01-04 12:29:33', '2020-01-04 12:32:31'),
(6, 6, 'قيد يومية', 'Journal Voucher', 1, '2020-01-04 12:29:42', '2020-01-04 12:32:32'),
(7, 7, 'مبيعات اجله', 'Credit Sales', 1, '2020-01-04 12:29:52', '2020-01-04 12:32:33'),
(8, 11, 'مشتريات اجله', 'Credit Purchase', 1, '2020-01-04 12:30:06', '2020-01-04 12:32:34'),
(9, 16, 'تسوية بالمخازن', 'Invt Adgustment', 1, '2020-01-04 12:30:16', '2020-01-04 12:32:34'),
(11, 17, 'تحويل بضاعة', 'Trnsfr Branch', 1, '2020-01-04 12:30:53', '2020-01-04 12:32:34'),
(12, 18, 'قيد إعتماد', 'LC. JV', 1, '2020-01-04 12:31:09', '2020-01-04 12:32:42'),
(13, 19, 'تكلفة بضاعة مباعة', 'Sales Cost', 1, '2020-01-04 12:31:20', '2020-01-04 12:32:43'),
(14, 14, 'مرتجع مشتريات نقدية', 'Cash Return Purchase', 1, '2020-01-04 12:31:29', '2020-01-04 12:32:43'),
(15, 15, 'إشعار دائن/مدين', 'Credit/Debit Note', 1, '2020-01-04 12:31:40', '2020-01-04 12:32:44'),
(16, 20, 'إهلاك الآصول', 'Assets Dep.', 1, '2020-01-04 12:31:57', '2020-01-04 12:32:44'),
(17, 8, 'مرتجع مبيعات آجلة', 'Credit Sales Return ', 1, '2020-01-04 12:31:57', '2020-01-04 12:32:44'),
(18, 9, 'مبيعات نقدية', 'Cash Sales ', 1, '2020-01-04 12:31:57', '2020-01-04 12:32:44'),
(19, 10, 'مرتجع مبيعات نقدية', 'Cash Sales ', 1, '2020-01-04 12:31:57', '2020-01-04 12:32:44'),
(20, 12, 'مرتجع مشتريات آجلة', 'Cash Sales ', 1, '2020-01-04 12:31:57', '2020-01-04 12:32:44'),
(21, 13, 'مشتريات نقدية', 'Cash Purchase', 1, '2020-01-04 12:31:57', '2020-01-04 12:32:44');

-- --------------------------------------------------------

--
-- Table structure for table `glccs`
--

CREATE TABLE `glccs` (
  `id` int(10) UNSIGNED NOT NULL,
  `branch_id` int(10) UNSIGNED DEFAULT NULL,
  `name_ar` varchar(191) NOT NULL,
  `name_en` varchar(191) NOT NULL,
  `code` varchar(191) DEFAULT NULL,
  `level_id` int(10) UNSIGNED DEFAULT NULL,
  `levelType` enum('1','2','3','4') NOT NULL DEFAULT '2',
  `type` enum('0','1') DEFAULT NULL,
  `status` enum('0','1') DEFAULT NULL,
  `creditor` varchar(191) NOT NULL DEFAULT '0',
  `debtor` varchar(191) NOT NULL DEFAULT '0',
  `estimite` varchar(191) DEFAULT NULL,
  `description` varchar(191) DEFAULT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gljrnal`
--

CREATE TABLE `gljrnal` (
  `ID_No` int(10) UNSIGNED NOT NULL,
  `Cmp_No` int(11) DEFAULT NULL,
  `Brn_No` int(11) DEFAULT NULL,
  `Jr_Ty` int(11) DEFAULT NULL,
  `Tr_No` bigint(20) DEFAULT NULL,
  `Month_No` int(11) DEFAULT NULL,
  `Month_Jvno` int(11) DEFAULT NULL,
  `Doc_Type` enum('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16') DEFAULT NULL,
  `Tr_Dt` datetime DEFAULT NULL,
  `Tr_DtAr` varchar(191) DEFAULT NULL,
  `Chq_no` varchar(191) DEFAULT NULL,
  `Bnk_Nm` varchar(191) DEFAULT NULL,
  `Issue_Dt` datetime DEFAULT NULL,
  `Due_Issue_Dt` datetime DEFAULT NULL,
  `Acc_No` bigint(20) DEFAULT NULL,
  `Rcpt_By` varchar(191) DEFAULT NULL,
  `Pymt_To` varchar(191) DEFAULT NULL,
  `Pymt_By` varchar(191) DEFAULT NULL,
  `Jv_Post` tinyint(1) DEFAULT NULL,
  `User_ID` varchar(191) DEFAULT NULL,
  `Entr_Dt` varchar(191) DEFAULT NULL,
  `Entr_Time` varchar(191) DEFAULT NULL,
  `Ac_Ty` int(11) DEFAULT NULL,
  `Cstm_No` bigint(20) DEFAULT NULL,
  `Sup_No` bigint(20) DEFAULT NULL,
  `Emp_No` bigint(20) DEFAULT NULL,
  `Chrt_No` bigint(20) DEFAULT NULL,
  `Tr_Db` double(50,10) DEFAULT NULL,
  `Tr_Cr` double(50,10) DEFAULT NULL,
  `Curncy_No` int(11) DEFAULT NULL,
  `Curncy_Rate` float(50,10) DEFAULT NULL,
  `Taxp_Extra` float(50,10) DEFAULT NULL,
  `Taxv_Extra` float(50,10) DEFAULT NULL,
  `Tot_Amunt` double(50,10) DEFAULT NULL,
  `Crnt_Blnc` double(50,10) DEFAULT NULL,
  `Tr_Ds` varchar(200) DEFAULT NULL,
  `Tr_Ds1` varchar(200) DEFAULT NULL,
  `Dc_No` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `FTot_Amunt` float(50,10) DEFAULT NULL,
  `Slm_No` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gljrnal`
--

INSERT INTO `gljrnal` (`ID_No`, `Cmp_No`, `Brn_No`, `Jr_Ty`, `Tr_No`, `Month_No`, `Month_Jvno`, `Doc_Type`, `Tr_Dt`, `Tr_DtAr`, `Chq_no`, `Bnk_Nm`, `Issue_Dt`, `Due_Issue_Dt`, `Acc_No`, `Rcpt_By`, `Pymt_To`, `Pymt_By`, `Jv_Post`, `User_ID`, `Entr_Dt`, `Entr_Time`, `Ac_Ty`, `Cstm_No`, `Sup_No`, `Emp_No`, `Chrt_No`, `Tr_Db`, `Tr_Cr`, `Curncy_No`, `Curncy_Rate`, `Taxp_Extra`, `Taxv_Extra`, `Tot_Amunt`, `Crnt_Blnc`, `Tr_Ds`, `Tr_Ds1`, `Dc_No`, `created_at`, `updated_at`, `status`, `FTot_Amunt`, `Slm_No`) VALUES
(25, 2, 2, 6, 122101, 1, NULL, NULL, '2020-01-11 00:00:00', '1441-05-16', NULL, NULL, NULL, NULL, 10103, NULL, NULL, NULL, NULL, '1', '2020-01-11', '15:48:21', 1, NULL, NULL, NULL, 1010309, 500.0000000000, 500.0000000000, 1, 5.0000000000, NULL, NULL, NULL, NULL, 'سطر1', NULL, 12, '2020-01-11 13:48:21', '2020-01-11 13:48:21', 0, NULL, NULL),
(26, 2, 2, 2, 1, 1, 1, '1', '2020-01-11 00:00:00', '1441-05-16', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 20201, '', NULL, NULL, NULL, '1', '2020-01-11', '15:51:48', 1, NULL, NULL, NULL, 2020101, 500.0000000000, 500.0000000000, 1, 5.0000000000, NULL, 0.0000000000, 500.0000000000, NULL, 'سطر1', 'سطر1', 0, '2020-01-11 13:51:48', '2020-01-11 13:51:48', 0, 100.0000000000, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gljrntrs`
--

CREATE TABLE `gljrntrs` (
  `ID_No` int(10) UNSIGNED NOT NULL,
  `Cmp_No` int(11) DEFAULT NULL,
  `Brn_No` int(11) DEFAULT NULL,
  `Jr_Ty` int(11) DEFAULT NULL,
  `Tr_No` varchar(200) DEFAULT NULL,
  `Ln_No` int(11) DEFAULT NULL,
  `Month_No` int(11) DEFAULT NULL,
  `Month_Jvno` int(11) DEFAULT NULL,
  `Tr_Dt` datetime DEFAULT NULL,
  `Tr_DtAr` varchar(191) DEFAULT NULL,
  `Ac_Ty` enum('1','2','3','4','5','6','7') DEFAULT NULL,
  `Sysub_Account` bigint(20) DEFAULT NULL,
  `Acc_No` bigint(20) DEFAULT NULL,
  `Tr_Db` double(8,2) DEFAULT NULL,
  `Tr_Cr` double(8,2) DEFAULT NULL,
  `Dc_No` varchar(191) DEFAULT NULL,
  `Tr_Ds` varchar(200) DEFAULT NULL,
  `Slm_No` int(11) DEFAULT NULL,
  `Tr_Ds1` varchar(200) DEFAULT NULL,
  `Clsacc_no1` bigint(20) DEFAULT NULL,
  `Clsacc_no2` bigint(20) DEFAULT NULL,
  `Costcntr_No` bigint(20) DEFAULT NULL,
  `Doc_Type` enum('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16') DEFAULT NULL,
  `Curncy_No` int(11) DEFAULT NULL,
  `GL_Post` tinyint(1) DEFAULT NULL,
  `JV_Post` tinyint(1) DEFAULT NULL,
  `User_ID` varchar(191) DEFAULT NULL,
  `Entr_Dt` varchar(191) DEFAULT NULL,
  `Entr_Time` varchar(191) DEFAULT NULL,
  `Acc_Type` int(11) DEFAULT NULL,
  `Rcpt_Value` double(8,2) DEFAULT NULL,
  `RetPur_Sal` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `FTot_Amunt` float(50,10) DEFAULT NULL,
  `FTr_Db` float(50,10) DEFAULT NULL,
  `FTr_Cr` float(50,10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gljrntrs`
--

INSERT INTO `gljrntrs` (`ID_No`, `Cmp_No`, `Brn_No`, `Jr_Ty`, `Tr_No`, `Ln_No`, `Month_No`, `Month_Jvno`, `Tr_Dt`, `Tr_DtAr`, `Ac_Ty`, `Sysub_Account`, `Acc_No`, `Tr_Db`, `Tr_Cr`, `Dc_No`, `Tr_Ds`, `Slm_No`, `Tr_Ds1`, `Clsacc_no1`, `Clsacc_no2`, `Costcntr_No`, `Doc_Type`, `Curncy_No`, `GL_Post`, `JV_Post`, `User_ID`, `Entr_Dt`, `Entr_Time`, `Acc_Type`, `Rcpt_Value`, `RetPur_Sal`, `created_at`, `updated_at`, `FTot_Amunt`, `FTr_Db`, `FTr_Cr`) VALUES
(56, 2, 2, 6, '122101', 1, 1, 122101, '2020-01-11 00:00:00', '1441-05-16', '1', 1010309, 10103, 500.00, 0.00, '12', 'سطر1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '2020-01-11', '15:48:21', NULL, 500.00, NULL, '2020-01-11 13:48:21', '2020-01-11 13:48:21', 100.0000000000, 100.0000000000, 0.0000000000),
(57, 2, 2, 6, '122101', 2, 1, 122101, '2020-01-11 00:00:00', '1441-05-16', '1', 1010501, 10103, 0.00, 500.00, '12', 'سطر2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '2020-01-11', '15:48:21', NULL, 500.00, NULL, '2020-01-11 13:48:21', '2020-01-11 13:48:21', 100.0000000000, 0.0000000000, 100.0000000000),
(58, 2, 2, 2, '1', 1, 1, 1, '2020-01-11 00:00:00', '1441-05-16', '1', 0, 1010101, 500.00, 0.00, '', 'سطر1', NULL, 'سطر1', NULL, NULL, NULL, '1', 1, NULL, NULL, '1', '2020-01-11', '15:51:48', NULL, 500.00, NULL, '2020-01-11 13:51:48', '2020-01-11 13:51:48', 100.0000000000, 100.0000000000, 0.0000000000),
(59, 2, 2, 2, '1', 2, 1, 1, '2020-01-11 00:00:00', '1441-05-16', '1', 2020101, 20201, 0.00, 500.00, '', 'سطر1', NULL, '', NULL, NULL, NULL, '1', NULL, NULL, NULL, '1', '2020-01-11', '15:51:48', NULL, 500.00, NULL, '2020-01-11 13:51:48', '2020-01-11 13:51:48', 100.0000000000, 0.0000000000, 100.0000000000);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` enum('1','2','3','4') DEFAULT NULL,
  `name_ar` varchar(191) DEFAULT NULL,
  `name_en` varchar(191) DEFAULT NULL,
  `format` varchar(191) DEFAULT NULL,
  `length` int(11) DEFAULT NULL,
  `levelId` int(11) DEFAULT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`id`, `type`, `name_ar`, `name_en`, `format`, `length`, `levelId`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, '1', 'المستوي الأول', 'first level', '1', 1, 1, NULL, NULL, NULL),
(2, '1', 'المستوي الثاني', 'second level', '101', 2, 2, 1, NULL, NULL),
(3, '1', 'المستوي الثالث', 'third level', '10101', 2, 3, 2, NULL, NULL),
(4, '1', 'المستوي الرابع', 'fourth level', '1010101', 2, 4, 3, NULL, NULL),
(5, '1', 'المستوي الخامس', 'fifth level', '101010101', 2, 5, 4, NULL, NULL),
(6, '1', 'المستوي السادس', 'sixth level', '10101010101', 2, 6, 5, NULL, NULL),
(7, '1', 'المستوي السابع', 'seventh level', '1010101010101', 2, 7, 6, NULL, NULL),
(8, '2', 'المستوي الأول', 'first level', '1', 1, 1, NULL, NULL, NULL),
(9, '2', 'المستوي الثاني', 'second level', '101', 2, 2, 8, NULL, NULL),
(10, '2', 'المستوي الثالث', 'third level', '10101', 2, 3, 9, NULL, NULL),
(11, '3', 'المستوي الأول', 'first level', '1', 1, 1, NULL, NULL, NULL),
(12, '3', 'المستوي الثاني', 'second level', '101', 2, 2, 11, NULL, NULL),
(13, '3', 'المستوي الثالث', 'third level', '10101', 2, 3, 12, NULL, NULL),
(14, '4', 'المستوي الأول', 'first level', '1', 1, 1, NULL, NULL, NULL),
(15, '4', 'المستوي الثاني', 'second level', '101', 2, 2, 14, NULL, NULL),
(16, '4', 'المستوي الثالث', 'third level', '10101', 2, 3, 15, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `limitationreceipts`
--

CREATE TABLE `limitationreceipts` (
  `id` int(10) UNSIGNED NOT NULL,
  `name_ar` varchar(191) DEFAULT NULL,
  `name_en` varchar(191) DEFAULT NULL,
  `limitationReceiptsId` varchar(191) DEFAULT NULL,
  `type` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `limitationreceipts`
--

INSERT INTO `limitationreceipts` (`id`, `name_ar`, `name_en`, `limitationReceiptsId`, `type`, `created_at`, `updated_at`) VALUES
(1, 'سند قبض نقدي', 'receipts in Cash', '0', '0', NULL, NULL),
(2, 'سند قبض شيك', 'receipts in check', '1', '0', NULL, NULL),
(3, 'سند صرف نقدي', 'receipts out cash', '2', '0', NULL, NULL),
(4, 'سند صرف شيك', 'receipts out check', '3', '0', NULL, NULL),
(5, 'قيد يوميه', 'daily', '0', '1', NULL, NULL),
(6, 'اشعار مدين', 'Notice Debt', '1', '1', NULL, NULL),
(7, 'اشعار دائن', 'Notice Creditor', '2', '1', NULL, NULL),
(8, 'فاتورة المبيعات', 'sales', '3', '1', NULL, NULL),
(9, 'فاتورة المشتريات', 'purchases', '4', '1', NULL, NULL),
(10, 'ايراد مستحق', 'Revenue Payable', '5', '1', NULL, NULL),
(11, 'صرف مواد', 'Exchange Of Materials', '6', '1', NULL, NULL),
(12, 'قيد افتتاحي', 'Opening Entry', '0', '2', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `limitations`
--

CREATE TABLE `limitations` (
  `id` int(10) UNSIGNED NOT NULL,
  `limitationId` int(11) DEFAULT NULL,
  `branche_id` int(10) UNSIGNED DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `limitationsType_id` int(10) UNSIGNED DEFAULT NULL,
  `invoice_id` varchar(191) DEFAULT NULL,
  `status` varchar(191) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `limitations_datas`
--

CREATE TABLE `limitations_datas` (
  `id` int(10) UNSIGNED NOT NULL,
  `debtor` varchar(191) NOT NULL DEFAULT '0',
  `creditor` varchar(191) NOT NULL DEFAULT '0',
  `invoice_id` varchar(191) DEFAULT NULL,
  `limitations_id` int(10) UNSIGNED DEFAULT NULL,
  `status` varchar(191) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `limitations_data_types`
--

CREATE TABLE `limitations_data_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `limitations_type_id` int(10) UNSIGNED DEFAULT NULL,
  `limitations_data_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `limitations_type`
--

CREATE TABLE `limitations_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `name_ar` varchar(191) DEFAULT NULL,
  `name_en` varchar(191) DEFAULT NULL,
  `tree_id` int(10) UNSIGNED DEFAULT NULL,
  `operation_id` int(10) UNSIGNED DEFAULT NULL,
  `limitations_id` int(10) UNSIGNED DEFAULT NULL,
  `cc_id` int(10) UNSIGNED DEFAULT NULL,
  `relation_id` varchar(191) DEFAULT NULL,
  `debtor` varchar(191) NOT NULL DEFAULT '0',
  `creditor` varchar(191) NOT NULL DEFAULT '0',
  `note` varchar(191) DEFAULT NULL,
  `note_en` varchar(191) DEFAULT NULL,
  `status` varchar(191) NOT NULL DEFAULT '0',
  `invoice_id` varchar(191) DEFAULT NULL,
  `receipt_number` varchar(191) DEFAULT NULL,
  `month_for` enum('1','2','3','4','5','6','7','8','9','10','11','12') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mainbranch`
--

CREATE TABLE `mainbranch` (
  `ID_No` int(10) UNSIGNED NOT NULL,
  `Cmp_No` int(11) DEFAULT NULL,
  `Brn_No` int(11) DEFAULT NULL,
  `Cmp_Actvty_No` int(11) DEFAULT NULL,
  `Main_Brn` int(11) DEFAULT NULL,
  `Dlv_Stor` int(11) DEFAULT NULL,
  `Actvty_No` tinyint(1) DEFAULT NULL,
  `Isue_Alinvc` tinyint(1) DEFAULT NULL,
  `Br_Ty` tinyint(1) DEFAULT NULL,
  `Brn_NmEn` varchar(191) DEFAULT NULL,
  `Brn_NmAr` varchar(191) DEFAULT NULL,
  `Brn_Tel` varchar(191) DEFAULT NULL,
  `Brn_Adrs` varchar(191) DEFAULT NULL,
  `Brn_Email` varchar(191) DEFAULT NULL,
  `Brn_Fax` varchar(191) DEFAULT NULL,
  `Acc_Cashier` bigint(20) DEFAULT NULL,
  `Acc_Customer` bigint(20) DEFAULT NULL,
  `Acc_Suplier` bigint(20) DEFAULT NULL,
  `Acc_CrdSal` bigint(20) DEFAULT NULL,
  `Acc_CshSal` bigint(20) DEFAULT NULL,
  `Acc_RetSal` bigint(20) DEFAULT NULL,
  `Acc_DiscSal` bigint(20) DEFAULT NULL,
  `Acc_CrdPur` bigint(20) DEFAULT NULL,
  `Acc_CshPur` bigint(20) DEFAULT NULL,
  `Acc_RetPur` bigint(20) DEFAULT NULL,
  `Acc_DiscPur` bigint(20) DEFAULT NULL,
  `DlyPst_CshSal` tinyint(1) DEFAULT 0,
  `DlyPst_CshPur` tinyint(1) DEFAULT 0,
  `Adv_SalAcc` bigint(20) DEFAULT NULL,
  `Adv_RetSalAcc` bigint(20) DEFAULT NULL,
  `Inv_Prdctn` double(8,2) DEFAULT NULL,
  `Inv_Undprs` double(8,2) DEFAULT NULL,
  `Inv_RM` double(8,2) DEFAULT NULL,
  `Cost_INVt` bigint(20) DEFAULT NULL,
  `Cost_SalInvt` bigint(20) DEFAULT NULL,
  `Acc_Invtry` bigint(20) DEFAULT NULL,
  `Acc_InvAdj` bigint(20) DEFAULT NULL,
  `Acc_TaxExtraDb` bigint(20) DEFAULT NULL,
  `Acc_TaxExtraCR` bigint(20) DEFAULT NULL,
  `Acc_DBEmp` bigint(20) DEFAULT NULL,
  `Acc_LonesEmp` bigint(20) DEFAULT NULL,
  `Rcpt_Flg` tinyint(1) DEFAULT 0,
  `Pymt_Flg` tinyint(1) DEFAULT 0,
  `Jv_Flg` tinyint(1) DEFAULT 0,
  `Sal_Flg` tinyint(1) DEFAULT 0,
  `Pur_Flg` tinyint(1) DEFAULT 0,
  `Inv_Flg` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mainbranch`
--

INSERT INTO `mainbranch` (`ID_No`, `Cmp_No`, `Brn_No`, `Cmp_Actvty_No`, `Main_Brn`, `Dlv_Stor`, `Actvty_No`, `Isue_Alinvc`, `Br_Ty`, `Brn_NmEn`, `Brn_NmAr`, `Brn_Tel`, `Brn_Adrs`, `Brn_Email`, `Brn_Fax`, `Acc_Cashier`, `Acc_Customer`, `Acc_Suplier`, `Acc_CrdSal`, `Acc_CshSal`, `Acc_RetSal`, `Acc_DiscSal`, `Acc_CrdPur`, `Acc_CshPur`, `Acc_RetPur`, `Acc_DiscPur`, `DlyPst_CshSal`, `DlyPst_CshPur`, `Adv_SalAcc`, `Adv_RetSalAcc`, `Inv_Prdctn`, `Inv_Undprs`, `Inv_RM`, `Cost_INVt`, `Cost_SalInvt`, `Acc_Invtry`, `Acc_InvAdj`, `Acc_TaxExtraDb`, `Acc_TaxExtraCR`, `Acc_DBEmp`, `Acc_LonesEmp`, `Rcpt_Flg`, `Pymt_Flg`, `Jv_Flg`, `Sal_Flg`, `Pur_Flg`, `Inv_Flg`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, 1, NULL, NULL, NULL, 0, 'Management', 'فرع الصيانة والتشغيل', '0222200000', 'عنوان 1', 'example1@example.com', '2222222', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, '2019-12-09 07:31:25', '2020-01-09 10:51:55'),
(2, 2, 2, NULL, 2, NULL, NULL, NULL, 1, 'Main store 1', 'مستودع رئيسى 1', '033330000', 'عنوان 1', 'example1@example.com', '333333', NULL, 1010401, 2010101, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, '2019-12-09 07:31:56', '2019-12-18 10:13:20'),
(3, 1, 3, NULL, 3, NULL, NULL, NULL, 1, 'Main store 1', 'مستودع رئيسى 1', '25727528', 'المنصوره', 'example1@example.com', '454545', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, '2019-12-09 07:33:10', '2019-12-09 07:33:26'),
(4, 2, 4, NULL, 4, NULL, NULL, NULL, 0, 'Management', 'الاداره الرئيسيه', '012254', 'عنوان 2', 'aa@ss.a', '1111111', NULL, 1010401, 2010101, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, '2019-12-09 07:33:35', '2019-12-18 10:13:25'),
(5, 3, 5, NULL, 5, NULL, NULL, NULL, 0, 'Management', 'الاداره الرئيسيه', '0222200000', 'عنوان 2', 'aa@ss.a', '2222222', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, '2019-12-09 07:33:54', '2019-12-09 07:34:06');

-- --------------------------------------------------------

--
-- Table structure for table `maincompany`
--

CREATE TABLE `maincompany` (
  `ID_No` int(10) UNSIGNED NOT NULL,
  `Cmp_No` int(11) DEFAULT NULL,
  `Local_Lang` int(11) DEFAULT 0,
  `Sys_SetupNo` int(11) DEFAULT NULL,
  `Actvty_No` int(11) DEFAULT NULL,
  `Cmp_ShrtNm` varchar(191) DEFAULT NULL,
  `Start_Month` int(11) DEFAULT NULL,
  `Start_Year` int(11) DEFAULT NULL,
  `End_Month` int(11) DEFAULT NULL,
  `End_Year` int(11) DEFAULT NULL,
  `Start_MonthHij` int(11) DEFAULT NULL,
  `Start_YearHij` int(11) DEFAULT NULL,
  `End_MonthHij` int(11) DEFAULT NULL,
  `End_YearHij` int(11) DEFAULT NULL,
  `Cmp_NmAr` varchar(191) DEFAULT NULL,
  `Cmp_NmAr2` varchar(191) DEFAULT NULL,
  `Cmp_NmEn` varchar(191) DEFAULT NULL,
  `Cmp_NmEn2` varchar(191) DEFAULT NULL,
  `Cmp_Tel` varchar(191) DEFAULT NULL,
  `Cmp_Fax` varchar(191) DEFAULT NULL,
  `Cmp_Email` varchar(191) DEFAULT NULL,
  `Cmp_AddAr` varchar(191) DEFAULT NULL,
  `Cmp_AddEn` varchar(191) DEFAULT NULL,
  `Picture` varchar(191) DEFAULT NULL,
  `CR_No` varchar(191) DEFAULT NULL,
  `CC_No` varchar(191) DEFAULT NULL,
  `License_No` varchar(191) DEFAULT NULL,
  `Tax_No` varchar(191) DEFAULT NULL,
  `TaxExtra_Prct` int(11) DEFAULT NULL,
  `Itm_SrchRef` tinyint(1) DEFAULT 0,
  `Date_Status` tinyint(1) DEFAULT 0,
  `JvAuto_Mnth` tinyint(1) DEFAULT 0,
  `Cshr_Status` tinyint(1) DEFAULT 0,
  `PhyTy_CostPrice` tinyint(1) DEFAULT 0,
  `PhyTy_SalePrice` tinyint(1) DEFAULT 0,
  `Fraction_Cost` int(11) DEFAULT 0,
  `Fraction_Curncy` double(8,2) DEFAULT NULL,
  `Alw_slmacc` smallint(6) NOT NULL DEFAULT 0,
  `JVPst_SalCash` tinyint(1) DEFAULT 0,
  `JVPst_PurCash` tinyint(1) DEFAULT 0,
  `JVPst_NetSalCrdt` tinyint(1) DEFAULT 0,
  `JVPst_NetPurCrdt` tinyint(1) DEFAULT 0,
  `JVPst_TrnsferVch` tinyint(1) DEFAULT 0,
  `JVPst_AdjustVch` tinyint(1) DEFAULT 0,
  `JVPst_InvCost` tinyint(1) DEFAULT 0,
  `JVPst_InvSal` tinyint(1) DEFAULT 0,
  `Spcrpt_Rcpt` tinyint(1) DEFAULT 0,
  `Spcrpt_Pymt` tinyint(1) DEFAULT 0,
  `Spcrpt_Sal` tinyint(1) DEFAULT 0,
  `Spcrpt_Pur` tinyint(1) DEFAULT 0,
  `Spcrpt_Trnf` tinyint(1) DEFAULT 0,
  `Spcrpt_Adjust` tinyint(1) DEFAULT 0,
  `Spcrpt_SRV` tinyint(1) DEFAULT 0,
  `Spcrpt_DNV` tinyint(1) DEFAULT 0,
  `PrintOrder_DNV` tinyint(1) DEFAULT 0,
  `PrintOrder_SRV` tinyint(1) DEFAULT 0,
  `SelctNorm_Prntr1` tinyint(1) DEFAULT 0,
  `SelctNorm_Prntr2` tinyint(1) DEFAULT 0,
  `SelctNorm_Prntr3` tinyint(1) DEFAULT 0,
  `SelctBarCod_Prntr1` tinyint(1) DEFAULT 0,
  `SelctBarCod_Prntr2` tinyint(1) DEFAULT 0,
  `SelctBarCod_Prntr3` tinyint(1) DEFAULT 0,
  `SelctPosSlip_Prntr1` tinyint(1) DEFAULT 0,
  `SelctPosSlip_Prntr2` tinyint(1) DEFAULT 0,
  `SelctPosSlip_Prntr3` tinyint(1) DEFAULT 0,
  `AllwItm_RepatVch` tinyint(1) DEFAULT 0,
  `AllwItmLoc_ZroBlnc` tinyint(1) DEFAULT 0,
  `AllwItmQty_CostCalc` tinyint(1) DEFAULT 0,
  `AllwDisc1Pur_Dis1Sal` tinyint(1) DEFAULT 0,
  `AllwDisc2Pur_Dis2Sal` tinyint(1) DEFAULT 0,
  `AllwStock_Minus` tinyint(1) DEFAULT 0,
  `AllwPur_Disc1` tinyint(1) DEFAULT 0,
  `AllwPur_Disc2` tinyint(1) DEFAULT 0,
  `AllwPur_Bouns` tinyint(1) DEFAULT 0,
  `AllwSal_Disc1` tinyint(1) DEFAULT 0,
  `AllwSal_Disc2` tinyint(1) DEFAULT 0,
  `AllwSal_Bouns` tinyint(1) DEFAULT 0,
  `AllwTrnf_Cost` tinyint(1) DEFAULT 0,
  `AllwTrnf_Disc1` tinyint(1) DEFAULT 0,
  `AllwTrnf_Bouns` tinyint(1) DEFAULT 0,
  `AllwBatch_No` tinyint(1) DEFAULT 0,
  `AllwExpt_Dt` tinyint(1) DEFAULT 0,
  `ActvDnv_No` tinyint(1) DEFAULT 0,
  `ActvSRV_No` tinyint(1) DEFAULT 0,
  `ActvTrnf_No` tinyint(1) DEFAULT 0,
  `TabOrder_Pur` tinyint(1) DEFAULT 0,
  `TabOrder_SaL` tinyint(1) DEFAULT 0,
  `Month_Post1` tinyint(1) DEFAULT 0,
  `Month_Post2` tinyint(1) DEFAULT 0,
  `Month_Post3` tinyint(1) DEFAULT 0,
  `Month_Post4` tinyint(1) DEFAULT 0,
  `Month_Post5` tinyint(1) DEFAULT 0,
  `Month_Post6` tinyint(1) DEFAULT 0,
  `Month_Post7` tinyint(1) DEFAULT 0,
  `Month_Post8` tinyint(1) DEFAULT 0,
  `Month_Post9` tinyint(1) DEFAULT 0,
  `Month_Post10` tinyint(1) DEFAULT 0,
  `Month_Post11` tinyint(1) DEFAULT 0,
  `Month_Post12` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `Accredit_expens` tinyint(1) NOT NULL DEFAULT 0,
  `Foreign_Curncy` tinyint(1) NOT NULL DEFAULT 0,
  `L_Curncy_No` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `maincompany`
--

INSERT INTO `maincompany` (`ID_No`, `Cmp_No`, `Local_Lang`, `Sys_SetupNo`, `Actvty_No`, `Cmp_ShrtNm`, `Start_Month`, `Start_Year`, `End_Month`, `End_Year`, `Start_MonthHij`, `Start_YearHij`, `End_MonthHij`, `End_YearHij`, `Cmp_NmAr`, `Cmp_NmAr2`, `Cmp_NmEn`, `Cmp_NmEn2`, `Cmp_Tel`, `Cmp_Fax`, `Cmp_Email`, `Cmp_AddAr`, `Cmp_AddEn`, `Picture`, `CR_No`, `CC_No`, `License_No`, `Tax_No`, `TaxExtra_Prct`, `Itm_SrchRef`, `Date_Status`, `JvAuto_Mnth`, `Cshr_Status`, `PhyTy_CostPrice`, `PhyTy_SalePrice`, `Fraction_Cost`, `Fraction_Curncy`, `Alw_slmacc`, `JVPst_SalCash`, `JVPst_PurCash`, `JVPst_NetSalCrdt`, `JVPst_NetPurCrdt`, `JVPst_TrnsferVch`, `JVPst_AdjustVch`, `JVPst_InvCost`, `JVPst_InvSal`, `Spcrpt_Rcpt`, `Spcrpt_Pymt`, `Spcrpt_Sal`, `Spcrpt_Pur`, `Spcrpt_Trnf`, `Spcrpt_Adjust`, `Spcrpt_SRV`, `Spcrpt_DNV`, `PrintOrder_DNV`, `PrintOrder_SRV`, `SelctNorm_Prntr1`, `SelctNorm_Prntr2`, `SelctNorm_Prntr3`, `SelctBarCod_Prntr1`, `SelctBarCod_Prntr2`, `SelctBarCod_Prntr3`, `SelctPosSlip_Prntr1`, `SelctPosSlip_Prntr2`, `SelctPosSlip_Prntr3`, `AllwItm_RepatVch`, `AllwItmLoc_ZroBlnc`, `AllwItmQty_CostCalc`, `AllwDisc1Pur_Dis1Sal`, `AllwDisc2Pur_Dis2Sal`, `AllwStock_Minus`, `AllwPur_Disc1`, `AllwPur_Disc2`, `AllwPur_Bouns`, `AllwSal_Disc1`, `AllwSal_Disc2`, `AllwSal_Bouns`, `AllwTrnf_Cost`, `AllwTrnf_Disc1`, `AllwTrnf_Bouns`, `AllwBatch_No`, `AllwExpt_Dt`, `ActvDnv_No`, `ActvSRV_No`, `ActvTrnf_No`, `TabOrder_Pur`, `TabOrder_SaL`, `Month_Post1`, `Month_Post2`, `Month_Post3`, `Month_Post4`, `Month_Post5`, `Month_Post6`, `Month_Post7`, `Month_Post8`, `Month_Post9`, `Month_Post10`, `Month_Post11`, `Month_Post12`, `created_at`, `updated_at`, `Accredit_expens`, `Foreign_Curncy`, `L_Curncy_No`) VALUES
(1, 1, 0, NULL, 2, 'صيانه و تشغيل', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيجادين للصيانه و التشغيل', 'صيانه و تشغيل', 'Behjaden for Maintenance and operation', 'Maintenance and operation', '2', '555555', 'company1@gmail.com', '85282', 'ggg', 'companies/9rTXCSLQepttMHK6MtR5urJ2ntEU8OykIJJPz55x.png', NULL, NULL, '451216', NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2019-12-03 11:37:02', '2020-01-06 10:42:47', 0, 0, NULL),
(2, 2, 0, NULL, 1, 'مقاولات', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيجادين للمقاولات', 'مقاولات', 'Bejaden for Contracting', 'Contracting', '7', '555555', 'company1@gmail.com', '85282', 'عنوان انجليزى', 'companies/tqatYQX8VXzY9SKWkHakmqZbhVXBNWCl0zTXYQkK.png', NULL, NULL, '2145', NULL, 5, 0, 0, 1, 0, 0, 0, 0, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2019-12-03 11:38:05', '2020-01-06 10:42:14', 0, 0, 1),
(3, 3, 0, NULL, 3, 'العمره', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيجادين للعمره', 'العمره', 'Bejaden for Omra', 'Omra', '3', '555555', 'ghg@gfg.com', '85282', 'Address of company 1', 'companies/BjydvBwc0r7YLxzqXz2xDpoYfapMw2Q44A135fs5.png', NULL, NULL, '458100', NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0.00, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2019-12-03 11:38:28', '2020-01-06 10:46:58', 0, 1, 1),
(8, 4, 0, NULL, 3, 'عمره', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'بيجادين للعمره 2', 'العمره 2', 'Company 1', 'gg', '2', '555555', 'dsgdf@yagdy.com', '542', 'gg', NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2019-12-24 13:05:28', '2020-01-06 10:42:25', 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(8, '2019_01_04_000000_create_blog_entries_table', 1),
(9, '2019_01_09_090550_create_admins_table', 1),
(10, '2019_01_11_131556_create_permission_tables', 1),
(11, '2019_01_12_112522_create_branches_table', 1),
(12, '2019_01_12_132425_add_setting_table', 1),
(13, '2019_01_13_101525_create_files_table', 1),
(14, '2019_01_13_111831_create_levels_table', 1),
(15, '2019_01_13_131747_create_countries_table', 1),
(16, '2019_01_14_083031_create_cities_table', 1),
(17, '2019_01_14_093217_create_states_table', 1),
(18, '2019_01_14_120722_create_departments_table', 1),
(19, '2019_01_15_092047_create_glccs_table', 1),
(20, '2019_01_15_110604_create_operations_table', 1),
(21, '2019_01_15_120407_add__to__users_table', 1),
(22, '2019_01_15_121807_create_subscriptions_table', 1),
(23, '2019_01_15_123437_create_parents_table', 1),
(24, '2019_01_15_131531_add_activity_type', 1),
(25, '2019_01_15_140619_add_foreign_key_subcr', 1),
(26, '2019_01_17_110414_create_sub_parents_table', 1),
(27, '2019_01_21_074117_add_soft_deletes_to_subscriber_table', 1),
(28, '2019_01_21_142444_create_employee_table', 1),
(29, '2019_01_21_144430_create_nations_table', 1),
(30, '2019_01_21_144634_add_to_employee_table', 1),
(31, '2019_01_21_144810_add_to_nations_table', 1),
(32, '2019_01_22_134250_create_suppliers_table', 1),
(33, '2019_01_22_143415_add_to_suppliers_table', 1),
(34, '2019_01_23_091727_add__to__admins_table', 1),
(35, '2019_02_03_093741_create_visitors_table', 1),
(36, '2019_02_07_114349_create_notifications_table', 1),
(37, '2019_02_07_163342_create_jobs_table', 1),
(38, '2019_02_13_094015_add_branshes_to_employee', 1),
(39, '2019_02_28_112343_add_forighn_key_to_departments', 1),
(40, '2019_03_09_124727_limitation_receipts', 1),
(41, '2019_03_10_152752_create_limitations_table', 1),
(42, '2019_03_10_153000_add_forign_limitations_table', 1),
(43, '2019_03_11_095120_create_limitations_datas_table', 1),
(44, '2019_03_11_104146_add_forign_key_limitations_datas', 1),
(45, '2019_03_11_153531_create_limitations_type_table', 1),
(46, '2019_03_11_153724_add_forign_limitations_type_table', 1),
(47, '2019_03_11_154000_create_limitations_data_types_table', 1),
(48, '2019_03_13_130614_create_receipts_table', 1),
(49, '2019_03_13_131355_add_foreigh_key_to_receipts', 1),
(50, '2019_03_13_134225_create_receipts_data', 1),
(51, '2019_03_13_135008_add_foreigh_key_to_receipts_data', 1),
(52, '2019_03_13_195555_create_receipts_type_table', 1),
(53, '2019_03_13_195841_add_foreigh_key_to_receipts_type', 1),
(54, '2019_03_13_196239_creat_pivot_receipts_data_types', 1),
(55, '2019_04_06_114320_create_pjitmmsfls_table', 1),
(56, '2019_05_29_115851_create_projects_table', 1),
(57, '2019_06_02_141640_create_contractors_types_table', 1),
(58, '2019_06_02_144826_create_contractors_table', 1),
(59, '2019_06_02_153702_create_responsible_people_table', 1),
(60, '2019_06_11_132404_create_projectcontracts_table', 1),
(61, '2019_06_12_143202_create_contracts_table', 1),
(62, '2019_11_05_145253_create_main_companies_table', 1),
(63, '2019_11_06_112824_add_branshes_to_admins', 1),
(64, '2019_11_06_135047_create_main_branches_table', 1),
(67, '2019_11_18_112242_create_mts_chart_acs_table', 1),
(69, '2019_11_24_121555_create_mts_suplirs_table', 1),
(70, '2019_12_01_125441_create_AstMarket_table', 1),
(72, '2019_12_01_132142_create_AstNutrbusn_table', 1),
(73, '2019_12_01_150736_create_astsupctgs_table', 1),
(74, '2019_12_03_085818_create_mts_clos_accs_table', 1),
(75, '2019_11_24_090357_create_MTsCustomer_table', 2),
(76, '2019_12_01_125441_create_astsalesman_table', 2),
(77, '2019_12_04_111522_create_mts_costcntrs_table', 3),
(78, '2019_12_07_122203_create_projectmfs_table', 4),
(79, '2019_12_08_111532_create_Projcontractmfs_table', 5),
(81, '2019_12_15_145917_create_g_lacc_bnks_table', 7),
(86, '2019_11_16_142924_create_g_l_jrnals_table', 8),
(87, '2019_11_16_145616_create_g_ljrn_trs_table', 8),
(89, '2019_12_24_090752_create_activity_types_table', 9),
(90, '2020_01_01_123614_create_ast_curncies_table', 10),
(93, '2020_01_04_112917_create_g_l_ast_jrntyps_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Admin', 1),
(2, 'App\\Admin', 1),
(3, 'App\\Admin', 1),
(4, 'App\\Admin', 1),
(5, 'App\\Admin', 1),
(6, 'App\\Admin', 1),
(7, 'App\\Admin', 1),
(8, 'App\\Admin', 1),
(9, 'App\\Admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Admin', 1),
(2, 'App\\Admin', 1),
(3, 'App\\Admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mtschartac`
--

CREATE TABLE `mtschartac` (
  `ID_No` int(10) UNSIGNED NOT NULL,
  `Cmp_No` int(10) UNSIGNED DEFAULT NULL,
  `Acc_No` bigint(20) DEFAULT NULL,
  `Parnt_Acc` bigint(20) DEFAULT NULL,
  `Acc_Typ` enum('1','2','3','4','5','6','7') DEFAULT NULL,
  `Level_No` int(11) DEFAULT NULL,
  `Acc_Ntr` int(11) DEFAULT NULL,
  `Level_Status` tinyint(1) DEFAULT NULL,
  `Acc_NmAr` varchar(191) DEFAULT NULL,
  `Acc_NmEn` varchar(191) DEFAULT NULL,
  `Clsacc_No1` int(11) DEFAULT NULL,
  `Clsacc_No2` int(11) DEFAULT NULL,
  `Clsacc_No3` int(11) DEFAULT NULL,
  `CostCntr_Flag` tinyint(1) DEFAULT NULL,
  `Costcntr_No` bigint(20) DEFAULT NULL,
  `Fbal_DB` double(50,10) DEFAULT NULL,
  `Fbal_CR` double(50,10) DEFAULT NULL,
  `Cr_Blnc` double(50,10) DEFAULT NULL,
  `DB11` double(50,10) DEFAULT NULL,
  `CR11` double(50,10) DEFAULT NULL,
  `DB12` double(50,10) DEFAULT NULL,
  `CR12` double(50,10) DEFAULT NULL,
  `DB13` double(50,10) DEFAULT NULL,
  `CR13` double(50,10) DEFAULT NULL,
  `DB14` double(50,10) DEFAULT NULL,
  `CR14` double(50,10) DEFAULT NULL,
  `DB15` double(50,10) DEFAULT NULL,
  `CR15` double(50,10) DEFAULT NULL,
  `DB16` double(50,10) DEFAULT NULL,
  `CR16` double(50,10) DEFAULT NULL,
  `DB17` double(50,10) DEFAULT NULL,
  `CR17` double(50,10) DEFAULT NULL,
  `DB18` double(50,10) DEFAULT NULL,
  `CR18` double(50,10) DEFAULT NULL,
  `DB19` double(50,10) DEFAULT NULL,
  `CR19` double(50,10) DEFAULT NULL,
  `DB20` double(50,10) DEFAULT NULL,
  `CR20` double(50,10) DEFAULT NULL,
  `DB21` double(50,10) DEFAULT NULL,
  `CR21` double(50,10) DEFAULT NULL,
  `DB22` double(50,10) DEFAULT NULL,
  `CR22` double(50,10) DEFAULT NULL,
  `Acc_Dt` datetime DEFAULT NULL,
  `Acc_DtAr` varchar(191) DEFAULT NULL,
  `Acc_Actv` tinyint(1) DEFAULT 1,
  `ComplxFbal_DB` double(50,10) DEFAULT NULL,
  `ComplxFbal_CR` double(50,10) DEFAULT NULL,
  `User_Id` int(11) DEFAULT NULL,
  `Updt_Time` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mtschartac`
--

INSERT INTO `mtschartac` (`ID_No`, `Cmp_No`, `Acc_No`, `Parnt_Acc`, `Acc_Typ`, `Level_No`, `Acc_Ntr`, `Level_Status`, `Acc_NmAr`, `Acc_NmEn`, `Clsacc_No1`, `Clsacc_No2`, `Clsacc_No3`, `CostCntr_Flag`, `Costcntr_No`, `Fbal_DB`, `Fbal_CR`, `Cr_Blnc`, `DB11`, `CR11`, `DB12`, `CR12`, `DB13`, `CR13`, `DB14`, `CR14`, `DB15`, `CR15`, `DB16`, `CR16`, `DB17`, `CR17`, `DB18`, `CR18`, `DB19`, `CR19`, `DB20`, `CR20`, `DB21`, `CR21`, `DB22`, `CR22`, `Acc_Dt`, `Acc_DtAr`, `Acc_Actv`, `ComplxFbal_DB`, `ComplxFbal_CR`, `User_Id`, `Updt_Time`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 0, NULL, 1, NULL, 0, 'الاصول', 'الاصول', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 13:39:01', '1441-04-06', 1, NULL, NULL, 1, '2019-12-08 14:36:52', '2019-12-03 11:39:01', '2019-12-08 12:36:52'),
(2, 2, 2, 0, NULL, 1, NULL, 0, 'الخصوم', 'الخصوم', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 13:39:13', '1441-04-06', 1, NULL, NULL, 1, '2019-12-07 13:34:35', '2019-12-03 11:39:13', '2019-12-07 11:34:35'),
(3, 2, 3, 0, NULL, 1, NULL, 0, 'المصاريف', 'المصاريف', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 13:39:41', '1441-04-06', 1, NULL, NULL, 1, '2019-12-07 13:36:08', '2019-12-03 11:39:41', '2019-12-07 11:37:23'),
(4, 2, 4, 0, NULL, 1, NULL, 0, 'الايرادات', 'الايرادات', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 13:40:04', '1441-04-06', 1, NULL, NULL, 1, '2019-12-07 13:38:45', '2019-12-03 11:40:04', '2019-12-07 11:38:45'),
(5, 2, 101, 1, '1', 2, 1, 0, 'الاصول المتداوله', 'الاصول المتداوله', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 13:41:00', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 13:41:00', '2019-12-03 11:41:00', '2019-12-07 11:33:39'),
(6, 2, 102, 1, '1', 2, 1, 0, 'الاصول الثابته', 'الاصول الثابته', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 13:41:33', '1441-04-06', 1, NULL, NULL, 1, '2019-12-07 13:33:41', '2019-12-03 11:41:33', '2019-12-08 07:24:54'),
(7, 2, 103, 1, '1', 2, 1, 1, 'اصول اخرى', 'اصول اخرى', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 13:42:39', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 13:42:39', '2019-12-03 11:42:39', '2019-12-07 11:33:41'),
(8, 2, 10101, 101, '1', 3, 1, 0, 'الصندوق', 'الصندوق', NULL, NULL, NULL, NULL, NULL, 88500.0000000000, 107109.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 13:47:00', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 13:57:21', '2019-12-03 11:47:00', '2019-12-07 11:33:39'),
(9, 2, 1010101, 10101, '1', 4, 1, 1, 'الصندوق الرئيسى', 'الصندوق الرئيسى', NULL, NULL, NULL, NULL, NULL, 88500.0000000000, 107109.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 13:47:54', '1441-04-06', 1, NULL, NULL, 1, '2019-12-08 14:42:25', '2019-12-03 11:47:54', '2019-12-08 12:42:25'),
(10, 2, 10102, 101, '1', 3, 1, 0, 'البنوك', 'البنوك', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 13:58:18', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 13:58:18', '2019-12-03 11:58:18', '2019-12-07 11:33:39'),
(11, 2, 10103, 101, '1', 3, 1, 0, 'العهده النقديه', 'العهده النقديه', NULL, NULL, NULL, NULL, NULL, 212465.0000000000, 166214.9111328125, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 13:58:50', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 13:58:50', '2019-12-03 11:58:50', '2019-12-07 11:33:39'),
(12, 2, 10104, 101, '1', 3, 1, 0, 'ذمم العملاء', 'ذمم العملاء', NULL, NULL, NULL, NULL, NULL, 4987080.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 13:59:16', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 13:59:16', '2019-12-03 11:59:16', '2019-12-07 11:33:40'),
(13, 2, 10105, 101, '1', 3, 1, 0, 'الايرادات المستحقة للمشاريع', 'الايرادات المستحقة للمشاريع', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 4987080.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 13:59:37', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 13:59:37', '2019-12-03 11:59:37', '2019-12-07 11:33:40'),
(14, 2, 10106, 101, '1', 3, 1, 0, 'المخزون', 'المخزون', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 13:59:56', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 13:59:56', '2019-12-03 11:59:56', '2019-12-07 11:33:40'),
(15, 2, 10107, 101, '1', 3, 1, 0, 'ذمم الموظفين', 'ذمم الموظفين', NULL, NULL, NULL, NULL, NULL, 133706.0000000000, 233656.6718750000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:00:22', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:00:22', '2019-12-03 12:00:22', '2019-12-07 11:33:40'),
(19, 2, 10108, 101, '1', 3, 1, 0, 'مدينون متنوعون', 'مدينون متنوعون', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:05:12', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:05:12', '2019-12-03 12:05:12', '2019-12-07 11:33:40'),
(20, 2, 10109, 101, '1', 3, 1, 1, 'مصاريف مدفوعة مقدما', 'مصاريف مدفوعة مقدما', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:05:50', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:05:50', '2019-12-03 12:05:50', '2019-12-07 11:33:40'),
(21, 2, 10110, 101, '1', 3, 1, 0, 'ضريبة القيمة المضافة للمصروفات', 'ضريبة القيمة المضافة للمصروفات', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:06:21', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:06:21', '2019-12-03 12:06:21', '2019-12-07 11:33:40'),
(22, 2, 1010201, 10102, '1', 4, 1, 1, 'البنك الراجحي', 'البنك الراجحي', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:11:13', '1441-04-06', 1, NULL, NULL, 1, '2019-12-15 12:31:24', '2019-12-03 12:11:13', '2019-12-15 10:31:24'),
(23, 2, 1010202, 10102, '1', 4, 1, 1, 'البنك الاهلي', 'البنك الاهلي', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:11:32', '1441-04-06', 1, NULL, NULL, 1, '2019-12-15 12:31:49', '2019-12-03 12:11:32', '2019-12-15 10:31:49'),
(24, 2, 1010203, 10102, '1', 4, 1, 1, 'بنك البلاد', 'بنك البلاد', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:11:48', '1441-04-06', 1, NULL, NULL, 1, '2019-12-15 12:32:15', '2019-12-03 12:11:48', '2019-12-15 10:32:15'),
(25, 2, 1010301, 10103, '1', 4, 1, 1, 'عهدة م/محمد الخباص', 'عهدة م/محمد الخباص', NULL, NULL, NULL, NULL, NULL, 94259.0000000000, 66046.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:15:02', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:15:02', '2019-12-03 12:15:02', '2019-12-07 11:33:39'),
(26, 2, 1010302, 10103, '1', 4, 1, 1, 'عهدة ياسر الغماري', 'عهدة ياسر الغماري', NULL, NULL, NULL, NULL, NULL, 62609.0000000000, 54897.6000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:15:32', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:15:32', '2019-12-03 12:15:32', '2019-12-07 11:33:39'),
(27, 2, 1010303, 10103, '1', 4, 1, 1, 'عهدة صالح العمري', 'عهدة صالح العمري', NULL, NULL, NULL, NULL, NULL, 29900.0000000000, 29500.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:16:02', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:16:02', '2019-12-03 12:16:02', '2019-12-07 11:33:39'),
(28, 2, 1010304, 10103, '1', 4, 1, 1, 'عهدة شمس زاروب', 'عهدة شمس زاروب', NULL, NULL, NULL, NULL, NULL, 3355.0000000000, 3770.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:16:31', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:16:31', '2019-12-03 12:16:31', '2019-12-07 11:33:39'),
(29, 2, 1010305, 10103, '1', 4, 1, 1, 'عهدة م/عرمان الحاج بشير', 'عهدة م/عرمان الحاج بشير', NULL, NULL, NULL, NULL, NULL, 14050.0000000000, 11221.3000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:16:58', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:16:58', '2019-12-03 12:16:58', '2019-12-07 11:33:39'),
(30, 2, 1010306, 10103, '1', 4, 1, 1, 'عهدة هارون _ قسم التشغيل والصيانة', 'عهدة هارون _ قسم التشغيل والصيانة', NULL, NULL, NULL, NULL, NULL, 1642.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:17:30', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:17:30', '2019-12-03 12:17:30', '2019-12-07 11:33:40'),
(31, 2, 1010307, 10103, '1', 4, 1, 1, 'عهدة ابراهيم الكومي', 'عهدة ابراهيم الكومي', NULL, NULL, NULL, NULL, NULL, 1450.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:18:21', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:18:21', '2019-12-03 12:18:21', '2019-12-07 11:33:40'),
(32, 2, 1010308, 10103, '1', 4, 1, 1, 'عهدة مفرح العازمي', 'عهدة مفرح العازمي', NULL, NULL, NULL, NULL, NULL, 5000.0000000000, 605.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:18:49', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:18:49', '2019-12-03 12:18:49', '2019-12-07 11:33:40'),
(33, 2, 1010309, 10103, '1', 4, 1, 1, 'عهدة الحارث ناصر ( سائق المطار )', 'عهدة الحارث ناصر ( سائق المطار )', NULL, NULL, NULL, NULL, NULL, 200.0000000000, 175.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:19:13', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:19:13', '2019-12-03 12:19:13', '2019-12-07 11:33:40'),
(34, 2, 1010310, 10103, '1', 4, 1, 1, 'عهدة سفيان اسماعيل', 'عهدة سفيان اسماعيل', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:19:32', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:19:32', '2019-12-03 12:19:32', '2019-12-07 11:33:40'),
(35, 2, 1010311, 10103, '1', 4, 1, 1, 'عهدة صالح السيد _ابو يوسف', 'عهدة صالح السيد _ابو يوسف', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:19:46', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:19:46', '2019-12-03 12:19:46', '2019-12-07 11:33:40'),
(36, 2, 1010401, 10104, '2', 4, 1, 1, 'ذمم العملاء فرع جدة', 'ذمم العملاء فرع جدة', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:22:01', '1441-04-06', 1, NULL, NULL, 1, '2019-12-11 10:29:20', '2019-12-03 12:22:01', '2019-12-11 08:29:20'),
(37, 2, 1010402, 10104, '2', 4, 1, 1, 'وزارة الاعلام فرع جدة', 'وزارة الاعلام فرع جدة', NULL, NULL, NULL, NULL, NULL, 4987080.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:22:36', '1441-04-06', 1, NULL, NULL, 1, '2019-12-15 12:33:18', '2019-12-03 12:22:36', '2019-12-15 10:33:18'),
(38, 2, 1010501, 10105, '1', 4, 1, 1, 'الايرادات المستحقة لوزارة الاعلام', 'الايرادات المستحقة لوزارة الاعلام', NULL, NULL, NULL, NULL, NULL, 4987080.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:24:14', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:24:14', '2019-12-03 12:24:14', '2019-12-07 11:33:40'),
(39, 2, 1010601, 10106, '1', 4, 1, 1, 'مخزون فرع جدة', 'مخزون فرع جدة', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:25:45', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:25:45', '2019-12-03 12:25:45', '2019-12-07 11:33:40'),
(40, 2, 1010701, 10107, '1', 4, 1, 1, 'ذمم موظفين الادارة', 'ذمم موظفين الادارة', NULL, NULL, NULL, 1, 1, 133706.0000000000, 133706.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:29:14', '1441-04-06', 1, NULL, NULL, 1, '2019-12-15 14:43:05', '2019-12-03 12:29:14', '2019-12-15 12:43:05'),
(41, 2, 1010801, 10108, '1', 4, 1, 1, 'مؤسسة البجادين للصيانة و التشغيل', 'مؤسسة البجادين للصيانة و التشغيل', NULL, NULL, NULL, NULL, NULL, 138.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:30:19', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:30:37', '2019-12-03 12:30:19', '2019-12-07 11:33:40'),
(42, 2, 1010802, 10108, '1', 4, 1, 1, 'مطبخ نكهة المشاعر', 'مطبخ نكهة المشاعر', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:30:58', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:30:58', '2019-12-03 12:30:58', '2019-12-07 11:33:40'),
(43, 2, 1011001, 10110, '1', 4, 1, 1, 'ضريبة القيمة المضافة للمشتريات', 'ضريبة القيمة المضافة للمشتريات', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:32:03', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:32:03', '2019-12-03 12:32:03', '2019-12-07 11:33:40'),
(44, 2, 1011002, 10110, '1', 4, 1, 1, 'خصومات الضريبة من المستخلصات', 'خصومات الضريبة من المستخلصات', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:32:21', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:32:21', '2019-12-03 12:32:21', '2019-12-07 11:33:41'),
(45, 2, 10201, 102, NULL, 3, 1, 0, 'المبانى', 'المبانى', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:34:41', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:34:41', '2019-12-03 12:34:41', '2019-12-08 07:24:54'),
(46, 2, 10202, 102, NULL, 3, 1, 0, 'السيارات', 'السيارات', NULL, NULL, NULL, NULL, NULL, 6225.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:36:41', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:36:41', '2019-12-03 12:36:41', '2019-12-08 07:24:55'),
(47, 2, 10203, 102, NULL, 3, 1, 0, 'الات ومعدات', 'الات ومعدات', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:37:04', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:37:04', '2019-12-03 12:37:04', '2019-12-08 07:24:55'),
(48, 2, 10204, 102, NULL, 3, 1, 0, 'اجهزة كهربائية', 'اجهزة كهربائية', NULL, NULL, NULL, NULL, NULL, 705.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:37:31', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:37:31', '2019-12-03 12:37:31', '2019-12-08 07:24:55'),
(51, 2, 1020101, 10201, '1', 4, 1, 1, 'المبانى', 'المبانى', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:39:46', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:39:46', '2019-12-03 12:39:46', '2019-12-08 07:24:55'),
(52, 2, 1020201, 10202, '1', 4, 1, 1, 'السيارات', 'السيارات', NULL, NULL, NULL, NULL, NULL, 6225.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:40:23', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:40:23', '2019-12-03 12:40:23', '2019-12-08 07:24:55'),
(53, 2, 1020301, 10203, '1', 4, 1, 1, 'الات ومعدات', 'الات ومعدات', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:41:19', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:41:19', '2019-12-03 12:41:19', '2019-12-08 07:24:55'),
(54, 2, 1020401, 10204, '1', 4, 1, 1, 'اجهزة كهربائية', 'اجهزة كهربائية', NULL, NULL, NULL, NULL, NULL, 335.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:42:27', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:42:27', '2019-12-03 12:42:27', '2019-12-08 07:24:55'),
(55, 2, 1020402, 10204, '1', 4, 1, 1, 'مكيفات', 'مكيفات', NULL, NULL, NULL, NULL, NULL, 370.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:43:19', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:43:19', '2019-12-03 12:43:19', '2019-12-08 07:24:55'),
(56, 2, 10205, 102, '1', 3, 1, 0, 'اجهزة كبيوتر', 'اجهزة كبيوتر', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:45:23', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:45:23', '2019-12-03 12:45:23', '2019-12-08 07:24:55'),
(57, 2, 1020501, 10205, '1', 4, 1, 1, 'اجهزة كبيوتر', 'اجهزة كبيوتر', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:45:53', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:45:53', '2019-12-03 12:45:53', '2019-12-08 07:24:55'),
(58, 2, 10206, 102, '1', 3, 1, 0, 'اثاث ومفروشات', 'اثاث ومفروشات', NULL, NULL, NULL, NULL, NULL, 315.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:47:55', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:47:55', '2019-12-03 12:47:55', '2019-12-08 07:24:55'),
(59, 2, 1020601, 10206, '1', 4, 1, 1, 'اثاث ومفروشات', 'اثاث ومفروشات', NULL, NULL, NULL, NULL, NULL, 315.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:48:49', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:48:49', '2019-12-03 12:48:49', '2019-12-08 07:24:55'),
(60, 2, 10207, 102, '1', 3, 1, 0, 'عدد وادوات', 'عدد وادوات', NULL, NULL, NULL, NULL, NULL, 178.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:50:08', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:50:08', '2019-12-03 12:50:08', '2019-12-08 07:24:55'),
(61, 2, 1020701, 10207, '1', 4, 1, 1, 'اصول ثابتة عدد وادوات', 'اصول ثابتة عدد وادوات', NULL, NULL, NULL, NULL, NULL, 178.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 14:50:29', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 14:50:29', '2019-12-03 12:50:29', '2019-12-08 07:24:55'),
(62, 2, 201, 2, '1', 2, 2, 0, 'الخصوم المتداوله', 'الخصوم المتداوله', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 15:29:14', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 15:29:14', '2019-12-03 13:29:14', '2019-12-07 11:34:35'),
(63, 2, 202, 2, '1', 2, 2, 0, 'حقوق الملكية', 'حقوق الملكية', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 15:29:44', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 15:29:44', '2019-12-03 13:29:44', '2019-12-07 11:34:36'),
(64, 2, 203, 2, '1', 2, 2, 0, 'مجمع اهلاك الاصول الثابتة', 'مجمع اهلاك الاصول الثابتة', NULL, NULL, NULL, NULL, NULL, 1722.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 15:30:21', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 15:30:21', '2019-12-03 13:30:21', '2019-12-07 11:34:36'),
(65, 2, 204, 2, '1', 2, 2, 0, 'مخصصات واحتياطيات', 'مخصصات واحتياطيات', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 15:30:56', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 15:30:56', '2019-12-03 13:30:56', '2019-12-07 11:34:37'),
(66, 2, 20101, 201, '3', 3, 2, 0, 'الموردين', 'الموردين', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 15:33:53', '1441-04-06', 1, NULL, NULL, 1, '2019-12-14 11:50:30', '2019-12-03 13:33:53', '2019-12-14 09:50:30'),
(67, 2, 2010101, 20101, '3', 4, 1, 1, 'موردين النشاط', 'موردين النشاط', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 15:35:02', '1441-04-06', 1, NULL, NULL, 1, '2019-12-14 11:57:50', '2019-12-03 13:35:02', '2019-12-14 09:57:50'),
(68, 2, 20102, 201, '3', 3, 2, 0, 'دائنون متنوعون', 'دائنون متنوعون', NULL, NULL, NULL, NULL, NULL, 49300.0000000000, 90850.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 15:36:12', '1441-04-06', 1, NULL, NULL, 1, '2019-12-14 11:51:10', '2019-12-03 13:36:12', '2019-12-14 09:51:10'),
(69, 2, 20103, 201, '1', 3, 2, 1, 'ارصده دائنه اخرى', 'ارصده دائنه اخرى', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 15:36:43', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 15:36:43', '2019-12-03 13:36:43', '2019-12-07 11:34:36'),
(70, 2, 20104, 201, '1', 3, 2, 0, 'ضريبة القيمه المضافه للايرادات', 'ضريبة القيمه المضافه للايرادات', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 15:37:12', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 16:02:52', '2019-12-03 13:37:12', '2019-12-07 11:34:36'),
(71, 2, 2010201, 20102, '1', 4, 2, 1, 'سامى عبد الله المويهى', 'سامى عبد الله المويهى', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 20650.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 15:43:09', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 15:57:34', '2019-12-03 13:43:09', '2019-12-14 09:51:10'),
(72, 2, 2010202, 20102, '1', 4, 2, 1, 'مؤسسة البيجادين لخدمات المعتمرين', 'مؤسسة البيجادين لخدمات المعتمرين', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 17200.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 15:44:25', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 15:58:01', '2019-12-03 13:44:25', '2019-12-14 09:51:11'),
(73, 2, 2010203, 20102, '1', 4, 2, 1, 'ماجد هنية - سائق باص', 'ماجد هنية - سائق باص', NULL, NULL, NULL, NULL, NULL, 14300.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 15:45:00', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 15:58:21', '2019-12-03 13:45:00', '2019-12-14 09:51:11'),
(74, 2, 2010204, 20102, '1', 4, 2, 1, 'فينو كومار - سائق باص', 'فينو كومار - سائق باص', NULL, NULL, NULL, NULL, NULL, 4000.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 15:45:32', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 15:58:52', '2019-12-03 13:45:32', '2019-12-14 09:51:11'),
(75, 2, 2010205, 20102, '1', 4, 2, 1, 'مؤسسة النظم التخطيطيه لحلول التقنيه', 'مؤسسة النظم التخطيطيه لحلول التقنيه', NULL, NULL, NULL, NULL, NULL, 20000.0000000000, 42000.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 15:46:16', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 15:59:17', '2019-12-03 13:46:16', '2019-12-14 09:51:11'),
(76, 2, 2010206, 20102, '1', 4, 2, 1, 'مؤسسة سلطان فهد العتيبى للمقاولات', 'مؤسسة سلطان فهد العتيبى للمقاولات', NULL, NULL, NULL, NULL, NULL, 11000.0000000000, 11000.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 15:47:02', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 15:59:38', '2019-12-03 13:47:02', '2019-12-14 09:51:11'),
(77, 2, 2010401, 20104, '1', 4, 2, 1, 'ضريبة القيمه المضافه للمبيعات', 'ضريبة القيمه المضافه للمبيعات', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-03 15:48:47', '1441-04-06', 1, NULL, NULL, 1, '2019-12-03 15:48:47', '2019-12-03 13:48:47', '2019-12-07 11:34:36'),
(78, 2, 20201, 202, '1', 3, 2, 0, 'راس المال', 'راس المال', 107, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-04 10:00:47', '1441-04-07', 1, NULL, NULL, 1, '2019-12-04 10:00:47', '2019-12-04 08:00:47', '2019-12-07 11:34:36'),
(79, 2, 2020101, 20201, '1', 4, 2, 1, 'نواف بجد العتيبى', 'نواف بجد العتيبى', 107, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-04 10:03:29', '1441-04-07', 1, NULL, NULL, 1, '2019-12-04 10:03:29', '2019-12-04 08:03:29', '2019-12-07 11:34:36'),
(80, 2, 20202, 202, '1', 3, 2, 1, 'جاري الشركاء', 'جاري الشركاء', 101, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-04 17:18:46', '1441-04-07', 1, NULL, NULL, 1, '2019-12-04 17:18:46', '2019-12-04 15:18:46', '2019-12-07 11:34:36'),
(81, 2, 20203, 202, '1', 3, 2, 1, 'ارباح وخسائر العام', 'ارباح وخسائر العام', 101, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-04 17:20:30', '1441-04-07', 1, NULL, NULL, 1, '2019-12-04 17:20:30', '2019-12-04 15:20:30', '2019-12-07 11:34:36'),
(82, 2, 20301, 203, '1', 3, 2, 0, 'مجمع اهلاك المباني', 'مجمع اهلاك المباني', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 09:08:58', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 09:08:58', '2019-12-07 07:08:58', '2019-12-07 11:34:36'),
(83, 2, 2030101, 20301, '2', 4, 2, 1, 'وكلاء تونس', 'وكلاء تونس', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 09:15:39', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 09:15:39', '2019-12-07 07:15:39', '2019-12-07 11:34:36'),
(84, 2, 2030102, 20301, '2', 4, 1, 1, 'وكلاء افغانستان', 'وكلاء افغانستان', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 09:17:17', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 09:17:17', '2019-12-07 07:17:17', '2019-12-07 11:34:36'),
(85, 2, 20302, 203, '1', 3, 2, 1, 'مجمع اهلاك السيارات', 'مجمع اهلاك السيارات', 101, NULL, NULL, NULL, NULL, 1176.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 09:19:16', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 09:19:16', '2019-12-07 07:19:16', '2019-12-07 11:34:36'),
(86, 2, 20303, 203, '1', 3, 2, 1, 'مجمع اهلاك الات ومعدات', 'مجمع اهلاك الات ومعدات', 101, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 09:21:36', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 09:21:36', '2019-12-07 07:21:36', '2019-12-07 11:34:36'),
(87, 2, 20304, 203, '1', 3, 1, 1, 'عهدة فهد القرشي', 'عهدة فهد القرشي', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 09:23:31', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 09:23:31', '2019-12-07 07:23:31', '2019-12-07 11:34:36'),
(88, 2, 20305, 203, '1', 3, 2, 1, 'مجمع اهلاك اجهزة كمبيوتر', 'مجمع اهلاك اجهزة كمبيوتر', 101, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 09:24:49', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 09:24:49', '2019-12-07 07:24:49', '2019-12-07 11:34:36'),
(89, 2, 20306, 203, '1', 3, 1, 0, 'عهدة عبد الرزاق محمد نور', 'عهدة عبد الرزاق محمد نور', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 09:26:07', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 09:26:07', '2019-12-07 07:26:07', '2019-12-07 11:34:36'),
(90, 2, 20307, 20306, '1', 4, 1, 1, 'مجمع اهلاك اثاث ومفروشات', 'مجمع اهلاك اثاث ومفروشات', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 10:50:44', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 10:50:44', '2019-12-07 08:50:44', '2019-12-07 11:34:36'),
(91, 2, 20307, 203, '1', 3, 1, 1, 'مجمع اهلاك اثاث ومفروشات', 'مجمع اهلاك اثاث ومفروشات', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 10:52:05', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 10:52:05', '2019-12-07 08:52:05', '2019-12-07 08:52:05'),
(92, 2, 20401, 204, '1', 3, 1, 1, 'مخصص الزكاه والدخل', 'مخصص الزكاه والدخل', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 10:56:31', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 10:56:31', '2019-12-07 08:56:31', '2019-12-07 11:34:37'),
(93, 2, 20402, 204, '1', 3, 1, 1, 'مخصص ديون معدومه', 'مخصص ديون معدومه', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 10:57:38', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 10:57:38', '2019-12-07 08:57:38', '2019-12-07 11:34:37'),
(94, 2, 20403, 204, '1', 3, 1, 1, 'مخصص ديون مشكوك في تحصيلها', 'مخصص ديون مشكوك في تحصيلها', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 10:59:43', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 10:59:43', '2019-12-07 08:59:43', '2019-12-07 11:34:37'),
(95, 2, 20404, 204, '1', 3, 1, 1, 'مخصص الاجازات', 'مخصص الاجازات', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:01:33', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:01:33', '2019-12-07 09:01:33', '2019-12-07 11:34:37'),
(96, 2, 20405, 204, '1', 3, 1, 1, 'مخصص تذاكر السفر', 'مخصص تذاكر السفر', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:02:33', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:02:33', '2019-12-07 09:02:33', '2019-12-07 11:34:37'),
(97, 2, 20406, 204, '1', 3, 1, 1, 'احتياطي نظامي', 'احتياطي نظامي', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:03:25', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:03:25', '2019-12-07 09:03:25', '2019-12-07 11:34:37'),
(98, 2, 301, 3, '1', 2, 1, 0, 'مشتريات', 'مشتريات', NULL, NULL, NULL, NULL, NULL, 48046.6000000000, 400.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:08:14', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:08:14', '2019-12-07 09:08:14', '2019-12-07 11:37:23'),
(99, 2, 30101, 301, '1', 3, 1, 0, 'مشتريات النشاط', 'مشتريات النشاط', NULL, NULL, NULL, NULL, NULL, 48046.6000000000, 40.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:09:09', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:09:09', '2019-12-07 09:09:09', '2019-12-07 11:37:23'),
(100, 2, 3010101, 30101, '1', 4, 1, 0, 'المشتريات النقديه', 'المشتريات النقديه', NULL, NULL, NULL, NULL, NULL, 48046.6000000000, 400.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:17:20', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:17:20', '2019-12-07 09:17:20', '2019-12-07 11:37:23'),
(101, 2, 301010101, 3010101, '1', 5, 1, 1, 'مشتريات نقديه مواد نظافه', 'مشتريات نقديه مواد نظافه', NULL, NULL, NULL, NULL, NULL, 45965.6000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:18:48', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:18:48', '2019-12-07 09:18:48', '2019-12-07 11:37:23'),
(102, 2, 301010102, 3010101, '1', 5, 1, 1, 'مشتريات نقديه سباكه', 'مشتريات نقديه سباكه', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:19:38', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:19:38', '2019-12-07 09:19:38', '2019-12-07 11:37:23'),
(103, 2, 301010103, 3010101, '1', 5, 1, 1, 'مشتريات نقديه مواد كهرباء', 'مشتريات نقديه مواد كهرباء', NULL, NULL, NULL, NULL, NULL, 1039.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:20:38', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:20:38', '2019-12-07 09:20:38', '2019-12-07 11:37:23'),
(104, 2, 301010104, 3010101, '1', 5, 1, 1, 'مشتريات نقديه قطع غيار', 'مشتريات نقديه قطع غيار', NULL, NULL, NULL, NULL, NULL, 147.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:21:35', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:21:35', '2019-12-07 09:21:35', '2019-12-07 11:37:23'),
(105, 2, 301010105, 3010101, '1', 5, 1, 1, 'مشتريات نقديه مواد بناء', 'مشتريات نقديه مواد بناء', 101, NULL, NULL, NULL, NULL, 895.0000000000, 400.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:25:39', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:25:39', '2019-12-07 09:25:39', '2019-12-07 11:37:23'),
(106, 2, 3010102, 30101, '1', 4, 1, 0, 'المشتريات الآجله', 'المشتريات الآجله', 101, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:26:53', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:26:53', '2019-12-07 09:26:53', '2019-12-07 11:37:24'),
(107, 2, 301010201, 3010102, '1', 5, 1, 1, 'مشتريات اجله مواد كهرباء', 'مشتريات اجله مواد كهرباء', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:27:59', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:27:59', '2019-12-07 09:27:59', '2019-12-07 11:37:24'),
(108, 2, 301010202, 3010102, '1', 5, 1, 1, 'مشتريات اجله زي موحد', 'مشتريات اجله زي موحد', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:28:47', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:28:47', '2019-12-07 09:28:47', '2019-12-07 11:37:24'),
(109, 2, 301010203, 3010102, '1', 5, 1, 1, 'مشتريات اجله قطع غيار', 'مشتريات اجله قطع غيار', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:29:43', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:29:43', '2019-12-07 09:29:43', '2019-12-07 11:37:24'),
(110, 2, 302, 3, '1', 2, 1, 0, 'مصاريف التشغيل', 'مصاريف التشغيل', NULL, NULL, NULL, NULL, NULL, 332953.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:33:33', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:35:29', '2019-12-07 09:33:33', '2019-12-07 11:37:24'),
(111, 2, 30201, 302, '1', 3, 1, 0, 'مصاريف الرواتب والاجور للمشاريع', 'مصاريف الرواتب والاجور للمشاريع', NULL, NULL, NULL, NULL, NULL, 332953.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:34:49', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:34:49', '2019-12-07 09:34:49', '2019-12-07 11:37:24'),
(112, 2, 3020101, 30201, '1', 4, 1, 1, 'اجور ورواتب للمشاريع', 'اجور ورواتب للمشاريع', NULL, NULL, NULL, NULL, NULL, 233657.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:37:26', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:37:26', '2019-12-07 09:37:26', '2019-12-07 11:37:24'),
(113, 2, 30202, 302, '1', 3, 1, 0, 'مصاريف تشغيل قطع الغيار', 'مصاريف تشغيل قطع الغيار', NULL, NULL, NULL, NULL, NULL, 5975.3100000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:38:57', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:38:57', '2019-12-07 09:38:57', '2019-12-07 11:37:24'),
(114, 2, 3020201, 30202, '1', 4, 1, 1, 'مصاريف قطع غيار سباكه', 'مصاريف قطع غيار سباكه', NULL, NULL, NULL, NULL, NULL, 728.2500000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:40:08', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:40:08', '2019-12-07 09:40:08', '2019-12-07 11:37:24'),
(115, 2, 3020202, 30202, '1', 4, 1, 1, 'مصاريف قطع غيار كهرباء', 'مصاريف قطع غيار كهرباء', NULL, NULL, NULL, NULL, NULL, 5247.0600000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:41:25', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:41:25', '2019-12-07 09:41:25', '2019-12-07 11:37:24'),
(116, 2, 3020203, 30202, '1', 4, 1, 1, 'مصاريف قطع غيار متنوعه', 'مصاريف قطع غيار متنوعه', NULL, NULL, NULL, NULL, NULL, 147.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:42:46', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:42:46', '2019-12-07 09:42:46', '2019-12-07 11:37:24'),
(117, 2, 30203, 302, '1', 3, 1, 0, 'المصاريف الحكوميه', 'المصاريف الحكوميه', NULL, NULL, NULL, NULL, NULL, 93321.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:44:37', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:44:37', '2019-12-07 09:44:37', '2019-12-07 11:37:24'),
(118, 2, 3020301, 30203, '1', 4, 1, 1, 'مصاريف نقل كفاله', 'مصاريف نقل كفاله', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:46:01', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:46:01', '2019-12-07 09:46:01', '2019-12-07 11:37:24'),
(119, 2, 3020302, 30203, '1', 4, 1, 1, 'مصاريف تجديد الاقامه', 'مصاريف تجديد الاقامه', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:46:54', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:46:54', '2019-12-07 09:46:54', '2019-12-07 11:37:24'),
(120, 2, 3020303, 30203, '1', 4, 1, 1, 'مصاريف رخصة العمل', 'مصاريف رخصة العمل', NULL, NULL, NULL, NULL, NULL, 76821.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:48:28', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:48:28', '2019-12-07 09:48:28', '2019-12-07 11:37:24'),
(121, 2, 3020304, 30203, '1', 4, 1, 1, 'مصاريف غرامات تاخير', 'مصاريف غرامات تاخير', NULL, NULL, NULL, NULL, NULL, 10000.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:49:17', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:49:17', '2019-12-07 09:49:17', '2019-12-07 11:37:24'),
(122, 2, 30204, 302, '1', 3, 1, 1, 'غرامات تقصير عماله', 'غرامات تقصير عماله', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:50:17', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:50:17', '2019-12-07 09:50:17', '2019-12-07 11:37:24');
INSERT INTO `mtschartac` (`ID_No`, `Cmp_No`, `Acc_No`, `Parnt_Acc`, `Acc_Typ`, `Level_No`, `Acc_Ntr`, `Level_Status`, `Acc_NmAr`, `Acc_NmEn`, `Clsacc_No1`, `Clsacc_No2`, `Clsacc_No3`, `CostCntr_Flag`, `Costcntr_No`, `Fbal_DB`, `Fbal_CR`, `Cr_Blnc`, `DB11`, `CR11`, `DB12`, `CR12`, `DB13`, `CR13`, `DB14`, `CR14`, `DB15`, `CR15`, `DB16`, `CR16`, `DB17`, `CR17`, `DB18`, `CR18`, `DB19`, `CR19`, `DB20`, `CR20`, `DB21`, `CR21`, `DB22`, `CR22`, `Acc_Dt`, `Acc_DtAr`, `Acc_Actv`, `ComplxFbal_DB`, `ComplxFbal_CR`, `User_Id`, `Updt_Time`, `created_at`, `updated_at`) VALUES
(123, 2, 30205, 302, '1', 3, 1, 1, 'غرامات تقصير اعمال الصيانه والتشغيل', 'غرامات تقصير اعمال الصيانه والتشغيل', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:51:46', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:51:46', '2019-12-07 09:51:46', '2019-12-07 11:37:24'),
(124, 2, 30206, 302, '1', 3, 1, 1, 'عمولات مستخلصات', 'عمولات مستخلصات', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:52:48', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:52:48', '2019-12-07 09:52:48', '2019-12-07 11:37:24'),
(125, 2, 303, 3, '1', 2, 1, 0, 'المصاريف العموميه والاداريه', 'المصاريف العموميه والاداريه', NULL, NULL, NULL, NULL, NULL, 106621.0000000000, 750.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:54:05', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:54:05', '2019-12-07 09:54:05', '2019-12-07 11:37:24'),
(126, 2, 30301, 303, NULL, 3, 2, 1, 'مصاريف الهواتف والاتصالات والانترنت', 'مصاريف الهواتف والاتصالات والانترنت', NULL, NULL, NULL, NULL, NULL, 513.0000000000, 750.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:55:14', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:55:14', '2019-12-07 09:55:14', '2019-12-07 11:37:24'),
(127, 2, 30302, 303, NULL, 3, 1, 1, 'مصاريف انتقال وتنقل (ليموزين)', 'مصاريف انتقال وتنقل (ليموزين)', NULL, NULL, NULL, NULL, NULL, 3739.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:56:42', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:56:42', '2019-12-07 09:56:42', '2019-12-07 11:37:24'),
(128, 2, 30303, 303, '1', 3, 1, 1, 'مصاريف بنزين ومحروقات', 'مصاريف بنزين ومحروقات', NULL, NULL, NULL, NULL, NULL, 2802.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:57:43', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:57:43', '2019-12-07 09:57:43', '2019-12-07 11:37:24'),
(129, 2, 30304, 303, '1', 3, 1, 1, 'مصاريف عدد وادوات', 'مصاريف عدد وادوات', NULL, NULL, NULL, NULL, NULL, 1422.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:58:37', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:58:37', '2019-12-07 09:58:37', '2019-12-07 11:37:24'),
(130, 2, 30305, 303, '1', 3, 1, 1, 'مصاريف ادوات السباكه', 'مصاريف ادوات السباكه', NULL, NULL, NULL, NULL, NULL, 127.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 11:59:24', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 11:59:24', '2019-12-07 09:59:24', '2019-12-07 11:37:25'),
(131, 2, 30306, 303, '1', 3, 1, 1, 'مصاريف الادوات الكهربائيه', 'مصاريف الادوات الكهربائيه', NULL, NULL, NULL, NULL, NULL, 190.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:00:22', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:00:22', '2019-12-07 10:00:22', '2019-12-07 11:37:25'),
(132, 2, 30307, 303, '1', 3, 1, 1, 'مصاريف الادوات المكتبيه والمطبوعات', 'مصاريف الادوات المكتبيه والمطبوعات', NULL, NULL, NULL, NULL, NULL, 445.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:01:17', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:01:17', '2019-12-07 10:01:17', '2019-12-07 11:37:25'),
(133, 2, 30308, 303, '1', 3, 1, 1, 'مصاريف ادوات النظافه', 'مصاريف ادوات النظافه', NULL, NULL, NULL, NULL, NULL, 65.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:02:11', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:02:11', '2019-12-07 10:02:11', '2019-12-07 11:37:25'),
(134, 2, 30309, 303, '1', 3, 1, 1, 'مصاريف الزي الموحد', 'مصاريف الزي الموحد', NULL, NULL, NULL, NULL, NULL, 1300.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:10:46', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:10:46', '2019-12-07 10:10:46', '2019-12-07 11:37:25'),
(135, 2, 30310, 303, '1', 3, 1, 1, 'مصاريف ايجار السيارات', 'مصاريف ايجار السيارات', NULL, NULL, NULL, NULL, NULL, 7676.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:11:43', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:11:43', '2019-12-07 10:11:43', '2019-12-07 11:37:25'),
(136, 2, 30311, 303, '1', 3, 1, 1, 'مصاريف ايجار شقق وفنادق', 'مصاريف ايجار شقق وفنادق', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:12:37', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:12:37', '2019-12-07 10:12:37', '2019-12-07 11:37:25'),
(137, 2, 30312, 303, '1', 3, 1, 1, 'مصاريف الرسوم الحكوميه', 'مصاريف الرسوم الحكوميه', NULL, NULL, NULL, NULL, NULL, 2703.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:14:28', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:14:28', '2019-12-07 10:14:28', '2019-12-07 11:37:25'),
(138, 2, 30313, 303, '1', 3, 1, 1, 'مصاريف الرواتب والاجور للاداره', 'مصاريف الرواتب والاجور للاداره', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:15:27', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:15:27', '2019-12-07 10:15:27', '2019-12-07 11:37:25'),
(139, 2, 30314, 303, '1', 3, 1, 1, 'مصاريف الغرامات الحكوميه', 'مصاريف الغرامات الحكوميهؤ', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:16:13', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:16:13', '2019-12-07 10:16:13', '2019-12-07 11:37:25'),
(140, 2, 30315, 303, '1', 3, 1, 1, 'مصاريف فحص العماله', 'مصاريف فحص العماله', NULL, NULL, NULL, NULL, NULL, 4000.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:17:10', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:17:10', '2019-12-07 10:17:10', '2019-12-07 11:37:25'),
(141, 2, 30316, 303, '1', 3, 1, 0, 'مصاريف متنوعه', 'مصاريف متنوعه', NULL, NULL, NULL, NULL, NULL, 2505.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:18:04', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:18:04', '2019-12-07 10:18:04', '2019-12-07 11:37:25'),
(142, 2, 3031601, 30316, '1', 4, 1, 1, 'عهدة فهد القرشي', 'عهدة فهد القرشي', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:18:55', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:18:55', '2019-12-07 10:18:55', '2019-12-07 11:37:25'),
(143, 2, 3031602, 30316, '1', 4, 1, 1, 'عهدة محمد انور', 'عهدة محمد انور', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:19:45', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:19:45', '2019-12-07 10:19:45', '2019-12-07 11:37:25'),
(144, 2, 3031603, 30316, '1', 4, 1, 1, 'عهدة عبدالله مناوي', 'عهدة عبدالله مناوي', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:20:34', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:20:34', '2019-12-07 10:20:34', '2019-12-07 11:37:25'),
(145, 2, 30317, 303, '1', 3, 1, 1, 'مصاريف نقل العمال(باصات)', 'مصاريف نقل العمال(باصات)', NULL, NULL, NULL, NULL, NULL, 280.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:21:53', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:21:53', '2019-12-07 10:21:53', '2019-12-07 11:37:25'),
(146, 2, 30318, 303, '1', 3, 1, 1, 'مصاريف ايجار سكن عمال المطار', 'مصاريف ايجار سكن عمال المطار', NULL, NULL, NULL, NULL, NULL, 8090.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:22:43', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:22:43', '2019-12-07 10:22:43', '2019-12-07 11:37:25'),
(147, 2, 30319, 303, '1', 3, 1, 1, 'مصاريف نقل وتحميل', 'مصاريف نقل وتحميل', NULL, NULL, NULL, NULL, NULL, 1006.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:23:31', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:23:31', '2019-12-07 10:23:31', '2019-12-07 11:37:25'),
(148, 2, 30320, 303, '1', 3, 1, 1, 'مصاريف غاز وفريون', 'مصاريف غاز وفريون', NULL, NULL, NULL, NULL, NULL, 200.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:24:19', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:24:19', '2019-12-07 10:24:19', '2019-12-07 11:37:25'),
(149, 2, 30321, 303, '1', 3, 1, 1, 'مصاريف ضيافه وغداء', 'مصاريف ضيافه وغداء', NULL, NULL, NULL, NULL, NULL, 302.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:25:07', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:25:07', '2019-12-07 10:25:07', '2019-12-07 11:37:25'),
(150, 2, 30322, 303, '1', 3, 1, 1, 'مصاريف العمل الاضافي والاكراميات', 'مصاريف العمل الاضافي والاكراميات', NULL, NULL, NULL, NULL, NULL, 1824.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:25:58', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:25:58', '2019-12-07 10:25:58', '2019-12-07 11:37:26'),
(151, 2, 30323, 303, '1', 3, 1, 1, 'صيانة سنترالات والشبكه الهاتفيه بالوزاره', 'صيانة سنترالات والشبكه الهاتفيه بالوزاره', NULL, NULL, NULL, NULL, NULL, 42000.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:27:05', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:27:05', '2019-12-07 10:27:05', '2019-12-07 11:37:26'),
(152, 2, 30324, 303, '1', 3, 1, 1, 'مصاريف صيانه ومكيفات', 'مصاريف صيانه ومكيفات', NULL, NULL, NULL, NULL, NULL, 3147.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:37:22', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:37:22', '2019-12-07 10:37:22', '2019-12-07 11:37:26'),
(153, 2, 30325, 303, NULL, 3, 1, 1, 'مصاريف جزم واحذيه', 'مصاريف جزم واحذيه', NULL, NULL, NULL, NULL, NULL, 367.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:38:33', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:38:33', '2019-12-07 10:38:33', '2019-12-07 11:37:26'),
(154, 2, 30326, 303, '1', 3, 1, 1, 'مصاريف المياه والصرف الصحي', 'مصاريف المياه والصرف الصحي', NULL, NULL, NULL, NULL, NULL, 143.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:40:30', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:40:30', '2019-12-07 10:40:30', '2019-12-07 11:37:26'),
(155, 2, 30327, 303, '1', 3, 1, 1, 'مصاريف مخالفات مروريه', 'مصاريف مخالفات مروريه', NULL, NULL, NULL, NULL, NULL, 1365.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:41:40', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:41:40', '2019-12-07 10:41:40', '2019-12-07 11:37:26'),
(156, 2, 30328, 303, '1', 3, 1, 1, 'مصاريف ايجار معدات', 'مصاريف ايجار معدات', NULL, NULL, NULL, NULL, NULL, 35.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:42:33', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:42:33', '2019-12-07 10:42:33', '2019-12-07 11:37:26'),
(157, 2, 30329, 303, '1', 3, 1, 1, 'ايجار سكن الرويس', 'ايجار سكن الرويس', NULL, NULL, NULL, NULL, NULL, 15000.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:44:29', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:44:29', '2019-12-07 10:44:29', '2019-12-07 11:37:26'),
(158, 2, 30330, 303, '1', 3, 1, 1, 'مصاريف اقساط سيارة (كيا ريو)', 'مصاريف اقساط سيارة (كيا ريو)', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:45:38', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:45:38', '2019-12-07 10:45:38', '2019-12-07 11:37:26'),
(159, 2, 30331, 303, '1', 3, 1, 1, 'مصاريف صيانه واصلاح', 'مصاريف صيانه واصلاح', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:46:36', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:46:36', '2019-12-07 10:46:36', '2019-12-07 11:37:26'),
(160, 2, 30332, 303, '1', 3, 1, 1, 'كهرباء وماء', 'كهرباء وماء', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:47:23', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:47:23', '2019-12-07 10:47:23', '2019-12-07 11:37:26'),
(161, 2, 304, 3, '1', 2, 1, 1, 'مصاريف البيع والتوزيع', 'مصاريف البيع والتوزيع', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:48:25', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:48:25', '2019-12-07 10:48:25', '2019-12-07 11:37:26'),
(162, 2, 401, 4, '1', 2, 1, 0, 'المبيعات', 'المبيعات', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:49:15', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:49:15', '2019-12-07 10:49:15', '2019-12-07 11:38:45'),
(163, 2, 40101, 401, '1', 3, 1, 1, 'المبيعات الاجله', 'المبيعات الاجله', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:49:59', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:49:59', '2019-12-07 10:49:59', '2019-12-07 11:38:45'),
(164, 2, 40102, 401, '1', 3, 1, 1, 'المبيعات النقديه', 'المبيعات النقديه', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:50:45', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:50:45', '2019-12-07 10:50:45', '2019-12-07 11:38:45'),
(165, 2, 40103, 401, '1', 3, 1, 1, 'المبيعات الخارجيه', 'المبيعات الخارجيه', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:51:42', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:51:42', '2019-12-07 10:51:42', '2019-12-07 11:38:45'),
(166, 2, 40104, 401, '1', 3, 1, 1, 'مرتجع المبيعات', 'مرتجع المبيعات', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:52:24', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:52:24', '2019-12-07 10:52:24', '2019-12-07 11:38:45'),
(167, 2, 402, 4, '1', 2, 1, 0, 'ايرادات اخرى', 'ايرادات اخرى', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:53:32', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:53:32', '2019-12-07 10:53:32', '2019-12-07 11:38:45'),
(168, 2, 40201, 402, '1', 3, 1, 1, 'ايرادات اخرى متنوعه', 'ايرادات اخرى متنوعه', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:54:17', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:54:17', '2019-12-07 10:54:17', '2019-12-07 11:38:45'),
(169, 2, 40202, 402, '1', 3, 1, 1, 'ايرادات المستخلصات', 'ايرادات المستخلصات', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:55:01', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:55:01', '2019-12-07 10:55:01', '2019-12-07 11:38:46'),
(170, 2, 40203, 402, '1', 3, 1, 1, 'ايرادات مستخلصات قطع الغيار', 'ايرادات مستخلصات قطع الغيار', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-07 12:55:56', '1441-04-10', 1, NULL, NULL, 1, '2019-12-07 12:55:56', '2019-12-07 10:55:56', '2019-12-07 11:38:46'),
(175, 3, 1, 0, NULL, 1, NULL, 0, 'الاصول للعمره', 'الاصول للعمره', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-08 09:32:28', '1441-04-11', 1, NULL, NULL, 1, '2019-12-08 09:32:28', '2019-12-08 07:32:28', '2019-12-08 07:32:28'),
(176, 3, 101, 1, '1', 2, 1, 1, 'اصول متداوله', 'اصول متداوله', NULL, NULL, NULL, NULL, NULL, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-10 09:14:28', '1441-04-13', 1, NULL, NULL, 1, '2019-12-10 09:14:28', '2019-12-10 07:14:28', '2019-12-10 07:14:28'),
(177, 4, 1, 0, NULL, 1, NULL, 0, 'اصول العمره', 'اصول العمره', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-24 15:06:39', '1441-04-27', 1, NULL, NULL, 1, '2019-12-24 15:06:39', '2019-12-24 13:06:39', '2019-12-24 13:06:39');

-- --------------------------------------------------------

--
-- Table structure for table `mtsclosacc`
--

CREATE TABLE `mtsclosacc` (
  `ID_No` int(10) UNSIGNED NOT NULL,
  `Cmp_No` int(11) NOT NULL,
  `CLsacc_No` bigint(20) NOT NULL,
  `Parnt_Acc` bigint(20) NOT NULL,
  `Level_Status` int(11) NOT NULL,
  `Level_No` int(11) NOT NULL,
  `Main_Rpt` int(11) NOT NULL,
  `CLsacc_NmAr` varchar(200) NOT NULL,
  `CLsacc_NmEn` varchar(200) NOT NULL,
  `Prnt_YN` int(11) NOT NULL,
  `Prnt_Sorc` varchar(100) NOT NULL,
  `Fbal_DB` double(50,10) NOT NULL,
  `Fbal_CR` double(50,10) NOT NULL,
  `DB11` double(50,10) NOT NULL,
  `CR11` double(50,10) NOT NULL,
  `DB12` double(50,10) NOT NULL,
  `CR12` double(50,10) NOT NULL,
  `DB13` double(50,10) NOT NULL,
  `CR13` double(50,10) NOT NULL,
  `DB14` double(50,10) NOT NULL,
  `CR14` double(50,10) NOT NULL,
  `DB15` double(50,10) NOT NULL,
  `CR15` double(50,10) NOT NULL,
  `DB16` double(50,10) NOT NULL,
  `CR16` double(50,10) NOT NULL,
  `DB17` double(50,10) NOT NULL,
  `CR17` double(50,10) NOT NULL,
  `DB18` double(50,10) NOT NULL,
  `CR18` double(50,10) NOT NULL,
  `DB19` double(50,10) NOT NULL,
  `CR19` double(50,10) NOT NULL,
  `DB20` double(50,10) NOT NULL,
  `CR20` double(50,10) NOT NULL,
  `DB21` double(50,10) NOT NULL,
  `CR21` double(50,10) NOT NULL,
  `DB22` double(50,10) NOT NULL,
  `CR22` double(50,10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mtsclosacc`
--

INSERT INTO `mtsclosacc` (`ID_No`, `Cmp_No`, `CLsacc_No`, `Parnt_Acc`, `Level_Status`, `Level_No`, `Main_Rpt`, `CLsacc_NmAr`, `CLsacc_NmEn`, `Prnt_YN`, `Prnt_Sorc`, `Fbal_DB`, `Fbal_CR`, `DB11`, `CR11`, `DB12`, `CR12`, `DB13`, `CR13`, `DB14`, `CR14`, `DB15`, `CR15`, `DB16`, `CR16`, `DB17`, `CR17`, `DB18`, `CR18`, `DB19`, `CR19`, `DB20`, `CR20`, `DB21`, `CR21`, `DB22`, `CR22`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, 0, 1, 0, 'بنود الميزانية', '', 0, '', 60801240.4800000000, 60801240.4800000000, 1264452.2200000000, 1245279.8220000000, 1347286.3800000000, 1429026.3700000000, 1871309.9800000000, 1674204.6700000000, 1227433.0000000000, 1292371.0080000000, 1516303.0900000000, 1577150.3510000000, 807352.0100000000, 686387.1500000000, 1217328.5500000000, 1521761.2800000000, 917703.1900000000, 945747.2400000000, 855352.4600000000, 722063.5700000000, 1051532.4500000000, 1058756.2400000000, 1257441.7300000000, 1456431.8840000000, 1599315.8800000000, 1439944.0200000000, '2019-12-30 22:00:00', '2019-12-30 22:00:00'),
(2, 1, 2, 0, 0, 1, 0, 'بنود قائمة الدخل', '', 0, '', 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 197081.1300000000, 282818.5000000000, 176945.8500000000, 339972.0000000000, 231634.2200000000, 331909.0000000000, 273827.3100000000, 314634.6000000000, 550529.4100000000, 635672.7500000000, NULL, NULL),
(3, 1, 101, 1, 0, 2, 1, 'الاصول المتداولة', '', 0, '', 35899294.6500000000, 8092548.5000000000, 1136701.0600000000, 1245279.8220000000, 1341126.3800000000, 1429026.3700000000, 1829569.9800000000, 1674204.6700000000, 1227433.0000000000, 1292371.0080000000, 1506303.0900000000, 1577150.3510000000, 792352.0100000000, 686387.1500000000, 1212648.5500000000, 1521761.2800000000, 895456.1900000000, 945747.2400000000, 855352.4600000000, 722063.5700000000, 1040897.4500000000, 1058756.2400000000, 1256441.7300000000, 1456431.8840000000, 1599315.8800000000, 1420226.0200000000, NULL, NULL),
(4, 1, 102, 1, 0, 2, 1, 'الخصوم المتداولة', '', 0, '', 0.0000000000, 22968049.1300000000, 127751.1600000000, 0.0000000000, 6160.0000000000, 0.0000000000, 41740.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 10000.0000000000, 0.0000000000, 15000.0000000000, 0.0000000000, 4680.0000000000, 0.0000000000, 22247.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 10635.0000000000, 0.0000000000, 1000.0000000000, 0.0000000000, 0.0000000000, 19718.0000000000, NULL, NULL),
(5, 1, 103, 1, 0, 2, 1, 'راس المال العامل', '', 0, '', 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL),
(6, 1, 104, 1, 0, 2, 1, 'الاصول طويلة الاجل', '', 0, '', 24901945.8300000000, 20070037.5100000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL),
(7, 1, 105, 1, 0, 2, 1, 'اجمالى الاستثمار', '', 0, '', 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL),
(8, 1, 106, 1, 0, 2, 1, 'الخصوم غير المتداولة', '', 0, '', 0.0000000000, 93454.5000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL),
(9, 1, 107, 1, 0, 2, 1, 'حقوق الملكية', '', 0, '', 0.0000000000, 9577150.8400000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL),
(10, 1, 108, 1, 0, 2, 1, 'اجمالى الخصوم غير المتداولة وحقوق الملكية', '', 0, '', 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL),
(11, 1, 201, 2, 1, 2, 2, 'ايرادات العمليات ', '', 0, '', 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 282818.5000000000, 0.0000000000, 339972.0000000000, 7524.0000000000, 331909.0000000000, 0.0000000000, 314553.0000000000, 0.0000000000, 635672.7500000000, NULL, NULL),
(12, 1, 202, 2, 1, 2, 2, 'تكاليف العمليات ', '', 0, '', 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 117919.8000000000, 0.0000000000, 119163.7900000000, 0.0000000000, 133814.3300000000, 0.0000000000, 175687.5300000000, 0.0000000000, 326414.5100000000, 0.0000000000, NULL, NULL),
(13, 1, 203, 2, 0, 2, 2, 'مجمل ربح العمليات ', '', 0, '', 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL),
(14, 1, 204, 2, 1, 2, 2, 'مصروفات النشاط ', '', 0, '', 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 79161.3300000000, 0.0000000000, 57782.0600000000, 0.0000000000, 90295.8900000000, 0.0000000000, 98139.7800000000, 0.0000000000, 224114.9000000000, 0.0000000000, NULL, NULL),
(15, 1, 205, 2, 0, 2, 2, 'صافى ربح النشاط ', '', 0, '', 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL),
(16, 1, 206, 2, 0, 2, 2, 'ارباح رأسمالية ', '', 0, '', 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL),
(17, 1, 207, 2, 0, 2, 2, 'ايرادات اخرى ', '', 0, '', 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL),
(18, 1, 208, 2, 0, 2, 2, 'صافى ربح العام ', '', 0, '', 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL),
(19, 1, 10101, 101, 1, 3, 1, 'نقدية لدى البنوك والصندوق ', '', 0, '', 260117.7100000000, 713582.9100000000, 817640.9300000000, 781988.8920000000, 951995.0000000000, 903899.3700000000, 1085999.7600000000, 1058010.9100000000, 822335.9000000000, 784916.1080000000, 1113991.8200000000, 982158.5310000000, 389329.1800000000, 510868.9700000000, 958668.8500000000, 733179.4300000000, 547796.7700000000, 662450.4700000000, 455981.8500000000, 419081.7200000000, 669135.0000000000, 485297.2400000000, 858428.9000000000, 1088184.5840000000, 806525.8900000000, 798700.1300000000, NULL, NULL),
(20, 1, 10110, 101, 1, 3, 1, 'تأمينات خطابات ضمان واعتمادات مستندية ', '', 0, '', 14127605.8400000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL),
(21, 1, 10120, 101, 1, 3, 1, 'ذمم مدينة بالصافى ', '', 0, '', 18884041.3200000000, 7333364.1900000000, 319060.1300000000, 463290.9300000000, 389131.3800000000, 525127.0000000000, 743570.2200000000, 616193.7600000000, 405097.1000000000, 507454.9000000000, 392311.2700000000, 594991.8200000000, 403022.8300000000, 175518.1800000000, 253979.7000000000, 788581.8500000000, 297659.4200000000, 283296.7700000000, 359370.6100000000, 197981.8500000000, 350762.4500000000, 573459.0000000000, 327900.6500000000, 356247.3000000000, 662789.9900000000, 491525.8900000000, NULL, NULL),
(22, 1, 10130, 101, 1, 3, 1, 'ارصدة مدينة اخرى ومصروفات مقدمة ', '', 0, '', 1881315.4600000000, 45601.4000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 50000.0000000000, 0.0000000000, 40000.0000000000, 105000.0000000000, 21000.0000000000, 0.0000000000, 70112.1800000000, 12000.0000000000, 130000.0000000000, 130000.0000000000, NULL, NULL),
(23, 1, 10140, 101, 1, 3, 1, 'جارى قسم المدنى ', '', 0, '', 746214.3200000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL),
(24, 1, 10201, 102, 1, 3, 1, 'بنك سحب على المكشوف ', '', 0, '', 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, NULL, NULL),
(25, 1, 10210, 102, 1, 3, 1, 'ذمم دائنة ', '', 0, '', 0.0000000000, 11522794.7200000000, 0.0000000000, 0.0000000000, 5000.0000000000, 0.0000000000, 10000.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 19000.0000000000, 0.0000000000, 0.0000000000, 0.0000000000, 10635.0000000000, 0.0000000000, 1000.0000000000, 0.0000000000, 0.0000000000, 13653.0000000000, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mtscustomer`
--

CREATE TABLE `mtscustomer` (
  `ID_No` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `Cmp_No` int(11) DEFAULT NULL,
  `Brn_No` int(11) DEFAULT NULL,
  `Cstm_No` bigint(20) DEFAULT NULL,
  `Cstm_Active` tinyint(1) DEFAULT NULL,
  `Cstm_Ctg` int(11) DEFAULT NULL,
  `Cstm_Refno` varchar(20) DEFAULT NULL,
  `Internal_Invoice` tinyint(1) DEFAULT NULL,
  `Acc_No` bigint(20) DEFAULT NULL,
  `Cstm_NmEn` varchar(200) DEFAULT NULL,
  `Cstm_NmAr` varchar(200) NOT NULL,
  `Catg_No` int(11) DEFAULT NULL,
  `Slm_No` int(11) DEFAULT NULL,
  `Mrkt_No` int(11) DEFAULT NULL,
  `Nutr_No` int(11) DEFAULT NULL,
  `Cntry_No` int(11) DEFAULT NULL,
  `City_No` int(11) DEFAULT NULL,
  `Area_No` int(11) DEFAULT NULL,
  `Credit_Value` decimal(8,2) DEFAULT NULL,
  `Credit_Days` int(11) DEFAULT NULL,
  `Cstm_Adr` varchar(200) DEFAULT NULL,
  `Cstm_POBox` varchar(40) DEFAULT NULL,
  `Cstm_ZipCode` varchar(191) DEFAULT NULL,
  `Cstm_Rsp` varchar(100) DEFAULT NULL,
  `Cstm_Othr` varchar(40) DEFAULT NULL,
  `Cstm_Email` varchar(191) DEFAULT NULL,
  `Cstm_Tel` varchar(50) DEFAULT NULL,
  `Cstm_Fax` varchar(15) DEFAULT NULL,
  `Cntct_Prsn1` varchar(50) DEFAULT NULL,
  `Cntct_Prsn2` varchar(50) DEFAULT NULL,
  `Cntct_Prsn3` varchar(50) DEFAULT NULL,
  `Cntct_Prsn4` varchar(50) DEFAULT NULL,
  `Cntct_Prsn5` varchar(50) DEFAULT NULL,
  `TitL1` varchar(50) DEFAULT NULL,
  `TitL2` varchar(50) DEFAULT NULL,
  `TitL3` varchar(50) DEFAULT NULL,
  `TitL4` varchar(50) DEFAULT NULL,
  `TitL5` varchar(50) DEFAULT NULL,
  `Mobile1` varchar(15) DEFAULT NULL,
  `Mobile2` varchar(15) DEFAULT NULL,
  `Mobile3` varchar(15) DEFAULT NULL,
  `Mobile4` varchar(15) DEFAULT NULL,
  `Mobile5` varchar(15) DEFAULT NULL,
  `Email1` varchar(50) DEFAULT NULL,
  `Email2` varchar(50) DEFAULT NULL,
  `Email3` varchar(50) DEFAULT NULL,
  `Email4` varchar(50) DEFAULT NULL,
  `Email5` varchar(50) DEFAULT NULL,
  `Tel1` varchar(15) DEFAULT NULL,
  `Tel2` varchar(50) DEFAULT NULL,
  `Tel3` varchar(50) DEFAULT NULL,
  `Mobile` varchar(15) DEFAULT NULL,
  `Fbal_Db` decimal(8,2) DEFAULT NULL,
  `Fbal_CR` decimal(8,2) DEFAULT NULL,
  `CR11` decimal(8,2) DEFAULT NULL,
  `CR12` decimal(8,2) DEFAULT NULL,
  `CR13` decimal(8,2) DEFAULT NULL,
  `CR14` decimal(8,2) DEFAULT NULL,
  `CR15` decimal(8,2) DEFAULT NULL,
  `CR16` decimal(8,2) DEFAULT NULL,
  `CR17` decimal(8,2) DEFAULT NULL,
  `CR18` decimal(8,2) DEFAULT NULL,
  `CR19` decimal(8,2) DEFAULT NULL,
  `CR20` decimal(8,2) DEFAULT NULL,
  `CR21` decimal(8,2) DEFAULT NULL,
  `CR22` decimal(8,2) DEFAULT NULL,
  `DB11` decimal(8,2) DEFAULT NULL,
  `DB12` decimal(8,2) DEFAULT NULL,
  `DB13` decimal(8,2) DEFAULT NULL,
  `DB14` decimal(8,2) DEFAULT NULL,
  `DB15` decimal(8,2) DEFAULT NULL,
  `DB16` decimal(8,2) DEFAULT NULL,
  `DB17` decimal(8,2) DEFAULT NULL,
  `DB18` decimal(8,2) DEFAULT NULL,
  `DB19` decimal(8,2) DEFAULT NULL,
  `DB20` decimal(8,2) DEFAULT NULL,
  `DB21` decimal(8,2) DEFAULT NULL,
  `DB22` decimal(8,2) DEFAULT NULL,
  `Opn_Date` date DEFAULT NULL,
  `Opn_Time` time DEFAULT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `Updt_Date` datetime DEFAULT NULL,
  `Cstm_Agrmnt` int(11) DEFAULT NULL,
  `Disc_prct` int(11) DEFAULT NULL,
  `Itm_Sal` int(11) DEFAULT NULL,
  `Linv_No` bigint(20) DEFAULT NULL,
  `Linv_Dt` varchar(191) DEFAULT NULL,
  `Linv_Net` decimal(8,2) DEFAULT NULL,
  `LRcpt_No` bigint(20) DEFAULT NULL,
  `LRcpt_Dt` varchar(10) DEFAULT NULL,
  `LRcpt_Db` decimal(8,2) DEFAULT NULL,
  `Notes` varchar(40) DEFAULT NULL,
  `Tax_No` varchar(20) DEFAULT NULL,
  `AgeNot_Calculate` tinyint(1) DEFAULT NULL,
  `Deserve_Discount` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mtscustomer`
--

INSERT INTO `mtscustomer` (`ID_No`, `created_at`, `updated_at`, `Cmp_No`, `Brn_No`, `Cstm_No`, `Cstm_Active`, `Cstm_Ctg`, `Cstm_Refno`, `Internal_Invoice`, `Acc_No`, `Cstm_NmEn`, `Cstm_NmAr`, `Catg_No`, `Slm_No`, `Mrkt_No`, `Nutr_No`, `Cntry_No`, `City_No`, `Area_No`, `Credit_Value`, `Credit_Days`, `Cstm_Adr`, `Cstm_POBox`, `Cstm_ZipCode`, `Cstm_Rsp`, `Cstm_Othr`, `Cstm_Email`, `Cstm_Tel`, `Cstm_Fax`, `Cntct_Prsn1`, `Cntct_Prsn2`, `Cntct_Prsn3`, `Cntct_Prsn4`, `Cntct_Prsn5`, `TitL1`, `TitL2`, `TitL3`, `TitL4`, `TitL5`, `Mobile1`, `Mobile2`, `Mobile3`, `Mobile4`, `Mobile5`, `Email1`, `Email2`, `Email3`, `Email4`, `Email5`, `Tel1`, `Tel2`, `Tel3`, `Mobile`, `Fbal_Db`, `Fbal_CR`, `CR11`, `CR12`, `CR13`, `CR14`, `CR15`, `CR16`, `CR17`, `CR18`, `CR19`, `CR20`, `CR21`, `CR22`, `DB11`, `DB12`, `DB13`, `DB14`, `DB15`, `DB16`, `DB17`, `DB18`, `DB19`, `DB20`, `DB21`, `DB22`, `Opn_Date`, `Opn_Time`, `User_ID`, `Updt_Date`, `Cstm_Agrmnt`, `Disc_prct`, `Itm_Sal`, `Linv_No`, `Linv_Dt`, `Linv_Net`, `LRcpt_No`, `LRcpt_Dt`, `LRcpt_Db`, `Notes`, `Tax_No`, `AgeNot_Calculate`, `Deserve_Discount`) VALUES
(1, '2019-12-03 11:34:13', '2019-12-04 11:05:47', 2, 2, 10001, NULL, NULL, NULL, NULL, NULL, NULL, 'دي لوجستيكس', 0, 1, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'عبداالطيف صوبرا', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '011-2816362', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, '2019-12-03 11:36:09', '2019-12-03 11:36:09', 2, 2, 10002, NULL, 0, NULL, NULL, NULL, NULL, 'الشركة السعودية للمأكولات الخفيفة المحدودة', 0, 1, NULL, NULL, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ساعة 8.5 ريال  امتداد لعقد 1/4/2015', NULL, NULL, NULL),
(4, '2019-12-03 11:38:03', '2019-12-03 11:38:03', 2, 2, 10003, NULL, 0, NULL, NULL, NULL, NULL, 'فندق السلام هوليداي إن', 0, 2, NULL, NULL, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ايمان بني محفوظ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '054 028 2002', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'عدد العمالة حاليا 4 فقط', NULL, NULL, NULL),
(5, '2019-12-03 11:40:04', '2019-12-03 11:40:04', 2, 2, 10004, NULL, 0, NULL, NULL, NULL, NULL, 'السنبلة', 0, 2, NULL, NULL, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'عبد الله المالكي', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '050 3358 774', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, '2019-12-03 11:41:17', '2019-12-03 11:41:17', 2, 2, 10005, NULL, 0, NULL, NULL, NULL, NULL, 'شركة ابداع التغليف المحدودة', 0, 1, NULL, NULL, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'احمد المربعي', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'تم ايقاف العقد قبل سنة تقريبا', NULL, NULL, NULL),
(7, '2019-12-03 11:42:05', '2019-12-03 11:42:05', 2, 2, 10006, NULL, 0, NULL, NULL, NULL, NULL, 'شركة مصنع حلول التعبئة و التغليف المحدودة', 0, 2, NULL, NULL, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'احمد المربعي', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, '2019-12-03 11:43:00', '2019-12-03 11:43:00', 2, 2, 10007, NULL, 0, NULL, NULL, NULL, NULL, 'مؤسسة الرواد المشرقة التجارية', 0, 2, NULL, NULL, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'نضال عبد الكريم', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, '2019-12-03 11:45:12', '2019-12-03 11:47:57', 2, 2, 10008, NULL, 0, NULL, NULL, NULL, NULL, 'صافولا لانظمة التغليف', 0, 1, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'نايف السفياني', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '012 657 3333', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, '2019-12-03 11:46:37', '2019-12-03 11:46:37', 2, 2, 10009, NULL, 0, NULL, NULL, NULL, NULL, 'مصنع الحلويات و الطحينة الوطني', 0, 1, NULL, NULL, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'احمد زيني', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '012 6380054', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ما زال العقد ساري رغم انتهائه لا يوجد مل', NULL, NULL, NULL),
(11, '2019-12-03 11:48:44', '2019-12-03 11:48:44', 2, 2, 10010, NULL, 0, NULL, NULL, NULL, NULL, 'مصنع الجزيرة', 0, 1, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'لا يوجد ارقام تواصل مع العميل', NULL, NULL, NULL),
(12, '2019-12-03 11:49:36', '2019-12-03 11:49:36', 2, 2, 10011, NULL, 0, NULL, NULL, NULL, NULL, 'العبيكان للمنسوجات الانشائية', 0, 2, NULL, NULL, 1, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '011 2839400', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, '2019-12-03 11:55:31', '2019-12-03 11:55:31', 2, 2, 10012, NULL, 0, NULL, NULL, NULL, NULL, 'عمر ابوبكر بالبيد', 0, 2, NULL, NULL, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ابو بكر بالبيد', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '012 6404444', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, '2019-12-03 11:56:22', '2019-12-03 11:56:22', 2, 2, 10013, NULL, 0, NULL, NULL, NULL, NULL, 'شركة عافية العالمية', 0, 1, NULL, NULL, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'اسامة عشى', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '012 6350000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, '2019-12-03 11:57:29', '2019-12-03 11:57:29', 2, 2, 10014, NULL, 0, NULL, NULL, NULL, NULL, 'مصنع شركة عالم الندوير الابداعي المحدودة', 0, 2, NULL, NULL, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'احمد المربعي', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'مستحقات متاخرة', NULL, NULL, NULL),
(16, '2019-12-03 11:58:32', '2019-12-03 11:58:32', 2, 2, 10015, NULL, 0, NULL, NULL, NULL, NULL, 'مؤسسة سعود حديد العتيبي', 0, 1, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'سعود حديد', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '553443559', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, '2019-12-03 11:59:31', '2019-12-03 11:59:31', 2, 2, 10016, NULL, 0, NULL, NULL, NULL, NULL, 'مصنع العبوات البلاستيكية - بلاستيكو', 0, 2, NULL, NULL, 1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'مناف بستنجي', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '012 635 5577', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'العدد الفعلي للعمال 42 عامل', NULL, NULL, NULL),
(18, '2019-12-04 07:24:19', '2019-12-04 07:24:19', 2, 2, 10017, NULL, 0, NULL, NULL, NULL, 'PDC-CJSC', 'PDC-CJSC', 0, 1, NULL, NULL, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'عمر باكربشات', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '012-6166019', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, '2019-12-04 11:39:59', '2020-01-08 11:36:33', 1, 3, 30001, 1, NULL, NULL, NULL, NULL, 'CUS', 'عميل', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '54545.00', '30000.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mts_costcntrs`
--

CREATE TABLE `mts_costcntrs` (
  `ID_No` int(10) UNSIGNED NOT NULL,
  `Cmp_No` int(10) UNSIGNED DEFAULT NULL,
  `Acc_No` bigint(20) DEFAULT NULL,
  `Parnt_Acc` bigint(20) DEFAULT NULL,
  `Level_No` int(11) DEFAULT NULL,
  `Level_Status` tinyint(1) DEFAULT NULL,
  `Costcntr_Nmar` varchar(191) DEFAULT NULL,
  `Costcntr_Nmen` varchar(191) DEFAULT NULL,
  `Costcntr_No` bigint(20) DEFAULT NULL,
  `Fbal_DB` double(50,10) DEFAULT NULL,
  `Fbal_CR` double(50,10) DEFAULT NULL,
  `DB11` double(50,10) DEFAULT NULL,
  `CR11` double(50,10) DEFAULT NULL,
  `DB12` double(50,10) DEFAULT NULL,
  `CR12` double(50,10) DEFAULT NULL,
  `DB13` double(50,10) DEFAULT NULL,
  `CR13` double(50,10) DEFAULT NULL,
  `DB14` double(50,10) DEFAULT NULL,
  `CR14` double(50,10) DEFAULT NULL,
  `DB15` double(50,10) DEFAULT NULL,
  `CR15` double(50,10) DEFAULT NULL,
  `DB16` double(50,10) DEFAULT NULL,
  `CR16` double(50,10) DEFAULT NULL,
  `DB17` double(50,10) DEFAULT NULL,
  `CR17` double(50,10) DEFAULT NULL,
  `DB18` double(50,10) DEFAULT NULL,
  `CR18` double(50,10) DEFAULT NULL,
  `DB19` double(50,10) DEFAULT NULL,
  `CR19` double(50,10) DEFAULT NULL,
  `DB20` double(50,10) DEFAULT NULL,
  `CR20` double(50,10) DEFAULT NULL,
  `DB21` double(50,10) DEFAULT NULL,
  `CR21` double(50,10) DEFAULT NULL,
  `DB22` double(50,10) DEFAULT NULL,
  `CR22` double(50,10) DEFAULT NULL,
  `Analyticl2_Flag` int(11) DEFAULT NULL,
  `Updt_Time` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mts_costcntrs`
--

INSERT INTO `mts_costcntrs` (`ID_No`, `Cmp_No`, `Acc_No`, `Parnt_Acc`, `Level_No`, `Level_Status`, `Costcntr_Nmar`, `Costcntr_Nmen`, `Costcntr_No`, `Fbal_DB`, `Fbal_CR`, `DB11`, `CR11`, `DB12`, `CR12`, `DB13`, `CR13`, `DB14`, `CR14`, `DB15`, `CR15`, `DB16`, `CR16`, `DB17`, `CR17`, `DB18`, `CR18`, `DB19`, `CR19`, `DB20`, `CR20`, `DB21`, `CR21`, `DB22`, `CR22`, `Analyticl2_Flag`, `Updt_Time`, `created_at`, `updated_at`) VALUES
(4, 2, NULL, 0, 1, 0, 'مراكز التكلفه', 'مراكز التكلفه', 1, 341651.0000000000, 4500.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-09 10:32:41', '2019-12-09 08:25:54', '2019-12-09 08:32:41'),
(5, 2, NULL, 1, 2, 0, 'مشروع الصيانة والتشغيل', 'مشروع الصيانة والتشغيل', 101, 341651.0000000000, 4500.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-09 10:26:59', '2019-12-09 08:26:59', '2019-12-09 08:27:36'),
(6, 2, NULL, 101, 3, 1, 'ايرادات مشروع الصيانة والتشغيل', 'ايرادات مشروع الصيانة والتشغيل', 10101, 0.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-09 10:27:36', '2019-12-09 08:27:36', '2019-12-09 08:27:36'),
(7, 2, NULL, 101, 3, 1, 'مصروفات مشروع الصيانة والتشغيل', 'مصروفات مشروع الصيانة والتشغيل', 10102, 98274.0000000000, 4500.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-09 10:29:10', '2019-12-09 08:29:10', '2019-12-09 08:29:10'),
(8, 2, NULL, 101, 3, 1, 'وزارة الاعلام', 'وزارة الاعلام', 10103, 55706.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-09 10:29:49', '2019-12-09 08:29:49', '2019-12-09 08:29:49'),
(9, 2, NULL, 101, 3, 1, 'مبنى برج وزارة الاعلام', 'مبنى برج وزارة الاعلام', 10104, 125800.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-09 10:30:40', '2019-12-09 08:30:40', '2019-12-09 08:30:40'),
(10, 2, NULL, 101, 3, 1, 'وزارة الاعلام المطار', 'وزارة الاعلام المطار', 10105, 61871.0000000000, 0.0000000000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-09 10:32:58', '2019-12-09 08:31:25', '2019-12-09 08:32:58');

-- --------------------------------------------------------

--
-- Table structure for table `mts_suplirs`
--

CREATE TABLE `mts_suplirs` (
  `ID_No` int(10) UNSIGNED NOT NULL,
  `Cmp_No` int(11) DEFAULT NULL,
  `Brn_No` int(11) DEFAULT NULL,
  `Sup_No` int(11) DEFAULT NULL,
  `Sup_Active` tinyint(1) DEFAULT NULL,
  `Cstm_POBox` varchar(191) DEFAULT NULL,
  `Cstm_ZipCode` varchar(191) DEFAULT NULL,
  `Sup_Refno` varchar(191) DEFAULT NULL,
  `SupCtg_No` int(11) DEFAULT NULL,
  `Cntry_No` int(11) DEFAULT NULL,
  `Sup_NmEn` varchar(191) DEFAULT NULL,
  `Sup_NmAr` varchar(191) DEFAULT NULL,
  `Sup_Adr` varchar(191) DEFAULT NULL,
  `Sup_Rsp` varchar(191) DEFAULT NULL,
  `Sup_Othr` varchar(191) DEFAULT NULL,
  `Curncy_No` int(11) DEFAULT NULL,
  `Sup_Email` varchar(191) DEFAULT NULL,
  `note` varchar(191) DEFAULT NULL,
  `Sup_Tel1` varchar(191) DEFAULT NULL,
  `Sup_Tel2` varchar(191) DEFAULT NULL,
  `Mobile` varchar(191) DEFAULT NULL,
  `Sup_Fax` varchar(191) DEFAULT NULL,
  `Acc_No` bigint(20) DEFAULT NULL,
  `Credit_Value` double(8,2) DEFAULT NULL,
  `Credit_Days` int(11) DEFAULT NULL,
  `Fbal_Db` double(8,2) DEFAULT NULL,
  `Fbal_CR` double(8,2) DEFAULT NULL,
  `Cntct_Prsn1` varchar(191) DEFAULT NULL,
  `Cntct_Prsn2` varchar(191) DEFAULT NULL,
  `Cntct_Prsn3` varchar(191) DEFAULT NULL,
  `Cntct_Prsn4` varchar(191) DEFAULT NULL,
  `Cntct_Prsn5` varchar(191) DEFAULT NULL,
  `TitL1` varchar(191) DEFAULT NULL,
  `TitL2` varchar(191) DEFAULT NULL,
  `TitL3` varchar(191) DEFAULT NULL,
  `TitL4` varchar(191) DEFAULT NULL,
  `TitL5` varchar(191) DEFAULT NULL,
  `Mobile1` varchar(191) DEFAULT NULL,
  `Mobile2` varchar(191) DEFAULT NULL,
  `Mobile3` varchar(191) DEFAULT NULL,
  `Mobile4` varchar(191) DEFAULT NULL,
  `Mobile5` varchar(191) DEFAULT NULL,
  `Email1` varchar(191) DEFAULT NULL,
  `Email2` varchar(191) DEFAULT NULL,
  `Email3` varchar(191) DEFAULT NULL,
  `Email4` varchar(191) DEFAULT NULL,
  `Email5` varchar(191) DEFAULT NULL,
  `Linv_No` varchar(191) DEFAULT NULL,
  `Linv_Dt` varchar(191) DEFAULT NULL,
  `Linv_Net` double(8,2) DEFAULT NULL,
  `LRcpt_No` varchar(191) DEFAULT NULL,
  `LRcpt_Dt` varchar(191) DEFAULT NULL,
  `LRcpt_Db` double(8,2) DEFAULT NULL,
  `CBal` double(8,2) DEFAULT NULL,
  `TradeOffer` varchar(191) DEFAULT NULL,
  `CR11` double(8,2) DEFAULT NULL,
  `CR12` double(8,2) DEFAULT NULL,
  `CR13` double(8,2) DEFAULT NULL,
  `CR14` double(8,2) DEFAULT NULL,
  `CR15` double(8,2) DEFAULT NULL,
  `CR16` double(8,2) DEFAULT NULL,
  `CR17` double(8,2) DEFAULT NULL,
  `CR18` double(8,2) DEFAULT NULL,
  `CR19` double(8,2) DEFAULT NULL,
  `CR20` double(8,2) DEFAULT NULL,
  `CR21` double(8,2) DEFAULT NULL,
  `CR22` double(8,2) DEFAULT NULL,
  `DB11` double(8,2) DEFAULT NULL,
  `DB12` double(8,2) DEFAULT NULL,
  `DB13` double(8,2) DEFAULT NULL,
  `DB14` double(8,2) DEFAULT NULL,
  `DB15` double(8,2) DEFAULT NULL,
  `DB16` double(8,2) DEFAULT NULL,
  `DB17` double(8,2) DEFAULT NULL,
  `DB18` double(8,2) DEFAULT NULL,
  `DB19` double(8,2) DEFAULT NULL,
  `DB20` double(8,2) DEFAULT NULL,
  `DB21` double(8,2) DEFAULT NULL,
  `DB22` double(8,2) DEFAULT NULL,
  `Updt_Date` datetime DEFAULT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `Tax_No` int(11) DEFAULT NULL,
  `Opn_Date` varchar(191) DEFAULT NULL,
  `Opn_Time` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mts_suplirs`
--

INSERT INTO `mts_suplirs` (`ID_No`, `Cmp_No`, `Brn_No`, `Sup_No`, `Sup_Active`, `Cstm_POBox`, `Cstm_ZipCode`, `Sup_Refno`, `SupCtg_No`, `Cntry_No`, `Sup_NmEn`, `Sup_NmAr`, `Sup_Adr`, `Sup_Rsp`, `Sup_Othr`, `Curncy_No`, `Sup_Email`, `note`, `Sup_Tel1`, `Sup_Tel2`, `Mobile`, `Sup_Fax`, `Acc_No`, `Credit_Value`, `Credit_Days`, `Fbal_Db`, `Fbal_CR`, `Cntct_Prsn1`, `Cntct_Prsn2`, `Cntct_Prsn3`, `Cntct_Prsn4`, `Cntct_Prsn5`, `TitL1`, `TitL2`, `TitL3`, `TitL4`, `TitL5`, `Mobile1`, `Mobile2`, `Mobile3`, `Mobile4`, `Mobile5`, `Email1`, `Email2`, `Email3`, `Email4`, `Email5`, `Linv_No`, `Linv_Dt`, `Linv_Net`, `LRcpt_No`, `LRcpt_Dt`, `LRcpt_Db`, `CBal`, `TradeOffer`, `CR11`, `CR12`, `CR13`, `CR14`, `CR15`, `CR16`, `CR17`, `CR18`, `CR19`, `CR20`, `CR21`, `CR22`, `DB11`, `DB12`, `DB13`, `DB14`, `DB15`, `DB16`, `DB17`, `DB18`, `DB19`, `DB20`, `DB21`, `DB22`, `Updt_Date`, `User_ID`, `Tax_No`, `Opn_Date`, `Opn_Time`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 2, 1, '55555', '55555', NULL, 1, 1, 'مورد 1', 'مورد 1', 'عنوان 1', NULL, NULL, 0, 'supplier1@example.com', 'ملاحظات 1', '0101254478', NULL, '01000', '55145', NULL, 10000.00, 30, NULL, NULL, 'مسؤل 1', NULL, NULL, NULL, NULL, 'وظيفه 1', NULL, NULL, NULL, NULL, '010000000', NULL, NULL, NULL, NULL, 'suplier1@example.com', NULL, NULL, NULL, NULL, '555', '2019-12-04', 2000.00, '4545', '2019-12-18', 500.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-09 09:05:32', '2019-12-09 10:44:31');

-- --------------------------------------------------------

--
-- Table structure for table `nations`
--

CREATE TABLE `nations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name_ar` varchar(191) NOT NULL,
  `name_en` varchar(191) NOT NULL,
  `country_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(191) NOT NULL,
  `notifiable_type` varchar(191) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `secret` varchar(100) NOT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `operations`
--

CREATE TABLE `operations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name_ar` varchar(191) NOT NULL,
  `name_en` varchar(191) NOT NULL,
  `receipt` varchar(191) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `operations`
--

INSERT INTO `operations` (`id`, `name_ar`, `name_en`, `receipt`, `created_at`, `updated_at`) VALUES
(1, 'موردين', 'Suppliers', '1', NULL, NULL),
(2, 'عملاء', 'Customers', '2', NULL, NULL),
(3, 'مشروعات', 'Projects', '0', NULL, NULL),
(4, 'حسابات', 'Accounts', '1', NULL, NULL),
(5, 'موظفين', 'Employees', '1', NULL, NULL),
(6, 'الصندوق', 'Cashiers', '0', NULL, NULL),
(7, 'البنوك', 'Banks', '0', NULL, NULL),
(8, 'اشعار خصم', 'Minus Document', '0', NULL, NULL),
(9, 'اشعار اضافه', 'Plus Document', '0', NULL, NULL),
(10, 'مقاولين الباطن', 'Contracts', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE `parents` (
  `id` int(10) UNSIGNED NOT NULL,
  `name_ar` varchar(191) NOT NULL,
  `name_en` varchar(191) NOT NULL,
  `phone` varchar(191) NOT NULL,
  `relation` enum('0','1','2','3','4','5','6','7','8','9','10','11','12','13','14') DEFAULT NULL,
  `job` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'create', 'admin', NULL, NULL),
(2, 'edit', 'admin', NULL, NULL),
(3, 'delete', 'admin', NULL, NULL),
(4, 'student', 'admin', NULL, NULL),
(5, 'single', 'admin', NULL, NULL),
(6, 'company', 'admin', NULL, NULL),
(7, 'flight', 'admin', NULL, NULL),
(8, 'driver', 'admin', NULL, NULL),
(9, 'reports', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pjitmmsfls`
--

CREATE TABLE `pjitmmsfls` (
  `id` int(10) UNSIGNED NOT NULL,
  `month` enum('1','2','3','4','5','6','7','8','9','10','11','12') DEFAULT NULL,
  `year` varchar(191) DEFAULT NULL,
  `debtor` varchar(191) DEFAULT NULL,
  `creditor` varchar(191) DEFAULT NULL,
  `current_balance` varchar(191) DEFAULT NULL,
  `estimated_balance` varchar(191) DEFAULT NULL,
  `type` enum('1','2') DEFAULT NULL,
  `tree_id` int(10) UNSIGNED DEFAULT NULL,
  `cc_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `projcontractmfs`
--

CREATE TABLE `projcontractmfs` (
  `ID_No` int(10) UNSIGNED NOT NULL,
  `Cmp_No` int(10) UNSIGNED DEFAULT NULL,
  `Cntrct_No` bigint(20) DEFAULT NULL,
  `Rvisd_No` int(11) DEFAULT NULL,
  `Cntrct_Actv` tinyint(1) DEFAULT NULL,
  `Tr_Dt` datetime DEFAULT NULL,
  `Tr_DtAr` datetime DEFAULT NULL,
  `Prj_No` bigint(20) DEFAULT NULL,
  `Prj_Year` int(11) DEFAULT NULL,
  `Prj_Stus` int(11) DEFAULT NULL,
  `Cstm_No` bigint(20) DEFAULT NULL,
  `Cnt_Refno` varchar(191) DEFAULT NULL,
  `Cnt_Dt` varchar(191) DEFAULT NULL,
  `CntStrt_Dt` varchar(191) DEFAULT NULL,
  `CntCompl_Dt` varchar(191) DEFAULT NULL,
  `CntCompL_Priod` varchar(191) DEFAULT NULL,
  `Inst_Dt` varchar(191) DEFAULT NULL,
  `Comisn_Dt` varchar(191) DEFAULT NULL,
  `Wrntstrt_dt` varchar(191) DEFAULT NULL,
  `Wrntend_Dt` varchar(191) DEFAULT NULL,
  `Acc_DB` double(8,2) DEFAULT NULL,
  `Acc_CR` double(8,2) DEFAULT NULL,
  `Comitd_Cost` double(50,10) DEFAULT NULL,
  `Actul_Cost` double(50,10) DEFAULT NULL,
  `Cnt_Vl` double(50,10) DEFAULT NULL,
  `Cnt_Bdgt` double(50,10) DEFAULT NULL,
  `Cntrb_VL` double(50,10) DEFAULT NULL,
  `Cntrb_Prct` double(50,10) DEFAULT NULL,
  `Gnrlovhd_VaL` double(50,10) DEFAULT NULL,
  `Gnrlovhd_Prct` double(50,10) DEFAULT NULL,
  `Dprtmovhd_Vl` double(50,10) DEFAULT NULL,
  `Dprtmovhd_Prct` double(50,10) DEFAULT NULL,
  `Wrnt_Prct` double(50,10) DEFAULT NULL,
  `Fince_Prct` double(50,10) DEFAULT NULL,
  `Subtot_VaL` double(50,10) DEFAULT NULL,
  `Subtot_Prct` double(50,10) DEFAULT NULL,
  `Netcntrib_VaL` double(50,10) DEFAULT NULL,
  `Netcntrib_Prct` double(50,10) DEFAULT NULL,
  `Tot_Rcpt` double(50,10) DEFAULT NULL,
  `Balance` double(50,10) DEFAULT NULL,
  `Bnkgrnt_No` varchar(191) DEFAULT NULL,
  `Bnkgrnt_IsudByAr` varchar(191) DEFAULT NULL,
  `Bnkgrnt_IsudByEn` varchar(191) DEFAULT NULL,
  `Bnkgrnt_Amount` double(50,10) DEFAULT NULL,
  `Insurnc_Comprehensive` double(50,10) DEFAULT NULL,
  `Insurnc_Contractors` double(50,10) DEFAULT NULL,
  `DwnPym` double(50,10) DEFAULT NULL,
  `Dposit` double(50,10) DEFAULT NULL,
  `AdtionalWk` double(50,10) DEFAULT NULL,
  `WkDedction` double(50,10) DEFAULT NULL,
  `SitDedction` double(50,10) DEFAULT NULL,
  `NofEmp` varchar(191) DEFAULT NULL,
  `Emp_Hur` double(50,10) DEFAULT NULL,
  `NofMonths` double(50,10) DEFAULT NULL,
  `Mnthly_Pyment` double(50,10) DEFAULT NULL,
  `Cnt_DscAr` varchar(191) DEFAULT NULL,
  `Cnt_DscEn` varchar(191) DEFAULT NULL,
  `Brn_No` varchar(191) DEFAULT NULL,
  `Tr_Post` varchar(191) DEFAULT NULL,
  `Opn_Date` varchar(191) DEFAULT NULL,
  `Opn_Time` varchar(191) DEFAULT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `Updt_Date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `projcontractmfs`
--

INSERT INTO `projcontractmfs` (`ID_No`, `Cmp_No`, `Cntrct_No`, `Rvisd_No`, `Cntrct_Actv`, `Tr_Dt`, `Tr_DtAr`, `Prj_No`, `Prj_Year`, `Prj_Stus`, `Cstm_No`, `Cnt_Refno`, `Cnt_Dt`, `CntStrt_Dt`, `CntCompl_Dt`, `CntCompL_Priod`, `Inst_Dt`, `Comisn_Dt`, `Wrntstrt_dt`, `Wrntend_Dt`, `Acc_DB`, `Acc_CR`, `Comitd_Cost`, `Actul_Cost`, `Cnt_Vl`, `Cnt_Bdgt`, `Cntrb_VL`, `Cntrb_Prct`, `Gnrlovhd_VaL`, `Gnrlovhd_Prct`, `Dprtmovhd_Vl`, `Dprtmovhd_Prct`, `Wrnt_Prct`, `Fince_Prct`, `Subtot_VaL`, `Subtot_Prct`, `Netcntrib_VaL`, `Netcntrib_Prct`, `Tot_Rcpt`, `Balance`, `Bnkgrnt_No`, `Bnkgrnt_IsudByAr`, `Bnkgrnt_IsudByEn`, `Bnkgrnt_Amount`, `Insurnc_Comprehensive`, `Insurnc_Contractors`, `DwnPym`, `Dposit`, `AdtionalWk`, `WkDedction`, `SitDedction`, `NofEmp`, `Emp_Hur`, `NofMonths`, `Mnthly_Pyment`, `Cnt_DscAr`, `Cnt_DscEn`, `Brn_No`, `Tr_Post`, `Opn_Date`, `Opn_Time`, `User_ID`, `Updt_Date`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1254, NULL, '2019-12-11 00:00:00', '0000-00-00 00:00:00', NULL, NULL, NULL, 17, '545', '2019-12-27', '2019-12-27', '2019-12-27', '30', '2019-12-26', '2019-12-27', '2019-12-26', '2019-12-26', 999999.99, 999999.99, 1000000.0000000000, 1000000.0000000000, 5000.0000000000, 1000.0000000000, -4000.0000000000, -80.0000000000, 10000.0000000000, 200.0000000000, 20000.0000000000, 400.0000000000, 1.8000000000, 1800.0000000000, 120090.0000000000, 2401.8000000000, 0.0000000000, -2302.0000000000, 10000.0000000000, -5000.0000000000, '54545465464', '4545', '545564546', 546546.0000000000, 54564.0000000000, 4545.0000000000, NULL, NULL, NULL, NULL, NULL, '50', 150.0000000000, 1.0000000000, 50000.0000000000, 'jhgvrfrfhgrfgvhfb', 'jnbfjbrlrbgn', '1', NULL, '2019-12-16 08:51:50', NULL, 1, '2019-12-16 08:52:19', '2019-12-16 06:51:50', '2019-12-16 06:52:19');

-- --------------------------------------------------------

--
-- Table structure for table `projectcontracts`
--

CREATE TABLE `projectcontracts` (
  `id` int(10) UNSIGNED NOT NULL,
  `branche_id` int(10) UNSIGNED DEFAULT NULL,
  `project_id` int(10) UNSIGNED DEFAULT NULL,
  `date_hijri` varchar(191) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `note` longtext DEFAULT NULL,
  `note_en` longtext DEFAULT NULL,
  `Date_contract` date DEFAULT NULL,
  `beginning_contract` date DEFAULT NULL,
  `End_contract` date DEFAULT NULL,
  `period_contract` varchar(191) DEFAULT NULL,
  `start_implementation` date DEFAULT NULL,
  `end_implementation` date DEFAULT NULL,
  `start_warranty` date DEFAULT NULL,
  `end_warranty` date DEFAULT NULL,
  `number_employees` varchar(191) DEFAULT NULL,
  `Hour_employee` varchar(191) DEFAULT NULL,
  `number_months` varchar(191) DEFAULT NULL,
  `monthly_payment` varchar(191) DEFAULT NULL,
  `revenue_measurement` varchar(191) DEFAULT NULL,
  `expenses_measurement` varchar(191) DEFAULT NULL,
  `cost_limit` varchar(191) DEFAULT NULL,
  `actual_cost` varchar(191) DEFAULT NULL,
  `Estimated_value` varchar(191) DEFAULT NULL,
  `contract_value` varchar(191) DEFAULT NULL,
  `deviation_value` varchar(191) DEFAULT NULL,
  `Bank_guarantee_number` varchar(191) DEFAULT NULL,
  `warranty_history` varchar(191) DEFAULT NULL,
  `amount_guarantee` varchar(191) DEFAULT NULL,
  `warranty_issued` varchar(191) DEFAULT NULL,
  `warranty_issued_en` varchar(191) DEFAULT NULL,
  `comprehensive_insurance` varchar(191) DEFAULT NULL,
  `contractor_insurance` varchar(191) DEFAULT NULL,
  `reference_retirement` varchar(191) DEFAULT NULL,
  `subscriber_id` int(10) UNSIGNED DEFAULT NULL,
  `management_expenses_percentage` varchar(191) DEFAULT NULL,
  `management_expenses` varchar(191) DEFAULT NULL,
  `department_expenses_percentage` varchar(191) DEFAULT NULL,
  `department_expenses` varchar(191) DEFAULT NULL,
  `warranty_period_percentage` varchar(191) DEFAULT NULL,
  `warranty_period` varchar(191) DEFAULT NULL,
  `financial_expenses_percentage` varchar(191) DEFAULT NULL,
  `financial_expenses` varchar(191) DEFAULT NULL,
  `subtotal_percentage` varchar(191) DEFAULT NULL,
  `subtotal` varchar(191) DEFAULT NULL,
  `net_deviation_percentage` varchar(191) DEFAULT NULL,
  `net_deviation` varchar(191) DEFAULT NULL,
  `total_collection` varchar(191) DEFAULT NULL,
  `current_balance` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `projectmfs`
--

CREATE TABLE `projectmfs` (
  `ID_No` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `Cmp_No` int(10) UNSIGNED DEFAULT NULL,
  `Prj_No` int(10) UNSIGNED DEFAULT NULL,
  `Prj_Parnt` int(11) DEFAULT NULL,
  `Level_Status` tinyint(1) DEFAULT NULL,
  `Level_No` int(11) DEFAULT NULL,
  `Costcntr_No` int(11) DEFAULT NULL,
  `Prj_Actv` tinyint(1) DEFAULT NULL,
  `Prj_Year` date NOT NULL,
  `Prj_Status` enum('0','1','2','3','4','5','6') DEFAULT NULL,
  `Tr_Dt` date DEFAULT NULL,
  `Tr_DtAr` date DEFAULT NULL,
  `Prj_NmAr` varchar(191) DEFAULT NULL,
  `Prj_NmEn` varchar(250) DEFAULT NULL,
  `Prj_Refno` varchar(20) DEFAULT NULL,
  `Prj_Categ` int(11) DEFAULT NULL,
  `Prj_Value` double(50,10) DEFAULT NULL,
  `Cstm_No` int(11) DEFAULT NULL,
  `Slm_No` int(11) DEFAULT NULL,
  `Country_No` int(11) DEFAULT NULL,
  `City_No` int(11) DEFAULT NULL,
  `Area_No` int(11) DEFAULT NULL,
  `Acc_DB` int(11) DEFAULT NULL,
  `Acc_CR` int(11) DEFAULT NULL,
  `FBal_Db` double(50,10) DEFAULT NULL,
  `FBal_Cr` double(50,10) DEFAULT NULL,
  `DB11` double(50,10) DEFAULT NULL,
  `DB12` double(50,10) DEFAULT NULL,
  `DB13` double(50,10) DEFAULT NULL,
  `DB14` double(50,10) DEFAULT NULL,
  `DB15` double(50,10) DEFAULT NULL,
  `DB16` double(50,10) DEFAULT NULL,
  `DB17` double(50,10) DEFAULT NULL,
  `DB18` double(50,10) DEFAULT NULL,
  `DB20` double(50,10) DEFAULT NULL,
  `DB21` double(50,10) DEFAULT NULL,
  `DB22` double(50,10) DEFAULT NULL,
  `CR11` double(50,10) DEFAULT NULL,
  `CR12` double(50,10) DEFAULT NULL,
  `CR13` double(50,10) DEFAULT NULL,
  `CR14` double(50,10) DEFAULT NULL,
  `CR15` double(50,10) DEFAULT NULL,
  `CR16` double(50,10) DEFAULT NULL,
  `CR17` double(50,10) DEFAULT NULL,
  `CR18` double(50,10) DEFAULT NULL,
  `CR19` double(50,10) DEFAULT NULL,
  `CR20` double(50,10) DEFAULT NULL,
  `CR21` double(50,10) DEFAULT NULL,
  `CR22` double(50,10) DEFAULT NULL,
  `Brn_No` int(11) DEFAULT NULL,
  `Dlv_Stor` int(11) DEFAULT NULL,
  `Ordr_Value` double(50,10) DEFAULT NULL,
  `Ordr_No` int(11) DEFAULT NULL,
  `Ordr_Dt` date DEFAULT NULL,
  `Prj_Adr` varchar(200) DEFAULT NULL,
  `Prj_Tel` varchar(15) DEFAULT NULL,
  `Prj_Mobile` varchar(15) DEFAULT NULL,
  `Prj_Mobile1` varchar(15) DEFAULT NULL,
  `Nxt_Vst` date DEFAULT NULL,
  `Mnth_Year` date DEFAULT NULL,
  `Cntct_Prsn1` varchar(191) DEFAULT NULL,
  `Cntct_Prsn2` varchar(191) DEFAULT NULL,
  `TitL1` varchar(191) DEFAULT NULL,
  `TitL2` varchar(191) DEFAULT NULL,
  `Mobile1` varchar(191) DEFAULT NULL,
  `Mobile2` varchar(191) DEFAULT NULL,
  `Email1` varchar(191) DEFAULT NULL,
  `Email2` varchar(191) DEFAULT NULL,
  `Opn_Date` date DEFAULT NULL,
  `Opn_Time` time DEFAULT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `Updt_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `projectmfs`
--

INSERT INTO `projectmfs` (`ID_No`, `created_at`, `updated_at`, `Cmp_No`, `Prj_No`, `Prj_Parnt`, `Level_Status`, `Level_No`, `Costcntr_No`, `Prj_Actv`, `Prj_Year`, `Prj_Status`, `Tr_Dt`, `Tr_DtAr`, `Prj_NmAr`, `Prj_NmEn`, `Prj_Refno`, `Prj_Categ`, `Prj_Value`, `Cstm_No`, `Slm_No`, `Country_No`, `City_No`, `Area_No`, `Acc_DB`, `Acc_CR`, `FBal_Db`, `FBal_Cr`, `DB11`, `DB12`, `DB13`, `DB14`, `DB15`, `DB16`, `DB17`, `DB18`, `DB20`, `DB21`, `DB22`, `CR11`, `CR12`, `CR13`, `CR14`, `CR15`, `CR16`, `CR17`, `CR18`, `CR19`, `CR20`, `CR21`, `CR22`, `Brn_No`, `Dlv_Stor`, `Ordr_Value`, `Ordr_No`, `Ordr_Dt`, `Prj_Adr`, `Prj_Tel`, `Prj_Mobile`, `Prj_Mobile1`, `Nxt_Vst`, `Mnth_Year`, `Cntct_Prsn1`, `Cntct_Prsn2`, `TitL1`, `TitL2`, `Mobile1`, `Mobile2`, `Email1`, `Email2`, `Opn_Date`, `Opn_Time`, `User_ID`, `Updt_Date`) VALUES
(1, '2020-01-08 12:05:31', '2020-01-08 12:09:30', 1, 1, 0, 0, 1, NULL, 1, '0000-00-00', NULL, '2020-01-08', '1441-05-13', '435', '345', '32', NULL, 3.0000000000, 1, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2020-01-08'),
(2, '2020-01-08 12:06:10', '2020-01-08 12:06:10', 1, 1, 0, 0, 1, NULL, 1, '0000-00-00', NULL, NULL, '1441-05-13', '435', '345', '32', NULL, 3.0000000000, 1, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(3, '2020-01-08 12:06:21', '2020-01-08 12:06:21', 1, 1, 0, 0, 1, NULL, 1, '0000-00-00', NULL, NULL, '1441-05-13', '435', '345', '32', NULL, 3.0000000000, 1, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(4, '2020-01-08 12:06:43', '2020-01-08 12:06:43', 1, 1, 0, 0, 1, NULL, 1, '0000-00-00', NULL, NULL, '1441-05-13', '435', '345', '32', NULL, 3.0000000000, 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(5, '2020-01-08 12:07:25', '2020-01-08 12:07:25', 1, 101, 1, 1, 2, NULL, 1, '0000-00-00', NULL, '2020-01-08', '1441-05-13', NULL, NULL, '152', NULL, 15.0000000000, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(6, '2020-01-08 12:07:39', '2020-01-08 12:07:39', 1, 101, 1, 1, 2, NULL, 1, '0000-00-00', NULL, '2020-01-08', '1441-05-13', NULL, NULL, '152', NULL, 15.0000000000, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(7, '2020-01-08 12:07:57', '2020-01-08 12:07:57', 1, 101, 1, 1, 2, NULL, 1, '0000-00-00', NULL, '2020-01-08', '1441-05-13', NULL, NULL, '152', NULL, 15.0000000000, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(8, '2020-01-08 12:08:10', '2020-01-08 12:08:10', 1, 101, 1, 1, 2, NULL, 1, '0000-00-00', NULL, '2020-01-08', '1441-05-13', NULL, NULL, '152', NULL, 15.0000000000, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(10) UNSIGNED NOT NULL,
  `name_ar` varchar(191) DEFAULT NULL,
  `name_en` varchar(191) DEFAULT NULL,
  `contract_number` varchar(191) DEFAULT NULL,
  `phone_number` varchar(191) DEFAULT NULL,
  `fax_number` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `responsible_person` varchar(191) DEFAULT NULL,
  `warehouse` varchar(191) DEFAULT NULL,
  `customer_id` int(10) UNSIGNED DEFAULT NULL,
  `tree_id` int(10) UNSIGNED DEFAULT NULL,
  `cc_id` int(10) UNSIGNED DEFAULT NULL,
  `operation_id` int(10) UNSIGNED NOT NULL DEFAULT 3,
  `project_title` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE `receipts` (
  `id` int(10) UNSIGNED NOT NULL,
  `receiptId` int(11) DEFAULT NULL,
  `branche_id` int(10) UNSIGNED DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `receiptsType_id` int(10) UNSIGNED DEFAULT NULL,
  `operation_id` int(10) UNSIGNED DEFAULT NULL,
  `invoice_id` varchar(191) DEFAULT NULL,
  `status` varchar(191) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `receipts_data`
--

CREATE TABLE `receipts_data` (
  `id` int(10) UNSIGNED NOT NULL,
  `debtor` varchar(191) DEFAULT NULL,
  `creditor` varchar(191) DEFAULT NULL,
  `receipt_number` varchar(191) DEFAULT NULL,
  `check` varchar(191) DEFAULT NULL,
  `checkDate` datetime DEFAULT NULL,
  `person` varchar(191) DEFAULT NULL,
  `taken` varchar(191) DEFAULT NULL,
  `invoice_id` varchar(191) DEFAULT NULL,
  `receipts_id` int(10) UNSIGNED DEFAULT NULL,
  `tree_id` int(10) UNSIGNED DEFAULT NULL,
  `operation_id` int(10) UNSIGNED DEFAULT NULL,
  `note` varchar(191) DEFAULT NULL,
  `note_en` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `receipts_data_types`
--

CREATE TABLE `receipts_data_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `receipts_type_id` int(10) UNSIGNED DEFAULT NULL,
  `receipts_data_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `receipts_type`
--

CREATE TABLE `receipts_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `name_ar` varchar(191) DEFAULT NULL,
  `name_en` varchar(191) DEFAULT NULL,
  `tree_id` int(10) UNSIGNED DEFAULT NULL,
  `operation_id` int(10) UNSIGNED DEFAULT NULL,
  `receipts_id` int(10) UNSIGNED DEFAULT NULL,
  `cc_id` int(10) UNSIGNED DEFAULT NULL,
  `relation_id` varchar(191) DEFAULT NULL,
  `debtor` varchar(191) DEFAULT NULL,
  `creditor` varchar(191) DEFAULT NULL,
  `note` varchar(191) DEFAULT NULL,
  `note_en` varchar(191) DEFAULT NULL,
  `status` varchar(191) NOT NULL DEFAULT '0',
  `tax` varchar(191) DEFAULT NULL,
  `invoice_id` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `responsible_people`
--

CREATE TABLE `responsible_people` (
  `id` int(10) UNSIGNED NOT NULL,
  `responsible_people` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `phone1` varchar(191) DEFAULT NULL,
  `phone2` varchar(191) DEFAULT NULL,
  `mobile` varchar(191) DEFAULT NULL,
  `contractor_name` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `guard_name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'writer', 'admin', NULL, NULL),
(2, 'reader', 'admin', NULL, NULL),
(3, 'admin', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `sitename_ar` varchar(191) NOT NULL,
  `sitename_en` varchar(191) NOT NULL,
  `logo` varchar(191) DEFAULT NULL,
  `icon` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `main_lang` varchar(191) NOT NULL DEFAULT 'en',
  `description` longtext DEFAULT NULL,
  `description_ar` longtext DEFAULT NULL,
  `contact_description` longtext DEFAULT NULL,
  `contact_description_ar` longtext DEFAULT NULL,
  `keyword` longtext DEFAULT NULL,
  `status` enum('open','close') NOT NULL DEFAULT 'open',
  `currancy` enum('0','1','2') NOT NULL DEFAULT '0',
  `message_maintenance` longtext DEFAULT NULL,
  `addriss` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `facebook` varchar(191) DEFAULT NULL,
  `twitter` varchar(191) DEFAULT NULL,
  `googel` varchar(191) DEFAULT NULL,
  `linkedin` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `sitename_ar`, `sitename_en`, `logo`, `icon`, `email`, `main_lang`, `description`, `description_ar`, `contact_description`, `contact_description_ar`, `keyword`, `status`, `currancy`, `message_maintenance`, `addriss`, `phone`, `facebook`, `twitter`, `googel`, `linkedin`, `created_at`, `updated_at`) VALUES
(1, 'arabic', 'english', NULL, NULL, NULL, 'en', NULL, NULL, NULL, NULL, NULL, 'open', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(10) UNSIGNED NOT NULL,
  `state_name_ar` varchar(191) NOT NULL,
  `state_name_en` varchar(191) NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `country_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name_ar` varchar(191) NOT NULL,
  `name_en` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `address` varchar(191) DEFAULT NULL,
  `branches_id` int(10) UNSIGNED DEFAULT NULL,
  `status` varchar(191) NOT NULL DEFAULT '1',
  `phone_1` varchar(191) DEFAULT NULL,
  `phone_2` varchar(191) DEFAULT NULL,
  `phone_3` varchar(191) DEFAULT NULL,
  `phone_4` varchar(191) DEFAULT NULL,
  `per_status` varchar(191) DEFAULT NULL,
  `facebook` varchar(191) DEFAULT NULL,
  `twitter` varchar(191) DEFAULT NULL,
  `tax_num` varchar(191) DEFAULT NULL,
  `Discounts` tinyint(4) DEFAULT NULL,
  `Commissions` tinyint(4) DEFAULT NULL,
  `note` mediumtext DEFAULT NULL,
  `debtor` varchar(191) NOT NULL DEFAULT '0',
  `creditor` varchar(191) NOT NULL DEFAULT '0',
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `admin_id` int(10) UNSIGNED DEFAULT NULL,
  `operation_id` int(10) UNSIGNED NOT NULL DEFAULT 2,
  `countries_id` int(10) UNSIGNED DEFAULT NULL,
  `city_id` int(10) UNSIGNED DEFAULT NULL,
  `employee_id` int(10) UNSIGNED DEFAULT NULL,
  `activity_type_id` int(10) UNSIGNED DEFAULT NULL,
  `cc_id` int(10) UNSIGNED DEFAULT NULL,
  `cc_type` varchar(191) NOT NULL DEFAULT '0',
  `credit_limit` varchar(191) DEFAULT NULL,
  `repayment_period` varchar(191) DEFAULT NULL,
  `discount` varchar(191) DEFAULT NULL,
  `state_id` int(10) UNSIGNED DEFAULT NULL,
  `tree_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sub_parents`
--

CREATE TABLE `sub_parents` (
  `id` int(10) UNSIGNED NOT NULL,
  `subscription_id` int(10) UNSIGNED DEFAULT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name_ar` varchar(191) NOT NULL,
  `name_en` varchar(191) NOT NULL,
  `addriss` varchar(191) NOT NULL,
  `responsible` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `credit_limit` varchar(191) NOT NULL,
  `debtor` varchar(191) NOT NULL,
  `creditor` varchar(191) NOT NULL,
  `country_id` int(10) UNSIGNED DEFAULT NULL,
  `currency` enum('0','1') NOT NULL,
  `phone1` varchar(191) NOT NULL,
  `phone2` varchar(191) NOT NULL,
  `fax` varchar(191) NOT NULL,
  `account_num` varchar(191) NOT NULL,
  `tax_num` varchar(191) NOT NULL,
  `tree_id` int(10) UNSIGNED DEFAULT NULL,
  `branches_id` int(10) UNSIGNED DEFAULT NULL,
  `operation_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `status` varchar(191) NOT NULL DEFAULT '2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name_en` varchar(191) NOT NULL,
  `addriss` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `gender` enum('0','1') NOT NULL,
  `city_id` int(10) UNSIGNED DEFAULT NULL,
  `state_id` int(10) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` int(10) UNSIGNED NOT NULL,
  `users` varchar(191) DEFAULT NULL,
  `country` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`id`, `users`, `country`, `created_at`, `updated_at`) VALUES
(1, '0', 'Egypt', NULL, NULL),
(2, '0', 'Bhutan', NULL, NULL),
(3, '0', 'Democratic Republic of the Congo', NULL, NULL),
(4, '0', 'Liechtenstein', NULL, NULL),
(5, '0', 'Maldives', NULL, NULL),
(6, '0', 'Sudan', NULL, NULL),
(7, '0', 'Zimbabwe', NULL, NULL),
(8, '0', 'Mauritania', NULL, NULL),
(9, '0', 'Mozambique', NULL, NULL),
(10, '0', 'Nigeria', NULL, NULL),
(11, '0', 'Swaziland', NULL, NULL),
(12, '0', 'Tanzania', NULL, NULL),
(13, '0', 'Iraq', NULL, NULL),
(14, '0', 'Guyana', NULL, NULL),
(15, '0', 'Namibia', NULL, NULL),
(16, '0', 'Senegal', NULL, NULL),
(17, '0', 'Turkmenistan', NULL, NULL),
(18, '0', 'Afghanistan', NULL, NULL),
(19, '0', 'Andorra', NULL, NULL),
(20, '0', 'Fiji', NULL, NULL),
(21, '0', 'Gabon', NULL, NULL),
(22, '0', 'Uzbekistan', NULL, NULL),
(23, '0', 'Cameroon', NULL, NULL),
(24, '0', 'Cuba', NULL, NULL),
(25, '0', 'Faroe Islands', NULL, NULL),
(26, '0', 'El Salvador', NULL, NULL),
(27, '0', 'Caribbean', NULL, NULL),
(28, '0', 'Ethiopia', NULL, NULL),
(29, '0', 'Mongolia', NULL, NULL),
(30, '0', 'Puerto Rico', NULL, NULL),
(31, '0', 'Samoa', NULL, NULL),
(32, '0', 'Myanmar', NULL, NULL),
(33, '0', 'Nicaragua', NULL, NULL),
(34, '0', 'Seychelles', NULL, NULL),
(35, '0', 'Tajikistan', NULL, NULL),
(36, '0', 'Dominican Republic', NULL, NULL),
(37, '0', 'Guinea', NULL, NULL),
(38, '0', 'Barbados', NULL, NULL),
(39, '0', 'CI', NULL, NULL),
(40, '0', 'Laos', NULL, NULL),
(41, '0', 'Libya', NULL, NULL),
(42, '0', 'Panama', NULL, NULL),
(43, '0', 'Bahrain', NULL, NULL),
(44, '0', 'Benin', NULL, NULL),
(45, '0', 'Ghana', NULL, NULL),
(46, '0', 'Haiti', NULL, NULL),
(47, '0', 'Montenegro', NULL, NULL),
(48, '0', 'Somalia', NULL, NULL),
(49, '0', 'Syria', NULL, NULL),
(50, '0', 'Ecuador', NULL, NULL),
(51, '0', 'Honduras', NULL, NULL),
(52, '0', 'Madagascar', NULL, NULL),
(53, '0', 'Papua New Guinea', NULL, NULL),
(54, '0', 'Tunisia', NULL, NULL),
(55, '0', 'Angola', NULL, NULL),
(56, '0', 'Botswana', NULL, NULL),
(57, '0', 'Cyprus', NULL, NULL),
(58, '0', 'Algeria', NULL, NULL),
(59, '0', 'Bahamas', NULL, NULL),
(60, '0', 'New Caledonia', NULL, NULL),
(61, '0', 'Uganda', NULL, NULL),
(62, '0', 'Yemen', NULL, NULL),
(63, '0', 'Zambia', NULL, NULL),
(64, '0', 'Antarctica', NULL, NULL),
(65, '0', 'Paraguay', NULL, NULL),
(66, '0', 'Jamaica', NULL, NULL),
(67, '0', 'Palestine', NULL, NULL),
(68, '0', 'Bolivia', NULL, NULL),
(69, '0', 'Bosnia and Herzegovina', NULL, NULL),
(70, '0', 'Vietnam', NULL, NULL),
(71, '0', 'Kenya', NULL, NULL),
(72, '0', 'Luxembourg', NULL, NULL),
(73, '0', 'Niger', NULL, NULL),
(74, '0', 'Kuwait', NULL, NULL),
(75, '0', 'Hawaii', NULL, NULL),
(76, '0', 'Scotland', NULL, NULL),
(77, '0', 'Cambodia', NULL, NULL),
(78, '0', 'Uruguay', NULL, NULL),
(79, '0', 'Kyrgyzstan', NULL, NULL),
(80, '0', 'Saudi Arabia', NULL, NULL),
(81, '0', 'Indonesia', NULL, NULL),
(82, '0', 'Azerbaijan', NULL, NULL),
(83, '0', 'United Arab Emirates', NULL, NULL),
(84, '0', 'Mauritius', NULL, NULL),
(85, '0', 'Morocco', NULL, NULL),
(86, '0', 'Albania', NULL, NULL),
(87, '0', 'South Korea', NULL, NULL),
(88, '0', 'Kazakhstan', NULL, NULL),
(89, '0', 'Macedonia', NULL, NULL),
(90, '0', 'Venezuela', NULL, NULL),
(91, '0', 'Taiwan', NULL, NULL),
(92, '0', 'Qatar', NULL, NULL),
(93, '0', 'Jordan', NULL, NULL),
(94, '0', 'Iceland', NULL, NULL),
(95, '0', 'Guatemala', NULL, NULL),
(96, '0', 'Costa Rica', NULL, NULL),
(97, '0', 'Hong Kong', NULL, NULL),
(98, '0', 'San Marino', NULL, NULL),
(99, '0', 'Colombia', NULL, NULL),
(100, '0', 'Moldova', NULL, NULL),
(101, '0', 'Armenia', NULL, NULL),
(102, '0', 'Malta', NULL, NULL),
(103, '0', 'Nepal', NULL, NULL),
(104, '0', 'Lebanon', NULL, NULL),
(105, '0', 'Malaysia', NULL, NULL),
(106, '0', 'Serbia', NULL, NULL),
(107, '0', 'Peru', NULL, NULL),
(108, '0', 'Trinidad and Tobago', NULL, NULL),
(109, '0', 'Lithuania', NULL, NULL),
(110, '0', 'Estonia', NULL, NULL),
(111, '0', 'Georgia', NULL, NULL),
(112, '0', 'Iran', NULL, NULL),
(113, '0', 'Chile', NULL, NULL),
(114, '0', 'Latvia', NULL, NULL),
(115, '0', 'Thailand', NULL, NULL),
(116, '0', 'Egypt', NULL, NULL),
(117, '0', 'Slovenia', NULL, NULL),
(118, '0', 'Mexico', NULL, NULL),
(119, '0', 'Belarus', NULL, NULL),
(120, '0', 'Slovakia', NULL, NULL),
(121, '0', 'Sri Lanka', NULL, NULL),
(122, '0', 'Croatia', NULL, NULL),
(123, '0', 'Philippines', NULL, NULL),
(124, '0', 'Bangladesh', NULL, NULL),
(125, '0', 'Turkey', NULL, NULL),
(126, '0', 'Romania', NULL, NULL),
(127, '0', 'Italy', NULL, NULL),
(128, '0', 'South Africa', NULL, NULL),
(129, '0', 'Hungary', NULL, NULL),
(130, '0', 'Pakistan', NULL, NULL),
(131, '0', 'Portugal', NULL, NULL),
(132, '0', 'Ukraine', NULL, NULL),
(133, '0', 'Greece', NULL, NULL),
(134, '0', 'Oman', NULL, NULL),
(135, '0', 'Argentina', NULL, NULL),
(136, '0', 'Singapore', NULL, NULL),
(137, '0', 'Bulgaria', NULL, NULL),
(138, '0', 'Japan', NULL, NULL),
(139, '0', 'Czech Republic ', NULL, NULL),
(140, '0', 'Ireland', NULL, NULL),
(141, '0', 'China', NULL, NULL),
(142, '0', 'Finland', NULL, NULL),
(143, '0', 'Brazil', NULL, NULL),
(144, '0', 'Norway', NULL, NULL),
(145, '0', 'Austria', NULL, NULL),
(146, '0', 'Denmark', NULL, NULL),
(147, '0', 'Belgium', NULL, NULL),
(148, '0', 'New Zealand', NULL, NULL),
(149, '0', 'Spain', NULL, NULL),
(150, '0', 'Switzerland', NULL, NULL),
(151, '0', 'Russia', NULL, NULL),
(152, '0', 'Poland', NULL, NULL),
(153, '0', 'Israel', NULL, NULL),
(154, '0', 'Sweden', NULL, NULL),
(155, '0', 'Netherlands', NULL, NULL),
(156, '0', 'France', NULL, NULL),
(157, '0', 'Australia', NULL, NULL),
(158, '0', 'Canada', NULL, NULL),
(159, '0', 'India', NULL, NULL),
(160, '0', 'Germany', NULL, NULL),
(161, '0', 'United Kingdom', NULL, NULL),
(162, '0', 'United States', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activitytypes`
--
ALTER TABLE `activitytypes`
  ADD PRIMARY KEY (`ID_No`);

--
-- Indexes for table `activity_type`
--
ALTER TABLE `activity_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `astcurncy`
--
ALTER TABLE `astcurncy`
  ADD PRIMARY KEY (`ID_No`);

--
-- Indexes for table `astmarket`
--
ALTER TABLE `astmarket`
  ADD PRIMARY KEY (`ID_No`);

--
-- Indexes for table `astsalesman`
--
ALTER TABLE `astsalesman`
  ADD PRIMARY KEY (`ID_No`);

--
-- Indexes for table `astsupctgs`
--
ALTER TABLE `astsupctgs`
  ADD PRIMARY KEY (`ID_No`);

--
-- Indexes for table `blog_entries`
--
ALTER TABLE `blog_entries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`,`blog`),
  ADD KEY `public` (`publish_after`,`blog`,`slug`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branche_employee`
--
ALTER TABLE `branche_employee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branche_employee_employee_id_foreign` (`employee_id`),
  ADD KEY `branche_employee_branche_id_foreign` (`branche_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_country_id_foreign` (`country_id`);

--
-- Indexes for table `contractors`
--
ALTER TABLE `contractors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contractors_contractor_type_id_foreign` (`contractor_type_id`),
  ADD KEY `contractors_tree_id_foreign` (`tree_id`),
  ADD KEY `contractors_operation_id_foreign` (`operation_id`),
  ADD KEY `contractors_country_id_foreign` (`country_id`);

--
-- Indexes for table `contractors_types`
--
ALTER TABLE `contractors_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contracts_section_id_foreign` (`section_id`),
  ADD KEY `contracts_project_id_foreign` (`project_id`),
  ADD KEY `contracts_contractor_id_foreign` (`contractor_id`),
  ADD KEY `contracts_subscriber_id_foreign` (`subscriber_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departments_branch_id_foreign` (`branch_id`),
  ADD KEY `departments_level_id_foreign` (`level_id`),
  ADD KEY `departments_operation_id_foreign` (`operation_id`),
  ADD KEY `departments_parent_id_foreign` (`parent_id`),
  ADD KEY `departments_cc_id_foreign` (`cc_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employees_tree_id_foreign` (`tree_id`),
  ADD KEY `employees_companybanks_id_foreign` (`companybanks_id`),
  ADD KEY `employees_employeebanks_id_foreign` (`employeebanks_id`),
  ADD KEY `employees_operation_id_foreign` (`operation_id`),
  ADD KEY `employees_branches_id_foreign` (`branches_id`),
  ADD KEY `employees_cc_id_foreign` (`cc_id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `glaccbnk`
--
ALTER TABLE `glaccbnk`
  ADD PRIMARY KEY (`ID_No`);

--
-- Indexes for table `glastjrntyp`
--
ALTER TABLE `glastjrntyp`
  ADD PRIMARY KEY (`ID_NO`);

--
-- Indexes for table `glccs`
--
ALTER TABLE `glccs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `glccs_branch_id_foreign` (`branch_id`),
  ADD KEY `glccs_level_id_foreign` (`level_id`),
  ADD KEY `glccs_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `gljrnal`
--
ALTER TABLE `gljrnal`
  ADD PRIMARY KEY (`ID_No`);

--
-- Indexes for table `gljrntrs`
--
ALTER TABLE `gljrntrs`
  ADD PRIMARY KEY (`ID_No`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `levels_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `limitationreceipts`
--
ALTER TABLE `limitationreceipts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `limitations`
--
ALTER TABLE `limitations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `limitations_branche_id_foreign` (`branche_id`),
  ADD KEY `limitations_limitationstype_id_foreign` (`limitationsType_id`);

--
-- Indexes for table `limitations_datas`
--
ALTER TABLE `limitations_datas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `limitations_datas_limitations_id_foreign` (`limitations_id`);

--
-- Indexes for table `limitations_data_types`
--
ALTER TABLE `limitations_data_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `limitations_data_types_limitations_type_id_foreign` (`limitations_type_id`),
  ADD KEY `limitations_data_types_limitations_data_id_foreign` (`limitations_data_id`);

--
-- Indexes for table `limitations_type`
--
ALTER TABLE `limitations_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `limitations_type_tree_id_foreign` (`tree_id`),
  ADD KEY `limitations_type_operation_id_foreign` (`operation_id`),
  ADD KEY `limitations_type_limitations_id_foreign` (`limitations_id`),
  ADD KEY `limitations_type_cc_id_foreign` (`cc_id`);

--
-- Indexes for table `mainbranch`
--
ALTER TABLE `mainbranch`
  ADD PRIMARY KEY (`ID_No`),
  ADD KEY `mainbranch_cmp_no_index` (`Cmp_No`);

--
-- Indexes for table `maincompany`
--
ALTER TABLE `maincompany`
  ADD PRIMARY KEY (`ID_No`),
  ADD UNIQUE KEY `maincompany_cmp_no_unique` (`Cmp_No`);

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
-- Indexes for table `mtschartac`
--
ALTER TABLE `mtschartac`
  ADD PRIMARY KEY (`ID_No`),
  ADD KEY `mtschartac_cmp_no_index` (`Cmp_No`);

--
-- Indexes for table `mtsclosacc`
--
ALTER TABLE `mtsclosacc`
  ADD PRIMARY KEY (`ID_No`);

--
-- Indexes for table `mtscustomer`
--
ALTER TABLE `mtscustomer`
  ADD PRIMARY KEY (`ID_No`);

--
-- Indexes for table `mts_costcntrs`
--
ALTER TABLE `mts_costcntrs`
  ADD PRIMARY KEY (`ID_No`),
  ADD KEY `mts_costcntrs_cmp_no_index` (`Cmp_No`);

--
-- Indexes for table `mts_suplirs`
--
ALTER TABLE `mts_suplirs`
  ADD PRIMARY KEY (`ID_No`);

--
-- Indexes for table `nations`
--
ALTER TABLE `nations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nations_country_id_foreign` (`country_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

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
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `operations`
--
ALTER TABLE `operations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `pjitmmsfls`
--
ALTER TABLE `pjitmmsfls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pjitmmsfls_tree_id_foreign` (`tree_id`),
  ADD KEY `pjitmmsfls_cc_id_foreign` (`cc_id`);

--
-- Indexes for table `projcontractmfs`
--
ALTER TABLE `projcontractmfs`
  ADD PRIMARY KEY (`ID_No`),
  ADD KEY `projcontractmfs_cmp_no_index` (`Cmp_No`);

--
-- Indexes for table `projectcontracts`
--
ALTER TABLE `projectcontracts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projectcontracts_branche_id_foreign` (`branche_id`),
  ADD KEY `projectcontracts_project_id_foreign` (`project_id`),
  ADD KEY `projectcontracts_subscriber_id_foreign` (`subscriber_id`);

--
-- Indexes for table `projectmfs`
--
ALTER TABLE `projectmfs`
  ADD PRIMARY KEY (`ID_No`),
  ADD KEY `projectmfs_cmp_no_index` (`Cmp_No`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projects_customer_id_foreign` (`customer_id`),
  ADD KEY `projects_tree_id_foreign` (`tree_id`),
  ADD KEY `projects_cc_id_foreign` (`cc_id`),
  ADD KEY `projects_operation_id_foreign` (`operation_id`);

--
-- Indexes for table `receipts`
--
ALTER TABLE `receipts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receipts_branche_id_foreign` (`branche_id`),
  ADD KEY `receipts_receiptstype_id_foreign` (`receiptsType_id`),
  ADD KEY `receipts_operation_id_foreign` (`operation_id`);

--
-- Indexes for table `receipts_data`
--
ALTER TABLE `receipts_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receipts_data_receipts_id_foreign` (`receipts_id`),
  ADD KEY `receipts_data_operation_id_foreign` (`operation_id`),
  ADD KEY `receipts_data_tree_id_foreign` (`tree_id`);

--
-- Indexes for table `receipts_data_types`
--
ALTER TABLE `receipts_data_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receipts_data_types_receipts_type_id_foreign` (`receipts_type_id`),
  ADD KEY `receipts_data_types_receipts_data_id_foreign` (`receipts_data_id`);

--
-- Indexes for table `receipts_type`
--
ALTER TABLE `receipts_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receipts_type_tree_id_foreign` (`tree_id`),
  ADD KEY `receipts_type_operation_id_foreign` (`operation_id`),
  ADD KEY `receipts_type_receipts_id_foreign` (`receipts_id`),
  ADD KEY `receipts_type_cc_id_foreign` (`cc_id`);

--
-- Indexes for table `responsible_people`
--
ALTER TABLE `responsible_people`
  ADD PRIMARY KEY (`id`),
  ADD KEY `responsible_people_contractor_name_foreign` (`contractor_name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`),
  ADD KEY `states_city_id_foreign` (`city_id`),
  ADD KEY `states_country_id_foreign` (`country_id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscriptions_user_id_foreign` (`user_id`),
  ADD KEY `subscriptions_admin_id_foreign` (`admin_id`),
  ADD KEY `subscriptions_operation_id_foreign` (`operation_id`),
  ADD KEY `subscriptions_tree_id_foreign` (`tree_id`),
  ADD KEY `subscriptions_branches_id_foreign` (`branches_id`),
  ADD KEY `subscriptions_activity_type_id_foreign` (`activity_type_id`),
  ADD KEY `subscriptions_countries_id_foreign` (`countries_id`),
  ADD KEY `subscriptions_city_id_foreign` (`city_id`),
  ADD KEY `subscriptions_state_id_foreign` (`state_id`),
  ADD KEY `subscriptions_cc_id_foreign` (`cc_id`);

--
-- Indexes for table `sub_parents`
--
ALTER TABLE `sub_parents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_parents_subscription_id_foreign` (`subscription_id`),
  ADD KEY `sub_parents_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `suppliers_country_id_foreign` (`country_id`),
  ADD KEY `suppliers_tree_id_foreign` (`tree_id`),
  ADD KEY `suppliers_operation_id_foreign` (`operation_id`),
  ADD KEY `suppliers_branches_id_foreign` (`branches_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_city_id_foreign` (`city_id`),
  ADD KEY `users_state_id_foreign` (`state_id`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activitytypes`
--
ALTER TABLE `activitytypes`
  MODIFY `ID_No` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `activity_type`
--
ALTER TABLE `activity_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `astcurncy`
--
ALTER TABLE `astcurncy`
  MODIFY `ID_No` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `astmarket`
--
ALTER TABLE `astmarket`
  MODIFY `ID_No` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `astsalesman`
--
ALTER TABLE `astsalesman`
  MODIFY `ID_No` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `astsupctgs`
--
ALTER TABLE `astsupctgs`
  MODIFY `ID_No` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blog_entries`
--
ALTER TABLE `blog_entries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `branche_employee`
--
ALTER TABLE `branche_employee`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contractors`
--
ALTER TABLE `contractors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contractors_types`
--
ALTER TABLE `contractors_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `glaccbnk`
--
ALTER TABLE `glaccbnk`
  MODIFY `ID_No` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `glastjrntyp`
--
ALTER TABLE `glastjrntyp`
  MODIFY `ID_NO` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `glccs`
--
ALTER TABLE `glccs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gljrnal`
--
ALTER TABLE `gljrnal`
  MODIFY `ID_No` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `gljrntrs`
--
ALTER TABLE `gljrntrs`
  MODIFY `ID_No` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `limitationreceipts`
--
ALTER TABLE `limitationreceipts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `limitations`
--
ALTER TABLE `limitations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `limitations_datas`
--
ALTER TABLE `limitations_datas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `limitations_data_types`
--
ALTER TABLE `limitations_data_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `limitations_type`
--
ALTER TABLE `limitations_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mainbranch`
--
ALTER TABLE `mainbranch`
  MODIFY `ID_No` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `maincompany`
--
ALTER TABLE `maincompany`
  MODIFY `ID_No` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `mtschartac`
--
ALTER TABLE `mtschartac`
  MODIFY `ID_No` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT for table `mtsclosacc`
--
ALTER TABLE `mtsclosacc`
  MODIFY `ID_No` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `mtscustomer`
--
ALTER TABLE `mtscustomer`
  MODIFY `ID_No` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `mts_costcntrs`
--
ALTER TABLE `mts_costcntrs`
  MODIFY `ID_No` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `mts_suplirs`
--
ALTER TABLE `mts_suplirs`
  MODIFY `ID_No` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `nations`
--
ALTER TABLE `nations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `operations`
--
ALTER TABLE `operations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `parents`
--
ALTER TABLE `parents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pjitmmsfls`
--
ALTER TABLE `pjitmmsfls`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projcontractmfs`
--
ALTER TABLE `projcontractmfs`
  MODIFY `ID_No` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `projectcontracts`
--
ALTER TABLE `projectcontracts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projectmfs`
--
ALTER TABLE `projectmfs`
  MODIFY `ID_No` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `receipts`
--
ALTER TABLE `receipts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `receipts_data`
--
ALTER TABLE `receipts_data`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `receipts_data_types`
--
ALTER TABLE `receipts_data_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `receipts_type`
--
ALTER TABLE `receipts_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `responsible_people`
--
ALTER TABLE `responsible_people`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_parents`
--
ALTER TABLE `sub_parents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `branche_employee`
--
ALTER TABLE `branche_employee`
  ADD CONSTRAINT `branche_employee_branche_id_foreign` FOREIGN KEY (`branche_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `branche_employee_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `contractors`
--
ALTER TABLE `contractors`
  ADD CONSTRAINT `contractors_contractor_type_id_foreign` FOREIGN KEY (`contractor_type_id`) REFERENCES `contractors_types` (`id`),
  ADD CONSTRAINT `contractors_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `contractors_operation_id_foreign` FOREIGN KEY (`operation_id`) REFERENCES `operations` (`id`),
  ADD CONSTRAINT `contractors_tree_id_foreign` FOREIGN KEY (`tree_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `contracts`
--
ALTER TABLE `contracts`
  ADD CONSTRAINT `contracts_contractor_id_foreign` FOREIGN KEY (`contractor_id`) REFERENCES `contractors` (`id`),
  ADD CONSTRAINT `contracts_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `contracts_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `contracts_subscriber_id_foreign` FOREIGN KEY (`subscriber_id`) REFERENCES `subscriptions` (`id`);

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `departments_cc_id_foreign` FOREIGN KEY (`cc_id`) REFERENCES `glccs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `departments_level_id_foreign` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`),
  ADD CONSTRAINT `departments_operation_id_foreign` FOREIGN KEY (`operation_id`) REFERENCES `operations` (`id`),
  ADD CONSTRAINT `departments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_branches_id_foreign` FOREIGN KEY (`branches_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `employees_cc_id_foreign` FOREIGN KEY (`cc_id`) REFERENCES `glccs` (`id`),
  ADD CONSTRAINT `employees_companybanks_id_foreign` FOREIGN KEY (`companybanks_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `employees_employeebanks_id_foreign` FOREIGN KEY (`employeebanks_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `employees_operation_id_foreign` FOREIGN KEY (`operation_id`) REFERENCES `operations` (`id`),
  ADD CONSTRAINT `employees_tree_id_foreign` FOREIGN KEY (`tree_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `glccs`
--
ALTER TABLE `glccs`
  ADD CONSTRAINT `glccs_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `glccs_level_id_foreign` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`),
  ADD CONSTRAINT `glccs_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `levels`
--
ALTER TABLE `levels`
  ADD CONSTRAINT `levels_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `levels` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `limitations`
--
ALTER TABLE `limitations`
  ADD CONSTRAINT `limitations_branche_id_foreign` FOREIGN KEY (`branche_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `limitations_limitationstype_id_foreign` FOREIGN KEY (`limitationsType_id`) REFERENCES `limitationreceipts` (`id`);

--
-- Constraints for table `limitations_datas`
--
ALTER TABLE `limitations_datas`
  ADD CONSTRAINT `limitations_datas_limitations_id_foreign` FOREIGN KEY (`limitations_id`) REFERENCES `limitations` (`id`);

--
-- Constraints for table `limitations_data_types`
--
ALTER TABLE `limitations_data_types`
  ADD CONSTRAINT `limitations_data_types_limitations_data_id_foreign` FOREIGN KEY (`limitations_data_id`) REFERENCES `limitations_datas` (`id`),
  ADD CONSTRAINT `limitations_data_types_limitations_type_id_foreign` FOREIGN KEY (`limitations_type_id`) REFERENCES `limitations_type` (`id`);

--
-- Constraints for table `limitations_type`
--
ALTER TABLE `limitations_type`
  ADD CONSTRAINT `limitations_type_cc_id_foreign` FOREIGN KEY (`cc_id`) REFERENCES `glccs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `limitations_type_limitations_id_foreign` FOREIGN KEY (`limitations_id`) REFERENCES `limitations` (`id`),
  ADD CONSTRAINT `limitations_type_operation_id_foreign` FOREIGN KEY (`operation_id`) REFERENCES `operations` (`id`),
  ADD CONSTRAINT `limitations_type_tree_id_foreign` FOREIGN KEY (`tree_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `mainbranch`
--
ALTER TABLE `mainbranch`
  ADD CONSTRAINT `mainbranch_cmp_no_foreign` FOREIGN KEY (`Cmp_No`) REFERENCES `maincompany` (`Cmp_No`) ON DELETE CASCADE;

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
-- Constraints for table `nations`
--
ALTER TABLE `nations`
  ADD CONSTRAINT `nations_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);

--
-- Constraints for table `pjitmmsfls`
--
ALTER TABLE `pjitmmsfls`
  ADD CONSTRAINT `pjitmmsfls_cc_id_foreign` FOREIGN KEY (`cc_id`) REFERENCES `glccs` (`id`),
  ADD CONSTRAINT `pjitmmsfls_tree_id_foreign` FOREIGN KEY (`tree_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `projectcontracts`
--
ALTER TABLE `projectcontracts`
  ADD CONSTRAINT `projectcontracts_branche_id_foreign` FOREIGN KEY (`branche_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `projectcontracts_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  ADD CONSTRAINT `projectcontracts_subscriber_id_foreign` FOREIGN KEY (`subscriber_id`) REFERENCES `subscriptions` (`id`);

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_cc_id_foreign` FOREIGN KEY (`cc_id`) REFERENCES `glccs` (`id`),
  ADD CONSTRAINT `projects_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `projects_operation_id_foreign` FOREIGN KEY (`operation_id`) REFERENCES `operations` (`id`),
  ADD CONSTRAINT `projects_tree_id_foreign` FOREIGN KEY (`tree_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `receipts`
--
ALTER TABLE `receipts`
  ADD CONSTRAINT `receipts_branche_id_foreign` FOREIGN KEY (`branche_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `receipts_operation_id_foreign` FOREIGN KEY (`operation_id`) REFERENCES `operations` (`id`),
  ADD CONSTRAINT `receipts_receiptstype_id_foreign` FOREIGN KEY (`receiptsType_id`) REFERENCES `limitationreceipts` (`id`);

--
-- Constraints for table `receipts_data`
--
ALTER TABLE `receipts_data`
  ADD CONSTRAINT `receipts_data_operation_id_foreign` FOREIGN KEY (`operation_id`) REFERENCES `operations` (`id`),
  ADD CONSTRAINT `receipts_data_receipts_id_foreign` FOREIGN KEY (`receipts_id`) REFERENCES `receipts` (`id`),
  ADD CONSTRAINT `receipts_data_tree_id_foreign` FOREIGN KEY (`tree_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `receipts_data_types`
--
ALTER TABLE `receipts_data_types`
  ADD CONSTRAINT `receipts_data_types_receipts_data_id_foreign` FOREIGN KEY (`receipts_data_id`) REFERENCES `receipts_data` (`id`),
  ADD CONSTRAINT `receipts_data_types_receipts_type_id_foreign` FOREIGN KEY (`receipts_type_id`) REFERENCES `receipts_type` (`id`);

--
-- Constraints for table `receipts_type`
--
ALTER TABLE `receipts_type`
  ADD CONSTRAINT `receipts_type_cc_id_foreign` FOREIGN KEY (`cc_id`) REFERENCES `glccs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `receipts_type_operation_id_foreign` FOREIGN KEY (`operation_id`) REFERENCES `operations` (`id`),
  ADD CONSTRAINT `receipts_type_receipts_id_foreign` FOREIGN KEY (`receipts_id`) REFERENCES `receipts` (`id`),
  ADD CONSTRAINT `receipts_type_tree_id_foreign` FOREIGN KEY (`tree_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `responsible_people`
--
ALTER TABLE `responsible_people`
  ADD CONSTRAINT `responsible_people_contractor_name_foreign` FOREIGN KEY (`contractor_name`) REFERENCES `contractors` (`id`);

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `states`
--
ALTER TABLE `states`
  ADD CONSTRAINT `states_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `states_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_activity_type_id_foreign` FOREIGN KEY (`activity_type_id`) REFERENCES `activity_type` (`id`),
  ADD CONSTRAINT `subscriptions_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`),
  ADD CONSTRAINT `subscriptions_branches_id_foreign` FOREIGN KEY (`branches_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `subscriptions_cc_id_foreign` FOREIGN KEY (`cc_id`) REFERENCES `glccs` (`id`),
  ADD CONSTRAINT `subscriptions_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `subscriptions_countries_id_foreign` FOREIGN KEY (`countries_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `subscriptions_operation_id_foreign` FOREIGN KEY (`operation_id`) REFERENCES `operations` (`id`),
  ADD CONSTRAINT `subscriptions_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`),
  ADD CONSTRAINT `subscriptions_tree_id_foreign` FOREIGN KEY (`tree_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `sub_parents`
--
ALTER TABLE `sub_parents`
  ADD CONSTRAINT `sub_parents_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `parents` (`id`),
  ADD CONSTRAINT `sub_parents_subscription_id_foreign` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`);

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_branches_id_foreign` FOREIGN KEY (`branches_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `suppliers_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `suppliers_operation_id_foreign` FOREIGN KEY (`operation_id`) REFERENCES `operations` (`id`),
  ADD CONSTRAINT `suppliers_tree_id_foreign` FOREIGN KEY (`tree_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
