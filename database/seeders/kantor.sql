-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Waktu pembuatan: 20 Nov 2023 pada 04.30
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `emonitoringku`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kantor`
--

CREATE TABLE `kantor` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_kantor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kantor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kantor`
--

INSERT INTO `kantor` (`id`, `kode_kantor`, `nama_kantor`, `created_at`, `updated_at`) VALUES
(1, '001', 'Pusat', '2023-11-15 01:03:14', '2023-11-15 01:03:14'),
(2, '002', 'Cisalak', '2023-11-15 01:03:24', '2023-11-15 01:03:24'),
(3, '003', 'KPO', '2023-11-15 01:03:40', '2023-11-15 01:03:40'),
(4, '004', 'Subang', '2023-11-15 01:03:52', '2023-11-15 01:03:52'),
(5, '005', 'Purwadadi', '2023-11-15 01:04:02', '2023-11-15 01:04:02'),
(6, '006', 'Pamanukan', '2023-11-15 01:04:12', '2023-11-15 01:04:12');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kantor`
--
ALTER TABLE `kantor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kantor_kode_kantor_unique` (`kode_kantor`),
  ADD UNIQUE KEY `kantor_nama_kantor_unique` (`nama_kantor`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kantor`
--
ALTER TABLE `kantor`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
