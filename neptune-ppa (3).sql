-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2017 at 12:50 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `neptune-ppa`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_name` int(10) UNSIGNED NOT NULL,
  `category_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_delete` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `project_name`, `category_name`, `is_active`, `is_delete`, `created_at`, `updated_at`) VALUES
(8, 4, 'MAN', 0, 1, NULL, NULL),
(9, 12, 'Man1', 0, 1, NULL, NULL),
(11, 1, 'NUEROLOGY.', 0, 1, NULL, NULL),
(12, 2, 'KDR1', 0, 1, NULL, NULL),
(13, 2, 'MBA', 0, 1, NULL, NULL),
(22, 48, 'DDD Pacemakers', 1, 0, NULL, NULL),
(23, 48, 'DDD ICD', 1, 0, NULL, NULL),
(24, 48, 'VVI ICD', 1, 0, NULL, NULL),
(25, 48, 'VVI Pacemakers', 1, 0, NULL, NULL),
(26, 48, 'CRT-D', 1, 0, NULL, NULL),
(27, 48, 'CRT-P', 1, 0, NULL, NULL),
(29, 48, 'Leads', 1, 0, NULL, NULL),
(30, 28, 'Stim', 1, 0, NULL, NULL),
(31, 30, 'Hip Components', 1, 0, NULL, NULL),
(32, 31, 'RF Irrigated ', 1, 0, NULL, NULL),
(36, 48, 'Loop Recorder', 1, 0, NULL, NULL),
(37, 29, 'Drug Eluting', 1, 0, NULL, NULL),
(38, 29, 'BMS', 1, 0, NULL, NULL),
(39, 29, 'Wires', 1, 0, NULL, NULL),
(40, 29, 'Balloons', 1, 0, NULL, NULL),
(41, 48, 'CRM Market Share', 1, 0, NULL, NULL),
(44, 34, 'Test', 1, 0, NULL, NULL),
(45, 34, 'Test2', 1, 0, NULL, NULL),
(46, 34, 'Test3', 1, 0, NULL, NULL),
(47, 34, 'Test4', 1, 0, NULL, NULL),
(48, 34, 'Test6', 1, 0, NULL, NULL),
(49, 35, 'Test New Category', 1, 0, NULL, NULL),
(50, 35, 'Test New', 1, 0, NULL, NULL),
(51, 35, 'Test New1', 1, 0, NULL, NULL),
(52, 35, 'Test New2', 1, 0, NULL, NULL),
(53, 35, 'Test New3', 1, 0, NULL, NULL),
(58, 36, 'Test One', 1, 0, NULL, NULL),
(59, 36, 'Test Two', 1, 0, NULL, NULL),
(60, 37, 'cat1', 1, 0, NULL, NULL),
(63, 42, 'Final Test One ', 1, 0, NULL, NULL),
(64, 42, 'Final Test Two ', 1, 0, NULL, NULL),
(66, 45, 'Test Category', 1, 0, NULL, NULL),
(67, 45, 'Test Category1', 1, 0, NULL, NULL),
(68, 46, 'frtyh', 1, 0, NULL, NULL),
(69, 47, 'First Category1', 1, 0, NULL, NULL),
(70, 47, 'First Category2', 1, 0, NULL, NULL),
(71, 47, 'First Category3', 1, 0, NULL, NULL),
(72, 47, 'First Category4', 1, 0, NULL, NULL),
(73, 50, 'New Proj1', 1, 0, NULL, NULL),
(74, 50, 'New Proj2', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `category_sort`
--

CREATE TABLE `category_sort` (
  `id` int(10) UNSIGNED NOT NULL,
  `sort_number` int(11) NOT NULL,
  `client_name` int(10) UNSIGNED NOT NULL,
  `category_name` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category_sort`
--

INSERT INTO `category_sort` (`id`, `sort_number`, `client_name`, `category_name`, `created_at`, `updated_at`) VALUES
(47, 1, 22, 58, '2017-02-06 16:56:42', '2017-02-06 16:56:42'),
(48, 2, 22, 59, '2017-02-06 16:56:42', '2017-02-06 16:56:42'),
(49, 3, 22, 22, '2017-02-06 16:56:42', '2017-02-06 16:56:42'),
(50, 4, 22, 23, '2017-02-06 16:56:42', '2017-02-06 16:56:42'),
(51, 5, 22, 24, '2017-02-06 16:56:42', '2017-02-06 16:56:42'),
(52, 6, 22, 25, '2017-02-06 16:56:42', '2017-02-06 16:56:42'),
(53, 7, 22, 26, '2017-02-06 16:56:42', '2017-02-06 16:56:42'),
(54, 8, 22, 27, '2017-02-06 16:56:42', '2017-02-06 16:56:42'),
(55, 9, 22, 29, '2017-02-06 16:56:42', '2017-02-06 16:56:42'),
(56, 10, 22, 36, '2017-02-06 16:56:42', '2017-02-06 16:56:42'),
(57, 11, 22, 41, '2017-02-06 16:56:42', '2017-02-06 16:56:42'),
(77, 1, 20, 49, '2017-02-06 17:06:07', '2017-02-06 17:06:07'),
(78, 2, 20, 50, '2017-02-06 17:06:07', '2017-02-06 17:06:07'),
(79, 3, 20, 51, '2017-02-06 17:06:07', '2017-02-06 17:06:07'),
(80, 4, 20, 52, '2017-02-06 17:06:07', '2017-02-06 17:06:07'),
(81, 5, 20, 53, '2017-02-06 17:06:07', '2017-02-06 17:06:07'),
(82, 6, 20, 22, '2017-02-06 17:06:07', '2017-02-06 17:06:07'),
(83, 7, 20, 23, '2017-02-06 17:06:07', '2017-02-06 17:06:07'),
(84, 8, 20, 24, '2017-02-06 17:06:07', '2017-02-06 17:06:07'),
(85, 9, 20, 25, '2017-02-06 17:06:07', '2017-02-06 17:06:07'),
(86, 10, 20, 26, '2017-02-06 17:06:07', '2017-02-06 17:06:07'),
(87, 11, 20, 27, '2017-02-06 17:06:07', '2017-02-06 17:06:07'),
(88, 12, 20, 29, '2017-02-06 17:06:07', '2017-02-06 17:06:07'),
(89, 13, 20, 36, '2017-02-06 17:06:07', '2017-02-06 17:06:07'),
(90, 14, 20, 41, '2017-02-06 17:06:07', '2017-02-06 17:06:07'),
(91, 1, 23, 60, '2017-02-06 20:12:53', '2017-02-06 20:12:53'),
(92, 2, 23, 61, '2017-02-06 20:12:53', '2017-02-06 20:12:53'),
(93, 3, 23, 62, '2017-02-06 20:12:53', '2017-02-06 20:12:53'),
(94, 4, 23, 58, '2017-02-06 20:12:53', '2017-02-06 20:12:53'),
(95, 5, 23, 59, '2017-02-06 20:12:53', '2017-02-06 20:12:53'),
(197, 1, 17, 22, '2017-02-07 01:43:41', '2017-02-07 01:43:41'),
(198, 2, 17, 23, '2017-02-07 01:43:41', '2017-02-07 01:43:41'),
(199, 3, 17, 24, '2017-02-07 01:43:42', '2017-02-07 01:43:42'),
(200, 4, 17, 25, '2017-02-07 01:43:42', '2017-02-07 01:43:42'),
(201, 5, 17, 26, '2017-02-07 01:43:42', '2017-02-07 01:43:42'),
(202, 6, 17, 27, '2017-02-07 01:43:42', '2017-02-07 01:43:42'),
(203, 7, 17, 29, '2017-02-07 01:43:42', '2017-02-07 01:43:42'),
(204, 8, 17, 36, '2017-02-07 01:43:42', '2017-02-07 01:43:42'),
(205, 9, 17, 41, '2017-02-07 01:43:42', '2017-02-07 01:43:42'),
(215, 1, 26, 22, '2017-02-07 10:31:49', '2017-02-07 10:31:49'),
(216, 2, 26, 23, '2017-02-07 10:31:49', '2017-02-07 10:31:49'),
(217, 3, 26, 24, '2017-02-07 10:31:49', '2017-02-07 10:31:49'),
(218, 4, 26, 25, '2017-02-07 10:31:49', '2017-02-07 10:31:49'),
(219, 5, 26, 26, '2017-02-07 10:31:49', '2017-02-07 10:31:49'),
(220, 6, 26, 27, '2017-02-07 10:31:49', '2017-02-07 10:31:49'),
(221, 7, 26, 29, '2017-02-07 10:31:49', '2017-02-07 10:31:49'),
(222, 8, 26, 36, '2017-02-07 10:31:49', '2017-02-07 10:31:49'),
(223, 9, 26, 41, '2017-02-07 10:31:49', '2017-02-07 10:31:49'),
(224, 10, 26, 58, '2017-02-07 10:31:49', '2017-02-07 10:31:49'),
(225, 11, 26, 59, '2017-02-07 10:31:49', '2017-02-07 10:31:49'),
(226, 1, 27, 22, '2017-02-07 12:26:37', '2017-02-07 12:26:37'),
(227, 2, 27, 23, '2017-02-07 12:26:37', '2017-02-07 12:26:37'),
(228, 3, 27, 24, '2017-02-07 12:26:37', '2017-02-07 12:26:37'),
(229, 4, 27, 25, '2017-02-07 12:26:37', '2017-02-07 12:26:37'),
(230, 5, 27, 26, '2017-02-07 12:26:37', '2017-02-07 12:26:37'),
(231, 6, 27, 27, '2017-02-07 12:26:37', '2017-02-07 12:26:37'),
(232, 7, 27, 29, '2017-02-07 12:26:37', '2017-02-07 12:26:37'),
(233, 8, 27, 36, '2017-02-07 12:26:37', '2017-02-07 12:26:37'),
(234, 9, 27, 41, '2017-02-07 12:26:37', '2017-02-07 12:26:37'),
(235, 1, 28, 22, '2017-02-07 12:40:28', '2017-02-07 12:40:28'),
(236, 2, 28, 23, '2017-02-07 12:40:28', '2017-02-07 12:40:28'),
(237, 3, 28, 24, '2017-02-07 12:40:28', '2017-02-07 12:40:28'),
(238, 4, 28, 25, '2017-02-07 12:40:28', '2017-02-07 12:40:28'),
(239, 5, 28, 26, '2017-02-07 12:40:28', '2017-02-07 12:40:28'),
(240, 6, 28, 27, '2017-02-07 12:40:28', '2017-02-07 12:40:28'),
(241, 7, 28, 29, '2017-02-07 12:40:28', '2017-02-07 12:40:28'),
(242, 8, 28, 36, '2017-02-07 12:40:28', '2017-02-07 12:40:28'),
(243, 9, 28, 41, '2017-02-07 12:40:28', '2017-02-07 12:40:28'),
(244, 1, 29, 63, '2017-02-07 19:09:40', '2017-02-07 19:09:40'),
(245, 2, 29, 64, '2017-02-07 19:10:15', '2017-02-07 19:10:15'),
(268, 1, 15, 22, '2017-02-20 13:14:46', '2017-02-20 13:14:46'),
(269, 2, 15, 24, '2017-02-20 13:14:46', '2017-02-20 13:14:46'),
(270, 3, 15, 23, '2017-02-20 13:14:46', '2017-02-20 13:14:46'),
(271, 4, 15, 25, '2017-02-20 13:14:46', '2017-02-20 13:14:46'),
(272, 5, 15, 26, '2017-02-20 13:14:46', '2017-02-20 13:14:46'),
(273, 6, 15, 27, '2017-02-20 13:14:46', '2017-02-20 13:14:46'),
(274, 7, 15, 29, '2017-02-20 13:14:46', '2017-02-20 13:14:46'),
(275, 8, 15, 36, '2017-02-20 13:14:46', '2017-02-20 13:14:46'),
(276, 9, 15, 41, '2017-02-20 13:14:46', '2017-02-20 13:14:46'),
(277, 10, 15, 44, '2017-02-20 13:14:46', '2017-02-20 13:14:46'),
(278, 11, 15, 30, '2017-02-20 13:14:46', '2017-02-20 13:14:46'),
(279, 12, 15, 45, '2017-02-20 13:14:46', '2017-02-20 13:14:46'),
(280, 13, 15, 46, '2017-02-20 13:14:46', '2017-02-20 13:14:46'),
(281, 14, 15, 47, '2017-02-20 13:14:46', '2017-02-20 13:14:46'),
(282, 15, 15, 48, '2017-02-20 13:14:46', '2017-02-20 13:14:46'),
(283, 16, 15, 49, '2017-02-20 13:14:46', '2017-02-20 13:14:46'),
(284, 17, 15, 51, '2017-02-20 13:14:46', '2017-02-20 13:14:46'),
(285, 18, 15, 50, '2017-02-20 13:14:46', '2017-02-20 13:14:46'),
(286, 19, 15, 52, '2017-02-20 13:14:46', '2017-02-20 13:14:46'),
(287, 20, 15, 53, '2017-02-20 13:14:46', '2017-02-20 13:14:46'),
(290, 1, 31, 67, '2017-02-25 13:31:50', '2017-02-25 13:31:50'),
(291, 2, 31, 66, '2017-02-25 13:31:50', '2017-02-25 13:31:50'),
(292, 3, 31, 68, '2017-02-25 13:52:40', '2017-02-25 13:52:40'),
(294, 10, 27, 68, '2017-04-26 13:25:06', '2017-04-26 13:25:06'),
(295, 1, 32, 68, '2017-04-26 13:25:06', '2017-04-26 13:25:06'),
(296, 1, 16, 30, '2017-04-26 13:32:35', '2017-04-26 13:32:35'),
(297, 2, 16, 44, '2017-04-26 13:32:35', '2017-04-26 13:32:35'),
(298, 3, 16, 45, '2017-04-26 13:32:35', '2017-04-26 13:32:35'),
(299, 4, 16, 46, '2017-04-26 13:32:35', '2017-04-26 13:32:35'),
(300, 5, 16, 47, '2017-04-26 13:32:35', '2017-04-26 13:32:35'),
(301, 6, 16, 48, '2017-04-26 13:32:35', '2017-04-26 13:32:35'),
(302, 7, 16, 49, '2017-04-26 13:32:35', '2017-04-26 13:32:35'),
(303, 8, 16, 50, '2017-04-26 13:32:35', '2017-04-26 13:32:35'),
(304, 9, 16, 51, '2017-04-26 13:32:35', '2017-04-26 13:32:35'),
(305, 10, 16, 52, '2017-04-26 13:32:35', '2017-04-26 13:32:35'),
(306, 11, 16, 53, '2017-04-26 13:32:36', '2017-04-26 13:32:36'),
(307, 12, 16, 31, '2017-04-26 13:32:36', '2017-04-26 13:32:36'),
(308, 13, 16, 23, '2017-04-26 13:32:36', '2017-04-26 13:32:36'),
(309, 14, 16, 24, '2017-04-26 13:32:36', '2017-04-26 13:32:36'),
(310, 15, 16, 25, '2017-04-26 13:32:36', '2017-04-26 13:32:36'),
(311, 16, 16, 26, '2017-04-26 13:32:36', '2017-04-26 13:32:36'),
(312, 17, 16, 22, '2017-04-26 13:32:36', '2017-04-26 13:32:36'),
(313, 18, 16, 27, '2017-04-26 13:32:36', '2017-04-26 13:32:36'),
(314, 19, 16, 29, '2017-04-26 13:32:36', '2017-04-26 13:32:36'),
(315, 20, 16, 36, '2017-04-26 13:32:36', '2017-04-26 13:32:36'),
(316, 21, 16, 41, '2017-04-26 13:32:36', '2017-04-26 13:32:36'),
(317, 22, 16, 37, '2017-04-26 13:32:36', '2017-04-26 13:32:36'),
(318, 23, 16, 38, '2017-04-26 13:32:36', '2017-04-26 13:32:36'),
(319, 24, 16, 39, '2017-04-26 13:32:36', '2017-04-26 13:32:36'),
(320, 25, 16, 40, '2017-04-26 13:32:36', '2017-04-26 13:32:36'),
(321, 1, 33, 69, '2017-05-10 20:13:10', '2017-05-10 20:13:10'),
(322, 2, 33, 70, '2017-05-10 20:13:53', '2017-05-10 20:13:53'),
(323, 3, 33, 71, '2017-05-10 20:14:09', '2017-05-10 20:14:09'),
(324, 4, 33, 72, '2017-05-10 20:14:21', '2017-05-10 20:14:21'),
(325, 5, 33, 73, '2017-05-15 12:50:54', '2017-05-15 12:50:54'),
(326, 26, 16, 73, '2017-05-15 12:50:54', '2017-05-15 12:50:54'),
(327, 21, 15, 73, '2017-05-15 12:50:54', '2017-05-15 12:50:54'),
(334, 2, 34, 73, '2017-05-15 12:52:34', '2017-05-15 12:52:34'),
(329, 6, 33, 74, '2017-05-15 12:52:02', '2017-05-15 12:52:02'),
(330, 27, 16, 74, '2017-05-15 12:52:02', '2017-05-15 12:52:02'),
(331, 22, 15, 74, '2017-05-15 12:52:02', '2017-05-15 12:52:02'),
(333, 1, 34, 74, '2017-05-15 12:52:34', '2017-05-15 12:52:34');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `item_no` int(11) NOT NULL,
  `client_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `street_address` text COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` int(10) UNSIGNED NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_delete` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `item_no`, `client_name`, `street_address`, `city`, `state`, `is_active`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 25453, 'test client', 'Varchha, Surat', 'Surat', 1, 0, 0, '2017-05-09 20:30:41', '2017-05-09 20:30:41'),
(15, 6698, 'UVMC', '111 Colchester Ave', 'Burlington ', 45, 1, 0, NULL, NULL),
(16, 2587, 'CVPH', '75 Beekman St', 'Plattsburgh', 7, 1, 0, NULL, NULL),
(17, 1043, 'Baylor St. Lukes', '6720 Bertner Ave, Houston', 'Houston', 43, 1, 0, NULL, NULL),
(20, 9716, 'Test New Client', 'Test', 'Test', 14, 1, 0, NULL, NULL),
(22, 4390, 'Test One', 'Test Two', 'Test Three', 2, 1, 0, NULL, NULL),
(23, 5072, 'zsfds', 'ddw', 'sdd', 17, 1, 0, NULL, NULL),
(26, 2539, 'Test New', 'tn', 'CHENNAI', 17, 1, 0, NULL, NULL),
(27, 9360, 'Net Test', 'gfdggd', 'sdf', 16, 1, 0, NULL, NULL),
(29, 4422, 'sfsf', 'werw', 'wrwr d', 18, 1, 0, NULL, NULL),
(31, 6638, 'Test Client', 'Test Address', 'Test City', 16, 1, 0, NULL, NULL),
(32, 6498, 'ryyery', 'trytry', 'rtyty', 16, 1, 0, NULL, NULL),
(33, 4570, 'First Client', 'New Street', 'Chicago', 16, 1, 0, NULL, NULL),
(34, 2757, 'NEWS READER', 'New Street', 'Chicago', 16, 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `client_custom_field`
--

CREATE TABLE `client_custom_field` (
  `id` int(10) UNSIGNED NOT NULL,
  `device_id` int(10) UNSIGNED NOT NULL,
  `client_name` int(10) UNSIGNED NOT NULL,
  `field_check` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `c_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `client_custom_field`
--

INSERT INTO `client_custom_field` (`id`, `device_id`, `client_name`, `field_check`, `c_id`, `created_at`, `updated_at`) VALUES
(37, 45, 16, 'True', 21, NULL, NULL),
(38, 45, 16, 'True', 162, NULL, NULL),
(39, 45, 16, 'False', 163, NULL, NULL),
(40, 45, 16, 'True', 164, NULL, NULL),
(41, 45, 16, 'False', 165, NULL, NULL),
(42, 45, 16, 'False', 166, NULL, NULL),
(43, 45, 16, 'True', 167, NULL, NULL),
(44, 45, 16, 'False', 168, NULL, NULL),
(45, 45, 16, 'True', 169, NULL, NULL),
(58, 46, 16, 'False', 23, NULL, NULL),
(59, 46, 16, 'True', 172, NULL, NULL),
(62, 46, 15, 'True', 23, NULL, NULL),
(63, 46, 15, '', 172, NULL, NULL),
(82, 45, 15, 'True', 21, NULL, NULL),
(83, 45, 15, 'False', 162, NULL, NULL),
(84, 45, 15, 'False', 163, NULL, NULL),
(85, 45, 15, 'False', 164, NULL, NULL),
(86, 45, 15, 'True', 165, NULL, NULL),
(87, 45, 15, 'True', 166, NULL, NULL),
(88, 45, 15, 'False', 167, NULL, NULL),
(89, 45, 15, 'False', 168, NULL, NULL),
(90, 45, 15, 'True', 169, NULL, NULL),
(91, 139, 15, 'False', 160, NULL, NULL),
(92, 139, 15, 'False', 161, NULL, NULL),
(93, 139, 15, 'False', 173, NULL, NULL),
(96, 48, 15, 'False', 27, NULL, NULL),
(106, 103, 16, 'False', 73, NULL, NULL),
(107, 103, 16, 'False', 74, NULL, NULL),
(108, 102, 15, 'False', 71, NULL, NULL),
(109, 102, 15, 'False', 72, NULL, NULL),
(110, 102, 16, 'False', 71, NULL, NULL),
(111, 102, 16, 'False', 72, NULL, NULL),
(275, 111, 15, 'True', 207, NULL, NULL),
(117, 111, 16, 'False', 106, NULL, NULL),
(118, 109, 16, 'True', 100, NULL, NULL),
(119, 109, 16, 'False', 101, NULL, NULL),
(122, 91, 16, 'False', 20, NULL, NULL),
(249, 91, 15, 'True', 20, NULL, NULL),
(124, 90, 16, 'True', 14, NULL, NULL),
(273, 90, 15, 'True', 208, NULL, NULL),
(126, 108, 15, 'True', 98, NULL, NULL),
(127, 108, 15, 'False', 99, NULL, NULL),
(128, 108, 16, 'False', 98, NULL, NULL),
(129, 108, 16, 'True', 99, NULL, NULL),
(130, 99, 15, 'True', 53, NULL, NULL),
(131, 99, 15, 'False', 54, NULL, NULL),
(132, 99, 16, 'False', 53, NULL, NULL),
(133, 99, 16, 'False', 54, NULL, NULL),
(134, 93, 15, 'True', 28, NULL, NULL),
(136, 92, 15, 'False', 26, NULL, NULL),
(137, 92, 15, 'False', 170, NULL, NULL),
(138, 92, 15, 'True', 171, NULL, NULL),
(142, 50, 15, 'True', 25, NULL, NULL),
(143, 50, 16, 'True', 25, NULL, NULL),
(147, 139, 20, 'True', 160, NULL, NULL),
(148, 139, 20, 'False', 161, NULL, NULL),
(149, 139, 20, 'False', 173, NULL, NULL),
(150, 111, 20, 'False', 106, NULL, NULL),
(151, 108, 20, 'False', 98, NULL, NULL),
(152, 108, 20, 'False', 99, NULL, NULL),
(153, 139, 23, 'True', 160, NULL, NULL),
(154, 139, 23, 'False', 161, NULL, NULL),
(155, 139, 23, 'False', 173, NULL, NULL),
(156, 111, 26, 'False', 106, NULL, NULL),
(157, 103, 26, 'False', 73, NULL, NULL),
(158, 103, 26, 'False', 74, NULL, NULL),
(159, 109, 26, 'False', 100, NULL, NULL),
(160, 109, 26, 'False', 101, NULL, NULL),
(161, 139, 26, 'False', 160, NULL, NULL),
(162, 139, 26, 'False', 161, NULL, NULL),
(163, 139, 26, 'False', 173, NULL, NULL),
(164, 111, 27, 'False', 106, NULL, NULL),
(165, 109, 27, 'False', 100, NULL, NULL),
(166, 109, 27, 'False', 101, NULL, NULL),
(167, 103, 27, 'False', 73, NULL, NULL),
(168, 103, 27, 'False', 74, NULL, NULL),
(169, 91, 27, 'False', 20, NULL, NULL),
(170, 111, 28, 'False', 106, NULL, NULL),
(171, 109, 28, 'False', 100, NULL, NULL),
(172, 109, 28, 'False', 101, NULL, NULL),
(173, 103, 28, 'False', 73, NULL, NULL),
(174, 103, 28, 'False', 74, NULL, NULL),
(175, 91, 28, 'False', 20, NULL, NULL),
(176, 109, 15, 'True', 100, NULL, NULL),
(177, 109, 15, 'False', 101, NULL, NULL),
(178, 92, 16, 'False', 26, NULL, NULL),
(179, 92, 16, 'True', 170, NULL, NULL),
(180, 92, 16, 'False', 171, NULL, NULL),
(189, 93, 16, 'True', 28, NULL, NULL),
(190, 93, 16, 'True', 174, NULL, NULL),
(191, 93, 16, 'True', 175, NULL, NULL),
(192, 93, 16, 'True', 176, NULL, NULL),
(193, 93, 16, 'True', 177, NULL, NULL),
(194, 93, 16, 'True', 178, NULL, NULL),
(195, 93, 16, 'True', 179, NULL, NULL),
(196, 93, 16, 'True', 180, NULL, NULL),
(197, 93, 16, 'True', 181, NULL, NULL),
(198, 93, 16, 'True', 182, NULL, NULL),
(199, 93, 16, 'True', 183, NULL, NULL),
(200, 93, 16, 'True', 184, NULL, NULL),
(203, 103, 15, 'True', 73, NULL, NULL),
(204, 103, 15, 'True', 74, NULL, NULL),
(205, 146, 31, '', 185, NULL, NULL),
(206, 146, 31, 'True', 186, NULL, NULL),
(207, 146, 31, 'True', 187, NULL, NULL),
(208, 146, 31, 'True', 188, NULL, NULL),
(209, 146, 31, 'True', 189, NULL, NULL),
(210, 146, 31, 'True', 190, NULL, NULL),
(211, 146, 31, 'True', 191, NULL, NULL),
(212, 146, 31, 'True', 192, NULL, NULL),
(213, 146, 31, 'True', 193, NULL, NULL),
(214, 146, 31, 'True', 194, NULL, NULL),
(215, 145, 31, 'True', 195, NULL, NULL),
(216, 145, 31, 'True', 196, NULL, NULL),
(217, 145, 31, 'True', 197, NULL, NULL),
(218, 145, 31, 'True', 198, NULL, NULL),
(219, 145, 31, 'True', 199, NULL, NULL),
(220, 145, 31, 'True', 200, NULL, NULL),
(221, 145, 31, 'True', 201, NULL, NULL),
(222, 145, 31, 'True', 202, NULL, NULL),
(223, 145, 31, 'True', 203, NULL, NULL),
(224, 145, 31, 'True', 204, NULL, NULL),
(236, 44, 16, 'False', 153, NULL, NULL),
(226, 39, 17, 'False', 15, NULL, NULL),
(235, 44, 16, 'False', 6, NULL, NULL),
(228, 40, 16, 'False', 13, NULL, NULL),
(250, 40, 15, 'False', 13, NULL, NULL),
(234, 39, 16, 'False', 15, NULL, NULL),
(232, 39, 15, 'False', 15, NULL, NULL),
(237, 44, 15, 'False', 6, NULL, NULL),
(238, 44, 15, 'False', 153, NULL, NULL),
(239, 44, 17, 'False', 6, NULL, NULL),
(240, 44, 17, 'False', 153, NULL, NULL),
(248, 91, 17, 'False', 20, NULL, NULL),
(254, 156, 15, 'True', 205, NULL, NULL),
(255, 156, 15, 'True', 206, NULL, NULL),
(274, 111, 15, 'True', 106, NULL, NULL),
(272, 90, 15, 'True', 14, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `client_price`
--

CREATE TABLE `client_price` (
  `id` int(10) UNSIGNED NOT NULL,
  `device_id` int(10) UNSIGNED NOT NULL,
  `client_name` int(10) UNSIGNED NOT NULL,
  `unit_cost` double(8,2) NOT NULL,
  `unit_cost_check` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bulk_unit_cost` double(8,2) NOT NULL,
  `bulk_unit_cost_check` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bulk` double(8,2) NOT NULL,
  `bulk_check` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cco_discount` double(8,2) NOT NULL,
  `cco` double(8,2) NOT NULL,
  `cco_check` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cco_discount_check` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `unit_rep_cost` double(8,2) NOT NULL,
  `unit_rep_cost_check` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `unit_repless_discount` double(8,2) NOT NULL,
  `unit_repless_discount_check` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `system_cost` double(8,2) NOT NULL,
  `system_bulk` double(8,2) NOT NULL,
  `system_bulk_check` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `system_cost_check` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bulk_system_cost` double(8,2) NOT NULL,
  `bulk_system_cost_check` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `system_repless_cost` double(8,2) NOT NULL,
  `system_repless_cost_check` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `system_repless_discount` double(8,2) NOT NULL,
  `system_repless_discount_check` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reimbursement` text COLLATE utf8_unicode_ci NOT NULL,
  `reimbursement_check` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order_email` int(10) UNSIGNED NOT NULL,
  `is_delete` int(11) NOT NULL,
  `is_created` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_updated` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `unit_cost_delta_check` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `cco_delta_check` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `cco_discount_delta_check` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `unit_repless_delta_check` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `unit_repless_discount_delta_check` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `system_cost_delta_check` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `system_repless_delta_check` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `system_repless_discount_delta_check` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `reimbursement_delta_check` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `client_price`
--

INSERT INTO `client_price` (`id`, `device_id`, `client_name`, `unit_cost`, `unit_cost_check`, `bulk_unit_cost`, `bulk_unit_cost_check`, `bulk`, `bulk_check`, `cco_discount`, `cco`, `cco_check`, `cco_discount_check`, `unit_rep_cost`, `unit_rep_cost_check`, `unit_repless_discount`, `unit_repless_discount_check`, `system_cost`, `system_bulk`, `system_bulk_check`, `system_cost_check`, `bulk_system_cost`, `bulk_system_cost_check`, `system_repless_cost`, `system_repless_cost_check`, `system_repless_discount`, `system_repless_discount_check`, `reimbursement`, `reimbursement_check`, `order_email`, `is_delete`, `is_created`, `is_updated`, `created_at`, `updated_at`, `unit_cost_delta_check`, `cco_delta_check`, `cco_discount_delta_check`, `unit_repless_delta_check`, `unit_repless_discount_delta_check`, `system_cost_delta_check`, `system_repless_delta_check`, `system_repless_discount_delta_check`, `reimbursement_delta_check`) VALUES
(1, 4, 2, 100.00, 'True', 200.00, 'False', 5.00, 'False', 3.00, 0.00, '', 'False', 50.00, 'False', 12.00, 'False', 150.00, 0.00, '', '', 2.00, 'False', 230.00, 'False', 2.00, 'False', '1200', 'False', 44, 1, '', '', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(2, 5, 2, 1200.00, 'True', 12.00, 'False', 5.00, 'False', 3.00, 0.00, '', 'False', 1200.00, 'False', 3.00, 'False', 120.00, 0.00, '', '', 4.00, 'False', 150.00, 'False', 2.00, 'False', '1500', 'False', 44, 0, '', '', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(3, 6, 2, 8000.00, 'True', 12.00, 'True', 5.00, 'True', 12.00, 0.00, '', 'True', 150.00, 'True', 5.00, 'False', 9500.00, 0.00, '', '', 5.00, 'True', 120.00, 'True', 5.00, 'False', '1533', 'True', 44, 0, '', '09/12/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(4, 6, 1, 7500.00, 'True', 5.00, 'True', 5.00, 'True', 6.00, 0.00, '', 'True', 200.00, 'True', 4.00, 'False', 9500.00, 0.00, '', '', 5.00, 'True', 400.00, 'False', 5.00, 'True', '575', 'True', 46, 0, '', '09/12/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(5, 3, 1, 7800.00, 'True', 5.00, 'True', 5.00, 'True', 5.00, 0.00, '', 'True', 245.00, 'False', 5.00, 'True', 8880.00, 0.00, '', '', 5.00, 'True', 305.00, 'True', 5.00, 'False', '542', 'True', 46, 0, '', '09/12/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(6, 3, 2, 7900.00, 'True', 5.00, 'True', 5.00, 'True', 5.00, 0.00, '', 'True', 548.00, 'True', 8.00, 'False', 9100.00, 0.00, '', '', 5.00, 'True', 280.00, 'True', 5.00, 'False', '452', 'True', 52, 0, '', '09/12/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(7, 4, 1, 4521.00, 'True', 5.00, 'True', 2.00, 'True', 4.00, 0.00, '', 'True', 160.00, 'True', 4.00, 'False', 7879.00, 0.00, '', '', 5.00, 'True', 435.00, 'False', 5.00, 'True', '220', 'True', 46, 0, '', '09/12/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(8, 1, 1, 4564.00, 'True', 4.00, 'True', 4.00, 'True', 4.00, 0.00, '', 'True', 214.00, 'True', 4.00, 'False', 6457.00, 0.00, '', '', 4.00, 'True', 124.00, 'True', 4.00, 'False', '214', 'False', 46, 0, '', '', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(9, 1, 2, 5786.00, 'True', 5.00, 'True', 4.00, 'True', 5.00, 0.00, '', 'True', 214.00, 'True', 4.00, 'False', 7854.00, 0.00, '', '', 5.00, 'False', 214.00, 'True', 5.00, 'False', '421', 'False', 52, 0, '', '', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(10, 1, 3, 5478.00, 'True', 5.00, 'True', 8.00, 'True', 8.00, 0.00, '', 'True', 280.00, 'True', 4.00, 'False', 6456.00, 0.00, '', '', 5.00, 'True', 180.00, 'False', 4.00, 'True', '650', 'True', 49, 0, '', '09/12/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(11, 7, 3, 4525.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, '', 'False', 0.00, 'False', 0.00, 'False', 6452.00, 0.00, '', '', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 49, 0, '', '', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(12, 7, 2, 9546.00, 'True', 5.00, 'True', 6.00, 'True', 4.00, 0.00, '', 'True', 203.00, 'True', 4.00, 'False', 12345.00, 0.00, '', '', 5.00, 'True', 200.00, 'True', 4.00, 'False', '250', 'True', 52, 0, '', '09/07/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(13, 12, 1, 6544.00, 'True', 5.00, 'False', 0.00, 'False', 0.00, 0.00, '', 'False', 0.00, 'False', 0.00, 'False', 2651.00, 0.00, '', '', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 46, 0, '', '', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(14, 12, 2, 5496.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, '', 'False', 0.00, 'False', 0.00, 'False', 7856.00, 0.00, '', '', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 47, 1, '', '', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(15, 12, 2, 5496.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, '', 'False', 0.00, 'False', 0.00, 'False', 7856.00, 0.00, '', '', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 47, 0, '', '', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(16, 12, 4, 6541.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, '', 'False', 0.00, 'False', 0.00, 'False', 7896.00, 0.00, '', '', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 38, 0, '', '', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(17, 12, 3, 2131.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, '', 'False', 0.00, 'False', 0.00, 'False', 2131.00, 0.00, '', '', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 49, 0, '', '', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(18, 13, 5, 8000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, '', 'False', 0.00, 'False', 0.00, 'False', 9500.00, 0.00, '', '', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 60, 0, '', '', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(19, 14, 5, 5000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, '', 'False', 0.00, 'False', 0.00, 'False', 6000.00, 0.00, '', '', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 60, 0, '', '', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(20, 22, 1, 6800.00, 'True', 5.00, 'False', 5.00, 'False', 5.00, 0.00, '', 'False', 200.00, 'False', 4.00, 'False', 8900.00, 0.00, '', '', 5.00, 'False', 200.00, 'False', 4.00, 'False', '542', 'False', 46, 0, '', '', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(21, 23, 1, 4850.00, 'False', 7.00, 'False', 4.00, 'False', 12.00, 0.00, '', 'False', 124.00, 'False', 7.00, 'False', 6600.00, 0.00, '', 'False', 10.00, 'False', 200.00, 'False', 0.00, 'False', '780', 'False', 46, 0, '', '09/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(22, 10, 2, 4550.00, 'False', 10.00, 'True', 7.00, 'True', 2.00, 0.00, '', 'True', 200.00, 'True', 0.00, 'False', 6500.00, 0.00, '', 'False', 10.00, 'True', 250.00, 'True', 0.00, 'False', '750', 'True', 52, 0, '', '09/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(23, 10, 1, 5000.00, 'True', 10.00, 'False', 10.00, 'True', 2.00, 0.00, '', 'True', 200.00, 'True', 20.00, 'False', 6600.00, 0.00, '', 'True', 10.00, 'True', 250.00, 'False', 3.00, 'True', '750', 'True', 46, 0, '', '09/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(24, 10, 3, 4550.00, 'True', 10.00, 'False', 5.00, 'False', 2.00, 0.00, '', 'False', 200.00, 'False', 0.00, 'False', 6550.00, 0.00, '', '', 10.00, 'False', 250.00, 'False', 0.00, 'False', '750', 'False', 49, 0, '', '', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(25, 9, 1, 4800.00, 'True', 10.00, 'True', 5.00, 'False', 2.00, 0.00, '', 'False', 200.00, 'False', 0.00, 'False', 6900.00, 0.00, '', '', 10.00, 'False', 250.00, 'False', 0.00, 'False', '750', 'False', 46, 0, '', '09/12/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(26, 9, 2, 4800.00, 'True', 10.00, 'False', 5.00, 'False', 2.00, 0.00, '', 'False', 200.00, 'False', 0.00, 'False', 6900.00, 0.00, '', '', 10.00, 'False', 250.00, 'False', 0.00, 'False', '750', 'False', 52, 0, '', '', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(27, 9, 3, 4800.00, 'True', 10.00, 'False', 5.00, 'False', 2.00, 0.00, '', 'False', 200.00, 'False', 0.00, 'False', 6900.00, 0.00, '', '', 10.00, 'False', 250.00, 'False', 0.00, 'False', '750', 'False', 49, 0, '', '', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(28, 7, 1, 4800.00, 'True', 10.00, 'True', 5.00, 'False', 2.00, 0.00, '', 'True', 200.00, 'True', 0.00, 'False', 6900.00, 0.00, '', 'True', 10.00, 'True', 250.00, 'False', 2.00, 'True', '750', 'True', 46, 0, '', '09/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(29, 17, 1, 4800.00, 'False', 10.00, 'False', 5.00, 'False', 2.00, 0.00, '', 'False', 200.00, 'False', 0.00, 'False', 6900.00, 0.00, '', 'False', 10.00, 'False', 250.00, 'True', 0.00, 'False', '750', 'False', 46, 0, '', '09/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(30, 17, 2, 4850.00, 'True', 10.00, 'True', 15.00, 'True', 2.00, 0.00, '', 'True', 200.00, 'False', 0.00, 'False', 6950.00, 0.00, '', '', 10.00, 'True', 250.00, 'False', 0.00, 'False', '750', 'False', 52, 0, '', '09/12/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(31, 17, 3, 4550.00, 'True', 10.00, 'False', 5.00, 'False', 2.00, 0.00, '', 'False', 200.00, 'False', 0.00, 'False', 6900.00, 0.00, '', '', 10.00, 'False', 250.00, 'False', 0.00, 'False', '780', 'False', 49, 0, '', '', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(32, 18, 1, 4650.00, 'False', 8.00, 'False', 19.00, 'False', 3.00, 0.00, '', 'False', 150.00, 'False', 2.00, 'False', 65000.00, 0.00, '', 'False', 8.00, 'False', 260.00, 'False', 5.00, 'False', '790', 'False', 46, 0, '', '09/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(33, 18, 2, 4600.00, 'True', 10.00, 'True', 4.00, 'True', 3.00, 0.00, '', 'True', 200.00, 'True', 0.00, 'False', 6600.00, 0.00, '', '', 8.00, 'True', 260.00, 'True', 0.00, 'False', '780', 'False', 52, 0, '', '09/12/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(34, 18, 3, 4850.00, 'True', 7.00, 'False', 5.00, 'False', 3.00, 0.00, '', 'False', 175.00, 'False', 0.00, 'False', 6950.00, 0.00, '', '', 8.00, 'True', 280.00, 'True', 0.00, 'False', '760', 'False', 49, 1, '', '', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(35, 23, 2, 4850.00, 'True', 10.00, 'False', 5.00, 'True', 2.00, 0.00, '', 'False', 175.00, 'False', 0.00, 'False', 6550.00, 0.00, '', '', 8.00, 'True', 280.00, 'True', 0.00, 'False', '790', 'False', 52, 0, '', '', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(36, 23, 3, 4600.00, 'True', 7.00, 'True', 4.00, 'True', 2.00, 0.00, '', 'True', 124.00, 'False', 0.00, 'False', 6600.00, 0.00, '', '', 8.00, 'False', 260.00, 'True', 0.00, 'False', '750', 'False', 49, 0, '', '', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(37, 23, 3, 4600.00, 'True', 7.00, 'False', 4.00, 'False', 2.00, 0.00, '', 'False', 124.00, 'False', 0.00, 'False', 6600.00, 0.00, '', '', 8.00, 'False', 260.00, 'False', 0.00, 'False', '750', 'False', 49, 1, '', '', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(38, 18, 3, 4850.00, 'True', 7.00, 'True', 15.00, 'True', 3.00, 0.00, '', 'True', 175.00, 'False', 0.00, 'False', 6950.00, 0.00, '', '', 8.00, 'True', 280.00, 'True', 0.00, 'False', '760', 'False', 49, 0, '', '09/12/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(39, 4, 4, 5000.00, 'True', 3.00, 'True', 5.00, 'False', 3.00, 0.00, '', 'True', 200.00, 'False', 5.00, 'True', 8000.00, 0.00, '', '', 4.00, 'True', 250.00, 'False', 5.00, 'True', '750', 'True', 38, 0, '', '09/12/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(40, 2, 1, 6000.00, 'True', 5.00, 'True', 5.00, 'True', 3.00, 0.00, '', 'True', 200.00, 'False', 3.00, 'True', 7800.00, 0.00, '', '', 6.00, 'True', 250.00, 'True', 4.00, 'False', '650', 'True', 46, 0, '', '09/12/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(41, 2, 2, 6000.00, 'True', 8.00, 'True', 5.00, 'True', 4.00, 0.00, '', 'True', 200.00, 'False', 4.00, 'True', 8000.00, 0.00, '', '', 5.00, 'True', 280.00, 'False', 3.00, 'True', '750', 'True', 52, 0, '', '09/12/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(42, 2, 3, 6000.00, 'True', 5.00, 'False', 8.00, 'False', 4.00, 0.00, '', 'False', 200.00, 'False', 4.00, 'False', 8000.00, 0.00, '', '', 4.00, 'False', 8.00, 'False', 2.00, 'False', '850', 'False', 49, 0, '', '09/12/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(43, 3, 3, 7500.00, 'True', 9.00, 'True', 6.00, 'True', 5.00, 0.00, '', 'True', 220.00, 'True', 4.00, 'False', 9800.00, 0.00, '', '', 5.00, 'True', 260.00, 'False', 3.00, 'True', '550', 'True', 49, 0, '', '09/12/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(44, 3, 4, 7800.00, 'True', 7.00, 'True', 4.00, 'True', 7.00, 0.00, '', 'True', 280.00, 'True', 3.00, 'False', 10000.00, 0.00, '', '', 10.00, 'True', 280.00, 'False', 4.00, 'True', '850', 'True', 38, 0, '', '09/12/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(45, 4, 10, 8000.00, 'True', 9.00, 'True', 6.00, 'True', 5.00, 0.00, '', 'True', 280.00, 'True', 4.00, 'False', 11000.00, 0.00, '', '', 10.00, 'True', 250.00, 'True', 3.00, 'False', '750', 'True', 70, 0, '', '09/12/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(46, 6, 3, 7500.00, 'True', 9.00, 'True', 6.00, 'True', 3.00, 0.00, '', 'True', 280.00, 'True', 4.00, 'False', 10000.00, 0.00, '', '', 10.00, 'True', 280.00, 'False', 4.00, 'True', '850', 'True', 49, 0, '', '09/12/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(47, 6, 4, 8000.00, 'True', 5.00, 'True', 8.00, 'True', 5.00, 0.00, '', 'True', 220.00, 'True', 4.00, 'False', 9800.00, 0.00, '', '', 6.00, 'True', 280.00, 'False', 3.00, 'True', '650', 'True', 38, 0, '', '09/12/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(48, 18, 3, 1000.00, 'True', 0.00, 'True', 0.00, 'False', 0.00, 0.00, '', 'False', 0.00, 'False', 0.00, 'False', 1100.00, 0.00, '', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 49, 0, '', '09/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(49, 34, 1, 7500.00, 'True', 9.00, 'True', 4.00, 'True', 3.00, 0.00, '', 'True', 220.00, 'True', 3.00, 'False', 9800.00, 0.00, '', 'True', 10.00, 'True', 8.00, 'False', 4.00, 'True', '750', 'True', 46, 0, '', '09/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(50, 34, 2, 8000.00, 'True', 7.00, 'True', 8.00, 'True', 4.00, 0.00, '', 'True', 280.00, 'False', 3.00, 'True', 10000.00, 0.00, '', 'True', 5.00, 'True', 250.00, 'False', 2.00, 'True', '750', 'True', 44, 0, '', '09/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(51, 34, 5, 7800.00, 'True', 8.00, 'True', 8.00, 'True', 7.00, 0.00, '', 'True', 280.00, 'True', 3.00, 'False', 9800.00, 0.00, '', 'True', 10.00, 'True', 260.00, 'True', 3.00, 'False', '850', 'True', 60, 0, '', '09/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(52, 34, 10, 8500.00, 'False', 9.00, 'False', 6.00, 'False', 7.00, 0.00, '', 'False', 280.00, 'False', 0.00, 'False', 11000.00, 0.00, '', 'False', 10.00, 'False', 280.00, 'False', 3.00, 'False', '750', 'False', 70, 0, '', '09/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(53, 33, 1, 7500.00, 'True', 5.00, 'True', 5.00, 'True', 7.00, 0.00, '', 'True', 280.00, 'True', 3.00, 'False', 10000.00, 0.00, '', 'True', 10.00, 'True', 250.00, 'False', 4.00, 'True', '850', 'True', 46, 0, '', '09/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(54, 33, 2, 8000.00, 'True', 9.00, 'True', 8.00, 'True', 7.00, 0.00, '', 'True', 280.00, 'True', 4.00, 'False', 10000.00, 0.00, '', 'True', 10.00, 'True', 260.00, 'True', 4.00, 'False', '850', 'True', 52, 0, '', '09/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(55, 33, 5, 8500.00, 'True', 5.00, 'True', 6.00, 'True', 7.00, 0.00, '', 'True', 220.00, 'False', 2.00, 'True', 9800.00, 0.00, '', 'True', 5.00, 'True', 280.00, 'True', 3.00, 'False', '550', 'True', 60, 0, '', '09/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(56, 33, 10, 7500.00, 'True', 9.00, 'True', 5.00, 'True', 4.00, 0.00, '', 'True', 280.00, 'True', 4.00, 'False', 9800.00, 0.00, '', 'True', 10.00, 'True', 250.00, 'False', 4.00, 'True', '850', 'True', 70, 0, '', '09/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(57, 32, 1, 8500.00, 'False', 5.00, 'True', 8.00, 'True', 4.00, 0.00, '', 'True', 220.00, 'True', 3.00, 'False', 10000.00, 0.00, '', 'False', 10.00, 'True', 250.00, 'True', 3.00, 'False', '850', 'True', 46, 0, '', '09/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(58, 32, 2, 6000.00, 'False', 9.00, 'True', 6.00, 'True', 4.00, 0.00, '', 'True', 200.00, 'False', 4.00, 'True', 8000.00, 0.00, '', 'False', 5.00, 'True', 280.00, 'False', 4.00, 'True', '650', 'True', 52, 0, '', '09/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(59, 32, 5, 8500.00, 'False', 8.00, 'True', 6.00, 'True', 7.00, 0.00, '', 'True', 280.00, 'True', 4.00, 'False', 9800.00, 0.00, '', 'False', 5.00, 'True', 280.00, 'True', 4.00, 'False', '750', 'True', 60, 0, '', '09/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(60, 32, 10, 8000.00, 'False', 8.00, 'True', 6.00, 'True', 7.00, 0.00, '', 'True', 220.00, 'True', 3.00, 'False', 10000.00, 0.00, '', 'False', 5.00, 'True', 250.00, 'False', 4.00, 'True', '850', 'True', 70, 0, '', '09/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(61, 31, 1, 7800.00, 'False', 5.00, 'True', 8.00, 'True', 4.00, 0.00, '', 'True', 220.00, 'True', 3.00, 'False', 9800.00, 0.00, '', 'False', 10.00, 'True', 280.00, 'False', 3.00, 'True', '650', 'True', 46, 0, '', '09/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(62, 31, 2, 7900.00, 'False', 9.00, 'True', 6.00, 'True', 7.00, 0.00, '', 'True', 280.00, 'True', 4.00, 'False', 9900.00, 0.00, '', 'False', 10.00, 'True', 250.00, 'True', 3.00, 'False', '850', 'True', 52, 0, '', '09/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(63, 31, 5, 7800.00, 'False', 8.00, 'True', 5.00, 'True', 4.00, 0.00, '', 'True', 300.00, 'True', 4.00, 'False', 9000.00, 0.00, '', 'False', 9.00, 'True', 350.00, 'False', 4.00, 'True', '950', 'True', 60, 0, '', '09/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(64, 31, 10, 8000.00, 'False', 7.00, 'False', 8.00, 'False', 5.00, 0.00, '', 'False', 320.00, 'False', 5.00, 'False', 9200.00, 0.00, '', 'False', 9.00, 'False', 350.00, 'False', 4.00, 'False', '950', 'False', 70, 0, '', '09/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(65, 29, 1, 8000.00, 'False', 8.00, 'True', 8.00, 'True', 5.00, 0.00, '', 'True', 300.00, 'True', 5.00, 'False', 9200.00, 0.00, '', 'False', 8.00, 'True', 350.00, 'True', 3.00, 'False', '850', 'True', 46, 0, '', '09/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(66, 29, 2, 7900.00, 'False', 6.00, 'True', 7.00, 'True', 6.00, 0.00, '', 'True', 340.00, 'True', 6.00, 'False', 9100.00, 0.00, '', 'False', 7.00, 'True', 380.00, 'True', 6.00, 'False', '750', 'True', 44, 0, '', '09/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(67, 29, 3, 7800.00, 'False', 7.00, 'True', 5.00, 'True', 6.00, 0.00, '', 'True', 320.00, 'True', 5.00, 'False', 9200.00, 0.00, '', 'False', 8.00, 'True', 380.00, 'True', 6.00, 'False', '850', 'True', 49, 0, '', '09/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(68, 44, 15, 4050.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'True', 'False', 0.00, 'True', 0.00, 'False', 4490.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'True', 0.00, 'False', '0', 'True', 92, 0, '', '2017-06-01 07:19:19', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(69, 43, 15, 3020.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 3420.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(70, 42, 15, 3150.00, 'True', 10.00, 'True', 0.00, 'False', 10.00, 0.00, 'False', 'False', 250.00, 'True', 0.00, 'False', 3410.00, 0.00, 'False', 'True', 10.00, 'True', 250.00, 'True', 0.00, 'False', '', 'False', 92, 0, '', '11/29/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(71, 41, 15, 3300.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 500.00, 'True', 'False', 0.00, 'False', 0.00, 'False', 3740.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(72, 40, 15, 1850.00, 'True', 10.00, 'True', 17.00, 'True', 10.00, 0.00, 'False', 'True', 250.00, 'True', 0.00, 'False', 2110.00, 10.00, 'True', 'True', 10.00, 'True', 250.00, 'True', 10.00, 'False', '0', 'True', 92, 0, '', '2017-06-01 10:19:45', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(73, 39, 15, 1977.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 2377.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '2017-05-11 15:00:25', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(74, 45, 15, 2136.00, 'True', 0.00, 'False', 0.00, 'False', 5.00, 20.00, 'False', 'False', 100.00, 'True', 0.00, 'False', 2936.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '01/05/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(75, 46, 15, 2250.00, 'True', 10.00, 'True', 4.00, 'True', 10.00, 20.00, 'False', 'True', 250.00, 'False', 0.00, 'False', 2770.00, 7.00, 'True', 'True', 10.00, 'True', 250.00, 'True', 0.00, 'False', '', 'False', 92, 0, '', '01/05/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(76, 47, 15, 4150.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, '', 'False', 4150.00, 'True', 0.00, 'False', 5030.00, 0.00, '', 'True', 0.00, 'False', 5030.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '09/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(77, 48, 15, 3600.00, 'True', 10.00, 'True', 15.00, 'True', 10.00, 0.00, 'False', 'False', 250.00, 'True', 0.00, 'False', 4120.00, 14.00, 'True', 'True', 10.00, 'True', 250.00, 'True', 0.00, 'False', '', 'False', 92, 0, '', '02/04/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(78, 49, 15, 3420.00, 'True', 18.00, 'True', 0.00, 'True', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 4220.00, 0.00, 'True', 'True', 18.00, 'True', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '11/29/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(79, 50, 15, 4275.00, 'True', 10.00, 'True', 1.00, 'True', 0.00, 0.00, 'False', 'False', 0.00, 'True', 0.00, 'False', 5075.00, 1.00, 'True', 'True', 10.00, 'True', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '02/06/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(80, 51, 15, 4900.00, 'True', 0.00, 'False', 0.00, 'True', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 5780.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '02/06/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(81, 52, 15, 10000.00, 'True', 10.00, 'True', 4.00, 'True', 12.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 12340.00, 0.00, 'False', 'False', 10.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '12/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(82, 53, 15, 11250.00, 'True', 10.00, 'True', 0.00, 'False', 0.00, 500.00, 'True', 'False', 0.00, 'False', 0.00, 'False', 14650.00, 0.00, 'False', 'False', 10.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(83, 54, 15, 10000.00, 'True', 10.00, 'True', 2.00, 'True', 0.00, 1000.00, 'True', 'False', 0.00, 'False', 0.00, 'False', 13100.00, 0.00, 'False', 'False', 10.00, 'True', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '12/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(84, 55, 15, 12300.00, 'False', 10.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 15630.00, 0.00, 'False', 'True', 10.00, 'True', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '11/29/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(85, 56, 15, 10500.00, 'False', 10.00, 'False', 0.00, 'False', 12.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 12840.00, 2.00, 'True', 'True', 10.00, 'True', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '12/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(86, 57, 15, 13250.00, 'True', 10.00, 'False', 0.00, 'False', 0.00, 500.00, 'True', 'False', 0.00, 'False', 0.00, 'False', 16580.00, 0.00, 'False', 'False', 10.00, 'True', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(87, 58, 15, 11295.00, 'False', 10.00, 'False', 1.00, 'False', 0.00, 1000.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 14822.00, 1.00, 'True', 'True', 10.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '12/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(88, 59, 15, 10500.00, 'True', 10.00, 'True', 15.00, 'True', 12.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 12600.00, 5.00, 'False', 'False', 10.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '12/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(89, 60, 15, 11700.00, 'False', 0.00, 'False', 0.00, 'False', 0.00, 500.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 15540.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '09/24/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(90, 61, 15, 13750.00, 'False', 10.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 17590.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(91, 62, 15, 11000.00, 'False', 10.00, 'False', 3.00, 'False', 12.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 13600.00, 4.00, 'True', 'True', 10.00, 'True', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '12/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(92, 63, 15, 13650.00, 'True', 10.00, 'True', 2.00, 'True', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 17380.00, 0.00, 'False', 'False', 18.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '11/06/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(93, 64, 15, 12500.00, 'True', 10.00, 'True', 6.00, 'True', 15.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 16500.00, 4.00, 'False', 'False', 10.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '12/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(94, 65, 15, 17640.00, 'True', 10.00, 'True', 1.00, 'True', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 23170.00, 1.00, 'False', 'False', 10.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(95, 67, 15, 13992.00, 'True', 10.00, 'True', 0.00, 'False', 10.72, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 19319.50, 0.00, 'False', 'True', 10.00, 'True', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(96, 68, 15, 16560.00, 'False', 0.00, 'False', 0.00, 'False', 0.00, 750.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 22200.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(97, 69, 15, 13500.00, 'False', 10.00, 'False', 0.00, 'False', 15.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 15750.00, 0.00, 'True', 'True', 10.00, 'True', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '11/06/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(98, 70, 15, 17640.00, 'True', 10.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 22770.00, 4.00, 'True', 'True', 10.00, 'True', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '12/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(99, 71, 15, 15675.00, 'False', 10.00, 'False', 0.00, 'False', 0.00, 1500.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 21934.00, 4.00, 'True', 'True', 10.00, 'True', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '12/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(101, 73, 15, 6700.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 9380.00, 4.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(102, 74, 15, 5450.00, 'True', 10.00, 'True', 2.00, 'True', 10.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 7370.00, 2.00, 'True', 'True', 10.00, 'False', 50.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '12/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(103, 75, 15, 6300.00, 'True', 2.00, 'False', 10.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 8500.00, 10.00, 'False', 'True', 10.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(110, 76, 15, 6555.00, 'True', 2.00, 'True', 13.00, 'True', 0.00, 750.00, 'True', 'False', 0.00, 'False', 0.00, 'False', 9209.00, 5.00, 'True', 'True', 10.00, 'True', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(112, 74, 16, 5450.00, 'True', 4.00, 'False', 7.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 7370.00, 5.00, 'False', 'True', 4.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(113, 76, 16, 6000.00, 'True', 2.00, 'False', 5.00, 'False', 0.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'True', 92009.00, 5.00, 'False', 'True', 2.00, 'False', 3.00, 'False', 3.00, 'True', '', 'False', 98, 0, '', '09/26/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(114, 77, 15, 12300.00, 'False', 20.00, 'True', 0.00, 'True', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 15630.00, 0.00, 'True', 'True', 10.00, 'True', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '11/29/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(115, 78, 15, 300.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 400.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '12/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(116, 79, 15, 300.00, 'False', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 500.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '09/19/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(117, 71, 16, 15675.00, 'False', 10.00, 'False', 19.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 21934.00, 4.00, 'False', 'True', 10.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(119, 83, 15, 2745.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 3145.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'True', 0.00, 'False', '', 'False', 92, 0, '', '09/24/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(120, 43, 16, 3020.00, 'True', 10.80, 'True', 3.00, 'True', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 3420.00, 3.00, 'True', 'True', 10.80, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '12/14/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(121, 41, 16, 3300.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 500.00, 'True', 'False', 0.00, 'False', 0.00, 'False', 3740.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(122, 40, 16, 1850.00, 'True', 10.00, 'True', 18.00, 'True', 10.00, 0.00, 'False', 'False', 250.00, 'True', 0.00, 'False', 2110.00, 5.00, 'True', 'True', 10.00, 'True', 250.00, 'True', 0.00, 'False', '', 'False', 98, 0, '', '2017-05-25 09:01:46', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(123, 39, 16, 1977.00, 'True', 10.80, 'True', 6.00, 'True', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 2377.00, 8.00, 'True', 'True', 10.80, 'True', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '2017-05-11 15:00:15', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(124, 83, 16, 2745.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'True', 'False', 0.00, 'False', 0.00, 'True', 3145.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'True', 0.00, 'False', '', 'False', 98, 0, '', '09/27/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(125, 90, 15, 3700.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 500.00, 'True', 'False', 0.00, 'True', 0.00, 'False', 4125.00, 0.00, 'True', 'True', 0.00, 'True', 120.00, 'True', 0.00, 'False', '150', 'True', 92, 0, '', '2017-06-01 09:41:55', NULL, NULL, 'True', 'False', 'True', 'False', 'True', 'True', 'False', 'True', 'True'),
(126, 90, 16, 3700.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 500.00, 'True', 'False', 0.00, 'False', 0.00, 'False', 4125.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '0', 'False', 98, 0, '', '2017-06-01 07:32:40', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(127, 42, 16, 3150.00, 'True', 0.00, 'False', 0.00, 'False', 10.00, 0.00, 'False', 'True', 250.00, 'True', 0.00, 'False', 3410.00, 0.00, 'False', 'True', 0.00, 'False', 250.00, 'True', 0.00, 'False', '', 'False', 98, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(128, 91, 16, 2891.00, 'True', 10.00, 'True', 23.00, 'True', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 3341.00, 5.00, 'True', 'True', 10.00, 'True', 0.00, 'True', 0.00, 'False', '', 'False', 98, 0, '', '2017-05-25 09:04:20', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(129, 45, 16, 2136.00, 'False', 10.50, 'True', 3.00, 'True', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 2936.00, 3.00, 'True', 'True', 10.80, 'True', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '02/06/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(130, 49, 16, 3420.00, 'True', 10.80, 'True', 2.00, 'True', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 4220.00, 0.00, 'True', 'True', 10.80, 'True', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '12/14/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(131, 50, 16, 4275.00, 'True', 10.80, 'True', 10.00, 'True', 10.00, 200.00, 'True', 'False', 0.00, 'False', 0.00, 'False', 5075.00, 10.00, 'True', 'True', 10.80, 'True', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '02/06/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(132, 92, 15, 4150.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 5000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '02/06/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(133, 92, 16, 4150.00, 'True', 0.00, 'False', 0.00, 'False', 5.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 5000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '02/06/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(134, 93, 16, 3800.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 500.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 4205.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '02/06/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(135, 60, 16, 11700.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 500.00, 'True', 'False', 0.00, 'False', 0.00, 'False', 15540.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '09/24/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(136, 59, 16, 10500.00, 'True', 0.00, 'False', 0.00, 'False', 12.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 13100.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '09/24/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(137, 94, 15, 11295.00, 'True', 10.00, 'True', 3.00, 'True', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 14822.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '12/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(138, 94, 16, 11295.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 14822.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '09/24/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(139, 95, 15, 11700.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 500.00, 'True', 'False', 0.00, 'False', 0.00, 'False', 15540.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '10/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(140, 63, 16, 13650.00, 'False', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 17380.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(141, 96, 15, 13650.00, 'False', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 17380.00, 2.00, 'True', 'True', 10.00, 'True', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(142, 96, 16, 13650.00, 'False', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 17380.00, 2.00, 'True', 'True', 10.00, 'True', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '09/24/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(143, 61, 16, 13750.00, 'False', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 17590.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(144, 97, 15, 13750.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 500.00, 'True', 'False', 0.00, 'False', 0.00, 'False', 17590.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(145, 97, 16, 13750.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 500.00, 'True', 'False', 0.00, 'False', 0.00, 'False', 17590.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(146, 62, 16, 11000.00, 'False', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 13600.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(147, 98, 15, 11000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 500.00, 'True', 'False', 0.00, 'False', 0.00, 'False', 13600.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(148, 98, 16, 11000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 500.00, 'True', 'False', 0.00, 'False', 0.00, 'False', 13600.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(149, 99, 15, 10000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 500.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 12600.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '02/06/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(150, 99, 16, 10000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 12600.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '02/06/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(151, 53, 16, 11250.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 500.00, 'True', 'False', 0.00, 'False', 0.00, 'False', 14650.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(152, 54, 16, 10000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 1000.00, 'True', 'False', 0.00, 'False', 0.00, 'False', 13100.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(153, 52, 16, 10000.00, 'True', 0.00, 'False', 0.00, 'False', 12.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 12340.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(154, 100, 15, 10000.00, 'False', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 12340.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(155, 100, 16, 10000.00, 'False', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 12340.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(156, 55, 16, 12300.00, 'False', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 15630.00, 1.00, 'True', 'True', 11.00, 'True', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '12/14/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(157, 101, 15, 12300.00, 'True', 10.00, 'True', 1.00, 'True', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 15630.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '12/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(158, 101, 16, 12300.00, 'True', 11.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 15630.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(159, 57, 16, 13250.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 500.00, 'True', 'False', 0.00, 'False', 0.00, 'False', 16580.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(160, 56, 16, 10500.00, 'False', 0.00, 'False', 0.00, 'False', 12.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 12840.00, 11.00, 'False', 'True', 10.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(161, 102, 15, 10000.00, 'False', 0.00, 'False', 2.00, 'False', 0.00, 1000.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 13100.00, 4.00, 'True', 'True', 10.00, 'True', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '12/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False');
INSERT INTO `client_price` (`id`, `device_id`, `client_name`, `unit_cost`, `unit_cost_check`, `bulk_unit_cost`, `bulk_unit_cost_check`, `bulk`, `bulk_check`, `cco_discount`, `cco`, `cco_check`, `cco_discount_check`, `unit_rep_cost`, `unit_rep_cost_check`, `unit_repless_discount`, `unit_repless_discount_check`, `system_cost`, `system_bulk`, `system_bulk_check`, `system_cost_check`, `bulk_system_cost`, `bulk_system_cost_check`, `system_repless_cost`, `system_repless_cost_check`, `system_repless_discount`, `system_repless_discount_check`, `reimbursement`, `reimbursement_check`, `order_email`, `is_delete`, `is_created`, `is_updated`, `created_at`, `updated_at`, `unit_cost_delta_check`, `cco_delta_check`, `cco_discount_delta_check`, `unit_repless_delta_check`, `unit_repless_discount_delta_check`, `system_cost_delta_check`, `system_repless_delta_check`, `system_repless_discount_delta_check`, `reimbursement_delta_check`) VALUES
(162, 102, 16, 10000.00, 'False', 0.00, 'False', 0.00, 'False', 0.00, 1000.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 13100.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(163, 103, 15, 9000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 500.00, 'True', 'False', 0.00, 'False', 0.00, 'False', 16580.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '2017-02-24 06:17:06', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(164, 103, 16, 13250.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 16580.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '02/07/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(165, 66, 15, 17640.00, 'True', 10.00, 'True', 1.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 22770.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '11/29/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(166, 66, 16, 17640.00, 'True', 11.00, 'True', 2.00, 'True', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 22770.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '11/21/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(167, 70, 16, 17640.00, 'False', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 22770.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(168, 65, 16, 17640.00, 'True', 11.00, 'True', 0.00, 'True', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 23170.00, 0.00, 'False', 'False', 11.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '12/14/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(169, 104, 15, 17640.00, 'False', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 23170.00, 6.00, 'True', 'True', 10.00, 'True', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '12/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(170, 104, 16, 17640.00, 'False', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 23170.00, 1.00, 'True', 'True', 11.00, 'True', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '12/14/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(171, 68, 16, 16560.00, 'False', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 22200.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(172, 105, 15, 16560.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 750.00, 'True', 'False', 0.00, 'False', 0.00, 'False', 22200.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(173, 105, 16, 16560.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 750.00, 'True', 'False', 0.00, 'False', 0.00, 'False', 22200.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '10/01/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(174, 69, 16, 13500.00, 'False', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 15750.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(175, 64, 16, 12500.00, 'True', 0.00, 'False', 0.00, 'False', 15.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 16500.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '11/21/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(176, 106, 15, 12250.00, 'True', 0.00, 'False', 0.00, 'False', 15.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 16500.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(177, 106, 16, 12250.00, 'True', 0.00, 'False', 0.00, 'False', 15.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 16500.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '11/21/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(178, 107, 15, 4844.00, 'True', 0.00, 'True', 4.00, 'True', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 4885.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '11/29/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(179, 107, 16, 4884.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 4885.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(180, 73, 16, 6700.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 9380.00, 0.00, 'False', 'True', 0.00, 'False', 20.00, 'False', 3.00, 'False', '', 'False', 98, 0, '', '09/26/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(181, 75, 16, 6300.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 8500.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(182, 72, 15, 5700.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 7900.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(183, 72, 16, 5700.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 7900.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '09/25/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(184, 108, 15, 1400.00, 'True', 0.00, 'True', 5.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 17380.00, 3.00, 'True', 'True', 10.00, 'True', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '02/06/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(185, 109, 15, 10000.00, 'True', 0.00, 'False', 2.00, 'False', 0.00, 500.00, 'True', 'False', 0.00, 'False', 0.00, 'False', 12340.00, 2.00, 'True', 'True', 10.00, 'True', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '2017-02-24 06:18:12', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(186, 110, 15, 12600.00, 'False', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 14175.00, 5.00, 'True', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '12/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(187, 111, 15, 3250.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'True', 'False', 0.00, 'True', 0.00, 'False', 3550.00, 5.00, 'True', 'True', 10.00, 'True', 100.00, 'True', 0.00, 'False', '120', 'True', 92, 0, '', '2017-06-01 09:22:55', NULL, NULL, 'True', 'False', 'True', 'False', 'True', 'True', 'False', 'True', 'True'),
(188, 112, 15, 535.00, 'True', 10.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 25.00, 'False', 1000.00, 0.00, 'False', 'False', 0.00, 'False', 500.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '11/17/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(189, 108, 16, 13650.00, 'True', 0.00, 'True', 1.00, 'True', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 17380.00, 1.00, 'True', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '02/06/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(190, 113, 15, 1195.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 2000.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 92, 0, '', '11/15/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(191, 114, 15, 1050.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 2000.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 81, 0, '', '11/15/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(192, 115, 15, 6555.00, 'True', 10.00, 'True', 3.00, 'True', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 9960.00, 3.00, 'True', 'True', 10.00, 'True', 0.00, 'False', 0.00, 'False', '', 'False', 81, 0, '', '12/13/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(193, 116, 15, 1175.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 2000.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 81, 0, '', '11/15/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(194, 117, 15, 1425.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 2000.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 81, 0, '', '11/17/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(195, 120, 15, 200000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 500000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 81, 0, '', '12/19/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(197, 119, 15, 560.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 1000.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 81, 0, '', '11/17/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(198, 118, 15, 600.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 1000.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 81, 0, '', '11/17/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(199, 115, 16, 6555.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 9660.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '11/21/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(200, 111, 16, 3200.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 3550.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '02/06/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(201, 110, 16, 12600.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 14175.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '11/21/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(202, 109, 16, 10000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 12340.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '2017-02-07 06:27:33', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(203, 95, 16, 11700.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 15540.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '11/21/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(204, 77, 16, 12300.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 15630.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '11/21/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(205, 58, 16, 11295.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 14822.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '11/21/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(206, 48, 16, 3600.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 250.00, 'True', 0.00, 'False', 4120.00, 0.00, 'False', 'True', 0.00, 'False', 250.00, 'True', 0.00, 'False', '', 'False', 98, 0, '', '11/22/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(208, 46, 16, 2250.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 250.00, 'True', 0.00, 'False', 2770.00, 0.00, 'False', 'True', 0.00, 'False', 250.00, 'True', 0.00, 'False', '', 'False', 98, 0, '', '2017-05-11 14:19:54', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(209, 44, 16, 4050.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 4490.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '0', 'False', 98, 0, '', '2017-06-01 07:28:25', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(210, 93, 15, 500.00, 'True', 10.00, 'True', 2.00, 'True', 3.00, 50.00, 'True', 'False', 350.00, 'False', 3.00, 'True', 560.00, 10.00, 'True', 'True', 5.00, 'True', 150.00, 'True', 5.00, 'False', '3', 'False', 81, 0, '', '02/06/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(211, 120, 16, 45565.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 54634.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '12/20/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(212, 139, 15, 4658.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 7854.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 81, 0, '', '12/23/16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(213, 137, 20, 250.00, 'True', 2.00, 'True', 5.00, 'True', 2.00, 10.00, 'True', 'False', 210.00, 'True', 4.00, 'False', 550.00, 5.00, 'True', 'True', 5.00, 'True', 252.00, 'True', 3.00, 'False', '123', 'True', 50, 0, '', '02/06/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(214, 91, 15, 5000.00, 'True', 10.00, 'True', 26.00, 'True', 10.00, 100.00, 'False', 'True', 100.00, 'False', 10.00, 'True', 6000.00, 5.00, 'True', 'True', 10.00, 'True', 100.00, 'False', 10.00, 'True', '0', 'True', 81, 0, '', '2017-06-01 10:19:40', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(215, 51, 16, 4584.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 6542.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 98, 0, '', '02/06/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(216, 138, 20, 5000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 6000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 50, 0, '', '02/06/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(217, 139, 20, 6452.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 54552.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 133, 0, '', '02/06/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(218, 138, 15, 5000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 6000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 81, 0, '', '02/06/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(219, 111, 20, 6000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 7000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 50, 0, '', '02/06/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(220, 108, 20, 5000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 6000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 133, 0, '', '02/06/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(221, 139, 23, 5000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 6000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 137, 0, '', '02/06/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(222, 111, 26, 4000.00, 'True', 10.00, 'True', 5.00, 'True', 0.00, 100.00, 'True', 'False', 0.00, 'False', 10.00, 'True', 5000.00, 5.00, 'True', 'True', 10.00, 'True', 100.00, 'True', 0.00, 'False', '', 'False', 146, 0, '', '02/07/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(223, 109, 26, 6000.00, 'True', 10.00, 'True', 5.00, 'True', 10.00, 0.00, 'False', 'True', 100.00, 'True', 0.00, 'False', 7000.00, 10.00, 'True', 'True', 10.00, 'True', 0.00, 'False', 10.00, 'True', '', 'False', 146, 0, '', '02/07/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(224, 103, 26, 5000.00, 'True', 10.00, 'True', 10.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 6000.00, 10.00, 'True', 'True', 10.00, 'True', 100.00, 'True', 0.00, 'False', '', 'False', 146, 0, '', '02/07/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(225, 139, 26, 5000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 6005.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 146, 0, '', '2017-02-07 06:29:40', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(226, 111, 27, 5000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 6000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 149, 0, '', '02/07/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(227, 109, 27, 6000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 7000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 149, 0, '', '02/07/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(228, 103, 27, 5000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 6000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 149, 0, '', '02/07/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(258, 91, 17, 4000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 5000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '0', 'False', 0, 0, '', '2017-05-17 06:57:03', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(230, 109, 28, 4000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 5000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 151, 0, '', '02/07/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(231, 111, 28, 6000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 7000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 151, 0, '', '02/07/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(232, 103, 28, 4000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 5000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 151, 0, '', '02/07/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(233, 91, 28, 6000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 7000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 151, 0, '', '02/07/17', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(234, 140, 29, 5000.00, 'True', 10.00, 'True', 10.00, 'True', 0.00, 100.00, 'True', 'False', 0.00, 'False', 0.00, 'False', 6000.00, 10.00, 'True', 'True', 10.00, 'True', 100.00, 'True', 0.00, 'False', '', 'False', 151, 0, '', '2017-02-07 12:23:37', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(235, 141, 29, 8000.00, 'True', 10.00, 'True', 10.00, 'True', 0.00, 100.00, 'True', 'False', 100.00, 'True', 10.00, 'False', 9000.00, 10.00, 'True', 'True', 10.00, 'True', 100.00, 'True', 0.00, 'False', '', 'False', 151, 0, '', '2017-02-07 12:25:59', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(236, 142, 29, 9000.00, 'True', 10.00, 'True', 10.00, 'True', 10.00, 0.00, 'False', 'True', 0.00, 'False', 10.00, 'True', 10000.00, 10.00, 'True', 'True', 10.00, 'True', 0.00, 'False', 10.00, 'True', '', 'False', 151, 0, '', '2017-02-07 12:27:30', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(237, 143, 29, 8000.00, 'True', 10.00, 'True', 10.00, 'True', 10.00, 0.00, 'False', 'True', 0.00, 'False', 10.00, 'True', 10000.00, 10.00, 'True', 'True', 10.00, 'True', 0.00, 'False', 10.00, 'True', '', 'False', 151, 0, '', '2017-02-07 12:29:00', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(238, 145, 31, 5000.00, 'True', 10.00, 'True', 10.00, 'True', 10.00, 100.00, 'False', 'True', 100.00, 'False', 10.00, 'True', 6000.00, 10.00, 'True', 'True', 10.00, 'True', 0.00, 'False', 10.00, 'True', '', 'False', 153, 0, '', '2017-02-25 06:23:27', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(239, 146, 31, 6000.00, 'True', 10.00, 'True', 10.00, 'True', 0.00, 100.00, 'True', 'False', 100.00, 'True', 0.00, 'False', 7000.00, 10.00, 'True', 'True', 10.00, 'True', 100.00, 'True', 0.00, 'False', '', 'False', 153, 0, '', '2017-02-25 06:19:20', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(240, 39, 17, 5000.00, 'True', 5.00, 'True', 5.00, 'True', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 6000.00, 5.00, 'True', 'True', 5.00, 'True', 0.00, 'False', 0.00, 'False', '', 'False', 175, 0, '', '2017-05-11 09:54:00', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(241, 150, 33, 5000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 6000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 0, 0, '', '2017-05-11 13:06:49', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(242, 150, 16, 5000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 6000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 0, 0, '', '2017-05-11 13:48:39', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(243, 150, 15, 5000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 6000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 0, 0, '', '2017-05-11 13:49:04', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(244, 151, 17, 5000.00, 'True', 5.00, 'True', 5.00, 'True', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 6000.00, 5.00, 'True', 'True', 5.00, 'True', 0.00, 'False', 0.00, 'False', '', 'False', 0, 0, '', '2017-05-12 04:31:18', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(245, 151, 16, 5000.00, 'True', 5.00, 'True', 5.00, 'True', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 6000.00, 5.00, 'True', 'True', 5.00, 'True', 0.00, 'False', 0.00, 'False', '', 'False', 0, 0, '', '2017-05-12 04:31:53', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(246, 151, 15, 5000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 6000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 0, 0, '', '2017-05-12 04:32:37', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(247, 151, 33, 5000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 6000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 0, 0, '', '2017-05-12 04:32:56', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(248, 147, 16, 5000.00, 'True', 5.00, 'True', 4.00, 'True', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 6000.00, 5.00, 'True', 'True', 5.00, 'True', 0.00, 'False', 0.00, 'False', '', 'False', 0, 0, '', '2017-05-12 06:54:46', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(249, 147, 15, 5000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 6000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 0, 0, '', '2017-05-12 06:55:01', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(250, 147, 33, 5000.00, 'True', 5.00, 'True', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 6000.00, 5.00, 'True', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 0, 0, '', '2017-05-12 07:03:07', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(251, 148, 33, 5000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 6000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 0, 0, '', '2017-05-12 07:05:04', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(252, 44, 17, 5000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 6000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 0, 0, '', '2017-06-01 07:27:38', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(253, 152, 33, 5000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 6000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 0, 0, '', '2017-05-12 10:24:33', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(254, 153, 33, 5000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 6000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 0, 0, '', '2017-05-12 10:33:08', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(264, 156, 33, 5000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 6000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 0, 0, '', '2017-05-22 09:25:06', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(262, 153, 17, 5000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 6000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 0, 0, '', '2017-05-20 05:50:16', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(261, 153, 16, 5000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 6000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 0, 0, '', '2017-05-20 05:49:59', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(269, 156, 16, 5000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 6000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '', 'False', 0, 0, '', '2017-05-23 05:17:26', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False'),
(270, 156, 15, 5000.00, 'True', 0.00, 'False', 0.00, 'False', 0.00, 0.00, 'False', 'False', 0.00, 'False', 0.00, 'False', 6000.00, 0.00, 'False', 'True', 0.00, 'False', 0.00, 'False', 0.00, 'False', '0200', 'True', 0, 0, '', '2017-06-01 10:56:01', NULL, NULL, 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'False', 'True');

-- --------------------------------------------------------

--
-- Table structure for table `custom_contact_info`
--

CREATE TABLE `custom_contact_info` (
  `id` int(10) UNSIGNED NOT NULL,
  `clientId` int(10) UNSIGNED NOT NULL,
  `deviceId` int(10) UNSIGNED NOT NULL,
  `order_email` int(10) UNSIGNED NOT NULL,
  `cc1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cc2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cc3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cc4` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cc5` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cc6` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `custom_contact_info`
--

INSERT INTO `custom_contact_info` (`id`, `clientId`, `deviceId`, `order_email`, `cc1`, `cc2`, `cc3`, `cc4`, `cc5`, `subject`, `created_at`, `updated_at`, `cc6`) VALUES
(2, 15, 143, 125, 'nareshanantharaj@gmail.com', 'suren.benny46@gmail.com', 'manikandakumar7@gmail.com', 'msr300789@gmail.com', '300789msr@gmail.com', 'New Test Email', '2017-05-10 16:31:01', '2017-05-10 16:31:01', NULL),
(3, 16, 39, 98, 'nareshanatharaj@gmail.com', 'msr300789@gmail.com', '300789msr@gmail.com', 'mani@cyberfinite.com', '', 'New Device 123', '2017-05-11 17:10:04', '2017-05-11 22:01:08', ''),
(4, 16, 148, 98, 'test@gmail.com', '', '', '', '', 'test', '2017-05-11 17:45:30', '2017-05-11 17:45:30', ''),
(5, 15, 39, 81, 'nareshanatharaj@gmail.com', 'msr300789@gmail.com', '300789msr@gmail.com', 'mani@cyberfinite.com', 'suren.benny46@gmail.com', 'ADD Device', '2017-05-11 18:57:49', '2017-05-11 22:01:19', 'mani.kumar@cyberfinite.com'),
(6, 16, 40, 0, 'mani123@gmail.com', 'msr300789@gmail.com', '300789msr@gmail.com', 'mani@cyberfinite.com', 'suren.benny46@gmail.com', 'New Device 788', '2017-05-11 19:16:16', '2017-05-17 14:38:12', 'mani.kumar@cyberfinite.com'),
(7, 15, 40, 81, 'manikk1@gmail.com', 'msr300789@gmail.com', '300789msr@gmail.com', 'mani@cyberfinite.com', 'suren.benny46@gmail.com', 'ADD Device 123', '2017-05-11 19:17:25', '2017-05-20 13:07:55', 'mani.kumar@cyberfinite.com'),
(8, 16, 150, 98, 'mani123@gmail.com', 'msr300789@gmail.com', '300789msr@gmail.com', 'mani@cyberfinite.com', 'suren.benny6@gmail.com', 'ADD Device 244', '2017-05-11 20:51:46', '2017-05-20 14:33:02', 'mani.kumar@cyberfinite.com'),
(9, 15, 150, 125, 'mani123@gmail.com', 'msr300789@gmail.com', '300789msr@gmail.com', 'mani@cyberfinite.com', 'suren.benny4@gmail.com', 'ADD Device 1234', '2017-05-11 20:52:47', '2017-05-20 14:32:36', 'mani.kumar@cyberfinite.com'),
(10, 16, 46, 98, 'nareshanatharaj@gmail.com', 'msr300789@gmail.com', '300789msr@gmail.com', 'mani@cyberfinite.com', 'suren.benny46@gmail.com', 'dfgdfh', '2017-05-11 21:11:43', '2017-05-11 21:11:43', 'mani.kumar@cyberfinite.com'),
(11, 15, 46, 125, 'nareshanatharaj@gmail.com', 'msr300789@gmail.com', '300789msr@gmail.com', 'mani@cyberfinite.com', 'suren.benny46@gmail.com', 'New Device 123dfg', '2017-05-11 21:12:28', '2017-05-11 21:12:28', 'mani.kumar@cyberfinite.com'),
(12, 17, 151, 175, 'mani123@gmail.com', 'suren.benny46@gmail.com', 'msr300789@gmail.com', '300789@gmail.com', 'mani.kumar@urbansoft.in', 'Baylor - Device', '2017-05-12 11:35:52', '2017-05-20 14:30:16', 'mkk123@urbansoft.in'),
(13, 16, 151, 98, 'mani123@gmail.com', 'suren.benny4@gmail.com', 'msr300789@gmail.com', '300789msr@gmail.com', 'mani.kumar@urbansoft.in', 'New Test Email - CVPH', '2017-05-12 11:36:56', '2017-05-20 14:29:51', 'mkk123@urbansoft.in'),
(14, 15, 151, 81, 'mani123@gmail.com', 'suren.benny6@gmail.com', 'manikandakumar7@gmail.com', 'msr300789@gmail.com', '300789msr@gmail.com', 'New Test Email - UVMC', '2017-05-12 11:37:49', '2017-05-20 14:29:21', 'mkk300@urbansoft.in'),
(15, 33, 151, 178, 'mani123@gmail.com', 'suren.benny46@gmail.com', 'msr300789@gmail.com', '300789msr@gmail.com', 'mani.kumar@urbansoft.in', 'New Test Email - FC', '2017-05-12 11:39:39', '2017-05-20 14:28:51', 'mkk300@urbansoft.in'),
(16, 15, 147, 81, 'mani123@gmail.com', 'suren.benny6@gmail.com', '', '', '', 'New Test Email - UVMC', '2017-05-12 14:00:13', '2017-05-20 14:31:26', ''),
(17, 17, 39, 175, 'nareshanantharaj@gmail.com', 'suren.benny46@gmail.com', 'msr300789@gmail.com', '300789msr@gmail.com', 'mani.kumar@urbansoft.in', 'Baylor - Device', '2017-05-12 15:34:06', '2017-05-12 15:34:06', 'naresh@urbansoft.in'),
(18, 16, 44, 98, 'nareshanantharaj@gmail.com', 'suren.benny46@gmail.com', 'msr300789@gmail.com', '300789msr@gmail.com', 'mani.kumar@urbansoft.in', 'New Test Email - CVPH', '2017-05-12 17:14:42', '2017-05-12 17:14:42', 'naresh@urbansoft.in'),
(19, 15, 44, 125, 'nareshanantharaj@gmail.com', 'suren.benny46@gmail.com', 'msr300789@gmail.com', '300789msr@gmail.com', 'mani.kumar@urbansoft.in', 'New Test Email', '2017-05-12 17:16:06', '2017-05-12 17:16:06', 'naresh@urbansoft.in'),
(20, 17, 44, 175, 'nareshanantharaj@gmail.com', 'suren.benny46@gmail.com', 'msr300789@gmail.com', '300789msr@gmail.com', 'mani.kumar@urbansoft.in', 'Baylor - Device', '2017-05-12 17:18:11', '2017-05-12 17:18:11', 'naresh@urbansoft.in'),
(21, 16, 91, 98, 'manikk1@gmail.com', 'suren.benny46@gmail.com', 'manikandakumar7@gmail.com', 'mani.urbansoft@gmail.com', '', 'New DEvice CVPH', '2017-05-12 20:13:56', '2017-05-20 13:05:18', ''),
(23, 15, 155, 92, 'don@dmdgo.com', 'mani123@gmail.com', '', '', '', 'New DEvice UVMC', '2017-05-12 22:02:37', '2017-05-20 14:33:50', ''),
(28, 16, 156, 98, 'mani123@gmail.com', 'suren.benny4@gmail.com', 'msr300789@gmail.com', '300789msr@gmail.com', 'mani.kumar@urbansoft.in', 'New Test Email - CVPH', '2017-05-15 14:03:03', '2017-05-20 14:34:10', ''),
(45, 15, 156, 0, 'mani123@gmail.com', '', '', '', '', '', '2017-05-18 15:13:07', '2017-05-18 15:13:07', ''),
(40, 15, 91, 0, 'idigisofttech@gmail.com', 'suren.benny46@gmail.com', 'msr300789@gmail.com', 'mani.urbansoft@gmail.com', '300789msr@gmail.com', 'UVMC Order - Assurity SR', '2017-05-17 13:54:23', '2017-05-20 13:00:57', ''),
(47, 16, 154, 98, '', '', '', '', '', '', '2017-05-20 12:29:35', '2017-05-20 12:29:35', ''),
(48, 15, 154, 81, '', '', '', '', '', '', '2017-05-20 12:29:52', '2017-05-20 12:29:52', ''),
(49, 17, 153, 175, '', '', '', '', '', '', '2017-05-20 12:45:11', '2017-05-20 12:45:11', '');

-- --------------------------------------------------------

--
-- Table structure for table `device`
--

CREATE TABLE `device` (
  `id` int(10) UNSIGNED NOT NULL,
  `level_name` enum('Entry Level','Advanced Level') COLLATE utf8_unicode_ci NOT NULL,
  `project_name` int(10) UNSIGNED NOT NULL,
  `category_name` int(10) UNSIGNED NOT NULL,
  `manufacturer_name` int(10) UNSIGNED NOT NULL,
  `device_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `device_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rep_email` int(10) UNSIGNED NOT NULL,
  `status` enum('Enabled','Disabled') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Disabled',
  `exclusive` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `exclusive_check` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `longevity` int(11) NOT NULL,
  `longevity_check` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shock` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shock_check` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `size` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `size_check` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `research` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `research_check` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `website_page` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `website_page_check` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `overall_value` enum('Low','Medium','High') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Medium',
  `overall_value_check` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_delete` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `device`
--

INSERT INTO `device` (`id`, `level_name`, `project_name`, `category_name`, `manufacturer_name`, `device_name`, `model_name`, `device_image`, `rep_email`, `status`, `exclusive`, `exclusive_check`, `longevity`, `longevity_check`, `shock`, `shock_check`, `size`, `size_check`, `research`, `research_check`, `website_page`, `website_page_check`, `url`, `overall_value`, `overall_value_check`, `is_delete`, `created_at`, `updated_at`) VALUES
(5, 'Entry Level', 1, 5, 1, 'DE test', 'Mo test', 'device_44301.jpg', 41, 'Enabled', 'MRI', 'False', 8, 'False', '351/9s', 'False', '78g/34cc', 'False', 'Xyuz', 'False', 'Evera', 'False', 'http://mrkhabari.com', 'Medium', 'False', 1, NULL, NULL),
(16, 'Entry Level', 1, 5, 3, 'KBA123', 'KDB12', 'device_43820.png', 41, 'Enabled', '', 'False', 0, 'False', '', 'False', '', 'False', '', 'False', '', 'False', '', '', 'False', 1, NULL, NULL),
(19, 'Advanced Level', 4, 8, 3, 'MORDENMED', 'MOR125MED', 'device_29620.jpg', 61, 'Enabled', '', 'False', 0, 'False', '', 'False', '', 'False', '', 'False', '', 'False', '', '', 'False', 1, NULL, NULL),
(22, 'Entry Level', 2, 3, 2, 'MORGON D', 'DMOR456', 'device_59152.png', 39, 'Enabled', '', 'False', 0, 'False', '', 'False', '', 'False', '', 'False', '', 'False', '', '', 'False', 1, NULL, NULL),
(24, 'Entry Level', 2, 1, 1, 'Tamilnadu', 'Tamilnadu1', 'device_13479.png', 40, 'Enabled', '', 'False', 0, 'False', '', 'False', '', 'False', '', 'False', '', 'False', '', '', 'False', 1, NULL, NULL),
(39, 'Entry Level', 48, 25, 1, 'Sensia SR ', 'SESR01', 'device_78210.jpg', 162, 'Enabled', '', 'False', 10, 'True', '', 'False', '21/10', 'True', 'Wrapit', 'False', 'SESR01', 'True', 'http://www.medtronic.com/for-healthcare-professionals/products-therapies/cardiac-rhythm/pacemakers/sensia-pacing-system/', '', 'False', 0, NULL, NULL),
(40, 'Entry Level', 48, 25, 12, 'Etrinsa SR-T', '394936', 'device_78306.png', 102, 'Enabled', 'Cell/RF/CLS', 'False', 13, 'True', '140/35', 'False', '24/11', 'True', '', 'False', 'Etrinsa', 'True', 'http://www.biotronikusa.com/manuals/', '', 'False', 0, NULL, NULL),
(41, 'Entry Level', 48, 25, 3, 'Accolade SR', 'L300', 'device_52401.png', 100, 'Enabled', '', 'False', 9, 'True', '', 'False', '23/13', 'True', '', 'False', 'Accolade', 'True', 'https://www.bostonscientific.com/content/dam/bostonscientific/Rhythm%20Management/portfolio-group/Pacemakers/ACCOLADE/CRM-295812-AA-ACCOLADE_BrochHigh_web%20optimized.pdf', '', 'False', 0, NULL, NULL),
(42, 'Advanced Level', 48, 25, 12, 'Entovis SR-T', '4', 'device_35140.jpg', 102, 'Enabled', 'Cellular/MRI/RF Tele/CLS', 'False', 11, 'True', '', 'False', '24/11', 'True', '', 'False', 'Entovis', 'True', 'https://www.biotronik.com/en-de/products/crm/bradycardia/entovis-dr-t-sr-t', '', 'False', 0, NULL, NULL),
(43, 'Advanced Level', 48, 25, 1, 'Advisa SR', 'A3SR01', 'device_75483.jpg', 162, 'Enabled', '', 'False', 10, 'True', '', 'False', '21/12', 'True', '', 'False', 'Advisa', 'True', 'http://wwwp.medtronic.com/productperformance/model/A3SR01-advisa-sr.html', '', 'False', 0, NULL, NULL),
(44, 'Advanced Level', 48, 25, 3, 'Accolade MRI', 'L310', 'device_30616.jpg', 100, 'Enabled', 'MRI', 'True', 10, 'True', '', 'False', '23/13', 'True', '', 'False', '', 'False', '', '', 'False', 0, NULL, NULL),
(45, 'Entry Level', 48, 22, 1, 'Versa DR', 'VEDR01', 'device_82467.jpg', 162, 'Enabled', '', 'False', 9, 'True', '100/32', 'False', '27/12', 'True', 'CDTV', 'False', 'Versa', 'True', 'http://wwwp.medtronic.com/productperformance/model/VEDR01-versa-dr.html', '', 'False', 0, NULL, NULL),
(46, 'Advanced Level', 48, 22, 12, 'Etrinsa DR-T', '394931', 'device_99361.jpg', 102, 'Enabled', '', 'False', 10, 'True', '', 'False', '', 'True', '', 'False', 'Etrinsa', 'True', 'http://www.biotronikusa.com/global/assets/product_manuals/pacemakers/M4164-B%2012-14_Etrinsa%20Technical%20Manual_MN031r1.pdf', '', 'False', 0, NULL, NULL),
(47, 'Entry Level', 48, 22, 3, 'Accolade EL DR', 'L321', 'device_62340.png', 100, 'Disabled', '', 'False', 14, 'True', '', 'False', '29/15', 'True', '', 'False', 'Accolade', 'True', 'http://www.bostonscientific.com/en-US/products/pacemakers/accolade-and-essentio-pacemakers.html', '', 'False', 0, NULL, NULL),
(48, 'Advanced Level', 48, 22, 12, 'Eluna DR-T', '394969', 'device_63037.jpg', 102, 'Enabled', 'MRI/Cel/RF/CLS', 'False', 8, 'True', '', 'False', '25/12', 'True', '', 'False', 'Eluna', 'True', 'https://www.biotronik.com/en-us/products/crm/bradycardia/eluna-8-dr-t-sr-t', '', 'False', 0, NULL, NULL),
(49, 'Entry Level', 48, 22, 1, 'Adapta DR', 'ADDR01', 'device_25324.jpg', 162, 'Enabled', '', 'False', 8, 'True', '', 'False', '27/12', 'True', '', 'False', 'Adapta', 'True', 'http://manuals.medtronic.com/wcm/groups/mdtcom_sg/@emanuals/@era/@crdm/documents/documents/wcm_prod064182.pdf', '', 'False', 0, NULL, NULL),
(50, 'Advanced Level', 48, 22, 1, 'Advisa DR', 'A2DR01', 'device_77803.gif', 162, 'Enabled', '', 'False', 7, 'True', '', 'False', '22/12', 'True', '', 'False', 'Advisa', 'True', 'http://wwwp.medtronic.com/productperformance/model/A2DR01-advisa-dr-mri.html', '', 'False', 0, NULL, NULL),
(51, 'Advanced Level', 48, 22, 3, 'Accolade DR', '13', 'device_68742.png', 100, 'Disabled', 'MRI', 'True', 9, 'True', '', 'False', '25/13', 'True', '', 'False', '', 'False', '', '', 'False', 0, NULL, NULL),
(52, 'Entry Level', 48, 24, 12, 'Itrevia VR-T', '393040', 'device_68534.jpg', 102, 'Enabled', '', 'False', 9, 'True', '37/10', 'True', '82/33', 'True', '', 'False', 'Itrevia', 'True', 'http://www.biotronikusa.com/global/assets/product_manuals/icds/M4166-B%2002-15_Itrevia%20Technical%20Manual.pdf', '', 'False', 0, NULL, NULL),
(53, 'Entry Level', 48, 24, 3, 'Inogen Mini VR', 'D011', 'device_89279.jpg', 100, 'Enabled', '', 'False', 5, 'True', '35/9', 'True', '62/28', 'True', '', 'False', 'Inogen', 'True', 'http://www.bostonscientific.com/en-US/products/defibrillators/inogen.html', '', 'False', 0, NULL, NULL),
(54, 'Entry Level', 48, 24, 4, 'Ellipse NextGen VR', 'CD1411-36C', 'device_20337.jpg', 101, 'Enabled', '', 'False', 10, 'True', '36/10', 'True', '66/31', 'True', '', 'False', 'Ellipse', 'True', 'https://www.sjm.com/en/professionals/resources-and-reimbursement/technical-resources/cardiac-rhythm-management/implantable-cardioverter-defibrillator-icd-devices/single-chamber/ellipse-vr-single-chamber-implantable-cardioverter-defibrillator-icd?alert=Dee', '', 'False', 0, NULL, NULL),
(55, 'Advanced Level', 48, 24, 1, 'Visia AF VR', 'DVFB1D4', 'device_97651.png', 162, 'Enabled', 'MRI', 'False', 9, 'True', '35/8', 'True', '77/33', 'True', 'Wrapit', 'False', 'Visia', 'True', 'http://www.medtronic.com/us-en/healthcare-professionals/products/cardiac-rhythm/implantable-cardiac-defibrillators/visia-af-mri-surescan.html', '', 'False', 0, NULL, NULL),
(56, 'Advanced Level', 48, 24, 12, 'Iperia VR-T ', '393032', 'device_91760.jpg', 102, 'Enabled', '', 'False', 9, 'True', '37/10', 'True', '82/33', 'True', '', 'False', 'Iperia', 'True', 'https://www.biotronik.com/en-us/products/crm/tachycardia/iperia-7-vr-t-dx', '', 'False', 0, NULL, NULL),
(57, 'Advanced Level', 48, 24, 3, 'Inogen VR', 'D141', 'device_38394.jpg', 100, 'Enabled', '', 'False', 11, 'True', '35/9', 'True', '70/31', 'True', '', 'False', 'Inogen', 'True', 'https://www.bostonscientific.com/content/dam/bostonscientific/Rhythm%20Management/portfolio-group/ICD/INOGEN™%20EL™%20ICD/CRM-268401-AB_INOGEN_EL_ICD_specsheet.pdf', '', 'False', 0, NULL, NULL),
(58, 'Entry Level', 48, 23, 4, 'Ellipse NextGen DR', 'CD2411-36Q', 'device_89882.jpg', 101, 'Enabled', '', 'False', 8, 'True', '36/10', 'True', '68/31', 'True', '', 'False', 'Ellipse', 'True', 'https://www.sjm.com/en/professionals/featured-products/cardiac-rhythm-management/icd-devices/single-and-dual-chamber-defibrillators/ellipse-icd/details#tab', '', 'False', 0, NULL, NULL),
(59, 'Entry Level', 48, 23, 12, 'Itrevia DR-T', '392412', 'device_12921.jpg', 102, 'Enabled', '', 'False', 9, 'True', '37/10', 'True', '81/33', 'True', 'Protego', 'True', 'Itrevia', 'True', 'https://www.biotronik.com/en-de/products/crm/tachycardia/itrevia-7-dr-t-vr-t', '', 'False', 0, NULL, NULL),
(60, 'Entry Level', 48, 23, 3, 'Inogen Mini DR  ', 'D012', 'device_46085.jpg', 100, 'Enabled', '', 'False', 4, 'True', '35/9', 'True', '62/28', 'True', '', 'False', 'Inogen', 'True', 'http://www.bostonscientific.com/en-US/products/defibrillators/inogen.html', '', 'False', 0, NULL, NULL),
(61, 'Advanced Level', 48, 23, 3, 'Inogen DR ', 'D142', 'device_21444.jpg', 100, 'Enabled', '', 'False', 11, 'True', '35/9', 'True', '72/31', 'True', '', 'False', 'Inogen EL', 'True', 'http://www.bostonscientific.com/en-US/products/defibrillators/inogen-el.html', '', 'False', 0, NULL, NULL),
(62, 'Advanced Level', 48, 23, 12, 'Iperia DR', '392423', 'device_67714.jpg', 102, 'Enabled', 'MRI', 'False', 9, 'True', '37/10', 'True', '82/33', 'True', '', 'False', 'Iperia', 'True', 'https://www.biotronik.com/en-ch/products/crm/tachycardia/iperia-7-dr-t-vr-t', '', 'False', 0, NULL, NULL),
(63, 'Advanced Level', 48, 23, 1, 'Evera XT DR', 'DDBB1D1', 'device_13780.png', 162, 'Enabled', '', 'False', 7, 'True', '35/8', 'True', '78/34', 'True', '', 'False', 'Evera', 'True', 'http://www.medtronic.com/us-en/healthcare-professionals/products/cardiac-rhythm/implantable-cardiac-defibrillators/evera-xt-dr-vr-icd-defibrillators.html', '', 'False', 0, NULL, NULL),
(64, 'Entry Level', 48, 26, 12, 'Itrevia HF-T', '393014', 'device_42181.jpg', 102, 'Enabled', 'Cell/CLS', 'False', 8, 'True', '37/10', 'True', '81/36', 'True', 'Protego', 'False', 'Itrevia', 'True', 'http://www.biotronikusa.com/global/assets/product_manuals/crt-d/M4169-B%2006-15_Itrevia%20HF-T%20QP%20Technical%20Manual_MN045hq.pdf', '', 'False', 0, NULL, NULL),
(65, 'Advanced Level', 48, 26, 1, 'Viva Quad XT', 'DTBA1Q1', 'device_40576.png', 162, 'Enabled', '', 'False', 7, 'True', '35/8', 'True', '81/35', 'True', 'AdaptiveCRT/Wrapit', 'True', 'Viva Quad', 'True', 'http://www.medtronic.com/us-en/healthcare-professionals/products/cardiac-rhythm/cardiac-resynchronization-therapy-devices/viva-quadxt-crt-d-devices.html', '', 'False', 0, NULL, NULL),
(66, 'Entry Level', 48, 26, 1, 'Viva XT CRT-D ', 'DTBA1D1', 'device_80356.png', 162, 'Enabled', '', 'False', 7, 'True', '35/8', 'True', '81/35', 'True', 'AdaptiveCRT/Wrapit', 'False', 'VIVA', 'True', 'http://www.medtronic.com/us-en/healthcare-professionals/products/cardiac-rhythm/cardiac-resynchronization-therapy-devices/viva-xt-crt-d-devices.html', '', 'False', 0, NULL, NULL),
(67, 'Entry Level', 48, 26, 4, 'Unify Assura', 'CD3357-40C', 'device_66781.jpg', 101, 'Enabled', 'Cell', 'False', 8, 'True', '37/10', 'True', '78/36', 'True', '', 'False', 'Unify', 'True', 'https://www.sjmglobal.com/en-int/professionals/resources-and-reimbursement/technical-resources/cardiac-rhythm-management/cardiac-resynchronization-therapy-crt-devices/crt-defibrillator/unify-assura-no-coat-cardiac-resynchronisation-therapy-defibrillator-c', '', 'False', 0, NULL, NULL),
(68, 'Advanced Level', 48, 26, 3, 'Inogen CRT DF4', 'G148', 'device_34574.jpg', 100, 'Enabled', 'Quad Pole', 'False', 8, 'True', '35/9', 'True', '78/36', 'True', '', 'False', 'Ingoen', 'True', 'http://www.bostonscientific.com/en-US/products/crt-d/inogen.html', '', 'False', 0, NULL, NULL),
(69, 'Advanced Level', 48, 22, 12, 'Itrevia CRTD', '401662', 'device_34993.png', 102, 'Enabled', 'Quad Pole/CLS', 'False', 8, 'True', '37/10', 'True', '87/36', 'True', '', 'False', 'Itrevia', 'True', 'https://www.biotronik.com/en-us/products/crm/cardiac-resynchronization/itrevia-7-hf-t-qp-hf-t', '', 'False', 0, NULL, NULL),
(70, 'Entry Level', 48, 26, 1, 'VIVA XT ', 'DTBA1D4', 'device_65037.jpg', 162, 'Enabled', '', 'False', 7, 'True', '35/8', 'True', '80/35', 'True', 'VIVA Quad CRT XTDF4 Quad Pole', 'True', 'Viva', 'True', 'http://wwwp.medtronic.com/productperformance/model/DTBA1D4-viva-xt.html', '', 'False', 0, NULL, NULL),
(71, 'Advanced Level', 48, 26, 4, 'Quadra Assura NG', 'CD3365-40Q', 'device_87943.jpg', 101, 'Enabled', 'Quad Pole/Cell', 'False', 8, 'True', '40/9', 'True', '81/38', 'True', '', 'False', 'Quadra', 'True', 'https://www.sjm.com/en/professionals/featured-products/heart-failure-management/crt-devices/crt-defibrillators/quadra-assura-mp-crt-d', '', 'False', 0, NULL, NULL),
(72, 'Entry Level', 48, 27, 1, 'Syncra', 'C2TR01', 'device_18657.jpg', 162, 'Enabled', '', 'False', 8, 'True', '25/32', 'False', '26/15', 'True', '', 'False', 'Syncra', 'True', 'http://www.medtronic.com/us-en/healthcare-professionals/products/cardiac-rhythm/cardiac-resynchronization-therapy-devices/syncra-crt-p-devices.html', '', 'False', 0, NULL, NULL),
(73, 'Advanced Level', 48, 27, 3, 'Valitude Quad  ', 'U128', 'device_88921.jpg', 100, 'Enabled', 'Quad Pole/Cell', 'False', 10, 'True', '15/20', 'False', '33/18', 'True', '', 'False', 'Valitude', 'True', 'http://www.bostonscientific.com/en-US/products/crt-p/valitude-x4-crtp.html', '', 'False', 0, NULL, NULL),
(74, 'Entry Level', 48, 27, 12, 'Etrinsa CRTP', '394919', 'device_92326.jpg', 102, 'Enabled', 'MRI', 'False', 9, 'True', '100/15', 'False', '27/14', 'True', '', 'False', 'Etrinsa', 'True', 'https://www.biotronik.com/en-us/products/crm/cardiac-resynchronization/etrinsa-8-hf-t', 'High', 'False', 0, NULL, NULL),
(75, 'Entry Level', 48, 27, 1, 'Viva CRTP', 'C6TR01', 'device_50965.png', 162, 'Enabled', 'MRI', 'False', 9, 'True', '50/20', 'False', '26/15', 'True', 'Wrapit', 'False', 'Viva', 'True', 'http://www.medtronic.com/us-en/patients/treatments-therapies/heart-failure-device-crt/viva-cardiac-resynchronization-therapy-pacemaker.html', 'Medium', 'False', 0, NULL, NULL),
(76, 'Advanced Level', 48, 27, 4, 'Allure Quad', 'PM3562', 'device_83560.jpg', 101, 'Disabled', 'Quad Pole', 'False', 8, 'True', '25/2', 'False', '27/15', 'True', '', 'False', 'Allure', 'True', 'https://www.sjmglobal.com/en-int/professionals/featured-products/heart-failure-management/crt-devices/crt-pacemakers/quadra-allure-mp-rf-crt-p', 'Low', 'False', 0, NULL, NULL),
(77, 'Advanced Level', 23, 24, 1, 'EVERA XT VR', 'DVBB1D4', 'device_64426.jpg', 99, 'Enabled', 'MRI', 'False', 9, 'True', '35/9', 'True', '69/33', 'True', '', 'False', '', 'False', '', '', 'False', 0, NULL, NULL),
(78, 'Entry Level', 23, 29, 1, '5076', '5076', 'device_94902.jpg', 99, 'Disabled', 'thin', 'False', 0, 'False', '', 'False', '', 'False', '', 'False', '', 'False', '', '', 'False', 0, NULL, NULL),
(79, 'Entry Level', 23, 29, 1, 'Select Secure', '3830', 'device_46852.jpg', 99, 'Disabled', 'Thin', 'False', 0, 'False', '', 'False', '', 'False', '', 'False', '', 'False', '', '', 'False', 0, NULL, NULL),
(83, 'Entry Level', 23, 25, 1, 'Adapta SR', 'ADSR01', 'device_18766.jpg', 99, 'Enabled', '', 'False', 8, 'True', '', 'False', '21/10', 'True', '', 'False', 'Adapta SR', 'True', 'http://wwwp.medtronic.com/productperformance/model/ADSR01-adapta-sr.html', '', 'False', 0, NULL, NULL),
(90, 'Advanced Level', 48, 25, 3, 'Essentio SR', 'L110', 'device_52016.jpg', 100, 'Enabled', '', 'False', 10, 'True', '140/35', 'False', '13/13', 'True', '', 'False', 'Essentio', 'True', 'https://www.bostonscientific.com/content/dam/bostonscientific/Rhythm%20Management/portfolio-group/Pacemakers/ESSENTIO/CRM-287005-AB_ESSENTIO%20L100_L101_SpecSheet.pdf', '', 'False', 0, NULL, NULL),
(91, 'Entry Level', 48, 25, 4, 'Assurity SR', 'PM1240', 'device_61947.jpg', 101, 'Enabled', '', 'False', 10, 'True', '100/32', 'False', '10/20', 'True', '', 'False', 'Assurity', 'True', 'https://www.sjm.com/en/professionals/featured-products/cardiac-rhythm-management/pacemakers/single-and-dual-chamber-pacemakers/assurity-pacemaker?alert=DeepLinkSoftAlert&clset=af584191-45c9-4201-8740-5409f4cf8bdd%3ab20716c1-c2a6-4e4c-844b-d0dd6899eb3a', '', 'False', 0, NULL, NULL),
(92, 'Advanced Level', 23, 22, 3, 'Essentio DR', 'L111', 'device_42991.jpg', 100, 'Enabled', '', 'False', 9, 'True', '', 'False', '25/13', 'True', '', 'False', 'Essentio', 'True', 'https://www.bostonscientific.com/content/dam/bostonscientific/Rhythm%20Management/portfolio-group/Pacemakers/ESSENTIO/ESSENTIO_MRI_Pacemaker_Spec_Sheet.pdf', '', 'False', 0, NULL, NULL),
(93, 'Entry Level', 48, 22, 4, 'AssurityDR-RF', 'PM2240', 'device_63952.jpg', 101, 'Enabled', '', 'False', 9, 'True', '', 'False', '10/20', 'True', '', 'False', 'Assurity', 'True', 'https://www.sjm.com/en/professionals/featured-products/cardiac-rhythm-management/pacemakers/single-and-dual-chamber-pacemakers/assurity-pacemaker?alert=DeepLinkSoftAlert&clset=af584191-45c9-4201-8740-5409f4cf8bdd%3ab20716c1-c2a6-4e4c-844b-d0dd6899eb3a', '', 'False', 0, NULL, NULL),
(94, 'Entry Level', 23, 23, 4, 'Ellipse NG DR', 'CD2411-36C', 'device_45666.jpg', 101, 'Enabled', '', 'False', 8, 'True', '36/10', 'True', '68/31', 'True', '', 'False', 'Ellipse', 'True', 'https://www.sjm.com/en/professionals/featured-products/cardiac-rhythm-management/icd-devices/single-and-dual-chamber-defibrillators/ellipse-icd/details#tab', '', 'False', 0, NULL, NULL),
(95, 'Entry Level', 23, 23, 3, 'Inogen DR MINI', 'D013', 'device_27422.jpg', 100, 'Enabled', '', 'False', 4, 'True', '35/9', 'True', '62/28', 'True', '', 'False', 'Inogen', 'True', 'http://www.bostonscientific.com/en-US/products/defibrillators/inogen.html', '', 'False', 0, NULL, NULL),
(96, 'Advanced Level', 23, 23, 1, 'Evera DR XT', 'DDBB1D4', 'device_74112.png', 99, 'Disabled', '', 'False', 7, 'True', '35/8', 'True', '78/34', 'True', '', 'False', 'Evera XT', 'True', 'http://www.medtronic.com/us-en/healthcare-professionals/products/cardiac-rhythm/implantable-cardiac-defibrillators/evera-mri-xt-dr-vr.html', '', 'False', 0, NULL, NULL),
(97, 'Advanced Level', 23, 23, 3, 'Inogen EL', 'D143', 'device_77252.jpg', 100, 'Enabled', '', 'False', 11, 'True', '35/9', 'True', '71/31', 'True', '', 'False', 'Inogen EL', 'True', 'http://www.bostonscientific.com/content/dam/bostonscientific/Rhythm%20Management/portfolio-group/ICD/INOGEN™%20EL™%20ICD/CRM-268401-AB_INOGEN_EL_ICD_specsheet.pdf', '', 'False', 0, NULL, NULL),
(98, 'Advanced Level', 23, 23, 12, 'Iperia DR-T', '392409', 'device_50211.jpg', 102, 'Enabled', '', 'False', 8, 'True', '37/10', 'True', '82/33', 'True', 'Protego', 'True', 'Iperia', 'True', 'https://www.biotronik.com/en-ch/products/crm/tachycardia/iperia-7-dr-t-vr-t', '', 'False', 0, NULL, NULL),
(99, 'Entry Level', 23, 23, 12, 'Itrevia DR', '392426', 'device_41362.jpg', 102, 'Enabled', '', 'False', 9, 'True', '37/10', 'True', '81/33', 'True', 'Protego', 'True', 'Itrevia', 'True', 'http://www.biotronikusa.com/global/assets/product_manuals/icds/M4166-B%2002-15_Itrevia%20Technical%20Manual.pdf', '', 'False', 0, NULL, NULL),
(100, 'Entry Level', 23, 24, 12, 'Itrevia DX', '393037', 'device_11934.jpg', 102, 'Enabled', '', 'False', 9, 'True', '37/10', 'True', '82/33', 'True', '', 'False', 'Itrevia', 'True', 'http://www.biotronikusa.com/global/assets/product_manuals/icds/M4166-B%2002-15_Itrevia%20Technical%20Manual.pdf', '', 'False', 0, NULL, NULL),
(101, 'Advanced Level', 23, 24, 1, 'Visia ', 'DVAB1D1', 'device_25869.png', 99, 'Enabled', '', 'False', 9, 'True', '35/8', 'True', '77/33', 'True', '', 'False', 'Visia', 'True', 'http://www.medtronic.com/us-en/healthcare-professionals/products/cardiac-rhythm/implantable-cardiac-defibrillators/visia-af-mri-surescan.html', '', 'False', 0, NULL, NULL),
(102, 'Entry Level', 23, 24, 4, 'Ellipse NG', 'CD1411-36Q', 'device_71609.jpg', 101, 'Enabled', '', 'False', 10, 'True', '36/10', 'True', '67/30', 'True', '', 'False', 'Ellipse', 'True', 'https://www.sjm.com/en/professionals/resources-and-reimbursement/technical-resources/cardiac-rhythm-management/implantable-cardioverter-defibrillator-icd-devices/single-chamber/ellipse-vr-single-chamber-implantable-cardioverter-defibrillator-icd', '', 'False', 0, NULL, NULL),
(103, 'Advanced Level', 23, 24, 3, 'Inogen', 'D140', 'device_30465.png', 100, 'Enabled', '', 'False', 11, 'True', '35/9', 'True', '71/31', 'True', '', 'False', 'Inogen', 'True', 'https://www.bostonscientific.com/content/dam/bostonscientific/Rhythm%20Management/portfolio-group/ICD/INOGEN™%20EL™%20ICD/CRM-268401-AB_INOGEN_EL_ICD_specsheet.pdf', '', 'False', 0, NULL, NULL),
(104, 'Advanced Level', 23, 26, 1, 'VIVA XT Quad', 'DTBA1QQ', 'device_50859.png', 99, 'Enabled', '', 'False', 7, 'True', '35/8', 'True', '82/35', 'True', '', 'False', 'VIVA QUAD', 'True', 'http://www.medtronic.com/us-en/healthcare-professionals/products/cardiac-rhythm/cardiac-resynchronization-therapy-devices/viva-quadxt-crt-d-devices.html', '', 'False', 0, NULL, NULL),
(105, 'Advanced Level', 23, 26, 3, 'Inogen CRTD ', 'G146', 'device_27174.png', 100, 'Enabled', '', 'False', 8, 'True', '35/9', 'True', '73/32', 'True', '', 'False', 'Inogen', 'True', 'http://www.bostonscientific.com/en-US/products/crt-d/inogen.html', '', 'False', 0, NULL, NULL),
(106, 'Entry Level', 23, 26, 12, 'ITREVIA HF', '393016', 'device_92718.jpg', 102, 'Enabled', '', 'False', 8, 'True', '37/10', 'True', '82/33', 'True', '', 'False', 'Itrevia', 'True', 'http://www.biotronikusa.com/global/assets/product_manuals/icds/M4166-B%2002-15_Itrevia%20Technical%20Manual.pdf', '', 'False', 0, NULL, NULL),
(107, 'Entry Level', 23, 36, 1, 'Linq', 'Linq', 'device_68978.jpg', 99, 'Enabled', '', 'False', 3, 'True', '', 'False', '0/1', 'True', '', 'False', 'Linq', 'True', 'http://www.medtronicdiagnostics.com/us/cardiac-monitors/reveal-linq/', '', 'False', 0, NULL, NULL),
(108, 'Advanced Level', 23, 23, 1, 'Evera XT', 'DDMB1D4', 'device_46809.jpg', 99, 'Enabled', '', 'False', 7, 'True', '35/9', 'True', '77/33', 'True', '', 'False', 'Evera', 'True', 'http://wwwp.medtronic.com/productperformance/model/DDMB1D4-evera-mri-xt.html', '', 'False', 0, NULL, NULL),
(109, 'Entry Level', 23, 24, 12, 'Itrevia', '393041', 'device_91634.jpg', 102, 'Enabled', '', 'False', 9, 'True', '37/10', 'True', '82/33', 'True', '', 'False', 'Itrevia', 'True', 'http://www.biotronikusa.com/global/assets/product_manuals/icds/M4166-B%2002-15_Itrevia%20Technical%20Manual.pdf', '', 'False', 0, NULL, NULL),
(110, 'Advanced Level', 23, 26, 12, 'Iperia HF QP', '401658', 'device_70523.jpg', 102, 'Enabled', '', 'False', 8, 'True', '37/10', 'True', '87/36', 'True', '', 'False', 'IPERIA HF', 'True', 'https://www.biotronik.com/en-ch/products/crm/cardiac-resynchronization/iperia-7-hf-t-qp-hf-t', '', 'False', 0, NULL, NULL),
(111, 'Advanced Level', 48, 25, 12, 'Eluna SR', '394971', 'device_43554.jpg', 102, 'Enabled', '', 'False', 13, 'True', '120/30', 'False', '24/11', 'True', '', 'False', 'Eluna', 'True', 'http://www.biotronikusa.com/global/assets/product_manuals/pacemakers/M4160-B%2012-14_Eluna%20ProMRI%20Technical%20Manual_MN032r3sc.pdf', '', 'False', 0, NULL, NULL),
(112, 'Entry Level', 29, 38, 1, 'Integrity', 'Integrity', 'device_37798.jpg', 127, 'Enabled', '', 'False', 0, 'False', '', 'False', '', 'False', '', 'False', 'Integrity', 'True', 'http://www.medtronicstents.com/en/en_integrity_competitive_data.html', '', 'False', 0, NULL, NULL),
(113, 'Entry Level', 29, 37, 1, 'Resolute Integrity', 'Resolute Integrity', 'device_77289.jpg', 127, 'Enabled', '', 'False', 0, 'False', '', 'False', '', 'False', '', 'False', 'Resolute', 'True', 'http://www.medtronicstents.com/en/en_resolute_integrity.html', '', 'False', 0, NULL, NULL),
(114, 'Entry Level', 29, 37, 3, 'Promus Premier', 'Promus Premier', 'device_16449.jpg', 129, 'Enabled', '', 'False', 0, 'False', '', 'False', '', 'False', '', 'False', 'Promus', 'True', 'http://www.bostonscientific.com/en-US/products/stents--coronary/promus-premier-stent-system.html', '', 'False', 0, NULL, NULL),
(115, 'Advanced Level', 23, 27, 4, 'Allure Quadra RF', 'PM3242', 'device_46362.jpg', 101, 'Enabled', '', 'False', 8, 'True', '', 'False', '27/15', 'True', '', 'False', 'Allure Quad', 'True', 'https://www.sjm.com/en/professionals/resources-and-reimbursement/technical-resources/cardiac-rhythm-management/cardiac-resynchronization-therapy-crt-devices/crt-pacemaker/allure-quadra-rf-cardiac-resynchronization-therapy-pacemaker', '', 'False', 0, NULL, NULL),
(116, 'Entry Level', 29, 37, 14, 'Xience', 'Xience', 'device_23715.jpg', 130, 'Enabled', '', 'False', 0, 'False', '', 'False', '', 'False', '', 'False', 'Xience', 'True', 'http://www.abbottvascular.com/docs/ifu/coronary_intervention/eIFU_Xience_Xpedition.pdf', '', 'False', 0, NULL, NULL),
(117, 'Entry Level', 29, 37, 3, 'Synergy', 'Synergy', 'device_24861.jpg', 129, 'Enabled', '', 'False', 0, 'False', '', 'False', '', 'False', '', 'False', 'Synergy', 'True', 'https://www.bostonscientific.com/content/dam/bostonscientific/Interventional%20Cardiology/portfolio-group/Stents/Synergy/resource-center/SYNERGY-Product-Spec-Sheet.pdf', '', 'False', 0, NULL, NULL),
(118, 'Entry Level', 29, 38, 14, 'Vision', 'Vision', 'device_81850.png', 130, 'Enabled', '', 'False', 0, 'False', '', 'False', '', 'False', '', 'False', '', 'False', '', '', 'False', 0, NULL, NULL),
(119, 'Entry Level', 29, 38, 3, 'Rebel', 'Rebel', 'device_26850.png', 129, 'Enabled', '', 'False', 0, 'False', '', 'False', '', 'False', '', 'False', '', 'False', '', '', 'False', 0, NULL, NULL),
(120, 'Entry Level', 23, 41, 1, '55%', '55%', 'device_31534.png', 99, 'Enabled', '', 'False', 0, 'False', '45/12', 'True', '10/20', 'False', '', 'False', '', 'False', '', '', 'False', 0, NULL, NULL),
(121, 'Entry Level', 23, 29, 12, 'SELOX JT', '346369', 'device_91146.jpg', 102, 'Disabled', '', 'False', 0, 'False', '', 'False', '45/53', 'False', '', 'False', 'BIOTRONIK USA', 'False', 'http://www.biotronikusa.com/global/assets/product_manuals/pacer_leads/M4101_D%2010-14_Selox%20Technical%20Manual.pdf', '', 'False', 0, NULL, NULL),
(122, 'Entry Level', 23, 29, 12, 'SELOX ST', '346366', 'device_94908.jpg', 102, 'Disabled', '', 'False', 0, 'False', '', 'False', '53/60', 'False', '', 'False', 'BIOTRONIK USA', 'False', 'http://www.biotronikusa.com/global/assets/product_manuals/pacer_leads/M4101_D%2010-14_Selox%20Technical%20Manual.pdf', '', 'False', 0, NULL, NULL),
(123, 'Entry Level', 23, 29, 12, 'SOLIA S', '377176', 'device_22173.jpg', 102, 'Disabled', '', 'False', 0, 'False', '', 'False', '45/60', 'False', '', 'False', 'BIOTRONIKUSA.COM', 'False', 'http://www.biotronikusa.com/global/assets/product_manuals/pacer_leads/M4205-B%2006-16_Solia%20S%20Pacing%20Leads%20Technical%20Manual_MN072sc.pdf', '', 'False', 0, NULL, NULL),
(124, 'Entry Level', 23, 29, 3, 'EASYTRAK 2', '4517', 'device_88050.jpg', 100, 'Disabled', '', 'False', 0, 'False', '', 'False', '80/100', 'False', '', 'False', 'https://www.bostonscientific.com/content/dam/Manuals/us/current-rev-en/easytrak2_S.pdf', 'False', 'https://www.bostonscientific.com/content/dam/Manuals/us/current-rev-en/easytrak2_S.pdf', '', 'False', 0, NULL, NULL),
(125, 'Entry Level', 23, 29, 3, 'EASYTRAK 3', '4524', 'device_30958.jpg', 100, 'Disabled', '', 'False', 0, 'False', '', 'False', '80/100', 'False', '', 'False', 'https://www.bostonscientific.com/content/dam/Manuals/us/current-rev-en/356342-004_S.pdf', 'False', 'https://www.bostonscientific.com/content/dam/Manuals/us/current-rev-en/356342-004_S.pdf', '', 'False', 0, NULL, NULL),
(126, 'Entry Level', 23, 29, 3, 'ACUITY X4 CRT LEAD', '4672', 'device_70481.jpg', 100, 'Disabled', '', 'False', 0, 'False', '', 'False', '86', 'False', '', 'False', 'https://www.bostonscientific.com/content/dam/bostonscientific/Rhythm%20Management/portfolio-group/Leads/X4%20CRT-D%20and%20Acuity™%20X4/Acuity_X4_Spec_Sheet.pdf', 'False', 'https://www.bostonscientific.com/content/dam/bostonscientific/Rhythm%20Management/portfolio-group/Leads/X4%20CRT-D%20and%20Acuity™%20X4/Acuity_X4_Spec_Sheet.pdf', '', 'False', 0, NULL, NULL),
(127, 'Entry Level', 23, 29, 3, 'ACUITY SPIRAL', '4591', 'device_96197.jpg', 100, 'Disabled', '', 'False', 0, 'False', '', 'False', '80/100', 'False', '', 'False', 'https://www.bostonscientific.com/content/dam/Manuals/us/current-rev-en/357271-004_US_S.pdf', 'False', 'https://www.bostonscientific.com/content/dam/Manuals/us/current-rev-en/357271-004_US_S.pdf', '', 'False', 0, NULL, NULL),
(128, 'Entry Level', 23, 29, 3, 'ACUITY STEERABLE', '4555', 'device_35355.jpg', 100, 'Disabled', '', 'False', 0, 'False', '', 'False', '80/90', 'False', '', 'False', 'https://www.bostonscientific.com/content/dam/Manuals/us/current-rev-en/357203-006_US_S.pdf', 'False', 'https://www.bostonscientific.com/content/dam/Manuals/us/current-rev-en/357203-006_US_S.pdf', '', 'False', 0, NULL, NULL),
(129, 'Entry Level', 23, 29, 4, 'QUICKFLEX Micro', '1258T', 'device_99168.jpg', 101, 'Disabled', '', 'False', 0, 'False', '', 'False', '75/92', 'False', '', 'False', 'http://www.matesa.com.sv/manuales/quickflex-micro-brochure-en.pdf', 'False', 'http://www.matesa.com.sv/manuales/quickflex-micro-brochure-en.pdf', '', 'False', 0, NULL, NULL),
(130, 'Entry Level', 23, 29, 4, 'QUARTET', '1458Q', 'device_77596.jpg', 101, 'Disabled', '', 'False', 0, 'False', '', 'False', '86/92', 'False', '', 'False', 'http://www.cardion.cz/file/209/quartet-specsheet.pdf', 'False', 'http://www.cardion.cz/file/209/quartet-specsheet.pdf', '', 'False', 0, NULL, NULL),
(131, 'Entry Level', 23, 29, 1, 'Attain Ability ', '4196', 'device_54634.jpg', 99, 'Disabled', '', 'False', 0, 'False', '', 'False', '78/88', 'False', '', 'False', 'http://www.medtronic.com/content/dam/medtronic-com/products/cardiac-rhythm/cardiac-resynchronization-therapy-devices/attain-left-heart-leads/documents/attain-ability-surescan-4196.pdf', 'False', 'http://www.medtronic.com/content/dam/medtronic-com/products/cardiac-rhythm/cardiac-resynchronization-therapy-devices/attain-left-heart-leads/documents/attain-ability-surescan-4196.pdf', '', 'False', 0, NULL, NULL),
(132, 'Entry Level', 23, 29, 1, 'Attain Performa ', '4298', 'device_56387.png', 99, 'Disabled', '', 'False', 0, 'False', '', 'False', '78/88', 'False', '', 'False', 'http://www.medtronic.com/content/dam/medtronic-com-m/mdt/eu/documents/attain-performa-mod-4298-specs.pdf', 'False', 'http://www.medtronic.com/content/dam/medtronic-com-m/mdt/eu/documents/attain-performa-mod-4298-specs.pdf', '', 'False', 0, NULL, NULL),
(133, 'Entry Level', 23, 29, 12, 'Corox OTW BP Lead ', '354805', 'device_69186.jpg', 102, 'Disabled', '', 'False', 0, 'False', '', 'False', '75/85', 'False', '', 'False', 'http://www.biotronikusa.com/global/assets/pdf/product_manuals/lv_leads/M4124-B%202-10_Corox%20Family%20Manual.pdf', 'False', 'http://www.biotronikusa.com/global/assets/pdf/product_manuals/lv_leads/M4124-B%202-10_Corox%20Family%20Manual.pdf', '', 'False', 0, NULL, NULL),
(134, 'Entry Level', 23, 29, 3, 'Reliance PF', '148', 'device_27774.png', 100, 'Disabled', '', 'False', 0, 'False', '', 'False', '64/90', 'False', '', 'False', 'https://www.bostonscientific.com/content/dam/Manuals/us/current-rev-en/355456-005_EndotakReliance_PLM_US_S.pdf', 'False', 'https://www.bostonscientific.com/content/dam/Manuals/us/current-rev-en/355456-005_EndotakReliance_PLM_US_S.pdf', '', 'False', 0, NULL, NULL),
(135, 'Entry Level', 23, 29, 3, 'Reliance AF', '158', 'device_47566.jpg', 100, 'Disabled', '', 'False', 0, 'False', '', 'False', '59/90', 'False', '', 'False', 'https://www.bostonscientific.com/content/dam/Manuals/us/current-rev-en/355458-005_Reliance_S_ExtRet_PLM_US_S.pdf', 'False', 'https://www.bostonscientific.com/content/dam/Manuals/us/current-rev-en/355458-005_Reliance_S_ExtRet_PLM_US_S.pdf', '', 'False', 0, NULL, NULL),
(136, 'Entry Level', 23, 29, 4, 'Durata ', '7122', 'device_86659.jpg', 101, 'Disabled', '', 'False', 0, 'False', '', 'False', '60/65', 'False', '', 'False', 'https://www.sjm.com/en/professionals/resources-and-reimbursement/technical-resources/cardiac-rhythm-management/leads/defibrillation-leads/durata-defibrillation-lead', 'False', 'https://www.sjm.com/en/professionals/resources-and-reimbursement/technical-resources/cardiac-rhythm-management/leads/defibrillation-leads/durata-defibrillation-lead', '', 'False', 0, NULL, NULL),
(137, 'Entry Level', 35, 49, 1, 'Test Device 101', 'TD101', 'device_52665.jpg', 99, 'Enabled', '', '', 5, '', '56/10', '', '50/20', '', 'Wrapit', '', 'Tracer', '', 'http://tracetrick.com', 'Medium', '', 0, NULL, NULL),
(138, 'Entry Level', 35, 53, 14, 'Test 123', '123test', 'device_53763.png', 134, 'Enabled', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', 0, NULL, NULL),
(139, 'Advanced Level', 36, 58, 14, 'tersrvf', '635awdcx', 'device_67385.png', 134, 'Enabled', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', 0, NULL, NULL),
(140, 'Entry Level', 42, 63, 15, 'tesqeqwd', 'werew3252', 'device_76583.png', 152, 'Enabled', '', '', 10, '', '100/32', '', '', '', '', '', '', '', '', '', '', 0, NULL, NULL),
(141, 'Entry Level', 42, 63, 15, 'mfgd234', 'xvfs1232', 'device_20830.png', 152, 'Enabled', '', '', 0, '', '133/61', '', '', '', '', '', '', '', '', 'Medium', '', 0, NULL, NULL),
(142, 'Entry Level', 42, 64, 15, 'recx344', 'xcd33', 'device_64595.png', 152, 'Enabled', '', '', 0, '', '', '', '50/23', '', '', '', '', '', '', 'High', '', 0, NULL, NULL),
(143, 'Entry Level', 42, 64, 15, 'nfg34', 'gfjdf112', 'device_77005.png', 152, 'Enabled', '', '', 9, '', '', '', '', '', '', '', '', '', '', '', '', 0, NULL, NULL),
(144, 'Entry Level', 23, 29, 3, 'dsfvgds', 'dsfs', 'device_86760.png', 100, 'Enabled', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', 0, NULL, NULL),
(145, 'Entry Level', 45, 66, 17, 'Device', 'de322', 'device_52514.png', 161, 'Enabled', '', '', 10, '', '50/32', '', '100/32', '', 'RF/DER', '', 'Facebook', '', 'https://www.facebook.com/', 'Medium', '', 0, NULL, NULL),
(146, 'Entry Level', 45, 66, 17, 'Device1', 'sd5452', 'device_31927.png', 161, 'Enabled', '', '', 10, '', '10/22', '', '50/21', '', 'SDF/AF', '', 'Google', '', 'https://www.google.co.in/', 'Medium', '', 0, NULL, NULL),
(147, 'Entry Level', 47, 70, 15, 'First Device1', 'FD1-235', 'device_88175.jpg', 152, 'Enabled', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', 0, NULL, NULL),
(148, 'Entry Level', 47, 69, 15, 'test23', 'temo23', 'device_15487.png', 152, 'Enabled', 'ter', '', 5, '', '25/20', '', '50/20', '', 'Wrapit', '', 'Tracer', '', 'http://tracetrick.com', 'Low', '', 0, NULL, NULL),
(149, 'Entry Level', 45, 66, 15, 'test', 'test234', 'device_44888.jpg', 0, 'Enabled', 'test', '', 125, '', '100/32', '', '10/21', '', 'huhiii', '', 'test', '', 'test.com', '', '', 0, NULL, NULL),
(150, 'Entry Level', 47, 70, 19, 'New123Device', 'N123D', 'device_72310.jpg', 0, 'Enabled', '', '', 10, '', '', '', '', '', '', '', '', '', '', '', '', 0, NULL, NULL),
(151, 'Entry Level', 50, 73, 19, 'First Device645', 'FD645', 'device_27171.jpg', 0, 'Enabled', '', '', 10, '', '15/12', '', '', '', '', '', '', '', '', '', '', 0, NULL, NULL),
(152, 'Entry Level', 47, 71, 19, 'Prer545', 'ert65', 'device_72832.jpg', 0, 'Enabled', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', 0, NULL, NULL),
(153, 'Entry Level', 47, 71, 19, 'Fam132WE', 'WE1234', 'device_11779.jpg', 0, 'Enabled', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', 0, NULL, NULL),
(154, 'Entry Level', 28, 30, 4, 'New Dev123', 'ND145', 'device_83932.jpg', 0, 'Enabled', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', 0, NULL, NULL),
(155, 'Entry Level', 48, 25, 4, 'New Device78RE', 'ER45', 'device_23560.jpg', 0, 'Enabled', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', 0, NULL, NULL),
(156, 'Entry Level', 50, 73, 4, 'New Proj DEv1', 'NPD1231', 'device_13947.jpg', 0, 'Enabled', '', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', 0, NULL, NULL),
(157, 'Advanced Level', 48, 22, 12, 'SDRF', 'SD4562', 'default.jpg', 0, 'Enabled', '0', '', 0, '', '0', '', '0', '', '0', '', '0', '', '-', 'Medium', '', 0, NULL, NULL),
(158, 'Advanced Level', 48, 22, 12, 'dfdgf', 'sdds', 'default.jpg', 0, 'Enabled', '0', '', 0, '', '0', '', '0', '', '0', '', '0', '', '-', 'Medium', '', 0, NULL, NULL),
(159, 'Advanced Level', 48, 26, 3, 'MADON', 'MA123D', 'default.jpg', 0, 'Enabled', '0', '', 0, '', '0', '', '0', '', '0', '', '0', '', '-', 'Medium', '', 0, NULL, NULL),
(160, 'Advanced Level', 48, 27, 1, 'MADONE', 'MD134D', 'default.jpg', 0, 'Enabled', '0', '', 0, '', '0', '', '0', '', '0', '', '0', '', '-', 'Medium', '', 0, NULL, NULL),
(161, 'Advanced Level', 48, 27, 1, 'KUD123', 'K145D', 'default.jpg', 0, 'Enabled', '0', '', 0, '', '0', '', '0', '', '0', '', '0', '', '-', 'Medium', '', 0, NULL, NULL),
(162, 'Advanced Level', 48, 25, 1, 'Mani123', 'MD123', 'default.jpg', 0, 'Enabled', '0', '', 0, '', '0', '', '0', '', '0', '', '0', '', '-', 'Medium', '', 0, NULL, NULL),
(163, 'Advanced Level', 48, 25, 1, 'DDVRWE', 'PS2SD', 'default.jpg', 0, 'Enabled', '0', '', 0, '', '0', '', '0', '', '0', '', '0', '', '-', 'Medium', '', 0, NULL, NULL),
(164, 'Advanced Level', 48, 25, 1, 'Itrevia 007', '007ITR', 'default.jpg', 0, 'Enabled', '0', '', 0, '', '0', '', '0', '', '0', '', '0', '', '-', 'Medium', '', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `device_custom_field`
--

CREATE TABLE `device_custom_field` (
  `id` int(10) UNSIGNED NOT NULL,
  `device_id` int(10) UNSIGNED NOT NULL,
  `client_name` int(10) UNSIGNED NOT NULL,
  `field_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `field_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `field_check` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_delete` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `device_custom_field`
--

INSERT INTO `device_custom_field` (`id`, `device_id`, `client_name`, `field_name`, `field_value`, `field_check`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 8, 0, '', '', 'False', 0, NULL, NULL),
(2, 9, 0, '', '', 'False', 0, NULL, NULL),
(3, 15, 0, 'Kumar', '', 'False', 0, NULL, NULL),
(5, 23, 0, 'Kumar', '', 'False', 0, NULL, NULL),
(6, 44, 0, 'Features', 'MRI', 'False', 0, NULL, NULL),
(7, 78, 0, 'Lead Size', '10', 'True', 0, NULL, NULL),
(8, 78, 0, 'Lead Length', '23', 'True', 0, NULL, NULL),
(9, 75, 0, 'Features', 'Adapt', 'False', 0, NULL, NULL),
(10, 73, 0, 'Features', 'QP/RF', 'False', 0, NULL, NULL),
(11, 74, 0, 'Features', 'RF/CLS', 'False', 0, NULL, NULL),
(12, 79, 0, 'Fr Size', '15', 'True', 0, NULL, NULL),
(13, 40, 0, 'Features', 'Cel/RF/CLS', 'False', 0, NULL, NULL),
(14, 90, 0, 'Features', 'MRI/RF', 'False', 0, NULL, NULL),
(15, 39, 0, 'Features', '', 'False', 0, NULL, NULL),
(16, 83, 0, 'Features', '', '1', 0, NULL, NULL),
(17, 41, 0, 'Features', 'RF', 'False', 0, NULL, NULL),
(18, 43, 0, 'Features', 'MRI', 'False', 0, NULL, NULL),
(19, 42, 0, 'Features', 'MRI/RF/CLS', 'False', 0, NULL, NULL),
(20, 91, 0, 'Features', 'RF', 'False', 0, NULL, NULL),
(21, 45, 0, 'Features', '10', 'False', 0, NULL, NULL),
(22, 47, 0, 'Features', 'RF', 'False', 0, NULL, NULL),
(23, 46, 0, 'Features', 'RF/CLS', 'False', 0, NULL, NULL),
(24, 49, 0, 'Features', 'MVP', 'False', 0, NULL, NULL),
(25, 50, 0, 'Features', 'MRI/MVP', 'False', 0, NULL, NULL),
(26, 92, 0, 'Features', 'MRI/RF', 'True', 0, NULL, NULL),
(27, 48, 0, 'Features', 'MRI/RF/CLS', 'False', 0, NULL, NULL),
(28, 93, 0, 'Features', 'RF', 'False', 0, NULL, NULL),
(29, 60, 0, 'Features', 'RF', 'False', 0, NULL, NULL),
(30, 60, 0, 'Header ', 'DF4', 'False', 0, NULL, NULL),
(31, 59, 0, 'Features', 'RF/CLS', 'False', 0, NULL, NULL),
(32, 59, 0, 'Header', 'DF1', 'False', 0, NULL, NULL),
(33, 58, 0, 'Features', 'RF', 'False', 0, NULL, NULL),
(34, 58, 0, 'Header', 'DF4', 'False', 0, NULL, NULL),
(35, 94, 0, 'Features', 'RF', 'True', 0, NULL, NULL),
(36, 94, 0, 'Header ', 'DF1', 'True', 0, NULL, NULL),
(37, 95, 0, 'Features', 'RF', 'True', 0, NULL, NULL),
(38, 95, 0, 'Header', 'DF1', 'True', 0, NULL, NULL),
(39, 63, 0, 'Features', 'MRI/RF', 'False', 0, NULL, NULL),
(40, 63, 0, 'Header', 'DF1', 'False', 0, NULL, NULL),
(41, 77, 0, 'Features', 'MRI', 'True', 0, NULL, NULL),
(42, 77, 0, 'Header', 'DF4', 'True', 0, NULL, NULL),
(43, 96, 0, 'Features', 'MRI/RF', 'True', 0, NULL, NULL),
(44, 96, 0, 'Header', 'DF4', 'True', 0, NULL, NULL),
(45, 62, 0, 'Features', 'MRI/RF', 'False', 0, NULL, NULL),
(46, 62, 0, 'Header', 'DF4', 'False', 0, NULL, NULL),
(47, 61, 0, 'Features', 'RF/EL', 'False', 0, NULL, NULL),
(48, 97, 0, 'Features', 'RF/EL', 'True', 0, NULL, NULL),
(49, 97, 0, 'Header', 'DF1', 'True', 0, NULL, NULL),
(50, 98, 0, 'Features', 'MRI/RF/CLS', 'True', 0, NULL, NULL),
(51, 98, 0, 'Header', 'DF1', 'True', 0, NULL, NULL),
(52, 61, 0, 'Header', 'DF4', 'False', 0, NULL, NULL),
(53, 99, 0, 'Features', 'RF/CLS', 'True', 0, NULL, NULL),
(54, 99, 0, 'Header', 'DF4', 'True', 0, NULL, NULL),
(55, 53, 0, 'Features', 'RF', 'False', 0, NULL, NULL),
(56, 53, 0, 'Header', 'DF1', 'False', 0, NULL, NULL),
(57, 54, 0, 'Features', 'RF', 'False', 0, NULL, NULL),
(58, 54, 0, 'Header', 'DF1', 'False', 0, NULL, NULL),
(59, 52, 0, 'Features', 'RF/CLS', 'False', 0, NULL, NULL),
(60, 52, 0, 'Header', 'DF1', 'False', 0, NULL, NULL),
(61, 100, 0, 'Features', 'VDD/RF/CLS', 'True', 0, NULL, NULL),
(62, 100, 0, 'Header', 'DF4', 'True', 0, NULL, NULL),
(63, 55, 0, 'Features', 'MRI/RF/AF', 'False', 0, NULL, NULL),
(64, 55, 0, 'Header', 'DF4', 'False', 0, NULL, NULL),
(65, 101, 0, 'Features', 'MRI/RF/AF', 'True', 0, NULL, NULL),
(66, 101, 0, 'Header ', 'DF1', 'True', 0, NULL, NULL),
(67, 57, 0, 'Features', 'RF', 'False', 0, NULL, NULL),
(68, 57, 0, 'Header ', 'DF1', 'False', 0, NULL, NULL),
(69, 56, 0, 'Features', 'MRI/VDD/CLS', 'False', 0, NULL, NULL),
(70, 56, 0, 'Header', 'DF4', 'False', 0, NULL, NULL),
(71, 102, 0, 'Features', 'RF', 'True', 0, NULL, NULL),
(72, 102, 0, 'Header', 'DF4', 'True', 0, NULL, NULL),
(73, 103, 0, 'Features', 'RF/EL', 'True', 0, NULL, NULL),
(74, 103, 0, 'Header', 'DF4', 'True', 0, NULL, NULL),
(75, 70, 0, 'Features', 'Adaptive', 'False', 0, NULL, NULL),
(76, 70, 0, 'Header', 'DF4/IS1', 'False', 0, NULL, NULL),
(77, 66, 0, 'Features', 'Adaptive', 'False', 0, NULL, NULL),
(78, 66, 0, 'Header', 'DF1/IS1', 'False', 0, NULL, NULL),
(79, 65, 0, 'Features', 'QP', 'False', 0, NULL, NULL),
(80, 65, 0, 'Features', 'Adaptive', 'False', 0, NULL, NULL),
(81, 104, 0, 'Features', 'QP/RF/Adpt', 'True', 0, NULL, NULL),
(82, 104, 0, 'Header', 'DF4/IS4', 'True', 0, NULL, NULL),
(83, 71, 0, 'Features', 'QP/RF', 'False', 0, NULL, NULL),
(84, 71, 0, 'Header', 'DF4/IS4', 'False', 0, NULL, NULL),
(85, 68, 0, 'Features', 'QP/RF', 'False', 0, NULL, NULL),
(86, 68, 0, 'Header', 'DF4/IS4', 'False', 0, NULL, NULL),
(87, 105, 0, 'Features', 'QP', 'True', 0, NULL, NULL),
(88, 105, 0, 'Features', '-', 'True', 0, NULL, NULL),
(89, 69, 0, 'Features', 'QP/RF/CLS', 'False', 0, NULL, NULL),
(90, 69, 0, 'Header', 'DF4/IS4', 'False', 0, NULL, NULL),
(91, 64, 0, 'Features', 'RF/CLS', 'False', 0, NULL, NULL),
(92, 64, 0, 'Header', 'DF1/IS1', 'False', 0, NULL, NULL),
(93, 106, 0, 'Features', 'CLS', 'True', 0, NULL, NULL),
(94, 106, 0, 'Header', 'DF4/IS1', 'True', 0, NULL, NULL),
(95, 67, 0, 'Features', 'RF', 'False', 0, NULL, NULL),
(96, 67, 0, 'Header', 'DF1/IS1', 'False', 0, NULL, NULL),
(97, 76, 0, 'Features', 'QP/RF/MP', 'False', 0, NULL, NULL),
(98, 108, 0, 'Features', 'MRI/RF', 'True', 0, NULL, NULL),
(99, 108, 0, 'Header', 'DF4', 'True', 0, NULL, NULL),
(100, 109, 0, 'Features', 'RF/CLS', 'True', 0, NULL, NULL),
(101, 109, 0, 'Header', 'DF4', 'True', 0, NULL, NULL),
(102, 65, 0, 'Header', 'DF1/IS4', 'False', 0, NULL, NULL),
(103, 105, 0, 'Header', 'DF1/IS4', 'True', 0, NULL, NULL),
(104, 110, 0, 'Features ', 'QP', 'True', 0, NULL, NULL),
(105, 110, 0, 'Header', 'DF4/IS4', 'True', 0, NULL, NULL),
(106, 111, 0, 'Features', 'MRI/RF/CLS', 'False', 0, NULL, NULL),
(107, 112, 0, 'Material ', 'Cobalt', 'True', 0, NULL, NULL),
(108, 113, 0, 'Delivery', 'Microtrac', 'True', 0, NULL, NULL),
(109, 113, 0, 'Drug', 'Zotarolimus', 'True', 0, NULL, NULL),
(110, 113, 0, 'Material', 'Cobalt', 'True', 0, NULL, NULL),
(115, 115, 0, 'Features', 'QP/RF', 'True', 0, NULL, NULL),
(116, 114, 0, 'Delivery', 'ACDS', 'True', 0, NULL, NULL),
(117, 114, 0, 'Drug', 'Everolimus', 'True', 0, NULL, NULL),
(118, 114, 0, 'Material', 'PtCr', 'True', 0, NULL, NULL),
(119, 116, 0, 'Delivery ', 'RE', 'True', 0, NULL, NULL),
(120, 116, 0, 'Drug', 'Everolimus', 'True', 0, NULL, NULL),
(121, 116, 0, 'Material', 'CoCr', 'True', 0, NULL, NULL),
(122, 117, 0, 'Delivery', 'Dual', 'True', 0, NULL, NULL),
(123, 117, 0, 'Drug', 'Everolimus', 'True', 0, NULL, NULL),
(124, 117, 0, 'Material', 'PtCr', 'True', 0, NULL, NULL),
(125, 112, 0, 'Delivery', 'Microtrac', '1', 0, NULL, NULL),
(126, 118, 0, 'Delivery', 'Multi-Link Vision', 'True', 0, NULL, NULL),
(127, 118, 0, 'Material', 'CoCr', 'True', 0, NULL, NULL),
(128, 119, 0, 'Delivery', 'Balloon Catheter', 'True', 0, NULL, NULL),
(129, 119, 0, 'Material', 'PtCr', 'True', 0, NULL, NULL),
(130, 120, 0, 'BSX', '22%', 'True', 0, NULL, NULL),
(131, 120, 0, 'StJ', '15%', 'True', 0, NULL, NULL),
(134, 115, 16, 'Features1', '10', 'True', 0, NULL, NULL),
(135, 59, 15, 'Features', 'RF/CLS', 'False', 0, NULL, NULL),
(143, 59, 15, 'Headers', 'DF1', 'False', 0, NULL, NULL),
(153, 44, 15, 'Size', '33g/21cc', 'False', 0, NULL, NULL),
(154, 120, 0, 'Add Field', 'dfd', 'True', 0, NULL, NULL),
(155, 120, 0, 'Plus', '10', 'True', 0, NULL, NULL),
(156, 120, 0, 'Minus', '12', 'True', 0, NULL, NULL),
(157, 120, 0, 'Multiplying', '4', 'False', 0, NULL, NULL),
(158, 136, 0, 'Field one', 'Value One', '1', 0, NULL, NULL),
(159, 136, 0, 'Field second', 'Value Second', 'True', 0, NULL, NULL),
(160, 139, 0, 'dfg', 'ert', 'False', 0, NULL, NULL),
(161, 139, 0, 'dfgd', 'dgdg', 'False', 0, NULL, NULL),
(162, 45, 0, 'value', 's20', 'False', 0, NULL, NULL),
(163, 45, 0, 'control', '540', 'False', 0, NULL, NULL),
(164, 45, 0, 'wrs', '54w3', 'False', 0, NULL, NULL),
(165, 45, 0, 'wersf241', 'dsrtrt42', 'False', 0, NULL, NULL),
(166, 45, 0, 'wer45', '9965ert345', 'False', 0, NULL, NULL),
(167, 45, 0, 'werwer', '345ef', 'False', 0, NULL, NULL),
(168, 45, 0, 'ghfdg', '3453sdc', 'False', 0, NULL, NULL),
(169, 45, 0, 'ldfgdg56', '345sdfsd', 'False', 0, NULL, NULL),
(170, 92, 0, 'xsdf', 'dfds', 'False', 0, NULL, NULL),
(171, 92, 0, 'ABX', 'XBA', 'False', 0, NULL, NULL),
(172, 46, 0, 'Adds', 'dsf', 'False', 0, NULL, NULL),
(173, 139, 0, 'Abcd', 'Abcd', 'False', 0, NULL, NULL),
(174, 93, 0, 'sdd', 'sfer', 'False', 0, NULL, NULL),
(175, 93, 0, 'dfhrt', '67ffd', 'False', 0, NULL, NULL),
(176, 93, 0, '3cdf', '546gfsdhf', 'False', 0, NULL, NULL),
(177, 93, 0, 'cbhg', '56ffg', 'False', 0, NULL, NULL),
(178, 93, 0, 'zxfsdfd', '3cd534', 'False', 0, NULL, NULL),
(179, 93, 0, 'sdfgsdge', '324dfsf', 'False', 0, NULL, NULL),
(180, 93, 0, 'weraf', '5dfdf', 'False', 0, NULL, NULL),
(181, 93, 0, 'dfgdsg', 'fdgdfg', 'False', 0, NULL, NULL),
(182, 93, 0, 'sfdsdfe', 'weett', 'False', 0, NULL, NULL),
(183, 93, 0, 'sdfs', 'etet', 'False', 0, NULL, NULL),
(184, 93, 0, 'weraf', 'fsf', 'False', 0, NULL, NULL),
(185, 146, 0, 'Feature', '654', 'False', 0, NULL, NULL),
(186, 146, 0, 'Feature1', 'fghd', 'False', 0, NULL, NULL),
(187, 146, 0, 'Feature2', 'fghfdhr', 'False', 0, NULL, NULL),
(188, 146, 0, 'Feature3', 'fdbgdf', 'False', 0, NULL, NULL),
(189, 146, 0, 'Feature4', 'fghf', 'False', 0, NULL, NULL),
(190, 146, 0, 'Feature5', 'ghfg', 'False', 0, NULL, NULL),
(191, 146, 0, 'Feature6', '.kjll', 'False', 0, NULL, NULL),
(192, 146, 0, 'Feature7', 'yuitjy', 'False', 0, NULL, NULL),
(193, 146, 0, 'Feature8', 'fdydhydhgdr', 'False', 0, NULL, NULL),
(194, 146, 0, 'Feature9', 'dfgdg', 'False', 0, NULL, NULL),
(195, 145, 0, 'Feature', '645', 'False', 0, NULL, NULL),
(196, 145, 0, 'Feature1', '6+745dfvds', 'False', 0, NULL, NULL),
(197, 145, 0, 'Feature2', 'gfhftrh', 'False', 0, NULL, NULL),
(198, 145, 0, 'Feature3', 'dfgdsgjdx', 'False', 0, NULL, NULL),
(199, 145, 0, 'Feature4', 'oihjk', 'False', 0, NULL, NULL),
(200, 145, 0, 'Feature5', 'yuygffh', 'False', 0, NULL, NULL),
(201, 145, 0, 'Feature6', 'ukigfg', 'False', 0, NULL, NULL),
(202, 145, 0, 'Feature7', 'jklbxz', 'False', 0, NULL, NULL),
(203, 145, 0, 'Feature8', 'ghjtnf', 'False', 0, NULL, NULL),
(204, 145, 0, 'Feature9', '.oifrt64', 'False', 0, NULL, NULL),
(205, 156, 0, 'header', '125/4', 'False', 0, NULL, NULL),
(206, 156, 0, 'header', '125/4', 'False', 0, NULL, NULL),
(207, 111, 0, 'header', 'As/54', 'False', 0, NULL, NULL),
(208, 90, 0, 'header', 'edd/52', 'False', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `device_features`
--

CREATE TABLE `device_features` (
  `id` int(10) UNSIGNED NOT NULL,
  `device_id` int(10) UNSIGNED NOT NULL,
  `client_name` int(10) UNSIGNED NOT NULL,
  `longevity_check` enum('True','False') COLLATE utf8_unicode_ci DEFAULT 'False',
  `shock_check` enum('True','False') COLLATE utf8_unicode_ci DEFAULT 'False',
  `size_check` enum('True','False') COLLATE utf8_unicode_ci DEFAULT 'False',
  `research_check` enum('True','False') COLLATE utf8_unicode_ci DEFAULT 'False',
  `siteinfo_check` enum('True','False') COLLATE utf8_unicode_ci DEFAULT 'False',
  `overall_value_check` enum('True','False') COLLATE utf8_unicode_ci DEFAULT 'False',
  `is_created` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_updated` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `device_features`
--

INSERT INTO `device_features` (`id`, `device_id`, `client_name`, `longevity_check`, `shock_check`, `size_check`, `research_check`, `siteinfo_check`, `overall_value_check`, `is_created`, `is_updated`, `created_at`, `updated_at`) VALUES
(1, 45, 15, 'True', 'True', 'True', 'True', 'True', 'True', '', '', '2016-12-23 21:57:00', '2016-12-23 22:13:53'),
(2, 45, 16, '', NULL, NULL, NULL, NULL, NULL, '', '', '2016-12-23 21:59:27', '2016-12-23 21:59:27'),
(3, 46, 15, 'True', NULL, NULL, 'True', 'True', NULL, '', '', '2016-12-23 22:06:20', '2016-12-23 22:10:05'),
(4, 46, 16, '', NULL, NULL, NULL, NULL, NULL, '', '', '2016-12-23 22:07:13', '2016-12-23 22:07:13'),
(5, 139, 15, '', NULL, NULL, NULL, 'True', NULL, '', '', '2016-12-26 18:37:30', '2016-12-26 18:37:30'),
(6, 111, 15, 'True', NULL, 'True', NULL, NULL, NULL, '', '', '2017-01-06 13:43:22', '2017-06-02 06:39:39'),
(7, 48, 15, 'True', NULL, 'True', NULL, 'True', NULL, '', '', '2017-02-04 14:24:21', '2017-02-04 14:24:21'),
(8, 108, 15, '', NULL, NULL, NULL, NULL, NULL, '', '', '2017-02-04 14:54:24', '2017-02-04 14:54:24'),
(9, 111, 16, 'True', NULL, 'True', NULL, 'True', NULL, '', '', '2017-02-04 16:53:08', '2017-02-04 16:53:08'),
(10, 109, 15, 'True', 'True', 'True', NULL, NULL, NULL, '', '', '2017-02-04 16:54:07', '2017-02-07 17:50:29'),
(11, 109, 16, 'True', NULL, 'True', NULL, NULL, NULL, '', '', '2017-02-04 16:54:21', '2017-02-04 16:54:21'),
(12, 103, 15, 'True', 'True', 'True', NULL, NULL, NULL, '', '', '2017-02-04 16:54:40', '2017-02-24 13:15:23'),
(13, 103, 16, 'True', NULL, NULL, NULL, 'True', NULL, '', '', '2017-02-04 16:54:57', '2017-02-04 16:54:57'),
(14, 102, 15, '', NULL, NULL, NULL, NULL, NULL, '', '', '2017-02-04 16:55:16', '2017-02-04 16:55:16'),
(15, 102, 16, 'True', NULL, 'True', NULL, 'True', NULL, '', '', '2017-02-04 16:55:32', '2017-02-04 16:55:32'),
(16, 91, 15, 'True', 'True', 'True', NULL, NULL, NULL, '', '', '2017-02-04 16:55:48', '2017-06-01 05:00:43'),
(17, 91, 16, 'True', NULL, 'True', NULL, 'True', NULL, '', '', '2017-02-04 16:56:07', '2017-02-06 15:09:27'),
(18, 90, 15, 'True', NULL, 'True', NULL, NULL, NULL, '', '', '2017-02-04 16:56:23', '2017-06-02 06:39:22'),
(19, 90, 16, 'True', NULL, 'True', NULL, 'True', NULL, '', '', '2017-02-04 16:56:36', '2017-02-04 16:56:36'),
(20, 137, 20, 'True', 'True', 'True', 'True', 'True', 'True', '', '', '2017-02-06 14:01:19', '2017-02-06 14:01:19'),
(21, 108, 16, 'True', NULL, NULL, NULL, NULL, NULL, '', '', '2017-02-06 15:11:21', '2017-02-06 15:11:21'),
(22, 99, 15, 'True', NULL, NULL, NULL, NULL, NULL, '', '', '2017-02-06 15:12:22', '2017-02-06 15:12:22'),
(23, 99, 16, '', 'True', 'True', NULL, 'True', NULL, '', '', '2017-02-06 15:12:34', '2017-02-06 15:12:34'),
(24, 93, 15, 'True', NULL, 'True', NULL, NULL, NULL, '', '', '2017-02-06 15:13:10', '2017-02-06 15:13:10'),
(25, 93, 16, 'True', NULL, 'True', NULL, 'True', NULL, '', '', '2017-02-06 15:13:21', '2017-02-07 18:55:15'),
(26, 92, 15, 'True', NULL, 'True', NULL, NULL, NULL, '', '', '2017-02-06 15:13:59', '2017-02-06 15:13:59'),
(27, 92, 16, 'True', NULL, 'True', NULL, 'True', NULL, '', '', '2017-02-06 15:14:12', '2017-02-07 18:00:57'),
(28, 51, 15, 'True', NULL, 'True', NULL, NULL, NULL, '', '', '2017-02-06 15:15:02', '2017-02-06 15:15:02'),
(29, 51, 16, 'True', NULL, 'True', NULL, NULL, NULL, '', '', '2017-02-06 15:15:16', '2017-02-06 15:15:16'),
(30, 50, 15, 'True', NULL, 'True', NULL, NULL, NULL, '', '', '2017-02-06 15:16:08', '2017-02-06 15:16:08'),
(31, 50, 16, 'True', NULL, 'True', NULL, NULL, NULL, '', '', '2017-02-06 15:16:24', '2017-02-06 15:16:24'),
(32, 138, 20, '', NULL, NULL, NULL, NULL, NULL, '', '', '2017-02-06 15:47:40', '2017-02-06 15:47:40'),
(33, 139, 20, '', NULL, NULL, NULL, NULL, NULL, '', '', '2017-02-06 15:48:22', '2017-02-06 15:48:22'),
(34, 138, 15, '', NULL, NULL, NULL, NULL, NULL, '', '', '2017-02-06 16:01:04', '2017-02-06 16:01:04'),
(35, 111, 20, 'True', NULL, NULL, NULL, NULL, NULL, '', '', '2017-02-06 17:09:02', '2017-02-06 17:09:02'),
(36, 108, 20, '', NULL, NULL, NULL, NULL, NULL, '', '', '2017-02-06 17:10:09', '2017-02-06 17:10:09'),
(37, 139, 23, '', NULL, NULL, NULL, NULL, NULL, '', '', '2017-02-06 20:12:12', '2017-02-06 20:12:12'),
(38, 111, 26, 'True', NULL, 'True', NULL, NULL, NULL, '', '', '2017-02-07 09:46:09', '2017-02-07 09:46:09'),
(39, 103, 26, 'True', NULL, 'True', NULL, 'True', NULL, '', '', '2017-02-07 10:03:48', '2017-02-07 10:03:48'),
(40, 109, 26, 'True', NULL, 'True', NULL, 'True', NULL, '', '', '2017-02-07 10:04:05', '2017-02-07 10:04:05'),
(41, 139, 26, '', NULL, NULL, NULL, NULL, NULL, '', '', '2017-02-07 10:30:10', '2017-02-07 10:30:10'),
(42, 111, 27, 'True', NULL, 'True', NULL, NULL, NULL, '', '', '2017-02-07 12:31:10', '2017-02-07 12:31:10'),
(43, 109, 27, 'True', 'True', NULL, NULL, NULL, NULL, '', '', '2017-02-07 12:31:54', '2017-02-07 12:31:54'),
(44, 103, 27, 'True', NULL, NULL, NULL, 'True', NULL, '', '', '2017-02-07 12:32:39', '2017-02-07 12:32:39'),
(98, 91, 17, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-18 12:17:02', '2017-05-18 12:17:02'),
(46, 111, 28, 'True', NULL, NULL, NULL, NULL, NULL, '', '', '2017-02-07 12:37:55', '2017-02-07 12:37:55'),
(47, 109, 28, '', 'True', NULL, NULL, NULL, NULL, '', '', '2017-02-07 12:38:08', '2017-02-07 12:38:08'),
(48, 103, 28, 'True', NULL, NULL, NULL, NULL, NULL, '', '', '2017-02-07 12:38:44', '2017-02-07 12:38:44'),
(78, 155, 16, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-13 17:01:46', '2017-05-13 17:01:46'),
(50, 140, 29, 'True', 'True', NULL, NULL, NULL, NULL, '', '', '2017-02-07 19:23:57', '2017-02-07 19:23:57'),
(51, 141, 29, '', 'True', NULL, NULL, NULL, NULL, '', '', '2017-02-07 19:26:09', '2017-02-07 19:26:09'),
(52, 142, 29, '', NULL, 'True', NULL, NULL, 'True', '', '', '2017-02-07 19:27:43', '2017-02-07 19:27:43'),
(53, 143, 29, 'True', NULL, NULL, NULL, NULL, NULL, '', '', '2017-02-07 19:29:10', '2017-02-07 19:29:10'),
(54, 145, 31, 'True', 'True', 'True', 'True', 'True', 'True', '', '', '2017-02-25 13:07:57', '2017-02-25 13:20:50'),
(55, 146, 31, 'True', 'True', 'True', 'True', 'True', 'True', '', '', '2017-02-25 13:08:50', '2017-02-25 13:18:22'),
(56, 143, 15, '', NULL, NULL, NULL, NULL, NULL, '', '', '2017-04-20 14:50:39', '2017-04-20 14:50:39'),
(57, 148, 33, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-11 18:40:42', '2017-05-11 18:40:42'),
(58, 40, 16, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-11 19:14:17', '2017-05-11 19:14:17'),
(59, 40, 15, 'True', 'True', 'True', NULL, NULL, NULL, '', '', '2017-05-11 19:14:27', '2017-06-01 05:01:14'),
(60, 39, 16, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-11 19:14:41', '2017-05-11 19:14:41'),
(61, 39, 15, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-11 19:15:00', '2017-05-11 19:15:00'),
(62, 150, 33, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-11 20:50:02', '2017-05-11 20:50:02'),
(63, 150, 15, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-11 20:50:29', '2017-05-11 20:50:29'),
(64, 150, 16, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-11 20:50:54', '2017-05-11 20:50:54'),
(65, 151, 17, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-12 11:33:23', '2017-05-12 11:33:23'),
(66, 151, 16, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-12 11:33:33', '2017-05-12 11:33:33'),
(67, 151, 15, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-12 11:33:44', '2017-05-12 11:33:44'),
(68, 151, 33, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-12 11:33:53', '2017-05-12 11:33:53'),
(69, 147, 17, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-12 13:55:09', '2017-05-12 13:55:09'),
(70, 147, 16, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-12 13:55:20', '2017-05-12 13:55:20'),
(71, 147, 15, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-12 13:55:27', '2017-05-12 13:55:27'),
(72, 147, 33, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-12 14:03:39', '2017-05-12 14:03:39'),
(73, 44, 16, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-12 17:13:41', '2017-05-12 17:13:41'),
(74, 44, 15, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-12 17:13:49', '2017-05-12 17:13:49'),
(75, 44, 17, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-12 17:13:58', '2017-05-12 17:13:58'),
(76, 152, 33, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-12 17:25:02', '2017-05-12 17:25:02'),
(77, 153, 33, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-12 17:33:30', '2017-05-12 17:33:30'),
(107, 153, 17, 'True', NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-20 12:45:26', '2017-05-20 12:46:32'),
(99, 154, 16, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-20 12:18:26', '2017-05-20 12:18:26'),
(108, 154, 15, 'True', NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-20 14:05:14', '2017-05-20 14:05:14'),
(109, 156, 33, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-22 16:25:48', '2017-05-22 16:25:48'),
(110, 156, 16, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-22 16:25:56', '2017-05-22 16:25:56'),
(111, 156, 15, 'True', NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-22 16:26:08', '2017-06-01 05:39:08'),
(104, 154, 17, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-20 12:28:13', '2017-05-20 12:28:13'),
(105, 153, 15, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-20 12:30:24', '2017-05-20 12:30:24'),
(106, 153, 16, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-20 12:30:37', '2017-05-20 12:30:37'),
(113, 156, 34, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '2017-05-22 17:45:39', '2017-05-22 17:45:39');

-- --------------------------------------------------------

--
-- Table structure for table `item_files`
--

CREATE TABLE `item_files` (
  `id` int(10) UNSIGNED NOT NULL,
  `clientId` int(10) UNSIGNED NOT NULL,
  `itemFile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_files_details`
--

CREATE TABLE `item_files_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `company` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `supplyItem` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mfgPartNumber` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hospitalNumber` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `doctors` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_file_entry`
--

CREATE TABLE `item_file_entry` (
  `id` int(10) UNSIGNED NOT NULL,
  `repcaseID` int(10) UNSIGNED NOT NULL,
  `supplyItem` int(10) UNSIGNED NOT NULL,
  `hospitalPart` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mfgPartNumber` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `purchaseType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `serialNumber` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `poNumber` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loginuser`
--

CREATE TABLE `loginuser` (
  `id` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `loginuser`
--

INSERT INTO `loginuser` (`id`, `userId`, `created_at`, `updated_at`) VALUES
(1, 96, '2017-05-30 03:50:38', '2017-05-30 03:50:38'),
(2, 96, '2017-05-30 04:07:38', '2017-05-30 04:07:38'),
(3, 96, '2017-05-30 04:22:36', '2017-05-30 04:22:36'),
(4, 96, '2017-05-31 03:19:40', '2017-05-31 03:19:40'),
(5, 106, '2017-05-31 03:41:13', '2017-05-31 03:41:13'),
(6, 96, '2017-05-31 23:19:22', '2017-05-31 23:19:22'),
(7, 96, '2017-06-01 23:37:01', '2017-06-01 23:37:01');

-- --------------------------------------------------------

--
-- Table structure for table `manufacturers`
--

CREATE TABLE `manufacturers` (
  `id` int(10) UNSIGNED NOT NULL,
  `item_no` int(11) NOT NULL,
  `manufacturer_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `manufacturer_logo` text COLLATE utf8_unicode_ci NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_delete` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `manufacturers`
--

INSERT INTO `manufacturers` (`id`, `item_no`, `manufacturer_name`, `manufacturer_logo`, `is_active`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 6130, 'Medtronic', 'manu_logo_84781.png', 0, 0, NULL, NULL),
(3, 7848, 'Boston Scientific', 'manu_logo_15917.png', 0, 0, NULL, NULL),
(4, 6567, 'St.Jude Medical', 'manu_logo_81138.png', 0, 0, NULL, NULL),
(12, 2295, 'Biotronik', 'manu_logo_77629.png', 0, 0, NULL, NULL),
(13, 5286, 'Biosense Webster', 'manu_logo_16643.png', 0, 0, NULL, NULL),
(14, 9935, 'Abbott', 'manu_logo_21129.png', 0, 0, NULL, NULL),
(15, 4537, 'TestManu', 'manu_logo_60890.jpg', 0, 0, NULL, NULL),
(17, 2220, 'Test', 'manu_logo_69240.png', 0, 0, NULL, NULL),
(19, 2595, 'First Manu', 'manu_logo_52343.jpg', 0, 0, NULL, NULL),
(20, 3261, 'Test Manu', 'manu_logo_81429.jpg', 0, 0, NULL, NULL),
(21, 9692, 'meermanu', 'manu_logo_20960.jpg', 0, 0, NULL, NULL),
(22, 7149, 'ert manu', 'manu_logo_40965.jpg', 0, 0, NULL, NULL),
(23, 6854, 'New Manu', 'manu_logo_29363.png', 0, 0, NULL, NULL),
(24, 4672, 'New Man', 'manu_logo_93423.jpg', 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2017_04_18_055011_create_password_resets_table', 1),
('2017_04_18_055506_state_table', 1),
('2017_04_18_063857_role_table', 1),
('2017_04_18_070536_client_table', 1),
('2017_04_18_071409_projects_table', 1),
('2017_04_18_072116_project_clients_table', 1),
('2017_04_18_072702_category_table', 1),
('2017_04_18_073142_category_sort_table', 1),
('2017_04_18_085151_users_table', 1),
('2017_04_18_090421_manufacturers_table', 1),
('2017_04_18_091206_device_table', 1),
('2017_04_24_060934_create_device_custom_field', 1),
('2017_04_24_070909_create_client_custom_field', 1),
('2017_04_24_083017_create_client_price', 1),
('2017_04_24_090330_create_device_features', 1),
('2017_04_24_092121_create_orders_table', 1),
('2017_04_24_093502_create_schedule_table', 1),
('2017_04_25_050607_create_survey_table', 1),
('2017_04_25_052220_survey_answer', 1),
('2017_04_25_053203_add_delta_field_client_price_table', 1),
('2017_04_25_061853_create_scorecard_table', 1),
('2017_04_25_062158_create_scorecard_image_table', 1),
('2017_04_25_064834_create_custom_contact_inofrmation_table', 1),
('2017_04_25_070328_add_rep_user_field_user_table', 1),
('2017_04_25_071756_create_rep_case_details_table', 1),
('2017_04_25_084500_create_item_files_table', 1),
('2017_04_25_085011_create_item_file_details_table', 1),
('2017_04_25_085500_create_item_file_entry_table', 1),
('2017_04_26_090241_add_deviceid_survey', 1),
('2017_04_26_090259_add_deviceid_surveyanswer', 1),
('2017_04_26_100951_create_user_clients_table', 1),
('2017_04_26_101710_create_user_projects_table', 1),
('2017_05_02_100902_repContactInfo', 1),
('2017_05_06_091303_addFlagSurveyAnswer', 1),
('2017_05_08_114103_drop_monthid_scorecard', 1),
('2017_05_08_114130_month_table', 1),
('2017_05_08_115625_add_monthId_scorecard', 1),
('2017_05_11_071625_remove_orderemail_clientPrice', 2),
('2017_05_11_071649_remove_repemail_device', 2),
('2017_05_11_094241_add_ccmail_contact_info', 2),
('2017_05_13_122132_add_clientId_device', 3),
('2017_05_20_105305_add_deviceId_order', 4),
('2017_05_30_090545_loginuser', 5);

-- --------------------------------------------------------

--
-- Table structure for table `month`
--

CREATE TABLE `month` (
  `id` int(10) UNSIGNED NOT NULL,
  `month` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `month`
--

INSERT INTO `month` (`id`, `month`, `created_at`, `updated_at`) VALUES
(1, 'January', '2017-05-23 13:16:36', '2017-05-23 13:16:36'),
(2, 'February', '2017-05-23 13:16:36', '2017-05-23 13:16:36'),
(3, 'March', '2017-05-23 13:16:36', '2017-05-23 13:16:36'),
(4, 'April', '2017-05-23 13:16:36', '2017-05-23 13:16:36'),
(5, 'May', '2017-05-23 13:16:36', '2017-05-23 13:16:36'),
(6, 'June', '2017-05-23 13:16:36', '2017-05-23 13:16:36'),
(7, 'July', '2017-05-23 13:16:36', '2017-05-23 13:16:36'),
(8, 'August', '2017-05-23 13:16:36', '2017-05-23 13:16:36'),
(9, 'September', '2017-05-23 13:16:36', '2017-05-23 13:16:36'),
(10, 'October', '2017-05-23 13:16:36', '2017-05-23 13:16:36'),
(11, 'November', '2017-05-23 13:16:36', '2017-05-23 13:16:36'),
(12, 'December', '2017-05-23 13:16:36', '2017-05-23 13:16:36');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `manufacturer_name` int(10) UNSIGNED NOT NULL,
  `model_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `unit_cost` double(8,2) NOT NULL,
  `system_cost` double(8,2) NOT NULL,
  `cco` double(8,2) NOT NULL,
  `reimbrusement` double(8,2) NOT NULL,
  `order_date` date NOT NULL,
  `orderby` int(10) UNSIGNED NOT NULL,
  `rep` int(10) UNSIGNED NOT NULL,
  `sent_to` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('New','Complete','Cancelled') COLLATE utf8_unicode_ci NOT NULL,
  `bulk_check` enum('True','False') COLLATE utf8_unicode_ci NOT NULL,
  `is_delete` int(11) NOT NULL,
  `is_archive` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `clientId` int(10) UNSIGNED NOT NULL,
  `deviceId` int(10) UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `manufacturer_name`, `model_name`, `model_no`, `unit_cost`, `system_cost`, `cco`, `reimbrusement`, `order_date`, `orderby`, `rep`, `sent_to`, `status`, `bulk_check`, `is_delete`, `is_archive`, `created_at`, `updated_at`, `clientId`, `deviceId`) VALUES
(63, 1, 'Versa VEDRO1', '7', 2136.00, 0.00, 0.00, 0.00, '2016-09-14', 94, 89, 'petern12583@yahoo.com', 'New', '', 0, 0, NULL, '2017-05-25 19:39:36', 0, NULL),
(64, 1, 'Viva CRT-D XTDF4', '28', 0.00, 22770.00, 0.00, 0.00, '2016-09-14', 94, 89, 'petern12583@yahoo.com', 'New', '', 0, 0, NULL, '2017-05-25 19:39:36', 0, NULL),
(69, 1, 'Quadra Assura NG', '34', 0.00, 21934.50, 0.00, 0.00, '2016-09-15', 94, 89, 'petern12583@yahoo.com', 'New', '', 0, 0, NULL, '2017-05-25 19:39:36', 0, 71),
(70, 0, 'Quadra Assura NG', '34', 14107.50, 0.00, 12.00, 0.00, '2016-09-15', 0, 89, 'petern12583@yahoo.com', 'New', '', 0, 0, NULL, '2017-05-25 19:39:36', 0, 71),
(71, 4, 'Allure Quad', '39', 490.00, 0.00, 0.00, 0.00, '2016-09-16', 95, 93, 'msr300789@gmail.com', 'New', '', 0, 0, NULL, '2017-05-25 19:39:36', 0, 76),
(73, 4, 'Allure Quad', '39', 0.00, 528.00, 0.00, 0.00, '2016-09-16', 95, 93, 'msr300789@gmail.com', 'New', '', 0, 0, NULL, '2017-05-25 19:39:36', 0, 76),
(74, 4, 'Allure Quad', '39', 490.00, 0.00, 0.00, 0.00, '2016-09-16', 95, 93, 'msr300789@gmail.com', 'Cancelled', '', 0, 0, NULL, '2017-05-25 19:39:36', 0, 76),
(75, 4, 'Allure Quad', '39', 0.00, 528.00, 0.00, 0.00, '2016-09-16', 95, 93, 'msr300789@gmail.com', 'Cancelled', '', 0, 0, NULL, '2017-05-25 19:39:36', 0, 76),
(76, 4, 'Allure Quad', '39', 8000.00, 0.00, 0.00, 0.00, '2016-09-16', 96, 93, 'manikk@gmail.com', 'Cancelled', '', 0, 0, NULL, '2017-05-25 19:39:36', 0, 76),
(77, 4, 'Allure Quad', '39', 0.00, 528.00, 0.00, 0.00, '2016-09-16', 95, 93, 'msr300789@gmail.com', 'Cancelled', '', 0, 0, NULL, '2017-05-25 19:39:36', 0, 76),
(78, 3, 'Valitude Quad  DF4', '36', 0.00, 9380.00, 0.00, 0.00, '2016-09-16', 95, 91, 'msr300789@gmail.com', 'Cancelled', '', 0, 0, NULL, '2017-05-25 19:39:36', 0, NULL),
(79, 4, 'Allure Quad', '39', 8000.00, 0.00, 0.00, 0.00, '2016-09-16', 96, 93, 'manikk@gmail.com', 'Cancelled', '', 0, 0, NULL, '2017-05-25 19:39:36', 0, 76),
(80, 4, 'Allure Quad', '39', 8000.00, 0.00, 0.00, 0.00, '2016-09-16', 96, 93, 'manikk@gmail.com', 'New', '', 0, 0, NULL, '2017-05-25 19:39:36', 0, 76),
(81, 1, 'Viva CRTP', '38', 0.00, 7650.00, 0.00, 0.00, '2016-09-16', 95, 89, 'msr300789@gmail.com', 'New', '', 0, 0, NULL, '2017-05-25 19:39:36', 0, 75),
(82, 1, 'Viva CRTP', '38', 0.00, 8500.00, 0.00, 0.00, '2016-09-16', 95, 89, 'msr300789@gmail.com', 'New', '', 0, 0, NULL, '2017-05-25 19:39:36', 0, 75),
(83, 1, 'Viva CRTP', '38', 0.00, 8500.00, 0.00, 0.00, '2016-09-16', 95, 89, 'msr300789@gmail.com', 'New', '', 0, 0, NULL, '2017-05-25 19:39:36', 0, 75),
(84, 4, 'Allure Quad', '39', 8000.00, 0.00, 0.00, 0.00, '2016-09-16', 96, 93, 'manikk@gmail.com', 'New', '', 0, 0, NULL, '2017-05-25 19:39:36', 0, 76),
(85, 1, 'Viva CRTP', '38', 0.00, 8500.00, 0.00, 0.00, '2016-09-16', 95, 89, 'msr300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:36', 0, 75),
(86, 1, 'Viva CRTP', '38', 0.00, 7650.00, 0.00, 0.00, '2016-09-16', 95, 89, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, 75),
(87, 1, 'Viva CRTP', '38', 0.00, 8500.00, 0.00, 0.00, '2016-09-16', 95, 89, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, 75),
(88, 1, 'Viva CRTP', '38', 6174.00, 0.00, 0.00, 0.00, '2016-09-16', 95, 89, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, 75),
(89, 1, 'Viva CRTP', '38', 6300.00, 0.00, 0.00, 0.00, '2016-09-16', 95, 89, 'msr300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:36', 0, 75),
(90, 1, 'Viva CRTP', '38', 6300.00, 0.00, 0.00, 0.00, '2016-09-16', 95, 89, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, 75),
(91, 1, 'Versa VEDRO1', '7', 2136.00, 0.00, 0.00, 0.00, '2016-09-16', 95, 89, 'msr300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:36', 0, NULL),
(92, 4, 'Allure Quad', '39', 8000.00, 0.00, 0.00, 0.00, '2016-09-16', 96, 93, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, 76),
(93, 1, 'Viva CRTP', '38', 0.00, 8500.00, 0.00, 0.00, '2016-09-16', 95, 89, 'msr300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:36', 0, 75),
(94, 4, 'Allure Quad', '39', 8000.00, 0.00, 0.00, 0.00, '2016-09-16', 96, 93, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:36', 0, 76),
(95, 1, 'Viva CRTP', '38', 0.00, 7650.00, 0.00, 0.00, '2016-09-16', 95, 89, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, 75),
(96, 12, 'Entrinsa CRTP', '37', 4800.00, 0.00, 0.00, 0.00, '2016-09-16', 96, 90, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, NULL),
(97, 1, 'Viva CRTP', '38', 0.00, 8500.00, 0.00, 0.00, '2016-09-16', 95, 89, 'msr300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:36', 0, 75),
(98, 4, 'Allure Quad', '39', 7840.00, 0.00, 0.00, 0.00, '2016-09-16', 96, 93, 'manikk@gmail.com', 'Cancelled', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, 76),
(99, 4, 'Allure Quad', '39', 490.00, 0.00, 0.00, 0.00, '2016-09-16', 95, 104, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, 76),
(100, 4, 'Allure Quad', '39', 0.00, 9200.00, 0.00, 0.00, '2016-09-18', 95, 101, 'msr300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:36', 0, 76),
(101, 4, 'Allure Quad', '39', 7840.00, 0.00, 0.00, 0.00, '2016-09-18', 95, 101, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, 76),
(102, 4, 'Allure Quad', '39', 7840.00, 0.00, 0.00, 0.00, '2016-09-18', 95, 101, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, 76),
(103, 4, 'Allure Quad', '39', 7840.00, 0.00, 0.00, 0.00, '2016-09-18', 95, 101, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, 76),
(104, 4, 'Allure Quad', '39', 0.00, 9200.00, 0.00, 0.00, '2016-09-18', 95, 101, 'msr300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:36', 0, 76),
(105, 4, 'Allure Quad', '39', 0.00, 9200.00, 0.00, 0.00, '2016-09-18', 95, 101, 'msr300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:36', 0, 76),
(106, 1, 'Viva CRTP', '38', 0.00, 7650.00, 0.00, 0.00, '2016-09-18', 95, 99, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, 75),
(107, 1, 'Viva CRTP', '38', 6174.00, 0.00, 6174.00, 0.00, '2016-09-18', 95, 99, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, 75),
(108, 1, 'Viva CRTP', '38', 6174.00, 0.00, 6174.00, 0.00, '2016-09-18', 95, 99, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, 75),
(109, 4, 'Allure Quad', '39', 7840.00, 0.00, 0.00, 0.00, '2016-09-18', 95, 101, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, 76),
(110, 1, 'Viva CRTP', '38', 6174.00, 0.00, 6174.00, 0.00, '2016-09-18', 95, 99, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, 75),
(111, 12, 'Entrinsa CRTP', '37', 4800.00, 0.00, 0.00, 0.00, '2016-09-18', 95, 102, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, NULL),
(112, 12, 'Entrinsa CRTP', '37', 0.00, 6720.00, 0.00, 0.00, '2016-09-18', 95, 102, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, NULL),
(113, 12, 'Entrinsa CRTP', '37', 0.00, 6720.00, 0.00, 0.00, '2016-09-18', 95, 102, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, NULL),
(114, 1, 'Viva CRTP', '38', 6174.00, 0.00, 6174.00, 0.00, '2016-09-18', 95, 99, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, 75),
(115, 1, 'Viva CRTP', '38', 6174.00, 0.00, 6174.00, 0.00, '2016-09-18', 95, 99, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, 75),
(116, 4, 'Allure Quad', '39', 8000.00, 0.00, 0.00, 0.00, '2016-09-18', 95, 101, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, 76),
(117, 12, 'Entrinsa CRTP', '37', 4800.00, 0.00, 0.00, 0.00, '2016-09-18', 95, 102, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, NULL),
(118, 4, 'Allure Quad', '39', 8000.00, 0.00, 0.00, 0.00, '2016-09-18', 95, 101, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, 76),
(119, 1, 'Viva CRTP', '38', 0.00, 7650.00, 0.00, 0.00, '2016-09-18', 95, 99, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, 75),
(120, 1, 'Viva CRTP', '38', 0.00, 7650.00, 0.00, 0.00, '2016-09-18', 95, 99, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, 75),
(121, 4, 'Allure Quad', '39', 0.00, 9200.00, 0.00, 0.00, '2016-09-18', 95, 101, 'msr300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:36', 0, 76),
(122, 12, 'Entrinsa CRTP', '37', 0.00, 6720.00, 0.00, 0.00, '2016-09-18', 95, 102, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, NULL),
(123, 12, 'Entrinsa CRTP', '37', 0.00, 6720.00, 0.00, 0.00, '2016-09-18', 95, 102, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, NULL),
(124, 12, 'Entrinsa CRTP', '37', 4800.00, 0.00, 0.00, 0.00, '2016-09-18', 95, 102, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, NULL),
(125, 1, 'Viva CRTP', '38', 0.00, 7650.00, 0.00, 0.00, '2016-09-18', 95, 99, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, 75),
(126, 1, 'Viva CRTP', '38', 0.00, 7650.00, 0.00, 0.00, '2016-09-18', 95, 99, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, 75),
(127, 12, 'Entrinsa CRTP', '37', 0.00, 6720.00, 0.00, 0.00, '2016-09-18', 95, 102, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, NULL),
(128, 4, 'Allure Quad', '39', 0.00, 528.00, 0.00, 0.00, '2016-09-18', 95, 101, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, 76),
(129, 12, 'Entrinsa CRTP', '37', 0.00, 6633.00, 0.00, 0.00, '2016-09-18', 95, 102, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, NULL),
(130, 4, 'Allure Quad', '39', 0.00, 528.00, 0.00, 0.00, '2016-09-18', 95, 101, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:36', 0, 76),
(131, 4, 'Allure Quad', '39', 490.00, 0.00, 450.00, 0.00, '2016-09-18', 95, 101, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 76),
(132, 4, 'Allure Quad', '39', 490.00, 0.00, 450.00, 0.00, '2016-09-18', 95, 104, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 76),
(133, 4, 'Allure Quad', '39', 490.00, 0.00, 450.00, 0.00, '2016-09-18', 95, 104, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 76),
(137, 1, 'Quadra Assura NG', '34', 0.00, 9800.00, 0.00, 0.00, '2016-09-22', 96, 89, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 71),
(138, 1, 'Quadra Assura NG', '34', 0.00, 9800.00, 0.00, 0.00, '2016-09-22', 96, 89, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 71),
(139, 1, 'Quadra Assura NG', '34', 0.00, 9800.00, 0.00, 0.00, '2016-09-22', 96, 89, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 71),
(140, 1, 'Quadra Assura NG', '34', 7020.00, 0.00, 0.00, 0.00, '2016-09-22', 96, 89, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 71),
(141, 1, 'Quadra Assura NG', '34', 7020.00, 0.00, 0.00, 0.00, '2016-09-22', 96, 89, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 71),
(142, 1, 'Quadra Assura NG', '34', 7020.00, 0.00, 0.00, 0.00, '2016-09-22', 96, 89, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 71),
(143, 12, 'Entrinsa CRTP', '37', 0.00, 7000.00, 0.00, 0.00, '2016-09-22', 96, 102, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, NULL),
(144, 12, 'Entrinsa CRTP', '37', 0.00, 7000.00, 0.00, 0.00, '2016-09-22', 96, 102, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, NULL),
(145, 1, 'Quadra Assura NG', '34', 7020.00, 0.00, 0.00, 0.00, '2016-09-22', 96, 89, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 71),
(146, 1, 'Quadra Assura NG', '34', 7020.00, 0.00, 0.00, 0.00, '2016-09-22', 96, 89, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 71),
(147, 1, 'Quadra Assura NG', '34', 7020.00, 0.00, 0.00, 0.00, '2016-09-22', 96, 89, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 71),
(148, 1, 'Quadra Assura NG', '34', 7020.00, 0.00, 0.00, 0.00, '2016-09-22', 96, 89, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 71),
(149, 12, 'Entrinsa CRTP', '37', 0.00, 7000.00, 0.00, 0.00, '2016-09-22', 96, 102, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, NULL),
(150, 1, 'Quadra Assura NG', '34', 7800.00, 0.00, 0.00, 0.00, '2016-09-22', 96, 89, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 71),
(151, 1, 'Quadra Assura NG', '34', 7800.00, 0.00, 0.00, 0.00, '2016-09-22', 96, 99, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 71),
(152, 1, 'Quadra Assura NG', '34', 7800.00, 0.00, 0.00, 0.00, '2016-09-22', 96, 99, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 71),
(153, 1, 'Quadra Assura NG', '34', 7800.00, 0.00, 0.00, 0.00, '2016-09-22', 96, 99, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 71),
(154, 1, 'Quadra Assura NG', '34', 7800.00, 0.00, 0.00, 0.00, '2016-09-22', 96, 99, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 71),
(155, 1, 'Quadra Assura NG', '34', 7800.00, 0.00, 0.00, 0.00, '2016-09-22', 96, 99, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 71),
(156, 12, 'Entrinsa CRTP', '37', 0.00, 7000.00, 0.00, 0.00, '2016-09-22', 96, 102, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, NULL),
(157, 12, 'Entrinsa CRTP', '37', 4800.00, 0.00, 0.00, 0.00, '2016-09-22', 96, 102, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, NULL),
(158, 12, 'Entrinsa CRTP', '37', 4800.00, 0.00, 0.00, 0.00, '2016-09-22', 96, 102, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, NULL),
(159, 1, 'Quadra Assura NG', '34', 7800.00, 0.00, 0.00, 0.00, '2016-09-22', 96, 99, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 71),
(160, 1, 'Quadra Assura NG', '34', 7800.00, 0.00, 0.00, 0.00, '2016-09-22', 96, 99, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 71),
(161, 12, 'Entrinsa CRTP', '37', 4800.00, 0.00, 0.00, 0.00, '2016-09-22', 96, 102, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, NULL),
(162, 12, 'Entrinsa CRTP', '37', 5000.00, 0.00, 0.00, 0.00, '2016-09-22', 96, 102, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, NULL),
(163, 12, 'Entrinsa CRTP', '37', 5000.00, 0.00, 0.00, 0.00, '2016-09-22', 96, 102, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, NULL),
(165, 1, 'Quadra Assura NG', '34', 0.00, 9800.00, 0.00, 0.00, '2016-09-22', 96, 99, 'manikk@gmail.com', 'New', 'False', 0, 1, NULL, '2017-05-25 19:39:37', 0, 71),
(172, 12, 'Entrensia DR-T', '8', 2025.00, 0.00, 1822.50, 0.00, '2016-09-24', 95, 90, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, NULL),
(173, 12, 'Entrensia DR-T', '8', 2025.00, 0.00, 1822.50, 0.00, '2016-09-24', 95, 90, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, NULL),
(174, 12, 'Entrensia DR-T', '8', 2025.00, 0.00, 1822.50, 0.00, '2016-09-24', 95, 90, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, NULL),
(175, 12, 'Itrevia DR-T', '22', 9000.00, 0.00, 7920.00, 0.00, '2016-09-24', 95, 90, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 59),
(176, 12, 'Itrevia DR-T', '22', 9000.00, 0.00, 7920.00, 0.00, '2016-09-24', 95, 90, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 59),
(177, 12, 'Itrevia DR-T', '22', 9000.00, 0.00, 7920.00, 0.00, '2016-09-24', 95, 90, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 59),
(178, 12, 'Itrevia DR-T', '22', 9000.00, 0.00, 7920.00, 0.00, '2016-09-24', 95, 90, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 59),
(179, 12, 'Itrevia DR-T', '22', 9000.00, 0.00, 7920.00, 0.00, '2016-09-24', 95, 90, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 59),
(180, 12, 'Entrensia DR-T', '8', 2025.00, 0.00, 1822.50, 0.00, '2016-09-24', 95, 90, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, NULL),
(181, 4, 'Allure Quad', '39', 8000.00, 0.00, 8000.00, 0.00, '2016-09-24', 96, 101, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 76),
(182, 12, 'Entrinsa CRTP', '37', 5000.00, 0.00, 0.00, 0.00, '2016-09-24', 96, 102, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, NULL),
(183, 1, 'Sensia SR ', 'SESR01', 0.00, 2120.28, 0.00, 0.00, '2016-09-24', 96, 99, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 39),
(184, 1, 'Sensia SR ', 'SESR01', 0.00, 2120.28, 0.00, 0.00, '2016-09-24', 96, 99, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 39),
(185, 1, 'Adapta SR', 'ADSR01', 0.00, 3145.00, 0.00, 0.00, '2016-09-25', 94, 99, 'petern12583@yahoo.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 83),
(186, 3, 'Inogen DR MINI', 'D013', 11700.00, 0.00, 11200.00, 0.00, '2016-09-27', 95, 100, 'msr300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 95),
(187, 12, 'Itrevia DR-T', '392412', 9450.00, 0.00, 8316.00, 0.00, '2016-09-27', 95, 102, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 59),
(188, 12, 'Itrevia DR-T', '392412', 9450.00, 0.00, 8316.00, 0.00, '2016-09-27', 95, 102, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 59),
(189, 12, 'Itrevia DR-T', '392412', 9450.00, 0.00, 8316.00, 0.00, '2016-09-27', 95, 102, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 59),
(190, 12, 'Itrevia DR', '392426', 0.00, 12600.00, 0.00, 0.00, '2016-09-27', 95, 102, 'msr300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 99),
(191, 1, 'Evera XT DR', 'DDBB1D1', 12285.00, 0.00, 0.00, 0.00, '2016-09-28', 95, 99, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 63),
(192, 12, 'Itrevia DR-T', '392412', 9450.00, 0.00, 8316.00, 0.00, '2016-09-28', 95, 102, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 59),
(193, 1, 'Evera XT DR', 'DDBB1D1', 12285.00, 0.00, 0.00, 0.00, '2016-09-28', 95, 99, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 63),
(194, 12, 'Iperia DR', '392423', 0.00, 12240.00, 0.00, 0.00, '2016-09-28', 94, 102, 'petern12583@yahoo.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 62),
(195, 12, 'Eluna DR-T', '394969', 3240.00, 0.00, 2916.00, 0.00, '2016-09-28', 94, 102, 'petern12583@yahoo.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 48),
(196, 1, 'Viva Quad XT', 'DTBA1Q1', 15876.00, 0.00, 0.00, 0.00, '2016-09-28', 94, 99, 'petern12583@yahoo.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 65),
(197, 1, 'Viva XT CRT-D ', 'DTBA1D1', 15876.00, 0.00, 0.00, 0.00, '2016-09-28', 94, 99, 'petern12583@yahoo.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 66),
(198, 3, 'Essentio DR', 'L111', 4150.00, 0.00, 0.00, 0.00, '2016-09-28', 94, 100, 'petern12583@yahoo.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 92),
(199, 12, 'ITREVIA HF', '393016', 12250.00, 0.00, 10412.50, 0.00, '2016-09-28', 94, 102, 'petern12583@yahoo.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 106),
(200, 3, 'Essentio DR', 'L111', 4150.00, 0.00, 0.00, 0.00, '2016-09-28', 94, 100, 'petern12583@yahoo.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 92),
(201, 1, 'Versa DR', 'VEDR01', 2136.00, 0.00, 0.00, 0.00, '2016-09-28', 94, 99, 'petern12583@yahoo.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 45),
(202, 12, 'Itrevia HF-T', '393014', 11250.00, 0.00, 9562.50, 0.00, '2016-09-28', 94, 102, 'petern12583@yahoo.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 64),
(203, 1, 'Viva Quad XT', 'DTBA1Q1', 17640.00, 0.00, 0.00, 0.00, '2016-09-28', 94, 99, 'petern12583@yahoo.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 65),
(204, 3, 'Inogen CRTD ', 'G146', 16560.00, 0.00, 15810.00, 0.00, '2016-09-28', 94, 100, 'petern12583@yahoo.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 105),
(205, 12, 'Entrinsa SR-T', '394936', 0.00, 1899.00, 0.00, 0.00, '2016-09-28', 94, 102, 'petern12583@yahoo.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, NULL),
(206, 3, 'Inogen CRTD ', 'G146', 16560.00, 0.00, 15810.00, 0.00, '2016-09-28', 94, 100, 'petern12583@yahoo.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 105),
(207, 3, 'Inogen CRTD ', 'G146', 16560.00, 0.00, 15810.00, 0.00, '2016-09-28', 94, 100, 'petern12583@yahoo.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 105),
(208, 12, 'Entrinsa CRTP', '394919', 0.00, 7370.00, 0.00, 0.00, '2016-09-28', 94, 102, 'petern12583@yahoo.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, NULL),
(209, 3, 'Inogen CRT DF4', 'G148', 0.00, 22200.00, 0.00, 0.00, '2016-09-28', 94, 100, 'petern12583@yahoo.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 68),
(210, 4, 'Ellipse NG', 'CD1411-36Q', 0.00, 11790.00, 0.00, 0.00, '2016-09-29', 94, 101, 'petern12583@yahoo.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 102),
(211, 3, 'Inogen DR MINI', 'D013', 11700.00, 0.00, 11200.00, 0.00, '2016-09-30', 95, 100, 'msr300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 95),
(212, 12, 'Iperia DR-T', '392409', 11000.00, 0.00, 10500.00, 0.00, '2016-09-30', 95, 102, 'msr300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 98),
(213, 4, 'Ellipse NextGen DR', 'CD2411-36Q', 0.00, 14822.50, 0.00, 0.00, '2016-09-30', 116, 101, 'daniel.lustgarten@uvmhealth.org', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 58),
(214, 4, 'Ellipse NG DR', 'CD2411-36C', 11295.00, 0.00, 0.00, 0.00, '2016-09-30', 96, 101, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 94),
(215, 1, 'Adapta DR', 'ADDR01', 3050.64, 0.00, 0.00, 0.00, '2016-09-30', 96, 99, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 49),
(216, 12, 'Itrevia DR', '392426', 0.00, 12600.00, 0.00, 0.00, '2016-09-30', 94, 102, 'petern12583@yahoo.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 99),
(217, 3, 'Inogen DR MINI', 'D013', 11700.00, 0.00, 11200.00, 0.00, '2016-10-01', 95, 100, 'msr300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 95),
(218, 12, 'Entrinsa DR-T', '394931', 2025.00, 0.00, 1822.50, 0.00, '2016-10-01', 95, 102, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, NULL),
(219, 12, 'Entrinsa CRTP', '394919', 5450.00, 0.00, 0.00, 0.00, '2016-10-01', 123, 102, 'dberger@stlukeshealth.org', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, NULL),
(220, 1, 'Adapta DR', 'ADDR01', 3050.64, 0.00, 0.00, 0.00, '2016-10-01', 96, 99, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 49),
(221, 4, 'Ellipse NG DR', 'CD2411-36C', 10165.50, 0.00, 0.00, 0.00, '2016-10-01', 94, 101, 'petern12583@yahoo.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 94),
(222, 4, 'Ellipse NG DR', 'CD2411-36C', 0.00, 14822.00, 0.00, 0.00, '2016-10-01', 96, 101, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 94),
(223, 4, 'AssurityDR-RF', 'PM2240', 3800.00, 0.00, 0.00, 0.00, '2016-10-01', 96, 101, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 93),
(224, 4, 'Ellipse NG', 'CD1411-36Q', 0.00, 11790.00, 0.00, 0.00, '2016-10-01', 94, 101, 'petern12583@yahoo.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 102),
(225, 12, 'Itrevia DR-T', '392412', 9450.00, 0.00, 8316.00, 0.00, '2016-10-02', 123, 102, 'dberger@stlukeshealth.org', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 59),
(226, 12, 'Itrevia DR', '392426', 0.00, 12600.00, 0.00, 0.00, '2016-10-03', 95, 102, 'msr300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 99),
(227, 4, 'Ellipse NextGen DR', 'CD2411-36Q', 0.00, 14822.50, 0.00, 0.00, '2016-10-03', 95, 101, 'msr300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 58),
(228, 12, 'Entrinsa DR-T', '394931', 2025.00, 0.00, 1822.50, 0.00, '2016-10-03', 95, 102, 'msr300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, NULL),
(229, 12, 'Iperia VR-T ', '393032', 0.00, 11556.00, 0.00, 0.00, '2016-10-03', 116, 102, 'daniel.lustgarten@uvmhealth.org', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 56),
(230, 12, 'Itrevia HF-T', '393014', 11250.00, 0.00, 9562.50, 0.00, '2016-10-05', 116, 102, 'daniel.lustgarten@uvmhealth.org', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 64),
(231, 1, 'Versa DR', 'VEDR01', 2136.00, 0.00, 0.00, 0.00, '2016-10-13', 117, 99, 'joseph.winget@uvmhealth.org', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 45),
(238, 12, 'Etrinsa DR-T', '394931', 0.00, 2493.00, 0.00, 0.00, '2016-10-18', 94, 102, 'petern12583@yahoo.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 46),
(239, 1, 'Adapta SR', 'ADSR01', 0.00, 3145.00, 0.00, 0.00, '2016-10-19', 94, 99, 'petern12583@yahoo.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 83),
(240, 12, 'Etrinsa DR-T', '394931', 0.00, 2493.00, 0.00, 0.00, '2016-10-24', 116, 102, 'daniel.lustgarten@uvmhealth.org', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 46),
(241, 12, 'Etrinsa DR-T', '394931', 0.00, 2493.00, 0.00, 0.00, '2016-10-26', 116, 102, 'daniel.lustgarten@uvmhealth.org', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 46),
(242, 12, 'Itrevia CRTD', '401662', 0.00, 15750.00, 0.00, 0.00, '2016-11-11', 94, 102, 'petern12583@yahoo.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 69),
(243, 1, 'Adapta SR', 'ADSR01', 2745.00, 0.00, 2745.00, 0.00, '2016-12-14', 96, 99, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 83),
(244, 3, 'Essentio SR', 'L110', 3700.00, 0.00, 3200.00, 0.00, '2017-02-05', 95, 100, 'msr300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 90),
(245, 12, 'Eluna SR', '394971', 3250.00, 0.00, 0.00, 0.00, '2017-02-05', 95, 102, 'msr300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 111),
(246, 3, 'Essentio SR', 'L110', 3700.00, 0.00, 3200.00, 0.00, '2017-02-05', 95, 100, 'msr300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 90),
(247, 3, 'Essentio SR', 'L110', 0.00, 4125.00, 0.00, 0.00, '2017-02-05', 95, 100, 'msr300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 90),
(248, 3, 'Essentio SR', 'L110', 0.00, 4125.00, 0.00, 0.00, '2017-02-05', 95, 100, 'msr300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 90),
(249, 3, 'Essentio SR', 'L110', 0.00, 4125.00, 0.00, 0.00, '2017-02-05', 95, 100, 'msr300789@gmail.com', 'Complete', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 90),
(250, 12, 'Eluna SR', '394971', 3250.00, 0.00, 0.00, 0.00, '2017-02-05', 95, 102, 'msr300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 111),
(254, 14, 'tersrvf', '635awdcx', 5000.00, 0.00, 0.00, 0.00, '2017-02-06', 136, 134, 't2u@gmail.com', 'Complete', 'False', 0, 1, NULL, '2017-05-25 19:39:37', 0, 139),
(255, 3, 'Inogen', 'D140', 0.00, 5400.00, 0.00, 0.00, '2017-02-07', 145, 100, 'tnp@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 103),
(256, 12, 'Itrevia', '393041', 10000.00, 0.00, 0.00, 0.00, '2017-02-07', 95, 102, 'msr300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 109),
(257, 12, 'Itrevia', '393041', 10000.00, 0.00, 0.00, 0.00, '2017-02-07', 95, 102, 'msr300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 109),
(260, 15, 'recx344', 'xcd33', 0.00, 9000.00, 0.00, 0.00, '2017-02-07', 150, 152, 'south@gmail.com', 'Complete', 'True', 0, 1, NULL, '2017-05-25 19:39:37', 0, 142),
(262, 12, 'Itrevia', '393041', 10000.00, 0.00, 0.00, 0.00, '2017-02-07', 95, 102, 'msr300789@gmail.com', 'Complete', 'False', 0, 1, NULL, '2017-05-25 19:39:37', 0, 109),
(263, 12, 'Itrevia', '393041', 10000.00, 0.00, 0.00, 0.00, '2017-02-20', 155, 102, 'srmkk300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 109),
(264, 0, 'Itrevia', '393041', 10000.00, 0.00, 0.00, 0.00, '2017-02-20', 0, 102, 'srmkk300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 109),
(265, 4, 'AssurityDR-RF', 'PM2240', 450.00, 0.00, 400.00, 0.00, '2017-02-21', 155, 101, 'srmkk300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 93),
(266, 1, 'Versa DR', 'VEDR01', 2136.00, 0.00, 0.00, 0.00, '2017-02-21', 155, 99, 'srmkk300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 45),
(267, 1, 'Versa DR', 'VEDR01', 2136.00, 0.00, 0.00, 0.00, '2017-02-21', 155, 99, 'srmkk300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 45),
(268, 4, 'AssurityDR-RF', 'PM2240', 450.00, 0.00, 400.00, 0.00, '2017-02-21', 155, 101, 'srmkk300789@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 93),
(269, 1, 'Versa DR', 'VEDR01', 2136.00, 0.00, 0.00, 0.00, '2017-02-22', 155, 99, 'srmkk300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 45),
(270, 1, 'Versa DR', 'VEDR01', 2136.00, 0.00, 0.00, 0.00, '2017-02-22', 159, 99, 'srmkk300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 45),
(271, 17, 'Device', 'de322', 5000.00, 0.00, 0.00, 0.00, '2017-02-25', 160, 161, 'srmkk300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 145),
(273, 17, 'Device', 'de322', 0.00, 6000.00, 0.00, 0.00, '2017-02-25', 160, 161, 'srmkk300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 145),
(274, 17, 'Device1', 'sd5452', 0.00, 7000.00, 0.00, 0.00, '2017-02-25', 160, 161, 'srmkk300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 146),
(276, 17, 'Device1', 'sd5452', 5400.00, 0.00, 5300.00, 0.00, '2017-02-25', 160, 161, 'srmkk300789@gmail.com', 'Complete', 'True', 0, 1, NULL, '2017-05-25 19:39:37', 0, 146),
(277, 4, 'AssurityDR-RF', 'PM2240', 3800.00, 0.00, 0.00, 0.00, '2017-03-09', 96, 101, 'manikk@gmail.com', 'Complete', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 93),
(278, 4, 'Assurity SR', 'PM1240', 0.00, 5000.00, 0.00, 0.00, '2017-05-10', 160, 101, 'srmkk300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 91),
(279, 12, 'Etrinsa DR-T', '394931', 2250.00, 0.00, 0.00, 0.00, '2017-05-11', 96, 102, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 46),
(280, 12, 'Etrinsa DR-T', '394931', 2250.00, 0.00, 0.00, 0.00, '2017-05-11', 96, 102, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 46),
(281, 12, 'Etrinsa DR-T', '394931', 2025.00, 0.00, 1822.50, 0.00, '2017-05-11', 96, 102, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 46),
(282, 12, 'Etrinsa DR-T', '394931', 2025.00, 0.00, 1822.50, 0.00, '2017-05-11', 96, 102, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 46),
(283, 1, 'Sensia SR ', 'SESR01', 1763.48, 0.00, 0.00, 0.00, '2017-05-11', 96, 162, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 39),
(284, 4, 'Assurity SR', 'PM1240', 4000.00, 0.00, 0.00, 0.00, '2017-05-12', 160, 101, 'srmkk300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 91),
(285, 4, 'Assurity SR', 'PM1240', 4000.00, 0.00, 0.00, 0.00, '2017-05-12', 160, 101, 'srmkk300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 91),
(286, 4, 'Assurity SR', 'PM1240', 4000.00, 0.00, 0.00, 0.00, '2017-05-12', 160, 101, 'srmkk300789@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 91),
(287, 19, 'Fam132WE', 'WE1234', 0.00, 0.00, 0.00, 0.00, '2017-05-12', 96, 0, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 153),
(288, 4, 'AssurityDR-RF', 'PM2240', 0.00, 0.00, 3.00, 0.00, '2017-05-12', 96, 101, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 93),
(289, 4, 'Assurity SR', 'PM1240', 0.00, 0.00, 0.00, 0.00, '2017-05-12', 96, 101, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 91),
(290, 4, 'Assurity SR', 'PM1240', 0.00, 0.00, 0.00, 0.00, '2017-05-12', 96, 101, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 91),
(291, 4, 'Assurity SR', 'PM1240', 0.00, 0.00, 0.00, 0.00, '2017-05-12', 96, 101, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 91),
(292, 4, 'Assurity SR', 'PM1240', 0.00, 0.00, 0.00, 0.00, '2017-05-12', 96, 101, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 91),
(293, 4, 'Assurity SR', 'PM1240', 0.00, 0.00, 0.00, 0.00, '2017-05-12', 96, 101, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 91),
(294, 12, 'Itrevia', '393041', 0.00, 0.00, 0.00, 0.00, '2017-05-12', 96, 102, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 109),
(295, 12, 'Itrevia', '393041', 0.00, 0.00, 0.00, 0.00, '2017-05-12', 96, 102, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 109),
(296, 4, 'Assurity SR', 'PM1240', 5000.00, 0.00, 0.00, 0.00, '2017-05-12', 96, 101, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 91),
(297, 1, 'Sensia SR ', 'SESR01', 1977.00, 0.00, 0.00, 0.00, '2017-05-12', 96, 162, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 39),
(298, 4, 'Assurity SR', 'PM1240', 5000.00, 0.00, 0.00, 0.00, '2017-05-12', 96, 101, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 91),
(299, 4, 'Assurity SR', 'PM1240', 0.00, 0.00, 0.00, 0.00, '2017-05-12', 96, 101, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 91),
(300, 12, 'Etrinsa SR-T', '394936', 1665.00, 0.00, 1498.50, 0.00, '2017-05-12', 96, 102, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 0, 40),
(301, 4, 'Assurity SR', 'PM1240', 0.00, 0.00, 0.00, 0.00, '2017-05-13', 96, 101, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 91),
(302, 4, 'Assurity SR', 'PM1240', 0.00, 0.00, 0.00, 0.00, '2017-05-13', 96, 101, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 91),
(303, 4, 'Assurity SR', 'PM1240', 0.00, 0.00, 0.00, 0.00, '2017-05-13', 96, 101, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 91),
(304, 4, 'Assurity SR', 'PM1240', 0.00, 0.00, 0.00, 0.00, '2017-05-13', 96, 101, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 91),
(305, 4, 'Assurity SR', 'PM1240', 0.00, 0.00, 0.00, 0.00, '2017-05-13', 96, 101, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 91),
(306, 4, 'Assurity SR', 'PM1240', 0.00, 0.00, 0.00, 0.00, '2017-05-13', 96, 101, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 91),
(307, 4, 'Assurity SR', 'PM1240', 0.00, 0.00, 0.00, 0.00, '2017-05-13', 96, 101, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 91),
(308, 4, 'Assurity SR', 'PM1240', 0.00, 0.00, 0.00, 0.00, '2017-05-13', 96, 101, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 91),
(309, 4, 'Assurity SR', 'PM1240', 0.00, 0.00, 0.00, 0.00, '2017-05-13', 96, 101, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 91),
(310, 4, 'Assurity SR', 'PM1240', 0.00, 0.00, 0.00, 0.00, '2017-05-13', 96, 101, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 91),
(311, 4, 'Assurity SR', 'PM1240', 0.00, 0.00, 0.00, 0.00, '2017-05-13', 96, 101, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 0, 91),
(312, 4, 'Assurity SR', 'PM1240', 0.00, 0.00, 10.00, 0.00, '2017-05-15', 96, 101, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 91),
(313, 12, 'Etrinsa SR-T', '394936', 1850.00, 0.00, 1665.00, 0.00, '2017-05-15', 96, 102, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 40),
(314, 12, 'Etrinsa SR-T', '394936', 1850.00, 0.00, 1665.00, 0.00, '2017-05-16', 96, 102, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 40),
(315, 3, 'Essentio SR', 'L110', 0.00, 0.00, 0.00, 0.00, '2017-05-16', 96, 100, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 15, 90),
(316, 3, 'Essentio SR', 'L110', 0.00, 0.00, 0.00, 0.00, '2017-05-16', 96, 100, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 15, 90),
(317, 12, 'Etrinsa SR-T', '394936', 1850.00, 0.00, 1665.00, 0.00, '2017-05-16', 96, 102, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 40),
(318, 1, 'Sensia SR ', 'SESR01', 0.00, 0.00, 0.00, 0.00, '2017-05-16', 96, 162, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 15, 39),
(319, 4, 'Assurity SR', 'PM1240', 0.00, 0.00, 10.00, 0.00, '2017-05-16', 96, 101, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 91),
(320, 4, 'Assurity SR', 'PM1240', 0.00, 0.00, 10.00, 0.00, '2017-05-16', 96, 101, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 91),
(321, 1, 'Sensia SR ', 'SESR01', 0.00, 0.00, 0.00, 0.00, '2017-05-16', 96, 162, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 15, 39),
(322, 12, 'Etrinsa SR-T', '394936', 1850.00, 0.00, 1665.00, 0.00, '2017-05-16', 96, 102, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 40),
(323, 12, 'Etrinsa SR-T', '394936', 1850.00, 0.00, 1665.00, 0.00, '2017-05-16', 96, 102, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 40),
(324, 12, 'Etrinsa SR-T', '394936', 1850.00, 0.00, 1665.00, 0.00, '2017-05-16', 96, 102, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 40),
(325, 12, 'Etrinsa SR-T', '394936', 1850.00, 0.00, 1665.00, 0.00, '2017-05-16', 96, 102, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 40),
(326, 12, 'Etrinsa SR-T', '394936', 1850.00, 0.00, 1665.00, 0.00, '2017-05-16', 96, 102, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 40),
(327, 4, 'Assurity SR', 'PM1240', 4500.00, 0.00, 4050.00, 0.00, '2017-05-16', 96, 101, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 91),
(328, 4, 'Assurity SR', 'PM1240', 4500.00, 0.00, 4050.00, 0.00, '2017-05-17', 96, 101, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 91),
(329, 4, 'Assurity SR', 'PM1240', 4500.00, 0.00, 4050.00, 0.00, '2017-05-17', 96, 101, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 91),
(330, 4, 'Assurity SR', 'PM1240', 4500.00, 0.00, 4050.00, 0.00, '2017-05-17', 96, 101, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 91),
(331, 4, 'Assurity SR', 'PM1240', 4500.00, 0.00, 4050.00, 0.00, '2017-05-17', 96, 101, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 91),
(332, 4, 'Assurity SR', 'PM1240', 5000.00, 0.00, 4500.00, 0.00, '2017-05-17', 96, 101, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 91),
(333, 4, 'Assurity SR', 'PM1240', 5000.00, 0.00, 4500.00, 0.00, '2017-05-17', 96, 101, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 91),
(334, 4, 'Assurity SR', 'PM1240', 5000.00, 0.00, 4500.00, 0.00, '2017-05-17', 96, 101, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 91),
(335, 4, 'Assurity SR', 'PM1240', 4500.00, 0.00, 4050.00, 0.00, '2017-05-18', 96, 101, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 91),
(336, 4, 'Assurity SR', 'PM1240', 4500.00, 0.00, 4050.00, 0.00, '2017-05-18', 96, 101, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 91),
(337, 12, 'Etrinsa SR-T', '394936', 1850.00, 0.00, 1665.00, 0.00, '2017-05-18', 96, 102, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 40),
(338, 4, 'Assurity SR', 'PM1240', 4500.00, 0.00, 4050.00, 0.00, '2017-05-18', 96, 101, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 91),
(339, 4, 'Assurity SR', 'PM1240', 4500.00, 0.00, 4050.00, 0.00, '2017-05-20', 96, 101, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 91),
(340, 4, 'Assurity SR', 'PM1240', 4500.00, 0.00, 4050.00, 0.00, '2017-05-20', 96, 101, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 91),
(341, 12, 'Etrinsa SR-T', '394936', 1665.00, 0.00, 1498.50, 0.00, '2017-05-20', 96, 102, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 40),
(342, 4, 'Assurity SR', 'PM1240', 2891.00, 0.00, 0.00, 0.00, '2017-05-20', 96, 101, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 16, 91),
(343, 12, 'Etrinsa SR-T', '394936', 1850.00, 0.00, 0.00, 0.00, '2017-05-20', 96, 102, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 16, 40),
(344, 1, 'Sensia SR ', 'SESR01', 0.00, 0.00, 0.00, 0.00, '2017-05-20', 96, 162, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 16, 39),
(345, 12, 'Etrinsa SR-T', '394936', 1665.00, 0.00, 1498.50, 0.00, '2017-05-20', 96, 102, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 40),
(346, 4, 'Assurity SR', 'PM1240', 4500.00, 0.00, 4050.00, 0.00, '2017-05-20', 96, 101, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 91),
(347, 1, 'Sensia SR ', 'SESR01', 0.00, 0.00, 0.00, 0.00, '2017-05-20', 96, 162, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 15, 39),
(348, 15, 'test23', 'temo23', 0.00, 0.00, 0.00, 0.00, '2017-05-20', 96, 152, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 33, 148),
(349, 0, 'First Device645', 'FD645', 5000.00, 0.00, 0.00, 0.00, '2017-05-20', 0, 0, 'manikk@gmail.com', 'New', 'False', 0, 0, NULL, '2017-05-25 19:39:37', 33, 151),
(351, 4, 'Assurity SR', 'PM1240', 5000.00, 0.00, 4500.00, 0.00, '2017-05-23', 96, 101, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 91),
(350, 4, 'AssurityDR-RF', 'PM2240', 450.00, 0.00, 400.00, 0.00, '2017-05-22', 96, 101, 'manikk@gmail.com', 'Cancelled', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 93),
(352, 4, 'Assurity SR', 'PM1240', 4500.00, 0.00, 4050.00, 0.00, '2017-05-23', 96, 101, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 91),
(353, 4, 'Assurity SR', 'PM1240', 4500.00, 0.00, 4050.00, 0.00, '2017-05-23', 96, 101, 'manikk@gmail.com', 'Complete', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 91),
(354, 4, 'Assurity SR', 'PM1240', 4500.00, 0.00, 4050.00, 0.00, '2017-05-23', 96, 101, 'manikk@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 91),
(355, 4, 'Assurity SR', 'PM1240', 4500.00, 0.00, 4050.00, 0.00, '2017-05-24', 104, 101, '300789msr@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 91),
(356, 12, 'Etrinsa SR-T', '394936', 1665.00, 0.00, 1498.50, 0.00, '2017-05-24', 104, 102, '300789msr@gmail.com', 'Complete', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 40),
(357, 12, 'Etrinsa SR-T', '394936', 1665.00, 0.00, 0.00, 0.00, '2017-05-25', 104, 102, '300789msr@gmail.com', 'Complete', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 16, 40),
(358, 4, 'Assurity SR', 'PM1240', 2601.90, 0.00, 0.00, 0.00, '2017-05-25', 104, 101, '300789msr@gmail.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 16, 91),
(359, 12, 'Etrinsa SR-T', '394936', 1665.00, 0.00, 0.00, 0.00, '2017-05-25', 183, 102, 'nash5725@outlook.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 16, 40),
(360, 4, 'Assurity SR', 'PM1240', 2601.90, 0.00, 0.00, 0.00, '2017-05-25', 183, 101, 'nash5725@outlook.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 16, 91),
(361, 12, 'Etrinsa SR-T', '394936', 1665.00, 0.00, 1498.50, 0.00, '2017-05-25', 183, 102, 'nash5725@outlook.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 40),
(362, 4, 'Assurity SR', 'PM1240', 4500.00, 0.00, 4050.00, 0.00, '2017-05-25', 183, 101, 'nash5725@outlook.com', 'New', 'True', 0, 0, NULL, '2017-05-25 19:39:37', 15, 91),
(363, 4, 'Assurity SR', 'PM1240', 4500.00, 0.00, 4050.00, 0.00, '2017-05-26', 184, 101, 'manikandakumar7@outlook.com', 'New', 'True', 0, 0, NULL, NULL, 15, 91);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_delete` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `project_name`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'Test Project', 0, '2017-05-09 20:30:41', '2017-05-09 20:30:41'),
(48, 'Cardiology', 0, NULL, NULL),
(28, 'Neuro', 0, NULL, NULL),
(29, 'Stents', 0, NULL, NULL),
(30, 'Trauma Ortho', 0, NULL, NULL),
(31, 'Ablation Cath', 0, NULL, NULL),
(32, 'Breast Implants', 0, NULL, NULL),
(34, 'Test Project1', 0, NULL, NULL),
(35, 'Test New Project', 0, NULL, NULL),
(36, 'Test One Pro', 0, NULL, NULL),
(37, 'prot', 0, NULL, NULL),
(42, 'Final Test', 0, NULL, NULL),
(45, 'Test Project', 0, NULL, NULL),
(46, 'Proje456', 0, NULL, NULL),
(50, 'New Proj', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `project_clients`
--

CREATE TABLE `project_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(10) UNSIGNED NOT NULL,
  `client_name` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `project_clients`
--

INSERT INTO `project_clients` (`id`, `project_id`, `client_name`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2017-05-09 20:30:41', '2017-05-09 20:30:41'),
(198, 28, 15, NULL, NULL),
(199, 28, 16, NULL, NULL),
(202, 34, 15, NULL, NULL),
(203, 34, 16, NULL, NULL),
(215, 35, 15, NULL, NULL),
(216, 35, 16, NULL, NULL),
(217, 35, 19, NULL, NULL),
(218, 35, 20, NULL, NULL),
(230, 37, 23, NULL, NULL),
(233, 30, 16, NULL, NULL),
(234, 32, 16, NULL, NULL),
(250, 36, 22, NULL, NULL),
(251, 36, 23, NULL, NULL),
(252, 36, 26, NULL, NULL),
(288, 48, 16, NULL, NULL),
(287, 48, 15, NULL, NULL),
(292, 50, 33, NULL, NULL),
(291, 50, 16, NULL, NULL),
(290, 50, 15, NULL, NULL),
(272, 45, 31, NULL, NULL),
(273, 29, 16, NULL, NULL),
(274, 42, 15, NULL, NULL),
(275, 42, 22, NULL, NULL),
(276, 42, 29, NULL, NULL),
(278, 46, 27, NULL, NULL),
(279, 46, 32, NULL, NULL),
(289, 48, 17, NULL, NULL),
(293, 50, 34, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rep_case_details`
--

CREATE TABLE `rep_case_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `caseId` int(11) NOT NULL,
  `procedureDate` date NOT NULL,
  `clientId` int(10) UNSIGNED NOT NULL,
  `physicianId` int(10) UNSIGNED NOT NULL,
  `categoryId` int(10) UNSIGNED NOT NULL,
  `manufacturerId` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rep_contact_info`
--

CREATE TABLE `rep_contact_info` (
  `id` int(10) UNSIGNED NOT NULL,
  `deviceId` int(10) UNSIGNED NOT NULL,
  `repId` int(10) UNSIGNED NOT NULL,
  `repStatus` enum('Yes','No') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rep_contact_info`
--

INSERT INTO `rep_contact_info` (`id`, `deviceId`, `repId`, `repStatus`, `created_at`, `updated_at`) VALUES
(1, 91, 101, 'Yes', '2017-05-10 15:37:56', '2017-05-10 15:37:56'),
(2, 91, 104, 'Yes', '2017-05-10 15:37:59', '2017-05-10 15:37:59'),
(3, 91, 105, 'Yes', '2017-05-10 15:38:02', '2017-05-10 15:38:02'),
(5, 91, 161, 'Yes', '2017-05-10 16:35:29', '2017-05-10 16:35:29'),
(6, 148, 94, 'Yes', '2017-05-11 15:58:31', '2017-05-11 15:58:31'),
(15, 148, 152, 'Yes', '2017-05-12 14:06:59', '2017-05-12 14:06:59'),
(8, 39, 174, 'Yes', '2017-05-11 19:57:38', '2017-05-11 19:57:38'),
(9, 39, 162, 'Yes', '2017-05-11 19:58:47', '2017-05-11 19:58:47'),
(22, 40, 102, 'Yes', '2017-05-12 16:53:07', '2017-05-12 16:53:07'),
(16, 150, 169, 'Yes', '2017-05-12 14:10:12', '2017-05-12 14:10:12'),
(17, 150, 176, 'Yes', '2017-05-12 14:10:56', '2017-05-12 14:10:56'),
(18, 150, 177, 'Yes', '2017-05-12 14:11:11', '2017-05-12 14:11:11'),
(19, 39, 127, 'Yes', '2017-05-12 15:35:27', '2017-05-12 15:35:27'),
(20, 39, 99, 'Yes', '2017-05-12 16:34:15', '2017-05-12 16:34:15'),
(23, 46, 102, 'Yes', '2017-05-12 17:25:28', '2017-05-12 17:25:28'),
(27, 152, 177, 'Yes', '2017-05-12 17:27:37', '2017-05-12 17:27:37'),
(26, 152, 169, 'Yes', '2017-05-12 17:27:26', '2017-05-12 17:27:26'),
(28, 153, 169, 'Yes', '2017-05-12 17:34:18', '2017-05-12 17:34:18'),
(29, 153, 176, 'Yes', '2017-05-12 17:36:47', '2017-05-12 17:36:47'),
(30, 91, 171, 'Yes', '2017-05-12 20:09:24', '2017-05-12 20:09:24'),
(31, 155, 101, 'Yes', '2017-05-12 22:03:18', '2017-05-12 22:03:18'),
(32, 155, 105, 'Yes', '2017-05-12 22:03:27', '2017-05-12 22:03:27'),
(33, 155, 104, 'Yes', '2017-05-12 22:03:27', '2017-05-12 22:03:27');

-- --------------------------------------------------------

--
-- Table structure for table `roll`
--

CREATE TABLE `roll` (
  `id` int(10) UNSIGNED NOT NULL,
  `roll_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_delete` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roll`
--

INSERT INTO `roll` (`id`, `roll_name`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'Master Admin', 0, '2017-05-09 19:59:46', '2017-05-09 19:59:46'),
(2, 'Administrator', 0, '2017-05-09 19:59:46', '2017-05-09 19:59:46'),
(3, 'Physician', 0, '2017-05-09 19:59:46', '2017-05-09 19:59:46'),
(4, 'Orders', 0, '2017-05-09 19:59:46', '2017-05-09 19:59:46'),
(5, 'Rep', 0, '2017-05-09 19:59:46', '2017-05-09 19:59:46');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_name` int(10) UNSIGNED NOT NULL,
  `client_name` int(10) UNSIGNED NOT NULL,
  `physician_name` int(10) UNSIGNED NOT NULL,
  `patient_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `manufacturer` int(10) UNSIGNED NOT NULL,
  `device_name` int(10) UNSIGNED NOT NULL,
  `model_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rep_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `event_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `start_time` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8_unicode_ci NOT NULL,
  `is_delete` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `project_name`, `client_name`, `physician_name`, `patient_id`, `manufacturer`, `device_name`, `model_no`, `rep_name`, `event_date`, `start_time`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 43, '1900', 2, 3, 'ITER7VRT', 'MKK1', '29-08-2016', '11:19 AM', 'Active', 1, NULL, NULL),
(2, 2, 1, 43, '9735', 2, 3, 'ITER7VRT', 'MKK1', '30-08-2016', '11:19 PM', 'Active', 1, NULL, NULL),
(3, 1, 1, 43, '2068', 1, 2, 'PRO124T', 'mkk2', '30-08-2016', '10:18 AM', 'Active', 1, NULL, NULL),
(4, 2, 2, 33, '1301', 2, 6, 'ITER7VR', 'MKK1', '30-08-2016', '11:18 PM', 'Active', 1, NULL, NULL),
(5, 2, 1, 43, '2966', 2, 3, 'ITER7VRT', 'MKK1', '31-08-2016', '12:0 PM', 'Active', 1, NULL, NULL),
(6, 2, 2, 33, '1678', 2, 3, 'ITER7VRT', 'MKK1', '30-08-2016', '8:16 PM', 'Active', 1, NULL, NULL),
(7, 1, 3, 36, '1460', 1, 2, 'PRO124T', 'mkk2', '30-08-2016', '11:28 AM', 'Active', 1, NULL, NULL),
(8, 3, 4, 42, '6648', 4, 4, 'GD245R', 'MKK4', '30-08-2016', '12:19 PM', 'Active', 1, NULL, NULL),
(9, 1, 2, 51, '5774', 1, 7, 'dfsgdfg', 'MKK3', '30-08-2016', '12:17 AM', 'Active', 1, NULL, NULL),
(10, 1, 2, 51, '9640', 3, 1, 'INOMI145', 'MKK3', '01-09-2016', '12:19 PM', 'Active', 1, NULL, NULL),
(11, 1, 2, 51, '8080', 3, 1, 'INOMI145', 'MKK30789', '04-09-2016', '12:18 AM', 'Active', 1, NULL, NULL),
(12, 1, 2, 54, '7522', 3, 1, 'INOMI145', 'MKK30789', '05-09-2016', '12:19 AM', 'Active', 1, NULL, NULL),
(13, 1, 1, 43, '2470', 1, 7, 'dfsgdfg', 'MKK3', '30-08-2016', '9:15 PM', 'Active', 1, NULL, NULL),
(14, 4, 5, 58, '8407', 3, 13, 'MA123D', 'SendM', '31-08-2016', '10:19 PM', 'Active', 1, NULL, NULL),
(15, 4, 5, 58, '1132', 3, 14, 'MD134D', 'SendM', '16-10-2016', '12:19 AM', 'Active', 1, NULL, NULL),
(16, 1, 1, 43, '9235', 1, 2, 'PRO124T', 'mkk2', '08-09-2016', '12:19 AM', 'Active', 1, NULL, NULL),
(17, 1, 3, 36, '8972', 2, 10, 'MO1', 'MKK3', '09-09-2016', '12:18 AM', 'Active', 1, NULL, NULL),
(18, 1, 3, 36, '2503', 2, 10, 'MO1', 'MKK3', '09-09-2016', '12:18 AM', 'Active', 1, NULL, NULL),
(19, 1, 2, 51, '3525', 3, 10, 'MO1', 'MKK30789', '31-08-2016', '12:18 AM', 'Active', 1, NULL, NULL),
(20, 1, 3, 36, '7268', 3, 8, 'ITER7V', 'MKK3', '15-09-2016', '10:18 AM', 'Active', 1, NULL, NULL),
(21, 2, 1, 32, '1594', 2, 3, 'ITER7VRT', 'MKK1', '31-08-2016', '11:16 AM', 'Active', 1, NULL, NULL),
(22, 1, 3, 36, '4778', 3, 8, 'ITER7V', 'MKK3', '08-09-2016', '9:17 AM', 'Active', 1, NULL, NULL),
(23, 4, 10, 71, '7525', 3, 13, 'MA123D', 'SendM', '22-09-2016', '10:0 AM', 'Active', 1, NULL, NULL),
(24, 23, 15, 95, '6196', 1, 45, '7', 'Evan Liberman', '30-09-2016', '12:25 PM', 'Active', 0, NULL, NULL),
(25, 23, 15, 95, '2086', 1, 45, '7', 'Evan Liberman', '30-09-2016', '12:25 PM', 'Active', 0, NULL, NULL),
(26, 23, 15, 95, '6433', 4, 55, '18', 'N Davies', '21-09-2016', '11:0 AM', 'Active', 0, NULL, NULL),
(27, 23, 15, 94, '2190', 3, 44, '6', 'William McQuown', '20-09-2016', '9:18 PM', 'Active', 0, NULL, NULL),
(28, 23, 16, 96, '9520', 3, 53, '15', 'William McQuown', '23-09-2016', '12:30 AM', 'Active', 0, NULL, NULL),
(29, 23, 15, 95, '8542', 4, 76, '39', 'manik', '29-09-2016', '12:19 AM', 'Active', 0, NULL, NULL),
(30, 23, 15, 95, '9638', 4, 76, '39', 'manik', '22-09-2016', '9:18 AM', 'Active', 0, NULL, NULL),
(31, 23, 15, 95, '2645', 4, 76, '39', 'manik', '22-09-2016', '12:16 AM', 'Active', 0, NULL, NULL),
(32, 23, 15, 95, '3011', 4, 76, '39', 'manik', '22-09-2016', '12:16 AM', 'Active', 0, NULL, NULL),
(33, 23, 15, 95, '1476', 4, 76, '39', 'manik', '29-09-2016', '10:19 AM', 'Active', 0, NULL, NULL),
(34, 23, 15, 95, '7942', 1, 75, '38', 'Joe Smith', '21-09-2016', '11:36 PM', 'Active', 0, NULL, NULL),
(35, 23, 15, 95, '3443', 4, 76, '39', 'manik', '28-09-2016', '10:19 AM', 'Active', 0, NULL, NULL),
(36, 23, 15, 95, '1498', 4, 76, '39', 'manik', '19-09-2016', '12:10 AM', 'Active', 0, NULL, NULL),
(37, 23, 15, 95, '9412', 4, 76, '39', 'manik', '01-10-2016', '10:15 PM', 'Active', 0, NULL, NULL),
(38, 23, 15, 95, '4271', 1, 78, '5076', 'Joe Smith', '21-09-2016', '10:17 AM', 'Active', 1, NULL, NULL),
(39, 23, 15, 95, '5426', 1, 78, '5076', 'Joe Smith', '21-09-2016', '11:18 PM', 'Active', 1, NULL, NULL),
(40, 23, 16, 96, '1584', 1, 75, '38', 'Joe Smith', '27-09-2016', '11:17 PM', 'Active', 0, NULL, NULL),
(41, 23, 15, 94, '7378', 4, 76, '39', 'manik', '20-02-2017', '12:15 AM', 'Active', 1, NULL, NULL),
(42, 23, 15, 95, '4708', 4, 76, '39', 'manik', '20-09-2016', '10:19 AM', 'Active', 1, NULL, NULL),
(43, 23, 15, 95, '5073', 4, 76, '39', 'manik', '20-09-2016', '1:1 PM', 'Active', 1, NULL, NULL),
(44, 23, 15, 95, '7572', 4, 76, '39', 'Sam Smith', '26-09-2016', '12:15 AM', 'Active', 1, NULL, NULL),
(45, 32, 17, 107, '4981', 13, 80, 'KU4562', 'Mani1', '24-09-2016', '10:10 AM', 'Active', 1, NULL, NULL),
(46, 36, 23, 136, '6346', 14, 139, '635awdcx', 'Test New Rep', '15-02-2017', '12:0 AM', 'Active', 1, NULL, NULL),
(47, 23, 15, 95, '6083', 1, 83, 'ADSR01', 'Joe Smith', '08-02-2017', '12:0 AM', 'Inactive', 1, NULL, NULL),
(48, 35, 15, 132, '2180', 1, 137, 'TD101', 'Joe Smith', '08-02-2017', '11:0 AM', 'Active', 1, NULL, NULL),
(49, 23, 15, 95, '3698', 3, 125, '4524', 'Bob Smith', '08-02-2017', '10:0 AM', 'Inactive', 1, NULL, NULL),
(50, 23, 15, 94, '4998', 12, 111, '394971', 'Ken Smith', '22-02-2017', '12:0 PM', 'Active', 0, NULL, NULL),
(51, 23, 15, 95, '8949', 12, 69, '401662', 'Ken Smith', '07-02-2017', '12:0 PM', 'Active', 1, NULL, NULL),
(52, 23, 15, 155, '4701', 3, 44, 'L310', 'Bob Smith', '22-02-2017', '12:0 PM', 'Active', 0, NULL, NULL),
(53, 23, 15, 94, '7012', 1, 78, '5076', 'Joe Smith', '22-02-2017', '8:16 AM', 'Active', 0, NULL, NULL),
(54, 23, 15, 94, '9070', 1, 78, '5076', 'Joe Smith', '22-02-2017', '8:16 AM', 'Active', 0, NULL, NULL),
(55, 23, 15, 159, '3946', 3, 57, 'D141', 'Bob Smith', '24-02-2017', '11:0 AM', 'Active', 0, NULL, NULL),
(56, 23, 15, 155, '2731', 3, 60, 'D012', 'Bob Smith', '22-02-2017', '12:15 PM', 'Active', 1, NULL, NULL),
(57, 23, 15, 159, '6585', 1, 45, 'VEDR01', 'Joe Smith', '24-02-2017', '12:0 AM', 'Active', 1, NULL, NULL),
(58, 45, 31, 160, '3214', 17, 145, 'de322', 'Test Rep', '25-02-2017', '12:0 PM', 'Active', 1, NULL, NULL),
(59, 48, 16, 96, '3876', 3, 53, 'D011', 'Bob Smith', '17-05-2017', '12:30 AM', 'Active', 0, NULL, NULL),
(60, 48, 16, 96, '8528', 3, 53, 'D011', 'Bob Smith', '17-05-2017', '12:30 AM', 'Active', 0, NULL, NULL),
(61, 47, 33, 85, '6561', 15, 147, 'FD1-235', 'Final Rep', '24-05-2017', '12:15 AM', 'Active', 0, NULL, NULL),
(62, 48, 15, 139, '9566', 1, 63, 'DDBB1D1', 'Meer', '31-05-2017', '8:17 PM', 'Active', 0, NULL, NULL),
(63, 42, 15, 65, '9364', 15, 140, 'werew3252', 'Final Rep', '13-05-2017', '11:17 AM', 'Active', 0, NULL, NULL),
(64, 47, 33, 190, '6066', 15, 147, 'FD1-235', 'Final Rep', '30-05-2017', '10:17 AM', 'Active', 0, NULL, NULL),
(65, 47, 33, 190, '5716', 15, 147, 'FD1-235', 'Final Rep', '30-05-2017', '10:17 AM', 'Active', 0, NULL, NULL),
(66, 47, 33, 85, '2748', 15, 147, 'FD1-235', 'Final Rep', '24-05-2017', '11:18 AM', 'Active', 0, NULL, NULL),
(67, 47, 33, 85, '4687', 15, 147, 'FD1-235', 'Final Rep', '24-05-2017', '10:15 AM', 'Active', 0, NULL, NULL),
(68, 48, 16, 140, '1489', 3, 47, 'L321', 'Bob Smith', '16-05-2017', '12:15 AM', 'Active', 0, NULL, NULL),
(69, 48, 15, 96, '2734', 12, 40, '394936', 'Ken Smith', '18-05-2017', '9:15 AM', 'Active', 0, NULL, NULL),
(70, 48, 15, 139, '3558', 12, 40, '394936', 'Ken Smith', '17-05-2017', '0:0 AM', 'Active', 0, NULL, NULL),
(71, 48, 15, 96, '9751', 12, 40, '394936', 'Ken Smith', '17-05-2017', '0:0 AM', 'Active', 0, NULL, NULL),
(72, 48, 15, 96, '9585', 12, 40, '394936', 'Ken Smith', '17-05-2017', '0:0 AM', 'Active', 0, NULL, NULL),
(73, 48, 15, 96, '4804', 12, 40, '394936', 'Ken Smith', '24-05-2017', '12:16 PM', 'Active', 0, NULL, NULL),
(74, 48, 15, 96, '5334', 12, 40, '394936', 'Ken Smith', '25-05-2017', '0:0 AM', 'Active', 0, NULL, NULL),
(75, 48, 15, 96, '3579', 12, 40, '394936', 'Ken Smith', '25-05-2017', '0:0 AM', 'Active', 0, NULL, NULL),
(76, 48, 15, 96, '7867', 12, 40, '394936', 'Ken Smith', '24-05-2017', '12:0 AM', 'Active', 0, NULL, NULL),
(77, 48, 15, 96, '3668', 12, 40, '394936', 'Ken Smith', '24-05-2017', '11:0 AM', 'Active', 0, NULL, NULL),
(78, 48, 15, 96, '6853', 4, 91, 'PM1240', 'Sam Smith', '19-05-2017', '11:10 AM', 'Active', 0, NULL, NULL),
(79, 48, 15, 96, '3513', 4, 91, 'PM1240', 'Sam Smith', '25-05-2017', '12:15 AM', 'Active', 0, NULL, NULL),
(80, 48, 15, 96, '9989', 4, 91, 'PM1240', 'Sam Smith', '25-05-2017', '12:15 AM', 'Active', 0, NULL, NULL),
(81, 48, 15, 96, '3515', 4, 91, 'PM1240', 'Sam Smith', '25-05-2017', '12:0 PM', 'Active', 0, NULL, NULL),
(82, 48, 15, 139, '4015', 4, 91, 'PM1240', 'Sam Smith', '25-05-2017', '12:0 PM', 'Active', 0, NULL, NULL),
(83, 48, 16, 140, '4473', 4, 93, 'PM2240', 'Sam Smith', '25-05-2017', '12:15 PM', 'Active', 0, NULL, NULL),
(84, 48, 15, 96, '7898', 4, 91, 'PM1240', 'Sam Smith', '28-05-2017', '8:8 AM', 'Active', 0, NULL, NULL),
(85, 48, 15, 139, '6501', 4, 93, 'PM2240', 'Sam Smith', '31-05-2017', '12:12 PM', 'Active', 0, NULL, NULL),
(86, 48, 15, 104, '8668', 4, 91, 'PM1240', 'Sam Smith', '30-05-2017', '8:30 PM', 'Active', 0, NULL, NULL),
(87, 48, 16, 140, '5238', 1, 55, 'DVFB1D4', 'Meer', '25-05-2017', '11:17 PM', 'Active', 0, NULL, NULL),
(88, 48, 15, 104, '2082', 12, 40, '394936', 'Ken Smith', '31-05-2017', '0:0 AM', 'Active', 0, NULL, NULL),
(89, 48, 16, 140, '8420', 1, 55, 'DVFB1D4', 'Meer', '25-05-2017', '11:17 PM', 'Active', 0, NULL, NULL),
(90, 48, 16, 140, '1553', 1, 55, 'DVFB1D4', 'Meer', '25-05-2017', '11:17 PM', 'Active', 0, NULL, NULL),
(91, 48, 16, 140, '1749', 1, 55, 'DVFB1D4', 'Meer', '25-05-2017', '7:17 PM', 'Active', 0, NULL, NULL),
(92, 48, 15, 104, '5245', 12, 40, '394936', 'Ken Smith', '24-05-2017', '0:0 AM', 'Active', 0, NULL, NULL),
(93, 48, 15, 363, '8056', 12, 40, '394936', 'Ken Smith', '24-05-2017', '0:0 AM', 'Active', 0, NULL, NULL),
(94, 48, 15, 182, '3805', 12, 40, '394936', 'Ken Smith', '28-05-2017', '12:15 PM', 'Active', 0, NULL, NULL),
(95, 48, 15, 96, '5843', 4, 76, 'PM3562', 'Sam Smith', '26-05-2017', '12:15 AM', 'Active', 0, NULL, NULL),
(96, 48, 16, 104, '7528', 3, 51, '13', 'Bob Smith', '25-05-2017', '6:16 PM', 'Active', 0, NULL, NULL),
(97, 48, 16, 104, '1547', 3, 51, '13', 'Bob Smith', '25-05-2017', '6:16 PM', 'Active', 0, NULL, NULL),
(98, 48, 16, 104, '8753', 3, 51, '13', 'Bob Smith', '25-05-2017', '6:16 PM', 'Active', 0, NULL, NULL),
(99, 48, 16, 104, '9377', 3, 51, '13', 'Bob Smith', '25-05-2017', '6:16 PM', 'Active', 0, NULL, NULL),
(100, 48, 16, 104, '2447', 3, 51, '13', 'Bob Smith', '25-05-2017', '6:16 PM', 'Active', 0, NULL, NULL),
(101, 48, 15, 104, '9818', 4, 58, 'CD2411-36Q', 'Sam Smith', '25-05-2017', '9:15 PM', 'Active', 0, NULL, NULL),
(102, 48, 15, 104, '7489', 4, 58, 'CD2411-36Q', 'Sam Smith', '25-05-2017', '9:15 PM', 'Active', 0, NULL, NULL),
(103, 45, 31, 160, '1809', 17, 145, 'de322', 'Test Rep', '28-05-2017', '11:16 AM', 'Active', 0, NULL, NULL),
(104, 48, 15, 104, '5130', 12, 40, '394936', 'Ken Smith', '29-05-2017', '8:0 PM', 'Active', 0, NULL, NULL),
(105, 48, 15, 96, '9152', 4, 91, 'PM1240', 'Sam Smith', '27-05-2017', '8:15 AM', 'Active', 0, NULL, NULL),
(106, 48, 15, 104, '8424', 12, 40, '394936', 'Ken Smith', '25-05-2017', '0:0 AM', 'Active', 0, NULL, NULL),
(107, 48, 15, 104, '6727', 12, 40, '394936', 'Ken Smith', '27-05-2017', '12:30 PM', 'Active', 0, NULL, NULL),
(108, 48, 15, 104, '4975', 4, 91, 'PM1240', 'Sam Smith', '27-05-2017', '12:30 PM', 'Active', 0, NULL, NULL),
(109, 48, 15, 183, '6953', 4, 91, 'PM1240', 'Sam Smith', '26-05-2017', '12:30 PM', 'Active', 0, NULL, NULL),
(110, 48, 15, 183, '4351', 12, 40, '394936', 'Ken Smith', '31-05-2017', '8:15 AM', 'Active', 0, NULL, NULL),
(111, 48, 16, 183, '4135', 4, 91, 'PM1240', 'Sam Smith', '27-05-2017', '10:10 AM', 'Active', 0, NULL, NULL),
(112, 48, 15, 139, '8428', 4, 91, 'PM1240', 'Sam Smith', '31-05-2017', '9:0 AM', 'Active', 0, NULL, NULL),
(113, 48, 15, 96, '3097', 4, 91, 'PM1240', 'Sam Smith', '30-05-2017', '11:0 AM', 'Active', 0, NULL, NULL),
(114, 48, 15, 96, '5424', 4, 91, 'PM1240', 'Sam Smith', '30-05-2017', '12:15 PM', 'Active', 0, NULL, NULL),
(115, 48, 15, 104, '6512', 4, 76, 'PM3562', 'Sam Smith', '31-05-2017', '12:17 PM', 'Active', 0, NULL, NULL),
(116, 48, 15, 184, '8925', 4, 91, 'PM1240', 'Sam Smith', '28-05-2017', '12:30 PM', 'Active', 0, NULL, NULL),
(117, 48, 15, 184, '8549', 4, 91, 'PM1240', 'Sam Smith', '31-05-2017', '10:10 AM', 'Active', 0, NULL, NULL),
(118, 48, 16, 104, '4385', 4, 91, 'PM1240', 'Sam Smith', '28-05-2017', '10:10 AM', 'Active', 0, NULL, NULL),
(119, 48, 15, 104, '5434', 4, 91, 'PM1240', 'Sam Smith', '30-05-2017', '10:15 AM', 'Active', 0, NULL, NULL),
(120, 48, 15, 184, '2191', 4, 91, 'PM1240', 'Sam Smith', '02-06-2017', '12:10 PM', 'Active', 0, NULL, NULL),
(121, 48, 16, 104, '9478', 3, 60, 'D012', 'Bob Smith', '30-05-2017', '10:17 PM', 'Active', 0, NULL, NULL),
(122, 48, 15, 184, '6420', 4, 91, 'PM1240', 'Sam Smith', '03-06-2017', '10:10 AM', 'Active', 0, NULL, NULL),
(123, 48, 15, 184, '7512', 4, 91, 'PM1240', 'Sam Smith', '30-05-2017', '12:17 PM', 'Active', 0, NULL, NULL),
(124, 48, 15, 184, '8296', 4, 91, 'PM1240', 'Sam Smith', '31-05-2017', '12:19 PM', 'Active', 0, NULL, NULL),
(125, 48, 16, 104, '3530', 4, 91, 'PM1240', 'Sam Smith', '08-06-2017', '12:17 PM', 'Active', 0, NULL, NULL),
(126, 48, 15, 184, '3594', 4, 91, 'PM1240', 'Sam Smith', '01-06-2017', '11:18 AM', 'Active', 0, NULL, NULL),
(127, 48, 15, 184, '7225', 4, 91, 'PM1240', 'Sam Smith', '01-06-2017', '11:18 AM', 'Active', 0, NULL, NULL),
(128, 48, 15, 184, '9140', 4, 91, 'PM1240', 'Sam Smith', '30-06-2017', '12:18 PM', 'Active', 0, NULL, NULL),
(129, 48, 15, 96, '6563', 4, 91, 'PM1240', 'Sam Smith', '29-06-2017', '12:17 PM', 'Active', 0, NULL, NULL),
(130, 48, 15, 96, '2190', 4, 91, 'PM1240', 'Sam Smith', '29-06-2017', '12:17 PM', 'Active', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `scorecards`
--

CREATE TABLE `scorecards` (
  `id` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `year` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `monthId` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `scorecards`
--

INSERT INTO `scorecards` (`id`, `userId`, `year`, `created_at`, `updated_at`, `monthId`) VALUES
(1, 96, 2017, '2017-05-23 13:17:07', '2017-05-23 13:17:07', 4),
(4, 96, 2017, '2017-05-25 12:14:36', '2017-05-25 12:14:36', 1),
(6, 96, 2017, '2017-05-25 12:26:15', '2017-05-25 12:26:15', 2),
(7, 182, 2017, '2017-05-25 12:29:42', '2017-05-25 12:29:42', 1),
(8, 182, 2017, '2017-05-25 12:30:17', '2017-05-25 12:31:00', 2),
(9, 183, 2017, '2017-05-25 21:30:53', '2017-05-25 21:30:53', 1),
(10, 183, 2017, '2017-05-25 21:31:48', '2017-05-25 21:31:48', 2),
(11, 183, 2017, '2017-05-25 21:32:25', '2017-05-25 21:32:25', 3),
(13, 184, 2017, '2017-05-26 16:15:33', '2017-05-26 16:19:50', 1),
(15, 184, 2016, '2017-05-26 19:34:29', '2017-05-26 20:16:53', 2);

-- --------------------------------------------------------

--
-- Table structure for table `scorecard_images`
--

CREATE TABLE `scorecard_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `scorecardId` int(10) UNSIGNED NOT NULL,
  `scorecardImage` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `scorecard_images`
--

INSERT INTO `scorecard_images` (`id`, `scorecardId`, `scorecardImage`, `created_at`, `updated_at`) VALUES
(1, 1, 'upload/scorecard/scorecard_1806.jpg', '2017-05-23 13:17:07', '2017-05-23 13:17:07'),
(2, 1, 'upload/scorecard/scorecard_5708.JPG', '2017-05-23 13:17:07', '2017-05-23 13:17:07'),
(3, 1, 'upload/scorecard/scorecard_8687.png', '2017-05-23 13:17:07', '2017-05-23 13:17:07'),
(4, 1, 'upload/scorecard/scorecard_5923.gif', '2017-05-23 13:17:07', '2017-05-23 13:17:07'),
(30, 4, 'upload/scorecard/scorecard_1987.jpg', '2017-05-25 12:14:36', '2017-05-25 12:14:36'),
(29, 4, 'upload/scorecard/scorecard_5140.png', '2017-05-25 12:14:36', '2017-05-25 12:14:36'),
(24, 3, 'upload/scorecard/scorecard_6017.jpg', '2017-05-23 20:15:34', '2017-05-23 20:15:34'),
(23, 3, 'upload/scorecard/scorecard_4508.png', '2017-05-23 20:15:34', '2017-05-23 20:15:34'),
(22, 3, 'upload/scorecard/scorecard_4278.jpg', '2017-05-23 20:15:34', '2017-05-23 20:15:34'),
(21, 3, 'upload/scorecard/scorecard_4393.png', '2017-05-23 20:15:34', '2017-05-23 20:15:34'),
(34, 5, 'upload/scorecard/scorecard_9593.jpg', '2017-05-25 12:19:38', '2017-05-25 12:19:38'),
(27, 4, 'upload/scorecard/scorecard_3637.jpg', '2017-05-25 12:14:36', '2017-05-25 12:14:36'),
(28, 4, 'upload/scorecard/scorecard_9155.jpg', '2017-05-25 12:14:36', '2017-05-25 12:14:36'),
(31, 4, 'upload/scorecard/scorecard_1648.png', '2017-05-25 12:14:36', '2017-05-25 12:14:36'),
(32, 4, 'upload/scorecard/scorecard_4998.jpg', '2017-05-25 12:14:36', '2017-05-25 12:14:36'),
(33, 4, 'upload/scorecard/scorecard_9449.png', '2017-05-25 12:14:36', '2017-05-25 12:14:36'),
(35, 5, 'upload/scorecard/scorecard_2886.jpg', '2017-05-25 12:19:38', '2017-05-25 12:19:38'),
(43, 5, 'upload/scorecard/scorecard_1950.png', '2017-05-25 12:20:24', '2017-05-25 12:20:24'),
(37, 5, 'upload/scorecard/scorecard_8415.png', '2017-05-25 12:19:38', '2017-05-25 12:19:38'),
(42, 5, 'upload/scorecard/scorecard_3272.jpg', '2017-05-25 12:20:24', '2017-05-25 12:20:24'),
(39, 5, 'upload/scorecard/scorecard_9976.png', '2017-05-25 12:19:38', '2017-05-25 12:19:38'),
(40, 5, 'upload/scorecard/scorecard_8775.jpg', '2017-05-25 12:19:38', '2017-05-25 12:19:38'),
(41, 5, 'upload/scorecard/scorecard_818.png', '2017-05-25 12:19:38', '2017-05-25 12:19:38'),
(44, 5, 'upload/scorecard/scorecard_1820.jpg', '2017-05-25 12:20:24', '2017-05-25 12:20:24'),
(53, 7, 'upload/scorecard/scorecard_5738.jpg', '2017-05-25 12:29:42', '2017-05-25 12:29:42'),
(46, 6, 'upload/scorecard/scorecard_2092.jpg', '2017-05-25 12:26:15', '2017-05-25 12:26:15'),
(47, 6, 'upload/scorecard/scorecard_5213.jpg', '2017-05-25 12:26:15', '2017-05-25 12:26:15'),
(48, 6, 'upload/scorecard/scorecard_4266.png', '2017-05-25 12:26:15', '2017-05-25 12:26:15'),
(49, 6, 'upload/scorecard/scorecard_2698.jpg', '2017-05-25 12:26:15', '2017-05-25 12:26:15'),
(50, 6, 'upload/scorecard/scorecard_3956.png', '2017-05-25 12:26:15', '2017-05-25 12:26:15'),
(51, 6, 'upload/scorecard/scorecard_9701.jpg', '2017-05-25 12:26:15', '2017-05-25 12:26:15'),
(52, 6, 'upload/scorecard/scorecard_5590.png', '2017-05-25 12:26:15', '2017-05-25 12:26:15'),
(54, 7, 'upload/scorecard/scorecard_8457.jpg', '2017-05-25 12:29:42', '2017-05-25 12:29:42'),
(55, 7, 'upload/scorecard/scorecard_1050.jpg', '2017-05-25 12:29:42', '2017-05-25 12:29:42'),
(56, 7, 'upload/scorecard/scorecard_4859.png', '2017-05-25 12:29:42', '2017-05-25 12:29:42'),
(57, 7, 'upload/scorecard/scorecard_555.jpg', '2017-05-25 12:29:42', '2017-05-25 12:29:42'),
(58, 7, 'upload/scorecard/scorecard_9831.png', '2017-05-25 12:29:42', '2017-05-25 12:29:42'),
(59, 7, 'upload/scorecard/scorecard_8109.jpg', '2017-05-25 12:29:42', '2017-05-25 12:29:42'),
(60, 7, 'upload/scorecard/scorecard_515.png', '2017-05-25 12:29:42', '2017-05-25 12:29:42'),
(61, 8, 'upload/scorecard/scorecard_8413.jpg', '2017-05-25 12:30:17', '2017-05-25 12:30:17'),
(62, 8, 'upload/scorecard/scorecard_4574.jpg', '2017-05-25 12:30:17', '2017-05-25 12:30:17'),
(63, 8, 'upload/scorecard/scorecard_9349.jpg', '2017-05-25 12:30:17', '2017-05-25 12:30:17'),
(64, 8, 'upload/scorecard/scorecard_4451.png', '2017-05-25 12:30:17', '2017-05-25 12:30:17'),
(65, 8, 'upload/scorecard/scorecard_5181.jpg', '2017-05-25 12:30:17', '2017-05-25 12:30:17'),
(66, 8, 'upload/scorecard/scorecard_4288.png', '2017-05-25 12:30:17', '2017-05-25 12:30:17'),
(67, 8, 'upload/scorecard/scorecard_8309.jpg', '2017-05-25 12:30:17', '2017-05-25 12:30:17'),
(68, 8, 'upload/scorecard/scorecard_7967.png', '2017-05-25 12:30:17', '2017-05-25 12:30:17'),
(69, 8, 'upload/scorecard/scorecard_6566.png', '2017-05-25 12:31:00', '2017-05-25 12:31:00'),
(70, 8, 'upload/scorecard/scorecard_9965.jpg', '2017-05-25 12:31:00', '2017-05-25 12:31:00'),
(71, 8, 'upload/scorecard/scorecard_2981.png', '2017-05-25 12:31:00', '2017-05-25 12:31:00'),
(72, 9, 'upload/scorecard/scorecard_5406.jpg', '2017-05-25 21:30:53', '2017-05-25 21:30:53'),
(73, 9, 'upload/scorecard/scorecard_134.jpg', '2017-05-25 21:30:53', '2017-05-25 21:30:53'),
(74, 9, 'upload/scorecard/scorecard_7211.jpg', '2017-05-25 21:30:53', '2017-05-25 21:30:53'),
(75, 9, 'upload/scorecard/scorecard_1314.png', '2017-05-25 21:30:53', '2017-05-25 21:30:53'),
(76, 9, 'upload/scorecard/scorecard_601.jpg', '2017-05-25 21:30:53', '2017-05-25 21:30:53'),
(77, 9, 'upload/scorecard/scorecard_9576.png', '2017-05-25 21:30:53', '2017-05-25 21:30:53'),
(78, 9, 'upload/scorecard/scorecard_562.jpg', '2017-05-25 21:30:53', '2017-05-25 21:30:53'),
(79, 9, 'upload/scorecard/scorecard_8667.png', '2017-05-25 21:30:53', '2017-05-25 21:30:53'),
(80, 10, 'upload/scorecard/scorecard_3874.jpg', '2017-05-25 21:31:48', '2017-05-25 21:31:48'),
(81, 10, 'upload/scorecard/scorecard_7866.jpg', '2017-05-25 21:31:48', '2017-05-25 21:31:48'),
(82, 10, 'upload/scorecard/scorecard_2635.jpg', '2017-05-25 21:31:48', '2017-05-25 21:31:48'),
(83, 10, 'upload/scorecard/scorecard_633.png', '2017-05-25 21:31:48', '2017-05-25 21:31:48'),
(84, 10, 'upload/scorecard/scorecard_9380.jpg', '2017-05-25 21:31:48', '2017-05-25 21:31:48'),
(85, 10, 'upload/scorecard/scorecard_5647.png', '2017-05-25 21:31:48', '2017-05-25 21:31:48'),
(86, 10, 'upload/scorecard/scorecard_41.jpg', '2017-05-25 21:31:48', '2017-05-25 21:31:48'),
(87, 10, 'upload/scorecard/scorecard_8047.png', '2017-05-25 21:31:48', '2017-05-25 21:31:48'),
(88, 11, 'upload/scorecard/scorecard_7426.jpg', '2017-05-25 21:32:25', '2017-05-25 21:32:25'),
(89, 11, 'upload/scorecard/scorecard_9617.jpg', '2017-05-25 21:32:25', '2017-05-25 21:32:25'),
(90, 11, 'upload/scorecard/scorecard_9479.jpg', '2017-05-25 21:32:25', '2017-05-25 21:32:25'),
(91, 11, 'upload/scorecard/scorecard_5914.png', '2017-05-25 21:32:25', '2017-05-25 21:32:25'),
(92, 11, 'upload/scorecard/scorecard_9115.jpg', '2017-05-25 21:32:25', '2017-05-25 21:32:25'),
(93, 11, 'upload/scorecard/scorecard_4635.png', '2017-05-25 21:32:25', '2017-05-25 21:32:25'),
(94, 11, 'upload/scorecard/scorecard_450.jpg', '2017-05-25 21:32:25', '2017-05-25 21:32:25'),
(95, 11, 'upload/scorecard/scorecard_4246.png', '2017-05-25 21:32:25', '2017-05-25 21:32:25'),
(104, 13, 'upload/scorecard/scorecard_1529.jpg', '2017-05-26 16:19:50', '2017-05-26 16:19:50'),
(103, 13, 'upload/scorecard/scorecard_9230.jpg', '2017-05-26 16:19:50', '2017-05-26 16:19:50'),
(99, 13, 'upload/scorecard/scorecard_5220.jpg', '2017-05-26 16:15:33', '2017-05-26 16:15:33'),
(100, 13, 'upload/scorecard/scorecard_6803.jpg', '2017-05-26 16:15:33', '2017-05-26 16:15:33'),
(101, 13, 'upload/scorecard/scorecard_2049.jpg', '2017-05-26 16:15:33', '2017-05-26 16:15:33'),
(102, 13, 'upload/scorecard/scorecard_2985.jpg', '2017-05-26 16:15:33', '2017-05-26 16:15:33'),
(105, 13, 'upload/scorecard/scorecard_7431.jpg', '2017-05-26 16:19:50', '2017-05-26 16:19:50'),
(125, 15, 'upload/scorecard/scorecard_1905.jpg', '2017-05-26 20:16:53', '2017-05-26 20:16:53'),
(107, 14, 'upload/scorecard/scorecard_2014.jpg', '2017-05-26 19:22:42', '2017-05-26 19:22:42'),
(108, 14, 'upload/scorecard/scorecard_6043.jpg', '2017-05-26 19:22:42', '2017-05-26 19:22:42'),
(109, 14, 'upload/scorecard/scorecard_6660.jpg', '2017-05-26 19:22:42', '2017-05-26 19:22:42'),
(110, 14, 'upload/scorecard/scorecard_6188.jpg', '2017-05-26 19:22:42', '2017-05-26 19:22:42'),
(112, 15, 'upload/scorecard/scorecard_9666.jpg', '2017-05-26 19:34:29', '2017-05-26 19:34:29'),
(124, 15, 'upload/scorecard/scorecard_1404.jpg', '2017-05-26 20:16:53', '2017-05-26 20:16:53'),
(114, 15, 'upload/scorecard/scorecard_9126.jpg', '2017-05-26 19:34:29', '2017-05-26 19:34:29'),
(115, 15, 'upload/scorecard/scorecard_6628.jpg', '2017-05-26 19:34:29', '2017-05-26 19:34:29'),
(126, 15, 'upload/scorecard/scorecard_7598.jpg', '2017-05-26 20:16:53', '2017-05-26 20:16:53'),
(117, 16, 'upload/scorecard/scorecard_9489.jpg', '2017-05-26 20:13:41', '2017-05-26 20:13:41'),
(118, 16, 'upload/scorecard/scorecard_5674.jpg', '2017-05-26 20:13:41', '2017-05-26 20:13:41'),
(119, 16, 'upload/scorecard/scorecard_5027.png', '2017-05-26 20:13:41', '2017-05-26 20:13:41'),
(120, 16, 'upload/scorecard/scorecard_4849.jpg', '2017-05-26 20:13:41', '2017-05-26 20:13:41'),
(121, 16, 'upload/scorecard/scorecard_3590.png', '2017-05-26 20:13:41', '2017-05-26 20:13:41'),
(122, 16, 'upload/scorecard/scorecard_3240.jpg', '2017-05-26 20:13:41', '2017-05-26 20:13:41'),
(123, 16, 'upload/scorecard/scorecard_9277.png', '2017-05-26 20:13:41', '2017-05-26 20:13:41'),
(127, 15, 'upload/scorecard/scorecard_2773.png', '2017-05-26 20:16:53', '2017-05-26 20:16:53'),
(128, 15, 'upload/scorecard/scorecard_1378.jpg', '2017-05-26 20:16:53', '2017-05-26 20:16:53'),
(129, 15, 'upload/scorecard/scorecard_4725.png', '2017-05-26 20:16:53', '2017-05-26 20:16:53');

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `id` int(10) UNSIGNED NOT NULL,
  `state_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_delete` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`id`, `state_name`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'Alabama', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(2, 'California', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(3, 'Delaware', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(4, 'Florida', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(5, 'Kansas', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(6, 'New Jersey', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(7, 'New York', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(8, 'Alaska', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(9, 'Arizona', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(10, 'Arkansas', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(11, 'Colorado', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(12, 'Connecticut', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(13, 'Georgia', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(14, 'Hawaii', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(15, 'Idaho', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(16, 'Illinois', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(17, 'Indiana', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(18, 'Iowa', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(19, 'Kentucky', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(20, 'Louisiana', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(21, 'Maine', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(22, 'Maryland', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(23, 'Massachusetts', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(24, 'Michigan', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(25, 'Minnesota', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(26, 'Mississippi', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(27, 'Missouri', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(28, 'Montana', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(29, 'Nebraska', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(30, 'Nevada', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(31, 'New Hampshire', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(32, 'New Mexico', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(33, 'North Carolina', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(34, 'North Dakota', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(35, 'Ohio', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(36, 'Oklahoma', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(37, 'Oregon', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(38, 'Pennsylvania', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(39, 'Rhode Island', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(40, 'South Carolina', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(41, 'South Dakota', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(42, 'Tennessee', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(43, 'Texas', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(44, 'Utah', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(45, 'Vermont', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(46, 'Virginia', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(47, 'Washington', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(48, 'West Virginia', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(49, 'Wisconsin', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03'),
(50, 'Wyoming', 0, '2017-05-09 20:00:03', '2017-05-09 20:00:03');

-- --------------------------------------------------------

--
-- Table structure for table `survey`
--

CREATE TABLE `survey` (
  `id` int(10) UNSIGNED NOT NULL,
  `clientId` int(10) UNSIGNED NOT NULL,
  `que_1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `que_1_check` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `que_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `que_2_check` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `que_3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `que_3_check` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `que_4` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `que_4_check` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `que_5` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `que_5_check` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `que_6` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `que_6_check` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `que_7` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `que_7_check` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `que_8` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `que_8_check` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `status` enum('True','False') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deviceId` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `survey`
--

INSERT INTO `survey` (`id`, `clientId`, `que_1`, `que_1_check`, `que_2`, `que_2_check`, `que_3`, `que_3_check`, `que_4`, `que_4_check`, `que_5`, `que_5_check`, `que_6`, `que_6_check`, `que_7`, `que_7_check`, `que_8`, `que_8_check`, `status`, `created_at`, `updated_at`, `deviceId`) VALUES
(51, 16, 'Test 1', 'True', 'Test 2', 'True', 'Test 3', 'True', '', 'False', '', 'False', '', 'False', '', 'False', '', 'False', 'True', '2017-05-18 15:13:58', '2017-05-18 15:13:58', 156),
(1, 31, 'News', 'False', 'Psot', 'False', 'Sat', 'False', 'Fri', 'False', 'Mon', 'False', 'Tues', 'False', 'Thurs', 'False', 'Sund', 'False', 'True', '2017-05-10 15:59:57', '2017-05-10 15:59:57', 146),
(3, 15, 'dfgfdgd', 'False', 'dfgdg', 'False', 'dfgfdg', 'False', 'dfgfd', 'False', 'dfhtrju', 'False', 'u65ru', 'False', 'eswrwr', 'False', 'uyuy', 'False', 'True', '2017-05-10 16:20:09', '2017-05-10 16:20:09', 143),
(7, 22, 'dfgfdgd', 'False', 'dfgdg', 'False', 'dfgfdg', 'False', 'dfgfd', 'False', 'dfhtrju', 'False', 'u65ru', 'False', 'eswrwr', 'False', 'uyuy', 'False', 'True', '2017-05-10 16:20:40', '2017-05-10 16:20:40', 143),
(9, 29, 'dfgfdgd', 'False', 'dfgdg', 'False', 'dfgfdg', 'False', 'dfgfd', 'False', 'dfhtrju', 'False', '946dfhh', 'False', 'eswrwr', 'False', 'uyuy', 'False', 'True', '2017-05-10 16:22:21', '2017-05-10 16:22:21', 143),
(18, 16, 'News', 'True', 'Price', 'False', 'Sat', 'False', 'Fri', 'True', 'Mon', 'True', 'Tues', 'False', 'Thurs', 'False', 'Sund', 'True', 'True', '2017-05-12 17:18:57', '2017-05-12 17:18:57', 44),
(43, 15, 'Test1', 'False', 'Test2', 'False', 'Test3', 'False', 'Test4', 'False', 'Test5', 'False', 'Test6', 'False', 'Test7', 'False', 'Test8', 'False', 'True', '2017-05-16 20:04:58', '2017-05-20 12:57:05', 91),
(10, 15, 'Cost', 'True', 'Price', 'False', 'Size', 'False', 'Features', 'True', 'Longevity', 'False', 'Shock/CT', 'True', 'RFL', 'False', 'SFT', 'True', 'True', '2017-05-11 21:04:27', '2017-05-11 21:04:27', 46),
(11, 16, 'Cost', 'False', 'Price', 'False', 'Size', 'False', 'Features', 'False', 'Longevity', 'True', 'Shock/CT', 'True', 'RFL', 'True', 'SFT', 'True', 'True', '2017-05-11 21:56:56', '2017-05-11 21:56:56', 40),
(22, 15, 'Cost', 'True', 'Price', 'False', 'Size', 'True', 'Features', 'False', 'Longevity', 'False', 'Shock/CT', 'True', 'RFL', 'False', 'SFT', 'True', 'True', '2017-05-12 21:14:09', '2017-05-18 11:58:04', 40),
(13, 17, 'News', 'True', 'Price', 'False', 'Sat', 'True', 'Fri', 'False', 'Mon', 'True', 'Tues', 'False', 'Thurs', 'True', 'Sund', 'False', 'True', '2017-05-12 11:40:26', '2017-05-12 11:40:26', 151),
(14, 16, 'News', 'True', 'Price', 'True', 'Sat', 'True', 'Fri', 'False', 'Mon', 'True', 'Tues', 'True', 'Thurs', 'True', 'Sund', 'False', 'True', '2017-05-12 11:40:42', '2017-05-12 11:40:42', 151),
(15, 15, 'News', 'True', 'Price', 'True', 'Sat', 'False', 'Fri', 'False', 'Mon', 'False', 'Tues', 'True', 'Thurs', 'True', 'Sund', 'False', 'True', '2017-05-12 11:41:14', '2017-05-12 11:41:14', 151),
(16, 33, 'News', 'True', 'Price', 'True', 'Sat', 'True', 'Fri', 'True', 'Mon', 'False', 'Tues', 'True', 'Thurs', 'True', 'Sund', 'True', 'True', '2017-05-12 11:41:37', '2017-05-12 14:47:13', 151),
(17, 33, 'News', 'True', 'Price', 'True', 'Sat', 'False', 'Fri', 'False', '', 'False', '', 'False', '', 'False', '', 'False', 'True', '2017-05-12 13:59:19', '2017-05-12 13:59:19', 147),
(19, 15, 'News', 'True', 'Price', 'False', 'Sat', 'False', 'Fri', 'True', 'Mon', 'True', 'Tues', 'False', 'Thurs', 'False', 'Sund', 'True', 'True', '2017-05-12 17:19:21', '2017-05-12 17:19:21', 44),
(21, 17, 'News', 'True', 'Price', 'False', 'Sat', 'True', 'Fri', 'True', 'Mon', 'True', 'Tues', 'False', 'Thurs', 'False', 'Sund', 'True', 'True', '2017-05-12 17:22:54', '2017-05-12 17:22:54', 44),
(49, 16, 'Test1', 'True', 'Test2', 'True', 'Test3', 'True', 'Test4', 'True', 'Test5', 'False', 'Test6', 'False', 'Test7', 'False', 'Test8', 'True', 'True', '2017-05-18 12:19:26', '2017-05-18 12:19:26', 91),
(50, 15, 'Test 1', 'True', 'Test 2', 'True', 'Test 3', 'False', 'Test 4', 'False', 'Test 5', 'False', 'Test 6', 'True', 'Test 7', 'True', 'Test 8', 'True', 'True', '2017-05-18 14:07:18', '2017-05-18 14:07:18', 156),
(54, 16, 'News', 'False', 'Price', 'False', '', 'False', '', 'False', '', 'False', '', 'False', '', 'False', '', 'False', 'True', '2017-05-20 12:55:39', '2017-05-20 12:55:39', 154),
(53, 15, 'News', 'False', 'Price', 'False', 'Sat', 'False', 'Fri', 'False', '', 'False', '', 'False', '', 'False', '', 'False', 'True', '2017-05-20 12:44:56', '2017-05-20 12:48:55', 153),
(55, 15, 'News', 'False', 'Price', 'False', '', 'False', '', 'False', '', 'False', '', 'False', '', 'False', '', 'False', 'True', '2017-05-20 12:55:58', '2017-05-20 12:55:58', 154),
(24, 33, 'Test 1', 'True', 'Test 2', 'True', 'Test 3', 'False', 'Test 4', 'False', 'Test 5', 'False', 'Test 6', 'True', 'Test 7', 'True', 'Test 8', 'True', 'True', '2017-05-20 19:52:48', '2017-05-20 19:52:48', 156),
(26, 34, 'News', 'False', 'Price', 'False', '', 'False', '', 'False', '', 'False', '', 'False', '', 'False', '', 'False', 'True', '2017-05-26 20:41:10', '2017-05-26 20:41:10', 156);

-- --------------------------------------------------------

--
-- Table structure for table `survey_answer`
--

CREATE TABLE `survey_answer` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `surveyId` int(10) UNSIGNED NOT NULL,
  `que_1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `que_1_check` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `que_1_answer` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `que_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `que_2_check` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `que_2_answer` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `que_3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `que_3_check` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `que_3_answer` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `que_4` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `que_4_check` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `que_4_answer` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `que_5` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `que_5_check` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `que_5_answer` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `que_6` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `que_6_check` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `que_6_answer` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `que_7` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `que_7_check` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `que_7_answer` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `que_8` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `que_8_check` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `que_8_answer` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deviceId` int(10) UNSIGNED NOT NULL,
  `flag` enum('True','False') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'False'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `survey_answer`
--

INSERT INTO `survey_answer` (`id`, `user_id`, `surveyId`, `que_1`, `que_1_check`, `que_1_answer`, `que_2`, `que_2_check`, `que_2_answer`, `que_3`, `que_3_check`, `que_3_answer`, `que_4`, `que_4_check`, `que_4_answer`, `que_5`, `que_5_check`, `que_5_answer`, `que_6`, `que_6_check`, `que_6_answer`, `que_7`, `que_7_check`, `que_7_answer`, `que_8`, `que_8_check`, `que_8_answer`, `created_at`, `updated_at`, `deviceId`, `flag`) VALUES
(1, 160, 1, 'price', 'True', 'False', 'Brand', 'True', 'False', 'efficiency', 'True', 'False', 'Features', 'True', 'False', 'stability', 'True', 'True', 'longevity', 'True', 'False', 'speed', 'True', 'False', 'Other', 'True', 'False', '2017-05-10 15:39:37', '2017-05-10 15:39:40', 91, 'True'),
(2, 96, 9, 'Cost', 'True', 'False', 'Price', 'False', 'False', 'Size', 'False', 'False', 'Features', 'True', 'False', 'Longevity', 'True', 'True', 'Shock/CT', 'True', 'True', 'RFL', 'False', 'False', 'SFT', 'True', 'False', '2017-05-11 21:31:11', '2017-05-11 21:31:39', 46, 'True'),
(3, 96, 9, 'Cost', 'True', 'True', 'Price', 'False', 'False', 'Size', 'False', 'False', 'Features', 'True', 'True', 'Longevity', 'True', 'True', 'Shock/CT', 'True', 'True', 'RFL', 'False', 'False', 'SFT', 'True', 'True', '2017-05-11 21:35:27', '2017-05-11 21:35:27', 46, 'False'),
(4, 96, 9, 'Cost', 'True', 'False', 'Price', 'True', 'True', 'Size', 'True', 'False', 'Features', 'True', 'False', 'Longevity', 'True', 'True', 'Shock/CT', 'True', 'True', 'RFL', 'True', 'True', 'SFT', 'True', 'True', '2017-05-11 21:41:04', '2017-05-11 21:41:04', 46, 'False'),
(5, 96, 10, 'Cost', 'True', 'False', 'Price', 'False', 'False', 'Size', 'False', 'False', 'Features', 'True', 'False', 'Longevity', 'False', 'False', 'Shock/CT', 'True', 'True', 'RFL', 'False', 'False', 'SFT', 'True', 'True', '2017-05-11 21:49:44', '2017-05-11 21:49:48', 46, 'True'),
(6, 96, 10, 'Cost', 'True', 'True', 'Price', 'False', 'False', 'Size', 'False', 'False', 'Features', 'True', 'False', 'Longevity', 'False', 'False', 'Shock/CT', 'True', 'False', 'RFL', 'False', 'False', 'SFT', 'True', 'True', '2017-05-11 21:53:20', '2017-05-11 21:53:36', 46, 'True'),
(7, 96, 7, 'Cost', 'True', 'True', 'Price', 'False', 'False', 'Size', 'True', 'True', 'Features', 'False', 'False', 'Longevity', 'True', 'True', 'Shock/CT', 'True', 'False', 'RFL', 'False', 'False', 'SFT', 'False', 'False', '2017-05-11 22:02:58', '2017-05-11 22:04:07', 39, 'True'),
(8, 160, 1, 'price', 'True', 'True', 'Brand', 'True', 'True', 'efficiency', 'True', 'False', 'Features', 'True', 'True', 'stability', 'True', 'False', 'longevity', 'True', 'False', 'speed', 'True', 'False', 'Other', 'True', 'True', '2017-05-12 12:44:08', '2017-05-12 12:44:10', 91, 'True'),
(9, 160, 1, 'price', 'True', 'False', 'Brand', 'True', 'False', 'efficiency', 'True', 'False', 'Features', 'True', 'False', 'stability', 'True', 'True', 'longevity', 'True', 'True', 'speed', 'True', 'True', 'Other', 'True', 'True', '2017-05-12 12:46:28', '2017-05-12 12:46:31', 91, 'True'),
(10, 160, 1, 'price', 'True', 'True', 'Brand', 'True', 'False', 'efficiency', 'True', 'False', 'Features', 'True', 'False', 'stability', 'True', 'False', 'longevity', 'True', 'False', 'speed', 'True', 'False', 'Other', 'True', 'False', '2017-05-12 13:00:44', '2017-05-12 13:00:51', 91, 'True'),
(11, 96, 21, 'Price ', 'True', 'True', 'Longevity', 'True', 'False', 'Test 2', 'True', 'False', 'Test 3', 'True', 'False', 'Test', 'True', 'False', 'Test6', 'True', 'False', 'Test 8', 'False', 'False', 'Test 7', 'False', 'False', '2017-05-12 21:20:04', '2017-05-12 21:21:32', 91, 'True'),
(12, 96, 24, 'Test1', 'True', 'True', 'Test2', 'True', 'False', 'Test3', 'True', 'False', 'Test4', 'True', 'False', 'test5', 'True', 'True', 'test6', 'True', 'True', 'test7', 'True', 'True', 'test8', 'True', 'False', '2017-05-12 21:22:02', '2017-05-12 21:22:06', 39, 'True'),
(13, 96, 26, 'Test1', 'True', 'True', 'Test2', 'True', 'False', 'Test3', 'True', 'False', 'Test4', 'True', 'False', 'Test5', 'True', 'True', 'Test6', 'True', 'False', 'Test7', 'True', 'False', 'Test8', 'True', 'False', '2017-05-12 21:38:11', '2017-05-12 21:38:16', 91, 'True'),
(14, 96, 22, 'Cost', 'True', 'True', 'Price', 'True', 'True', 'Size', 'True', 'False', 'Features', 'True', 'False', 'Longevity', 'True', 'False', 'Shock/CT', 'True', 'False', 'RFL', 'True', 'False', 'SFT', 'True', 'False', '2017-05-12 21:52:52', '2017-05-12 21:52:55', 40, 'True'),
(15, 96, 22, 'Cost', 'True', 'True', 'Price', 'True', 'True', 'Size', 'False', 'False', 'Features', 'False', 'False', 'Longevity', 'True', 'False', 'Shock/CT', 'False', 'False', 'RFL', 'False', 'False', 'SFT', 'True', 'False', '2017-05-15 16:36:54', '2017-05-15 16:36:54', 40, 'False'),
(16, 96, 22, 'Cost', 'True', 'False', 'Price', 'True', 'True', 'Size', 'False', 'False', 'Features', 'False', 'False', 'Longevity', 'True', 'True', 'Shock/CT', 'False', 'False', 'RFL', 'False', 'False', 'SFT', 'True', 'False', '2017-05-15 19:46:01', '2017-05-15 19:46:03', 40, 'True'),
(17, 96, 22, 'Cost', 'True', 'True', 'Price', 'True', 'False', 'Size', 'False', 'False', 'Features', 'True', 'False', 'Longevity', 'True', 'True', 'Shock/CT', 'False', 'False', 'RFL', 'False', 'False', 'SFT', 'True', 'False', '2017-05-16 14:08:02', '2017-05-16 14:08:17', 40, 'True'),
(18, 96, 22, 'Cost', 'True', 'True', 'Price', 'True', 'True', 'Size', 'False', 'False', 'Features', 'True', 'False', 'Longevity', 'True', 'False', 'Shock/CT', 'False', 'False', 'RFL', 'False', 'False', 'SFT', 'True', 'False', '2017-05-16 17:31:54', '2017-05-16 17:32:06', 40, 'True'),
(19, 96, 22, 'Cost', 'True', 'True', 'Price', 'True', 'False', 'Size', 'False', 'False', 'Features', 'True', 'False', 'Longevity', 'True', 'False', 'Shock/CT', 'False', 'False', 'RFL', 'False', 'False', 'SFT', 'True', 'False', '2017-05-16 18:05:30', '2017-05-16 18:05:30', 40, 'False'),
(20, 96, 22, 'Cost', 'True', 'True', 'Price', 'True', 'False', 'Size', 'False', 'False', 'Features', 'True', 'False', 'Longevity', 'True', 'False', 'Shock/CT', 'False', 'False', 'RFL', 'False', 'False', 'SFT', 'True', 'False', '2017-05-16 20:00:11', '2017-05-16 20:00:12', 40, 'True'),
(21, 96, 22, 'Cost', 'True', 'False', 'Price', 'True', 'True', 'Size', 'False', 'False', 'Features', 'True', 'False', 'Longevity', 'True', 'False', 'Shock/CT', 'False', 'False', 'RFL', 'False', 'False', 'SFT', 'True', 'False', '2017-05-16 20:00:24', '2017-05-16 20:00:25', 40, 'True'),
(22, 96, 22, 'Cost', 'True', 'False', 'Price', 'True', 'True', 'Size', 'False', 'False', 'Features', 'True', 'False', 'Longevity', 'True', 'False', 'Shock/CT', 'False', 'False', 'RFL', 'False', 'False', 'SFT', 'True', 'False', '2017-05-16 20:01:29', '2017-05-16 20:01:30', 40, 'True'),
(23, 96, 22, 'Cost', 'True', 'False', 'Price', 'True', 'True', 'Size', 'False', 'False', 'Features', 'False', 'False', 'Longevity', 'False', 'False', 'Shock/CT', 'False', 'False', 'RFL', 'False', 'False', 'SFT', 'False', 'False', '2017-05-17 11:21:44', '2017-05-17 11:21:44', 40, 'False'),
(24, 96, 22, 'Cost', 'True', 'False', 'Price', 'True', 'True', 'Size', 'False', 'False', 'Features', 'False', 'False', 'Longevity', 'False', 'False', 'Shock/CT', 'False', 'False', 'RFL', 'False', 'False', 'SFT', 'False', 'False', '2017-05-17 11:22:43', '2017-05-17 11:22:43', 40, 'False'),
(25, 96, 43, 'Test1', 'True', 'False', 'Test2', 'True', 'True', 'Test3', 'False', 'False', 'Test4', 'False', 'False', 'Test5', 'False', 'False', 'Test6', 'False', 'False', 'Test7', 'False', 'False', 'Test8', 'False', 'False', '2017-05-17 12:01:46', '2017-05-17 12:01:46', 91, 'False'),
(26, 96, 43, 'Test1', 'True', 'True', 'Test2', 'True', 'True', 'Test3', 'True', 'False', 'Test4', 'True', 'True', 'Test5', 'False', 'False', 'Test6', 'False', 'False', 'Test7', 'False', 'False', 'Test8', 'True', 'False', '2017-05-18 12:00:14', '2017-05-18 12:00:38', 91, 'True'),
(27, 96, 43, 'Test1', 'True', 'False', 'Test2', 'True', 'False', 'Test3', 'True', 'True', 'Test4', 'True', 'False', 'Test5', 'False', 'False', 'Test6', 'False', 'False', 'Test7', 'False', 'False', 'Test8', 'True', 'False', '2017-05-18 12:01:43', '2017-05-18 12:01:45', 91, 'True'),
(28, 96, 43, 'Test1', 'True', 'True', 'Test2', 'True', 'True', 'Test3', 'True', 'True', 'Test4', 'True', 'True', 'Test5', 'False', 'False', 'Test6', 'False', 'False', 'Test7', 'False', 'False', 'Test8', 'True', 'False', '2017-05-18 12:21:33', '2017-05-18 12:21:33', 91, 'False'),
(29, 96, 22, 'Cost', 'True', 'False', 'Price', 'False', 'False', 'Size', 'True', 'True', 'Features', 'False', 'False', 'Longevity', 'False', 'False', 'Shock/CT', 'True', 'False', 'RFL', 'False', 'False', 'SFT', 'True', 'True', '2017-05-18 12:22:14', '2017-05-18 12:22:17', 40, 'True'),
(30, 96, 43, 'Test1', 'True', 'True', 'Test2', 'True', 'False', 'Test3', 'True', 'False', 'Test4', 'True', 'False', 'Test5', 'False', 'False', 'Test6', 'False', 'False', 'Test7', 'False', 'False', 'Test8', 'True', 'False', '2017-05-18 12:22:48', '2017-05-18 12:22:51', 91, 'True'),
(31, 96, 22, 'Cost', 'True', 'True', 'Price', 'False', 'False', 'Size', 'True', 'True', 'Features', 'False', 'False', 'Longevity', 'False', 'False', 'Shock/CT', 'True', 'False', 'RFL', 'False', 'False', 'SFT', 'True', 'False', '2017-05-20 13:14:07', '2017-05-20 13:14:09', 40, 'True'),
(32, 96, 49, 'Test1', 'True', 'False', 'Test2', 'True', 'True', 'Test3', 'True', 'False', 'Test4', 'True', 'True', 'Test5', 'False', 'False', 'Test6', 'False', 'False', 'Test7', 'False', 'False', 'Test8', 'True', 'False', '2017-05-20 14:07:42', '2017-05-20 14:07:46', 91, 'True'),
(33, 96, 11, 'Cost', 'False', 'False', 'Price', 'False', 'False', 'Size', 'False', 'False', 'Features', 'False', 'False', 'Longevity', 'True', 'False', 'Shock/CT', 'True', 'True', 'RFL', 'True', 'False', 'SFT', 'True', 'True', '2017-05-20 14:13:39', '2017-05-20 14:13:41', 40, 'True'),
(34, 96, 22, 'Cost', 'True', 'False', 'Price', 'False', 'False', 'Size', 'True', 'True', 'Features', 'False', 'False', 'Longevity', 'False', 'False', 'Shock/CT', 'True', 'False', 'RFL', 'False', 'False', 'SFT', 'True', 'True', '2017-05-20 14:15:53', '2017-05-20 14:15:55', 40, 'True'),
(35, 96, 16, 'News', 'True', 'True', 'Price', 'True', 'False', 'Sat', 'True', 'True', 'Fri', 'True', 'False', 'Mon', 'False', 'False', 'Tues', 'True', 'True', 'Thurs', 'True', 'False', 'Sund', 'True', 'False', '2017-05-20 14:18:06', '2017-05-20 14:18:07', 151, 'True'),
(36, 104, 22, 'Cost', 'True', 'True', 'Price', 'False', 'False', 'Size', 'True', 'False', 'Features', 'False', 'False', 'Longevity', 'False', 'False', 'Shock/CT', 'True', 'True', 'RFL', 'False', 'False', 'SFT', 'True', 'False', '2017-05-24 14:10:58', '2017-05-24 14:11:14', 40, 'True'),
(37, 104, 11, 'Cost', 'False', 'False', 'Price', 'False', 'False', 'Size', 'False', 'False', 'Features', 'False', 'False', 'Longevity', 'True', 'False', 'Shock/CT', 'True', 'True', 'RFL', 'True', 'False', 'SFT', 'True', 'True', '2017-05-25 16:03:02', '2017-05-25 16:03:04', 40, 'True'),
(38, 104, 49, 'Test1', 'True', 'True', 'Test2', 'True', 'True', 'Test3', 'True', 'True', 'Test4', 'True', 'True', 'Test5', 'False', 'False', 'Test6', 'False', 'False', 'Test7', 'False', 'False', 'Test8', 'True', 'True', '2017-05-25 16:04:44', '2017-05-25 16:04:46', 91, 'True'),
(39, 183, 11, 'Cost', 'False', 'False', 'Price', 'False', 'False', 'Size', 'False', 'False', 'Features', 'False', 'False', 'Longevity', 'True', 'True', 'Shock/CT', 'True', 'True', 'RFL', 'True', 'True', 'SFT', 'True', 'True', '2017-05-25 18:07:35', '2017-05-25 18:07:36', 40, 'True'),
(40, 183, 49, 'Test1', 'True', 'False', 'Test2', 'True', 'True', 'Test3', 'True', 'True', 'Test4', 'True', 'False', 'Test5', 'False', 'False', 'Test6', 'False', 'False', 'Test7', 'False', 'False', 'Test8', 'True', 'False', '2017-05-25 18:08:45', '2017-05-25 18:08:47', 91, 'True'),
(41, 183, 22, 'Cost', 'True', 'True', 'Price', 'False', 'False', 'Size', 'True', 'False', 'Features', 'False', 'False', 'Longevity', 'False', 'False', 'Shock/CT', 'True', 'False', 'RFL', 'False', 'False', 'SFT', 'True', 'False', '2017-05-25 18:09:46', '2017-05-25 18:09:48', 40, 'True');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `organization` int(11) DEFAULT NULL,
  `org_type` int(11) DEFAULT NULL,
  `roll` int(10) UNSIGNED NOT NULL,
  `projectname` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('Enabled','Disabled') COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_delete` int(11) NOT NULL,
  `is_agree` int(11) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `profilePic` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `organization`, `org_type`, `roll`, `projectname`, `status`, `password`, `is_delete`, `is_agree`, `remember_token`, `created_at`, `updated_at`, `mobile`, `title`, `profilePic`) VALUES
(1, 'dhaval', 'thummardhaval64@gmail.com', 0, 0, 1, 0, 'Enabled', '$2y$10$FJHYTuYI68ty5tn/goMeKuPskKpp.W0DoaivWUgxoktaGKvS4ym42', 0, 1, 'G6S1LAtAgAf5zPS7yfxakEI6Df2pTWNo9rSeJtGWL3zdaUuZuPDRHxEWxaOH', '2017-05-09 20:30:41', '2017-06-02 00:11:51', NULL, NULL, NULL),
(3, 'Mani', 'manikandakumar7@gmail.com', 0, NULL, 1, 0, 'Enabled', '$2y$10$Wm2ehTH4XDNg8vMCYiPvuupv1o6KYzOFqIJLQ0ukeql7.zeK2QTxy', 0, 1, 'OzQwXI21AVpHxdGZp13jjaC7aJnwd484L35xp0ZZyzdXP1N5CtVnH9BtfpJ7', NULL, '2017-05-26 18:52:42', NULL, NULL, NULL),
(50, 'Ordertestedit', 'ordertest@gmail.com', 20, NULL, 4, 0, 'Enabled', '$2y$10$xdgi0ES3SOTTfuwVnZk34OvKXCOi4CS2vWwhieHf2x477rtrPwg.O', 0, 0, 'Xn6aRhBOEgQQ5Q5oWl6AsOMunrjekZJ1X89xCWBRmgA9dZGHEyVYzAZfMsXk', NULL, '2016-09-17 12:13:26', NULL, NULL, NULL),
(51, 'Naresh', 'nareshanatharaj@gmail.com', 20, NULL, 3, 35, 'Enabled', '$2y$10$urABsrqRfcx/uRpk6gRPyOeSIjExgYjcf45Cc2MB3Q6fU7AfnIsLq', 0, 1, 'YdiTDUrZEq9UboaQdXpjNjWBNsbFJwJrLGDzRyZpIfqCArq0pcdFzsjBwlB6', NULL, '2017-02-06 14:07:03', NULL, NULL, NULL),
(62, 'kumar', 'senman43@gmail.com', 3, NULL, 3, 2, 'Enabled', '$2y$10$QrATRSs8Zbqa8zZqVDoHDOYGxbC5CAlAivaTnZWhM0aP3wm48PkHy', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(67, 'Don  Mousseau', 'don@dmdgo.com', 0, NULL, 1, 0, 'Enabled', '$2y$10$E3ndyNNZm0pb65nEgeAjyugvdqJICnzwrjmP9PlRBjrUodpJG7StG', 0, 1, 'B7NoGFctGaq37GX2n9Qo7MiB0b9XsD1AyVLqNE1j5etXk9THxomMXMPPRwBf', NULL, '2016-09-30 21:40:38', NULL, NULL, NULL),
(69, 'vineeth_admin', 'inbox.vineeth@gmail.com', 0, NULL, 1, 0, 'Enabled', '$2y$10$6t3nJy04yoQwWsXedScoquei7lhgf6GCbfBdkTkZZ457O.kqBnLe6', 0, 1, 'QrcpJMu56Wsj3H1xgsJAaUUsmIXgiESxo7VedEzrCHDUSSRwilxMrQXMfAxG', NULL, '2016-10-18 02:51:58', NULL, NULL, NULL),
(70, 'Naresh', 'Naresh@urbansoft.in', 10, NULL, 4, 0, 'Disabled', '$2y$10$dmxJHI6TKD92pyqrevD.zeGqygZ4RMh7Z3P5YGgXauquIoXkhjTN6', 0, 0, 'ZyIcSP2yvLqf7uvs3u4R12DP9fpiIhASyKJq9KeFngDgs2DRGtQgx0VPoGSU', NULL, '2016-09-01 02:37:23', NULL, NULL, NULL),
(75, 'Kumar', 'kumarsr@gmail.com', 0, NULL, 1, 0, 'Enabled', '$2y$10$t8AIcO3X33rStWspoWUsAeADUtEg/7Nh/XbaHRYuN/K45250iZMby', 0, 1, 'Dz7ANluQHlFDLhdE0K4toYzQ0pUfFZGa8eEFGUixLtWUXVrkqqLgwKDeO5NL', NULL, '2016-09-11 11:59:02', NULL, NULL, NULL),
(76, 'sub', 'suburn@gmail.com', 5, NULL, 2, 0, 'Enabled', '$2y$10$wJwmlEEqB7wIuJRmB5XTLOGttZT7bXXxsjIQdIHPTtJYBoy5AFlV.', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(77, 'Kumar', 'kumar143@gmail.com', 1, NULL, 2, 0, 'Enabled', '$2y$10$ZttRrPMVYiHiNlNG1ZMKB.55.aeXSgMx.3pYnXNIEpf9o0gsTaC6q', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(81, 'Order', 'order12@gmail.com', 15, NULL, 4, 0, 'Enabled', '$2y$10$c.Banr7L9g42jyuLLEbHIuRudQnKZ6pHQ/i6PT2WD0kxUx/pnxOKm', 0, 1, 'aAvsFhXbL3aGFhnjG7rSMo9TS1SyKgs7b61dxV77x5JjpOLxfymhH42mE8CR', NULL, '2016-10-13 18:20:38', NULL, NULL, NULL),
(88, 'Rod Erb', 'rodneyerb@nesoinc.com', 0, NULL, 1, 0, 'Enabled', '$2y$10$xyPAqMbsQYikZSXRdqD5e..HSDI4Tps/uUBLXQjxZkDOPoQt9R3P6', 0, 1, 'W4Tq6eLGHQDIU2p0dwm6trBp7uqvU3hyEy6a258SGEk3ySHEm24Vd2262bbm', NULL, '2016-11-16 10:04:37', NULL, NULL, NULL),
(92, 'UVMC Orders', 'neptuneppa@nesoinc.com', 15, NULL, 4, 0, 'Enabled', '$2y$10$Vho1T1FETOVB8k8a/QCJI.6LOCqrAAhA7l8IPkT9/QDnxDG4I1isy', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(94, 'Erb Demo', 'petern12583@yahoo.com', 15, NULL, 3, 23, 'Enabled', '$2y$10$YG2vWwFZAUEQf/87Kf4ewujSpKd/qj6ngtkiRjcxz1nS9xI9WLJfm', 0, 1, '3tRSuqPUV8YsySVi8Uh0QIa6xE88sQllZ58Um4RWBgCG6k7GBrEEC7TgffGu', NULL, '2016-11-16 00:15:40', NULL, NULL, NULL),
(96, 'Manikk', 'manikk@gmail.com', 16, NULL, 3, 48, 'Enabled', '$2y$10$eYIeCqK7KOZ6nrzPN8veZOFQvYe0.WPxj35UFInBwLw0RnNb1l892', 0, 1, 'aJJpRTnz8wcfijST3pgvHNEGQsovSGuQFQQY3FYpSgJu1v14MI3YQTAlQlbu', NULL, '2017-05-30 04:07:48', NULL, NULL, NULL),
(98, 'mani', 'manikk1@gmail.com', 16, NULL, 4, 0, 'Disabled', '$2y$10$yNhZXpg1svyvQ/wLo7MIJOnjiQApHRqDTjV/KKPiwt9.UoySINyqa', 0, 1, 'HyhWKgrIUHnPOtl9BmhJ0QHpFJiNmgEf7F4MS5QNc1zi34Lm8CnHM8GraMC0', NULL, '2016-09-23 18:51:08', NULL, NULL, NULL),
(99, 'Joe Smith', 'jsmith@fakeemail.com', 1, NULL, 5, 48, 'Disabled', '$2y$10$4AAD90jeSuX26v9Q1E7i/OTAkW5c9p4BAS95W6Lw9KnMDnT1UMnVi', 0, 0, NULL, NULL, NULL, '8565767677', 'Mgr', 'user_05-12-17_1205pm_88452.jpg'),
(100, 'Bob Smith', 'bsmith@fakeemail.com', 3, NULL, 5, 48, 'Enabled', '$2y$10$L9dJ4mJHYPVMLRE6q7Ng3ujWEHeaHL5ff2Gsx6b1NFmYQBNOdLheu', 0, 0, NULL, NULL, NULL, '1323456798', 'test', 'user_05-12-17_1206pm_94337.jpg'),
(101, 'Sam Smith', 'ssmith@fakeemail.com', 4, NULL, 5, 48, 'Enabled', '$2y$10$cTbuDoVloxbDrVVhdS28POHeyxS.8aTgALvFNNVIBdwxTtdETmFp6', 0, 0, NULL, NULL, NULL, '6465456546', 'Sr Mgr', 'user_05-12-17_1207pm_28787.jpg'),
(102, 'Ken Smith', 'ksmith@fakeemail.com', 12, NULL, 5, 48, 'Enabled', '$2y$10$z6q7pZ5m9pVdPPdmQGBkF.d803M/2iOJEXKgdq1IxhAdyLRGpo6RO', 0, 0, NULL, NULL, NULL, '3456365735', 'dfgsdsfd', 'user_05-12-17_1208pm_92742.jpg'),
(104, 'manik', '300789msr@gmail.com', 4, NULL, 3, 48, 'Enabled', '$2y$10$rMjVmvlN4yMCco.waShZbOfqxQBcUv2EEUZAvlCt.P4BOE1IWj9Bq', 0, 1, 'AdqOjAvKCatlDT8N61cvASrKUWNVXwdLSNP3asNwdpP9IckSLUaUK7HnNEFY', NULL, '2017-05-25 16:16:45', '6468465465', 'Senior Manager', 'user_05-12-17_1209pm_61501.jpg'),
(105, 'reptest', 'rete@gmail.com', 4, NULL, 5, 48, 'Enabled', '$2y$10$IuZEQz1FXHMZD3mx1jB3bOSIIRJ1xXujHHrb1TuhWETz6h4sscpiG', 0, 0, NULL, NULL, NULL, '694641656', 'Asst Manager', 'user_05-12-17_1209pm_33392.jpg'),
(106, 'kumar', 'mani@cyberfinite.com', 15, NULL, 2, 0, 'Enabled', '$2y$10$IYBylwFq8WLxiiW8uIGgpez4pT7.hp0uzVcug9cnGuWeZAtTQOjbS', 0, 1, 'NZO2118oqvregeoNwG4F0zEG6WJh8PwkCFifwNn3BJvXLSBbnOHEaXAi9z7k', NULL, '2017-06-01 23:36:18', NULL, NULL, NULL),
(122, 'Don M', 'don@therockdaddys.com', 15, NULL, 3, 23, 'Enabled', '$2y$10$dDSNYAP57Jh2VPP94VHos.aPm4FhSylYiG0cDxnKM0nnRymkjxLIa', 0, 1, 'wcM23u9vMUOpKrKKQFFXBgHmuasB7sy3verzDJbf3in8whj5ifyVs2vs0Gps', NULL, '2017-01-13 22:04:26', NULL, NULL, NULL),
(125, 'Order', 'mani.kumar@urbansoft.in', 15, NULL, 4, 0, 'Disabled', '$2y$10$62UfRCbefNicRaMlJmnOhOoXhysQgB.jGf.0yvKAkrR1XexOa40cW', 0, 1, 'HUTAccKAR16p2C8781HbTWHHVqUjgwWIpDdwjatm7TyDCBn6EFM6eHShosnH', NULL, '2016-10-13 18:09:07', NULL, NULL, NULL),
(127, 'Dave Leffredo', 'petern11583@yahoo.com', 1, NULL, 5, 48, 'Disabled', '$2y$10$QfB6sfGxnJl2/BuHLzh2A.tmzuqgGuuJ6Dbk4tmEpXcMTqraa6NHi', 0, 0, NULL, NULL, NULL, '34576779789', 'Sr Mgr', 'user_05-12-17_1210pm_50751.jpg'),
(129, 'BSC Stent Rep', 'bscstent@fakeemail.com', 3, NULL, 5, 29, 'Disabled', '$2y$10$ISveUjuh..Mnpp09st/dZO86RrRFC12R9ZWV1yaVUbPQaedHwkDCy', 0, 0, NULL, NULL, NULL, '4654654564', 'Senior Manager', 'user_05-12-17_1211pm_92491.jpg'),
(130, 'SR', 'srfake@email.com', 14, NULL, 5, 29, 'Enabled', '$2y$10$SM8qmX3g0PVCiramilaugebuySAjEz20aI90TA8/MTfPw4aSw6MCq', 0, 0, NULL, NULL, NULL, '345677856', 'Asst Manager', 'user_05-12-17_1212pm_59205.jpg'),
(131, 'Patrick Fortner', 'pfortner@nesoinc.com', 0, NULL, 1, 0, 'Enabled', '$2y$10$g1.E.SsfO.HPXv.XK5HHWenL0B5x8PPAzdqBir9O/qZjYots.og96', 0, 1, 'kIaZ4qgFHiVECWt8Aod4ZxHkvT8xhLQP38uf1dtvwzI5DqbwY3GuoWmp1ezm', NULL, '2016-12-20 21:44:45', NULL, NULL, NULL),
(132, 'Test New', 'testnew@gmail.com', 15, NULL, 3, 35, 'Enabled', '$2y$10$l2zpLjh/.T9fdnMNwzoIiOSnXEw.uVxgGZYqNTWgC/11BF0x6wJKu', 0, 1, 'agpDOSOsnQEcZVhX8yqhA2aAe44iu3Tovejhx8rOuvI6xZ1YO5LOG8hCU0Ir', NULL, '2017-05-23 13:30:26', NULL, NULL, NULL),
(133, 'TestNewOrder', 'tno@gmail.com', 20, NULL, 4, 0, 'Enabled', '$2y$10$QhTdDmpMY63w5EHWR0FeZeC4Fw8DfCqdbRMTZ8.owfJNs8PsjpuB6', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(134, 'Test New Rep', 'tnr@gmail.com', 14, NULL, 5, 29, 'Enabled', '$2y$10$ywb63xqo/Kcud/9YofYe2uKA7Evlbz5pjVE03mU0koyp9c0PuDLtq', 0, 0, NULL, NULL, NULL, '43565456', 'Sales', 'user_05-12-17_1213pm_27988.jpg'),
(135, 'TestOneUser', 'tou@gmail.com', 20, NULL, 3, 23, 'Enabled', '$2y$10$Zc2zywJP2z8AtJ.UBXKp4OJoTxd3pyzC1yvTHIt0eT8eh8aIjfwdC', 0, 1, 'x38iIOoJBimQXIukEfzBhSCiV9LYvejKmQUAKm7xhgCTaNPF7bFyxo7mIqUg', NULL, '2017-02-06 19:03:17', NULL, NULL, NULL),
(136, 'Test2User', 't2u@gmail.com', 23, NULL, 3, 36, 'Enabled', '$2y$10$Z088tB2.5GqUzYZcGKplMu.d6GViuhfP/YeKYWd4Od1Gxyg3OMYW2', 0, 1, 'ixi9SYpvmDaE74qKqpTZTso5T1f1pANY7wlsGIturMeV3NbsngBBx1FeUBNL', NULL, '2017-02-07 09:32:34', NULL, NULL, NULL),
(137, 'Test1Order', 't1o@gmail.com', 23, NULL, 4, 0, 'Enabled', '$2y$10$OUB8TQFImhwhCpYv8irt.OLEXJDgMyylpzyJWwjMmWnrXkm1BWrsG', 0, 1, 'kqxIOacrY45j9JQrbyQwAuM124NA6wgTQE8zPuQkgrsrMkwNwt29ZLoNcwnM', NULL, '2017-02-06 20:38:29', NULL, NULL, NULL),
(138, 'Test1Rep', 't1r@gmail.com', 14, NULL, 5, 47, 'Enabled', '$2y$10$boikDgocoyUIVodq67T2Te.irklED4SXM0yYGn0UZKTd7DnpE8Im.', 0, 1, 'cQgmDtpOMQtbZ5oQapk1mm2Gqu2skk97OaFRpw9r2oi65TjkPBkTDlFtrtPR', NULL, '2017-02-06 20:40:03', '8967655464', 'Sales Manager', 'user_05-12-17_1214pm_17367.jpg'),
(139, 'Test2Rep', 't2r@gmail.com', 23, NULL, 3, 37, 'Enabled', '$2y$10$itFTKUpaDb4Dp7WQ44WNNuRbm2hJVSuL8P6hWM.mDMYit951UQgra', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(140, 'Test Admin', 'tadmin@gmail.com', 23, NULL, 2, 0, 'Enabled', '$2y$10$mtLu43U0RVvn2mKLD.oBd.SXZvfvGaPbARshfWnd2H5sE5YP9lO16', 0, 1, '9zFXuERkQQQmJthXZY5RhT7u7OQnAJgpMHgz1YkC3ULjShFjOc5CtweJovXz', NULL, '2017-05-26 20:22:42', NULL, NULL, NULL),
(144, 'Mani', 'srmkk@gmail.com', 0, NULL, 1, 0, 'Disabled', '$2y$10$VG1y5QABiW/RYF/B2PaoKe6488dyP9OMKEmam5MFzCT0RTderBt.q', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(145, 'tn', 'tnp@gmail.com', 26, NULL, 3, 23, 'Enabled', '$2y$10$AaWHxMnt/yJxrURG62UZy.xrK9CzIxDt0ZZvDbxwjaGxqBUkmwc0y', 0, 1, 'UKYRDzyiLtpYW3VYQA0JorMmGTwsO5gBXLemP3KBrx3Y0sJTjibN67CPJKNL', NULL, '2017-02-07 10:46:07', NULL, NULL, NULL),
(146, 'tno', 'tno1@gmail.com', 26, NULL, 4, 0, 'Enabled', '$2y$10$zbXUP2Y4Oo2Wymcc70xZI.ntH0gLVRYpQkRsw.lTxgwt.VueePu46', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(147, 'tnp2', 'tnp2@gmail.com', 26, NULL, 3, 36, 'Enabled', '$2y$10$ldL2ETjgD6WnDxHmCjvIyeWNrl/IhD6jDCJieMlCDQBsFsHxM0mjS', 0, 1, 'KVyYv2XuohToK6ForINAySCnVwzh14LQaKtMDbNhtW2X3JDFh94uGKuwyOWt', NULL, '2017-02-07 17:48:24', NULL, NULL, NULL),
(148, 'net phy', 'netphy@gmail.com', 27, NULL, 3, 23, 'Enabled', '$2y$10$DrNwQV1uUwlfqSx/KZIfqusB38VNIZu1ku1gngiUMKNu7MGlMntRG', 0, 1, 'ebSt4XiXKX7fZO6QaKOhXfawVr3B53pdss6WCn92GeudeWwzROJ5yypgAKS8', NULL, '2017-02-07 12:39:54', NULL, NULL, NULL),
(149, 'net ord', 'netord@gmail.com', 27, NULL, 4, 0, 'Enabled', '$2y$10$4w0LkLw.udZaL0uYx4OAP./DKHSth6Cx5VTxcG1oZlwK2zlX5PJOa', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(150, 'er', 'south@gmail.com', 29, NULL, 3, 42, 'Enabled', '$2y$10$xpYo.79P2qAfHvcGR1XBgu5tmvIA0cIaW0TpO55I957AczV5FQySG', 0, 1, 'iNNOFqMOvbZXiwzyRy6CKqHu4NqkDsi9RyUDOEPECiJ8Agb35VSeQH3Fe55D', NULL, '2017-02-07 19:57:15', NULL, NULL, NULL),
(151, 'dfd', 'west@gmail.com', 29, NULL, 4, 0, 'Enabled', '$2y$10$NkfWpekmWrbypUvRRRYRb.SkjPITJm4gTlArLEBbkvrHe4mCNeQe2', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(152, 'Final Rep', 'east@gmail.com', 15, NULL, 5, 47, 'Enabled', '$2y$10$O6juRG2m6spRFWiIeMUpA.vOKiXXvRdH.YlK936evzbLGM7kpGJ9i', 0, 1, '0icKkwYGpOAePty83NieRK2skYMWGsGmGrPWMobtfGJ9zYsmXAOekU1FnLz3', NULL, '2017-02-07 20:13:50', '7852625252', 'test', 'user_05-12-17_1214pm_38564.jpg'),
(153, 'sdfs', 'sds@sds.dd', 31, NULL, 4, 0, 'Enabled', '$2y$10$hJbtv3r3zHqri8wEunA2ku5E0Y.DZIinfcIxNaoPJTnkit.Mmwpz6', 0, 1, '5rMxrCtmp33f4yW9VmTMo0bRFUTwm1yUXQiBU2lzSW1p2hS5UiukWRQBoFv5', NULL, '2017-02-07 20:11:46', NULL, NULL, NULL),
(157, 'Mani S', 'msr300789@gmail.com', 0, NULL, 2, 0, 'Enabled', '$2y$10$g52AYbI58.xnrNXUID9CEuLorEbQtmoquZefmly16op9PbWDqVQWC', 0, 1, 'suAPNqhp6mDaeDSFvVTSg3qfXS6FyFCtA06ByNNHs25nMcPrKpkiXmJqGTdl', NULL, '2017-05-17 12:38:49', NULL, NULL, NULL),
(160, 'Test User', 'srmkk300789@gmail.com', 31, NULL, 3, 45, 'Enabled', '$2y$10$DxlQW9z0Wnmpdu7KBBMHh.lGBuOjH0Jg.GmoM9/XxclO2/53RC3PO', 0, 1, 'XDYJ13uCHUtwNbY7GBfbejjlQj5YOqhe7LxZedNmUI1QYQkfLmFpdfTK9nol', NULL, '2017-05-12 14:37:42', NULL, NULL, NULL),
(161, 'Test Rep', 'southeast@gmail.com', 4, NULL, 5, 48, 'Enabled', '$2y$10$fJOEKOYHqiforPVBC4ynY.G93Yvlcqo0JACDv91Aydh1B7I5erx1O', 0, 0, NULL, NULL, NULL, '8000989731', 'test', 'user_05-12-17_1215pm_24885.jpg'),
(162, 'Meer', 'meerhirpara@gmail.com', 1, NULL, 5, 48, 'Enabled', '$2y$10$cT2GTd5naCj/zY.GCKp26uexOHzSn1aryax19t7hWZXzahrYzFa0C', 0, 0, NULL, '2017-05-10 16:26:27', '2017-05-10 16:26:27', '8000989731', 'Test rep', 'user_05-12-17_1216pm_24408.jpg'),
(164, 'Mani', 'srmb123@gmail.com', NULL, NULL, 2, NULL, 'Enabled', '$2y$10$bCn5yyrhsJC5rgS73ZPvee0dzHFEiPjyVXJmrq.QAPuKd.w4lAl9m', 0, 1, 'WmPsc2NlzVozG1bzY9cBjs9r4PSlOj6jgGyZSDBeo6HdgoUMxscaekLYnZFe', '2017-05-10 18:42:25', '2017-05-10 21:24:48', NULL, NULL, NULL),
(165, 'Mani 123', 'srmb1234@gmail.com', NULL, NULL, 3, NULL, 'Enabled', '$2y$10$6bRf/PxtvB6JF3APHIHKf.X/jL2LagtE/8sd27wLqyyqFKTijz5Jq', 0, 0, NULL, '2017-05-10 18:45:02', '2017-05-10 18:45:02', NULL, NULL, NULL),
(166, 'Order', 'srmb1235@gmail.com', 20, NULL, 4, NULL, 'Enabled', '$2y$10$vSeNlSURkrFk6VHR0z/tFO.DarJsgpBxJ5I62IzLOXkJt4DOfB31u', 0, 0, NULL, '2017-05-10 18:47:46', '2017-05-10 18:47:46', NULL, NULL, NULL),
(167, 'Rep', 'srmb1236@gmail.com', 3, NULL, 5, 48, 'Enabled', '$2y$10$C3fRTVzlHr5wONTC2yIYFO7Ge9elYwU/cMfss.F7rpn1go.k8WMtS', 0, 0, NULL, '2017-05-10 18:50:02', '2017-05-10 18:50:02', '989532232', 'Senior Manager', 'user_05-12-17_1216pm_59432.jpg'),
(168, 'First Phy', 'firstphy@gmail.com', NULL, NULL, 3, 42, 'Enabled', '$2y$10$twJ/0LE0SD8rb2zYAbEqnOeSajzAUF97D9E..YoDjSC5qjwwC6AFG', 0, 0, NULL, '2017-05-10 20:24:36', '2017-05-10 20:24:36', NULL, NULL, NULL),
(169, 'First Rep', 'firstrep@gmail.com', 19, NULL, 5, 42, 'Enabled', '$2y$10$tLKjXCZNUqfd/fJnCAP0KeCKhJTTcJsh90CZHMOW2tC8h6GMNTrDe', 0, 0, NULL, '2017-05-10 20:41:33', '2017-05-10 20:41:33', '987965654', 'Assistant Manager', 'user_05-12-17_1217pm_17954.jpg'),
(170, 'First Phy2', 'firstphy2@gmail.com', NULL, NULL, 3, 47, 'Enabled', '$2y$10$cdl5pbL5jGiNTJy1jFpc3u3o3krScm.G3u.Qmsl9fVCDDqWHEFilO', 0, 0, NULL, '2017-05-10 21:08:37', '2017-05-10 21:08:37', NULL, NULL, NULL),
(171, 'Dhaval', 'thummarpatel@gmail.com', 4, NULL, 5, 28, 'Enabled', '$2y$10$K463kb0pwmUMtPV8kLm7XOWio4sZwALZAKK/LwGw.WVn05dTUOmba', 0, 0, NULL, '2017-05-11 11:17:18', '2017-05-11 11:17:18', '4567251220', 'test', 'user_05-11-17_0417am_97300.jpg'),
(172, 'test10', 'test10@gmail.com', NULL, NULL, 3, 47, 'Enabled', '$2y$10$nZm.xCxkPN0VIBzzPCgKw.sv4a4dEo6tfYgoBOPLwg9idcwOc9R7K', 0, 0, NULL, '2017-05-11 11:19:21', '2017-05-11 11:19:21', NULL, NULL, NULL),
(173, 'Mani', '123mani@gmail.com', NULL, NULL, 3, 48, 'Enabled', '$2y$10$QksYrUsL.87uSru7qHQWm.VZ49zHVOs57v3vieAS77RViPN19Tn7m', 0, 1, '4yNtcK219TvP8mxxgP8EaIRK8ALM0Aath42lF8VVUbjhSg55Tv4hjZSICHrG', '2017-05-11 15:17:30', '2017-05-26 18:02:46', NULL, NULL, NULL),
(174, 'Rep', 'newrep123@gmail.com', 1, NULL, 5, 48, 'Enabled', '$2y$10$XsrKfhaADC4vr48autRbe.H.IGNZ4j5ahW5qdzx9z3mZjrdrCPfKm', 0, 0, NULL, '2017-05-11 15:19:49', '2017-05-11 15:19:49', '8768756565', 'Sr Mgr', 'user_05-12-17_1218pm_15732.jpg'),
(175, 'User', 'orderuser123@gmail.com', 17, NULL, 4, NULL, 'Enabled', '$2y$10$HJZXXMCBUQM2s76nwcmaGubVByAxVEXixlcravAOoWyIfPAHHUFCm', 0, 0, NULL, '2017-05-11 16:52:57', '2017-05-11 16:52:57', NULL, NULL, NULL),
(176, 'First Rep2', 'firstrep2@gmail.com', 19, NULL, 5, 50, 'Enabled', '$2y$10$94ToDPUDwY8pdeIPHAIttOqiwnm0H5eypYH5xdreyJxOKVcYEFXxW', 0, 0, NULL, '2017-05-12 11:28:27', '2017-05-12 11:28:27', '8678676562', 'Manager', 'user_05-12-17_1218pm_13929.jpg'),
(177, 'First Rep 3', 'firstrep3@gmail.com', 19, NULL, 5, 50, 'Enabled', '$2y$10$gwijmcW4tPAZ/7UfT9r90.M6O4AfeIwORk9e6yIzxTaQETORAsTCO', 0, 0, NULL, '2017-05-12 11:30:02', '2017-05-12 11:30:02', '8678676566', 'Asst.Manager', 'user_05-12-17_1219pm_19455.jpg'),
(178, 'First Order', 'firstorder1@gmail.com', 33, NULL, 2, NULL, 'Enabled', '$2y$10$LqQZUYu7Owko3fctp4E/RuTUekEva/aYfLLfx7/aoLMD3J3GZnEia', 0, 1, 'LGUi9yh3eUPCSmNg4jbck2uKTAPFndH1p5bltUKM4gF1TWbRcjVOIEOrBh9D', '2017-05-12 11:38:52', '2017-05-26 16:04:40', NULL, NULL, NULL),
(179, 'Rep', 'rep12@gmail.com', 19, NULL, 5, 48, 'Enabled', '$2y$10$nBFk4scarsMYPoy4s0nDZuJbvmomPz5mjmEqQyI5gsIvZK.w.7Z76', 0, 0, NULL, '2017-05-12 20:44:14', '2017-05-12 20:44:14', '97898466565', 'Sr Mgr', 'user_05-12-17_0144pm_35217.jpg'),
(180, 'Rep', 'rep123we@gmail.com', 4, NULL, 5, 48, 'Enabled', '$2y$10$aG6zu3H2k.dG5rqmHAwiJ.Ke8UHhbQvogv34DT/CD0xL7q7eoW512', 0, 0, NULL, '2017-05-12 21:58:17', '2017-05-12 21:58:17', '9746546565', 'Senior Manager', 'user_05-12-17_0258pm_31977.jpg'),
(181, 'Punit', 'punitkathiriya@gmail.com', NULL, NULL, 1, NULL, 'Enabled', '$2y$10$eygYdh2hOzd74jg7AFXeeey.qk6Nt0YrLb3sFd6O3w49JHbmsYx12', 0, 0, NULL, '2017-05-13 17:52:52', '2017-05-13 17:52:52', NULL, NULL, NULL),
(182, 'New User', 'newuser@gmail.com', NULL, NULL, 3, 48, 'Enabled', '$2y$10$fxkA6X2VtxR5MdwZ7gPwe.jxAB5e5fFNP2cjWDkHZ3Dk9r/U7FiOq', 0, 0, NULL, '2017-05-15 12:54:50', '2017-05-15 12:54:50', NULL, NULL, NULL),
(183, 'Nash Phy', 'nash5725@outlook.com', NULL, NULL, 3, 48, 'Enabled', '$2y$10$U7t0VsjU86U6.xc1AoCpfOcP/l0AG/n5MrdHXpIavhMthF/.5FT/y', 0, 1, NULL, '2017-05-25 18:02:30', '2017-05-25 18:02:30', NULL, NULL, NULL),
(184, 'Mani SR', 'manikandakumar7@outlook.com', NULL, NULL, 3, 48, 'Enabled', '$2y$10$z5ynP8WTt6qEEKuE4wnyfuNT9/cXjhs8JEY67y47hZZmiC1/.iug6', 0, 1, 'k2mSUxgfdDV0Y3l3KJGhLagP4XRhoLRTwvpT9orqKX1tj2fhtIx6C8xdcCKa', '2017-05-26 14:08:36', '2017-05-29 20:13:27', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_clients`
--

CREATE TABLE `user_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `clientId` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_clients`
--

INSERT INTO `user_clients` (`id`, `userId`, `clientId`, `created_at`, `updated_at`) VALUES
(1, 50, 20, '2017-05-10 13:00:28', '2017-05-10 13:00:28'),
(2, 51, 20, '2017-05-10 13:00:28', '2017-05-10 13:00:28'),
(3, 62, 3, '2017-05-10 13:00:28', '2017-05-10 13:00:28'),
(4, 70, 10, '2017-05-10 13:00:28', '2017-05-10 13:00:28'),
(5, 76, 5, '2017-05-10 13:00:28', '2017-05-10 13:00:28'),
(367, 183, 16, NULL, NULL),
(361, 81, 15, NULL, NULL),
(8, 92, 15, '2017-05-10 13:00:28', '2017-05-10 13:00:28'),
(9, 94, 15, '2017-05-10 13:00:28', '2017-05-10 13:00:28'),
(139, 96, 15, NULL, NULL),
(11, 98, 16, '2017-05-10 13:00:28', '2017-05-10 13:00:28'),
(376, 106, 33, NULL, NULL),
(13, 122, 15, '2017-05-10 13:00:28', '2017-05-10 13:00:28'),
(14, 125, 15, '2017-05-10 13:00:28', '2017-05-10 13:00:28'),
(359, 132, 15, NULL, NULL),
(16, 133, 20, '2017-05-10 13:00:28', '2017-05-10 13:00:28'),
(17, 135, 20, '2017-05-10 13:00:28', '2017-05-10 13:00:28'),
(18, 136, 23, '2017-05-10 13:00:28', '2017-05-10 13:00:28'),
(19, 137, 23, '2017-05-10 13:00:28', '2017-05-10 13:00:28'),
(20, 139, 23, '2017-05-10 13:00:28', '2017-05-10 13:00:28'),
(309, 140, 33, NULL, NULL),
(22, 145, 26, '2017-05-10 13:00:28', '2017-05-10 13:00:28'),
(23, 146, 26, '2017-05-10 13:00:28', '2017-05-10 13:00:28'),
(24, 147, 26, '2017-05-10 13:00:28', '2017-05-10 13:00:28'),
(25, 148, 27, '2017-05-10 13:00:28', '2017-05-10 13:00:28'),
(26, 149, 27, '2017-05-10 13:00:28', '2017-05-10 13:00:28'),
(27, 150, 29, '2017-05-10 13:00:28', '2017-05-10 13:00:28'),
(28, 151, 29, '2017-05-10 13:00:28', '2017-05-10 13:00:28'),
(29, 153, 31, '2017-05-10 13:00:28', '2017-05-10 13:00:28'),
(32, 160, 27, NULL, NULL),
(33, 160, 31, NULL, NULL),
(34, 160, 32, NULL, NULL),
(261, 161, 15, NULL, NULL),
(375, 106, 17, NULL, NULL),
(374, 106, 16, NULL, NULL),
(64, 164, 17, NULL, NULL),
(63, 164, 16, NULL, NULL),
(62, 164, 15, NULL, NULL),
(53, 165, 15, NULL, NULL),
(54, 165, 16, NULL, NULL),
(55, 165, 17, NULL, NULL),
(56, 166, 20, NULL, NULL),
(58, 157, 15, NULL, NULL),
(59, 157, 16, NULL, NULL),
(60, 157, 20, NULL, NULL),
(65, 168, 15, NULL, NULL),
(66, 168, 16, NULL, NULL),
(67, 168, 17, NULL, NULL),
(68, 168, 33, NULL, NULL),
(277, 169, 33, NULL, NULL),
(276, 169, 17, NULL, NULL),
(275, 169, 16, NULL, NULL),
(274, 169, 15, NULL, NULL),
(85, 170, 33, NULL, NULL),
(366, 183, 15, NULL, NULL),
(190, 172, 33, NULL, NULL),
(257, 152, 17, NULL, NULL),
(256, 152, 16, NULL, NULL),
(189, 172, 17, NULL, NULL),
(188, 172, 16, NULL, NULL),
(187, 172, 15, NULL, NULL),
(365, 104, 33, NULL, NULL),
(364, 104, 16, NULL, NULL),
(363, 104, 15, NULL, NULL),
(289, 174, 33, NULL, NULL),
(288, 174, 31, NULL, NULL),
(287, 174, 22, NULL, NULL),
(286, 174, 17, NULL, NULL),
(285, 174, 16, NULL, NULL),
(181, 173, 17, NULL, NULL),
(117, 175, 17, NULL, NULL),
(284, 174, 15, NULL, NULL),
(214, 99, 17, NULL, NULL),
(213, 99, 16, NULL, NULL),
(212, 99, 15, NULL, NULL),
(236, 127, 17, NULL, NULL),
(235, 127, 16, NULL, NULL),
(234, 127, 15, NULL, NULL),
(348, 176, 33, NULL, NULL),
(266, 162, 17, NULL, NULL),
(265, 162, 15, NULL, NULL),
(140, 96, 16, NULL, NULL),
(141, 96, 20, NULL, NULL),
(142, 96, 33, NULL, NULL),
(224, 102, 33, NULL, NULL),
(223, 102, 16, NULL, NULL),
(222, 102, 15, NULL, NULL),
(347, 176, 16, NULL, NULL),
(346, 176, 15, NULL, NULL),
(345, 176, 1, NULL, NULL),
(353, 177, 33, NULL, NULL),
(352, 177, 17, NULL, NULL),
(351, 177, 16, NULL, NULL),
(350, 177, 15, NULL, NULL),
(369, 178, 16, NULL, NULL),
(373, 106, 15, NULL, NULL),
(232, 105, 33, NULL, NULL),
(231, 105, 16, NULL, NULL),
(230, 105, 15, NULL, NULL),
(255, 152, 15, NULL, NULL),
(216, 100, 15, NULL, NULL),
(218, 101, 15, NULL, NULL),
(219, 101, 16, NULL, NULL),
(220, 101, 33, NULL, NULL),
(238, 129, 15, NULL, NULL),
(239, 129, 16, NULL, NULL),
(240, 129, 33, NULL, NULL),
(242, 130, 15, NULL, NULL),
(243, 130, 16, NULL, NULL),
(244, 130, 33, NULL, NULL),
(246, 134, 15, NULL, NULL),
(247, 134, 16, NULL, NULL),
(248, 134, 33, NULL, NULL),
(250, 138, 15, NULL, NULL),
(251, 138, 16, NULL, NULL),
(252, 138, 17, NULL, NULL),
(253, 138, 33, NULL, NULL),
(258, 152, 22, NULL, NULL),
(259, 152, 33, NULL, NULL),
(262, 161, 17, NULL, NULL),
(263, 161, 33, NULL, NULL),
(267, 162, 33, NULL, NULL),
(269, 167, 15, NULL, NULL),
(270, 167, 16, NULL, NULL),
(271, 167, 31, NULL, NULL),
(272, 167, 33, NULL, NULL),
(343, 171, 33, NULL, NULL),
(342, 171, 17, NULL, NULL),
(341, 171, 16, NULL, NULL),
(308, 140, 16, NULL, NULL),
(307, 140, 15, NULL, NULL),
(306, 140, 1, NULL, NULL),
(318, 179, 22, NULL, NULL),
(317, 179, 17, NULL, NULL),
(316, 179, 16, NULL, NULL),
(315, 179, 15, NULL, NULL),
(319, 179, 33, NULL, NULL),
(326, 180, 20, NULL, NULL),
(325, 180, 16, NULL, NULL),
(324, 180, 15, NULL, NULL),
(327, 180, 33, NULL, NULL),
(334, 182, 33, NULL, NULL),
(333, 182, 16, NULL, NULL),
(332, 182, 15, NULL, NULL),
(335, 182, 34, NULL, NULL),
(377, 184, 15, NULL, NULL),
(378, 184, 16, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_projects`
--

CREATE TABLE `user_projects` (
  `id` int(10) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `projectId` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_projects`
--

INSERT INTO `user_projects` (`id`, `userId`, `projectId`, `created_at`, `updated_at`) VALUES
(1, 51, 35, '2017-05-10 13:44:31', '2017-05-10 13:44:31'),
(2, 62, 2, '2017-05-10 13:44:31', '2017-05-10 13:44:31'),
(3, 94, 23, '2017-05-10 13:44:31', '2017-05-10 13:44:31'),
(4, 96, 23, '2017-05-10 13:44:31', '2017-05-10 13:44:31'),
(5, 122, 23, '2017-05-10 13:44:31', '2017-05-10 13:44:31'),
(18, 132, 42, NULL, NULL),
(7, 135, 23, '2017-05-10 13:44:31', '2017-05-10 13:44:31'),
(8, 136, 36, '2017-05-10 13:44:31', '2017-05-10 13:44:31'),
(9, 139, 37, '2017-05-10 13:44:31', '2017-05-10 13:44:31'),
(10, 145, 23, '2017-05-10 13:44:31', '2017-05-10 13:44:31'),
(11, 147, 36, '2017-05-10 13:44:31', '2017-05-10 13:44:31'),
(12, 148, 23, '2017-05-10 13:44:31', '2017-05-10 13:44:31'),
(13, 150, 42, '2017-05-10 13:44:31', '2017-05-10 13:44:31'),
(15, 160, 23, NULL, NULL),
(16, 160, 46, NULL, NULL),
(17, 160, 45, NULL, NULL),
(19, 165, 35, NULL, NULL),
(20, 168, 42, '2017-05-14 11:12:51', '2017-05-14 11:12:51'),
(21, 170, 47, '2017-05-14 11:12:51', '2017-05-14 11:12:51'),
(22, 172, 47, '2017-05-14 11:12:51', '2017-05-14 11:12:51'),
(23, 173, 48, '2017-05-14 11:12:51', '2017-05-14 11:12:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_project_name_foreign` (`project_name`);

--
-- Indexes for table `category_sort`
--
ALTER TABLE `category_sort`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_sort_client_name_foreign` (`client_name`),
  ADD KEY `category_sort_category_name_foreign` (`category_name`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clients_state_foreign` (`state`);

--
-- Indexes for table `client_custom_field`
--
ALTER TABLE `client_custom_field`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_custom_field_device_id_foreign` (`device_id`),
  ADD KEY `client_custom_field_client_name_foreign` (`client_name`),
  ADD KEY `client_custom_field_c_id_foreign` (`c_id`);

--
-- Indexes for table `client_price`
--
ALTER TABLE `client_price`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_price_device_id_foreign` (`device_id`),
  ADD KEY `client_price_client_name_foreign` (`client_name`),
  ADD KEY `client_price_order_email_foreign` (`order_email`);

--
-- Indexes for table `custom_contact_info`
--
ALTER TABLE `custom_contact_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `custom_contact_info_clientid_foreign` (`clientId`),
  ADD KEY `custom_contact_info_deviceid_foreign` (`deviceId`),
  ADD KEY `custom_contact_info_order_email_foreign` (`order_email`);

--
-- Indexes for table `device`
--
ALTER TABLE `device`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_project_name_foreign` (`project_name`),
  ADD KEY `device_category_name_foreign` (`category_name`),
  ADD KEY `device_manufacturer_name_foreign` (`manufacturer_name`),
  ADD KEY `device_rep_email_foreign` (`rep_email`);

--
-- Indexes for table `device_custom_field`
--
ALTER TABLE `device_custom_field`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_custom_field_device_id_foreign` (`device_id`),
  ADD KEY `device_custom_field_client_name_foreign` (`client_name`);

--
-- Indexes for table `device_features`
--
ALTER TABLE `device_features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_features_device_id_foreign` (`device_id`),
  ADD KEY `device_features_client_name_foreign` (`client_name`);

--
-- Indexes for table `item_files`
--
ALTER TABLE `item_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_files_clientid_foreign` (`clientId`);

--
-- Indexes for table `item_files_details`
--
ALTER TABLE `item_files_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_file_entry`
--
ALTER TABLE `item_file_entry`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_file_entry_repcaseid_foreign` (`repcaseID`),
  ADD KEY `item_file_entry_supplyitem_foreign` (`supplyItem`);

--
-- Indexes for table `loginuser`
--
ALTER TABLE `loginuser`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manufacturers`
--
ALTER TABLE `manufacturers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `month`
--
ALTER TABLE `month`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_manufacturer_name_foreign` (`manufacturer_name`),
  ADD KEY `orders_orderby_foreign` (`orderby`),
  ADD KEY `orders_rep_foreign` (`rep`),
  ADD KEY `orders_clientid_foreign` (`clientId`),
  ADD KEY `orders_deviceid_foreign` (`deviceId`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_clients`
--
ALTER TABLE `project_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_clients_project_id_foreign` (`project_id`),
  ADD KEY `project_clients_client_name_foreign` (`client_name`);

--
-- Indexes for table `rep_case_details`
--
ALTER TABLE `rep_case_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rep_case_details_clientid_foreign` (`clientId`),
  ADD KEY `rep_case_details_physicianid_foreign` (`physicianId`),
  ADD KEY `rep_case_details_categoryid_foreign` (`categoryId`),
  ADD KEY `rep_case_details_manufacturerid_foreign` (`manufacturerId`);

--
-- Indexes for table `rep_contact_info`
--
ALTER TABLE `rep_contact_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rep_contact_info_deviceid_foreign` (`deviceId`),
  ADD KEY `rep_contact_info_repid_foreign` (`repId`);

--
-- Indexes for table `roll`
--
ALTER TABLE `roll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedule_project_name_foreign` (`project_name`),
  ADD KEY `schedule_client_name_foreign` (`client_name`),
  ADD KEY `schedule_physician_name_foreign` (`physician_name`),
  ADD KEY `schedule_manufacturer_foreign` (`manufacturer`),
  ADD KEY `schedule_device_name_foreign` (`device_name`);

--
-- Indexes for table `scorecards`
--
ALTER TABLE `scorecards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scorecards_userid_foreign` (`userId`),
  ADD KEY `scorecards_monthid_foreign` (`monthId`);

--
-- Indexes for table `scorecard_images`
--
ALTER TABLE `scorecard_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scorecard_images_scorecardid_foreign` (`scorecardId`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey`
--
ALTER TABLE `survey`
  ADD PRIMARY KEY (`id`),
  ADD KEY `survey_clientid_foreign` (`clientId`),
  ADD KEY `survey_deviceid_foreign` (`deviceId`);

--
-- Indexes for table `survey_answer`
--
ALTER TABLE `survey_answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `survey_answer_user_id_foreign` (`user_id`),
  ADD KEY `survey_answer_surveyid_foreign` (`surveyId`),
  ADD KEY `survey_answer_deviceid_foreign` (`deviceId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_roll_foreign` (`roll`),
  ADD KEY `users_projectname_foreign` (`projectname`);

--
-- Indexes for table `user_clients`
--
ALTER TABLE `user_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_clients_userid_foreign` (`userId`),
  ADD KEY `user_clients_clientid_foreign` (`clientId`);

--
-- Indexes for table `user_projects`
--
ALTER TABLE `user_projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_projects_userid_foreign` (`userId`),
  ADD KEY `user_projects_projectid_foreign` (`projectId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
--
-- AUTO_INCREMENT for table `category_sort`
--
ALTER TABLE `category_sort`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=335;
--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `client_custom_field`
--
ALTER TABLE `client_custom_field`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=276;
--
-- AUTO_INCREMENT for table `client_price`
--
ALTER TABLE `client_price`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=271;
--
-- AUTO_INCREMENT for table `custom_contact_info`
--
ALTER TABLE `custom_contact_info`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `device`
--
ALTER TABLE `device`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;
--
-- AUTO_INCREMENT for table `device_custom_field`
--
ALTER TABLE `device_custom_field`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=209;
--
-- AUTO_INCREMENT for table `device_features`
--
ALTER TABLE `device_features`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;
--
-- AUTO_INCREMENT for table `item_files`
--
ALTER TABLE `item_files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `item_files_details`
--
ALTER TABLE `item_files_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `item_file_entry`
--
ALTER TABLE `item_file_entry`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `loginuser`
--
ALTER TABLE `loginuser`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `manufacturers`
--
ALTER TABLE `manufacturers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `month`
--
ALTER TABLE `month`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=364;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `project_clients`
--
ALTER TABLE `project_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=295;
--
-- AUTO_INCREMENT for table `rep_case_details`
--
ALTER TABLE `rep_case_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rep_contact_info`
--
ALTER TABLE `rep_contact_info`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `roll`
--
ALTER TABLE `roll`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;
--
-- AUTO_INCREMENT for table `scorecards`
--
ALTER TABLE `scorecards`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `scorecard_images`
--
ALTER TABLE `scorecard_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;
--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `survey`
--
ALTER TABLE `survey`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
--
-- AUTO_INCREMENT for table `survey_answer`
--
ALTER TABLE `survey_answer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;
--
-- AUTO_INCREMENT for table `user_clients`
--
ALTER TABLE `user_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=379;
--
-- AUTO_INCREMENT for table `user_projects`
--
ALTER TABLE `user_projects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
