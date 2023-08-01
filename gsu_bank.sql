-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2023 at 05:01 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gsu_bank`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_information`
--

CREATE TABLE `account_information` (
  `username` varchar(50) NOT NULL,
  `balance` varchar(50) NOT NULL,
  `account_holder` varchar(100) NOT NULL,
  `account_type` varchar(50) NOT NULL,
  `mailing_address` varchar(200) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `routing_number` varchar(50) NOT NULL,
  `account_number` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account_information`
--

INSERT INTO `account_information` (`username`, `balance`, `account_holder`, `account_type`, `mailing_address`, `phone_number`, `email_address`, `routing_number`, `account_number`) VALUES
('gsu1', '70', 'Account Holder Name', 'Savings', '1234 Street, City, State, Zip', '1234567890', 'email@example.com', '', ''),
('gsu2', '50', 'John Doe', 'Savings', '123 ABC Street, City, State, ZIP', '123-456-7890', 'email@example.com', '', ''),
('gsu3', '200', 'John Doe', 'Savings', '123 Buford Dr, Buford, GA, 30033', '123-456-7890', 'gsu@gmail.com', '', ''),
('janeDoe456', '25000', 'Jane Doe', 'Checking', '456 Elm St, Anytown, NY 12345', '555-555-5556', 'jane.doe@example.com', '', ''),
('johnDoe123', '5000', 'John Doe', 'Savings', '123 Main St, Anytown, NY 12345', '555-555-5555', 'john.doe@example.com', '', ''),
('user1', '10067', 'User ABC', 'Savings', '789 Oak St, Anytown, NY 12345', '555-555-5557', 'user.abc@example.com', '', ''),
('user2', '17200', 'User XYZ', 'Checking', '321 Pine St, Anytown, NY 12345', '555-555-5558', 'user.xyz@example.com', '', ''),
('userABC', '10000', 'User ABC', 'Savings', '789 Oak St, Anytown, NY 12345', '555-555-5557', 'user.abc@example.com', '', ''),
('userXYZ', '15000', 'User XYZ', 'Checking', '321 Pine St, Anytown, NY 12345', '555-555-5558', 'user.xyz@example.com', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `username` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `date` date NOT NULL,
  `transaction_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`username`, `amount`, `description`, `date`, `transaction_time`) VALUES
('johnDoe123', '200.00', 'Grocery shopping', '2023-07-31', '10:00:00'),
('janeDoe456', '1000.00', 'Rent payment', '2023-07-31', '15:00:00'),
('user1', '300.00', 'withdrawal', '2023-08-01', '19:00:00'),
('user1', '500.00', 'Deposit', '2023-08-01', '16:30:00'),
('user1', '300.00', 'withdrawal', '2023-08-01', '19:00:00'),
('user1', '500.00', 'Deposit', '2023-08-01', '16:30:00'),
('user2', '600.00', 'withdrawal', '2023-08-01', '19:00:00'),
('user2', '900.00', 'Deposit', '2023-08-01', '16:30:00'),
('user1', '30.00', 'withdrawal', '2023-07-31', '09:00:00'),
('user1', '50.00', 'Deposit', '2023-07-31', '06:30:00'),
('user1', '1000.00', 'deposit', '2023-08-01', '00:08:43'),
('user1', '600.00', 'withdrawal', '2023-08-01', '00:22:33'),
('user1', '100.00', 'deposit', '2023-08-01', '00:26:56'),
('user1', '400.00', 'deposit', '2023-08-01', '00:32:33'),
('user1', '500.00', 'withdrawal', '2023-08-01', '00:33:21'),
('user1', '500.00', 'deposit', '2023-08-01', '00:33:31'),
('user1', '400.00', 'deposit', '2023-08-01', '00:40:27'),
('user1', '200.00', 'deposit', '2023-08-01', '00:48:03'),
('user1', '500.00', 'deposit', '2023-08-01', '00:48:30'),
('user1', '600.00', 'deposit', '2023-08-01', '01:03:25'),
('user1', '700.00', 'withdrawal', '2023-08-01', '01:03:40'),
('user1', '0.00', 'deposit', '2023-08-01', '01:04:00'),
('user1', '0.00', 'deposit', '2023-08-01', '01:04:26'),
('user1', '123.00', 'deposit', '2023-08-01', '01:28:35'),
('user1', '456.00', 'deposit', '2023-07-31', '19:36:18'),
('user1', '456.00', 'withdrawal', '2023-08-01', '01:36:46'),
('user1', '456.00', 'withdrawal', '2023-07-31', '19:37:18'),
('user1', '300.00', 'transfer', '2023-07-31', '19:50:41'),
('gsu1', '10.00', 'deposit', '2023-07-31', '22:17:21'),
('gsu1', '50.00', 'deposit', '2023-07-31', '22:18:07'),
('gsu2', '50.00', 'deposit', '2023-07-31', '22:34:11'),
('gsu3', '20.00', 'withdrawal', '2023-07-31', '22:38:11'),
('gsu3', '20.00', 'deposit', '2023-07-31', '22:38:24'),
('gsu3', '1000.00', 'deposit', '2023-07-31', '22:38:34'),
('gsu3', '500.00', 'transfer', '2023-07-31', '22:43:13'),
('gsu3', '200.00', 'deposit', '2023-07-31', '22:58:08'),
('gsu3', '300.00', 'withdrawal', '2023-07-31', '22:58:13'),
('gsu3', '200.00', 'transfer', '2023-07-31', '22:58:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `email`) VALUES
('user1', '123', 'user1@gmail.com'),
('user2', '456', 'user2@gmail.com'),
('user3', '789', 'user3@gmail.com'),
('user4', '4444', 'user4@gmail.com'),
('user5', '5555', 'user5@gmail.com'),
('user6', '666', 'user6@gmail.com'),
('user7', '777', 'user7@gmail.com'),
('user9', '999', 'user9@gmail.com'),
('gsu1', 'abc', 'gsu1@gmail.com'),
('gsu2', 'def', 'gsu2@gmail.com'),
('gsu3', 'zzz', 'gsu3@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_information`
--
ALTER TABLE `account_information`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD KEY `username` (`username`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`username`) REFERENCES `account_information` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
