-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 22 Lip 2018, 11:57
-- Wersja serwera: 10.1.32-MariaDB
-- Wersja PHP: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `lotnictwo`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `manual`
--

CREATE TABLE `manual` (
  `id` int(8) NOT NULL,
  `references` varchar(80) NOT NULL,
  `task_details` text NOT NULL,
  `ata` varchar(6) NOT NULL,
  `id_user` int(8) NOT NULL,
  `using_count` int(8) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `record`
--

CREATE TABLE `record` (
  `id` int(8) NOT NULL,
  `id_manual` int(8) NOT NULL,
  `id_report` int(8) DEFAULT NULL,
  `id_user` int(8) NOT NULL,
  `date` date NOT NULL,
  `b` bit(1) NOT NULL,
  `cat` bit(1) NOT NULL,
  `ac_reg` varchar(3) NOT NULL,
  `wo_number` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `report`
--

CREATE TABLE `report` (
  `id` int(8) NOT NULL,
  `id_user` int(8) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE `user` (
  `id` int(8) NOT NULL,
  `name` varchar(25) NOT NULL,
  `surname` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(25) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `subscription_date` date DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `post_code` varchar(8) DEFAULT NULL,
  `street` varchar(30) DEFAULT NULL,
  `house_number` int(4) DEFAULT NULL,
  `apartment_number` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `manual`
--
ALTER TABLE `manual`
  ADD PRIMARY KEY (`id`,`id_user`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeksy dla tabeli `record`
--
ALTER TABLE `record`
  ADD PRIMARY KEY (`id`,`id_user`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_manual` (`id_manual`),
  ADD KEY `id_report` (`id_report`);

--
-- Indeksy dla tabeli `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`,`id_user`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeksy dla tabeli `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `manual`
--
ALTER TABLE `manual`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `record`
--
ALTER TABLE `record`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `report`
--
ALTER TABLE `report`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `user`
--
ALTER TABLE `user`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `manual`
--
ALTER TABLE `manual`
  ADD CONSTRAINT `manual_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Ograniczenia dla tabeli `record`
--
ALTER TABLE `record`
  ADD CONSTRAINT `record_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `record_ibfk_2` FOREIGN KEY (`id_manual`) REFERENCES `manual` (`id`),
  ADD CONSTRAINT `record_ibfk_3` FOREIGN KEY (`id_report`) REFERENCES `report` (`id`);

--
-- Ograniczenia dla tabeli `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
