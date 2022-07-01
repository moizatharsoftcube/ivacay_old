-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2022 at 05:05 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xpiasbzoerxk_ivaccay`
--

-- --------------------------------------------------------

--
-- Table structure for table `journies`
--

CREATE TABLE `journies` (
  `id` int(11) NOT NULL,
  `invoice_number` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `guide_id` int(11) NOT NULL COMMENT 'guider id',
  `package_id` int(11) DEFAULT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `payment_url` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '0 = Process,\r\n1 = Completed<\r\n2 = Rejected',
  `member_ship_id` int(11) DEFAULT NULL,
  `total_price` decimal(14,2) DEFAULT NULL,
  `is_paid` int(11) DEFAULT NULL COMMENT '0 = unsuccessfully payment,\r\n1 = successfully payment',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `journies`
--

INSERT INTO `journies` (`id`, `invoice_number`, `user_id`, `guide_id`, `package_id`, `payment_id`, `payment_url`, `status`, `member_ship_id`, `total_price`, `is_paid`, `created_at`, `updated_at`) VALUES
(1, NULL, 2, 1, 1, 'ch_3KjXOdFF6yglEvQF0BSZeTnt', 'https://pay.stripe.com/receipts/acct_1KEflEFF6yglEvQF/ch_3KjXOdFF6yglEvQF0BSZeTnt/rcpt_LQOAabNv2v3rHVinXPIyXfPHB6Ee1yi', NULL, NULL, '604.00', NULL, '2022-04-01 04:27:20', '2022-04-01 04:27:20'),
(2, NULL, 8, 1, 1, '604', '0x65be55f49e00b0c909f8b86f1ddd1cea3b2e02851f9a71edb66247f9b318e93b', NULL, NULL, '604.00', NULL, '2022-04-29 05:11:05', '2022-04-29 05:11:05'),
(3, NULL, 8, 1, 1, '604', '0x43f6e1765c0139d748299474a1e6ca0a209f4cb7b4f8cabf010968f1ddf4c6b6', NULL, NULL, '604.00', NULL, '2022-04-29 05:11:40', '2022-04-29 05:11:40'),
(4, NULL, 1, 1, 3, 'ch_3KxwtXFF6yglEvQF1eNOeVha', 'https://pay.stripe.com/receipts/acct_1KEflEFF6yglEvQF/ch_3KxwtXFF6yglEvQF1eNOeVha/rcpt_LfHSIAlmnWSBT1GkehcCx12jkeWaHQF', NULL, NULL, '53.00', NULL, '2022-05-10 22:30:48', '2022-05-10 22:30:48'),
(5, NULL, 3, 1, 1, 'ch_3Kyg4HFF6yglEvQF0d4MUZ0h', 'https://pay.stripe.com/receipts/acct_1KEflEFF6yglEvQF/ch_3Kyg4HFF6yglEvQF0d4MUZ0h/rcpt_Lg28BU9DyQkPYpimAQyW7ac8s3ATtCW', NULL, NULL, '604.00', NULL, '2022-05-12 22:44:54', '2022-05-12 22:44:54'),
(6, NULL, 3, 1, 1, 'ch_3LBjLIFF6yglEvQF0viXIN0R', 'https://pay.stripe.com/receipts/acct_1KEflEFF6yglEvQF/ch_3LBjLIFF6yglEvQF0viXIN0R/rcpt_LtWOz1ZugIKJTPOR4Lt79K8DwTeZMkG', NULL, NULL, '604.00', NULL, '2022-06-17 21:52:25', '2022-06-17 21:52:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `journies`
--
ALTER TABLE `journies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pakacge_id` (`package_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `journies`
--
ALTER TABLE `journies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `journies`
--
ALTER TABLE `journies`
  ADD CONSTRAINT `pakacge_id` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
