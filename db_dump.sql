-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Окт 31 2017 г., 17:12
-- Версия сервера: 10.1.10-MariaDB
-- Версия PHP: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test_-_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Admin`
--
-- Создание: Окт 31 2017 г., 13:26
--

DROP TABLE IF EXISTS `Admin`;
CREATE TABLE IF NOT EXISTS `Admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(65) NOT NULL,
  `add_user_form_password` varchar(256) NOT NULL,
  `access_table_form_password` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Очистить таблицу перед добавлением данных `Admin`
--

TRUNCATE TABLE `Admin`;
--
-- Дамп данных таблицы `Admin`
--

INSERT INTO `Admin` (`id`, `name`, `add_user_form_password`, `access_table_form_password`) VALUES
(1, 'admin', 'af87b72e63755d6573e5464c383b7ab5', '4335c6470a9c145482b508d64fd48ff6');

-- --------------------------------------------------------

--
-- Структура таблицы `Users`
--
-- Создание: Окт 31 2017 г., 15:12
--

DROP TABLE IF EXISTS `Users`;
CREATE TABLE IF NOT EXISTS `Users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(65) NOT NULL,
  `gender` varchar(65) NOT NULL,
  `race` varchar(65) NOT NULL,
  `placebirth` varchar(55) NOT NULL,
  `datebirth` date NOT NULL,
  `is_carriedring` tinyint(1) NOT NULL,
  `is_enslaved` tinyint(1) NOT NULL,
  `crimes_total_count` int(11) NOT NULL,
  `crimes_punished_count` int(11) NOT NULL,
  `crimes_unpunished_count` int(11) NOT NULL,
  `crimes` longtext NOT NULL,
  `notes` longtext NOT NULL,
  `created_at` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Очистить таблицу перед добавлением данных `Users`
--

TRUNCATE TABLE `Users`;
--
-- Дамп данных таблицы `Users`
--

INSERT INTO `Users` (`id`, `name`, `gender`, `race`, `placebirth`, `datebirth`, `is_carriedring`, `is_enslaved`, `crimes_total_count`, `crimes_punished_count`, `crimes_unpunished_count`, `crimes`, `notes`, `created_at`) VALUES
(1, 'Billy', 'male', 'dwarf', 'City &quot;Kanz&quot;', '1987-02-21', 1, 0, 2, 2, 0, '{"1":{"is_punished":1,"date":"1988-02-03","note":"Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It''s also called placeholder (or filler) text."},"2":{"date":"1988-02-09","note":"Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It''s also called placeholder (or filler) text.","is_punished":1}}', '{"1":{"date":"2016-10-18","note":"Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It''s also called placeholder (or filler) text. It''s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation."}}', '2017-09-17'),
(2, 'Foo', 'unknown', 'orc', 'Barcuda', '1965-07-31', 1, 1, 0, 0, 0, '', '', '2017-09-28'),
(3, 'July', 'female', 'elf', 'Sacalamani', '2000-11-22', 0, 0, 2, 2, 0, '{"1":{"is_punished":1,"date":"2015-09-01","note":"Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero. Its words and letters have been changed by addition or removal, so to deliberately render its content nonsensical; it''s not genuine\\/"},"2":{"is_punished":1,"date":"2017-04-12","note":"Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero. Its words and letters have been changed by addition or removal, so to deliberately render its content nonsensical; it''s not genuine\\/"}}', '{"1":{"date":"2017-10-28","note":"Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It''s also called placeholder (or filler) text. It''s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation."}}', '2017-10-04'),
(4, 'Duron', 'male', 'human', 'Lorem ipsum and its many variants.', '1938-11-22', 0, 1, 1, 1, 0, '{"1":{"date":"2010-10-28","note":"Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It''s also called placeholder.","is_punished":1}}', '{"1":{"date":"2017-10-28","note":"Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It''s also called placeholder."}}', '2017-10-07'),
(5, 'O''reyli', 'mutant', 'dwarf', 'Unknown', '1879-03-29', 1, 1, 3, 2, 1, '{"1":{"is_punished":1,"date":"1945-08-09","note":"Lorem ipsum and its many variants have been employed since the early 1960ies, and quite likely since the sixteenth century."},"2":{"is_punished":1,"date":"1975-12-09","note":"Lorem ipsum and its many variants have been employed since the early 1960ies, and quite likely since the sixteenth century."},"3":{"date":"1980-08-01","note":"Lorem ipsum and its many variants have been employed since the early 1960ies, and quite likely since the sixteenth century.","is_punished":0}}', '{"1":{"date":"2017-10-28","note":"Lorem ipsum and its many variants have been employed since the early 1960ies, and quite likely since the sixteenth century."},"2":{"date":"2017-10-28","note":"Lorem ipsum and its many variants have been employed since the early 1960ies, and quite likely since the sixteenth century."}}', '2017-10-09'),
(6, 'Baron', 'male', 'hobbit', 'Its many variants.', '1938-11-23', 1, 1, 1, 0, 1, '{"1":{"date":"2010-10-28","note":"Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It''s also called placeholder.","is_punished":0}}', '{"1":{"date":"2017-10-28","note":"Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It''s also called placeholder."}}', '2017-10-11'),
(8, 'Gavani', 'female', 'ghost', 'Qwerty', '1918-05-23', 0, 0, 1, 1, 0, '{"1":{"date":"2000-10-12","note":"Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It''s also called placeholder.","is_punished":1}}', '{"1":{"date":"2001-10-28","note":"Lorem ipsum and its many variants have been employed since the early 1960ies, and quite likely since the sixteenth century."},"2":{"date":"1917-12-10","note":"Lorem ipsum and its many variants have been employed since the early 1960ies, and quite likely since the sixteenth century."}}', '2017-10-13'),
(9, 'Semana', 'female', 'elf', 'Sacalamani', '1984-12-12', 0, 0, 2, 0, 2, '{"1":{"is_punished":0,"date":"2015-09-01","note":"Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero. Its words and letters have been changed by addition or removal, so to deliberately render its content nonsensical; it''s not genuine\\/"},"2":{"is_punished":0,"date":"2017-04-12","note":"Lorem ipsum is mostly a part of a Latin text by the classical author and philosopher Cicero. Its words and letters have been changed by addition or removal, so to deliberately render its content nonsensical; it''s not genuine\\/"}}', '{"1":{"date":"2017-10-28","note":"Lorem ipsum is a pseudo-Latin text used in web design, typography, layout, and printing in place of English to emphasise design elements over content. It''s also called placeholder (or filler) text. It''s a convenient tool for mock-ups. It helps to outline the visual elements of a document or presentation."}}', '2017-10-20'),
(10, 'Afahata', 'male', 'elf', 'Arabia', '1996-05-01', 0, 0, 0, 0, 0, '', '{"1":{"date":"1975-12-09","note":"Lorem &quot;ipsum&quot;. O''rely kolo. foo\\/bar.<br \\/>\\r\\n{nano}, (banano), [super]"}}', '2017-10-27'),
(12, 'FooBar', 'kukuruku', 'kozel', 'Mountains', '1900-11-23', 1, 1, 2, 0, 2, '{"1":{"is_punished":0,"date":"1972-02-19","note":"Lorem ipsum is a pseudo-Latin text used in web design, typography."},"2":{"is_punished":0,"date":"1975-12-09","note":"Lorem ipsum is a pseudo-Latin text used in web design, typography."}}', '{"1":{"date":"1975-12-09","note":"Lorem ipsum is a pseudo-Latin text used in web design, typography."},"2":{"date":"1917-12-10","note":"Lorem ipsum is a pseudo-Latin text used in web design, typography."}}', '2017-10-28');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
