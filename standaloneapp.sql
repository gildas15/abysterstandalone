-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 28, 2019 at 10:09 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `standaloneapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `abaccount`
--

CREATE TABLE `abaccount` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cosumer_secret` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `registration_date` date NOT NULL,
  `activation_date` date NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `balance` int(11) NOT NULL,
  `social_reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `abaccount`
--

INSERT INTO `abaccount` (`id`, `user_id`, `email`, `cosumer_secret`, `status`, `registration_date`, `activation_date`, `address`, `phone_number`, `balance`, `social_reason`) VALUES
(1, 1, 'mbagildas15@gmail.com', '914dd36c5f90a0154ec0695c41f4a314', 'Active', '2016-05-18', '2016-05-18', 'Bonduma', '651360985', 29200, 'Good'),
(2, 2, 'silidje@gmail.com', '91a1039651b96b75e39879b19fefb03c', 'Selectionner votre status', '2025-05-18', '2025-05-18', 'Bonduma', '651360985', 400, 'Good');

-- --------------------------------------------------------

--
-- Table structure for table `passerelle`
--

CREATE TABLE `passerelle` (
  `id` int(11) NOT NULL,
  `msisdn` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `regular_expression` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_creation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type_transaction` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `passerelle`
--

INSERT INTO `passerelle` (`id`, `msisdn`, `country_code`, `state`, `regular_expression`, `name`, `date_creation`, `type_transaction`) VALUES
(1, '00237651360985', '00237', 'Active', '(^6[7]\\d{7}$|^6[5][01234]\\d{6}$|^6[8]\\d{7}$)', 'Mba Sob', '16-05-18', 'TRANSFERT_MOBILE_MONEY');

-- --------------------------------------------------------

--
-- Table structure for table `transactiondetails`
--

CREATE TABLE `transactiondetails` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `operation_date` date NOT NULL,
  `payement_method` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total_amount_received` double NOT NULL,
  `transaction_state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `msisdn_sender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `msisdn_receiver` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `currency` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transactiondetails`
--

