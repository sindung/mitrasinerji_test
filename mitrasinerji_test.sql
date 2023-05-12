-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2023 at 02:03 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mitrasinerji_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `m_barang`
--

CREATE TABLE `m_barang` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `harga` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_barang`
--

INSERT INTO `m_barang` (`id`, `kode`, `nama`, `harga`) VALUES
(1, 'BA001', 'Nama Barang 1', '500000'),
(2, 'BA002', 'Nama Barang 2', '4500');

-- --------------------------------------------------------

--
-- Table structure for table `m_customer`
--

CREATE TABLE `m_customer` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `telp` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_customer`
--

INSERT INTO `m_customer` (`id`, `kode`, `name`, `telp`) VALUES
(1, 'C001', 'Nama Customer 1 edit', '0812264903442'),
(2, 'C002', 'Nama Customer 2', '123');

-- --------------------------------------------------------

--
-- Table structure for table `nota`
--

CREATE TABLE `nota` (
  `nomor_nota` int(11) NOT NULL,
  `total_bayar` double(15,2) NOT NULL,
  `diskon` double(15,2) NOT NULL,
  `total_harga` double(15,2) NOT NULL,
  `tunai` double(15,2) NOT NULL,
  `kembali` double(15,2) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `print_at` datetime DEFAULT NULL,
  `session` varchar(128) NOT NULL,
  `user_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `nota`
--

INSERT INTO `nota` (`nomor_nota`, `total_bayar`, `diskon`, `total_harga`, `tunai`, `kembali`, `create_at`, `print_at`, `session`, `user_id`) VALUES
(1, 7000.00, 10000.00, 17000.00, 50000.00, 43000.00, '2020-07-09 10:31:16', '2020-07-09 17:34:00', 'qt4tmic4o7usnenqnogs2qqsr4kui8n5', 'admin'),
(2, 10000.00, 0.00, 10000.00, 20000.00, 10000.00, '2020-07-09 10:34:02', '2020-07-10 08:38:55', 'sv262edgc2lptd0ilbfie41tlfmvmkd3', 'admin'),
(3, 10000.00, 0.00, 10000.00, 50000.00, 40000.00, '2020-07-10 01:31:18', '2020-07-10 16:59:14', '5920rcuslnf6adlsh1fde0pp54eln1it', 'admin'),
(4, 82000.00, 0.00, 82000.00, 100000.00, 18000.00, '2020-07-11 00:22:22', '2020-07-11 09:31:17', '9s6ark0q9hquhh05o0n8ouarf6cveg6m', 'admin'),
(5, 10000.00, 0.00, 10000.00, 50000.00, 40000.00, '2020-07-11 00:26:31', '2020-07-11 10:00:05', '9s6ark0q9hquhh05o0n8ouarf6cveg6m', 'admin'),
(6, 10000.00, 0.00, 10000.00, 50000.00, 40000.00, '2020-07-13 02:53:11', '2020-07-13 09:56:27', '9mfubr64gkc5nvk34liri84j3q705mok', 'user'),
(7, 5000.00, 0.00, 5000.00, 10000.00, 5000.00, '2020-07-13 03:07:22', '2020-07-13 10:07:43', '0772tmkibrgarali0qku225r3rgf0rkq', 'admin'),
(8, 22000.00, 0.00, 22000.00, 50000.00, 28000.00, '2020-07-13 03:07:38', '2022-12-26 10:46:50', '0772tmkibrgarali0qku225r3rgf0rkq', 'admin'),
(9, 22000.00, 0.00, 22000.00, 0.00, 0.00, '2020-07-15 03:23:14', NULL, 'bj96roe08k9c5fu2hsab9ur1tfftettm', 'user'),
(10, 0.00, 0.00, 0.00, 0.00, 0.00, '2020-07-15 16:36:00', NULL, 'pnk29j5ivueaoedbd9bks9fa3fl0fgcg', 'tes'),
(11, 15000.00, 0.00, 15000.00, 50000.00, 35000.00, '2022-12-26 10:47:00', '2022-12-26 11:30:38', 'f43c06b775708412e012c90bf626235327a409b8', 'admin'),
(12, 10000.00, 0.00, 10000.00, 50000.00, 40000.00, '2022-12-26 11:18:06', '2022-12-26 11:31:41', '009b15d1b84a3c01942e812e013fced777bb72e3', 'admin'),
(13, 12000.00, 0.00, 12000.00, 100000.00, 88000.00, '2022-12-26 11:32:38', '2023-05-07 11:22:57', 'ccbe0d196fc859ee9c605c985fe78bdbc7d38236', 'admin'),
(14, 10000.00, 0.00, 10000.00, 20000.00, 10000.00, '2023-04-11 22:10:38', '2023-04-11 22:11:55', '3454a39903706067ff6dc0722028469762642d29', '123'),
(15, 15000.00, 0.00, 15000.00, 20000.00, 5000.00, '2023-04-11 22:18:41', '2023-04-11 22:19:14', '86e7a0bfc29aca6d3c62843b12187d08ea250f86', '123'),
(16, 0.00, 0.00, 0.00, 0.00, 0.00, '2023-04-11 22:19:26', NULL, '3454a39903706067ff6dc0722028469762642d29', '123'),
(17, 10000.00, 0.00, 10000.00, 100000.00, 90000.00, '2023-05-06 10:05:34', '2023-05-06 10:06:23', '2f23bc3ae4b9cc2f0741b6b4a3ed50879952186f', 'mbb'),
(18, 0.00, 0.00, 0.00, 0.00, 0.00, '2023-05-06 10:06:25', NULL, '2f23bc3ae4b9cc2f0741b6b4a3ed50879952186f', 'mbb'),
(19, 10000.00, 0.00, 10000.00, 50000.00, 40000.00, '2023-05-07 11:23:44', '2023-05-07 12:53:55', '0b6174d27e83152f7ffe392e473dc66202f78d44', 'admin'),
(20, 20000.00, 0.00, 20000.00, 500000.00, 480000.00, '2023-05-07 11:34:01', '2023-05-07 12:57:17', '54f0a1e524dddeefe8361ca40ed0db383fe12ca3', 'admin'),
(21, 10000.00, 0.00, 10000.00, 50000.00, 40000.00, '2023-05-07 12:56:37', '2023-05-07 13:00:38', '8863398c24deec00f83a469ee0b8dc56c8e52ecf', 'admin'),
(22, 10000.00, 0.00, 10000.00, 50000.00, 40000.00, '2023-05-07 13:00:40', '2023-05-07 13:01:40', '7b5cd938df8c464161e4ce7ab06bc9d808f612ec', 'admin'),
(23, 20000.00, 0.00, 20000.00, 50000.00, 0.00, '2023-05-07 13:01:42', '2023-05-07 13:08:53', '0d8cc9fc0c96253a09a13dcd41bc224dc488a533', 'admin'),
(24, 10000.00, 0.00, 10000.00, 50000.00, 40000.00, '2023-05-07 13:10:29', '2023-05-07 13:10:42', 'c69cc79e9beeb01794b3bba7ec9df7142126a0a9', 'admin'),
(25, 10000.00, 0.00, 10000.00, 500000.00, 490000.00, '2023-05-07 13:10:44', '2023-05-07 13:12:30', '708a7133e4463b7ad4feecc086fb4903bafe9f23', 'admin'),
(26, 10000.00, 0.00, 10000.00, 400000.00, 390000.00, '2023-05-07 13:12:32', '2023-05-07 13:13:12', '708a7133e4463b7ad4feecc086fb4903bafe9f23', 'admin'),
(27, 10000.00, 0.00, 10000.00, 500000.00, 490000.00, '2023-05-07 13:13:14', '2023-05-07 13:13:51', '64b85ccd7b6672297fd1ed9aa73e736bd9406430', 'admin'),
(28, 10000.00, 0.00, 10000.00, 50000.00, 40000.00, '2023-05-07 13:13:53', '2023-05-07 13:20:38', '64b85ccd7b6672297fd1ed9aa73e736bd9406430', 'admin'),
(29, 0.00, 0.00, 0.00, 50000.00, 50000.00, '2023-05-07 13:21:45', '2023-05-07 13:22:08', '5010c25f8bbbe6b86b65db9e935616419996b280', 'admin'),
(30, 10000.00, 0.00, 10000.00, 50000.00, 40000.00, '2023-05-07 13:23:02', '2023-05-07 13:24:34', '1fe24251158ad4749a9649d976ed2f0e05f9b5dc', 'admin'),
(31, 10000.00, 0.00, 10000.00, 50000.00, 40000.00, '2023-05-07 13:24:37', '2023-05-07 13:25:04', '5010c25f8bbbe6b86b65db9e935616419996b280', 'admin'),
(32, 10000.00, 0.00, 10000.00, 50000.00, 40000.00, '2023-05-07 13:25:07', '2023-05-07 13:32:56', '1fe24251158ad4749a9649d976ed2f0e05f9b5dc', 'admin'),
(33, 10000.00, 0.00, 10000.00, 50000.00, 40000.00, '2023-05-07 13:27:13', '2023-05-07 13:35:10', '8af45ac7c460bc81307cf4fb3dc0702b3fb62c48', 'admin'),
(34, 10000.00, 0.00, 10000.00, 50000.00, 40000.00, '2023-05-07 13:35:12', '2023-05-07 13:35:39', '92f09994594b32307a09dd8cda93ab73ff3cc981', 'admin'),
(35, 0.00, 0.00, 0.00, 0.00, 0.00, '2023-05-07 13:35:41', NULL, '1c6e096a22d6ddebcf6f872488deb0c8a371bd28', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(5) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `stok` int(5) NOT NULL,
  `harga` double(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `nama`, `stok`, `harga`, `created_at`) VALUES
(6, 'Ayam Goreng', 9984, 10000.00, '2019-08-11 10:05:43'),
(7, 'Nasi', 8, 2000.00, '2019-08-11 10:06:15'),
(10, 'Es Teh', 1, 5000.00, '2019-09-08 04:18:02'),
(11, 'tes stok', 9, 5000.00, '2019-09-25 13:35:58'),
(12, 'tes stok 2', 8, 3500.00, '2019-09-25 13:36:24'),
(13, 'tes stok 3', 15, 5500.00, '2019-09-25 13:36:41'),
(14, 'stok kosong', 0, 0.00, '2019-09-25 13:42:08');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(5) NOT NULL,
  `nomor_nota` int(11) NOT NULL,
  `id_produk` int(5) NOT NULL,
  `nama_produk` varchar(128) NOT NULL,
  `harga` double(15,2) NOT NULL,
  `qty` int(5) NOT NULL,
  `sub_total` double(15,2) NOT NULL,
  `user_id` varchar(128) NOT NULL,
  `create_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `nomor_nota`, `id_produk`, `nama_produk`, `harga`, `qty`, `sub_total`, `user_id`, `create_at`) VALUES
