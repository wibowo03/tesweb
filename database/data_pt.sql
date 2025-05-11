-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 23, 2018 at 01:57 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `data_pt`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_pt`
--

CREATE TABLE `data_pt` (
  `id_pt` int(4) NOT NULL,
  `nama_pt` varchar(128) COLLATE utf8_bin NOT NULL,
  `akreditasi_pt` varchar(64) COLLATE utf8_bin NOT NULL,
  `lokasi_pt` varchar(64) COLLATE utf8_bin NOT NULL,
  `jenjang_pt` varchar(64) COLLATE utf8_bin NOT NULL,
  `kuota_pt` varchar(64) COLLATE utf8_bin NOT NULL,
  `ipk_pt` varchar(64) COLLATE utf8_bin NOT NULL,
  `akreditasi_angka` varchar(64) COLLATE utf8_bin NOT NULL,
  `lokasi_angka` varchar(64) COLLATE utf8_bin NOT NULL,
  `jenjang_angka` varchar(64) COLLATE utf8_bin NOT NULL,
  `kuota_angka` varchar(64) COLLATE utf8_bin NOT NULL,
  `ipk_angka` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `data_pt`
--

INSERT INTO `data_pt` (`id_pt`, `nama_pt`, `akreditasi_pt`, `lokasi_pt`, `jenjang_pt`, `kuota_pt`, `ipk_pt`, `akreditasi_angka`, `lokasi_angka`, `jenjang_angka`, `kuota_angka`, `ipk_angka`) VALUES
(1, 'Universitas Airlangga ', 'Unggul', 'Sumatera, Jawa, Bali', 'Diploma & Sarjana', '400', '>3,5', '5', '5', '5', '5', '5'),
(2, 'Universitas Islam Riau', 'Unggul', 'Sumatera, Jawa, Bali', 'Sarjana', '200', '>3,5', '5', '5', '3', '3', '5'),
(3, 'Universitas Khairun', 'B', 'Maluku,Nusa Tenggara,Papua', 'Sarjana', '250', '2,75-3,1', '1', '1', '3', '3', '1'),
(4, 'Universitas Hasanuddin', 'Unggul', 'Kalimantan & Sulawesi', 'Sarjana', '350', '>3,5', '5', '3', '3', '5', '5'),
(5, 'Universitas Lambung Mangkurat', 'Baik', 'Kalimantan & Sulawesi', 'Sarjana', '150', '3,11-3,5', '1', '3', '3', '3', '3');

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int(4) NOT NULL,
  `nama_kriteria` varchar(128) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `nama_kriteria`) VALUES
(1, 'Akreditasi'),
(2, 'Lokasi'),
(3, 'Jenjang Pendidikan'),
(4, 'Kuota'),
(5, 'IPK');

-- --------------------------------------------------------

--
-- Table structure for table `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `id_subkriteria` int(4) NOT NULL,
  `id_kriteria` int(4) NOT NULL,
  `nama_subkriteria` varchar(128) COLLATE utf8_bin NOT NULL,
  `angka_subkriteria` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `sub_kriteria`
--

INSERT INTO `sub_kriteria` (`id_subkriteria`, `id_kriteria`, `nama_subkriteria`, `angka_subkriteria`) VALUES
(1, 1, 'Unggul', '5'),
(2, 1, 'Baik', '3'),
(3, 1, 'B', '1'),
(4, 2, 'Sumatera, Jawa, Bali', '5'),
(5, 2, 'Kalimantan & Sulawesi', '3'),
(6, 2, 'Maluku,Nusa Tenggara,Papua', '1'),
(7, 3, 'Diploma & Sarjana', '5'),
(8, 3, 'Sarjana', '3'),
(9, 3, 'Diploma', '1'),
(10, 4, '> 225', '5'),
(11, 4, '130 - 225', '3'),
(12, 4, '50 - 125', '1'),
(13, 5, '>3,5', '5'),
(14, 5, '3,11-3,5', '3'),
(15, 5, '2,75-3,1', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_pt`
--
ALTER TABLE `data_pt`
  ADD PRIMARY KEY (`id_pt`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indexes for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD PRIMARY KEY (`id_subkriteria`),
  ADD KEY `id_kriteria` (`id_kriteria`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_pt`
--
ALTER TABLE `data_pt`
  MODIFY `id_pt` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id_subkriteria` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD CONSTRAINT `sub_kriteria_ibfk_1` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;