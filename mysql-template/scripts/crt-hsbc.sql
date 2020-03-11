-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 14, 2020 at 10:34 AM
-- Server version: 5.7.29-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.2

-- SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
-- SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crt-hsbc`
--

-- --------------------------------------------------------

--
-- Table structure for table `backlog`
--
-- CREATE DATABASE crt_hsbc;
-- USE crt_hsbc;
CREATE TABLE `backlog` (
  `PKID` int(10) NOT NULL,
  `CUSTOMER` varchar(50) NOT NULL,
  `TNUM` varchar(50) NOT NULL,
  `STATUS` varchar(20) NOT NULL,
  `PRIORITY` int(4) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `TOWNER` varchar(50) NOT NULL,
  `GDC` varchar(20) NOT NULL,
  `REVIEWER` varchar(20) NOT NULL,
  `REASON` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `backlog`
--

-- INSERT INTO `backlog` (`PKID`, `CUSTOMER`, `TNUM`, `STATUS`, `PRIORITY`, `CREATE_DATE`, `TOWNER`, `GDC`, `REVIEWER`, `REASON`) VALUES
-- (1, 'HSBC', '1234', 'Acknowledged', 1, '2019-01-17', 'svenkatt', 'Bangalore', 'amasarda', 'NULL');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CUSTOMER` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

-- INSERT INTO `customer` (`CUSTOMER`) VALUES
-- ('HSBC');

-- --------------------------------------------------------

--
-- Table structure for table `cust_review`
--

