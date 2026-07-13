-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2026 at 07:37 PM
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
-- Database: `perpustakaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nama_admin` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_admin`, `username`, `password`, `foto`, `created_at`) VALUES
(1, 'Administrator', 'admin', 'admin123', 'admin.png', '2026-07-13 03:09:42');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `isbn` varchar(30) DEFAULT NULL,
  `judul` varchar(200) NOT NULL,
  `penulis` varchar(150) DEFAULT NULL,
  `penerbit` varchar(150) DEFAULT NULL,
  `tahun_terbit` year(4) DEFAULT NULL,
  `stok` int(11) DEFAULT 0,
  `cover` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `id_lokasi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `isbn`, `judul`, `penulis`, `penerbit`, `tahun_terbit`, `stok`, `cover`, `deskripsi`, `id_kategori`, `id_lokasi`) VALUES
(1, '9781234567891', 'The Great Gatsby', 'F. Scott Fitzgerald', 'Scribner', '2022', 12, 'gatsby.jpg', 'Novel klasik.', 1, 1),
(2, '9781234567892', 'Digital Frontier', 'A. R. Chen', 'TechPress', '2023', 5, 'digital.jpg', 'Teknologi masa depan.', 2, 2),
(3, '9781234567893', 'Modern Mathematics', 'Dr. Sarah Johnson', 'Education', '2020', 7, 'math.jpg', 'Matematika modern.', 3, 3),
(4, '9781234567894', 'Atomic Habits', 'James Clear', 'Penguin', '2019', 10, 'atomic.jpg', 'Pengembangan diri.', 2, 4),
(5, '9781234567895', 'Clean Code', 'Robert C. Martin', 'Prentice Hall', '2018', 6, 'clean.jpg', 'Pemrograman.', 2, 5),
(6, '3567992762256', 'Laskar Pelangi', 'Andrea Hirata', 'Garin', '2018', 11, '1783926892.jpg', 'ini buku laskar new \r\n', 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Novel'),
(2, 'Teknologi'),
(3, 'Sains'),
(4, 'Sejarah'),
(5, 'Fiksi');

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `id_lokasi` int(11) NOT NULL,
  `nama_lokasi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`id_lokasi`, `nama_lokasi`) VALUES
(1, 'Rak A1'),
(2, 'Rak A2'),
(3, 'Rak B1'),
(4, 'Rak B2'),
(5, 'Rak C1');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_pinjam` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `tanggal_pinjam` date DEFAULT NULL,
  `batas_kembali` date DEFAULT NULL,
  `status` enum('Dipinjam','Dikembalikan','Terlambat') DEFAULT 'Dipinjam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id_pinjam`, `id_siswa`, `id_buku`, `id_admin`, `tanggal_pinjam`, `batas_kembali`, `status`) VALUES
(2, 1, 4, 1, '2026-07-13', '2026-07-14', 'Dikembalikan'),
(4, 5, 5, 1, '2026-07-13', '2026-07-20', 'Dikembalikan'),
(5, 5, 6, 1, '2026-07-13', '2026-07-20', 'Dipinjam'),
(6, 5, 3, 1, '2026-07-13', '2026-07-20', 'Dipinjam');

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id_pengembalian` int(11) NOT NULL,
  `id_pinjam` int(11) NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `terlambat` int(11) DEFAULT 0,
  `denda` decimal(10,2) DEFAULT 0.00,
  `status` enum('Belum','Selesai') DEFAULT 'Belum'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengembalian`
--

INSERT INTO `pengembalian` (`id_pengembalian`, `id_pinjam`, `tanggal_kembali`, `terlambat`, `denda`, `status`) VALUES
(2, 2, '2026-07-16', 0, 2000.00, ''),
(27, 4, '2026-07-13', 0, 0.00, 'Selesai');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `nama_siswa` varchar(100) NOT NULL,
  `kelas` varchar(30) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nis`, `nama_siswa`, `kelas`, `jenis_kelamin`, `email`, `no_hp`, `alamat`, `password`, `foto`, `created_at`) VALUES
(1, '20240001', 'Andi', 'XII RPL 1', 'L', 'andi@email.com', '08123456789', 'Surabaya', '$2y$10$x/as4eGyrs/mjQOpddB/HukRSR6fHWEtVhtQeI3Hfhp3mhv6UDQ5i', '1783954478_andi.jpg', '2026-07-13 03:09:42'),
(2, '12345678', 'Maharani BP', 'XII TKJ 6', 'P', 'rani@gmail.com', '09863345566', 'Surabaya', '$2y$10$oYKK/oO9ooIgDQ4pI75Qc.vHpvULN0yczuxYPYoe9R4xacM008J9a', '1783952570_rani.jpg', '2026-07-13 14:22:50'),
(3, '12346789', 'nesa', 'XII TKJ 2', 'P', 'nesa@gmail.com', '098112223334', 'makassar', '$2y$10$PAsfwyrMkra/X1keuHJWoOmv1lzyt/YtFa89F2SHcGhYpSBl4.7Fu', '1783952679_nesa.jpg', '2026-07-13 14:24:39'),
(5, '111222333', 'jisung kim', 'XII IPA 1', 'L', 'jisung@gmail.com', '08766665423', 'jawa', '$2y$10$7VblNYjASXkqg73DPgnJ8.CEGGMbdSgpnZI9PzfRZFx/baWIGqs6S', '1783954377_jono.jpg', '2026-07-13 14:52:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `id_lokasi` (`id_lokasi`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id_lokasi`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_pinjam`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_buku` (`id_buku`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`id_pengembalian`),
  ADD KEY `id_pinjam` (`id_pinjam`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD UNIQUE KEY `nis` (`nis`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id_lokasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_pinjam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id_pengembalian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`),
  ADD CONSTRAINT `buku_ibfk_2` FOREIGN KEY (`id_lokasi`) REFERENCES `lokasi` (`id_lokasi`);

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`),
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`),
  ADD CONSTRAINT `peminjaman_ibfk_3` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`);

--
-- Constraints for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD CONSTRAINT `pengembalian_ibfk_1` FOREIGN KEY (`id_pinjam`) REFERENCES `peminjaman` (`id_pinjam`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
