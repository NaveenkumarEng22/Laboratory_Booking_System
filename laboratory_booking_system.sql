-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2025 at 07:07 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laboratory_booking_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `lab`
--

CREATE TABLE `lab` (
  `Lab_ID` varchar(10) NOT NULL,
  `Lab_Type` varchar(50) NOT NULL,
  `Availability_Status` varchar(20) DEFAULT NULL CHECK (`Availability_Status` in ('Available','Booked','Under Maintenance')),
  `Capacity` int(11) DEFAULT NULL CHECK (`Capacity` > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab`
--

INSERT INTO `lab` (`Lab_ID`, `Lab_Type`, `Availability_Status`, `Capacity`) VALUES
('L101', 'Computer Lab', 'Available', 40),
('L102', 'Manufactor Lab', 'Booked', 20),
('L103', 'Communication Lab', 'Available', 30),
('L104', 'Elementary Lab', 'Booked', 40),
('L105', 'Simulation Lab', 'Available', 45),
('L106', 'Hydraulics Lab', 'Available', 25),
('L107', 'Hydrology Lab', 'Booked', 25);

-- --------------------------------------------------------

--
-- Table structure for table `lab_booking_request`
--

CREATE TABLE `lab_booking_request` (
  `Request_ID` varchar(10) NOT NULL,
  `User_ID` varchar(10) DEFAULT NULL,
  `Lab_ID` varchar(10) DEFAULT NULL,
  `Requested_Date` date DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL CHECK (`Status` in ('Pending','Approved','Rejected'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_booking_request`
--

INSERT INTO `lab_booking_request` (`Request_ID`, `User_ID`, `Lab_ID`, `Requested_Date`, `Status`) VALUES
('R001', 'U0003', 'L101', '2025-07-02', 'Pending'),
('R002', 'U0002', 'L102', '2025-06-30', 'Approved'),
('R003', 'U0003', 'L105', '2025-07-08', 'Rejected'),
('R004', 'U0002', 'L103', '2025-07-01', 'Pending'),
('R031', 'U0008', 'L101', '2025-07-01', 'Rejected');

-- --------------------------------------------------------

--
-- Table structure for table `lab_equipment`
--

CREATE TABLE `lab_equipment` (
  `Equipment_ID` varchar(10) NOT NULL,
  `Lab_ID` varchar(10) DEFAULT NULL,
  `Equipment_Name` varchar(100) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL CHECK (`Quantity` >= 0),
  `Status` varchar(20) DEFAULT NULL CHECK (`Status` in ('Functional','Limited','Out of Order'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_equipment`
--

INSERT INTO `lab_equipment` (`Equipment_ID`, `Lab_ID`, `Equipment_Name`, `Quantity`, `Status`) VALUES
('E001', 'L101', 'Personal Computer', 45, 'Limited'),
('E002', 'L102', 'Concerete Mixer', 3, 'Limited'),
('E003', 'L103', 'Signal Generator', 5, 'Functional'),
('E004', 'L104', 'Oscilloscope', 5, 'Functional'),
('E005', 'L106', 'Hydraulic Press model', 2, 'Out of Order'),
('E006', 'L107', 'Waterfall Model', 1, 'Functional'),
('E007', 'L105', 'Simulator Boards', 4, 'Limited');

-- --------------------------------------------------------

--
-- Table structure for table `lab_schedule`
--

CREATE TABLE `lab_schedule` (
  `Schedule_ID` varchar(10) NOT NULL,
  `Lab_ID` varchar(10) DEFAULT NULL,
  `Booking_Date` date NOT NULL,
  `Time_Slot` varchar(20) NOT NULL,
  `Booked_By` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_schedule`
--

INSERT INTO `lab_schedule` (`Schedule_ID`, `Lab_ID`, `Booking_Date`, `Time_Slot`, `Booked_By`) VALUES
('S001', 'L102', '2025-06-30', '9.00-12.00', 'U0002');

-- --------------------------------------------------------

--
-- Table structure for table `lab_usage_log`
--

CREATE TABLE `lab_usage_log` (
  `Log_ID` varchar(10) NOT NULL,
  `Lab_ID` varchar(10) DEFAULT NULL,
  `User_ID` varchar(10) DEFAULT NULL,
  `Access_Date` date DEFAULT NULL,
  `Equipment_Used` text DEFAULT NULL,
  `Remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_usage_log`
--

INSERT INTO `lab_usage_log` (`Log_ID`, `Lab_ID`, `User_ID`, `Access_Date`, `Equipment_Used`, `Remarks`) VALUES
('L001', 'L102', 'U0002', '2025-06-24', 'Two Concrete Mixers', 'Third Mixer Not working Properly.'),
('L002', 'L101', 'U0003', '2025-06-23', '35 Personal Computers', 'Others Not Functioning Repairing Needed '),
('L456', 'L101', 'U0002', '2025-06-29', 'personal computers', '5 not working');

-- --------------------------------------------------------

--
-- Table structure for table `user_accounts`
--

CREATE TABLE `user_accounts` (
  `User_ID` varchar(10) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Role` varchar(50) DEFAULT NULL CHECK (`Role` in ('Student','Instructor','Lab TO','Lecture In Charge')),
  `Email` varchar(100) NOT NULL,
  `Password` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_accounts`
--

INSERT INTO `user_accounts` (`User_ID`, `Name`, `Role`, `Email`, `Password`) VALUES
('U0001', 'Dr.B.Mukunth', 'Lecture in Charge', 'mukunthProf@eng.jfn.ac.lk', 'Mukunth'),
('U0002', 'Miss.A.Rebeca', 'Instructor', 'rebeca@eng.jfn.ac.lk', 'Rebeca'),
('U0003', 'Mr.K.Jathush', 'Instructor', 'Jathu@eng.jfn.ac.lk', 'Jathush'),
('U0004', 'Mr.K.Ramesh', 'Instructor', 'ramesh@eng.jfn.ac.lk', 'Ramesh'),
('U0005', 'Mr.A.Arivu', 'Lab TO', 'arivu@eng.jfn.ac.lk', 'Arivu'),
('U0006', 'Mr.K.Karthik', 'Lab TO', 'karthik@eng.jfn.ac.lk', 'Karthik'),
('U0007', 'Mr.S.Santhosh', 'Student', 'Santhosh@eng.jfn.ac.lk', 'Santhosh'),
('U0008', 'Mr.J.Anbu', 'Student', 'anbu@eng.jfn.ac.lk', 'Anbu'),
('U0009', 'Mr.S.Sasi', 'Student', 'sasi@eng.jfn.ac.lk', 'Sasi'),
('U0010', 'Miss.S.Saniya', 'Student', 'saniya@eng.jfn.ac.lk', 'Saniya');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lab`
--
ALTER TABLE `lab`
  ADD PRIMARY KEY (`Lab_ID`);

--
-- Indexes for table `lab_booking_request`
--
ALTER TABLE `lab_booking_request`
  ADD PRIMARY KEY (`Request_ID`),
  ADD KEY `User_ID` (`User_ID`),
  ADD KEY `Lab_ID` (`Lab_ID`);

--
-- Indexes for table `lab_equipment`
--
ALTER TABLE `lab_equipment`
  ADD PRIMARY KEY (`Equipment_ID`),
  ADD KEY `Lab_ID` (`Lab_ID`);

--
-- Indexes for table `lab_schedule`
--
ALTER TABLE `lab_schedule`
  ADD PRIMARY KEY (`Schedule_ID`),
  ADD KEY `Lab_ID` (`Lab_ID`),
  ADD KEY `Booked_By` (`Booked_By`);

--
-- Indexes for table `lab_usage_log`
--
ALTER TABLE `lab_usage_log`
  ADD PRIMARY KEY (`Log_ID`),
  ADD KEY `Lab_ID` (`Lab_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `user_accounts`
--
ALTER TABLE `user_accounts`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lab_booking_request`
--
ALTER TABLE `lab_booking_request`
  ADD CONSTRAINT `lab_booking_request_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user_accounts` (`User_ID`),
  ADD CONSTRAINT `lab_booking_request_ibfk_2` FOREIGN KEY (`Lab_ID`) REFERENCES `lab` (`Lab_ID`);

--
-- Constraints for table `lab_equipment`
--
ALTER TABLE `lab_equipment`
  ADD CONSTRAINT `lab_equipment_ibfk_1` FOREIGN KEY (`Lab_ID`) REFERENCES `lab` (`Lab_ID`) ON DELETE CASCADE;

--
-- Constraints for table `lab_schedule`
--
ALTER TABLE `lab_schedule`
  ADD CONSTRAINT `lab_schedule_ibfk_1` FOREIGN KEY (`Lab_ID`) REFERENCES `lab` (`Lab_ID`),
  ADD CONSTRAINT `lab_schedule_ibfk_2` FOREIGN KEY (`Booked_By`) REFERENCES `user_accounts` (`User_ID`);

--
-- Constraints for table `lab_usage_log`
--
ALTER TABLE `lab_usage_log`
  ADD CONSTRAINT `lab_usage_log_ibfk_1` FOREIGN KEY (`Lab_ID`) REFERENCES `lab` (`Lab_ID`),
  ADD CONSTRAINT `lab_usage_log_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `user_accounts` (`User_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
