-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2023 at 10:41 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ringan_tangan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nama_admin` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_admin`, `email`, `password`, `foto`) VALUES
(12, 'Rendi', 'admin1@gmail.com', '$2y$10$lv9dnalSfY0dzR6NlYH1UePAiEbbFtyvTjA0Q.S7.2LbZGDsetjj.', '');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id_kegiatan` int(20) NOT NULL,
  `fotoKomunitas` varchar(255) DEFAULT NULL,
  `nama_komunitas` varchar(255) DEFAULT NULL,
  `fotoKegiatan` varchar(255) DEFAULT NULL,
  `namaKegiatan` varchar(255) DEFAULT NULL,
  `jenisKegiatan` varchar(255) DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `tanggalMulai` date DEFAULT NULL,
  `tanggalBerakhir` date DEFAULT NULL,
  `batasRegistrasi` date DEFAULT NULL,
  `metodeBriefing` varchar(255) DEFAULT NULL,
  `namaPekerjaan` varchar(255) DEFAULT NULL,
  `relawanDibutuhkan` varchar(255) DEFAULT NULL,
  `totalJamKerja` varchar(255) DEFAULT NULL,
  `tugasRelawan` varchar(255) DEFAULT NULL,
  `kriteriaRelawan` varchar(255) DEFAULT NULL,
  `perlengkapanRelawan` varchar(255) DEFAULT NULL,
  `id_komunitas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kegiatan`
--

INSERT INTO `kegiatan` (`id_kegiatan`, `fotoKomunitas`, `nama_komunitas`, `fotoKegiatan`, `namaKegiatan`, `jenisKegiatan`, `lokasi`, `tanggalMulai`, `tanggalBerakhir`, `batasRegistrasi`, `metodeBriefing`, `namaPekerjaan`, `relawanDibutuhkan`, `totalJamKerja`, `tugasRelawan`, `kriteriaRelawan`, `perlengkapanRelawan`, `id_komunitas`) VALUES
(182, '8041979.jpg', 'dermawan indonesia', '5554185.jpg', 'memberikan sumbangan', 'donasi', 'tanggerang', '2023-12-14', '2023-12-31', '2023-12-16', 'online', 'buruh', '100', '384 jam', 'memberikan sumbangan', 'rajin', 'diri sendiri', 24),
(184, 'th.jpeg', 'Bhinneka Ceria', 'aktivitas-relawan-rumah-zakat-membantu-evakuasi-korban-di-petobo-_181110140108-718.jpg', 'Evakuasi', 'kesehatan', 'dari tadi', '2023-12-15', '2023-12-15', '2023-12-14', 'tatap muka', 'membantu korban gempa', '20', '5', 'mengevakuasi warga', 'yang memiliki waktu luang', 'sepatu boots, sarungtangan', 29),
(185, '8041979.jpg', 'dermawan indonesia', 'sl_050622_50190_20.jpg', 'donorkan darahmu', 'donor darah', 'batam', '2023-12-01', '2024-01-31', '2023-12-28', 'online', 'bebas', '1000', '720 jam', 'mendonor darah', 'golongan darah A', 'diri sendiri', 24),
(186, '088857700_1587707860-54458142_393257388134888_7943449856838729728_o.webp', 'Grow to Give', '348eb39dfb28e9898adc8459ccabd480.jpg', 'Bantuan sosial', 'kesehatan', 'dari tadi', '2023-12-21', '2023-12-31', '2023-12-18', 'tatap muka', 'galangan dana', '20', '30', 'memberi bantuan sosial', 'yang memiliki waktu luang', 'bantuan kesehatan, makanan dll', 30),
(190, 'OFAAX40.jpg', 'Himpunan Mahasiswa Sistem Informasi', 'foto-manfaat-mengikuti-seminar.jpg', 'seminar star up', 'seminar', 'batam', '2023-12-01', '2023-12-02', '2023-12-01', 'online', 'bebas', '100', '24 jam', 'sebagai audiens', 'remaja', 'diri sendiri', 27),
(191, 'download.jpeg', 'Republic  friends', 'hari-menanam-pohon-indonesia-hmpi-20201606820578.jpeg', 'Reboisasi', 'Alam', 'dari tadi', '2023-12-15', '2023-12-18', '2023-12-12', 'tatap muka', 'petani', '20', '14', 'Menanam pohon', 'yang memiliki waktu luang', 'sepatu boots, sarungtangan, baju olahraga', 26),
(192, 'blog-5.jpg', 'ganteng', 'blog-1.jpg', 'reboisasi Hutan ava', 'Alam', 'dari tadi', '2023-12-07', '2023-12-12', '2023-12-27', 'Zoom', 'petani', '20', '14', 'Menanam pohon', 'yang memiliki waktu luang', 'sepatu boots, sarungtangan, baju olahraga', 25),
(193, 'blog-5.jpg', 'ganteng', 'ghy.png', 'reboisasi Hutan avaas', 'Alam', 'dari tadi', '2023-12-14', '2024-01-05', '2023-12-19', 'Zoom', 'petani', '20', '14', 'Menanam pohon', 'yang memiliki waktu luang', 'sepatu boots, sarungtangan, baju olahraga', 25);

-- --------------------------------------------------------

--
-- Table structure for table `komunitas`
--

CREATE TABLE `komunitas` (
  `id_komunitas` int(20) NOT NULL,
  `nama_komunitas` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ketua` varchar(100) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `tgl_berdiri` date NOT NULL,
  `deskripsi` text NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `komunitas`
