-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2023 at 03:46 PM
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
(7, '202305-00002', 202305, 'BA001', '500000', 2, '0', '0', '500000', '1000000'),
(9, '202305-00002', 202305, 'BA002', '500000', 2, '0', '0', '500000', '1000000');

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`);

--
-- Indexes for table `m_customer`
--
ALTER TABLE `m_customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `constraint_barang` (`barang_id`),
  ADD KEY `constraint_kode` (`kode`);

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
-- AUTO_INCREMENT for table `t_sales`
--
ALTER TABLE `t_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_sales_det`
--
ALTER TABLE `t_sales_det`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_sales_det`
--
ALTER TABLE `t_sales_det`
  ADD CONSTRAINT `constraint_barang` FOREIGN KEY (`barang_id`) REFERENCES `m_barang` (`kode`),
  ADD CONSTRAINT `constraint_kode` FOREIGN KEY (`kode`) REFERENCES `t_sales` (`kode`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
