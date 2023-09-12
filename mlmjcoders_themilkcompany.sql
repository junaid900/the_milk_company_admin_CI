-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 12, 2023 at 04:30 AM
-- Server version: 5.7.43
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mlmjcoders_themilkcompany`
--

-- --------------------------------------------------------

--
-- Table structure for table `milk_account`
--

CREATE TABLE `milk_account` (
  `account_id` int(11) NOT NULL,
  `account_no` text NOT NULL,
  `account_name` text NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `status` enum('Active','Inactive') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `milk_account`
--

INSERT INTO `milk_account` (`account_id`, `account_no`, `account_name`, `description`, `image`, `status`) VALUES
(1, '03006335290', 'Ali Bukhari', 'Send money and upload slip for jazz cash', 'uploads/payment/jazz_cash.png', 'Active'),
(2, '05090105580668', 'Meezan Bank', 'PK79MEZN0005090105580668', 'uploads/payment/6276cd5a924a6.png', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `milk_app_setting`
--

CREATE TABLE `milk_app_setting` (
  `id` int(11) NOT NULL,
  `item_key` text NOT NULL,
  `item_type` text NOT NULL,
  `item_value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `milk_app_setting`
--

INSERT INTO `milk_app_setting` (`id`, `item_key`, `item_type`, `item_value`) VALUES
(1, 'referal_amount', 'referal_amount_for_referal_user', '100'),
(2, 'referal_amount_user', 'referal_amount_for_user_refered_by', '100');

-- --------------------------------------------------------

--
-- Table structure for table `milk_banner`
--

