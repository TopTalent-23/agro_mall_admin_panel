-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2023 at 04:29 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `img_upload`
--

CREATE TABLE `img_upload` (
  `id` int(100) NOT NULL,
  `img_name` longblob NOT NULL,
  `sellid` int(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `Id` int(20) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  `phone_no` bigint(12) NOT NULL,
  `address` text NOT NULL,
  `password` varchar(250) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`Id`, `name`, `email`, `phone_no`, `address`, `password`, `datetime`) VALUES
(48, 'zaheer', 'zaheer@gmail.com', 9075819645, 'malegao', 'zaheer', '2023-04-11 19:35:56'),
(50, 'bhavesh', 'bhavesh@gmail.com', 9075635464, 'malegao', 'bhavesg', '2023-04-12 12:05:04'),
(53, 'shahezad', 'g@g.com', 756678687, 'dsfdfsv', 'sdf', '2023-04-12 12:29:16'),
(54, 'shahezad', 'h@h.com', 54564564, 'bwdv', '1234', '2023-04-12 12:35:14'),
(55, 'dss', 'djhds@gmail.com', 8475678586, 'malegao', '123', '2023-04-12 12:38:51'),
(61, 'vvgv', 'n@n.com', 6785656767, 'hvhv', 'uio', '2023-04-12 12:45:46'),
(62, 'hjkjhk', 'jhkj@gmail.com', 56757567, 'ujgh', '123', '2023-04-12 13:17:58'),
(64, 'vvgv', 'q@n.com', 6785656767, 'hvhv', '123', '2023-04-12 13:27:03'),
(66, 'vvgv', 'w@n.com', 6785656767, 'hvhv', '123', '2023-04-12 13:31:23'),
(68, 'vvgv', 'w@t.com', 6785656767, 'hvhv', '123', '2023-04-12 13:33:02'),
(70, 'vvgv', 'w@q.com', 6785656767, 'hvhv', '1', '2023-04-12 13:33:36'),
(72, 'vvgv', 'w@s.com', 6785656767, 'hvhv', '1', '2023-04-12 13:34:22'),
(74, 'vvgv', 'w@r.com', 6785656767, 'hvhv', '1', '2023-04-12 13:35:21'),
(76, 'vvgv', 'w@y.com', 6785656767, 'hvhv', '1', '2023-04-12 13:36:31'),
(78, 'vvgv', 'w@u.com', 6785656767, 'hvhv', '1', '2023-04-12 13:37:10'),
(81, 'vvgv', 'w@m.com', 6785656767, 'hvhv', '5', '2023-04-12 13:42:13'),
(83, 'vvgv', 'w@v.com', 6785656767, 'hvhv', 'g', '2023-04-12 13:47:07'),
(84, 'vvgv', 'wff@v.com', 6785656767, 'hvhv', '123', '2023-04-12 13:47:33'),
(85, 'ghj', 'a@b.com', 6756567, 'nmnm', '7', '2023-04-12 13:51:11'),
(86, 'jh', 'b@b.com', 23453454, 'vbfgh', '5', '2023-04-12 13:52:55'),
(88, 'jh', 'b@c.com', 23453454, 'vbfgh', '3', '2023-04-12 13:54:19'),
(89, 'sha', 'jsd@gmail.com', 874535, 'hsjd', '123', '2023-04-12 13:55:27'),
(92, 'sha', 'jso@gmail.com', 874535, 'hsjd', 'i', '2023-04-12 13:59:32'),
(93, 'aman', 'aman123@gmail.com', 9075819645, 'malegao', 'khan', '2023-04-13 11:40:00'),
(94, 'aman', 'aman1dd23@gmail.com', 9075819645, 'malegao', '123', '2023-04-13 11:58:06'),
(95, 'noman', 'noman@gmail.com', 9585858585858, 'malegao', '123', '2023-04-13 11:59:30'),
(96, 'BHAVA', 'BHAVA@GMAIL.COM', 9057465645, 'MALEGAO', 'BHAVA', '2023-04-15 09:18:15'),
(97, 'faisal', 'faisal@gmail.com', 9075819645, 'malegao', 'faisal', '2023-04-24 18:46:36'),
(98, 'faisal', 'faisal@gamil.com', 9075819645, 'malegao', 'faisal', '2023-04-24 18:48:49'),
(99, 'mustaqueem khan', 'mustaqueem@gmail.com', 9075819645, 'malegao ', 'khan', '2023-05-06 20:38:01');

-- --------------------------------------------------------

--
-- Table structure for table `sell`
--

CREATE TABLE `sell` (
  `id` int(250) NOT NULL,
  `bed_available` int(10) NOT NULL,
  `bed_price` int(10) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `pin` int(10) NOT NULL,
  `mno` bigint(11) NOT NULL,
  `payid` varchar(50) NOT NULL,
  `amount` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `sellid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sell`
--

INSERT INTO `sell` (`id`, `bed_available`, `bed_price`, `Address`, `pin`, `mno`, `payid`, `amount`, `date`, `sellid`) VALUES
(1, 4, 1000, 'haji ahmed pura ', 423203, 9075819645, 'pay_LmPp4BrOjTvRzm', 100, '2023-05-07 10:03:25', 1),
(2, 3, 1000, 'bilquis masjid', 423203, 9075819645, 'pay_LmdgDLeToW49Ne', 100, '2023-05-07 10:03:25', 0),
(3, 3, 2000, 'hazar kholi', 423203, 9075819645, 'pay_LmdiTksYng6ie8', 100, '2023-05-07 10:03:25', 48),
(4, 5, 2222, 'hazar kholi', 423203, 9075819645, 'pay_LmdtWwLWlo7SMu', 100, '2023-05-07 10:04:13', 48);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `img_upload`
--
ALTER TABLE `img_upload`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `sell`
--
ALTER TABLE `sell`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `img_upload`
--
ALTER TABLE `img_upload`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `Id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `sell`
--
ALTER TABLE `sell`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
