-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2025 at 12:42 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `api_eskul`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensis`
--

CREATE TABLE `absensis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `eskul_id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('hadir','alfa','izin','sakit') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eskuls`
--

CREATE TABLE `eskuls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jadwal` varchar(255) NOT NULL,
  `pembina_id` bigint(20) UNSIGNED NOT NULL,
  `tempat` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `eskuls`
--

INSERT INTO `eskuls` (`id`, `nama`, `jadwal`, `pembina_id`, `tempat`, `created_at`, `updated_at`) VALUES
(2, 'Paskibra', 'Senin, 15:00 WIB', 3, 'Lapangan Utama', '2025-06-25 19:58:30', '2025-06-25 19:58:30'),
(3, 'PMR', 'Senin, 15:00 WIB', 4, 'Lapangan Utama', '2025-06-25 19:58:30', '2025-06-25 19:58:30'),
(4, 'Pramuka', 'Senin, 15:00 WIB', 10, 'Lapangan Utama', '2025-06-25 19:59:17', '2025-06-25 19:59:17'),
(5, 'Paskibra', 'Senin, 15:00 WIB', 11, 'Lapangan Utama', '2025-06-25 19:59:17', '2025-06-25 19:59:17'),
(6, 'PMR', 'Senin, 15:00 WIB', 12, 'Lapangan Utama', '2025-06-25 19:59:17', '2025-06-25 19:59:17'),
(7, 'Pramuka', 'Senin, 15:00 WIB', 3, 'Lapangan Utama', '2025-06-25 22:37:42', '2025-06-25 22:37:42');

-- --------------------------------------------------------

--
-- Table structure for table `eskul_siswa`
--

CREATE TABLE `eskul_siswa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `eskul_id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `eskul_siswa`
--

