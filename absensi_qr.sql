-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 11, 2026 at 02:17 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absensi_qr`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` bigint UNSIGNED NOT NULL,
  `nis` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jadwal_id` bigint UNSIGNED DEFAULT NULL,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Hadir',
  `kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `nis`, `jadwal_id`, `waktu`, `status`, `kegiatan`, `created_at`, `updated_at`) VALUES
(17, '250103014', 2, '2025-10-15 02:41:35', 'Hadir', 'Berangkat Sekolah', '2025-10-15 02:41:35', '2025-10-15 02:41:35'),
(18, '250103014', 2, '2025-10-16 03:18:15', 'Hadir', 'Berangkat Sekolah', '2025-10-16 03:18:15', '2025-10-16 03:18:15'),
(19, '250103008', 2, '2025-10-16 03:19:43', 'Hadir', 'Berangkat Sekolah', '2025-10-16 03:19:43', '2025-10-16 03:19:43'),
(20, '250103020', 2, '2025-10-16 03:19:53', 'Hadir', 'Berangkat Sekolah', '2025-10-16 03:19:53', '2025-10-16 03:19:53'),
(21, '250103008', 3, '2025-10-16 11:30:04', 'Hadir', 'Madin', '2025-10-16 11:30:04', '2025-10-16 11:30:04'),
(22, '230101009', 2, '2025-12-11 05:52:15', 'Hadir', 'Berangkat Sekolah', '2025-12-11 05:52:15', '2025-12-11 05:52:15'),
(23, '250103014', 2, '2026-01-05 01:57:08', 'Hadir', 'Berangkat Sekolah', '2026-01-05 01:57:08', '2026-01-05 01:57:08'),
(24, '240103026', 2, '2026-01-05 02:10:55', 'Hadir', 'Berangkat Sekolah', '2026-01-05 02:10:55', '2026-01-05 02:10:55'),
(25, '240103048', 2, '2026-01-07 04:00:42', 'Hadir', 'Berangkat Sekolah', '2026-01-07 04:00:42', '2026-01-07 04:00:42'),
(26, '240103054', 2, '2026-01-08 04:08:43', 'Hadir', 'Berangkat Sekolah', '2026-01-08 04:08:43', '2026-01-08 04:08:43'),
(27, '250102002', 2, '2026-01-09 17:00:00', 'Hadir', 'Berangkat Sekolah', '2026-01-10 12:25:30', '2026-01-10 12:26:00'),
(28, '250103055', 5, '2026-01-11 13:56:58', 'Hadir', 'taqror', '2026-01-11 13:56:58', '2026-01-11 13:56:58'),
(29, '250103054', 5, '2026-01-11 13:57:17', 'Hadir', 'taqror', '2026-01-11 13:57:17', '2026-01-11 13:57:17');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_absen`
--

CREATE TABLE `jadwal_absen` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `hari` json DEFAULT NULL,
  `kode` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `aktif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jadwal_absen`
--

INSERT INTO `jadwal_absen` (`id`, `nama_kegiatan`, `jam_mulai`, `jam_selesai`, `hari`, `kode`, `keterangan`, `aktif`, `created_at`, `updated_at`) VALUES
(1, 'Ngaji Pagi', '05:30:00', '06:11:00', NULL, NULL, NULL, 0, '2025-10-13 20:28:06', '2025-12-11 05:20:53'),
(2, 'Berangkat Sekolah', '06:45:00', '13:20:00', '[1, 2, 3, 4, 5, 6]', NULL, NULL, 1, '2025-10-13 20:28:06', '2026-01-05 02:10:49'),
(3, 'Madin', '18:30:00', '20:00:00', '[1, 2, 3, 5, 6]', NULL, NULL, 1, '2025-10-13 20:28:06', '2026-01-05 02:09:51'),
(5, 'taqror', '20:30:00', '22:00:00', NULL, NULL, NULL, 1, '2025-12-14 12:12:27', '2026-01-11 13:55:57');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_10_09_031325_create_absensi_table', 2),
(5, '2025_10_09_031325_create_santri_table', 2),
(6, '2025_10_09_035656_add_fields_to_absensi_table', 3),
(7, '2025_10_10_164257_add_fields_to_santri_table', 4),
(8, '2025_10_10_170304_add_index_to_nis_in_santri_table', 5),
(9, '2025_10_10_165910_create_absensi_table', 6),
(10, '2025_10_14_032506_create_jadwal_absen_table', 7),
(11, '2025_10_15_085942_add_kegiatan_to_absensi_table', 8),
(12, '2025_12_09_100037_create_jadwal_absen_table', 9),
(13, '2025_12_09_101800_add_fields_to_jadwal_absen_table', 9),
(14, '2025_10_09_000000_create_santri_table', 10),
(15, '2025_12_14_202507_create_sessions_table', 11),
(16, '2026_01_05_090200_add_hari_to_jadwal_absen_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `santri`
--

CREATE TABLE `santri` (
  `id` bigint UNSIGNED NOT NULL,
  `nis` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelas` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `santri`
