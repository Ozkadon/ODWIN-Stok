-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2018 at 12:24 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.1.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `odwin_stok`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_control`
--

CREATE TABLE `access_control` (
  `id` int(11) NOT NULL,
  `user_level_id` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `content` text,
  `user_modified` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `access_control`
--

INSERT INTO `access_control` (`id`, `user_level_id`, `module_id`, `content`, `user_modified`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'a', 1, '2017-10-17 09:26:05', '2017-10-17 09:26:05'),
(2, 1, 2, 'a', 1, '2017-10-17 09:26:05', '2017-10-17 09:26:05'),
(3, 1, 3, 'a', 1, '2017-10-17 09:26:05', '2017-10-17 09:26:05'),
(4, 2, 1, 'a', 1, '2017-10-17 09:26:13', '2018-07-02 06:15:53'),
(5, 2, 2, 'a', 1, '2017-10-17 09:26:13', '2018-07-02 06:15:53'),
(6, 2, 3, 'a', 1, '2017-10-17 09:26:13', '2018-07-02 06:15:53'),
(7, 3, 1, 'v', 1, '2017-10-17 09:26:18', '2018-06-03 06:05:32'),
(8, 3, 2, 'v', 1, '2017-10-17 09:26:18', '2018-06-03 06:05:32'),
(9, 3, 3, 'v', 1, '2017-10-17 09:26:18', '2018-06-03 06:05:32'),
(10, 1, 4, 'a', 1, '2018-07-02 06:15:50', '2018-07-02 06:15:50'),
(11, 2, 4, 'a', 1, '2018-07-02 06:15:53', '2018-07-02 06:15:53'),
(12, 3, 4, 'v', 1, '2018-07-02 06:15:56', '2018-07-02 06:15:56'),
(13, 1, 5, 'a', 1, '2018-07-02 08:28:39', '2018-07-02 08:28:39'),
(14, 2, 5, 'a', 1, '2018-07-02 08:28:43', '2018-07-02 08:28:43'),
(15, 3, 5, 'v', 1, '2018-07-02 08:28:45', '2018-07-02 08:28:45'),
(16, 1, 6, 'a', 1, '2018-07-03 07:02:26', '2018-07-03 07:02:26'),
(17, 2, 6, 'a', 1, '2018-07-03 07:02:29', '2018-07-03 07:02:29'),
(18, 3, 6, 'v', 1, '2018-07-03 07:02:31', '2018-07-03 07:02:31'),
(19, 1, 7, 'a', 1, '2018-07-03 08:32:29', '2018-07-03 08:32:29'),
(20, 2, 7, 'a', 1, '2018-07-03 08:32:32', '2018-07-03 08:32:32'),
(21, 3, 7, 'v', 1, '2018-07-03 08:32:35', '2018-07-03 08:32:35'),
(22, 1, 8, 'a', 1, '2018-07-03 12:39:25', '2018-07-03 12:39:25'),
(23, 2, 8, 'a', 1, '2018-07-03 12:39:30', '2018-07-03 12:39:30'),
(24, 3, 8, 'v', 1, '2018-07-03 12:39:34', '2018-07-03 12:39:34');

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `kode` varchar(45) DEFAULT NULL,
  `nama` varchar(300) DEFAULT NULL,
  `harga_beli` int(11) DEFAULT NULL,
  `harga_jual` int(11) DEFAULT NULL,
  `keterangan` text,
  `active` int(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_modified` int(11) DEFAULT NULL,
  `stok_awal` int(11) UNSIGNED DEFAULT '0',
  `stok_total` int(11) DEFAULT '0',
  `img_id` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `kode`, `nama`, `harga_beli`, `harga_jual`, `keterangan`, `active`, `created_at`, `updated_at`, `user_modified`, `stok_awal`, `stok_total`, `img_id`) VALUES
(1, 'MB001', 'Barang 1', 25000, 27000, 'Keterangan 1', 1, '2018-07-03 07:37:19', '2018-07-04 05:41:27', 1, 30, 34, 1),
(2, 'MB002', 'Barang 2', 50000, 55000, 'Keterangan 2', 1, '2018-07-03 07:37:34', '2018-07-04 10:12:54', 1, 50, 58, 0);

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `address` text,
  `email` varchar(100) DEFAULT NULL,
  `contact` varchar(45) DEFAULT NULL,
  `subject` varchar(150) DEFAULT NULL,
  `message` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `read` int(1) DEFAULT NULL,
  `active` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `media_library`
--

CREATE TABLE `media_library` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `url` varchar(300) DEFAULT NULL,
  `size` varchar(10) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `media_library`
--

