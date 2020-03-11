-- SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
-- SET time_zone = "+00:00";

-- Table structure for table `cases`
CREATE TABLE `cases` (
  `PKID` int(11) NOT NULL,
  `CASE_NUM` varchar(200) NOT NULL,
  `QM_CEC` varchar(15) NOT NULL,
  `ENG_CEC` varchar(15) NOT NULL,
  `CUSTOMER` text NOT NULL,
  `ACCEPT` int(1) DEFAULT NULL,
  `DT_SUBMIT` datetime DEFAULT NULL,
  `DT_ACCEPT` datetime DEFAULT NULL,
  `DIFF_MIN` int(20) DEFAULT NULL,
  `SHIFT` varchar(2) DEFAULT NULL,
  `TYPE` varchar(20) DEFAULT NULL,
  `STATE` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;


--
-- Table structure for table `cecempid`
--

CREATE TABLE `cecempid` (
  `empid` text NOT NULL,
  `cec` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cecempid`
--

-- INSERT INTO `cecempid` (`empid`, `cec`) VALUES
-- ('37534', 'ihasund'),
-- ('448272', 'sunkoul'),
-- ('442951', 'pranaysi');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CUSTOMER` varchar(20) NOT NULL,
  `ALERTS` varchar(300) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `customer`
--

-- INSERT INTO `customer` (`CUSTOMER`, `ALERTS`) VALUES
-- ('HSBC', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `c_eng`
--

CREATE TABLE `c_eng` (
  `CEC` varchar(20) NOT NULL,
  `GDC` varchar(20) NOT NULL,
  `DAYS` int(11) NOT NULL,
  `REJECTED` int(8) NOT NULL,
  `EA_COUNT` int(5) NOT NULL,
  `P3P4_COUNT` int(5) NOT NULL,
  `P1P2_COUNT` int(5) NOT NULL,
  `S1_TIME` int(10) NOT NULL,
  `S2_TIME` int(10) NOT NULL,
  `S3_TIME` int(10) NOT NULL,
  `NOTICE_COUNT` int(5) NOT NULL,
  `DISPATCH` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `c_eng`
--

-- INSERT INTO `c_eng` (`CEC`, `GDC`, `DAYS`, `REJECTED`, `EA_COUNT`, `P3P4_COUNT`, `P1P2_COUNT`, `S1_TIME`, `S2_TIME`, `S3_TIME`, `NOTICE_COUNT`, `DISPATCH`) VALUES
-- ('achengal', 'Bangalore', 534, 4, 1790, 2248, 45, 239356, 324, 27422, 0, 3),
-- ('schemath', 'Bangalore', 515, 17, 1838, 2254, 31, 234937, 290, 25528, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `dispatch`
--

CREATE TABLE `dispatch` (
  `PKID` int(5) UNSIGNED NOT NULL,
  `CASE_NUM` text NOT NULL,
  `ENG_CEC` varchar(15) NOT NULL,
  `CUSTOMER` text NOT NULL,
  `DT_SUBMIT` datetime DEFAULT NULL,
  `SHIFT` varchar(2) DEFAULT NULL,
  `DT_DISPATCH` datetime DEFAULT NULL,
  `TYPE` varchar(50) DEFAULT NULL,
  `ASSIGNED` int(5) UNSIGNED ZEROFILL NOT NULL DEFAULT '00000'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `engineer`
--

CREATE TABLE `engineer` (
  `DATES` date DEFAULT NULL,
  `SEQ` int(5) NOT NULL,
  `CEC` varchar(20) NOT NULL,
  `STATE` varchar(20) NOT NULL DEFAULT 'Available',
  `EA` int(3) NOT NULL,
  `P1P2` int(3) NOT NULL,
  `P3P4` int(3) NOT NULL,
  `REASON` text NOT NULL,
  `Time_Added` datetime DEFAULT NULL,
  `SHIFT` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `engineer`
--

-- INSERT INTO `engineer` (`DATES`, `SEQ`, `CEC`, `STATE`, `EA`, `P1P2`, `P3P4`, `REASON`, `Time_Added`, `SHIFT`) VALUES
-- ('2020-02-14', 1, 'souhazra', 'Available', 3, 0, 3, '', '2020-02-14 08:17:30', 'A'),
-- ('2020-02-14', 2, 'rajuppal', 'Unavailable', 3, 0, 2, '', '2020-02-14 08:15:18', 'A'),
-- ('2020-02-14', 3, 'rimishr2', 'Unavailable', 3, 0, 2, '', '2020-02-14 08:15:18', 'A'),
-- ('2020-02-14', 4, 'ritaroy', 'Unavailable', 4, 0, 2, '', '2020-02-14 08:15:18', 'A'),
-- ('2020-02-14', 5, 'mpalleri', 'Available', 2, 0, 0, '', '2020-02-14 08:46:10', 'A'),
-- ('2020-02-14', 6, 'sunkoul', 'Unavailable', 4, 0, 2, '', '2020-02-14 08:15:18', 'A'),
-- ('2020-02-14', 7, 'sankerao', 'Unavailable', 4, 0, 2, '', '2020-02-14 08:15:18', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `finesse`
--

CREATE TABLE `finesse` (
  `CEC` varchar(50) NOT NULL,
  `DAYS` int(11) DEFAULT NULL,
  `T_READY` int(11) DEFAULT NULL,
  `T_NOTREADY` int(11) DEFAULT NULL,
  `T_TALKING` int(11) DEFAULT NULL,
  `CNA` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `finesse`
--

-- INSERT INTO `finesse` (`CEC`, `DAYS`, `T_READY`, `T_NOTREADY`, `T_TALKING`, `CNA`) VALUES
-- ('amasarda', 15, 302, 20, 60, 0);

-- --------------------------------------------------------

--
-- Table structure for table `handoff`
--

CREATE TABLE `handoff` (
  `PKID` varchar(100) NOT NULL,
  `CASE_NUM` varchar(100) NOT NULL,
  `CUSTOMER` varchar(100) NOT NULL,
  `CUR_ENG` varchar(100) NOT NULL,
  `TYPE` varchar(100) NOT NULL,
  `PRIORITY` varchar(100) NOT NULL,
  `CUR_SHIFT` varchar(100) NOT NULL,
  `NEXT_SHIFT` varchar(100) NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `REASON` text NOT NULL,
  `DEVICE` text NOT NULL,
  `DT_SUBMIT` datetime NOT NULL,
  `DT_DIS` datetime NOT NULL,
  `SUMMARY` text NOT NULL,
  `PREVIOUS` text NOT NULL,
  `ACTION` text NOT NULL,
  `NEXT_STEP` text NOT NULL,
  `NEXT_ENG` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `handoff`
--

-- INSERT INTO `handoff` (`PKID`, `CASE_NUM`, `CUSTOMER`, `CUR_ENG`, `TYPE`, `PRIORITY`, `CUR_SHIFT`, `NEXT_SHIFT`, `DESCRIPTION`, `REASON`, `DEVICE`, `DT_SUBMIT`, `DT_DIS`, `SUMMARY`, `PREVIOUS`, `ACTION`, `NEXT_STEP`, `NEXT_ENG`) VALUES
-- ('0', 'INsample', 'HSBC', 'svenkatt', 'COLD', 'P4', 'APAC', 'RTP', 'sample', 'sample', 'Sample', '2018-02-12 18:12:46', '2018-02-12 18:12:47', 'smple', '', 'sample', 'sample', 'sapme'),
-- ('1', 'sjhfj', 'HSBC', 'svenkatt', 'Cold', 'Manual P3/P4', 'D', 'B', 'fkdshfkj', 'kjdshf', 'skdfh', '2018-02-12 18:19:34', '2018-02-12 14:02:00', 'dkjfhkj', '', 'skjdhf', 'kjdh', '');

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE `manager` (
  `CEC` varchar(20) NOT NULL,
  `GDC` varchar(20) NOT NULL,
  `DAYS` int(11) NOT NULL,
  `REJECTED` int(8) NOT NULL,
  `EA_COUNT` int(5) NOT NULL,
  `P3P4_COUNT` int(5) NOT NULL,
  `P1P2_COUNT` int(5) NOT NULL,
  `S1_TIME` int(10) NOT NULL,
  `S2_TIME` int(10) NOT NULL,
  `S3_TIME` int(10) NOT NULL,
  `NOTICE_COUNT` int(5) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `manager`
--

-- INSERT INTO `manager` (`CEC`, `GDC`, `DAYS`, `REJECTED`, `EA_COUNT`, `P3P4_COUNT`, `P1P2_COUNT`, `S1_TIME`, `S2_TIME`, `S3_TIME`, `NOTICE_COUNT`) VALUES
-- ('prns', 'Krakow', 0, 0, 0, 0, 0, 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notice`
--

CREATE TABLE `notice` (
  `PKID` int(4) UNSIGNED ZEROFILL NOT NULL,
  `QM_CEC` text,
  `MESSAGE` text,
  `MESSAGE_READ` text,
  `DATE_ADDED` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='messages from timothy and oggy to the engineers' ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `optimizes`
--

CREATE TABLE `optimizes` (
  `PKID` int(11) NOT NULL,
  `CASE_NUM` varchar(200) NOT NULL,
  `QM_CEC` varchar(15) NOT NULL,
  `ENG_CEC` varchar(15) DEFAULT NULL,
  `CUSTOMER` text NOT NULL,
  `ACCEPT` int(1) DEFAULT '0',
  `DT_SUBMIT` datetime NOT NULL,
  `DT_ACCEPT` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `op_eng`
--

CREATE TABLE `op_eng` (
  `CEC` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `reject`
--

CREATE TABLE `reject` (
  `PKID` int(5) NOT NULL,
  `CUSTOMER` varchar(25) NOT NULL,
  `CASE_NAME` varchar(200) NOT NULL,
  `QM_CEC` varchar(20) NOT NULL,
  `ENG_CEC` varchar(20) NOT NULL,
  `DATE_REJECT` datetime NOT NULL,
  `SHIFT` varchar(2) NOT NULL,
  `TYPE` varchar(20) NOT NULL,
  `REASON` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `reject`
--

-- INSERT INTO `reject` (`PKID`, `CUSTOMER`, `CASE_NAME`, `QM_CEC`, `ENG_CEC`, `DATE_REJECT`, `SHIFT`, `TYPE`, `REASON`) VALUES
-- (140649, 'HSBC', '1067217', 'harsbhat', 'muhismai', '2020-01-23 13:25:39', 'A', 'Auto', 'PTO'),
-- (145184, 'HSBC', 'IN49342192', 'asaheer', 'penikolo', '2020-02-01 00:52:43', 'B', 'Manual P3/P4', 'Not familiar wit NICE'),
-- (148237, 'HSBC', '862898', 'apadhy', 'brfinega', '2020-02-13 02:55:03', '', 'Manual P3/P4', 'I was assigned CMSP 862896 not 862898');

-- --------------------------------------------------------

--
-- Table structure for table `shift`
--

CREATE TABLE `shift` (
  `SHIFT` varchar(2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `shift`
--

INSERT INTO `shift` (`SHIFT`) VALUES
('A');

-- --------------------------------------------------------

--
-- Table structure for table `t_eng`
--

CREATE TABLE `t_eng` (
  `DATES` date NOT NULL,
  `SHIFT` varchar(3) NOT NULL,
  `CEC` varchar(22) NOT NULL,
  `S1_TIME` int(10) NOT NULL,
  `S2_TIME` int(10) NOT NULL,
  `S3_TIME` int(10) NOT NULL,
  `EA_COUNT` int(5) NOT NULL,
  `P1P2_COUNT` int(5) NOT NULL,
  `P3P4_COUNT` int(5) NOT NULL,
  `REJECTED` int(5) NOT NULL,
  `DISPATCH` int(5) NOT NULL,
  `NOTICE` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `t_eng`
--

-- INSERT INTO `t_eng` (`DATES`, `SHIFT`, `CEC`, `S1_TIME`, `S2_TIME`, `S3_TIME`, `EA_COUNT`, `P1P2_COUNT`, `P3P4_COUNT`, `REJECTED`, `DISPATCH`, `NOTICE`) VALUES
-- ('2017-07-10', 'B', 'tdominic', 0, 0, 0, 0, 0, 0, 0, 0, 0),
-- ('2017-07-11', 'A', 'anthakar', 50593, 0, 0, 2, 1, 2, 0, 0, 0);

--
-- Indexes for table `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`PKID`);

--
-- Indexes for table `c_eng`
--
ALTER TABLE `c_eng`
  ADD PRIMARY KEY (`CEC`);

--
-- Indexes for table `dispatch`
--
ALTER TABLE `dispatch`
  ADD PRIMARY KEY (`PKID`);

--
-- Indexes for table `engineer`
--
ALTER TABLE `engineer`
  ADD PRIMARY KEY (`SEQ`);

--
-- Indexes for table `finesse`
--
ALTER TABLE `finesse`
  ADD PRIMARY KEY (`CEC`);

--
-- Indexes for table `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`CEC`);

--
-- Indexes for table `notice`
--
ALTER TABLE `notice`
  ADD PRIMARY KEY (`PKID`);

--
-- Indexes for table `optimizes`
--
ALTER TABLE `optimizes`
  ADD PRIMARY KEY (`PKID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dispatch`
--
ALTER TABLE `dispatch`
  MODIFY `PKID` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `notice`
--
ALTER TABLE `notice`
  MODIFY `PKID` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `optimizes`
--
ALTER TABLE `optimizes`
  MODIFY `PKID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;