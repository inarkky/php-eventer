-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2016 at 04:03 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rent_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `naziv` varchar(255) COLLATE utf8_bin NOT NULL,
  `adresa` varchar(255) COLLATE utf8_bin NOT NULL,
  `vlasnik_id` int(11) NOT NULL,
  `cijena` float(7,2) NOT NULL,
  `detalji` text COLLATE utf8_bin NOT NULL,
  `slika` varchar(255) COLLATE utf8_bin NOT NULL,
  `tagovi` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `naziv`, `adresa`, `vlasnik_id`, `cijena`, `detalji`, `slika`, `tagovi`) VALUES
(2, 'Vila Marija', 'Skenderovci 17, 34322 Brestovac, Hrvatska', 3, 1200.00, 'Ogromna kucerina na samom rubu pozesko-slavonske zupanije. Sa kvadraturom kuce od 600 m2, te ukupnim imanjem od 1000 m2 nodi savrseni prostor za odmor za cijelu obitelj. 4 spavace sobe te 3 kupaonice ce osigurati da svaki clan ima dovoljno mjesta. \r\nMinimalna kolicina nocenja: 3.', 'images/2.jpg', '40m2, vila, Pozega'),
(4, 'Hacijenda', 'Zlatni Rat 2a, 44758 Dalmacija, Hrvatska', 3, 500.00, 'Nesto kao iz tv sapuniceNesto kao iz tv sapuniceNesto kao iz tv sapuniceNesto kao iz tv sapuniceNesto kao iz tv sapuniceNesto kao iz tv sapuniceNesto kao iz tv sapuniceNesto kao iz tv sapuniceNesto kao iz tv sapuniceNesto kao iz tv sapuniceNesto kao iz tv sapunice', 'images/4.jpg', '150m2, vila, Osijek'),
(5, 'Vikendica', 'Jagodnjak 2, 34000 PoÅ¾ega, Hrvatska', 3, 100.00, 'Vikendica na samom rubu Å¡ume uz tamoÅ¡nje jezero. Izvrsno mjesto za okretanje roÅ¡tilja sa druÅ¡tvom. Zbog nepostojanja wifi-ja ljudi su se primorani druÅ¾iti pa ako Å¾elite pobjeci od obveza ovo je savrÅ¡ena lokacija.\r\nMinimum nocenja: 1', 'images/5.jpg', '20m2, vikendica, Pozega'),
(6, 'Bungalov', 'MaliÅ¡Äak, uz planinarski dom, Papuk, Hrvatska', 3, 105.00, 'Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet ', 'images/6.jpg', '40m2, vikendica, Velika'),
(7, 'Kuceerak', 'Jagodnjak 2, 34000 PoÅ¾ega, Hrvatska', 3, 500.00, 'Default. All characters are encoded before sent (spaces are converted to "+" symbols, and special characters are converted to ASCII HEX values)\r\nmultipart/form-data 	No characters are encoded. This value is required when you are using forms that have a file upload control\r\ntext/plain 	Spaces are converted to "+" symbols, but no special characters are encoded', 'images/7.jpg', '20m2, vikendica, Pozega');

-- --------------------------------------------------------

--
-- Table structure for table `kalendar`
--

CREATE TABLE `kalendar` (
  `id` int(11) NOT NULL,
  `art_id` int(11) NOT NULL,
  `kupac_id` int(11) NOT NULL,
  `datum` date NOT NULL,
  `pending` tinyint(4) NOT NULL,
  `poruka` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `kalendar`
--

INSERT INTO `kalendar` (`id`, `art_id`, `kupac_id`, `datum`, `pending`, `poruka`) VALUES
(11, 6, 2, '2016-09-20', 2, 'Za obljetnicu mature.'),
(12, 6, 2, '2016-09-20', 1, 'Za rodendan.'),
(13, 6, 2, '2016-09-22', 0, 'Za parti.');

-- --------------------------------------------------------

--
-- Table structure for table `pogodnosti`
--

CREATE TABLE `pogodnosti` (
  `id` int(11) NOT NULL,
  `art_id` int(11) NOT NULL,
  `wifi` tinyint(1) NOT NULL,
  `bazen` tinyint(1) NOT NULL,
  `zrak` tinyint(1) NOT NULL,
  `teretana` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `pogodnosti`
--

INSERT INTO `pogodnosti` (`id`, `art_id`, `wifi`, `bazen`, `zrak`, `teretana`) VALUES
(4, 2, 1, 1, 0, 0),
(6, 4, 1, 1, 1, 1),
(7, 5, 1, 1, 1, 1),
(8, 6, 1, 1, 1, 1),
(9, 7, 1, 1, 1, 1),
(12, 10, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(4) NOT NULL,
  `user` varchar(32) COLLATE utf8_bin NOT NULL,
  `pass` varchar(64) COLLATE utf8_bin NOT NULL,
  `ime` varchar(16) COLLATE utf8_bin NOT NULL,
  `prezime` varchar(16) COLLATE utf8_bin NOT NULL,
  `lvl` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user`, `pass`, `ime`, `prezime`, `lvl`) VALUES
(2, 'user', 'pass', 'Nova', 'Jo', 0),
(3, 'novi', 'novi', 'Ivan', 'Markovic', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vlasnik_id` (`vlasnik_id`);

--
-- Indexes for table `kalendar`
--
ALTER TABLE `kalendar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pogodnosti`
--
ALTER TABLE `pogodnosti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `art_id` (`art_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user` (`user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `kalendar`
--
ALTER TABLE `kalendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `pogodnosti`
--
ALTER TABLE `pogodnosti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