(1, 1, 6, 'Ayam Goreng', 10000.00, 1, 10000.00, 'admin', '2020-07-09 10:33:07'),
(2, 1, 10, 'Es Teh', 5000.00, 1, 5000.00, 'admin', '2020-07-09 10:33:12'),
(3, 1, 7, 'Nasi', 2000.00, 1, 2000.00, 'admin', '2020-07-09 10:33:20'),
(4, 2, 6, 'Ayam Goreng', 10000.00, 1, 10000.00, 'admin', '2020-07-10 01:30:02'),
(5, 3, 6, 'Ayam Goreng', 10000.00, 1, 10000.00, 'admin', '2020-07-10 09:59:07'),
(7, 4, 6, 'Ayam Goreng', 10000.00, 6, 60000.00, 'admin', '2020-07-11 00:25:48'),
(8, 4, 7, 'Nasi', 2000.00, 1, 2000.00, 'admin', '2020-07-11 00:26:05'),
(9, 4, 10, 'Es Teh', 5000.00, 4, 20000.00, 'admin', '2020-07-11 00:26:08'),
(10, 5, 6, 'Ayam Goreng', 10000.00, 1, 10000.00, 'admin', '2020-07-11 02:59:11'),
(11, 6, 6, 'Ayam Goreng', 10000.00, 1, 10000.00, 'user', '2020-07-13 02:54:14'),
(12, 7, 10, 'Es Teh', 5000.00, 1, 5000.00, 'admin', '2020-07-13 03:07:28'),
(13, 8, 6, 'Ayam Goreng', 10000.00, 2, 20000.00, 'admin', '2022-12-25 10:26:59'),
(14, 8, 7, 'Nasi', 2000.00, 1, 2000.00, 'admin', '2022-12-26 02:51:50'),
(15, 11, 6, 'Ayam Goreng', 10000.00, 1, 10000.00, 'admin', '2022-12-26 03:57:12'),
(16, 11, 10, 'Es Teh', 5000.00, 1, 5000.00, 'admin', '2022-12-26 03:57:16'),
(17, 12, 11, 'tes stok', 5000.00, 1, 5000.00, 'admin', '2022-12-26 04:31:30'),
(18, 12, 10, 'Es Teh', 5000.00, 1, 5000.00, 'admin', '2022-12-26 04:31:34'),
(20, 13, 7, 'Nasi', 2000.00, 1, 2000.00, 'admin', '2022-12-27 12:30:19'),
(21, 13, 6, 'Ayam Goreng', 10000.00, 1, 10000.00, 'admin', '2023-02-03 04:45:08'),
(22, 9, 6, 'Ayam Goreng', 10000.00, 1, 10000.00, 'user', '2023-02-03 04:50:32'),
(23, 9, 7, 'Nasi', 2000.00, 1, 2000.00, 'user', '2023-02-03 04:50:35'),
(24, 9, 10, 'Es Teh', 5000.00, 2, 10000.00, 'user', '2023-02-03 04:50:46'),
(25, 14, 6, 'Ayam Goreng', 10000.00, 1, 10000.00, '123', '2023-04-11 15:11:22'),
(26, 15, 10, 'Es Teh', 5000.00, 1, 5000.00, '123', '2023-04-11 15:18:51'),
(27, 15, 6, 'Ayam Goreng', 10000.00, 1, 10000.00, '123', '2023-04-11 15:18:57'),
(28, 17, 6, 'Ayam Goreng', 10000.00, 1, 10000.00, 'mbb', '2023-05-06 03:06:00'),
(29, 19, 6, 'Ayam Goreng', 10000.00, 1, 10000.00, 'admin', '2023-05-07 04:33:26'),
(30, 20, 6, 'Ayam Goreng', 10000.00, 2, 20000.00, 'admin', '2023-05-07 05:56:24'),
(31, 21, 6, 'Ayam Goreng', 10000.00, 1, 10000.00, 'admin', '2023-05-07 06:00:31'),
(32, 22, 6, 'Ayam Goreng', 10000.00, 1, 10000.00, 'admin', '2023-05-07 06:01:32'),
(33, 23, 6, 'Ayam Goreng', 10000.00, 2, 20000.00, 'admin', '2023-05-07 06:04:01'),
(34, 24, 6, 'Ayam Goreng', 10000.00, 1, 10000.00, 'admin', '2023-05-07 06:10:35'),
(35, 25, 6, 'Ayam Goreng', 10000.00, 1, 10000.00, 'admin', '2023-05-07 06:11:09'),
(36, 26, 6, 'Ayam Goreng', 10000.00, 1, 10000.00, 'admin', '2023-05-07 06:13:04'),
(37, 27, 6, 'Ayam Goreng', 10000.00, 1, 10000.00, 'admin', '2023-05-07 06:13:43'),
(38, 28, 6, 'Ayam Goreng', 10000.00, 1, 10000.00, 'admin', '2023-05-07 06:20:30'),
(39, 30, 6, 'Ayam Goreng', 10000.00, 1, 10000.00, 'admin', '2023-05-07 06:24:28'),
(40, 31, 6, 'Ayam Goreng', 10000.00, 1, 10000.00, 'admin', '2023-05-07 06:24:56'),
(41, 32, 6, 'Ayam Goreng', 10000.00, 1, 10000.00, 'admin', '2023-05-07 06:25:48'),
(42, 33, 6, 'Ayam Goreng', 10000.00, 1, 10000.00, 'admin', '2023-05-07 06:35:05'),
(43, 34, 6, 'Ayam Goreng', 10000.00, 1, 10000.00, 'admin', '2023-05-07 06:35:31');