CREATE TABLE `cust_review` (
  `customer` varchar(45) NOT NULL,
  `it_score` float NOT NULL,
  `t_score` float NOT NULL,
  `dc_score` float NOT NULL,
  `cc_score` float NOT NULL,
  `cd_score` float NOT NULL,
  `avg` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `engineer`
--

CREATE TABLE `engineer` (
  `CEC` varchar(50) NOT NULL,
  `MANAGER` varchar(20) NOT NULL,
  `GDC` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `engineer`
--

-- INSERT INTO `engineer` (`CEC`, `MANAGER`, `GDC`) VALUES
-- ('sfarisk', 'draphel', 'Bangalore'),
-- ('gkotapal', 'draphel', 'Bangalore'),
-- ('gshravya', 'draphel', 'Bangalore'),
-- ('svenkatt', 'draphel', 'Bangalore'),
-- ('abek', 'draphel', 'Bangalore'),
-- ('lakshjai', 'draphel', 'Bangalore'),
-- ('muhismai', 'trdavid', 'Krakow'),
-- ('krisjosh', 'draphel', 'Bangalore'),
-- ('yeruvred', 'draphel', 'Bangalore'),
-- ('mdabros', 'trdavid', 'Krakow'),
-- ('niveas', 'draphel', 'Bangalore'),
-- ('mmilov', 'trdavid', 'Krakow'),
-- ('achintap', 'draphel', 'Bangalore'),
-- ('pmariyar', 'draphel', 'Bangalore'),
-- ('nihpa', 'draphel', 'Bangalore'),
-- ('kgrochal', 'trdavid', 'Krakow'),
-- ('sankerao', 'draphel', 'Bangalore'),
-- ('rimishr2', 'draphel', 'Bangalore'),
-- ('schundan', 'draphel', 'Bangalore'),
-- ('asaheer', 'draphel', 'Bangalore'),
-- ('faiskha2', 'draphel', 'Bangalore'),
-- ('suparun', 'draphel', 'Bangalore'),
-- ('kipaul', 'draphel', 'Bangalore'),
-- ('bhanaik', 'draphel', 'Bangalore'),
-- ('apetryko', 'trdavid', 'Krakow'),
-- ('sabnasee', 'draphel', 'Bangalore'),
-- ('vinjames', 'draphel', 'Bangalore'),
-- ('vasolank', 'draphel', 'Bangalore'),
-- ('aramared', 'draphel', 'Bangalore'),
-- ('viveranj', 'draphel', 'Bangalore'),
-- ('mneyvasa', 'draphel', 'Bangalore'),
-- ('pranaysi', 'draphel', 'Bangalore'),
-- ('sunkoul', 'draphel', 'Bangalore'),
-- ('souhazra', 'draphel', 'Bangalore'),
-- ('ritaroy', 'draphel', 'Bangalore'),
-- ('abvp', 'draphel', 'Bangalore'),
-- ('apadhy', 'draphel', 'Bangalore'),
-- ('asannamu', 'draphel', 'Bangalore'),
-- ('swrevann', 'draphel', 'Bangalore'),
-- ('visingh5', 'draphel', 'Bangalore'),
-- ('schemath', 'draphel', 'Bangalore'),
-- ('sichanga', 'draphel', 'Bangalore'),
-- ('majap', 'draphel', 'Bangalore'),
-- ('sshukkoo', 'draphel', 'Bangalore'),
-- ('ranmitra', 'draphel', 'Bangalore'),
-- ('prakuma9', 'draphel', 'Bangalore'),
-- ('mshafeek', 'draphel', 'Bangalore');

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE `manager` (
  `MANAGER` varchar(20) NOT NULL,
  `GDC` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manager`
--

-- INSERT INTO `manager` (`MANAGER`, `GDC`) VALUES
-- ('draphel', 'Bangalore'),
-- ('sackapoo', 'Bangalore'),
-- ('matkaufm', 'RTP'),
-- ('trdavid', 'Krakow'),
-- ('ananambi','TEST'),
-- ('amasarda', 'TEST');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `PKID` int(10) NOT NULL,
  `CUSTOMER` varchar(50) NOT NULL,
  `REVIEWER` varchar(50) NOT NULL,
  `REVIEW_DATE` date NOT NULL,
  `TNUM` bigint(20) NOT NULL,
  `STATUS` varchar(20) NOT NULL,
  `CREATE_DATE` date NOT NULL,
  `PRIORITY` int(4) NOT NULL,
  `TOWNER` varchar(50) NOT NULL,
  `GDC` varchar(50) NOT NULL,
  `IT_SCORE` int(4) NOT NULL,
  `T_SCORE` int(4) NOT NULL,
  `DC_SCORE` int(4) NOT NULL,
  `CC_SCORE` int(4) NOT NULL,
  `CD_SCORE` int(4) NOT NULL,
  `COMMENT` text NOT NULL,
  `AVG` double(5,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `review2`
--

CREATE TABLE `review2` (
  `PKID` int(10) NOT NULL,
  `SNO` int(10) NOT NULL,
  `CUSTOMER` varchar(50) DEFAULT NULL,
  `REVIEWER` varchar(50) DEFAULT NULL,
  `REVIEW_DATE` date DEFAULT NULL,
  `TNUM` varchar(50) DEFAULT NULL,
  `STATUS` varchar(50) DEFAULT NULL,
  `CREATE_DATE` date DEFAULT NULL,
  `PRIORITY` int(4) DEFAULT NULL,
  `TOWNER` varchar(50) DEFAULT NULL,
  `GDC` varchar(50) DEFAULT NULL,
  `DC1` int(5) DEFAULT NULL,
  `DC2` int(5) DEFAULT NULL,
  `DC3` int(5) DEFAULT NULL,
  `T1` int(5) DEFAULT NULL,
  `T2` int(5) DEFAULT NULL,
  `T3` int(5) DEFAULT NULL,
  `T4` int(5) DEFAULT NULL,
  `CC1` int(5) DEFAULT NULL,
  `CC2` int(5) DEFAULT NULL,
  `CC3` int(5) DEFAULT NULL,
  `CC4` int(5) DEFAULT NULL,
  `EVE1` int(5) DEFAULT NULL,
  `EVE2` int(5) DEFAULT NULL,
  `EVE3` int(5) DEFAULT NULL,
  `EVE4` int(5) DEFAULT NULL,
  `CD1` int(5) DEFAULT NULL,
  `CD2` int(5) DEFAULT NULL,
  `CD3` int(5) DEFAULT NULL,
  `CD4` int(5) DEFAULT NULL,
  `COMMENTS` text,
  `DCRS` int(5) DEFAULT '20',
  `DCPS` int(5) DEFAULT NULL,
  `TRS` int(5) DEFAULT '20',
  `TPS` int(5) DEFAULT NULL,
  `CCRS` int(5) DEFAULT '25',
  `CCPS` int(5) DEFAULT NULL,
  `EVERS` int(5) DEFAULT '10',
  `EVEPS` int(5) DEFAULT NULL,
  `CDRS` int(5) DEFAULT '25',
  `CDPS` int(5) DEFAULT NULL,
  `FRS` int(5) DEFAULT '100',
  `FPS` int(5) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `review2`
--

--
-- Table structure for table `reviewers`
--

CREATE TABLE `reviewers` (
  `CEC` varchar(50) NOT NULL,
  `GDC` varchar(50) NOT NULL,
  `ID` int(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reviewers`
--

-- INSERT INTO `reviewers` (`CEC`, `GDC`, `ID`) VALUES
-- ('aramared', 'Bangalore', 5),
-- ('visingh5', 'Bangalore', 1),
-- ('sabnasee', 'Bangalore', 2),
-- ('pranaysi', 'Bangalore', 6),
-- ('shandatt', 'Bangalore', 3),
-- ('prns', 'Krakow', 4),
-- ('madziedz', 'Krakow', 7),
-- ('sackapoo', 'Bangalore', 8),
-- ('akrawczy', 'RTP', 9),
-- ('lubezerr', 'Krakow', 10),
-- ('vasolank', 'Bangalore', 11),
-- ('rahukapo', 'RTP', 12),
-- ('liquinte', 'Krakow', 13);

-- --------------------------------------------------------

--
-- Table structure for table `reviewers2`
--

CREATE TABLE `reviewers2` (
  `CEC` varchar(20) NOT NULL,
  `GDC` varchar(20) NOT NULL,
  `ID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `backlog`
--
ALTER TABLE `backlog`
  ADD PRIMARY KEY (`PKID`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`PKID`);

--
-- Indexes for table `review2`
--
ALTER TABLE `review2`
  ADD PRIMARY KEY (`SNO`);

--
-- Indexes for table `reviewers`
--
ALTER TABLE `reviewers`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `reviewers2`
--
ALTER TABLE `reviewers2`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `review2`
--
ALTER TABLE `review2`
  MODIFY `SNO` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=608;
--
-- AUTO_INCREMENT for table `reviewers`
--
ALTER TABLE `reviewers`
  MODIFY `ID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `reviewers2`
--
ALTER TABLE `reviewers2`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
