-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2023 at 05:11 PM
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
-- Database: `washmandu_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_id`, `username`, `admin_email`, `password`) VALUES
(1, 'admin', 'admin@gmail.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`customer_id`, `first_name`, `last_name`, `email`, `password`, `gender`, `phone`, `address`) VALUES
(1, 'bishesh', 'shrestha', 'bisheshshrestha652@gmail.com', 'bishesh1234', 'male', '9860106998', 'newroad'),
(8, 'Sushmita', 'Shrestha', 'sushmalakar10@gmail.com', 'sushmita1234', 'female', '9818085057', 'Putalisadak,Kathmandu'),
(10, 'Bishesh Lal', 'Shrestha', 'bisheshshrestha531@gmail.com', 'bishesh', 'Male', '9860106998', 'Putalisadak,Kathmandu');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_items`
--

CREATE TABLE `tbl_items` (
  `item_id` int(11) NOT NULL,
  `item_type` varchar(255) NOT NULL,
  `item_image` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `unit` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_items`
--

INSERT INTO `tbl_items` (`item_id`, `item_type`, `item_image`, `price`, `unit`) VALUES
(1, 'Tshirt', 'images/price_1.jpg', 100, 'kg'),
(2, 'Pant', 'images/price_3.jpg', 150, 'kg'),
(3, 'Coat', 'images/coat.jpg', 200, 'pcs'),
(4, 'Blanket', 'images/Untitled design (1).png', 250, 'pcs');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orders`
--

CREATE TABLE `tbl_orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `laundry_type` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `created_time` time NOT NULL,
  `pickup_date` date NOT NULL,
  `delivery_date` date NOT NULL,
  `location` varchar(255) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_orders`
--

INSERT INTO `tbl_orders` (`order_id`, `customer_id`, `laundry_type`, `quantity`, `price`, `order_date`, `created_time`, `pickup_date`, `delivery_date`, `location`, `status`) VALUES
(1, 1, 1, 1, 100, '2023-07-06', '00:00:00', '2023-07-06', '2023-07-08', 'newroad', 'Pending'),
(2, 10, 3, 2, 400, '2023-07-24', '08:16:57', '2023-07-24', '2023-07-26', 'Putalisadak,Kathmandu', 'Delivered'),
(3, 10, 4, 2, 500, '2023-07-24', '08:16:57', '2023-07-24', '2023-07-26', 'Putalisadak,Kathmandu', 'Delivered'),
(4, 10, 2, 2, 300, '2023-07-24', '08:48:35', '2023-07-24', '2023-07-26', 'Putalisadak,Kathmandu', 'Pending'),
(5, 10, 1, 2, 200, '2023-07-24', '08:48:35', '2023-07-24', '2023-07-26', 'Putalisadak,Kathmandu', 'Pending'),
(6, 1, 2, 1, 150, '2023-08-18', '07:58:30', '2023-08-18', '2023-08-20', 'newroad', 'Pending'),
(7, 1, 4, 2, 500, '2023-08-18', '07:58:30', '2023-08-18', '2023-08-20', 'newroad', 'Pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `tbl_items`
--
ALTER TABLE `tbl_items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `laundry_type` (`laundry_type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_items`
--
ALTER TABLE `tbl_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD CONSTRAINT `tbl_orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `tbl_customer` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_orders_ibfk_2` FOREIGN KEY (`laundry_type`) REFERENCES `tbl_items` (`item_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