-- --------------------------------------------------------

--
-- Table structure for table `t_sales`
--

CREATE TABLE `t_sales` (
  `id` int(11) NOT NULL,
  `kode` varchar(15) NOT NULL,
  `tgl` datetime DEFAULT current_timestamp(),
  `cust_id` varchar(15) NOT NULL,
  `subtotal` decimal(10,0) NOT NULL,
  `diskon` decimal(10,0) NOT NULL,
  `ongkir` decimal(10,0) NOT NULL,
  `total_bayar` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_sales`
--

INSERT INTO `t_sales` (`id`, `kode`, `tgl`, `cust_id`, `subtotal`, `diskon`, `ongkir`, `total_bayar`) VALUES
(1, '202305-00001', '2023-05-12 00:00:00', 'C001', '1003400', '1000', '5000', '997400'),
(2, '202305-00002', '2023-05-12 00:00:00', 'C002', '1020250', '0', '0', '1020250');

-- --------------------------------------------------------

--
-- Table structure for table `t_sales_det`
--

CREATE TABLE `t_sales_det` (
  `id` int(11) NOT NULL,
  `kode` varchar(15) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `barang_id` varchar(11) NOT NULL,
  `harga_bandrol` decimal(10,0) NOT NULL,
  `qty` int(11) NOT NULL,
  `diskon_pct` decimal(10,0) NOT NULL,
  `diskon_nilai` decimal(10,0) NOT NULL,
  `harga_diskon` decimal(10,0) NOT NULL,
  `total` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_sales_det`
--

INSERT INTO `t_sales_det` (`id`, `kode`, `sales_id`, `barang_id`, `harga_bandrol`, `qty`, `diskon_pct`, `diskon_nilai`, `harga_diskon`, `total`) VALUES
(4, '202305-00001', 202305, 'BA001', '500000', 2, '1', '50', '494950', '989900'),
(5, '202305-00001', 202305, 'BA002', '4500', 3, '0', '0', '4500', '13500'),
(6, '202305-00002', 202305, 'BA002', '4500', 5, '10', '0', '4050', '20250'),
(7, '202305-00002', 202305, 'BA001', '500000', 2, '0', '0', '500000', '1000000');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(5) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `user_id` varchar(128) NOT NULL,
  `gambar` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `is_active` int(1) NOT NULL,
  `role_id` int(1) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `user_id`, `gambar`, `password`, `is_active`, `role_id`, `create_at`) VALUES