INSERT INTO `media_library` (`id`, `name`, `type`, `url`, `size`, `user_created`, `created_at`, `updated_at`) VALUES
(0, 'noprofileimage', 'png', 'img/noprofileimage.png', '1159', 1, '2017-05-29 19:56:03', '2017-05-29 19:56:03'),
(1, 'tumblr_o8dmovrRZ21v9dlz9o9_250', 'png', 'upload/img/tumblr_o8dmovrRZ21v9dlz9o9_250.png', '76098', 1, '2018-07-03 06:40:43', '2018-07-03 06:40:43'),
(2, 'tumblr_oo8kv5a44d1s81jsfo2_250', 'png', 'upload/img/tumblr_oo8kv5a44d1s81jsfo2_250.png', '76301', 1, '2018-07-03 06:40:43', '2018-07-03 06:40:43');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `slug` varchar(20) DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `user_modified` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `slug`, `active`, `user_modified`, `created_at`, `updated_at`) VALUES
(1, 'Master User Level', 'users-level', 1, 1, '2017-10-17 07:07:07', '2017-10-17 07:43:43'),
(2, 'Master User', 'users-user', 1, 1, '2017-10-17 07:16:51', '2017-10-17 07:49:30'),
(3, 'Media Library', 'media-library', 1, 1, '2017-10-17 07:19:28', '2018-06-03 05:40:18'),
(4, 'Master Supplier', 'supplier', 1, 1, '2018-07-02 06:15:45', '2018-07-02 06:15:45'),
(5, 'Master Barang', 'barang', 1, 1, '2018-07-02 08:28:31', '2018-07-02 08:28:31'),
(6, 'Purchase Order', 'purchase-order', 1, 1, '2018-07-03 07:02:20', '2018-07-03 07:02:20'),
(7, 'Daftar Inden', 'inden', 1, 1, '2018-07-03 08:32:24', '2018-07-03 08:32:24'),
(8, 'Penjualan', 'penjualan', 1, 1, '2018-07-03 12:39:19', '2018-07-03 12:39:19');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_d`
--

CREATE TABLE `penjualan_d` (
  `id` int(11) NOT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_penjualan` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan_d`
--

INSERT INTO `penjualan_d` (`id`, `id_barang`, `jumlah`, `harga`, `created_at`, `updated_at`, `id_penjualan`) VALUES
(1, 2, 2, 55000, '2018-07-04 03:22:20', '2018-07-04 03:22:20', 1),
(2, 1, 3, 27000, '2018-07-04 03:22:20', '2018-07-04 03:22:20', 1),
(3, 1, 1, 27000, '2018-07-04 03:27:31', '2018-07-04 03:27:31', 2),
(4, 2, 2, 55000, '2018-07-04 03:27:31', '2018-07-04 03:27:31', 2);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_h`
--

