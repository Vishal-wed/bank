-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2024 at 05:43 PM
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
-- Database: `bank`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_details`
--

CREATE TABLE `account_details` (
  `account_id` int(11) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `account_number` varchar(20) NOT NULL,
  `account_type` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `pin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account_details`
--

INSERT INTO `account_details` (`account_id`, `bank_name`, `account_number`, `account_type`, `age`, `pin`) VALUES
(1, 'NNP Bank', '9261 7935 2396 7769', 'salary account', 18, 9705),
(2, 'NNP Bank', '9268 5294 8895 1569', 'salary account', 18, 9705);

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `account_id` int(11) NOT NULL,
  `paymant_status` varchar(255) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp(),
  `amount` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`account_id`, `paymant_status`, `desc`, `time`, `amount`) VALUES
(1, 'Credited', 'Added Money', '2024-05-02 16:07:17', 800),
(1, 'Debited', 'Withdrawal Money', '2024-05-02 16:18:28', 1000),
(1, 'Debited', 'Money Sended to daku', '2024-05-02 19:19:40', 100),
(2, 'Credited', 'Money Sended by vishal', '2024-05-02 19:19:46', 100),
(2, 'Credited', 'Added Money', '2024-05-02 19:24:14', 100),
(2, 'Debited', 'Withdrawal Money', '2024-05-02 19:25:22', 500),
(2, 'Debited', 'Money Sended to vishal', '2024-05-02 19:26:05', 100),
(1, 'Credited', 'Money Sended by daku', '2024-05-02 19:26:12', 100),
(1, 'Credited', 'Added Money', '2024-05-04 18:58:06', 1000),
(1, 'Debited', 'Withdrawal Money', '2024-05-04 18:58:56', 1000),
(1, 'Debited', 'Withdrawal Money', '2024-05-04 18:59:13', 100),
(1, 'Debited', 'Withdrawal Money', '2024-05-05 17:55:42', 900),
(1, 'Credited', 'Added Money', '2024-05-05 17:56:48', 1000),
(1, 'Credited', 'Added Money', '2024-05-05 19:23:12', 2394),
(1, 'Debited', 'Purchase Debit card', '2024-05-05 19:31:04', 399),
(2, 'Debited', 'Purchase Debit card', '2024-05-12 09:32:24', 399),
(2, 'Credited', 'Added Money', '2024-05-16 18:27:12', 9999),
(2, 'Debited', 'Withdrawal Money', '2024-05-16 18:46:15', 200),
(1, 'Credited', 'Money Sended by daku', '2024-05-16 18:52:02', 100000),
(1, 'Credited', 'Money Sended by daku', '2024-05-16 18:52:36', 100000),
(2, 'Debited', 'Money Sended to vishal', '2024-05-16 19:01:12', 100),
(1, 'Credited', 'Money Sended by daku', '2024-05-16 19:01:17', 100),
(2, 'Debited', 'Money Sended to vishal', '2024-05-16 19:05:29', 100),
(1, 'Credited', 'Money Sended by daku', '2024-05-16 19:05:35', 100),
(2, 'Debited', 'Money Sended to vishal', '2024-05-16 19:06:06', 100),
(1, 'Credited', 'Money Sended by daku', '2024-05-16 19:06:12', 100),
(2, 'Debited', 'Purchase Debit card', '2024-05-16 19:13:47', 399),
(2, 'Debited', 'Purchase Debit card', '2024-05-16 19:14:48', 399),
(2, 'Debited', 'Purchase Debit card', '2024-05-16 19:20:57', 399),
(2, 'Credited', 'Added Money', '2024-05-16 19:22:08', 39891094),
(2, 'Credited', 'Added Money', '2024-05-16 19:22:31', 1004),
(2, 'Debited', 'Purchase Debit card', '2024-05-16 19:27:01', 399),
(2, 'Debited', 'Purchase Debit card', '2024-05-16 19:27:23', 399),
(2, 'Debited', 'Withdrawal Money', '2024-05-16 19:28:04', 2),
(2, 'Debited', 'Withdrawal Money', '2024-05-16 19:31:37', 100),
(2, 'Debited', 'Withdrawal Money', '2024-05-16 19:33:22', 100),
(1, 'Debited', 'Withdrawal Money', '2024-05-18 13:23:52', 1900),
(1, 'Debited', 'Withdrawal Money', '2024-05-18 13:26:14', 100),
(1, 'Debited', 'Withdrawal Money', '2024-05-18 13:27:53', 100),
(1, 'Debited', 'Withdrawal Money', '2024-05-18 13:53:27', 800),
(1, 'Debited', 'Withdrawal Money', '2024-05-18 13:53:58', 800),
(1, 'Debited', 'Withdrawal Money', '2024-05-18 13:54:44', 200),
(1, 'Credited', 'Added Money', '2024-05-18 13:55:23', 2000),
(1, 'Credited', 'Added Money', '2024-05-18 13:58:10', 1000),
(1, 'Debited', 'Money Sended to daku', '2024-05-18 13:59:57', 11000),
(2, 'Credited', 'Money Sended by vishal', '2024-05-18 14:00:03', 11000);

-- --------------------------------------------------------

--
-- Table structure for table `money_bank`
--

CREATE TABLE `money_bank` (
  `account_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `amount` bigint(20) NOT NULL,
  `debit_card` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `money_bank`
--

INSERT INTO `money_bank` (`account_id`, `username`, `user_password`, `amount`, `debit_card`) VALUES
(1, 'vishal', '$2y$10$wol/rD21.9oyx/EgG6GCae8EbvLzP7LEdo3xzbOfTiD.9M1PLdlbW', 190000, 1),
(2, 'daku', '$2y$10$B1WzsA22krF/TdwAtYD81uHIdebseDSbypete7HyloIaa/Q.DyRHC', 11000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `persnol`
--

CREATE TABLE `persnol` (
  `account_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mobile_number` bigint(10) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `persnol`
--

INSERT INTO `persnol` (`account_id`, `name`, `mobile_number`, `email`) VALUES
(1, 'nakum vishal dhrmeshbhai', 7228918826, 'vishal7228918826@gmail.com'),
(2, 'daku', 8485949422, 'vishal7228918826@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_details`
--
ALTER TABLE `account_details`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `money_bank`
--
ALTER TABLE `money_bank`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `persnol`
--
ALTER TABLE `persnol`
  ADD PRIMARY KEY (`account_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_details`
--
ALTER TABLE `account_details`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `money_bank`
--
ALTER TABLE `money_bank`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `persnol`
--
ALTER TABLE `persnol`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