--

INSERT INTO `komunitas` (`id_komunitas`, `nama_komunitas`, `email`, `password`, `ketua`, `lokasi`, `tgl_berdiri`, `deskripsi`, `foto`) VALUES
(24, 'dermawan indonesia', 'derindo43@gmail.com', '$2y$10$9v.lxfsBYfhrUzxNhtWgVuuciHY6vldhIiDFjA7c4SEAYK6oBFWQS', 'naufal', 'indonesia', '2023-12-14', 'membantu rakyat kaya', '8041979.jpg'),
(25, 'ganteng', 'cantik1@gmail.com', '$2y$10$iykrL.NoiNVAlxY60/epmOWrDdKVdelXB10H89s9yu87DyGIcmfh.', 'rendi', 'adsa', '2023-12-06', 'sdaf', 'blog-5.jpg'),
(26, 'Republic  friends', 'halodek@gmail.com', '$2y$10$NO3D2xqLz1FZtecT/oeXy.eEXVjK2UEW8g4V39mSAOnUzsahLExuO', 'Rivaldi', 'dari tadi', '2023-12-01', 'membantu masyarakat', 'download.jpeg'),
(27, 'Himpunan Mahasiswa Sistem Informasi', 'himait777@gmail.com', '$2y$10$wv8O0vTVD/zvs9fuigYpCOZFRRL35tVu7rof1DWLmZhDNt.DkyMyi', 'dzaky', 'batam', '2023-12-14', 'aku kaya', 'OFAAX40.jpg'),
(28, 'TRPL TEAM', 'trpl@gmail.com', '$2y$10$MhMfnwMFj2.IvkqG.F2GOumInNn2SLt/2ghnVJdAgGPS4GYAtrO/a', 'Isnan rimex', 'Kampung Baru', '2023-12-14', 'Khusus TRPL POLIBATAM', 'trpl.jpg'),
(29, 'Bhinneka Ceria', 'haloyah@gmail.com', '$2y$10$17H0P.kE8liY9cJPNwZIpeeCrKFiaTjn1zt4trs8mQ3w3sDL1Pm9S', 'Rivaldi', 'dari tadi', '2023-12-02', 'menjadi lebih baik', 'th.jpeg'),
(30, 'Grow to Give', 'halokek@gmail.com', '$2y$10$una9ukPwSX0kGKISFZWn3.Fl0IQRW5GpWMhR03MJM144Mw.kd.Ft.', 'Rivaldi', 'dari tadi', '2023-11-26', 'membantu masyarakat yang membutuhkan', '088857700_1587707860-54458142_393257388134888_7943449856838729728_o.webp');

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id_laporan` int(11) NOT NULL,
  `id_relawan` int(20) DEFAULT NULL,
  `id_pendaftaran` int(11) DEFAULT NULL,
  `id_kegiatan` int(20) DEFAULT NULL,
  `nama_komunitas` varchar(255) DEFAULT NULL,
  `namaKegiatan` varchar(255) DEFAULT NULL,
  `nama_relawan` varchar(255) DEFAULT NULL,
  `komentar` text DEFAULT NULL,
  `tanggal` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`id_laporan`, `id_relawan`, `id_pendaftaran`, `id_kegiatan`, `nama_komunitas`, `namaKegiatan`, `nama_relawan`, `komentar`, `tanggal`) VALUES
(46, 11, 36, 192, 'ganteng', 'reboisasi Hutan ava', 'Rendi Sinaga', 'Kegiatan ini benar benar seru', '2023-12-15');

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id_pendaftaran` int(11) NOT NULL,
  `id_kegiatan` int(20) DEFAULT NULL,
  `id_komunitas` int(20) DEFAULT NULL,
  `namaKomunitas` varchar(255) DEFAULT NULL,
  `namaKegiatan` varchar(255) DEFAULT NULL,
  `nama_relawan` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `alasan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendaftaran`
