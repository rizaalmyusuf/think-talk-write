-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 28, 2020 at 10:34 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pjbl`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `fullname`) VALUES
(1, 'rizalmyusuf007', '6820275862afacc24a802984b545266d', 'Rizal M. Yusuf');

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `idA` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `phase_id` int(11) NOT NULL,
  `fileA` mediumblob NOT NULL,
  `passed` tinyint(1) NOT NULL DEFAULT 0,
  `point` int(11) DEFAULT 0,
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`idA`, `student_id`, `phase_id`, `fileA`, `passed`, `point`, `comment`) VALUES
(2, 3, 59, 0x626173697364617461315f426173697344617461496e74726f647563696e675f64625f61746575682e7a6970, 1, 90, 'sudah oks, mangga lanjutkan');

-- --------------------------------------------------------

--
-- Table structure for table `phases`
--

CREATE TABLE `phases` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `deadline` datetime NOT NULL,
  `file` mediumblob NOT NULL,
  `project_id` int(11) NOT NULL,
  `prev_phase` int(11) DEFAULT NULL,
  `next_phase` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `phases`
--

INSERT INTO `phases` (`id`, `name`, `desc`, `deadline`, `file`, `project_id`, `prev_phase`, `next_phase`) VALUES
(58, 'Create', 'Membuat database ataupun table', '2020-06-30 06:50:00', 0x4d617465726950726f6a656b42617369735f446174614372656174655f64625f61746575682e7a6970, 5, 59, 60),
(59, 'Introducing', 'Pengenalan apa itu basis data', '2020-06-29 06:55:00', 0x4d617465726950726f6a656b42617369735f44617461496e74726f647563696e675f64625f61746575682e7a6970, 5, NULL, 58),
(60, 'Reading', 'Membaca database, tabel dan record', '2020-07-01 07:12:00', 0x4d617465726950726f6a656b42617369735f4461746152656164696e675f64625f61746575682e7a6970, 5, 58, 61),
(61, 'Updating', 'Mengubah record tabel ataupun informasi tabel', '2020-07-02 07:13:00', 0x4d617465726950726f6a656b42617369735f446174615570646174696e675f64625f61746575682e7a6970, 5, 60, 62),
(62, 'Deleting', 'Menghapus record, tabel maupun database', '2020-07-03 07:14:00', 0x4d617465726950726f6a656b42617369735f4461746144656c6574696e675f64625f61746575682e7a6970, 5, 61, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `deadline` date NOT NULL,
  `pretest` mediumblob NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `completed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `desc`, `deadline`, `pretest`, `teacher_id`, `completed`) VALUES
(4, 'PromNet', 'Pemrograman Internet', '2020-07-27', 0x5072657465737450726f6d4e65745f506a424c4d616e75616c2e646f6378, 1, 1),
(5, 'Basis Data', 'Proyek untuk belajar memanipulasi data dan mendefinisikan data', '2020-07-31', 0x5072657465737442617369735f446174615f64625f61746575682e7a6970, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_groups`
--

CREATE TABLE `student_groups` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `member` text NOT NULL,
  `project_id` int(11) NOT NULL,
  `pretest_work` mediumblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_groups`
--

INSERT INTO `student_groups` (`id`, `username`, `password`, `fullname`, `member`, `project_id`, `pretest_work`) VALUES
(3, 'basisdata1', 'cdbff0b3c415ed07060e1c6fa0f5aa33', 'Basis Data 1', 'Rizal\r\nWage\r\nDaffa\r\nIsan\r\nErvin', 5, 0x62617369736461746131507265746573744261736973446174615f64625f61746575682e7a6970);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `username`, `password`, `fullname`) VALUES
(1, 'guru', '05c7b1b95dfb9a5a61a999e717bde725', 'Rizal Maulana Yusuf, S.Pd., M.Si.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`idA`),
  ADD KEY `fk_pretest_answer` (`student_id`),
  ADD KEY `fk_project_answer` (`phase_id`);

--
-- Indexes for table `phases`
--
ALTER TABLE `phases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_project_phase` (`project_id`),
  ADD KEY `fk_next_phase` (`next_phase`),
  ADD KEY `fk_phase_prev` (`prev_phase`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_teacher_project` (`teacher_id`);

--
-- Indexes for table `student_groups`
--
ALTER TABLE `student_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_project_student` (`project_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `idA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `phases`
--
ALTER TABLE `phases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `student_groups`
--
ALTER TABLE `student_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `fk_phase_answer` FOREIGN KEY (`phase_id`) REFERENCES `phases` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_student_answer` FOREIGN KEY (`student_id`) REFERENCES `student_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `phases`
--
ALTER TABLE `phases`
  ADD CONSTRAINT `fk_next_phase` FOREIGN KEY (`next_phase`) REFERENCES `phases` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `fk_phase_prev` FOREIGN KEY (`prev_phase`) REFERENCES `phases` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `fk_project_phase` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `fk_teacher_project` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_groups`
--
ALTER TABLE `student_groups`
  ADD CONSTRAINT `fk_project_student` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
