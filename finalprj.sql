-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Jan 29, 2025 at 06:14 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `finalprj`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `ID` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `course_code` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`ID`, `course_name`, `course_code`) VALUES
(1, 'Internet Computing', 'CSC385'),
(2, 'DataBase', 'CSC426'),
(3, 'C++', 'CSC212'),
(4, 'Security', 'CSC306');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `ID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `department` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`ID`, `user_id`, `department`) VALUES
(2, 6, 'Computer Science'),
(3, 7, 'Computer Science'),
(5, 15, 'Computer Science'),
(6, 18, 'Computer Science'),
(9, 28, 'NTR'),
(13, 32, 'NTR'),
(14, 36, 'CCE');

-- --------------------------------------------------------

--
-- Table structure for table `faculty_course`
--

CREATE TABLE `faculty_course` (
  `faculty_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty_course`
--

INSERT INTO `faculty_course` (`faculty_id`, `course_id`) VALUES
(2, 1),
(2, 3),
(3, 2),
(6, 4);

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `ID` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `grade` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `ID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 for unread,1 for read',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`ID`, `user_id`, `is_read`, `created_at`, `message`) VALUES
(1, 9, 1, '2024-12-08 13:00:08', 'New Student Dina Signed Up'),
(3, 13, 1, '2024-12-08 16:21:47', 'New StudentAlaa Bou Nassif has registered'),
(5, 15, 1, '2024-12-08 16:37:47', 'New Faculty Tony has registered'),
(6, 18, 1, '2024-12-08 16:42:17', 'New Faculty Farah has registered'),
(11, 28, 1, '2024-12-10 16:58:59', 'New Faculty dima has registered'),
(15, 32, 0, '2024-12-10 18:10:54', 'New Faculty Roua has registered'),
(18, 35, 1, '2024-12-10 20:19:04', 'New Student majd has registered'),
(19, 36, 1, '2024-12-10 20:20:17', 'New Faculty Ali has registered'),
(23, 40, 1, '2024-12-11 18:20:29', 'New Admin root has registered');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `ID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `gpa` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`ID`, `user_id`, `gpa`) VALUES
(4, 8, 3.00),
(5, 9, 4.00),
(6, 10, 3.00),
(10, 13, 3.81),
(15, 35, 2.50);

-- --------------------------------------------------------

--
-- Table structure for table `student_courses`
--

CREATE TABLE `student_courses` (
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `grade` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_courses`
--

INSERT INTO `student_courses` (`student_id`, `course_id`, `grade`) VALUES
(4, 1, 13),
(4, 2, NULL),
(4, 3, 30),
(4, 4, 92),
(5, 2, NULL),
(5, 4, 96),
(6, 1, 90),
(6, 3, 25),
(15, 1, NULL),
(15, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Faculty','Student') NOT NULL DEFAULT 'Student',
  `status` enum('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `name`, `email`, `password`, `role`, `status`) VALUES
(0, 'root', 'root@root.com', '$2y$10$uYVTuErb27YARKdp2s7XBuEiOVu2NDzaBDDkphXW3BDW04zj7SafC', 'Admin', 'Approved'),
(6, 'Kamil', 'kamil@gmail.com', '$2y$10$8WCSx.oMfE3.A9aYmEq5/.aRP1iGCpkSxaEdjwHfJB5U5OGIfwe0S', 'Faculty', 'Approved'),
(7, 'Sara', 'sara@gmail.com', '$2y$10$5rkICdKhoTszbN1yA17FH.bLRLnIriZpWaclsYnxH/.8JWLrS1LdO', 'Faculty', 'Approved'),
(8, 'Elyan', 'elyan@gmail.com', '$2y$10$vZRuShrla/1NFOts7mRAd.Ia5uPQbyimC2WOkcmPV8H5Q2S.4GGo.', 'Student', 'Approved'),
(9, 'Dina', 'dina@gmail.com', '$2y$10$PAsgyrmOjHz18wkuVQxR/eYflluFqovrBAY2FVy1O5mKWYttCADr.', 'Student', 'Approved'),
(10, 'Ziad', 'ziad@gmail.com', '$2y$10$qvjF6/sLpmed19v5mkHfeOQiBQEMadEebS/QL0vnECe2nw1PYVxHC', 'Student', 'Approved'),
(13, 'Alaa', 'alaa@gmail.com', '$2y$10$H4D3FitxGeG7j6FmOBad6.BVKihJ8HEXiR3hTRny7MfeQyYpkHdvO', 'Student', 'Rejected'),
(15, 'Tony', 'tony@gmail.com', '$2y$10$2lFrnt695C9R/jEVWInlG.IVid8IlUW/3NdmvWjP4NqkdG.8IN2l.', 'Faculty', 'Approved'),
(18, 'Farah', 'farah@gmail.com', '$2y$10$sGcxyOfgLdCH.qjJzGJR.OMgq6Sm2vwv5zhaafKeVie3s9VaO8Uaq', 'Faculty', 'Approved'),
(28, 'Dima', 'dima@gmail.com', '$2y$10$6k5MNT/a/7OjivDLAX5Tge33L8XnLJCj68YlGpvr/qWd/NP/Y8Ply', 'Faculty', 'Rejected'),
(32, 'Roua', 'roua@gmail.com', '$2y$10$YamlPb/jPvdXDYbGgkDUIuSdMqokubJUSkojJI4iXugG5ruazw5QO', 'Faculty', 'Pending'),
(35, 'Majd', 'majd@gmail.com', '$2y$10$F964ft.3yjNVHAl8RhRyQ.23J4NLr8fktMQ3v1XkSIXNJdgo0p9RG', 'Student', 'Approved'),
(36, 'Ali', 'ali@gmail.com', '$2y$10$46xconNpLFDMQbh9Ks5BHuQ6XCsThOEqJ3PVldjEjTSY//jAdBniW', 'Faculty', 'Rejected'),
(40, 'root', 'root1@gmail.com', '$2y$10$4jcSLXkKfCtEj7TSUGBpv.BkX2xTv7uE5KqlPt1b9Hy3BI0ZlVRD6', 'Admin', 'Approved');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `faculty_course`
--
ALTER TABLE `faculty_course`
  ADD PRIMARY KEY (`faculty_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `student_courses`
--
ALTER TABLE `student_courses`
  ADD PRIMARY KEY (`student_id`,`course_id`),
  ADD KEY `FK` (`course_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `faculty`
--
ALTER TABLE `faculty`
  ADD CONSTRAINT `faculty_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `faculty_course`
--
ALTER TABLE `faculty_course`
  ADD CONSTRAINT `faculty_course_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `faculty_course_ibfk_2` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_courses`
--
ALTER TABLE `student_courses`
  ADD CONSTRAINT `FK` FOREIGN KEY (`course_id`) REFERENCES `courses` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK2` FOREIGN KEY (`student_id`) REFERENCES `students` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
