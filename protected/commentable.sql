-- phpMyAdmin SQL Dump
-- version 3.4.3.1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Авг 11 2011 г., 12:40
-- Версия сервера: 5.1.44
-- Версия PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `commentable`
--

-- --------------------------------------------------------

--
-- Структура таблицы `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `article`
--

INSERT INTO `article` (`id`, `title`, `text`) VALUES
(1, 'test test', 'Содержимое тестовой записи 1'),
(2, 'blah blah', 'Содержимое тестовой записи 2');

-- --------------------------------------------------------

--
-- Структура таблицы `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `text` text NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comment_comment1` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `comment`
--

INSERT INTO `comment` (`id`, `name`, `text`, `date`, `parent_id`) VALUES
(1, '1', 'Содержимое тестовой записи 1', '2011-07-03 08:21:25', NULL),
(2, '2', 'Содержимое тестовой записи 2', '2011-07-03 08:21:25', NULL),
(3, '3', 'Содержимое тестовой записи 3', '2011-07-03 08:21:25', NULL),
(4, '4', 'Содержимое тестовой записи 4', '2011-07-03 08:21:25', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `comment_relation`
--

CREATE TABLE IF NOT EXISTS `comment_relation` (
  `model_id` int(11) NOT NULL,
  `model_name` varchar(200) NOT NULL,
  `comment_id` int(11) NOT NULL,
  PRIMARY KEY (`model_id`,`model_name`,`comment_id`),
  KEY `fk_table1_comment1` (`comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comment_relation`
--

INSERT INTO `comment_relation` (`model_id`, `model_name`, `comment_id`) VALUES
(1, 'Article', 1),
(2, 'Article', 3),
(2, 'Article', 4);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `comment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `comment_relation`
--
ALTER TABLE `comment_relation`
  ADD CONSTRAINT `fk_table1_comment1` FOREIGN KEY (`comment_id`) REFERENCES `comment` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