--

INSERT INTO `santri` (`id`, `nis`, `nama`, `kelas`, `created_at`, `updated_at`) VALUES
(1, '250103008', 'AHMAD HILMAN SHIDQI', 'TAHFIDZ 1', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(2, '250103014', 'Alief Fajri Wicaksono', 'TAHFIDZ 1', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(3, '250103020', 'Fathan taqiyan ibnu yasit', 'TAHFIDZ 1', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(4, '250103027', 'M. AZKA DAFISA PUTRA', 'TAHFIDZ 1', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(5, '250103050', 'Muhammad Zacky Kurniawan', 'TAHFIDZ 1', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(6, '250103042', 'Muhammad Habibulloh', 'TAHFIDZ 1', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(7, '250103045', 'Muhammad imdadurrohman Murtadlo', 'TAHFIDZ 1', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(8, '250103046', 'Muhammad Iqrom Rosidi', 'TAHFIDZ 1', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(9, '250103048', 'Muhammad Naufal Rakha Arrafi', 'TAHFIDZ 1', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(10, '250103049', 'MUHAMMAD RIZAL FANANI', '1A', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(11, '250103055', 'Rakha bintang kurniawan', 'TAHFIDZ 1', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(12, '250103061', 'Zahfran Baihaqi Wabil', 'TAHFIDZ 1', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(13, '250103062', 'Zahwan Lubna Muafa', 'TAHFIDZ 1', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(14, '240103015', 'AZFAR ARSYAD RHOMADHONA', 'TAHFIDZ 2', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(15, '240103025', 'DZAKI RAFA UTOMO', 'TAHFIDZ 2', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(16, '240103026', 'MUHAMMAD FAHMI KHOIRIZZUAMA', 'TAHFIDZ 2', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(17, '240103004', 'LINTAR AGUNG WICAKSONO', 'TAHFIDZ 2', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(18, '240103035', 'MUHAMMAD HARIS AL FATIH SAID', 'TAHFIDZ 2', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(19, '240103034', 'MUHAMMAD ATTAR TRISYAIFAN', 'TAHFIDZ 2', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(20, '240103029', 'A. ZAMZAMI AKBAR FUADI', 'TAHFIDZ 2', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(21, '230103044', 'MUHAMMAD HIKAM MUQTADAN', 'TAHFIDZ 3', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(22, '230103013', 'Auli Afiq Ghozali', 'TAHFIDZ 3', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(23, '230103024', 'Jaelani Ansofi', 'TAHFIDZ 3', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(24, '230103047', 'MUHAMMAD KHOZIN ZYAHRANDI LUTFI', 'TAHFIDZ 3', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(25, '230103032', 'MOCHAMMAD HAMDAN AKMAL', 'TAHFIDZ 3', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(26, '230103019', 'Erland Tristan Tyaga', 'TAHFIDZ 3', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(27, '230103030', 'MOCH ISKANDAR ZAINAL ABIDIN', 'TAHFIDZ 3', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(28, '250101001', 'EXCEL JANUAR RIZKY HARDIANTO', 'TAHFIDZ 4', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(29, '240101012', 'Fahdina Izul Haq', 'TAHFIDZ 4', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(30, '250101003', 'ILYAS ABDILLAH', 'TAHFIDZ 4', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(31, '250101007', 'Moh.Egan Jaelani Haryanto', 'TAHFIDZ 4', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(32, '250101005', 'M. Hafiz Alfarizi', 'TAHFIDZ 4', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(33, '250101008', 'MOHAMAD FATHUR RIDWAN', 'TAHFIDZ 4', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(34, '250101012', 'NOVAL ADICANDRA FIRJATULLAH', 'TAHFIDZ 4', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(35, '250101013', 'Oki Hasin Basri', 'TAHFIDZ 4', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(36, '250102011', 'YUSUF MUHAMMAD', 'TAHFIDZ 4', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(37, '250102002', 'ABDIL FATAHILLAH AKBAR', '1A', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(38, '250103003', 'ACHMAD FARREL SEPTIAN HAFIDZI', '1A', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(39, '250103005', 'Aditya Aulia Alamsyah', '1A', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(40, '250103009', 'AHMAD NIZAM RAMADANI', '1A', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(41, '250103012', 'AKBAR PRAWIRA', '1A', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(42, '250103015', 'Daffi salman al ghozaly', '1A', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(43, '250103018', 'Farhan imanulhaq', '1A', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(44, '250101002', 'Fatahillah Sholih Fauzy', '1A', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(45, '250103021', 'IBRAHIM AHMAD QOIDUL ASYKAR', '1A', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(46, '250103022', 'ISMAIL PUTRA SETYADI', '1A', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(47, '250103024', 'Kafa maftuh ghifari', '1A', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(48, '250103026', 'M. AINUL YAQIN RAMADANI', '1A', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(49, '250103025', 'M. ALFARO ATHOILAH', '1A', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(50, '250103031', 'MOCH. ANUGERAH ILAHI', '1A', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(51, '250103034', 'MOH. AFTON HIZAM AHZAMI', '1A', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(52, '250103035', 'MOH.NAUFAL ANIQ ZIDAN MAHMUDY', '1A', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(53, '250103036', 'MOHAMMAD DAFA DZIKRO BUDIYANSYAH', '1A', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(54, '250103038', 'MOHAMMAD MIZAN FAZAL QOYYAM RUSYDI', '1A', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(55, '250103040', 'muhammad ardan maulana', '1A', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(56, '250103041', 'MUHAMMAD DAURIL AZMI ELSYAH PUJI', '1A', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(57, '250103047', 'Muhammad Julio prasetia', '1A', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(58, '250102010', 'Muhammad Trias Eka Pranata', '1A', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(59, '250103052', 'Radith Pradita Racetyo', '1A', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(60, '250103053', 'RAFQA ZIDNY SABIL', '1A', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(61, '250103058', 'Rosyidan Pio Aryasatya Pratama', '1A', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(62, '250103059', 'Tirta Al Mukarromah', '1A', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(63, '250103001', 'Abid Aqila Azka', '1B', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(64, '250103002', 'ACH ABID NAUFAL RAMADANI', '1B', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(65, '250103004', 'Achmat Kafi Ezra Karisma', '1B', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(66, '250103006', 'Ahmad Fikri Adi Saputra', '1B', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(67, '250103007', 'Ahmad havit putra Pratama', '1B', '2025-10-10 09:53:27', '2025-10-10 09:53:27'),
(68, '250103010', 'AHMAD RENDI F', '1B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(69, '250103011', 'AHMAD UMAR KHADAFI', '1B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(70, '250103016', 'Fairuz Hasam Ismam Budiyasa', '1B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(71, '250103017', 'FAJAR MAULANA MABRURI', '1B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(72, '250103023', 'Jovan Aufar Rohim', '1B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(73, '250103028', 'M. NUH DAFA\' SUWAILIM ASNA', '1B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(74, '250103029', 'M. Yuriko Saputra', '1B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(75, '250103030', 'Moch ghazi irham firdaus zamani', '1B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(76, '250103032', 'MOCH. DHANY PRASETYA', '1B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(77, '250103033', 'MOCHAMAD MAULANA AL - MAWALI', '1B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(78, '250103037', 'Mohammad Dimas Septianto', '1B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(79, '250103039', 'Muhamad syazani syahdan jazuli', '1B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(80, '250103043', 'MUHAMMAD HIJRAH MAULANA RAHMAN', '1B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(81, '250103051', 'mukhamad gary akbar waleza', '1B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(82, '250103054', 'Raissa Randy Quinn Vendi Saputra', '1B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(83, '250103056', 'Ramadhani Ulil Albab', '1B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(84, '250103057', 'RISQI TRI ADITYA MAULANA', '1B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(85, '250103060', 'Valentino febrian putra arifin', '1B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(86, '240103057', 'ACHMAD SATRIA MAULANA', '2A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(87, '240103053', 'AFTON AL THOFURRIJAL', '2A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(88, '240102006', 'AHMAD FALIHUL HIMAM', '2A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(89, '240103008', 'AZRIL ALIFINO', '2A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(90, '240103036', 'AZRUL ARANZA DHAKY', '2A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(91, '240103018', 'FACHRIJAL ABDURACHMAN', '2A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(92, '240103006', 'HAIKAL MAQROBI', '2A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(93, '240103048', 'ILHAM FAZRIL ARDIANSAH', '2A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(94, '240103019', 'KEVIN DIMAS MAULANA', '2A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(95, '240103023', 'KRESNA AQIL YAAFI', '2A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(96, '240103054', 'MUHAMMAD AKBAR MAULANA', '2A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(97, '240103044', 'MUHAMMAD AKBAR ROSYID', '2A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(98, '240103037', 'M. ARKAN EBYAD BENASER HAQ', '2A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(99, '240103050', 'M. ALFIN NUR HABIBULLAH', '2A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(100, '240103051', 'M. ALI RIDHALLAH', '2A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(101, '240103042', 'MUHAMMAD ALIEF NADHOFATUL QULUB', '2A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(102, '240103041', 'M. AZKA SYAHDAN DZANUROIN', '2A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(103, '240103001', 'M. FAHMI ISKHAQUS SURYA', '2A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(104, '240103049', 'M. HASBIAN FAHMI', '2A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(105, '240103021', 'MOHAMMAD IWAN ABU JIBRIL', '2A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(106, '240103046', 'MUHAMMAD JAFAR ASSODIQ', '2A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(107, '240101007', 'MUHAMMAD NAUFAL AULAA', '2A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(108, '240103024', 'MOH. ADITYA FIRNANDO', '2A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(109, '240103030', 'NAZRIL NUZULUL FAHMI', '2A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(110, '240103031', 'AHMAD ALWINNAJIB HIDAYATULLAH', '2B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(111, '240102002', 'AHMAD BRAMAN TYO DWI YUNIARNO', '2B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(112, '240103009', 'AHMAD WISNU ABDILLAH', '2B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(113, '240103028', 'AIMAR GIBRANANTA FAEYZA A.', '2B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(114, '240103059', 'ALIFIL IRFAN MUHAMMAD.', '2B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(115, '240103045', 'HAFIZH NAUFAL ZAAKY', '2B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(116, '240103038', 'MUHAMMAD AKMAL YAZABIL ADAM', '2B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(117, '240103027', 'MUHAMMAD BISMA ALFARIZI', '2B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(118, '240103043', 'M. DANIEL ALVIANO PRATAMA', '2B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(119, '240103020', 'MUHAMMAD HENDRANATA', '2B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(120, '240103005', 'MUHAMMAD MAULEVI SAPUTRA', '2B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(121, '240103011', 'M. RIZKI AL FITRA ROMADONI', '2B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(122, '240103022', 'MUHAMMAD RAIHAN ALFATIH', '2B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(123, '240103016', 'M. WAHYU ADJI PRATAMA', '2B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(124, '240103058', 'MARVEL OKTAVIA ANANTA SAPUTRA', '2B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(125, '240103007', 'MOH. FAIQ DWI SAPUTRA', '2B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(126, '240103003', 'MOH. FAIZ EKA SAPUTRA', '2B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(127, '230103060', 'MUHAMMAD DENI', '2B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(128, '240103033', 'NUR FAUZAN TRI SUSILO', '2B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(129, '240103039', 'PRADIPTA AKBAR PERMANA', '2B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(130, '240103040', 'PRADIPTA TEGAR PERMANA', '2B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(131, '240103047', 'RADITYA BINTANG APRILLIO', '2B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(132, '240103012', 'RAMDHANI EGA RUSTANTO', '2B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(133, '240103060', 'RENDY ALGIFARI', '2B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(134, '240103013', 'ROFIKI NURUL YAKIN', '2B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(135, '240103052', 'SHAUQI ALAIKA ROHMAN', '2B', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(136, '230103004', 'AHMAD AFINAS HUMAIDI', '3A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(137, '230103002', 'ADITY EKA TOTI RAMADHANI', '3A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(138, '230103003', 'Agus Prasetyo', '3A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(139, '230103005', 'AHMAD HAFIL MUQODDAS', '3A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(140, '230103006', 'Ahmad Panji Nicky Sae', '3A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(141, '230103008', 'Ahmad Zidni Mubarrok', '3A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(142, '230103061', 'Bintang Rafa Maula A\'jibatul .', '3A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(143, '230103017', 'DEANDRA OMAR KHAYRY ATTHARIQ', '3A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(144, '230103018', 'DHAREL JUNIOR MULYONO PUTRA', '3A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(145, '230102002', 'DUTA TAUFIQI RISKY AJI', '3A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(146, '230102003', 'ESA NAILUL DHAFAR', '3A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(147, '230102004', 'FAZA NAILUL DHAFIR', '3A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(148, '230103023', 'Iqbal Aldiano Wafa', '3A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(149, '230103048', 'MUHAMMAD RIFKI ALNOFAL HAFID', '3A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(150, '230103040', 'MUHAMMAD AGUNG PRATAMA', '3A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(151, '230103028', 'Mahi Aiman Hakim', '3A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(152, '230103031', 'MOCH KHADAFY S.A.', '3A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(153, '230103033', 'MOH AJI PRAYOGA', '3A', '2025-10-10 09:53:28', '2025-10-10 09:53:28'),
(154, '230103034', 'MOH DAFID AINUL WAFA', '3A', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(155, '230103035', 'MOH NIZAM AZKA MUZAKKA', '3A', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(156, '230102011', 'MUHAMMAD YUSUF NAJMUDDIN', '3A', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(157, '230103045', 'MUHAMMAD IMDAD MAFAKHIR', '3A', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(158, '230103039', 'MOHAMMAD VIAN VABIANSYAH', '3A', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(159, '230103062', 'Vito Febrisio', '3A', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(160, '230103007', 'Ahmad Syauqi Habibi', '3B', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(161, '230103011', 'ATHFAL NIZAR KHAIR AN-NASSAJ', '3B', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(162, '230102001', 'BAGAS ADI PRAMANA', '3B', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(163, '230103022', 'Idia Sabilal Muhammad', '3B', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(164, '230101005', 'KHRISNA NANTA SUKISNA', '3B', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(165, '230103026', 'M. AZZRIL RAFIAN SYAH', '3B', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(166, '240101004', 'MUHAMMAD DAVA ANIDDLORUR AL ATHOILLAH', '3B', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(167, '230102009', 'MUHAMMAD FARIS ABDILLAH', '3B', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(168, '230102007', 'MOHAMMAD SUJA DZAKI FAUZAN', '3B', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(169, '230102010', 'MUHAMMAD ULIN NUHA AL ASY\'ARI', '3B', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(170, '230103036', 'MOHAMAD BINTANG AZ ZIKRA', '3B', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(171, '230103043', 'MUHAMMAD HAFEEL KHOIR FAUZY', '3B', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(172, '230103037', 'MOHAMMAD ABDI ZAKKI PRAYOGO', '3B', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(173, '230103063', 'MUHAMMAD BARA SATRIA P', '3B', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(174, '230103052', 'PANDU MARENZA', '3B', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(175, '230103056', 'Rama Tri Adi Saputra', '3B', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(176, '230103010', 'AKHMAD RIFQIATUR ROHMAN', '3B', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(177, '230103059', 'Zauqy Syabil Azra', '3B', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(178, '250102001', 'A RAISA AL HAKIM', '4', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(179, '250102004', 'Afdelan cahyaa rahmadinata putra', '4', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(180, '230103001', 'ADENARTA NOVALUNA', '4', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(181, '250101004', 'M Sholehhddin al ayyubi', '4', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(182, '250101009', 'MOHAMMAD DWI FEBRIANSYAH', '4', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(183, '250102005', 'M. Iklil Reza Al-Ilma', '4', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(184, '250101006', 'Marfel Tria Andika Pratama', '4', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(185, '250102006', 'Muhammad Ghiffari Lukman', '4', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(186, '250102007', 'Muhammad Hakki Nugroho', '4', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(187, '250101010', 'Muhammad Jaisyal Amirullah', '4', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(188, '250102009', 'MUHAMMAD RAFFI ZAINURI ARHAM', '4', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(189, '250101011', 'Nizar Hilal Audani', '4', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(190, '250101014', 'Rafa Adji Alfaza', '4', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(191, '240101005', 'M. UBAYDILLAH AKBAR', '5', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(192, '240101009', 'AHMAD SYAIF ARROSID', '5', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(193, '240101008', 'Bevan Azwar Maulana', '5', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(194, '240101010', 'DIRLY ADID KURNIAWAN', '5', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(195, '240101006', 'FATIR MAULANA M.', '5', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(196, '240102007', 'Ghalen Imtithal Da\'ifullah', '5', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(197, '240101011', 'Izzul Mutaaqin', '5', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(198, '240102004', 'MOH. ALIF SYAFII', '5', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(199, '240102008', 'M Fahmi Arifin', '5', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(200, '240101002', 'MOH FAREL IBRAHIM', '5', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(201, '240102005', 'MUHAMMAD RAFSANJANI', '5', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(202, '240102009', 'Reyhan Wahyu', '5', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(203, '240101001', 'TRIO SUKRON MAKMUN', '5', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(204, '230101003', 'CHOIRUL UMAM ARIFI', '6', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(205, '240102010', 'M. Farid Nur Hidayad', '6', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(206, '230102012', 'M. Nuzulul Umam', '6', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(207, '230101008', 'MUHAMMAD ZAINI ROHMATULLAH', '6', '2025-10-10 09:53:29', '2025-10-10 09:53:29'),
(208, '230101009', 'Nofta Farel Ardyanzhah', '6', '2025-10-10 09:53:29', '2025-10-10 09:53:29');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('8EPzD6Xsthxn2Ty4McJJhBbowebj0dVKKmVkI8tD', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiT2dQOXlURHlMMUNldWVCUVpvS0pPNUZVczJyRjZhbVpyUk02c0NkMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1768139857);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@absen.qr', NULL, '$2y$12$Z0XnZMJdeyeQU48WdM4EWemQVmxZjPd45MourVqhISotK2ULtH4/m', 'eowaFz3yIyTl4bCPQ3OtpECU6rmSIaD2jFaTKdULZtaqR7OQetmcuhpqCwSn', '2025-10-08 20:10:28', '2025-10-08 20:10:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `absensi_nis_foreign` (`nis`),
  ADD KEY `absensi_jadwal_id_foreign` (`jadwal_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jadwal_absen`
--
ALTER TABLE `jadwal_absen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jadwal_absen_kode_index` (`kode`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `santri`
--
ALTER TABLE `santri`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `santri_nis_unique` (`nis`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal_absen`
--
ALTER TABLE `jadwal_absen`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `santri`
--
ALTER TABLE `santri`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=209;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_jadwal_id_foreign` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal_absen` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `absensi_nis_foreign` FOREIGN KEY (`nis`) REFERENCES `santri` (`nis`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
