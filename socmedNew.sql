-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2021 at 02:54 PM
-- Server version: 10.4.14-MariaDB-log
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `socmed`
--

-- --------------------------------------------------------

--
-- Table structure for table `jeniskelamin`
--

CREATE TABLE `jeniskelamin` (
  `IDJENISKELAMIN` varchar(5) NOT NULL,
  `JENISKELAMIN` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jeniskelamin`
--

INSERT INTO `jeniskelamin` (`IDJENISKELAMIN`, `JENISKELAMIN`) VALUES
('J01', 'Laki-Laki'),
('J02', 'Perempuan');

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `IDLEVEL` varchar(5) NOT NULL,
  `NAMALEVEL` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`IDLEVEL`, `NAMALEVEL`) VALUES
('L001', 'Admin'),
('L002', 'Member');

-- --------------------------------------------------------

--
-- Table structure for table `pertemanan`
--

CREATE TABLE `pertemanan` (
  `IDPERTEMANAN` varchar(5) NOT NULL,
  `STATUSPERTEMANAN` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pertemanan`
--

INSERT INTO `pertemanan` (`IDPERTEMANAN`, `STATUSPERTEMANAN`) VALUES
('B001', 'Berteman'),
('B002', 'Blokir');

-- --------------------------------------------------------

--
-- Table structure for table `posting`
--

CREATE TABLE `posting` (
  `IDPOSTING` varchar(5) NOT NULL,
  `PESAN` text NOT NULL,
  `GAMBARPOSTING` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `IDUSER` varchar(5) NOT NULL,
  `IDJENISKELAMIN` varchar(5) DEFAULT NULL,
  `IDLEVEL` varchar(5) DEFAULT NULL,
  `USERNAME` varchar(12) NOT NULL,
  `PASSWORD` varchar(256) NOT NULL,
  `NAMAUSER` varchar(256) NOT NULL,
  `TANGGALLAHIR` date NOT NULL,
  `PHOTO` varchar(256) NOT NULL,
  `EMAIL` varchar(256) NOT NULL,
  `NOHP` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`IDUSER`, `IDJENISKELAMIN`, `IDLEVEL`, `USERNAME`, `PASSWORD`, `NAMAUSER`, `TANGGALLAHIR`, `PHOTO`, `EMAIL`, `NOHP`) VALUES
('U001', 'J01', 'L002', 'Rizki1', '202cb962ac59075b964b07152d234b70', 'Rizki Ashuri Pratama', '2001-05-13', 'IMG20210307185056-removebg-preview.jpg', 'rizkiashuri@gmail.com', '08996668479'),
('U002', 'J02', 'L002', 'Alfi1', '202cb962ac59075b964b07152d234b70', 'Alfi NK', '2001-09-23', 'bagan.png', 'alfi@gmail.com', '085719838742');

-- --------------------------------------------------------

--
-- Table structure for table `user_pertemanan`
--

CREATE TABLE `user_pertemanan` (
  `IDUSER` varchar(5) NOT NULL,
  `IDUSER2` varchar(5) NOT NULL,
  `IDPERTEMANAN` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_pertemanan`
--

INSERT INTO `user_pertemanan` (`IDUSER`, `IDUSER2`, `IDPERTEMANAN`) VALUES
('U001', 'U002', 'B001');

-- --------------------------------------------------------

--
-- Table structure for table `user_posting`
--

CREATE TABLE `user_posting` (
  `IDUSER` varchar(5) NOT NULL,
  `IDPOSTING` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jeniskelamin`
--
ALTER TABLE `jeniskelamin`
  ADD PRIMARY KEY (`IDJENISKELAMIN`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`IDLEVEL`);

--
-- Indexes for table `pertemanan`
--
ALTER TABLE `pertemanan`
  ADD PRIMARY KEY (`IDPERTEMANAN`);

--
-- Indexes for table `posting`
--
ALTER TABLE `posting`
  ADD PRIMARY KEY (`IDPOSTING`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`IDUSER`),
  ADD KEY `FK_USER_JENISKELAMIN` (`IDJENISKELAMIN`),
  ADD KEY `FK_USER_LEVEL` (`IDLEVEL`);

--
-- Indexes for table `user_pertemanan`
--
ALTER TABLE `user_pertemanan`
  ADD PRIMARY KEY (`IDUSER`,`IDPERTEMANAN`),
  ADD KEY `FK_USER_PERTEMANAN2` (`IDPERTEMANAN`),
  ADD KEY `IDUSER2` (`IDUSER2`);

--
-- Indexes for table `user_posting`
--
ALTER TABLE `user_posting`
  ADD PRIMARY KEY (`IDUSER`,`IDPOSTING`),
  ADD KEY `FK_USER_POSTING2` (`IDPOSTING`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_USER_JENISKELAMIN` FOREIGN KEY (`IDJENISKELAMIN`) REFERENCES `jeniskelamin` (`IDJENISKELAMIN`),
  ADD CONSTRAINT `FK_USER_LEVEL` FOREIGN KEY (`IDLEVEL`) REFERENCES `level` (`IDLEVEL`);

--
-- Constraints for table `user_pertemanan`
--
ALTER TABLE `user_pertemanan`
  ADD CONSTRAINT `FK_USER_PERTEMANAN` FOREIGN KEY (`IDUSER`) REFERENCES `user` (`IDUSER`),
  ADD CONSTRAINT `FK_USER_PERTEMANAN2` FOREIGN KEY (`IDPERTEMANAN`) REFERENCES `pertemanan` (`IDPERTEMANAN`),
  ADD CONSTRAINT `user_pertemanan_ibfk_1` FOREIGN KEY (`IDUSER2`) REFERENCES `user` (`IDUSER`);

--
-- Constraints for table `user_posting`
--
ALTER TABLE `user_posting`
  ADD CONSTRAINT `FK_USER_POSTING` FOREIGN KEY (`IDUSER`) REFERENCES `user` (`IDUSER`),
  ADD CONSTRAINT `FK_USER_POSTING2` FOREIGN KEY (`IDPOSTING`) REFERENCES `posting` (`IDPOSTING`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