(1, 'Hofar Ismail', 'hofar', 'default.jpg', '$2y$10$npd2rQYWQg2GLRXLD/BzkuSGJKOWiVmtGTS0.ynbo9XPfLwoU5rwy', 1, 1, '2019-08-31 05:20:18'),
(2, 'Admin', 'admin', 'default.jpg', '$2y$10$ZPUdSONgksImO0.PI.A7.eM0dZU5kR.sjOytNJArMlNO9XMsk6e7i', 1, 1, '2019-08-31 23:55:43'),
(3, 'User', 'user', 'default.jpg', '$2y$10$HuPSqF5hvJSdle8eromvmuB22wZKsDi6t2Zsf41B7jOSS5OpJj1we', 1, 2, '2019-08-31 23:55:56'),
(10, 'tes', 'tes', 'default.jpg', '$2y$10$4TBFGO.OPsofWEUfQyeaB.PQnfm5zNv7PhtQNMgTs1/IHkRg3YGs6', 1, 6, '2020-07-15 16:17:04'),
(11, 'tes2', 'tes2', 'default.jpg', '$2y$10$R8cHU7iwwYPbQGFxpALYJOB4Da.gR6agTNKoXYDMvNpIcgdOxupWu', 1, 2, '2020-07-15 16:29:56'),
(12, 'Near', '123', 'default.jpg', '$2y$10$aPfcI1xFrhqEtgMJwIYSuO45dPHjY/hbuYK2drRYyY.BWDY.hF/Nu', 1, 2, '2023-04-11 22:09:38'),
(13, 'mbb', 'mbb', 'default.jpg', '$2y$10$F.tDSPi9EoDm7or6IMqmsuF1gO8JW25Qu.ax8qfXBa8XuEDyC4DN2', 1, 2, '2023-05-06 10:05:15');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(5) NOT NULL,
  `name` varchar(50) NOT NULL,
  `nota` int(1) NOT NULL DEFAULT 0,
  `super` int(1) NOT NULL DEFAULT 0,
  `history` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `name`, `nota`, `super`, `history`) VALUES
(1, 'Administrator', 1, 1, 1),
(2, 'User', 1, 0, 0),
(6, 'Manajer', 1, 0, 1),
(10, 'tes', 0, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `m_barang`
--
ALTER TABLE `m_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_customer`
--
ALTER TABLE `m_customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nota`
--
ALTER TABLE `nota`
  ADD PRIMARY KEY (`nomor_nota`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_sales`
--
ALTER TABLE `t_sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`);

--
-- Indexes for table `t_sales_det`
--
ALTER TABLE `t_sales_det`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `m_barang`
--
ALTER TABLE `m_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `m_customer`
--
ALTER TABLE `m_customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `nota`
--
ALTER TABLE `nota`
  MODIFY `nomor_nota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `t_sales`
--
ALTER TABLE `t_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_sales_det`
--
ALTER TABLE `t_sales_det`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
