-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2020 at 12:35 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `storesmanage`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_08_19_000000_create_failed_jobs_table', 1),
(2, '2020_02_08_202958_create_stores_table', 1),
(3, '2020_02_17_210840_create_store_catigories_table', 2),
(4, '2020_02_17_222303_create_store_products_table', 3),
(5, '2020_02_19_201958_create_store_pics_table', 4),
(7, '2020_02_22_201556_create_store_employees_table', 6),
(8, '2020_02_20_145536_create_res_tables_table', 7),
(9, '2020_02_24_173812_create_store_orders_table', 8),
(10, '2020_03_02_182917_create_store_repos_table', 9),
(11, '2020_03_03_211345_create_store_rep_prods_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `res_tables`
--

CREATE TABLE `res_tables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `TableName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TableMaxSeat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TableStatus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TableOrder` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TableStoreId` varchar(21) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `StoreName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `StoreToken` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `StoreUser` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `StoreType` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `created_at`, `updated_at`, `StoreName`, `StoreToken`, `StoreUser`, `StoreType`) VALUES
(11, '2020-03-05 21:18:03', '2020-03-05 21:18:03', 'BlaxkResturant', NULL, '47', 'pharmasy');

-- --------------------------------------------------------

--
-- Table structure for table `store_catigories`
--

CREATE TABLE `store_catigories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `CatigoryName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CatigoryProdsNum` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CatigoryStoreId` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_catigories`
--

INSERT INTO `store_catigories` (`id`, `created_at`, `updated_at`, `CatigoryName`, `CatigoryProdsNum`, `CatigoryStoreId`) VALUES
(5, '2020-03-05 21:18:38', '2020-03-05 21:20:22', 'mobile', '3', '11');

-- --------------------------------------------------------

--
-- Table structure for table `store_employees`
--

CREATE TABLE `store_employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `EmployeeName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EmployeeAge` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EmployeeGender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EmployeeStatus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EmployeeFee` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EmployeeDP` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EmployeeMS` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EmployeeStoreId` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EmployeeType` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_employees`
--

INSERT INTO `store_employees` (`id`, `created_at`, `updated_at`, `EmployeeName`, `EmployeeAge`, `EmployeeGender`, `EmployeeStatus`, `EmployeeFee`, `EmployeeDP`, `EmployeeMS`, `EmployeeStoreId`, `EmployeeType`) VALUES
(6, '2020-03-05 21:18:55', '2020-03-05 21:18:55', 'ahmed al-aswad', '23', 'male', '0', '60000', '0', 'single', '11', 'Casher'),
(7, '2020-03-05 21:19:15', '2020-03-05 21:19:15', 'ahmed al-aswad', '23', 'male', '0', '20000', '0', 'single', '11', 'Delivery');

-- --------------------------------------------------------

--
-- Table structure for table `store_orders`
--

CREATE TABLE `store_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `OrderName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `OrderType` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `OrderCart` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `OrderStatus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `OrderPrice` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `OrderBy` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `OrderPayment` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `OrderStoreId` varchar(22) COLLATE utf8mb4_unicode_ci NOT NULL,
  `OrderInf` varchar(600) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_pics`
--

CREATE TABLE `store_pics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ProdId` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PicSource` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_pics`
--

INSERT INTO `store_pics` (`id`, `created_at`, `updated_at`, `ProdId`, `PicSource`) VALUES
(1, '2020-02-19 21:07:16', '2020-02-19 21:07:16', NULL, 'default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `store_products`
--

CREATE TABLE `store_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ProdName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ProdCatigory` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ProdPrice` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ProdStoreId` int(22) NOT NULL,
  `ProdImg` varchar(320) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_products`
--

INSERT INTO `store_products` (`id`, `created_at`, `updated_at`, `ProdName`, `ProdCatigory`, `ProdPrice`, `ProdStoreId`, `ProdImg`) VALUES
(2, '2020-03-05 21:19:55', '2020-03-05 21:19:55', 'xaomi redmi 8+', '5', '123', 11, '1'),
(3, '2020-03-05 21:20:04', '2020-03-05 21:20:04', 'xaomi redmi 7', '5', '123', 11, '1'),
(4, '2020-03-05 21:20:22', '2020-03-05 21:20:22', 'first product', '5', '123', 11, '1');

-- --------------------------------------------------------

--
-- Table structure for table `store_repos`
--

CREATE TABLE `store_repos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `RepoName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `RepoAddress` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `RepoStoreId` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_repos`
--

INSERT INTO `store_repos` (`id`, `created_at`, `updated_at`, `RepoName`, `RepoAddress`, `RepoStoreId`) VALUES
(1, '2020-03-02 16:39:12', '2020-03-02 16:39:12', 'testRepo', 'syria aleppo', '5'),
(2, '2020-03-05 20:44:30', '2020-03-05 20:44:30', 'asdasd', '12121', '8'),
(3, '2020-03-05 20:44:45', '2020-03-05 20:44:45', 'asdasd', '12121', '8'),
(4, '2020-03-05 20:45:26', '2020-03-05 20:45:26', 'asdasd', '2123', '9'),
(5, '2020-03-05 20:48:17', '2020-03-05 20:48:17', 'asdasd', '2123', '9'),
(7, '2020-03-05 20:59:28', '2020-03-05 20:59:28', 'asdasd', '2123', '9'),
(8, '2020-03-05 20:59:46', '2020-03-05 20:59:46', 'asdasd', '2123', '9');

-- --------------------------------------------------------

--
-- Table structure for table `store_rep_prods`
--

CREATE TABLE `store_rep_prods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `RProdName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `RProdQty` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `RProdRepo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `RProdSource` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_rep_prods`
--

INSERT INTO `store_rep_prods` (`id`, `created_at`, `updated_at`, `RProdName`, `RProdQty`, `RProdRepo`, `RProdSource`) VALUES
(2, '2020-03-03 20:17:48', '2020-03-03 20:17:48', 'aasd', 'test', '1', 'asdas');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `FullName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `UserName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PlanType` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PlanDayLeft` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `validationToken` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `UserStatus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `FullName`, `UserName`, `Email`, `password`, `Address`, `PlanType`, `PlanDayLeft`, `validationToken`, `UserStatus`, `created_at`, `updated_at`) VALUES
(4, 'ahmedd ali', 'deamdan3002014@gmail.com', 'deadman3002014@gmail.com', '$2y$10$mE7xg23kIhkhMvGxIqv/6efCJnuSMUl0f.u0AzKXFfwzCM8LFh0BG', 'syria aleppo', '4', '363', 'f1241319b1622f0b1820360bbc92b299', '1', '2020-02-10 15:19:29', '2020-02-16 18:59:42'),
(5, 'mohmed ali', 'deadman5002015', 'deadman5002015@gmail.com', '$2y$10$Lm6KNf8ZYrWkX8z.cG.pLu/bTmnBWLuttrZfO5Y5axPnUMInC/8WC', 'syria-alepooo', '2', '28', '0b370a1d54e68a69ddad10fd96e2a08e', '1', '2020-02-10 15:43:38', '2020-02-16 18:59:42'),
(19, 'ahmed', 'deadman1002015', 'deadman1002015@gmail.com', '$2y$10$wPNwIxBvahCufBtMZom4T.5owLH9WPzx7a1pI.hGuGKcpimtlEAhC', 'syria aleppo', '0', '0', '39547e49a02f773be53d3db6ddf0cd2f', '1', '2020-02-16 17:48:47', '2020-02-16 18:59:42'),
(43, 'ahmed', 'deadman10020199', 'deadman1002014@localhost.com', '$2y$10$hR788tAQzQM04JcV/e/uCeSXo8JjADxF.42IB6cfao0VY2aVmbK5e', 'syria aleppo', '0', '0', 'd5d7af08987101c3f9d68ca8ebd0dafb', '1', '2020-03-01 16:10:09', '2020-03-01 19:56:08'),
(46, 'deadman962011', 'deadman1002014', 'deadman1002014@gmail.com', '$2y$10$pjvLE41cArs.EYZvWIMkQeOn2ElGczXH5OZP3suODG.dhgoNQO2ea', 'syria aleppo', '0', '0', '915a1e6fc18b254261f249ef359a0b80', '0', '2020-03-04 16:30:29', '2020-03-04 16:30:29'),
(47, 'mohmed ali', 'deadman962011', 'deadman962011@gmail.com', '$2y$10$fjQfJunPCnz/7vJWGNyrZeAirv/49uESDU3BimA20l/FA4ERy2rtm', 'syria aleppo', '2', '90', 'b1633a290e3fb59306cf71af26347ea0', '1', '2020-03-04 16:31:46', '2020-03-04 17:41:43'),
(48, 'mohmed ali', 'deadman1002018', 'deadman1002018@localhost.com', '$2y$10$FKd1d62r/WBBbeFrRwVzyew6xiakcNxDBxoqI3cuAMWThh8cHMeZK', 'syria aleppo', '0', '0', 'c708d06f65181c5eed203b63c6f538c4', '0', '2020-03-05 21:34:25', '2020-03-05 21:34:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `res_tables`
--
ALTER TABLE `res_tables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_catigories`
--
ALTER TABLE `store_catigories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_employees`
--
ALTER TABLE `store_employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_orders`
--
ALTER TABLE `store_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_pics`
--
ALTER TABLE `store_pics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_products`
--
ALTER TABLE `store_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_repos`
--
ALTER TABLE `store_repos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_rep_prods`
--
ALTER TABLE `store_rep_prods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `res_tables`
--
ALTER TABLE `res_tables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `store_catigories`
--
ALTER TABLE `store_catigories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `store_employees`
--
ALTER TABLE `store_employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `store_orders`
--
ALTER TABLE `store_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store_pics`
--
ALTER TABLE `store_pics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `store_products`
--
ALTER TABLE `store_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `store_repos`
--
ALTER TABLE `store_repos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `store_rep_prods`
--
ALTER TABLE `store_rep_prods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
