-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2023 at 06:57 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tek_helpdesk`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Firstname` varchar(255) NOT NULL,
  `Lastname` varchar(255) NOT NULL,
  `Job_Title` varchar(255) NOT NULL,
  `Dept` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `user_status` varchar(255) DEFAULT 'Active',
  `user_type` enum('Administrator','Technician','End User') NOT NULL DEFAULT 'Administrator'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ID`, `Username`, `Firstname`, `Lastname`, `Job_Title`, `Dept`, `Email`, `Password`, `reset_token`, `user_status`, `user_type`) VALUES
(200, 'Hanniel', 'Joseph', 'Banda', 'Software Engineer', 'Information Technology', 'handaliels@gmail.com', '$2y$10$LKr8P9LkgSF62MlLFJDUlu8jYSurHGRsJUnSAiSu5eSSI5Ve7lgke', '366568', 'Active', 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `knowledge_base`
--

CREATE TABLE `knowledge_base` (
  `ID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` varchar(1000) NOT NULL,
  `Date_Created` timestamp NOT NULL DEFAULT current_timestamp(),
  `Date_Updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Created_By` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `knowledge_base`
--

INSERT INTO `knowledge_base` (`ID`, `Title`, `Description`, `Date_Created`, `Date_Updated`, `Created_By`) VALUES
(1, 'failure to connect to the internet', '1.) Disconnect and reconnect the internet cable(ethernet).\r\n2.) Restart the Network devices\r\n3.) If problem persists create a ticket', '2023-06-11 03:34:31', '2023-06-11 03:34:31', 200);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `ticket_id`, `category`, `body`, `created_at`) VALUES
(0, 17, 'Software', 'New ticket created', '2023-06-24 16:45:51'),
(0, 18, 'Hardware', 'New ticket created', '2023-06-24 21:13:04');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `ID` int(11) NOT NULL,
  `TicketID` int(11) NOT NULL,
  `TechnicianID` int(11) NOT NULL,
  `ReportDate` datetime NOT NULL,
  `ProblemDescription` text NOT NULL,
  `Resolution` varchar(1000) DEFAULT NULL,
  `Recommendations` text DEFAULT NULL,
  `Outcome` enum('Resolved','Pending','Unresolved') DEFAULT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`ID`, `TicketID`, `TechnicianID`, `ReportDate`, `ProblemDescription`, `Resolution`, `Recommendations`, `Outcome`, `Timestamp`) VALUES
(4, 7, 101, '2023-06-12 02:47:23', 'The user had a problem with an accounting application which was crashing due to software incompatibility.', 'Usage of another platform. App was meant for solaris operating system', 'Investing in cross platforms systems or applications could assist users in a great way, this can also prove to be beneficial to the organization at large.', 'Resolved', '2023-06-12 00:47:23'),
(5, 15, 101, '2023-06-17 06:50:50', 'User faced a problem with a burining computer which had to be replaced', 'Power supply was damaged. The only possible solution to the problem is replacement', 'Frequently computer maintenance could help avoid problems in the future which could be similar', 'Resolved', '2023-06-17 04:50:50');

-- --------------------------------------------------------

--
-- Table structure for table `technician`
--

CREATE TABLE `technician` (
  `ID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Firstname` varchar(255) NOT NULL,
  `Lastname` varchar(255) NOT NULL,
  `Job_Title` varchar(255) NOT NULL,
  `Dept` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `service_type` enum('Hardware','Software','Networks') NOT NULL DEFAULT 'Hardware',
  `reset_token` varchar(255) DEFAULT NULL,
  `user_status` varchar(255) DEFAULT 'Active',
  `user_type` enum('Administrator','Technician','End User') NOT NULL DEFAULT 'Technician'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `technician`
--

INSERT INTO `technician` (`ID`, `Username`, `Firstname`, `Lastname`, `Job_Title`, `Dept`, `Email`, `Password`, `service_type`, `reset_token`, `user_status`, `user_type`) VALUES
(101, 'Joel', 'Joel', 'Bhune', 'IT Technician', 'Information Technology', 'joeL@gmail.com', '$2y$10$HIlgtQiU8/6dU4QPCWaSMubWZJofi2sNOsWnxPZtlV0aQHPHRkI2m', 'Hardware', '812380', 'Active', 'Technician'),
(114, 'Mwiza', 'Mwiza', 'Niza', 'Quality Analyst', 'Operations', 'mwiza@gmail.com', '$2y$10$nMBH6652h0Sq2PYMtzKp3OQBjxL20E1hIODzaB81Q7q4gAxNpu1qK', 'Hardware', '384026', 'Active', 'Technician'),
(115, 'Joshua', 'Joshua', 'Mwinemushi', 'IT Technician', 'Information Technology', 'joshua@joshua.com', '$2y$10$soMB4n1hVOvd/3TiPZhnKesYl41ym/nGsVQ1fiLNdJ8TbFu7iJxdK', 'Software', '526793', 'Active', 'Technician');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` varchar(1000) NOT NULL,
  `Priority` enum('Low','Medium','High') NOT NULL,
  `Status` enum('Open','In Progress','Resolved','Closed') NOT NULL DEFAULT 'Open',
  `Resolution` varchar(1000) DEFAULT NULL,
  `Date_Created` datetime NOT NULL DEFAULT current_timestamp(),
  `Date_Updated` datetime NOT NULL DEFAULT current_timestamp(),
  `Assigned_To` int(11) DEFAULT NULL,
  `Submitted_By` int(11) DEFAULT NULL,
  `Department` varchar(255) NOT NULL,
  `Category` varchar(255) NOT NULL,
  `Feedback` varchar(1000) DEFAULT NULL,
  `Feedback_Date` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ID`, `Title`, `Description`, `Priority`, `Status`, `Resolution`, `Date_Created`, `Date_Updated`, `Assigned_To`, `Submitted_By`, `Department`, `Category`, `Feedback`, `Feedback_Date`) VALUES
(7, 'Screen', 'Kindly help me with my accounting application, its not working on my computer. everytime I try to open it, a crash takes place.', 'Medium', 'Closed', 'The problem with the accounting application crashing is due to incompatibility. It was not designed for windows operating systems.', '2023-06-11 16:17:22', '2023-06-11 07:17:22', 101, 100, 'Accounting', 'Hardware', NULL, '2023-06-12 00:30:50'),
(8, 'Network Failure', 'Kindly assist with internet connection has the router cable has been cut.', 'Medium', 'Open', NULL, '2023-06-16 17:19:10', '2023-06-16 08:19:10', NULL, 105, 'Operations', 'Networks', NULL, NULL),
(9, 'Network Failure', 'Kindly assist with internet connection has the router cable has been cut.', 'Medium', 'Open', NULL, '2023-06-16 17:22:41', '2023-06-16 08:22:41', NULL, 105, 'Operations', 'Networks', NULL, NULL),
(15, 'Computer Burning', 'Kindly help me with my office computer which has suddenly shutdown', 'Medium', 'Closed', 'Power supply was damaged. The only possible solution to the problem is replacement', '2023-06-17 06:31:09', '2023-06-16 21:31:09', 101, 102, 'Marketing', 'Hardware', NULL, '2023-06-23 20:05:57'),
(16, 'Network Failure', 'Kindly assist as I am unable to connect to the internet even my cables seems to be working fine', 'Medium', 'Open', NULL, '2023-06-24 20:10:53', '2023-06-24 11:10:53', NULL, 111, 'Marketing', 'Networks', NULL, NULL),
(17, 'Blue screen', 'My computer is displaying a blue screen error', 'High', 'Open', 'Blue screen errors often indicate hardware or driver issues. We can start by restarting the computer and checking for any recently installed hardware or software that might be causing conflicts. It\'s also important to update device drivers, especially for graphics cards or other critical components. If the problem persists, we may need to run hardware diagnostics or consult specialized technicians for further analysis.', '2023-06-25 01:45:50', '2023-06-24 16:45:50', NULL, 100, 'Accounting', 'Software', NULL, '2023-06-25 01:02:59'),
(18, 'Disk space', 'My computer is running out of disk space', 'Medium', 'Open', NULL, '2023-06-25 06:13:04', '2023-06-24 21:13:04', NULL, 100, 'Accounting', 'Hardware', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Firstname` varchar(255) NOT NULL,
  `Lastname` varchar(255) NOT NULL,
  `Job_Title` varchar(255) NOT NULL,
  `Dept` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `user_status` varchar(255) DEFAULT 'Active',
  `user_type` enum('Administrator','Technician','End User') NOT NULL DEFAULT 'End User'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `Username`, `Firstname`, `Lastname`, `Job_Title`, `Dept`, `Email`, `Password`, `reset_token`, `user_status`, `user_type`) VALUES
