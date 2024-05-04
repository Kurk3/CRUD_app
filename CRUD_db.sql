-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Počítač: localhost:8889
-- Vytvořeno: Sob 04. kvě 2024, 10:32
-- Verze serveru: 5.7.39
-- Verze PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `CRUD_db`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `records`
--

CREATE TABLE `records` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `registration_date` date DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `records`
--

INSERT INTO `records` (`id`, `name`, `email`, `birthdate`, `salary`, `registration_date`, `active`, `address`, `phone_number`, `notes`) VALUES
(12, 'Wing Thompson', 'belycijep@mailinator.commmm', '2016-01-31', '34.00', '1977-05-19', 1, '111', '+1 (975) 728-4147', 'Unde consectetur ea '),
(13, 'Haley Penasss', 'hyroq@mailinator.com', '2000-12-31', '81.00', '1970-10-21', 1, '123', '+1 (643) 498-8649', 'Odio in sunt sit do'),
(14, 'Gisela Gutierrez', 'byfixaco@mailinator.com', '1972-09-29', '4.00', '2000-12-03', 1, '123', '+1 (949) 387-6901', 'Aliquip rem dolorem '),
(15, 'Patricia Lara', 'kehati@mailinator.com', '2007-07-30', '81.00', '2023-08-05', 1, '12345', '+1 (436) 357-4875', 'Architecto officia e'),
(17, 'Theodore Walsh', 'gacer@mailinator.com', '1978-04-26', '75.00', '1987-08-17', 1, '1234556', '+1 (398) 108-1022', 'Libero asperiores ip');

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `records`
--
ALTER TABLE `records`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `records`
--
ALTER TABLE `records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
