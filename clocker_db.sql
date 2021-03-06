-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 30 Sty 2022, 12:41
-- Wersja serwera: 10.4.22-MariaDB
-- Wersja PHP: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `clocker_db`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `clients`
--

CREATE TABLE `clients` (
  `ID` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `clients`
--

INSERT INTO `clients` (`ID`, `name`, `user_id`) VALUES
(1, 'Januszex Firma', 8),
(2, 'NBP', 8),
(3, 'KAKA', 8),
(4, 'TEST', 8),
(5, 'test123', 8);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `groups`
--

CREATE TABLE `groups` (
  `ID` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `groups`
--

INSERT INTO `groups` (`ID`, `name`) VALUES
(1, 'Grupa TESSSSS'),
(2, 'Brains'),
(3, 'TEST WSPólny'),
(4, 'TEST1');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `members`
--

CREATE TABLE `members` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `members`
--

INSERT INTO `members` (`user_id`, `group_id`) VALUES
(8, 1),
(7, 2),
(8, 3),
(7, 3),
(8, 4);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `projects`
--

CREATE TABLE `projects` (
  `ID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `projects`
--

INSERT INTO `projects` (`ID`, `user_id`, `group_id`, `client_id`, `name`) VALUES
(1, 8, NULL, 1, 'Projekt Testowy 1'),
(2, 8, 1, 2, 'Dla '),
(12, 8, NULL, 4, 'TEST'),
(891, 8, NULL, 4, 'TEST2'),
(892, 8, NULL, 5, 'Projekt');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tasks`
--

CREATE TABLE `tasks` (
  `ID` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `start` timestamp NOT NULL DEFAULT current_timestamp(),
  `stop` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `timer` time NOT NULL DEFAULT '00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `tasks`
--

INSERT INTO `tasks` (`ID`, `project_id`, `name`, `description`, `start`, `stop`, `status`, `timer`) VALUES
(1, 1, 'Task1', 'abcd', '2022-01-29 18:43:36', '2022-01-29 18:43:38', 0, '00:03:19'),
(2, 1, 'Task1', 'Brak', '2022-01-29 18:45:03', '2022-01-29 18:45:05', 0, '00:04:01'),
(4, 1, 'TEST3', 'hola hola hola hola hola hola', '2022-01-29 18:43:24', '2022-01-29 18:43:28', 0, '00:03:29'),
(5, 1, 'aaa', '', '2022-01-29 18:43:24', '2022-01-29 18:43:27', 0, '00:03:38'),
(6, 2, 'abcd', '', '2022-01-22 11:30:29', '2022-01-22 11:30:29', 0, '00:00:00'),
(7, 12, 'test4', '', '2022-01-22 11:30:44', '2022-01-22 11:30:44', 0, '00:00:00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(1) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`ID`, `email`, `password`, `name`, `surname`, `role`) VALUES
(1, 'test@op.pl', 'test', 'name', 'surname', 'a'),
(2, 'abcd@xyz.pl', 'abcd', 'abcd', 'xyz', 'a'),
(3, 'kkk@kk.pl', 'k', 'kk', 'kkk', 'u'),
(6, 'test2@op.pl', '$2y$04$SBWbgERXhKmTiT05k3/FQOA', 'test2', 'test2', 'u'),
(7, 'test3@op.pl', '$2y$04$XM5bUZFY6lvVw9ZvOP0JHu3', 'test3', 'test3', 'u'),
(8, 'test4@op.pl', '$2y$04$bSMCEUEuPapdRkSQxbk08.tL18Mr5R453eRTWJQvtqTUUuOSRYBM6', 'test4', 'test', 'u'),
(9, 'master@ad.pl', '$2y$04$cFjh12R84WXvqbiebvOlhO3/qYGnMLrYOTqbWAz/ehGRdMmJrnv/6', 'Admin', 'Master', 'a');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `clients`
--
ALTER TABLE `clients`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `groups`
--
ALTER TABLE `groups`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `projects`
--
ALTER TABLE `projects`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=893;

--
-- AUTO_INCREMENT dla tabeli `tasks`
--
ALTER TABLE `tasks`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