(100, 'Pathias', 'pathias', 'galiatsis', 'Accountant', 'Accounting', 'Pathias@gmail.com', '$2y$10$5UOrp3n2xFENf8Th8ATi2eKoRDdJ3bj6WYHFKn/PacNRLmOvoDDh.', '211807', 'Active', 'End User'),
(102, 'Juliet', 'Juliet', 'Chitondo', 'Administrator', 'Marketing', 'julie@gmail.com', '$2y$10$.xFjIhcQskOJSfbmrtzU7.Wy0ZIubiO2d.1zzaq8GHZs/Gutuu7uu', '912188', 'Active', 'End User'),
(103, 'Charlse', 'Charlse', 'Makaveli', 'Transport Manager', 'Operations', 'charlie@maka.com', '$2y$10$S3O/Urg8Ysd3Qwfp3l87YeOIzyxY6yjQefUktcMtRRH46oRId.wKS', '654780', 'Deleted', 'End User'),
(104, 'Beatrice', 'Beatrice', 'muhandu', 'Human Resource Manager', 'Human Resource', 'beatrice@tekrem.com', '$2y$10$qyXdWEua6qTK9ip.XxeK/u..ZYYm1LBHvNFvty9.XMPMo7DvbZf3C', '417903', 'Active', 'End User'),
(105, 'Beauty', 'Beauty', 'Meadows', 'Assistant', 'Human Resource', 'Beauty@meadows.com', '$2y$10$DhV18YmzSfa86enpswDti.R/Q.JISrj3gG2wgLU7qSScArR8t9dQ.', '758788', 'Active', 'End User'),
(107, 'Blessings', 'Blessings', 'Ziela', 'Accountant', 'Accounting', 'ble@gmail.com', '$2y$10$MKypPQo908IVwPAwEmcGMugk0pBc/Plk647B1cA9QA5dhBRw7qiU.', '650376', 'Active', 'End User'),
(108, 'Cathy', 'Catherine', 'Phiri', 'Accountant', 'Accounting', 'catherine@gmail.com', '$2y$10$CI.AmcfbQOVqVTw4Q.l36u61r6In.NXYeWfqrCdMeqGGL65FW1EUG', '310605', 'Active', 'End User'),
(111, 'Solomon', 'solomon', 'banda', 'Accountant', 'Accounting', 'solomonjrbanda@gmail.com', '$2y$10$9L5EGAyGZtY7ycHh98Ofp.1bisrtNa.R0aWRHZzAU5y6SiZGqwA.S', '132190', 'Active', 'End User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `knowledge_base`
--
ALTER TABLE `knowledge_base`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `technician`
--
ALTER TABLE `technician`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `knowledge_base`
--
ALTER TABLE `knowledge_base`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