CREATE TABLE `milk_banner` (
  `banner_id` int(11) NOT NULL,
  `banner_title` text,
  `banner_image` text NOT NULL,
  `description` text,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `milk_category`
--

CREATE TABLE `milk_category` (
  `category_id` int(11) NOT NULL,
  `category_name` text NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `milk_category`
--

INSERT INTO `milk_category` (`category_id`, `category_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Milk', 'Inactive', '2021-11-30 12:43:24', '2022-05-08 09:08:08'),
(2, 'Yogurt', 'Inactive', '2021-11-30 12:43:51', '2022-05-08 09:07:50'),
(3, 'Milk Boiled ( Ready to Use)', 'Active', '2021-11-30 12:43:51', '2022-05-08 09:08:15'),
(4, 'Halwa', 'Active', '2022-01-01 09:49:44', '2022-02-20 01:34:25'),
(6, 'The Water', 'Active', '2022-03-20 06:54:05', '2022-03-20 06:54:05'),
(5, '03212445888', 'Inactive', '2022-02-20 01:31:36', '2022-05-08 09:10:02'),
(7, '03212445888', 'Active', '2022-05-08 09:10:53', '2022-05-08 09:10:53'),
(8, '03212445888', 'Active', '2022-05-08 09:10:53', '2022-05-08 09:10:53');

-- --------------------------------------------------------

--
-- Table structure for table `milk_constraint`
--

CREATE TABLE `milk_constraint` (
  `constraint_id` int(11) NOT NULL,
  `item_key` varchar(30) NOT NULL,
  `item_value` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `milk_notification`
--

CREATE TABLE `milk_notification` (
  `notification_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL DEFAULT '0',
  `notification_title` text NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `click` varchar(255) NOT NULL,
  `read_status` enum('Read','Unread') NOT NULL DEFAULT 'Unread',
  `data` text,
  `type` enum('Single','Group','All','Admin','Store','Driver') NOT NULL DEFAULT 'Single',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `milk_notification`
--

INSERT INTO `milk_notification` (`notification_id`, `receiver_id`, `notification_title`, `description`, `image`, `click`, `read_status`, `data`, `type`, `created_at`, `updated_at`) VALUES
(1, 11, 'Your order submitted successfully', 'Your order submitted successfully please check order history', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '{\"address_id\":\"4\",\"user_id\":\"11\",\"products\":\"[{\\\"product_id\\\":\\\"1\\\",\\\"id\\\":\\\"1\\\",\\\"quantity\\\":\\\"1\\\",\\\"time\\\":\\\"3\\\",\\\"s_date\\\":\\\"2022-03-24 00:00:00.000\\\",\\\"e_date\\\":\\\"2022-03-25 00:00:00.000\\\",\\\"product_price\\\":\\\"100\\\",\\\"type\\\":\\\"Week\\\",\\\"days\\\":\\\"2\\\"},{\\\"product_id\\\":\\\"2\\\",\\\"id\\\":\\\"2\\\",\\\"quantity\\\":\\\"1\\\",\\\"time\\\":\\\"5\\\",\\\"s_date\\\":\\\"\\\",\\\"e_date\\\":\\\"\\\",\\\"product_price\\\":\\\"140\\\",\\\"type\\\":\\\"One Time\\\",\\\"days\\\":\\\"0\\\"}]\",\"total\":340,\"no_of_products\":2,\"payment_method\":\"cash_on_delivery\"}', 'Single', '2022-03-17 06:55:21', '2022-03-17 01:55:21'),
(2, 11, 'New order received', 'You have received new order please check order history', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '{\"address_id\":\"4\",\"user_id\":\"11\",\"products\":\"[{\\\"product_id\\\":\\\"1\\\",\\\"id\\\":\\\"1\\\",\\\"quantity\\\":\\\"1\\\",\\\"time\\\":\\\"3\\\",\\\"s_date\\\":\\\"2022-03-24 00:00:00.000\\\",\\\"e_date\\\":\\\"2022-03-25 00:00:00.000\\\",\\\"product_price\\\":\\\"100\\\",\\\"type\\\":\\\"Week\\\",\\\"days\\\":\\\"2\\\"},{\\\"product_id\\\":\\\"2\\\",\\\"id\\\":\\\"2\\\",\\\"quantity\\\":\\\"1\\\",\\\"time\\\":\\\"5\\\",\\\"s_date\\\":\\\"\\\",\\\"e_date\\\":\\\"\\\",\\\"product_price\\\":\\\"140\\\",\\\"type\\\":\\\"One Time\\\",\\\"days\\\":\\\"0\\\"}]\",\"total\":340,\"no_of_products\":2,\"payment_method\":\"cash_on_delivery\"}', 'Admin', '2022-03-17 06:55:21', '2022-03-17 01:55:21'),
(3, 11, 'Order Canceled', 'O-1 has been canceled', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '{\"order_by\":\"desc\"}', 'Single', '2022-03-17 09:45:08', '2022-03-17 04:45:08'),
(4, 13, 'Your order submitted successfully', 'Your order submitted successfully please check order history', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '{\"address_id\":\"5\",\"user_id\":\"13\",\"products\":\"[{\\\"product_id\\\":\\\"2\\\",\\\"id\\\":\\\"3\\\",\\\"quantity\\\":\\\"1\\\",\\\"time\\\":\\\"5\\\",\\\"s_date\\\":\\\"\\\",\\\"e_date\\\":\\\"\\\",\\\"product_price\\\":\\\"140\\\",\\\"type\\\":\\\"One Time\\\",\\\"days\\\":\\\"0\\\"}]\",\"total\":140,\"no_of_products\":1,\"payment_method\":\"cash_on_delivery\"}', 'Single', '2022-03-17 09:45:12', '2022-03-17 04:45:12'),
(5, 13, 'New order received', 'You have received new order please check order history', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '{\"address_id\":\"5\",\"user_id\":\"13\",\"products\":\"[{\\\"product_id\\\":\\\"2\\\",\\\"id\\\":\\\"3\\\",\\\"quantity\\\":\\\"1\\\",\\\"time\\\":\\\"5\\\",\\\"s_date\\\":\\\"\\\",\\\"e_date\\\":\\\"\\\",\\\"product_price\\\":\\\"140\\\",\\\"type\\\":\\\"One Time\\\",\\\"days\\\":\\\"0\\\"}]\",\"total\":140,\"no_of_products\":1,\"payment_method\":\"cash_on_delivery\"}', 'Admin', '2022-03-17 09:45:12', '2022-03-17 04:45:12'),
(6, 13, 'Order Canceled', 'O-4 has been canceled', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '{\"order_by\":\"desc\"}', 'Single', '2022-03-17 09:45:36', '2022-03-17 04:45:36'),
(7, 11, 'Order Canceled', 'O-3 has been canceled', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '{\"order_by\":\"desc\"}', 'Single', '2022-04-08 03:17:21', '2022-04-08 10:17:21'),
(8, 11, 'Order Canceled', 'O-2 has been canceled', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '{\"order_by\":\"desc\"}', 'Single', '2022-04-08 03:17:46', '2022-04-08 10:17:46'),
(9, 18, 'Your order submitted successfully', 'Your order submitted successfully please check order history', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '{\"address_id\":\"6\",\"user_id\":\"18\",\"products\":\"[{\\\"product_id\\\":\\\"1\\\",\\\"id\\\":\\\"1\\\",\\\"quantity\\\":\\\"1\\\",\\\"time\\\":\\\"3\\\",\\\"s_date\\\":\\\"\\\",\\\"e_date\\\":\\\"\\\",\\\"product_price\\\":\\\"100\\\",\\\"type\\\":\\\"One Time\\\",\\\"days\\\":\\\"0\\\"}]\",\"total\":100,\"no_of_products\":1,\"payment_method\":\"cash_on_delivery\"}', 'Single', '2022-04-23 04:57:59', '2022-04-22 23:57:59'),
(10, 18, 'New order received', 'You have received new order please check order history', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '{\"address_id\":\"6\",\"user_id\":\"18\",\"products\":\"[{\\\"product_id\\\":\\\"1\\\",\\\"id\\\":\\\"1\\\",\\\"quantity\\\":\\\"1\\\",\\\"time\\\":\\\"3\\\",\\\"s_date\\\":\\\"\\\",\\\"e_date\\\":\\\"\\\",\\\"product_price\\\":\\\"100\\\",\\\"type\\\":\\\"One Time\\\",\\\"days\\\":\\\"0\\\"}]\",\"total\":100,\"no_of_products\":1,\"payment_method\":\"cash_on_delivery\"}', 'Admin', '2022-04-23 04:58:00', '2022-04-22 23:58:00'),
(11, 1, 'New Order Assignment', 'A new order has been assigned o-5', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '{\"order_by\":\"desc\"}', 'Store', '2022-04-24 01:01:15', '2022-04-23 20:01:15'),
(12, 10, 'New Order Assignment', 'A new order has been assigned o-5', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '[]', 'Driver', '2022-04-24 01:01:17', '2022-04-23 20:01:17'),
(13, 10, 'New Order Assignment', 'A new order has been assigned o-5', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '[]', 'Driver', '2022-04-24 07:06:25', '2022-04-24 14:06:25'),
(14, 18, 'Order Completed', 'O-5 has been completed', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '{\"order_by\":\"desc\"}', 'Single', '2022-05-02 10:37:58', '2022-05-02 17:37:58'),
(15, 21, 'Your order submitted successfully', 'Your order submitted successfully please check order history', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '{\"address_id\":\"8\",\"user_id\":\"21\",\"products\":\"[{\\\"product_id\\\":\\\"1\\\",\\\"id\\\":\\\"2\\\",\\\"quantity\\\":\\\"2\\\",\\\"time\\\":\\\"13\\\",\\\"s_date\\\":\\\"2022-05-04 00:00:00.000\\\",\\\"e_date\\\":\\\"2022-05-21 00:00:00.000\\\",\\\"product_price\\\":\\\"100\\\",\\\"type\\\":\\\"Month\\\",\\\"days\\\":\\\"18\\\"}]\",\"total\":3600,\"no_of_products\":1,\"payment_method\":\"cash_on_delivery\"}', 'Single', '2022-05-03 06:28:02', '2022-05-03 13:28:02'),
(16, 21, 'New order received', 'You have received new order please check order history', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '{\"address_id\":\"8\",\"user_id\":\"21\",\"products\":\"[{\\\"product_id\\\":\\\"1\\\",\\\"id\\\":\\\"2\\\",\\\"quantity\\\":\\\"2\\\",\\\"time\\\":\\\"13\\\",\\\"s_date\\\":\\\"2022-05-04 00:00:00.000\\\",\\\"e_date\\\":\\\"2022-05-21 00:00:00.000\\\",\\\"product_price\\\":\\\"100\\\",\\\"type\\\":\\\"Month\\\",\\\"days\\\":\\\"18\\\"}]\",\"total\":3600,\"no_of_products\":1,\"payment_method\":\"cash_on_delivery\"}', 'Admin', '2022-05-03 06:28:02', '2022-05-03 13:28:02'),
(17, 21, 'Order Canceled', 'O-7 has been canceled', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '{\"order_by\":\"desc\"}', 'Single', '2022-05-06 08:57:57', '2022-05-06 03:57:57'),
(18, 21, 'Order Canceled', 'O-8 has been canceled', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '{\"order_by\":\"desc\"}', 'Single', '2022-05-06 08:58:19', '2022-05-06 03:58:19'),
(19, 19, 'Your order submitted successfully', 'Your order submitted successfully please check order history', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '{\"address_id\":\"9\",\"user_id\":\"19\",\"products\":\"[{\\\"product_id\\\":\\\"1\\\",\\\"id\\\":\\\"1\\\",\\\"quantity\\\":\\\"2\\\",\\\"time\\\":\\\"3\\\",\\\"s_date\\\":\\\"\\\",\\\"e_date\\\":\\\"\\\",\\\"product_price\\\":\\\"100\\\",\\\"type\\\":\\\"One Time\\\",\\\"days\\\":\\\"0\\\"}]\",\"total\":200,\"no_of_products\":1,\"payment_method\":\"cash_on_delivery\"}', 'Single', '2022-05-07 09:49:27', '2022-05-07 16:49:27'),
(20, 19, 'New order received', 'You have received new order please check order history', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '{\"address_id\":\"9\",\"user_id\":\"19\",\"products\":\"[{\\\"product_id\\\":\\\"1\\\",\\\"id\\\":\\\"1\\\",\\\"quantity\\\":\\\"2\\\",\\\"time\\\":\\\"3\\\",\\\"s_date\\\":\\\"\\\",\\\"e_date\\\":\\\"\\\",\\\"product_price\\\":\\\"100\\\",\\\"type\\\":\\\"One Time\\\",\\\"days\\\":\\\"0\\\"}]\",\"total\":200,\"no_of_products\":1,\"payment_method\":\"cash_on_delivery\"}', 'Admin', '2022-05-07 09:49:27', '2022-05-07 16:49:27'),
(21, 1, 'New Order Assignment', 'A new order has been assigned o-6', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '{\"order_by\":\"desc\"}', 'Store', '2022-05-07 09:50:01', '2022-05-07 16:50:01'),
(22, 1, 'New Order Assignment', 'A new order has been assigned o-24', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '{\"order_by\":\"desc\"}', 'Store', '2022-05-07 09:51:06', '2022-05-07 16:51:06'),
(23, 21, 'Order Canceled', 'O-9 has been canceled', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '{\"order_by\":\"desc\"}', 'Single', '2022-05-08 12:51:07', '2022-05-07 19:51:07'),
(24, 21, 'Order Canceled', 'O-9 has been canceled', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '{\"order_by\":\"desc\"}', 'Single', '2022-05-08 12:53:49', '2022-05-07 19:53:49'),
(25, 21, 'Order Canceled', 'O-11 has been canceled', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '{\"order_by\":\"desc\"}', 'Single', '2022-05-09 11:59:51', '2022-05-09 18:59:51'),
(26, 21, 'Order Canceled', 'O-12 has been canceled', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '{\"order_by\":\"desc\"}', 'Single', '2022-05-10 12:01:24', '2022-05-09 19:01:24'),
(27, 21, 'Order Canceled', 'O-10 has been canceled', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '{\"order_by\":\"desc\"}', 'Single', '2022-05-10 12:01:42', '2022-05-09 19:01:42'),
(28, 19, 'Order Canceled', 'O-24 has been canceled', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '{\"order_by\":\"desc\"}', 'Single', '2022-05-10 12:01:53', '2022-05-09 19:01:53'),
(29, 21, 'Order Canceled', 'O-9 has been canceled', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '{\"order_by\":\"desc\"}', 'Single', '2022-05-10 12:02:14', '2022-05-09 19:02:14'),
(30, 21, 'Order Canceled', 'O-6 has been canceled', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '{\"order_by\":\"desc\"}', 'Single', '2022-05-10 12:02:31', '2022-05-09 19:02:31'),
(31, 24, 'Your order submitted successfully', 'Your order submitted successfully please check order history', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '{\"address_id\":\"13\",\"user_id\":\"24\",\"products\":\"[{\\\"product_id\\\":\\\"1\\\",\\\"id\\\":\\\"1\\\",\\\"quantity\\\":\\\"1\\\",\\\"time\\\":\\\"3\\\",\\\"s_date\\\":\\\"\\\",\\\"e_date\\\":\\\"\\\",\\\"product_price\\\":\\\"100\\\",\\\"type\\\":\\\"One Time\\\",\\\"days\\\":\\\"0\\\"}]\",\"total\":100,\"no_of_products\":1,\"payment_method\":\"cash_on_delivery\"}', 'Single', '2022-06-08 09:08:39', '2022-06-08 16:08:39'),
(32, 24, 'New order received', 'You have received new order please check order history', 'uploads/system/purchase-order-request-form.jpeg', 'order', 'Unread', '{\"address_id\":\"13\",\"user_id\":\"24\",\"products\":\"[{\\\"product_id\\\":\\\"1\\\",\\\"id\\\":\\\"1\\\",\\\"quantity\\\":\\\"1\\\",\\\"time\\\":\\\"3\\\",\\\"s_date\\\":\\\"\\\",\\\"e_date\\\":\\\"\\\",\\\"product_price\\\":\\\"100\\\",\\\"type\\\":\\\"One Time\\\",\\\"days\\\":\\\"0\\\"}]\",\"total\":100,\"no_of_products\":1,\"payment_method\":\"cash_on_delivery\"}', 'Admin', '2022-06-08 09:08:39', '2022-06-08 16:08:39');

-- --------------------------------------------------------

--
-- Table structure for table `milk_order`
--

CREATE TABLE `milk_order` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `description` longtext,
  `delivery_charges` int(11) NOT NULL DEFAULT '0',
  `sub_total` double NOT NULL DEFAULT '0',
  `grand_total` double NOT NULL DEFAULT '0',
  `actual_total` double NOT NULL DEFAULT '0',
  `order_status` enum('Pending','In-Process','On-Way','Delivered','Completed','Cancel') NOT NULL DEFAULT 'Pending',
  `store_id` int(11) NOT NULL DEFAULT '0',
  `driver_id` int(11) NOT NULL DEFAULT '0',
  `paid` enum('Yes','No') NOT NULL DEFAULT 'No',
  `order_referance` int(11) NOT NULL DEFAULT '0',
  `payment_method` enum('cash_on_delivery','wallet') NOT NULL DEFAULT 'cash_on_delivery',
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `milk_order`
--

INSERT INTO `milk_order` (`order_id`, `user_id`, `address_id`, `description`, `delivery_charges`, `sub_total`, `grand_total`, `actual_total`, `order_status`, `store_id`, `driver_id`, `paid`, `order_referance`, `payment_method`, `order_date`, `order_created_at`, `order_updated_at`) VALUES
(1, 11, 4, NULL, 0, 340, 340, 240, 'Cancel', 0, 0, 'No', 0, 'cash_on_delivery', '2022-03-17 00:00:00', '2022-03-17 06:55:21', '2022-03-17 04:45:08'),
(2, 11, 4, NULL, 0, 340, 340, 100, 'Cancel', 0, 0, 'No', 1, 'cash_on_delivery', '2022-03-24 00:00:00', '2022-03-17 06:55:21', '2022-04-08 10:17:46'),
(3, 11, 4, NULL, 0, 340, 340, 100, 'Cancel', 0, 0, 'No', 1, 'cash_on_delivery', '2022-03-25 00:00:00', '2022-03-17 06:55:21', '2022-04-08 10:17:21'),
(4, 13, 5, NULL, 0, 140, 140, 140, 'Cancel', 0, 0, 'No', 0, 'cash_on_delivery', '2022-03-17 00:00:00', '2022-03-17 09:45:12', '2022-03-17 04:45:36'),
(5, 18, 6, NULL, 0, 100, 100, 100, 'Completed', 1, 10, 'Yes', 0, 'cash_on_delivery', '2022-04-23 00:00:00', '2022-04-23 04:57:59', '2022-05-02 17:37:58'),
(6, 21, 8, NULL, 0, 3600, 3600, 200, 'Cancel', 1, 0, 'No', 0, 'cash_on_delivery', '2022-05-04 00:00:00', '2022-05-03 06:28:02', '2022-05-09 19:02:31'),
(7, 21, 8, NULL, 0, 3600, 3600, 200, 'Cancel', 1, 0, 'No', 6, 'cash_on_delivery', '2022-05-05 00:00:00', '2022-05-03 06:28:02', '2022-05-07 16:50:01'),
(8, 21, 8, NULL, 0, 3600, 3600, 200, 'Cancel', 1, 0, 'No', 6, 'cash_on_delivery', '2022-05-06 00:00:00', '2022-05-03 06:28:02', '2022-05-07 16:50:01'),
(9, 21, 8, NULL, 0, 3600, 3600, 200, 'Cancel', 1, 0, 'No', 6, 'cash_on_delivery', '2022-05-07 00:00:00', '2022-05-03 06:28:02', '2022-05-09 19:02:14'),
(10, 21, 8, NULL, 0, 3600, 3600, 200, 'Cancel', 1, 0, 'No', 6, 'cash_on_delivery', '2022-05-08 00:00:00', '2022-05-03 06:28:02', '2022-05-09 19:01:42'),
(11, 21, 8, NULL, 0, 3600, 3600, 200, 'Cancel', 1, 0, 'No', 6, 'cash_on_delivery', '2022-05-09 00:00:00', '2022-05-03 06:28:02', '2022-05-09 18:59:51'),
(12, 21, 8, NULL, 0, 3600, 3600, 200, 'Cancel', 1, 0, 'No', 6, 'cash_on_delivery', '2022-05-10 00:00:00', '2022-05-03 06:28:02', '2022-05-09 19:01:24'),
(13, 21, 8, NULL, 0, 3600, 3600, 200, 'Pending', 1, 0, 'No', 6, 'cash_on_delivery', '2022-05-11 00:00:00', '2022-05-03 06:28:02', '2022-05-07 16:50:01'),
(14, 21, 8, NULL, 0, 3600, 3600, 200, 'Pending', 1, 0, 'No', 6, 'cash_on_delivery', '2022-05-12 00:00:00', '2022-05-03 06:28:02', '2022-05-07 16:50:01'),
(15, 21, 8, NULL, 0, 3600, 3600, 200, 'Pending', 1, 0, 'No', 6, 'cash_on_delivery', '2022-05-13 00:00:00', '2022-05-03 06:28:02', '2022-05-07 16:50:01'),
(16, 21, 8, NULL, 0, 3600, 3600, 200, 'Pending', 1, 0, 'No', 6, 'cash_on_delivery', '2022-05-14 00:00:00', '2022-05-03 06:28:02', '2022-05-07 16:50:01'),
(17, 21, 8, NULL, 0, 3600, 3600, 200, 'Pending', 1, 0, 'No', 6, 'cash_on_delivery', '2022-05-15 00:00:00', '2022-05-03 06:28:02', '2022-05-07 16:50:01'),
(18, 21, 8, NULL, 0, 3600, 3600, 200, 'Pending', 1, 0, 'No', 6, 'cash_on_delivery', '2022-05-16 00:00:00', '2022-05-03 06:28:02', '2022-05-07 16:50:01'),
(19, 21, 8, NULL, 0, 3600, 3600, 200, 'Pending', 1, 0, 'No', 6, 'cash_on_delivery', '2022-05-17 00:00:00', '2022-05-03 06:28:02', '2022-05-07 16:50:01'),
(20, 21, 8, NULL, 0, 3600, 3600, 200, 'Pending', 1, 0, 'No', 6, 'cash_on_delivery', '2022-05-18 00:00:00', '2022-05-03 06:28:02', '2022-05-07 16:50:01'),
(21, 21, 8, NULL, 0, 3600, 3600, 200, 'Pending', 1, 0, 'No', 6, 'cash_on_delivery', '2022-05-19 00:00:00', '2022-05-03 06:28:02', '2022-05-07 16:50:01'),
(22, 21, 8, NULL, 0, 3600, 3600, 200, 'Pending', 1, 0, 'No', 6, 'cash_on_delivery', '2022-05-20 00:00:00', '2022-05-03 06:28:02', '2022-05-07 16:50:01'),
(23, 21, 8, NULL, 0, 3600, 3600, 200, 'Pending', 1, 0, 'No', 6, 'cash_on_delivery', '2022-05-21 00:00:00', '2022-05-03 06:28:02', '2022-05-07 16:50:01'),
(24, 19, 9, NULL, 0, 200, 200, 200, 'Cancel', 1, 0, 'No', 0, 'cash_on_delivery', '2022-05-07 00:00:00', '2022-05-07 09:49:27', '2022-05-09 19:01:53'),
(25, 24, 13, NULL, 0, 100, 100, 100, 'Pending', 0, 0, 'No', 0, 'cash_on_delivery', '2022-06-08 00:00:00', '2022-06-08 09:08:39', '2022-06-08 16:08:39');

-- --------------------------------------------------------

--
-- Table structure for table `milk_order_product`
--

CREATE TABLE `milk_order_product` (
  `order_product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `type` varchar(30) NOT NULL,
  `product_timing_id` int(11) NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `price` double NOT NULL DEFAULT '0',
  `total` double NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `milk_order_product`
--

INSERT INTO `milk_order_product` (`order_product_id`, `order_id`, `product_id`, `type`, `product_timing_id`, `start_date`, `end_date`, `quantity`, `price`, `total`) VALUES
(1, 1, 2, 'One Time', 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 140, 0),
(2, 2, 1, 'Week', 3, '2022-03-24 00:00:00', '2022-03-25 00:00:00', 1, 100, 0),
(3, 3, 1, 'Week', 3, '2022-03-24 00:00:00', '2022-03-25 00:00:00', 1, 100, 0),
(4, 4, 2, 'One Time', 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 140, 0),
(5, 5, 1, 'One Time', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 100, 0),
(6, 6, 1, 'Month', 13, '2022-05-04 00:00:00', '2022-05-21 00:00:00', 2, 100, 0),
(7, 7, 1, 'Month', 13, '2022-05-04 00:00:00', '2022-05-21 00:00:00', 2, 100, 0),
(8, 8, 1, 'Month', 13, '2022-05-04 00:00:00', '2022-05-21 00:00:00', 2, 100, 0),
(9, 9, 1, 'Month', 13, '2022-05-04 00:00:00', '2022-05-21 00:00:00', 2, 100, 0),
(10, 10, 1, 'Month', 13, '2022-05-04 00:00:00', '2022-05-21 00:00:00', 2, 100, 0),
(11, 11, 1, 'Month', 13, '2022-05-04 00:00:00', '2022-05-21 00:00:00', 2, 100, 0),
(12, 12, 1, 'Month', 13, '2022-05-04 00:00:00', '2022-05-21 00:00:00', 2, 100, 0),
(13, 13, 1, 'Month', 13, '2022-05-04 00:00:00', '2022-05-21 00:00:00', 2, 100, 0),
(14, 14, 1, 'Month', 13, '2022-05-04 00:00:00', '2022-05-21 00:00:00', 2, 100, 0),
(15, 15, 1, 'Month', 13, '2022-05-04 00:00:00', '2022-05-21 00:00:00', 2, 100, 0),
(16, 16, 1, 'Month', 13, '2022-05-04 00:00:00', '2022-05-21 00:00:00', 2, 100, 0),
(17, 17, 1, 'Month', 13, '2022-05-04 00:00:00', '2022-05-21 00:00:00', 2, 100, 0),
(18, 18, 1, 'Month', 13, '2022-05-04 00:00:00', '2022-05-21 00:00:00', 2, 100, 0),
(19, 19, 1, 'Month', 13, '2022-05-04 00:00:00', '2022-05-21 00:00:00', 2, 100, 0),
(20, 20, 1, 'Month', 13, '2022-05-04 00:00:00', '2022-05-21 00:00:00', 2, 100, 0),
(21, 21, 1, 'Month', 13, '2022-05-04 00:00:00', '2022-05-21 00:00:00', 2, 100, 0),
(22, 22, 1, 'Month', 13, '2022-05-04 00:00:00', '2022-05-21 00:00:00', 2, 100, 0),
(23, 23, 1, 'Month', 13, '2022-05-04 00:00:00', '2022-05-21 00:00:00', 2, 100, 0),
(24, 24, 1, 'One Time', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 100, 0),
(25, 25, 1, 'One Time', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 100, 0);

-- --------------------------------------------------------

--
-- Table structure for table `milk_payment_request`
--

CREATE TABLE `milk_payment_request` (
  `payment_request_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `slip_image` text NOT NULL,
  `description` text NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `admin_status` enum('Pending','Accepted','Rejected') NOT NULL DEFAULT 'Pending'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `milk_product`
--

CREATE TABLE `milk_product` (
  `product_id` int(11) NOT NULL,
  `product_name` text NOT NULL,
  `product_image` text,
  `product_description` text NOT NULL,
  `price` int(11) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `milk_product`
--

INSERT INTO `milk_product` (`product_id`, `product_name`, `product_image`, `product_description`, `price`, `category_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Milk', 'uploads/products/product-1.png', 'Fresh Milk', 100, 1, 'Active', '2021-11-30 12:45:02', '2022-03-14 15:02:19'),
(2, 'Yogurt', 'uploads/products/product-2.png', 'Fresh Yogurt', 140, 2, 'Active', '2021-11-30 12:45:02', '2022-03-14 15:24:16'),
(3, 'Eggs', 'uploads/products/product-3.jpg', 'Farm Fresh Eggs', 200, 3, 'Active', '2021-11-30 12:45:02', '2022-03-14 15:17:33'),
(9, 'The Water', 'uploads/products/6236d0eb7d038.png', 'Filtered Water', 2, 6, 'Active', '2022-03-20 06:59:55', '2022-03-20 06:59:55');

-- --------------------------------------------------------

--
-- Table structure for table `milk_product_timing`
--

CREATE TABLE `milk_product_timing` (
  `product_timing_id` int(11) NOT NULL,
  `time` text NOT NULL,
  `product_id` int(11) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `milk_product_timing`
--

INSERT INTO `milk_product_timing` (`product_timing_id`, `time`, `product_id`, `status`) VALUES
(1, '5AM', 1, 'Inactive'),
(2, '3PM', 1, 'Active'),
(3, '7PM', 1, 'Active'),
(4, '8AM', 2, 'Active'),
(5, '12PM', 2, 'Active'),
(6, '3PM', 2, 'Active'),
(12, '9AM', 3, 'Active'),
(13, '10 AM', 1, 'Active'),
(14, '3:00 PM', 9, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `milk_recharge_request`
--

CREATE TABLE `milk_recharge_request` (
  `recharge_request_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `status` enum('Pending','Canceled','Completed') NOT NULL DEFAULT 'Pending',
  `r_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `r_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `milk_role`
--

CREATE TABLE `milk_role` (
  `role_id` int(11) NOT NULL,
  `role_name` text NOT NULL,
  `role_title` text NOT NULL,
  `status` enum('Active','Inactive') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `milk_role`
--

INSERT INTO `milk_role` (`role_id`, `role_name`, `role_title`, `status`) VALUES
(1, 'admin', 'Admin', 'Active'),
(2, 'employee', 'Employee', 'Active'),
(3, 'user', 'User', 'Active'),
(4, 'driver', 'Driver', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `milk_store`
--

CREATE TABLE `milk_store` (
  `store_id` int(11) NOT NULL,
  `store_name` text NOT NULL,
  `store_address` text NOT NULL,
  `lat` text NOT NULL,
  `lng` text NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `milk_store`
--

INSERT INTO `milk_store` (`store_id`, `store_name`, `store_address`, `lat`, `lng`, `status`, `created_at`) VALUES
(1, 'TMC1', 'Punjab  Pakistan', '30.222942643546', '71.514986939728', 'Active', '2022-03-06 16:44:41'),
(2, 'TMC2', 'Main New Zakriya Town Road Main New Zakriya Town Road Pakistan', '30.22897523698', '71.492983438075', 'Active', '2022-03-06 16:45:22');

-- --------------------------------------------------------

--
-- Table structure for table `milk_transaction_history`
--

CREATE TABLE `milk_transaction_history` (
  `transaction_history_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `amount` double NOT NULL,
  `type` enum('Add','Remove') NOT NULL DEFAULT 'Add',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `milk_user`
--

CREATE TABLE `milk_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` tinyint(4) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `email` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_name` int(11) DEFAULT NULL,
  `profile_picture` text COLLATE utf8mb4_unicode_ci,
  `dob` date DEFAULT NULL,
  `activation_code` int(11) NOT NULL,
  `is_activate` tinyint(4) NOT NULL DEFAULT '0',
  `is_blocked` tinyint(4) NOT NULL DEFAULT '0',
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recovery_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referal` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `refered_by` int(11) DEFAULT NULL,
  `refered_code` text COLLATE utf8mb4_unicode_ci,
  `fcm_token` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_id` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `milk_user`
--

INSERT INTO `milk_user` (`user_id`, `created_at`, `updated_at`, `user_name`, `first_name`, `last_name`, `role_id`, `store_id`, `email`, `city_name`, `profile_picture`, `dob`, `activation_code`, `is_activate`, `is_blocked`, `phone`, `password`, `role`, `recovery_code`, `referal`, `refered_by`, `refered_code`, `fcm_token`, `session_id`) VALUES
(1, '2022-03-05 20:15:34', '2023-01-19 13:28:14', 'Ali Admin', 'Ali', 'Admin', 1, NULL, 'Ali@gmail.com', NULL, NULL, NULL, 0, 1, 0, '03043372286', '25d55ad283aa400af464c76d713c07ad', 'admin', NULL, 'XvIwdsOP4Z', NULL, NULL, '', 'a17e301f6e1e461b330a6a088ba9dc17'),
(7, '2022-03-06 16:23:48', '2022-03-07 14:10:13', 'Muhammad  Aftab', 'Muhammad ', 'Aftab', 3, NULL, 'aftabm@live.com ', NULL, ' ', NULL, 94495, 1, 0, '03006589880', '25d55ad283aa400af464c76d713c07ad', 'user', NULL, 'esgm', NULL, NULL, '', 'da571a9521181307421f35ca7e14c514'),
(8, '2022-03-06 16:47:21', '2022-03-06 16:47:21', 'Owner  TMC1', 'Owner ', 'TMC1', 2, 1, 'TMC1@incsyn.co ', NULL, NULL, NULL, 0, 1, 0, '03001112233', '25d55ad283aa400af464c76d713c07ad', 'employee', NULL, 'DYOnpyih8R', NULL, NULL, '', NULL),
(9, '2022-03-06 16:49:03', '2022-03-17 19:06:15', 'Owner TMC2', 'Owner', 'TMC2', 2, 2, 'tmc2@incsyn.com', NULL, NULL, NULL, 0, 1, 0, '03001115290', '25d55ad283aa400af464c76d713c07ad', 'employee', NULL, 'mM8Gn6hLNH', NULL, NULL, '', 'fe1dfe10ea9bc4fb0263a4a335f3cbd1'),
(10, '2022-03-06 16:51:03', '2022-04-07 09:33:40', 'Bike Ahmed', 'Bike', 'Ahmed', 4, 1, 'bike1tmc1@incsyb.com', NULL, NULL, NULL, 0, 1, 0, '03001112234', '25d55ad283aa400af464c76d713c07ad', 'driver', NULL, 'hpysWD1omd', NULL, NULL, '', '21bbec56275ddc37280ada4c287a2458'),
(11, '2022-03-10 09:49:12', '2023-01-19 13:09:45', 'Junaid Ali', 'Junaid', 'Ali', 3, NULL, 'junaidaliansaree@gmail.com', NULL, 'uploads/user/6229c9e3b435b.png', '2022-03-30', 21701, 1, 0, '03043372285', '25d55ad283aa400af464c76d713c07ad', 'user', NULL, 'K6xJ', NULL, NULL, '', '1f443a9e26d848ae1feaaadea335b609'),
(12, '2022-03-14 14:11:02', '2022-03-17 18:47:03', 'Ali fraz', 'Ali', 'fraz', 3, NULL, 'syedalifraz@live.com', NULL, ' ', NULL, 49954, 1, 0, '03006337605', '25342cf2a63edf17301a9cd6cf132f97', 'user', NULL, 'P7QA', NULL, NULL, '', '16f1993af376d803a19f95e9ec9b64d0'),
(13, '2022-03-14 14:23:15', '2022-03-14 14:23:37', 'Shagufta Bukhari', 'Shagufta', 'Bukhari', 3, NULL, 'rim89@live.com', NULL, ' ', NULL, 11617, 1, 0, '03136335290', '12e440c19046ab23468c2fc207bd008b', 'user', NULL, 'n4El', NULL, NULL, '', '695d1f39a28318d520bde034c892c8d2'),
(14, '2022-03-17 18:49:39', '2022-03-18 03:45:18', 'M. A. Jinnah Rd Ahmed', 'M. A. Jinnah Rd', 'Ahmed', 2, 1, 'ahmadakram603@gmail.com', NULL, NULL, NULL, 0, 1, 0, '03070073479', '8087b74d95b93e234cfa907f965a1a89', 'employee', NULL, 'K5NQISeJVg', NULL, NULL, '', '5bb24b4f62e378f1032680a1a7ec4661'),
(15, '2022-03-22 14:35:47', '2022-03-22 14:36:02', 'Qamar  Abbas', 'Qamar ', 'Abbas', 3, NULL, 'qamarmuchar111@gmail.com', NULL, ' ', NULL, 69915, 1, 0, '03156739350', '25f9e794323b453885f5181f1b624d0b', 'user', NULL, 'E4Gl', NULL, NULL, '', 'bff1ecdedade827ae7c1f880465e71bd'),
(16, '2022-03-23 04:53:45', '2022-03-23 04:54:17', 'Umair Asghar', 'Umair', 'Asghar', 3, NULL, 'umairasghar277@gmail.com', NULL, ' ', NULL, 74805, 1, 0, '03072806277', '24e20b4e3dac4e763a6f1c688bcbe056', 'user', NULL, 'ufn7', NULL, NULL, '', 'a33f26cb1640fa5245050a6818ddcd0e'),
(17, '2022-04-03 03:19:09', '2022-04-07 09:33:31', 'Muhammad  Usman Pervaiz ', 'Muhammad ', 'Usman Pervaiz ', 3, NULL, 'upervaiz18@gmail.com', NULL, ' ', NULL, 45753, 1, 0, '03212002333', '25d55ad283aa400af464c76d713c07ad', 'user', NULL, '8gsQ', NULL, NULL, '', 'ac66ccd2c45debec2268e96b7278ca94'),
(18, '2022-04-22 20:32:50', '2022-04-22 20:33:26', 'Zeeshan Malik', 'Zeeshan', 'Malik', 3, NULL, 'msh.jee@gmail.com', NULL, ' ', NULL, 72663, 1, 0, '03005448002', 'd54d1702ad0f8326224b817c796763c9', 'user', NULL, 'b89D', NULL, NULL, '', 'd37645a804a8322b4c5e5032eb898eb7'),
(19, '2022-05-01 06:58:18', '2022-06-05 08:47:25', 'Ali Bukhari', 'Ali', 'Bukhari', 3, NULL, 'saib@live.com', NULL, ' ', NULL, 70045, 1, 0, '03006335290', '9f8ccafd78a40dd88a32889f9c381a5e', 'user', NULL, 'OBGu', NULL, NULL, '', '60c83437a4e85fc550b84804575cc0cf'),
(20, '2022-05-02 06:37:26', '2022-05-02 06:38:01', 'Naveed Zaman', 'Naveed', 'Zaman', 3, NULL, 'naveeduzaman.p4l@gmail.com', NULL, ' ', NULL, 78795, 1, 0, '03009763074', 'befaa56927dda5955e998eb8753a8251', 'user', NULL, '0auW', NULL, NULL, '', '47ea9805b80193e0eba061fc4cbe2667'),
(21, '2022-05-03 13:24:38', '2022-05-03 13:24:54', 'syed Umair shah', 'syed Umair', 'shah', 3, NULL, 'riskyumair@gmail.com', NULL, ' ', NULL, 76862, 1, 0, '03126170604', 'f78c3fcd539079669cbce141822487e0', 'user', NULL, 'gKwf', NULL, NULL, '', 'f433947efeb4930f0fa9997fdb071e4c'),
(22, '2022-05-30 10:34:38', '2022-05-30 10:35:36', 'usama anwar', 'usama', 'anwar', 3, NULL, 'usamaanwaar04@gmail.com', NULL, ' ', NULL, 69819, 1, 0, '03036156002', '25d55ad283aa400af464c76d713c07ad', 'user', NULL, 'hzy5', NULL, NULL, '', 'f60e4640f0d6d7bafc77473b692ddc7f'),
(23, '2022-06-04 09:31:51', '2022-06-04 09:32:08', 'test a', 'test', 'a', 3, NULL, 'hufsanawaz540@gmail.com', NULL, ' ', NULL, 57586, 1, 0, '03037559070', '25d55ad283aa400af464c76d713c07ad', 'user', NULL, 'oPhO', NULL, NULL, '', 'da44912bfe237ace5fb5dffff0183fe6'),
(24, '2022-06-08 16:05:18', '2022-06-08 16:06:16', 'Dr. Zaid  Zia', 'Dr. Zaid ', 'Zia', 3, NULL, 'mzaidbinzia@yahoo.com', NULL, ' ', NULL, 92914, 1, 0, '03332423222', '8c9040e7d37dfbc917b4036dd9e9be95', 'user', NULL, '2nfr', NULL, NULL, '', 'edb451364df9d8d8364fc2fc19396225');

-- --------------------------------------------------------

--
-- Table structure for table `milk_user_address`
--

CREATE TABLE `milk_user_address` (
  `user_address_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `address` text,
  `lat` varchar(30) DEFAULT NULL,
  `lng` varchar(30) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `milk_user_address`
--

INSERT INTO `milk_user_address` (`user_address_id`, `name`, `address`, `lat`, `lng`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(5, 'Punjab', 'synergy alliance ', '30.212827427595617', '71.52718596160413', 'Active', 13, '2022-03-17 04:44:46', '2022-03-17 04:44:46'),
(3, '36', '36 36 Main/New Zakriya Town Rd Pakistan', '30.2283732689127', '71.49208355695009', 'Active', 7, '2022-03-07 04:29:31', '2022-03-07 04:29:31'),
(4, 'Multan', 'Multan  Pakistan', '30.189282361291433', '71.49004340171814', 'Active', 11, '2022-03-10 09:52:16', '2022-03-10 09:52:16'),
(6, '6F6H+885', '6F6H+885 6F6H+885 Pakistan', '30.21121389160496', '71.47892765700817', 'Active', 18, '2022-04-22 20:36:51', '2022-04-22 20:36:51'),
(7, '6FRG+288', 'House number 72 street number 3 khan village multan', '30.240747056440753', '71.47587899118662', 'Active', 20, '2022-05-02 06:39:35', '2022-05-02 06:39:35'),
(8, '2VP8+Q4M', '2VP8+Q4M 2VP8+Q4M Pakistan', '30.036132642258526', '71.86324764043093', 'Active', 21, '2022-05-03 13:26:37', '2022-05-03 13:26:37'),
(9, 'Punjab', 'Punjab  Pakistan', '30.22294611998398', '71.51499565690757', 'Active', 19, '2022-05-07 16:49:00', '2022-05-07 16:49:00'),
(10, 'office', '6G52+M7C 6G52+M7C Pakistan', '30.209034460532614', '71.50024551898241', 'Active', 22, '2022-05-30 10:36:20', '2022-05-30 10:36:20'),
(11, 'Plot 786', 'Plot 786 Plot 786 Pakistan', '30.21103367459401', '71.5008272230625', 'Active', 23, '2022-06-04 09:34:06', '2022-06-04 09:34:06'),
(12, '6FC6+M95', '6FC6+M95 6FC6+M95 Pakistan', '30.221669969360917', '71.46140646189451', 'Active', 24, '2022-06-08 16:07:36', '2022-06-08 16:07:36'),
(13, 'Multan Home', '6FC6+M95 6FC6+M95 Pakistan', '30.221498173018176', '71.46131660789251', 'Active', 24, '2022-06-08 16:08:08', '2022-06-08 16:08:08'),
(14, 'Khanewal Road', 'Khanewal Road 1st Floor Multan Trade Center Opposite MEPCO Head Quarters Pakistan', '30.209952075855586', '71.49943716824055', 'Active', 23, '2022-06-09 11:34:05', '2022-06-09 11:34:05');

-- --------------------------------------------------------

--
-- Table structure for table `milk_wallet`
--

CREATE TABLE `milk_wallet` (
  `wallet_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL DEFAULT '0',
  `available_amount` int(50) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `milk_wallet`
--

INSERT INTO `milk_wallet` (`wallet_id`, `user_id`, `total_amount`, `available_amount`, `created_at`, `updated_at`) VALUES
(5, 1, 0, 0, '2022-03-05 20:15:34', '2022-03-06 11:52:11'),
(7, 7, 0, 0, '2022-03-06 16:23:48', '2022-03-06 16:23:48'),
(8, 8, 0, 0, '2022-03-06 16:47:21', '2022-03-06 16:47:21'),
(9, 9, 0, 0, '2022-03-06 16:49:03', '2022-03-06 16:49:03'),
(10, 10, 0, 0, '2022-03-06 16:51:03', '2022-03-06 16:51:03'),
(11, 11, 0, 0, '2022-03-10 09:49:12', '2022-03-10 09:49:12'),
(12, 12, 0, 0, '2022-03-14 14:11:02', '2022-03-14 14:11:02'),
(13, 13, 0, 0, '2022-03-14 14:23:15', '2022-03-14 14:23:15'),
(14, 14, 0, 0, '2022-03-17 18:49:39', '2022-03-17 18:49:39'),
(15, 15, 0, 0, '2022-03-22 14:35:47', '2022-03-22 14:35:47'),
(16, 16, 0, 0, '2022-03-23 04:53:45', '2022-03-23 04:53:45'),
(17, 17, 0, 0, '2022-04-03 03:19:09', '2022-04-03 03:19:09'),
(18, 18, 0, 0, '2022-04-22 20:32:50', '2022-04-22 20:32:50'),
(19, 19, 0, 0, '2022-05-01 06:58:18', '2022-05-01 06:58:18'),
(20, 20, 0, 0, '2022-05-02 06:37:26', '2022-05-02 06:37:26'),
(21, 21, 0, 0, '2022-05-03 13:24:38', '2022-05-03 13:24:38'),
(22, 22, 0, 0, '2022-05-30 10:34:38', '2022-05-30 10:34:38'),
(23, 23, 0, 0, '2022-06-04 09:31:51', '2022-06-04 09:31:51'),
(24, 24, 0, 0, '2022-06-08 16:05:18', '2022-06-08 16:05:18'),
(25, 25, 0, 0, '2023-01-19 13:03:01', '2023-01-19 13:03:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `milk_account`
--
ALTER TABLE `milk_account`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `milk_app_setting`
--
ALTER TABLE `milk_app_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `milk_banner`
--
ALTER TABLE `milk_banner`
  ADD PRIMARY KEY (`banner_id`);

--
-- Indexes for table `milk_category`
--
ALTER TABLE `milk_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `milk_constraint`
--
ALTER TABLE `milk_constraint`
  ADD PRIMARY KEY (`constraint_id`);

--
-- Indexes for table `milk_notification`
--
ALTER TABLE `milk_notification`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `milk_order`
--
ALTER TABLE `milk_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `milk_order_product`
--
ALTER TABLE `milk_order_product`
  ADD PRIMARY KEY (`order_product_id`);

--
-- Indexes for table `milk_payment_request`
--
ALTER TABLE `milk_payment_request`
  ADD PRIMARY KEY (`payment_request_id`);

--
-- Indexes for table `milk_product`
--
ALTER TABLE `milk_product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `milk_product_timing`
--
ALTER TABLE `milk_product_timing`
  ADD PRIMARY KEY (`product_timing_id`);

--
-- Indexes for table `milk_recharge_request`
--
ALTER TABLE `milk_recharge_request`
  ADD PRIMARY KEY (`recharge_request_id`);

--
-- Indexes for table `milk_role`
--
ALTER TABLE `milk_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `milk_store`
--
ALTER TABLE `milk_store`
  ADD PRIMARY KEY (`store_id`);

--
-- Indexes for table `milk_transaction_history`
--
ALTER TABLE `milk_transaction_history`
  ADD PRIMARY KEY (`transaction_history_id`);

--
-- Indexes for table `milk_user`
--
ALTER TABLE `milk_user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `first_names` (`first_name`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `users_phone` (`phone`),
  ADD KEY `users_phone_unique` (`phone`);

--
-- Indexes for table `milk_user_address`
--
ALTER TABLE `milk_user_address`
  ADD PRIMARY KEY (`user_address_id`);

--
-- Indexes for table `milk_wallet`
--
ALTER TABLE `milk_wallet`
  ADD PRIMARY KEY (`wallet_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `milk_account`
--
ALTER TABLE `milk_account`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `milk_app_setting`
--
ALTER TABLE `milk_app_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `milk_banner`
--
ALTER TABLE `milk_banner`
  MODIFY `banner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `milk_category`
--
ALTER TABLE `milk_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `milk_constraint`
--
ALTER TABLE `milk_constraint`
  MODIFY `constraint_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `milk_notification`
--
ALTER TABLE `milk_notification`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `milk_order`
--
ALTER TABLE `milk_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `milk_order_product`
--
ALTER TABLE `milk_order_product`
  MODIFY `order_product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `milk_payment_request`
--
ALTER TABLE `milk_payment_request`
  MODIFY `payment_request_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `milk_product`
--
ALTER TABLE `milk_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `milk_product_timing`
--
ALTER TABLE `milk_product_timing`
  MODIFY `product_timing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `milk_recharge_request`
--
ALTER TABLE `milk_recharge_request`
  MODIFY `recharge_request_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `milk_role`
--
ALTER TABLE `milk_role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `milk_store`
--
ALTER TABLE `milk_store`
  MODIFY `store_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `milk_transaction_history`
--
ALTER TABLE `milk_transaction_history`
  MODIFY `transaction_history_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `milk_user`
--
ALTER TABLE `milk_user`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `milk_user_address`
--
ALTER TABLE `milk_user_address`
  MODIFY `user_address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `milk_wallet`
--
ALTER TABLE `milk_wallet`
  MODIFY `wallet_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