CREATE TABLE `penjualan_h` (
  `id` int(11) NOT NULL,
  `no_nota` varchar(45) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_modified` int(11) DEFAULT NULL,
  `keterangan` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan_h`
--

INSERT INTO `penjualan_h` (`id`, `no_nota`, `tanggal`, `total`, `active`, `created_at`, `updated_at`, `user_modified`, `keterangan`) VALUES
(1, 'NOT/0001', '2018-07-04', 191000, 0, '2018-07-04 03:22:20', '2018-07-04 03:26:44', 1, 'Keterangan Penjualan'),
(2, 'NOT/0001', '2018-07-04', 137000, 1, '2018-07-04 03:27:31', '2018-07-04 03:27:31', 1, 'Keterangan Penjualan');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_d`
--

CREATE TABLE `purchase_d` (
  `id` int(11) NOT NULL,
  `id_purchase` int(11) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_d`
--

INSERT INTO `purchase_d` (`id`, `id_purchase`, `id_barang`, `jumlah`, `harga`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 5, 25000, '2018-07-03 07:38:25', '2018-07-03 07:38:25'),
(2, 1, 2, 10, 50000, '2018-07-03 07:38:25', '2018-07-03 07:38:25'),
(4, 2, 2, 5, 65000, '2018-07-03 08:08:04', '2018-07-03 08:08:04'),
(5, 2, 1, 15, 30000, '2018-07-03 08:08:04', '2018-07-03 08:08:04');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_h`
--

CREATE TABLE `purchase_h` (
  `id` int(11) NOT NULL,
  `no_inv` varchar(45) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `id_sup` int(11) DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `status` enum('order','received') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_modified` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `keterangan` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_h`
--

INSERT INTO `purchase_h` (`id`, `no_inv`, `total`, `id_sup`, `active`, `status`, `created_at`, `updated_at`, `user_modified`, `tanggal`, `keterangan`) VALUES
(1, 'INV/0001', 625000, 2, 1, 'received', '2018-07-03 07:38:25', '2018-07-03 07:39:13', 1, '2018-07-03', NULL),
(2, 'INV/0002', 775000, 3, 1, 'order', '2018-07-03 07:41:03', '2018-07-03 08:08:04', 1, '2018-07-03', 'Keterangan Purchase');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `value` text,
  `user_modified` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `user_modified`, `created_at`, `updated_at`) VALUES
(1, 'web_title', 'ODWin Stok', 1, '2017-06-13 00:27:16', '2018-06-29 07:54:49'),
(2, 'logo', 'img/logo.png', 1, '2017-06-13 00:27:16', '2018-06-03 05:58:24'),
(3, 'email_admin', 'admin@admin.com', 1, '2017-06-13 00:27:16', '2018-06-03 05:58:52'),
(4, 'web_description', 'Website Description', 1, '2017-07-23 23:56:28', '2018-06-03 05:57:20');

-- --------------------------------------------------------

--
-- Table structure for table `stok`
--

CREATE TABLE `stok` (
  `id` int(11) NOT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `keterangan` text,
  `jumlah` int(11) DEFAULT NULL,
  `type` enum('beli','jual','koreksi') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stok`
--

INSERT INTO `stok` (`id`, `id_barang`, `keterangan`, `jumlah`, `type`, `created_at`, `updated_at`) VALUES
(22, 2, 'Koreksi Stok', 6, 'koreksi', '2018-07-04 10:12:54', '2018-07-04 10:12:54'),
(21, 2, 'Koreksi Stok', -6, 'koreksi', '2018-07-04 10:12:26', '2018-07-04 10:12:26'),
(20, 2, 'NOT/0001', -2, 'jual', '2018-07-04 03:27:31', '2018-07-04 03:27:31'),
(19, 1, 'NOT/0001', -1, 'jual', '2018-07-04 03:27:31', '2018-07-04 03:27:31'),
(15, 1, 'INV/0001', 5, 'beli', '2018-07-03 07:39:13', '2018-07-03 07:39:13'),
(16, 2, 'INV/0001', 10, 'beli', '2018-07-03 07:39:13', '2018-07-03 07:39:13');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `alamat` text,
  `cp` varchar(100) DEFAULT NULL,
  `telp` text,
  `active` int(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_modified` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `nama`, `alamat`, `cp`, `telp`, `active`, `created_at`, `updated_at`, `user_modified`) VALUES
(1, 'Supplier 1', 'Jl Tanimbar\r\n65117\r\nMalang\r\nJawa Timur', 'Donny', '082818392138912\r\n083138883982891', 1, '2018-01-17 01:21:02', '2018-07-02 06:16:19', 1),
(2, 'Supplier 2', 'Jl Ngagel\r\nSurabaya', 'Donny', '08324324823', 1, '2018-03-11 04:41:51', '2018-07-02 06:18:39', 1),
(3, 'Supplier 3', 'Jl Raya Darmo Permai\r\nSurabaya', 'Lidya', '0866237646726', 1, '2018-07-02 06:30:07', '2018-07-02 06:36:52', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_level_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `avatar_id` int(11) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `address` text,
  `phone` text,
  `gender` enum('male','female','other') DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active` int(1) NOT NULL,
  `user_modified` int(11) DEFAULT NULL,
  `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_level_id`, `firstname`, `lastname`, `avatar_id`, `email`, `address`, `phone`, `gender`, `birthdate`, `username`, `password`, `active`, `user_modified`, `last_activity`, `created_at`, `updated_at`) VALUES
(1, 1, 'Super', 'Admin', 0, 'superadmin@admin.com', 'Jl Madura xxxxxxx', '08383xxxxxxx', 'male', '1986-07-25', 'superadmin', '$2y$10$TkX/dDYrtvIEXidPOag5T.V8qbyluUHJg5ssBjKe6WlVqpItuN8uy', 1, 1, '2018-07-04 03:13:57', '2017-03-13 20:51:35', '2018-07-04 03:13:57'),
(2, 2, 'Admin', 'Admin', 0, 'admin@admin.com', NULL, NULL, 'male', NULL, 'admin', '$2y$10$PQaUY4b0YsSo5qAuK8Cc.OB.WeEJHrJJ0FDgk6YE9xhXboVRou3We', 1, 1, '2018-07-04 08:23:26', '2017-04-19 14:29:01', '2018-07-04 08:23:26');

-- --------------------------------------------------------

--
-- Table structure for table `user_levels`
--

CREATE TABLE `user_levels` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `active` int(1) DEFAULT NULL,
  `user_modified` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_levels`
--

INSERT INTO `user_levels` (`id`, `name`, `active`, `user_modified`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 1, 1, '2017-06-28 06:18:17', '2017-06-28 06:18:17'),
(2, 'Admin', 1, 1, '2018-06-02 15:59:51', '2018-06-02 15:59:51'),
(3, 'User', 1, 1, '2018-06-03 04:19:49', '2018-06-03 04:19:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_control`
--
ALTER TABLE `access_control`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media_library`
--
ALTER TABLE `media_library`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penjualan_d`
--
ALTER TABLE `penjualan_d`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penjualan_h`
--
ALTER TABLE `penjualan_h`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_d`
--
ALTER TABLE `purchase_d`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_h`
--
ALTER TABLE `purchase_h`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stok`
--
ALTER TABLE `stok`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_levels`
--
ALTER TABLE `user_levels`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_control`
--
ALTER TABLE `access_control`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media_library`
--
ALTER TABLE `media_library`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `penjualan_d`
--
ALTER TABLE `penjualan_d`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `penjualan_h`
--
ALTER TABLE `penjualan_h`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchase_d`
--
ALTER TABLE `purchase_d`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `purchase_h`
--
ALTER TABLE `purchase_h`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `stok`
--
ALTER TABLE `stok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_levels`
--
ALTER TABLE `user_levels`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
