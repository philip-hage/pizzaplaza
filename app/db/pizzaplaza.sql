-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 24 okt 2023 om 09:15
-- Serverversie: 10.4.28-MariaDB
-- PHP-versie: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pizzaplaza`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `customer`
--

CREATE TABLE `customer` (
  `customerId` varchar(4) NOT NULL,
  `customerName` varchar(255) NOT NULL,
  `customerStreetName` varchar(255) NOT NULL,
  `customerHouseNumber` varchar(255) NOT NULL,
  `customerZipCode` varchar(255) NOT NULL,
  `customerCity` varchar(255) NOT NULL,
  `customerEmail` varchar(255) NOT NULL,
  `customerPhone` int(10) NOT NULL,
  `customerIsActive` tinyint(1) NOT NULL DEFAULT 1,
  `customerCreateDate` varchar(10) NOT NULL,
  `customerDescription` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `customer`
--

INSERT INTO `customer` (`customerId`, `customerName`, `customerStreetName`, `customerHouseNumber`, `customerZipCode`, `customerCity`, `customerEmail`, `customerPhone`, `customerIsActive`, `customerCreateDate`, `customerDescription`) VALUES
('9MkD', 'Philip', 'Riddersborch ', '88', '3499BJ', 'Houten', 'philip@hage.cc', 681867393, 1, '1698071458', NULL),
('lqIq', 'Philip Hage', 'dfdfs', '97', '3992BJ', 'Houten', 'flip@gmail.com', 68195721, 1, '1698071550', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ingredients`
--

CREATE TABLE `ingredients` (
  `ingredientId` varchar(4) NOT NULL,
  `ingredientName` varchar(255) NOT NULL,
  `ingredientIsActive` tinyint(1) NOT NULL DEFAULT 1,
  `ingredientCreateDate` varchar(10) NOT NULL,
  `ingredientDescription` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `ingredients`
--

INSERT INTO `ingredients` (`ingredientId`, `ingredientName`, `ingredientIsActive`, `ingredientCreateDate`, `ingredientDescription`) VALUES
('1', 'Tomatensaus', 1, 'dfsdfs', ''),
('3242', 'Jalapeno', 1, '25353', ''),
('4213', 'Knoflookolie', 1, '2352', ''),
('5423', 'Mozzarella', 1, '235323', '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `order`
--

CREATE TABLE `order` (
  `orderId` varchar(4) NOT NULL,
  `customerId` varchar(4) NOT NULL,
  `orderIsActive` tinyint(1) NOT NULL DEFAULT 1,
  `orderCreateDate` varchar(255) NOT NULL,
  `orderDescription` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `order`
--

INSERT INTO `order` (`orderId`, `customerId`, `orderIsActive`, `orderCreateDate`, `orderDescription`) VALUES
('9MkD', '9MkD', 1, '1698071458', ''),
('lqIq', 'lqIq', 1, '1698071550', ''),
('t24s', '9MkD', 1, '1698071501', ''),
('WbGf', '9MkD', 1, '1698071763', '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `orderhaspizzas`
--

CREATE TABLE `orderhaspizzas` (
  `orderId` varchar(4) NOT NULL,
  `pizzaId` varchar(4) NOT NULL,
  `pizzaAmount` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `orderhaspizzas`
--

INSERT INTO `orderhaspizzas` (`orderId`, `pizzaId`, `pizzaAmount`) VALUES
('9MkD', '3422', 1),
('9MkD', '4232', 1),
('lqIq', '2345', 1),
('lqIq', '3422', 3),
('t24s', '2345', 1),
('t24s', '3422', 1),
('t24s', '4232', 1),
('WbGf', '2345', 1),
('WbGf', '3422', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `pizza`
--

CREATE TABLE `pizza` (
  `pizzaId` varchar(4) NOT NULL,
  `pizzaName` varchar(255) NOT NULL,
  `pizzaPrice` decimal(6,2) NOT NULL,
  `pizzaPath` varchar(255) NOT NULL,
  `pizzaIsActive` tinyint(1) NOT NULL DEFAULT 1,
  `pizzaCreateDate` varchar(10) NOT NULL,
  `pizzaDescription` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `pizza`
--

INSERT INTO `pizza` (`pizzaId`, `pizzaName`, `pizzaPrice`, `pizzaPath`, `pizzaIsActive`, `pizzaCreateDate`, `pizzaDescription`) VALUES
('2345', 'Zwarte Truffel', 19.00, 'public/img/Zwarte_Truffel-9551.jpg', 1, '5343432', NULL),
('3422', 'Pizza BBQ', 19.50, 'public/img/BBQ-9473.jpg', 1, '342', NULL),
('4232', 'Pizza 4 Cheese', 2.00, 'public/img/4_cheese-8013.png', 1, '53342', NULL),
('5322', 'pizza margherita', 2.00, 'public/img/Margherita-7711.jpg', 1, '233421', NULL),
('5423', 'Pizza Pesto Chicken', 19.00, 'public/img/pestochicken.jpg', 1, '5235323', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `pizzahasingredients`
--

CREATE TABLE `pizzahasingredients` (
  `pizzaId` varchar(4) NOT NULL,
  `ingredientId` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `pizzahasingredients`
--

INSERT INTO `pizzahasingredients` (`pizzaId`, `ingredientId`) VALUES
('2345', '3242'),
('4232', '5423'),
('5322', '1'),
('5322', '5423'),
('5423', '4213');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customerId`);

--
-- Indexen voor tabel `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`ingredientId`);

--
-- Indexen voor tabel `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`orderId`),
  ADD KEY `customerId` (`customerId`);

--
-- Indexen voor tabel `orderhaspizzas`
--
ALTER TABLE `orderhaspizzas`
  ADD PRIMARY KEY (`orderId`,`pizzaId`),
  ADD KEY `pizzaId` (`pizzaId`);

--
-- Indexen voor tabel `pizza`
--
ALTER TABLE `pizza`
  ADD PRIMARY KEY (`pizzaId`);

--
-- Indexen voor tabel `pizzahasingredients`
--
ALTER TABLE `pizzahasingredients`
  ADD PRIMARY KEY (`pizzaId`,`ingredientId`),
  ADD KEY `ingredientId` (`ingredientId`);

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`customerId`) REFERENCES `customer` (`customerId`);

--
-- Beperkingen voor tabel `orderhaspizzas`
--
ALTER TABLE `orderhaspizzas`
  ADD CONSTRAINT `orderhaspizzas_ibfk_1` FOREIGN KEY (`orderId`) REFERENCES `order` (`orderId`),
  ADD CONSTRAINT `orderhaspizzas_ibfk_2` FOREIGN KEY (`pizzaId`) REFERENCES `pizza` (`pizzaId`);

--
-- Beperkingen voor tabel `pizzahasingredients`
--
ALTER TABLE `pizzahasingredients`
  ADD CONSTRAINT `pizzahasingredients_ibfk_1` FOREIGN KEY (`pizzaId`) REFERENCES `pizza` (`pizzaId`),
  ADD CONSTRAINT `pizzahasingredients_ibfk_2` FOREIGN KEY (`ingredientId`) REFERENCES `ingredients` (`ingredientId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