--

INSERT INTO `pendaftaran` (`id_pendaftaran`, `id_kegiatan`, `id_komunitas`, `namaKomunitas`, `namaKegiatan`, `nama_relawan`, `email`, `alasan`) VALUES
(35, 186, 30, 'Grow to Give', 'Bantuan sosial', 'Dzaky', 'dzaky10@gmail.com', 'dads'),
(36, 192, 25, 'ganteng', 'reboisasi Hutan ava', 'Rendi Sinaga', 'rendysinagaa10@gmail.com', 'karena kegiatan ini menyenangkan'),
(37, 191, 26, 'Republic  friends', 'Reboisasi', 'Rendi Sinaga', 'rendysinagaa10@gmail.com', 'Karena kegiatan ini sepertinya seru');

-- --------------------------------------------------------

--
-- Table structure for table `relawan`
--

CREATE TABLE `relawan` (
  `id_relawan` int(20) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `jenis_kelamin` varchar(50) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `relawan`
--

INSERT INTO `relawan` (`id_relawan`, `nama`, `email`, `password`, `tanggal_lahir`, `alamat`, `jenis_kelamin`, `deskripsi`, `foto`) VALUES
(11, 'Rendi Sinaga', 'rendysinagaa10@gmail.com', '$2y$10$TdsxWDanwqrgUAIVkgvkyeUWnjxxsZhtpFXomZvW.SNBlameazmp.', '2023-12-11', 'Bali', 'Laki-Laki', NULL, ''),
(12, 'Dzaky', 'dzaky10@gmail.com', '$2y$10$nkLOiuV23lHHsRAqbg2wH.b/jhUIU2TCFPrLNENRLaDwgoQpEgUYa', '2023-11-27', 'Bali', 'Laki-Laki', NULL, ''),
(13, 'aku', 'aku1234@gmail.com', '$2y$10$HgGnGmk5YhprO2r5F1WQFOecj/bdRfmM6mrkUnu5awOAA1ei.0u3m', '2023-12-26', 'Bali', 'Laki-Laki', NULL, NULL),
(14, 'isnan', 'isnan@gmail.com', '$2y$10$6cyjLtxlGtkmusp62cnGaesu.awaHF97k6C6rcGOhv1w3INYBnCCO', '2023-11-27', 'Kampung Baru', 'Laki-Laki', NULL, NULL),
(15, 'Puteri', 'ptri@gmail.com', '$2y$10$kPYm/I5TFNWdP1CB/H68hesiYco6iNQAYVAZpHXnnUIg9kthJhos.', '2023-06-01', 'Tiban Koperasi ', 'Perempuan', NULL, NULL),
(16, 'Nuriyanti', 'nur@gmail.com', '$2y$10$cOxumju6dxjoKH5e7GXdTuW.yz4.WtaFvGhitbtWmaOES5RSooFC.', '2023-03-31', 'Batu aji', 'Perempuan', NULL, NULL),
(17, 'John', 'jon@gmail.com', '$2y$10$fK5hcSx5nOjGwwVu6IvCL.M2kzWelmnI/j7U.zy0BBpoK2ofNzB22', '2022-06-11', 'Jakarta', 'Laki-Laki', NULL, NULL),
(18, 'KIX', 'ki2@gmail.com', '$2y$10$C8wvnslKAkj3LxWXTqVmY.gGtQMXu5vhzLOIZt.HCEbnAWQ7Cv6XC', '2023-05-12', 'dirumah', 'Laki-Laki', NULL, NULL),
(19, 'Aldy', 'alddi@gmail.com', '$2y$10$Ww.ajeU4NmqnefbhosBhbe4gzy7t7fvsMCoLz0X1rBWdrPyGBnB72', '2023-12-21', 'Karimun ', 'Laki-Laki', NULL, NULL),
(20, 'Bowen ', 'Bown@gmail.com', '$2y$10$Wd2Kr48S2.rrkktvISutGO8H3FC1EaY35BYK0YBtxpt5hZ0QFZtva', '2023-12-07', 'Batu aji', 'Laki-Laki', NULL, NULL),
(21, 'upil', 'upil12@gmail.com', '$2y$10$3itAJMZ8oh8fQnLa5MN7duBBzGxnH99kr48QqVzcANxuLPKsVHjmC', '2023-12-14', 'batam', 'Laki-Laki', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`),
  ADD KEY `id_komunitas` (`id_komunitas`);

--
-- Indexes for table `komunitas`
--
ALTER TABLE `komunitas`
  ADD PRIMARY KEY (`id_komunitas`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `id_relawan` (`id_relawan`),
  ADD KEY `id_pendaftaran` (`id_pendaftaran`),
  ADD KEY `id_kegiatan` (`id_kegiatan`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`),
  ADD KEY `id_kegiatan` (`id_kegiatan`),
  ADD KEY `id_komunitas` (`id_komunitas`),
  ADD KEY `nama_relawan` (`nama_relawan`);

--
-- Indexes for table `relawan`
--
ALTER TABLE `relawan`
  ADD PRIMARY KEY (`id_relawan`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_nama` (`nama`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id_kegiatan` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- AUTO_INCREMENT for table `komunitas`
--
ALTER TABLE `komunitas`
  MODIFY `id_komunitas` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `relawan`
--
ALTER TABLE `relawan`
  MODIFY `id_relawan` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD CONSTRAINT `kegiatan_ibfk_2` FOREIGN KEY (`id_komunitas`) REFERENCES `komunitas` (`id_komunitas`);

--
-- Constraints for table `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`id_relawan`) REFERENCES `relawan` (`id_relawan`),
  ADD CONSTRAINT `laporan_ibfk_2` FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran` (`id_pendaftaran`),
  ADD CONSTRAINT `laporan_ibfk_3` FOREIGN KEY (`id_kegiatan`) REFERENCES `kegiatan` (`id_kegiatan`);

--
-- Constraints for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD CONSTRAINT `pendaftaran_ibfk_1` FOREIGN KEY (`id_kegiatan`) REFERENCES `kegiatan` (`id_kegiatan`),
  ADD CONSTRAINT `pendaftaran_ibfk_2` FOREIGN KEY (`id_komunitas`) REFERENCES `komunitas` (`id_komunitas`),
  ADD CONSTRAINT `pendaftaran_ibfk_3` FOREIGN KEY (`nama_relawan`) REFERENCES `relawan` (`nama`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
