-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 12, 2013 at 07:32 PM
-- Server version: 5.1.40
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `exivex`
--

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE IF NOT EXISTS `data` (
  `users` int(11) NOT NULL DEFAULT '0',
  `vklad` varchar(1) NOT NULL DEFAULT '0',
  `popolnenie` varchar(1) NOT NULL DEFAULT '0',
  `vyvod` varchar(1) NOT NULL DEFAULT '0',
  `premod_r` varchar(1) NOT NULL,
  `count_r` varchar(6) NOT NULL,
  `plus` decimal(10,2) NOT NULL DEFAULT '0.00',
  `with` decimal(10,2) NOT NULL DEFAULT '0.00',
  `plus_n` varchar(20000) NOT NULL,
  `with_n` varchar(20000) NOT NULL,
  `new_u` varchar(20000) NOT NULL,
  PRIMARY KEY (`users`),
  KEY `users` (`users`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`users`, `vklad`, `popolnenie`, `vyvod`, `premod_r`, `count_r`, `plus`, `with`, `plus_n`, `with_n`, `new_u`) VALUES
(0, '0', '0', '0', '', '', 0.00, 0.00, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `online`
--

CREATE TABLE IF NOT EXISTS `online` (
  `hid` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL,
  `last_time` int(10) NOT NULL,
  PRIMARY KEY (`hid`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `online`
--

INSERT INTO `online` (`hid`, `ip`, `last_time`) VALUES
(1, '127001', 1360684309);

-- --------------------------------------------------------

--
-- Table structure for table `operations`
--

CREATE TABLE IF NOT EXISTS `operations` (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `ologin` varchar(20) NOT NULL,
  `otype` tinyint(4) NOT NULL,
  `osum` decimal(10,2) NOT NULL DEFAULT '0.00',
  `osum2` decimal(10,2) NOT NULL DEFAULT '0.00',
  `odate` varchar(10) NOT NULL,
  `odate2` varchar(10) NOT NULL,
  `oplan` varchar(1) NOT NULL,
  `oref` varchar(20) NOT NULL,
  `orefsum` decimal(10,2) DEFAULT NULL,
  `obatch` varchar(50) NOT NULL,
  `oback` varchar(1) NOT NULL,
  `oproc` varchar(10) NOT NULL,
  `odays` varchar(4) NOT NULL DEFAULT '0',
  `oprofit` decimal(10,2) NOT NULL,
  `orefproc` varchar(3) NOT NULL,
  PRIMARY KEY (`oid`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `operations`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) DEFAULT NULL,
  `qiwi` varchar(32) NOT NULL,
  `ref` varchar(20) NOT NULL,
  `date` varchar(10) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `users`
--

