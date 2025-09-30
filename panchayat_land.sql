-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2025 at 08:37 AM
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
-- Database: `panchayat_land`
--

-- --------------------------------------------------------

--
-- Table structure for table `panchayat_terms`
--

CREATE TABLE panchayat_terms_kannada (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kannada_word VARCHAR(255),
    english_pronunciation VARCHAR(255),
    translated_term VARCHAR(255),
    pronunciation_in_kannada VARCHAR(255)
);
 ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `panchayat_terms`
--

INSERT INTO `panchayat_terms_kannada` (`id`, `tkannada_word`, `english_pronunciation`, `translated_term`, `pronunciation_in_kannada`) VALUES
(1, 'ಗ್ರಾಮ ಪಂಚಾಯತ್', 'gram panchayat', 'village panchayat', 'ಗ್ರಾಮ ಪಂಚಾಯತ್'),
(2, 'ಮಹಾನಗರ ಪಾಲಿಕೆ', 'mahanagara paalike', 'municipality', 'ಮಹಾನಗರ ಪಾಲಿಕೆ'),
(3, 'ಶಾಸನ', 'shasana', 'legislation', 'ಶಾಸನ'),
(4, 'ನಿವೇಶನ', 'niveshana', 'investment', 'ನಿವೇಶನ'),
(5, 'ನಗರೆಗಳ ಯೋಜನೆ', 'nagaregala yojane', 'urban planning', 'ನಗರೆಗಳ ಯೋಜನೆ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `panchayat_terms`
--
ALTER TABLE `panchayat_terms_kannada`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `panchayat_terms`
--
ALTER TABLE `panchayat_terms_kannada`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
