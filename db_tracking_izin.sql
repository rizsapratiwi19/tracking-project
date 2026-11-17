-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2026 at 11:07 AM
-- Server version: 10.11.16-MariaDB
-- PHP Version: 8.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tracking_izin`
--

-- --------------------------------------------------------

--
-- Table structure for table `jenis_izin`
--

CREATE TABLE `jenis_izin` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `punya_pencabutan` tinyint(1) NOT NULL DEFAULT 0,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jenis_izin`
--

INSERT INTO `jenis_izin` (`id`, `nama`, `kode`, `urutan`, `punya_pencabutan`, `aktif`, `created_at`, `updated_at`) VALUES
(1, 'PKKPR', 'PKKPR', 1, 0, 1, '2026-11-16 11:14:56', '2026-11-16 11:14:56'),
(2, 'Reklame', 'REKLAME', 2, 0, 1, '2026-11-16 11:14:56', '2026-11-16 11:14:56'),
(3, 'Izin Pendidikan', 'PEND', 3, 0, 1, '2026-11-16 11:14:56', '2026-11-16 11:14:56'),
(4, 'Izin Rekomendasi Penelitian', 'REKPEN', 4, 0, 1, '2026-11-16 11:14:56', '2026-11-16 11:14:56'),
(5, 'Izin Lingkungan', 'LING', 5, 0, 1, '2026-11-16 11:14:56', '2026-11-16 11:14:56'),
(6, 'Izin Praktek Dokter Hewan', 'DOKHEW', 6, 0, 1, '2026-11-16 11:14:56', '2026-11-16 11:14:56'),
(7, 'Izin Kesehatan', 'KES', 7, 1, 1, '2026-11-16 11:14:56', '2026-11-16 11:14:56');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2026-11-16-110531', 'App\\Database\\Migrations\\CreateJenisIzin', 'default', 'App', 1794827277, 1),
(2, '2026-11-16-130000', 'App\\Database\\Migrations\\CreatePengguna', 'default', 'App', 1794829265, 2);

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `peran` varchar(30) NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `nama`, `username`, `password`, `peran`, `aktif`, `created_at`, `updated_at`) VALUES
(1, 'Admin Sistem', 'admin', '$2y$12$4yxGps2pZeOH8T56dvxorOoUlUqGWd2yXczc/KmOINobTENcpvwpa', 'admin', 1, '2026-11-16 11:41:22', '2026-11-16 11:41:22'),
(2, 'Front Office Contoh', 'frontoffice1', '$2y$12$4yxGps2pZeOH8T56dvxorOoUlUqGWd2yXczc/KmOINobTENcpvwpa', 'front_office', 1, '2026-11-16 11:41:22', '2026-11-16 11:41:22'),
(3, 'Verifikator Contoh', 'verifikator1', '$2y$12$4yxGps2pZeOH8T56dvxorOoUlUqGWd2yXczc/KmOINobTENcpvwpa', 'verifikator', 1, '2026-11-16 11:41:22', '2026-11-16 11:41:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jenis_izin`
--
ALTER TABLE `jenis_izin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`nama`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jenis_izin`
--
ALTER TABLE `jenis_izin`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
