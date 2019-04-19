-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Апр 19 2019 г., 17:44
-- Версия сервера: 5.6.39-83.1
-- Версия PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cf62548_bx24`
--

-- --------------------------------------------------------

--
-- Структура таблицы `b24_points`
--

CREATE TABLE IF NOT EXISTS `b24_points` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_USER` int(11) NOT NULL,
  `PORTAL` varchar(35) NOT NULL,
  `COMPANY_ID` int(11) NOT NULL,
  `COMPANY_NAME` int(11) NOT NULL,
  `LID_ID` int(11) NOT NULL,
  `LID_NAME` varchar(255) NOT NULL,
  `CORDS` varchar(255) NOT NULL,
  `NAME` varchar(255) NOT NULL,
  `COMMENT` text NOT NULL,
  `TYPE_ID` int(11) NOT NULL,
  `DATETIME_CREATE` datetime NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `b24_points`
--

INSERT INTO `b24_points` (`ID`, `ID_USER`, `PORTAL`, `COMPANY_ID`, `COMPANY_NAME`, `LID_ID`, `LID_NAME`, `CORDS`, `NAME`, `COMMENT`, `TYPE_ID`, `DATETIME_CREATE`) VALUES
(28, 1, 'b24-j03jqa.bitrix24.ru', 0, 0, 0, '', '55.75806408805671,37.63210357666013', 'tt', 'ttt', 0, '0000-00-00 00:00:00'),
(27, 10, 'b24-j03jqa.bitrix24.ru', 0, 0, 0, '', '55.76793622996353,37.626953735351556', 'ttt', 'tttt', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `b24_point_comments`
--

CREATE TABLE IF NOT EXISTS `b24_point_comments` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `POINT_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `COMMENT_TEXT` text NOT NULL,
  `COMMENT_DT` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `b24_portal_reg`
--

CREATE TABLE IF NOT EXISTS `b24_portal_reg` (
  `PORTAL` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `ACCESS_TOKEN` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `EXPIRES_IN` int(11) UNSIGNED NOT NULL,
  `REFRESH_TOKEN` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `MEMBER_ID` char(32) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `b24_ratings`
--

CREATE TABLE IF NOT EXISTS `b24_ratings` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `ID_USER` bigint(20) DEFAULT NULL,
  `RATE_DATE` text,
  `RATE_SUM` float NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `b24_ratings`
--

INSERT INTO `b24_ratings` (`ID`, `ID_USER`, `RATE_DATE`, `RATE_SUM`) VALUES
(1, 1, '2019-03-27', 35000);

-- --------------------------------------------------------

--
-- Структура таблицы `b24_types_of_points`
--

CREATE TABLE IF NOT EXISTS `b24_types_of_points` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `PORTAL_ID` int(11) NOT NULL,
  `NAME` varchar(255) NOT NULL,
  `ICON` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `b24_users`
--

CREATE TABLE IF NOT EXISTS `b24_users` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `PORTAL` varchar(35) NOT NULL,
  `ID_USER` bigint(20) NOT NULL,
  `NAME` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `b24_users`
--

INSERT INTO `b24_users` (`ID`, `PORTAL`, `ID_USER`, `NAME`) VALUES
(4, 'b24-j03jqa.bitrix24.ru', 1, 'Сергей Воронов'),
(5, 'b24-j03jqa.bitrix24.ru', 10, 'Александр Попов');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
