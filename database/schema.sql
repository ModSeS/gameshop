-- Structure only: original account, message, order and product data omitted.
-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 16 2023 г., 21:34
-- Версия сервера: 8.0.24
-- Версия PHP: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `gameshop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `accounts`
--

CREATE TABLE `accounts` (
  `userID` int NOT NULL,
  `Type` varchar(30) NOT NULL,
  `RegistrationData` varchar(30) NOT NULL,
  `NickName` varchar(30) NOT NULL,
  `pass` varchar(30) NOT NULL,
  `balance` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `favorites`
--

CREATE TABLE `favorites` (
  `favID` int NOT NULL,
  `idUser` int NOT NULL,
  `idGame` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `games`
--

CREATE TABLE `games` (
  `idGames` int NOT NULL,
  `GameName` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Price` double NOT NULL,
  `SellerID` int NOT NULL,
  `Platform` varchar(30) NOT NULL,
  `Description` text,
  `TypeGame` varchar(30) NOT NULL,
  `Result` text NOT NULL,
  `Status` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

pass: qwerty123', 'checked'),
(11, 'ARMA 3 ПОЛНЫЙ ДОСТУП АККАУНТ', 412, 13, 'XBOX', 'ПОЛНЫЙ ДОСТУП АККАУНТ + ПОЧТА', 'Аккаунт', 'login: loglogga; pass: 12eawd3r\r\nlogin: loglogga2; pass: 12eawd3r2\r\nlogin: loglogga3; pass: 12eawd3r3\r\nlogin: loglogga3; pass: 12eawd3r3', 'checked');

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `idMess` int NOT NULL,
  `idRecipient` int NOT NULL,
  `idSender` int NOT NULL,
  `Data` varchar(30) NOT NULL,
  `TextMess` text NOT NULL,
  `StatusMsg` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `OrderID` int NOT NULL,
  `GameID` int NOT NULL,
  `userID` int NOT NULL,
  `Status` varchar(10) NOT NULL,
  `Result` text NOT NULL,
  `DataOrd` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `DataAcc` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

pass: qwerty123\r', '16.06.2023', '16.06.2023');

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `reviewID` int NOT NULL,
  `idUser` int NOT NULL,
  `reviewText` text NOT NULL,
  `idGame` int NOT NULL,
  `rating` int NOT NULL,
  `dataRev` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `NickName` (`NickName`);

--
-- Индексы таблицы `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`favID`),
  ADD UNIQUE KEY `idGame_2` (`idGame`,`idUser`),
  ADD KEY `idGame` (`idGame`,`idUser`),
  ADD KEY `idUser` (`idUser`);

--
-- Индексы таблицы `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`idGames`),
  ADD KEY `SellerID` (`SellerID`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`idMess`),
  ADD KEY `idSender` (`idSender`,`idRecipient`),
  ADD KEY `idRecipient` (`idRecipient`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `GameID` (`GameID`,`userID`),
  ADD KEY `userID` (`userID`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`reviewID`),
  ADD KEY `idGame` (`idGame`,`idUser`),
  ADD KEY `idUser` (`idUser`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `accounts`
--
ALTER TABLE `accounts`
  MODIFY `userID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `favorites`
--
ALTER TABLE `favorites`
  MODIFY `favID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `games`
--
ALTER TABLE `games`
  MODIFY `idGames` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `idMess` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `reviewID` int NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `accounts` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`idGame`) REFERENCES `games` (`idGames`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `games_ibfk_2` FOREIGN KEY (`SellerID`) REFERENCES `accounts` (`userID`);

--
-- Ограничения внешнего ключа таблицы `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`idRecipient`) REFERENCES `accounts` (`userID`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`idSender`) REFERENCES `accounts` (`userID`);

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `accounts` (`userID`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`GameID`) REFERENCES `games` (`idGames`);

--
-- Ограничения внешнего ключа таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `accounts` (`userID`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`idGame`) REFERENCES `games` (`idGames`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
