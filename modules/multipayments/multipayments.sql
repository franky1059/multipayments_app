-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Mar 18, 2015 at 10:03 PM
-- Server version: 5.5.38
-- PHP Version: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `multipayments`
--

-- --------------------------------------------------------

--
-- Table structure for table `mp_code`
--

CREATE TABLE `mp_code` (
`id` int(11) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mp_code`
--

INSERT INTO `mp_code` (`id`, `slug`, `name`, `description`) VALUES
(1, 'STATUS_ACTIVE', 'Active Status', 'Active Status'),
(2, 'STATUS_NOT_ACTIVE', 'Not Active Status', 'Not Active Status'),
(3, 'STATUS_REFUNDED', 'Refunded Payment', 'Refunded Payment'),
(4, 'API_HOOK_REFUND', 'Refund Web Hook', 'Refund Web Hook'),
(5, 'STATUS_ACTIVE_HIDDEN', 'Active Status Hidden', 'Active Status Hidden'),
(6, 'STATUS_DELETED', 'Deleted Status', 'Deleted Status');

-- --------------------------------------------------------

--
-- Table structure for table `mp_option`
--

CREATE TABLE `mp_option` (
`id` int(11) NOT NULL,
  `status_id` int(11) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `charge_description` varchar(255) DEFAULT NULL,
  `billing_interval` int(11) DEFAULT NULL,
  `expire_method` varchar(255) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `suffix` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `is_unlimitted` tinyint(1) DEFAULT '0',
  `is_gift` tinyint(1) DEFAULT '0',
  `order_value` int(11) DEFAULT NULL,
  `display` tinyint(4) DEFAULT NULL,
  `raw_data` text,
  `createdby` int(11) DEFAULT NULL,
  `modifiedby` int(11) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `modifydate` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mp_payment`
--

CREATE TABLE `mp_payment` (
`id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `record_id` int(11) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `processdate` datetime DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `modifiedby` int(11) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `modifydate` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1618 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mp_payment_item`
--

CREATE TABLE `mp_payment_item` (
`id` int(11) NOT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `product_option_id` varchar(255) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `modifiedby` int(11) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `modifydate` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mp_product`
--

CREATE TABLE `mp_product` (
`id` int(11) NOT NULL,
  `status_id` int(11) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `charge_description` varchar(255) DEFAULT NULL,
  `billing_interval` int(11) DEFAULT NULL,
  `expire_method` varchar(255) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `suffix` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `is_unlimitted` tinyint(1) DEFAULT '0',
  `is_gift` tinyint(1) DEFAULT '0',
  `order_value` int(11) DEFAULT NULL,
  `display` tinyint(4) DEFAULT NULL,
  `raw_data` text,
  `createdby` int(11) DEFAULT NULL,
  `modifiedby` int(11) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `modifydate` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mp_product_option`
--

CREATE TABLE `mp_product_option` (
`id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `option_id` varchar(255) DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `modifiedby` int(11) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `modifydate` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mp_code`
--
ALTER TABLE `mp_code`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mp_option`
--
ALTER TABLE `mp_option`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mp_payment`
--
ALTER TABLE `mp_payment`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mp_payment_item`
--
ALTER TABLE `mp_payment_item`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mp_product`
--
ALTER TABLE `mp_product`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mp_product_option`
--
ALTER TABLE `mp_product_option`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mp_code`
--
ALTER TABLE `mp_code`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `mp_option`
--
ALTER TABLE `mp_option`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `mp_payment`
--
ALTER TABLE `mp_payment`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1618;
--
-- AUTO_INCREMENT for table `mp_payment_item`
--
ALTER TABLE `mp_payment_item`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=70;
--
-- AUTO_INCREMENT for table `mp_product`
--
ALTER TABLE `mp_product`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `mp_product_option`
--
ALTER TABLE `mp_product_option`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=70;