-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2024 at 01:30 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `emb_appform`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `item_code` varchar(50) NOT NULL,
  `company` varchar(50) NOT NULL,
  `sticker_no` varchar(50) NOT NULL,
  `item_location` varchar(50) NOT NULL,
  `price` varchar(20) NOT NULL,
  `item_description` varchar(100) NOT NULL,
  `ref_no` varchar(20) NOT NULL,
  `serial_no` varchar(50) NOT NULL,
  `date_purchased` varchar(50) NOT NULL,
  `supplier` varchar(50) NOT NULL,
  `last_repaired` varchar(50) NOT NULL,
  `disposed` varchar(20) NOT NULL DEFAULT 'false',
  `date_dispose` varchar(50) NOT NULL,
  `last_sticker` varchar(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `est_life_mon` int(11) DEFAULT NULL,
  `est_life_year` int(11) DEFAULT NULL,
  `acq_cost` double DEFAULT NULL,
  `acc_depr` double DEFAULT NULL,
  `ffe_depr` double DEFAULT NULL,
  `book_value` double DEFAULT NULL,
  `branch_name` varchar(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `item_code`, `company`, `sticker_no`, `item_location`, `price`, `item_description`, `ref_no`, `serial_no`, `date_purchased`, `supplier`, `last_repaired`, `disposed`, `date_dispose`, `last_sticker`, `date`, `est_life_mon`, `est_life_year`, `acq_cost`, `acc_depr`, `ffe_depr`, `book_value`, `branch_name`, `type`, `status`) VALUES
(23, 'IC00001', 'EMB', '10', 'MAIN BRANCH', '5000', 'TECHNO SPARK GO-2024 (Mobile phone)', '', 'XBH5071088', '2024-08-08', 'MF Computer Solutions', '', 'false', '', '10', '2024-08-19 00:21:41', 3, 1, NULL, 34, NULL, NULL, 'EMB MAIN BRANCH ', '', ''),
(24, 'IC00024', 'EMB', '11', 'MAIN BRANCH', '1500', 'UPS', 'JV#242', 'XDFADW', '2024-08-08', 'MF Computer Solutions', '', 'false', '', '11', '2024-08-19 00:21:44', 2, NULL, 100, 200, NULL, 1, 'EMB MAIN BRANCH ', '', ''),
(26, 'IC00026', 'FCH', '1', 'BACOLOD', '1000', 'MONITOR', 'jhjhh', 'XBH5071088', '2024-08-10', 'MF Computer Solutions', '', 'false', '', '1', '2024-08-20 01:34:29', 1, 3, 20, 20, 80, NULL, 'EMB MAIN BRANCH ', '', ''),
(27, 'IC00027', 'RLC', '1', 'SING CANG', '200', 'LX1101', 'ghg', 'XBWEASDD', '2024-08-12', 'MF Computer Solutions', '', 'false', '', '1', '2024-08-19 00:57:50', NULL, NULL, NULL, 20, 20, 2, 'EMB MAIN BRANCH ', '', ''),
(28, 'IC00024', 'EMB', '13', 'MAIN BRANCH', '100', 'erwerws', 'JV#123', 'XDFADWER', '2024-08-08', 'MF Computer Solutions', '', 'false', '', '', '2024-08-19 00:43:08', NULL, NULL, NULL, 45.2, NULL, NULL, 'EMB MAIN BRANCH ', '', ''),
(29, 'IC00030', 'MAIN BRANCH', '40', 'MAIN BRANCH', '13,200.00', 'Steel Benches', 'dasd', 'XDFADWERad', '2024-08-20', '', '', 'false', '', '', '2024-08-16 06:12:17', NULL, NULL, NULL, NULL, NULL, NULL, 'EMB MAIN BRANCH ', '', ''),
(30, 'IC00030', 'MAIN BRANCH', '41', 'MAIN BRANCH', '13,200.00', 'Steel Benches', '', 'XDFADWERad', '2024-08-20', '', '', 'false', '', '', '2024-08-19 00:21:51', NULL, NULL, NULL, NULL, NULL, NULL, 'EMB MAIN BRANCH ', '', ''),
(31, 'IC00030', 'MAIN BRANCH', '42', 'MAIN BRANCH', '13,200.00', 'Steel Benches', '', 'XDFADWERad', '2024-08-20', '', '', 'false', '', '', '2024-08-19 00:21:53', NULL, NULL, NULL, NULL, NULL, NULL, 'EMB MAIN BRANCH ', '', ''),
(32, 'IC00031', 'MAIN BRANCH', '43', 'MAIN BRANCH', '13,200.00', 'philips LCD monitoe', '', 'XDFADWERadERE', '2024-08-22', '', '', '', '', '', '2024-08-19 00:21:54', NULL, NULL, NULL, 100, NULL, NULL, 'EMB MAIN BRANCH ', '', ''),
(33, 'IC00032', 'MAIN BRANCH', '44', 'MAIN BRANCH', '13,200.00', 'A4tech Black Keyboards', '', 'XDFADWERadERE', '2024-08-22', '', '', 'false', '', '', '2024-08-19 00:26:56', NULL, 3, NULL, 434, NULL, NULL, 'EMB MAIN BRANCH ', '', ''),
(34, 'IC00033', 'MAIN BRANCH', '45', 'MAIN BRANCH', '13,200.00', 'Back-up UPS blacks', '', 'XDFADWERadERE', '2024-08-22', '', '', 'false', '', '', '2024-08-20 03:30:41', 1, 2, NULL, 200, NULL, NULL, 'EMB MAIN BRANCH ', '', ''),
(65, 'IC00035', '', '22', '', '', 'PC monitor', 'JV#12232', '', '2024-08-20', '', '', 'false', '', '', '2024-08-20 07:45:53', 3, 3, 2000, 1000, 200, 2, 'EMB MAIN BRANCH', 'Non-Accesories', 'Working'),
(66, 'IC00036', '', '23', '', '', 'PC monitor', 'JV#12232', '', '2024-08-20', '', '', 'false', '', '', '2024-08-20 07:45:53', 3, 3, 2000, 1000, 200, 2, 'EMB MAIN BRANCH', 'Non-Accesories', 'Working'),
(67, 'IC00037', '', '24', '', '', 'PC monitor', 'JV#12232', '', '2024-08-20', '', '', 'false', '', '', '2024-08-20 07:45:53', 3, 3, 2000, 1000, 200, 2, 'EMB MAIN BRANCH', 'Non-Accesories', 'Working'),
(68, 'IC00068', '', '0022', '', '', 'PC Mouse', 'JV#122234', '', '2024-08-20', '', '', 'false', '', '', '2024-08-20 07:48:52', 2, 1, 100, 100, 100, 1, 'EMB MAIN BRANCH', 'Accessories', 'Working'),
(69, 'IC00069', '', '0023', '', '', 'PC Mouse', 'JV#122234', '', '2024-08-20', '', '', 'false', '', '', '2024-08-20 07:48:52', 2, 1, 100, 100, 100, 1, 'EMB MAIN BRANCH', 'Accessories', 'Working'),
(70, 'IC00070', '', '0024', '', '', 'PC Mouse', 'JV#122234', '', '2024-08-20', '', '', 'false', '', '', '2024-08-20 07:48:52', 2, 1, 100, 100, 100, 1, 'EMB MAIN BRANCH', 'Accessories', 'Working'),
(71, 'IC00071', '', '0025', '', '', 'PC Mouse', 'JV#122234', '', '2024-08-20', '', '', 'false', '', '', '2024-08-20 07:48:52', 2, 1, 100, 100, 100, 1, 'EMB MAIN BRANCH', 'Accessories', 'Working'),
(72, 'IC00072', '', '0026', '', '', 'PC Mouse', 'JV#122234', '', '2024-08-20', '', '', 'false', '', '', '2024-08-20 07:48:52', 2, 1, 100, 100, 100, 1, 'EMB MAIN BRANCH', 'Accessories', 'Working');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