INSERT INTO `transactiondetails` (`id`, `transaction_id`, `operation_date`, `payement_method`, `total_amount_received`, `transaction_state`, `msisdn_sender`, `msisdn_receiver`, `currency`, `country_code`) VALUES
(147, 54, '2018-06-06', 'MTN money', 0, 'PENDING', '675072636', '00237651360985', 'FCFA', '00237'),
(148, 54, '2018-06-06', 'MTN money', 200, 'INCOMPLETE', '675072636', '00237651360985', 'FCFA', '00237'),
(149, 55, '2018-06-07', 'Orange money', 0, 'PENDING', '677256665', '00237651360985', 'FCFA', '00237'),
(150, 55, '2018-06-07', 'Orange money', 200, 'INCOMPLETE', '677256665', '00237651360985', 'FCFA', '00237'),
(151, 55, '2018-06-07', 'Orange money', 400, 'INCOMPLETE', '677256665', '00237651360985', 'FCFA', '00237'),
(156, 60, '2018-06-18', 'Orange money', 0, 'PENDING', '675072636', '00237651360985', 'FCFA', '00237'),
(157, 60, '2018-06-18', 'Orange money', 200, 'INCOMPLETE', '675072636', '00237651360985', 'FCFA', '00237'),
(158, 60, '2018-06-18', 'Orange money', 400, 'INCOMPLETE', '675072636', '00237651360985', 'FCFA', '00237'),
(165, 63, '2018-06-20', 'Orange money', 0, 'PENDING', '675072636', '00237651360985', 'FCFA', '00237'),
(166, 63, '2018-06-20', 'Orange money', 200, 'INCOMPLETE', '675072636', '00237651360985', 'FCFA', '00237'),
(167, 63, '2018-06-20', 'Orange money', 400, 'INCOMPLETE', '675072636', '00237651360985', 'FCFA', '00237'),
(168, 63, '2018-06-20', 'Orange money', 600, 'INCOMPLETE', '675072636', '00237651360985', 'FCFA', '00237'),
(169, 63, '2018-06-20', 'Orange money', 800, 'INCOMPLETE', '675072636', '00237651360985', 'FCFA', '00237'),
(170, 63, '2018-06-20', 'Orange money', 1000, 'DONE', '675072636', '00237651360985', 'FCFA', '00237'),
(175, 66, '2018-06-20', 'Orange money', 0, 'PENDING', '675072636', '00237651360985', 'FCFA', '00237'),
(176, 66, '2018-06-20', 'Orange money', 200, 'INCOMPLETE', '675072636', '00237651360985', 'FCFA', '00237'),
(177, 66, '2018-06-20', 'Orange money', 400, 'INCOMPLETE', '675072636', '00237651360985', 'FCFA', '00237'),
(178, 66, '2018-06-20', 'Orange money', 600, 'INCOMPLETE', '675072636', '00237651360985', 'FCFA', '00237'),
(179, 66, '2018-06-20', 'Orange money', 800, 'INCOMPLETE', '675072636', '00237651360985', 'FCFA', '00237'),
(180, 66, '2018-06-20', 'Orange money', 1000, 'DONE', '675072636', '00237651360985', 'FCFA', '00237'),
(222, 76, '2018-06-21', 'Orange money', 0, 'PENDING', '651360985', '00237651360985', 'FCFA', '00237'),
(223, 76, '2018-06-21', 'Orange money', 200, 'INCOMPLETE', '651360985', '00237651360985', 'FCFA', '00237'),
(224, 76, '2018-06-21', 'Orange money', 400, 'INCOMPLETE', '651360985', '00237651360985', 'FCFA', '00237'),
(257, 109, '2018-06-25', 'Transfert_Mobile_Money', 0, 'PENDING', '651360985', '00237651360985', 'FCFA', '00237'),
(258, 110, '2018-06-29', 'Transfert_Mobile_Money', 0, 'PENDING', '651360985', '00237651360985', 'FCFA', '00237');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `passerelle_id` int(11) DEFAULT NULL,
  `abaccount_id` int(11) DEFAULT NULL,
  `email_sender` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_recipient` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `msisdn_sender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `msisdn_recipient` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_transfert` date DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `redirect_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_sms` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fees` double DEFAULT NULL,
  `date_reception_sms` date DEFAULT NULL,
  `amount_ttc` double NOT NULL,
  `type_operation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `currency` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total_amount_received` double NOT NULL,
  `delta_amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `passerelle_id`, `abaccount_id`, `email_sender`, `customer_name`, `email_recipient`, `msisdn_sender`, `country_code`, `msisdn_recipient`, `date_transfert`, `description`, `order_id`, `redirect_url`, `id_sms`, `fees`, `date_reception_sms`, `amount_ttc`, `type_operation`, `currency`, `state`, `total_amount_received`, `delta_amount`) VALUES
(54, 1, 1, 'salomonJahel@gmail.com', 'Mba Sob Gildas', 'mbagildas15@gmail.com', '675072636', '00237', '00237651360985', '2018-06-06', NULL, 'UTF45', 'http://localhost/standaloneapp/web/app_dev.php', NULL, 200, '2018-06-06', 1000, 'MTN money', 'FCFA', 'DONE', 400, 600),
(55, 1, 1, 'mbagildas15@gmail.com', 'Mba Sob Gildas', 'mbagildas15@gmail.com', '677256665', '00237', '00237651360985', '2018-06-07', NULL, 'UTF5', 'www.cuib-cameroon.org', NULL, 200, '2018-06-07', 1000, 'Orange money', 'FCFA', 'INCOMPLETE', 400, 600),
(60, 1, 1, 'mbagildas15@gmail.com', 'Mba Sob Gildas', 'mbagildas15@gmail.com', '675072636', '00237', '00237651360985', '2018-06-18', NULL, 'UTF5', 'www.cuib-cameroon.org', NULL, 200, '2018-06-18', 1000, 'Orange money', 'FCFA', 'INCOMPLETE', 400, 600),
(62, 1, 1, 'mbagildas15@gmail.com', 'Mba Sob Gildas', 'mbagildas15@gmail.com', '675072636', '00237', '00237651360985', '2018-06-20', NULL, 'UTF5', 'www.cuib-cameroon.org', NULL, 200, '2018-06-20', 1000, 'Orange money', 'FCFA', 'INCOMPLETE', 800, 200),
(63, 1, 1, 'mbagildas15@gmail.com', 'Mba Sob Gildas', 'mbagildas15@gmail.com', '675072636', '00237', '00237651360985', '2018-06-20', NULL, 'UTF5', 'www.cuib-cameroon.org', NULL, 200, '2018-06-20', 1000, 'Orange money', 'FCFA', 'DONE', 1000, 0),
(66, 1, 1, 'mbagildas15@gmail.com', 'Mba Sob Gildas', 'mbagildas15@gmail.com', '675072636', '00237', '00237651360985', '2018-06-20', NULL, 'UTF5', 'www.cuib-cameroon.org', NULL, 200, '2018-06-20', 1000, 'Orange money', 'FCFA', 'DONE', 1000, 0),
(76, 1, 1, 'mbagildas15@gmail.com', 'Mba Sob Gildas', 'mbagildas15@gmail.com', '651360985', '00237', '00237651360985', '2018-06-21', NULL, 'UTF5', 'www.cuib-cameroon.org', NULL, 200, '2018-06-21', 1000, 'Orange money', 'FCFA', 'INCOMPLETE', 400, 600),
(109, 1, 1, 'mbagildas15@gmail.com', 'Mba Sob Gildas', 'mbagildas15@gmail.com', '651360985', '00237', '00237651360985', NULL, NULL, 'UTFV5', 'localhost/standaloneapp/web/app_dev.php', NULL, NULL, NULL, 1000, 'Transfert_Mobile_Money', 'FCFA', 'PENDING', 0, 0),
(110, 1, 1, 'mbagildas15@gmail.com', 'Mba Sob Gildas', 'mbagildas15@gmail.com', '651360985', '00237', '00237651360985', NULL, NULL, 'UTFV5', 'localhost/standaloneapp/web/app_dev.php', NULL, NULL, NULL, 1000, 'Transfert_Mobile_Money', 'FCFA', 'PENDING', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`) VALUES
(1, 'Mba Gildas', 'mba gildas', 'mbagildas15@gmail.com', 'mbagildas15@gmail.com', 1, NULL, '$2y$13$VZu3O4QqDxK55te9w.RXyeFfV9h4bCvixA42uSNWxpOvFan47.89e', '2019-01-26 10:19:12', NULL, NULL, 'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}'),
(2, 'Silidje Brice', 'silidje brice', 'silidje@gmail.com', 'silidje@gmail.com', 1, NULL, '$2y$13$/uZxAJfPY37FSs9xrY8M0OLa1m9eHbgUntE8NDcYsxSgb3V4rcWXW', '2018-05-25 17:24:35', NULL, NULL, 'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abaccount`
--
ALTER TABLE `abaccount`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DF85AF55A76ED395` (`user_id`);

--
-- Indexes for table `passerelle`
--
ALTER TABLE `passerelle`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8C578E53D8AB44` (`msisdn`);

--
-- Indexes for table `transactiondetails`
--
ALTER TABLE `transactiondetails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactionId_index` (`transaction_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `passerelle_abaccount_index` (`passerelle_id`,`abaccount_id`),
  ADD KEY `abaccount_id` (`abaccount_id`),
  ADD KEY `IDX_EAA81A4CEBCA6F32` (`passerelle_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D64992FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_8D93D649A0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `UNIQ_8D93D649C05FB297` (`confirmation_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abaccount`
--
ALTER TABLE `abaccount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `passerelle`
--
ALTER TABLE `passerelle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transactiondetails`
--
ALTER TABLE `transactiondetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=259;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `abaccount`
--
ALTER TABLE `abaccount`
  ADD CONSTRAINT `FK_DF85AF55A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `transactiondetails`
--
ALTER TABLE `transactiondetails`
  ADD CONSTRAINT `FK_FD689E492FC0CB0F` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `FK_EAA81A4CB87BFE3D` FOREIGN KEY (`abaccount_id`) REFERENCES `abaccount` (`id`),
  ADD CONSTRAINT `FK_EAA81A4CEBCA6F32` FOREIGN KEY (`passerelle_id`) REFERENCES `passerelle` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
