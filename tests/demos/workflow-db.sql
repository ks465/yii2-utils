-- These are data for testing workflow module which has database manager
-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 17, 2019 at 05:12 PM
-- Server version: 10.1.34-MariaDB-0ubuntu0.18.04.1
-- PHP Version: 7.2.10-0ubuntu0.18.04.1

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `test`
--

--
-- Truncate table before insert `sw_metadata`
--

TRUNCATE TABLE `sw_metadata`;
--
-- Dumping data for table `sw_metadata`
--

INSERT INTO `sw_metadata` (`workflow_id`, `status_id`, `key`, `value`) VALUES
('TestWF', 'one', 'stage', '1'),
('TestWF', 'three', 'stage', '2'),
('TestWF', 'two', 'stage', '2');

--
-- Truncate table before insert `sw_status`
--

TRUNCATE TABLE `sw_status`;
--
-- Dumping data for table `sw_status`
--

INSERT INTO `sw_status` (`id`, `workflow_id`, `label`, `sort_order`) VALUES
('five', 'TestWF', 'Fifth Status', 5),
('four', 'TestWF', 'Fourth Status', 4),
('one', 'TestWF', 'First Status of First Workflow', 1),
('three', 'TestWF', 'Third Status of Workflow One', 3),
('two', 'TestWF', 'Second Status of Workflow One', 2);

--
-- Truncate table before insert `sw_transition`
--

TRUNCATE TABLE `sw_transition`;
--
-- Dumping data for table `sw_transition`
--

INSERT INTO `sw_transition` (`workflow_id`, `start_status_id`, `end_status_id`) VALUES
('TestWF', 'one', 'two'),
('TestWF', 'three', 'one'),
('TestWF', 'two', 'one'),
('TestWF', 'two', 'three');

--
-- Truncate table before insert `sw_workflow`
--

TRUNCATE TABLE `sw_workflow`;
--
-- Dumping data for table `sw_workflow`
--

INSERT INTO `sw_workflow` (`id`, `initial_status_id`) VALUES
('TestWF', 'one');
SET FOREIGN_KEY_CHECKS=1;
