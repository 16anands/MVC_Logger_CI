-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2019 at 04:15 AM
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
-- Table structure for table `action`
--

CREATE TABLE `action` (
  `actionid` int(11) NOT NULL,
  `description` varchar(50) NOT NULL,
  `eta` varchar(20) NOT NULL,
  `parent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `action`
--

INSERT INTO `action` (`actionid`, `description`, `eta`, `parent`) VALUES
(111, 'Received EOB via Call', 'Mention Path', 33),
(112, 'Received EOB via Web', 'Mention Path', 33),
(113, 'Received EOB through Email', 'Mention Path', 33),
(114, 'Received EOB through CPDI/TriZetto/RM', 'Mention Path', 33),
(115, 'Insurance Paid Incentive to Provider', 'Mention Path', 33),
(116, 'EOB mailed to Physical Address/Verified Person', 'Move to Associate', 33),
(117, 'Insurance Refused to Send EOB', '48 Hrs', 17),
(118, 'Unable to Contact Insurance', '48 Hrs', 17),
(119, 'Need Client Assistance', '48 Hrs', 17),
(120, 'Need Provider Info', '48 Hrs', 17),
(221, 'Need Patient Info', '48 Hrs', 17),
(222, 'Efforts Exhausted', '48 Hrs', 17),
(223, 'Need to Follow Up', '72 Hrs', 18),
(224, 'Need Valid Check/EFT details', 'Check with Requester', 18),
(225, 'Need to download from website', 'which website', 18),
(226, 'Unable to Reach Insurance Rep', '24 Hrs', 18),
(227, 'Left Voice Mail', '24 Hrs', 18),
(228, 'Awaiting EOB, Requested via Call/Fax', '72 Hrs', 18);

-- --------------------------------------------------------

--
-- Table structure for table `associate`
--

CREATE TABLE `associate` (
  `AssociateID` varchar(10) NOT NULL,
  `AssociateName` varchar(50) NOT NULL,
  `AssociateInitial` varchar(4) NOT NULL,
  `AccessLevel` int(11) NOT NULL,
  `ManagerID` varchar(10) NOT NULL,
  `Active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `associate`
--

INSERT INTO `associate` (`AssociateID`, `AssociateName`, `AssociateInitial`, `AccessLevel`, `ManagerID`, `Active`) VALUES
('AA054796', 'Arjun A', 'AA', 4, 'VB054005', 0),
('AB047334', 'Anup Biswas', 'AB', 2, 'AS050699', 1),
('AB055554', 'Anand Baradwaj', 'AB', 6, '', 0),
('AB061875', 'Akshatha Bhat', 'AB', 2, 'AR060673', 0),
('AG061723', 'Akshay Ghosh', 'AG', 2, 'KP062277', 0),
('AK051664', 'Avilash Kumar ', 'AK', 2, 'KP062277', 0),
('AK053817', 'Ahmed Khan', 'AK', 3, 'RV061973', 0),
('AK065041', 'Achappa K D', 'AK', 2, 'AS050699', 0),
('AM054585', 'Avinash M', 'AM', 3, 'AA054796', 0),
('AN048318', 'Annapurna N V', 'AN', 3, 'AS050699', 0),
('AP051627', 'Arunrani Paramasivan', 'P', 3, 'AA054796', 0),
('AP064797', 'Alok Kumar Prasad', 'AP', 2, 'AS050699', 0),
('AR060673', 'Alok Kumar Raut', 'AR', 4, 'VB054005', 0),
('AR062498', 'Abdul Razeeq', 'AR', 2, 'AS050699', 0),
('AR063853', 'Arjun R', 'AR', 2, 'RV061973', 0),
('AS049048', 'Ashok Selvaraj', 'AS', 2, 'AS050699', 0),
('AS050699', 'Milton Nepoli A', 'MN', 3, 'AS050699', 0),
('AS123456', 'A B', 'AB', 3, 'AR060673', 0),
('BA062369', 'Adiga,Balakrishna', 'BA', 3, 'AA054796', 0),
('BM062711', 'Balaji Maniyan', 'BM', 6, '', 0),
('BN051665', 'Bhagavathi Naidu', 'BN', 2, 'KP062277', 0),
('BP045845', 'Bhavya Prabhakar', 'BP', 3, 'RV061973', 0),
('BV054563', 'Balaji Vishwa', 'BV', 3, 'AR060673', 0),
('C16354', 'Vikash Sharma', 'VS', 2, 'RV061973', 0),
('C16391', 'Girirajan K.M', 'GK', 3, 'AR060673', 0),
('CK063634', 'K,Chethankumar', 'CK', 2, 'AA054796', 0),
('CV033492', 'Celin Velanganni', 'CV', 2, 'AS050699', 0),
('DG054361', 'Dadalaiah G', 'DG', 2, 'AS050699', 0),
('DH057093', 'Hareesh D', 'HD', 2, 'KP062277', 0),
('DH061178', 'Debashree Halder', 'DH', 2, 'AR060673', 0),
('DJ060691', 'J,DILIP KUMAR', 'DJ', 3, 'AA054796', 0),
('EB12345', 'Missing EOB', 'ME', 1, '', 0),
('ER053413', 'Erin Mariyam Raj', 'ER', 2, 'AS050699', 0),
('FB058014', 'Fathima Bano', 'FB', 2, 'KP062277', 0),
('GS061406', 'Gurveer Sehmi', 'GS', 2, 'AR060673', 0),
('HA057833', 'Harish', 'HA', 2, 'AA054796', 0),
('HG054569', 'Hemalatha G', 'GH', 2, 'KP062277', 0),
('IB035055', 'Irfan B S', 'IB', 3, 'AA054796', 0),
('JJ062938', 'Joy Jomin', 'JJ', 12, 'RK063856', 0),
('JN060707', 'Jalaluddin N', 'JN', 2, 'AR060673', 0),
('JW063629 ', 'Jasmine John Wesley', 'JW', 12, 'RK063856', 0),
('KA064827', 'Kumar Anad', 'KA', 2, 'AS050699', 0),
('KB053443', 'Kiran Kumar B', 'KB', 2, 'AS050699', 0),
('KC12345', 'Query KC', 'QK', 5, '', 0),
('KG061116', 'Khan Bahadur Ghouse', 'KG', 13, 'RK063856', 0),
('KK061310', 'K,Kruthika', 'KK', 2, 'AA054796', 0),
('KK064800', 'Karthik Kumar N', 'KN', 2, 'KP062277', 0),
('KP049049', 'Karthick', 'P', 3, 'AA054796', 0),
('KP062277', 'Kiran M P', 'KP', 4, 'VB054005', 0),
('KR051585', 'Kavitha R', 'KR', 2, 'AR060673', 0),
('KR064793', 'Karthick Raja', 'KR', 12, 'RK063856', 0),
('KS060671', 'Kruti SP', 'KS', 2, 'RV061973', 0),
('MA027762', 'Mallikarjun Aralikatti', 'MA', 3, 'AS050699', 0),
('MA053576', 'Musab Ahmed', 'MA', 3, 'AR060673', 0),
('MA064595', 'MASOOD AHMED', 'MA', 2, 'AR060673', 0),
('MA065113', 'Mohammed Ajmal', 'MA', 2, 'AS050699', 0),
('MC063628', 'Munnu Chandran', 'MC', 12, 'RK063856', 0),
('MG064829', 'Madhushree G', 'MG', 2, 'RV061973', 0),
('MK061724', 'Monica Kuttamballi', 'MK', 2, 'KP062277', 0),
('MM060310', 'MN,Maithry', 'MN', 2, 'AA054796', 0),
('MP057280', 'Mohammed Parvez', 'P', 3, 'AA054796', 0),
('MP063745', 'Muheeb Pasha', 'MP', 2, 'AS050699', 0),
('MR060314', 'Mujeeb Urs Rehman', 'MU', 3, 'KP062277', 0),
('MR061556', 'Monisha R', 'MR', 2, 'KP062277', 0),
('MS061050', 'Mani S', 'MS', 3, 'RV061973', 0),
('ND051202', 'Naorem DijenSingh', 'ND', 3, 'RV061973', 0),
('NP060931', 'Paul,Nancy', 'P', 2, 'AA054796', 0),
('NV058289', 'Nimmy Vayola P.C', 'NV', 2, 'AS050699', 0),
('PC051628', 'Poornima C', 'PC', 2, 'AR060673', 0),
('PD060692', 'Mahe,Priyanka', 'PD', 2, 'AA054796', 0),
('PH061043', 'Praveen Hosaganiger', 'PH', 2, 'AS050699', 0),
('PK054220', 'Priyanka K', 'PK', 3, 'RV061973', 0),
('PS053531', 'PramodT Shetty', 'PS', 2, 'AS050699', 0),
('QT12345', 'Query Team', 'QT', 5, '', 0),
('RK063856', 'Ramraj Kumar', 'RK', 14, 'VB054005', 0),
('RM050953', 'Rafeeq Mohammed', 'RM', 3, 'RV061973', 0),
('RS051687', 'Rajorshi Sarkar', 'RS', 2, 'AS050699', 0),
('RV051717', 'Rathish V', 'RV', 2, 'AS050699', 0),
('RV060154', 'Varma K,Rohit', 'RV', 3, 'AA054796', 0),
('RV061973', 'Rajaraman V', 'RV', 4, 'VB054005', 0),
('SB053270', 'Sneha BL', 'SB', 3, 'RV061973', 0),
('SB063705', 'Srinivas Bejavada', 'SB', 12, 'RK063856', 0),
('SC052864', 'Somanna CL', 'SC', 2, 'AR060673', 0),
('SC061728', 'Sudhanshu Singh Chauhan', 'SC', 3, 'AS050699', 0),
('SD054453', 'Sanket Dhingra', 'SD', 6, '', 0),
('SJ057738', 'Saurabh Joshi', 'SJ', 3, 'KP062277', 0),
('SK050988', 'Satyabodh Kadkol', 'SK', 3, 'RV061973', 0),
('SM061886', 'Syed,Mateen', 'SM', 3, 'AA054796', 0),
('SN051276', 'Shasendra Nagaraju', 'SN', 3, 'AR060673', 0),
('SN053864', 'Supriya A N', 'SN', 2, 'AS050699', 0),
('SP048324', 'Sathish P', 'SP', 3, 'KP062277', 0),
('SS061044', 'Sivanandan,Sona', 'SS', 2, 'AA054796', 0),
('SS061120', 'Syed Anwar Ali Shah', 'SA', 2, 'KP062277', 0),
('SS063222', 'Sumanth S', 'SS', 2, 'RV061973', 0),
('SS064831', 'V S,Subramanya', 'SS', 2, 'AA054796', 0),
('ST058232', 'Sanjana, T', 'ST', 3, 'AA054796', 0),
('SV063687', 'Sharanya V', 'SV', 2, 'AR060673', 0),
('TB048504', 'Thyagarajan B', 'TB', 3, 'KP062277', 0),
('TM047542', 'Tochi Manen', 'TM', 3, 'RV061973', 0),
('UK062317', 'USHA KV', 'UK', 2, 'AR060673', 0),
('UM051786', 'Uma Maheswari Marthala', 'UM', 3, 'AR060673', 0),
('VB054005', 'Vinayaka Baburao', 'VB', 6, '', 0),
('VB054575', 'Vinanti Bhat', 'VB', 2, 'AS050699', 0),
('VB060469', 'Vinitha Bai Allipilli', 'VB', 2, 'AS050699', 0),
('VB064572', 'Vaishnavi Badiganeni', 'VB', 2, 'RV061973', 0),
('VK024506', 'Vignesh K', 'VK', 3, 'AA054796', 0),
('VK054590', 'Vinuthna Kurla', 'VK', 3, 'KP062277', 0),
('VS063740', 'Vinutha Shree', 'VS', 2, 'RV061973', 0),
('YM065154', 'M,Yathish', 'YM', 2, 'AA054796', 0);

-- --------------------------------------------------------

--
-- Table structure for table `dailylog`
--

CREATE TABLE `dailylog` (
  `encounter` varchar(30) NOT NULL,
  `MRN` varchar(20) NOT NULL,
  `PostDate` date NOT NULL,
  `transactiontype` varchar(20) NOT NULL,
  `claimpaidamount` decimal(10,2) NOT NULL,
  `operatorID` varchar(50) NOT NULL,
  `facility` varchar(100) NOT NULL,
  `billingentity` varchar(100) NOT NULL,
  `transactionsalias` varchar(20) NOT NULL,
  `transreason` varchar(20) NOT NULL,
  `financialclass` varchar(100) NOT NULL,
  `cpt` varchar(10) NOT NULL,
  `transactionbdid` varchar(15) NOT NULL,
  `batchnumber` varchar(15) NOT NULL,
  `batchtype` varchar(20) NOT NULL,
  `insurance` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `missing`
--

CREATE TABLE `missing` (
  `missingid` int(11) NOT NULL,
  `ProjectID` int(11) DEFAULT NULL,
  `Category` varchar(15) DEFAULT NULL,
  `DepositDate` date DEFAULT NULL,
  `Amount` decimal(10,2) DEFAULT NULL,
  `Payer` varchar(200) DEFAULT NULL,
  `Encounter` varchar(30) DEFAULT NULL,
  `CheckAmt` decimal(10,2) DEFAULT NULL,
  `CheckDate` date DEFAULT NULL,
  `CheckNo` varchar(20) DEFAULT NULL,
  `Website` varchar(20) DEFAULT NULL,
  `Availibility` varchar(10) DEFAULT NULL,
  `CPDIPage` varchar(10) DEFAULT NULL,
  `RequestedDate` varchar(25) DEFAULT NULL,
  `RequestedBy` varchar(10) DEFAULT NULL,
  `Comment` varchar(5000) DEFAULT NULL,
  `AssignedID` varchar(10) DEFAULT NULL,
  `Status` int(11) DEFAULT NULL,
  `action` int(11) DEFAULT NULL,
  `eta` varchar(20) DEFAULT NULL,
  `location` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `otherpayment`
--

CREATE TABLE `otherpayment` (
  `OID` int(11) NOT NULL,
  `Encounter` varchar(30) NOT NULL,
  `baddebt` decimal(10,2) NOT NULL,
  `incentive` decimal(10,2) NOT NULL,
  `interest` decimal(10,2) NOT NULL,
  `noncern` decimal(10,2) NOT NULL,
  `overpayrec` decimal(10,2) NOT NULL,
  `forbal` decimal(10,2) NOT NULL,
  `hospital` decimal(10,2) NOT NULL,
  `capitation` decimal(10,2) NOT NULL,
  `spm` decimal(10,2) NOT NULL,
  `pmonpos` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `ProjectID` int(11) NOT NULL,
  `ProjectName` varchar(20) NOT NULL,
  `status` int(8) NOT NULL DEFAULT '1',
  `Owner` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`ProjectID`, `ProjectName`, `status`, `Owner`) VALUES
(14, 'NAH', 1, 'RV061973'),
(20, 'CHLD_FL', 1, 'AR060673'),
(21, ' SFPP', 1, 'AR060673'),
(25, 'CHS', 1, 'RV061973'),
(27, 'LMH', 1, 'KP062277'),
(28, 'IGH', 1, 'KP062277'),
(29, 'AMA', 1, 'KP062277'),
(30, 'CDI', 1, 'KP062277'),
(31, 'LMA', 1, 'KP062277'),
(32, 'NBC-OP', 1, 'KP062277'),
(33, 'NBC- KCK', 1, 'KP062277'),
(34, 'IMC', 1, 'KP062277'),
(35, 'CCD', 1, 'KP062277'),
(36, 'Emory', 1, 'KP062277'),
(38, 'Evolution', 1, 'KP062277'),
(39, 'TEC', 1, 'KP062277'),
(40, 'Barnabas South', 1, 'AS050699'),
(41, 'Barnabas North', 1, 'AS050699'),
(42, 'Crozer', 1, 'AS050699'),
(43, 'Steward - PGAR', 1, 'AA054796'),
(44, 'Steward - PPHS', 1, 'AA054796'),
(45, 'Steward - PPAZ', 1, 'AA054796'),
(46, 'Steward - PGLA', 1, 'AA054796'),
(47, 'Steward - PGAZ', 1, 'AA054796'),
(48, 'Steward - SJMC', 1, 'AA054796'),
(49, 'Steward - RMWC', 1, 'AA054796'),
(50, 'Steward - DGFM', 1, 'AA054796'),
(51, 'Steward - PGUT', 1, 'AA054796'),
(52, 'Steward - TXAR', 1, 'AA054796'),
(53, 'Steward - HLIU', 1, 'AA054796'),
(54, 'LHS', 1, 'AR060673');

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

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `statusid` int(11) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`statusid`, `description`) VALUES
(10, 'Assigned'),
(17, 'Issues'),
(18, 'Pending'),
(33, 'Resolved'),
(34, 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `worklog`
--

CREATE TABLE `worklog` (
  `WorkID` int(11) NOT NULL,
  `CategoryID` varchar(20) NOT NULL,
  `FacilityID` int(11) NOT NULL,
  `DepositeDate` date NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `BatchNo` varchar(200) NOT NULL,
  `UploadDate` varchar(25) NOT NULL,
  `AssignedID` varchar(10) NOT NULL,
  `Comments` varchar(200) NOT NULL,
  `CPM` varchar(20) NOT NULL,
  `CPMAmt` decimal(10,2) NOT NULL,
  `StartTime` varchar(25) NOT NULL,
  `PostDate` varchar(25) NOT NULL,
  `Duration` int(11) NOT NULL,
  `TAT` int(11) NOT NULL,
  `TATVal` varchar(15) NOT NULL,
  `EncCount` int(11) NOT NULL,
  `TranCount` int(11) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `action`
--
ALTER TABLE `action`
  ADD PRIMARY KEY (`actionid`);

--
-- Indexes for table `associate`
--
ALTER TABLE `associate`
  ADD PRIMARY KEY (`AssociateID`,`AccessLevel`),
  ADD UNIQUE KEY `AssociateID` (`AssociateID`),
  ADD UNIQUE KEY `AssociateID_2` (`AssociateID`,`AccessLevel`);

--
-- Indexes for table `dailylog`
--
ALTER TABLE `dailylog`
  ADD PRIMARY KEY (`transactionbdid`),
  ADD KEY `BN` (`batchnumber`),
  ADD KEY `TT` (`transactiontype`) USING BTREE;

--
-- Indexes for table `missing`
--
ALTER TABLE `missing`
  ADD PRIMARY KEY (`missingid`),
  ADD KEY `FI` (`ProjectID`);

--
-- Indexes for table `otherpayment`
--
ALTER TABLE `otherpayment`
  ADD PRIMARY KEY (`OID`),
  ADD KEY `BN` (`Encounter`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`ProjectID`),
  ADD KEY `PS` (`status`),
  ADD KEY `PO` (`Owner`);

--
-- Indexes for table `querylog`
--
ALTER TABLE `querylog`
  ADD PRIMARY KEY (`queryid`),
  ADD KEY `FI` (`ProjectID`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`statusid`);

--
-- Indexes for table `worklog`
--
ALTER TABLE `worklog`
  ADD PRIMARY KEY (`WorkID`),
  ADD KEY `FI` (`FacilityID`),
  ADD KEY `BN` (`CPM`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `missing`
--
ALTER TABLE `missing`
  MODIFY `missingid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `otherpayment`
--
ALTER TABLE `otherpayment`
  MODIFY `OID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `ProjectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `querylog`
--
ALTER TABLE `querylog`
  MODIFY `queryid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `worklog`
--
ALTER TABLE `worklog`
  MODIFY `WorkID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