INSERT INTO `eskul_siswa` (`id`, `eskul_id`, `siswa_id`, `created_at`, `updated_at`) VALUES
(3, 2, 6, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_06_26_022253_create_eskuls_table', 1),
(5, '2025_06_26_022353_create_eskul_siswa_table', 1),
(6, '2025_06_26_022422_create_absensis_table', 1),
(7, '2025_06_26_073834_create_nilais_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `nilais`
--

CREATE TABLE `nilais` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `eskul_id` bigint(20) UNSIGNED NOT NULL,
  `tahun_ajaran` varchar(255) NOT NULL,
  `nilai` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','siswa','pembina') NOT NULL,
  `nisn` varchar(255) DEFAULT NULL,
  `kelas` varchar(255) DEFAULT NULL,
  `no_telp` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `nisn`, `kelas`, `no_telp`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Utama', 'admin@example.com', NULL, '$2y$12$PgMzhkmy1dh6hl2F5jJbBetN6BxvEsb.JH1anm4c56oZPnFr7DGua', 'admin', NULL, NULL, NULL, NULL, '2025-06-25 19:58:28', '2025-06-25 19:58:28'),
(2, 'Dr. Dahlia Leannon', 'sylvia64@example.net', NULL, '$2y$12$7Y0S//w7C5PXdfC8wE7Zn.j8SeaFmwDHcRAK/buP1UA/Dv2km8dOq', 'pembina', NULL, NULL, '+1.760.453.5839', NULL, '2025-06-25 19:58:29', '2025-06-25 19:58:29'),
(3, 'Dr. Breanne Fahey II', 'lora.glover@example.com', NULL, '$2y$12$eQh2SfvBfUQ9OR5Gz927MuchuESCZN1mEt2u/nzNng5fEhjgEqGUe', 'pembina', NULL, NULL, '+1.760.453.5839', NULL, '2025-06-25 19:58:29', '2025-06-25 19:58:29'),
(4, 'Janae Hansen', 'rpfeffer@example.org', NULL, '$2y$12$yXvZhoSC0/app/rvtm.uJ.o.uYtB4/CSzbSq0ppEG0vweXzA8rD2y', 'pembina', NULL, NULL, '+1.760.453.5839', NULL, '2025-06-25 19:58:29', '2025-06-25 19:58:29'),
(5, 'Serena Luettgen Sr.', 'rolando.gleichner@example.com', NULL, '$2y$12$1Ohozd0u3FnlwpZEeTLcVeD9QyffZezCLqbjXEejC72DZl6BWBXFW', 'siswa', '673752297823', 'XII IPA 1', '+1-248-659-9472', NULL, '2025-06-25 19:58:30', '2025-06-25 19:58:30'),
(6, 'Marcella Graham', 'toni.schuster@example.org', NULL, '$2y$12$crRUWNCT9K9YSV11xrhAxeM2oFPS8OQOF5pPwivoaelU0HiyRll/.', 'siswa', '673752297823', 'XII IPA 1', '+1-248-659-9472', NULL, '2025-06-25 19:58:30', '2025-06-25 19:58:30'),
(7, 'Dylan Romaguera', 'auer.marisa@example.org', NULL, '$2y$12$uFZ3SH9zqpy9B0E580JJ8.UilaFZk9RRt5ix1gDRF7/0IVADT0mRG', 'siswa', '673752297823', 'XII IPA 1', '+1-248-659-9472', NULL, '2025-06-25 19:58:30', '2025-06-25 19:58:30'),
(8, 'Elizabeth Romaguera', 'christopher96@example.org', NULL, '$2y$12$dJ7xR7JoocUdeaqASDBqW.SmfU6GqL9VD8P4rXpD5PXoKX/Co.Yhi', 'siswa', '673752297823', 'XII IPA 1', '+1-248-659-9472', NULL, '2025-06-25 19:58:30', '2025-06-25 19:58:30'),
(9, 'Sebastian Daugherty', 'matilde81@example.com', NULL, '$2y$12$RA75m7JutuvVCj0T5/P4w.O7PL49p1PvQyDe.EXkZSAtKRxjPOLMi', 'siswa', '673752297823', 'XII IPA 1', '+1-248-659-9472', NULL, '2025-06-25 19:58:30', '2025-06-25 19:58:30'),
(10, 'Prof. Timmy Sporer', 'cschinner@example.net', NULL, '$2y$12$pA/MsZvfTvFdyNmON0FG6eKQe1ELN5esJ1SOh4NFCViqdgvBR2e3i', 'pembina', NULL, NULL, '845.251.5633', NULL, '2025-06-25 19:59:15', '2025-06-25 19:59:15'),
(11, 'Jalyn Spencer', 'russel.kiana@example.org', NULL, '$2y$12$nmFsOfwP6AafQ933zwkmVexLEAypYwN5JtEX/iOf6LBcen7YY8wZy', 'pembina', NULL, NULL, '845.251.5633', NULL, '2025-06-25 19:59:15', '2025-06-25 19:59:15'),
(12, 'Nathen Macejkovic', 'tjones@example.org', NULL, '$2y$12$ruW2ioLNjKNPHQPAVB6NCeM2AbZ5gHESFPpy15b1EDh18L.OewCzS', 'pembina', NULL, NULL, '845.251.5633', NULL, '2025-06-25 19:59:15', '2025-06-25 19:59:15'),
(13, 'Mrs. Cassidy Kiehn', 'gideon.koch@example.net', NULL, '$2y$12$ZLKpsa1vrYKcdkLdLulQ2ewn29TbwE63UOM08.i5HV4fo7hwry6uG', 'siswa', '722802516141', 'XII IPA 1', '1-765-381-1468', NULL, '2025-06-25 19:59:17', '2025-06-25 19:59:17'),
(14, 'Dr. Coby Lueilwitz', 'wnienow@example.org', NULL, '$2y$12$J1L4nVmCW9qpae9bd5BukuQQT7DLPPoJAtqcL8fVL//7Wu3Ixb3RG', 'siswa', '722802516141', 'XII IPA 1', '1-765-381-1468', NULL, '2025-06-25 19:59:17', '2025-06-25 19:59:17'),
(15, 'Dr. Clay Durgan PhD', 'hansen.meda@example.net', NULL, '$2y$12$aXqQQmQjRBccOGa01Vus3utYQ6nWClwO.NbwPRPw0alBkNbTdagEi', 'siswa', '722802516141', 'XII IPA 1', '1-765-381-1468', NULL, '2025-06-25 19:59:17', '2025-06-25 19:59:17'),
(16, 'Carson Feil', 'heaney.sofia@example.org', NULL, '$2y$12$keoIdoNqd2V5SVOKssMy/uxCaPikeJ7JnnS8L0P9VGHLU0iwVAhOO', 'siswa', '722802516141', 'XII IPA 1', '1-765-381-1468', NULL, '2025-06-25 19:59:17', '2025-06-25 19:59:17'),
(17, 'Bonnie Ryan MD', 'ruecker.joelle@example.com', NULL, '$2y$12$XkOVrDdCPVrno3YMGU5zEuOvHJwaJQVB7zybuquUjjbt5gzgI3WvO', 'siswa', '722802516141', 'XII IPA 1', '1-765-381-1468', NULL, '2025-06-25 19:59:17', '2025-06-25 19:59:17'),
(18, 'Asep', 'asep@gmail.com', NULL, '$2y$12$Z3zGs1E.7WZ/xqcg2GNteOB6pvO7uzLwLSS7ukc6wx6.PbYwAOzD6', 'siswa', '1234567890', 'XII IPA 1', '081234567890', NULL, '2025-06-25 20:21:21', '2025-06-25 20:21:21'),
(19, 'Budi Siswa', 'budi@example.com', NULL, '$2y$12$Tkpi5muBbwRwIG8Y8UWrVesMlcjRejhJRp5L8mM6yHnD4ouIBR1.m', 'siswa', '1234567890', 'XII IPA 1', '081234567890', NULL, '2025-06-25 22:39:10', '2025-06-25 22:39:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensis`
--
ALTER TABLE `absensis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `absensis_eskul_id_foreign` (`eskul_id`),
  ADD KEY `absensis_siswa_id_foreign` (`siswa_id`);

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
-- Indexes for table `eskuls`
--
ALTER TABLE `eskuls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `eskuls_pembina_id_foreign` (`pembina_id`);

--
-- Indexes for table `eskul_siswa`
--
ALTER TABLE `eskul_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `eskul_siswa_eskul_id_foreign` (`eskul_id`),
  ADD KEY `eskul_siswa_siswa_id_foreign` (`siswa_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `nilais`
--
ALTER TABLE `nilais`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nilais_siswa_id_foreign` (`siswa_id`),
  ADD KEY `nilais_eskul_id_foreign` (`eskul_id`);

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
-- AUTO_INCREMENT for table `absensis`
--
ALTER TABLE `absensis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `eskuls`
--
ALTER TABLE `eskuls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `eskul_siswa`
--
ALTER TABLE `eskul_siswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `nilais`
--
ALTER TABLE `nilais`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensis`
--
ALTER TABLE `absensis`
  ADD CONSTRAINT `absensis_eskul_id_foreign` FOREIGN KEY (`eskul_id`) REFERENCES `eskuls` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `absensis_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `eskuls`
--
ALTER TABLE `eskuls`
  ADD CONSTRAINT `eskuls_pembina_id_foreign` FOREIGN KEY (`pembina_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `eskul_siswa`
--
ALTER TABLE `eskul_siswa`
  ADD CONSTRAINT `eskul_siswa_eskul_id_foreign` FOREIGN KEY (`eskul_id`) REFERENCES `eskuls` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `eskul_siswa_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `nilais`
--
ALTER TABLE `nilais`
  ADD CONSTRAINT `nilais_eskul_id_foreign` FOREIGN KEY (`eskul_id`) REFERENCES `eskuls` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilais_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
