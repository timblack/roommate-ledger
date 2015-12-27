-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 27, 2015 at 03:21 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ledger`
--
CREATE DATABASE IF NOT EXISTS `ledger` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ledger`;

-- --------------------------------------------------------

--
-- Table structure for table `costings`
--

DROP TABLE IF EXISTS `costings`;
CREATE TABLE IF NOT EXISTS `costings` (
`id` int(11) NOT NULL,
  `housemate_id` int(11) NOT NULL,
  `lkey` int(11) NOT NULL,
  `value` float NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `costings`
--

INSERT INTO `costings` (`id`, `housemate_id`, `lkey`, `value`) VALUES
(1, 3, 100, 500),
(2, 5, 101, 150),
(3, 4, 101, 120),
(4, 2, 101, 110),
(5, 1, 101, 130),
(6, 3, 102, 300),
(7, 3, 103, 23.3),
(8, 1, 104, 12.5),
(9, 3, 104, 12.5),
(10, 4, 104, 12.5),
(11, 5, 104, 12.5),
(12, 1, 105, 130),
(13, 2, 105, 95),
(14, 4, 105, 130),
(15, 5, 105, 120),
(16, 1, 105, 130),
(17, 4, 105, 120),
(18, 5, 105, 150),
(19, 2, 105, 110),
(20, 1, 106, 11.95),
(21, 5, 106, 13),
(22, 3, 106, 11.95),
(23, 1, 106, 11.95);

-- --------------------------------------------------------

--
-- Table structure for table `housemates`
--

DROP TABLE IF EXISTS `housemates`;
CREATE TABLE IF NOT EXISTS `housemates` (
`housemate_id` int(11) NOT NULL,
  `housemate_name` varchar(255) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `housemates`
--

INSERT INTO `housemates` (`housemate_id`, `housemate_name`, `id`) VALUES
(1, 'Heidi', 0),
(2, 'Charlotte', 0),
(3, 'Joseph', 0),
(4, 'Derek', 0),
(5, 'Joel', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ledger`
--

DROP TABLE IF EXISTS `ledger`;
CREATE TABLE IF NOT EXISTS `ledger` (
`lkey` int(11) NOT NULL,
  `date` date NOT NULL,
  `description` varchar(255) NOT NULL,
  `paidby` int(11) NOT NULL,
  `notes` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ledger`
--

INSERT INTO `ledger` (`lkey`, `date`, `description`, `paidby`, `notes`) VALUES
(100, '2015-10-01', 'Money Transfer', 2, ''),
(101, '2015-09-29', 'Rent', 3, ''),
(102, '2015-09-28', 'Money Transfer', 4, ''),
(103, '2015-09-28', 'Groceries', 4, ''),
(104, '2015-09-26', 'Pizza', 3, ''),
(105, '2015-09-22', 'Rent', 3, ''),
(106, '2015-09-15', 'Burgers', 4, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `costings`
--
ALTER TABLE `costings`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `housemates`
--
ALTER TABLE `housemates`
 ADD PRIMARY KEY (`housemate_id`);

--
-- Indexes for table `ledger`
--
ALTER TABLE `ledger`
 ADD PRIMARY KEY (`lkey`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `costings`
--
ALTER TABLE `costings`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `housemates`
--
ALTER TABLE `housemates`
MODIFY `housemate_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `ledger`
--
ALTER TABLE `ledger`
MODIFY `lkey` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
