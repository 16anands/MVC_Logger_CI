-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2019 at 09:00 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wftppdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `querylog`
--

CREATE TABLE `querylog` (
  `queryid` int(11) NOT NULL,
  `ProjectID` int(11) NOT NULL,
  `Category` varchar(15) NOT NULL,
  `DepositDate` date NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `Payer` varchar(200) NOT NULL,
  `Encounter` varchar(30) NOT NULL,
  `RequestedDate` varchar(25) NOT NULL,
  `RequestedBy` varchar(10) NOT NULL,
  `amtinq` decimal(10,2) NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `AssignedID` varchar(10) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `querylog`
--

INSERT INTO `querylog` (`queryid`, `ProjectID`, `Category`, `DepositDate`, `Amount`, `Payer`, `Encounter`, `RequestedDate`, `RequestedBy`, `amtinq`, `comment`, `AssignedID`, `status`) VALUES
(1, 27, 'EFT', '2018-09-19', '13.98', 'CIGNA', '1234567890', '2019-02-25 12:58:11', 'AS050699', '10.11', 'question', 'VB054005', 18),
(2, 27, 'EFT', '2018-09-19', '13.98', 'CIGNA', '12345', '2019-02-25 13:09:12', 'AS050699', '10.00', '123', 'VB054005', 18),
(3, 27, 'EFT', '2018-09-19', '13.98', 'CIGNA', '2121', '2019-02-25 13:11:16', 'AS050699', '1.00', '1212', 'VB054005', 18),
(4, 27, 'EFT', '2018-09-19', '13.98', 'CIGNA', '121212', '2019-02-25 13:13:13', 'AS050699', '12.00', '212121', 'VB054005', 18),
(5, 27, 'EFT', '2018-09-19', '13.98', 'CIGNA', '212121', '2019-02-25 13:18:16', 'AS050699', '1.00', '212121', 'VB054005', 18),
(6, 27, 'EFT', '2018-09-19', '13.98', 'CIGNA', '1111', '2019-02-25 13:24:57', 'AS050699', '111.00', '111', 'VB054005', 18),
(7, 27, 'EFT', '2018-09-19', '13.98', 'CIGNA', '111', '2019-02-25 13:27:28', 'AS050699', '111.00', '111', 'VB054005', 18),
(8, 27, 'EFT', '2018-09-19', '13.98', 'CIGNA', '11', '2019-02-25 13:30:19', 'AS050699', '11.00', '11', 'VB054005', 18);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `querylog`
--
ALTER TABLE `querylog`
  ADD PRIMARY KEY (`queryid`),
  ADD KEY `FI` (`ProjectID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `querylog`
--
ALTER TABLE `querylog`
  MODIFY `queryid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
