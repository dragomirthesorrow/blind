-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Сен 02 2016 г., 11:40
-- Версия сервера: 10.1.13-MariaDB
-- Версия PHP: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `blind`
--

-- --------------------------------------------------------

--
-- Структура таблицы `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime DEFAULT NULL,
  `monitor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `events`
--

INSERT INTO `events` (`id`, `start_time`, `end_time`, `monitor_id`) VALUES
(1, '2016-09-01 12:55:28', '2016-09-01 12:58:07', 1),
(2, '2016-09-01 16:03:40', '2016-09-02 10:07:36', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `log_record`
--

CREATE TABLE `log_record` (
  `id` int(255) NOT NULL,
  `id_monitor` int(255) NOT NULL,
  `pid` int(255) NOT NULL,
  `start_time` datetime NOT NULL,
  `finished` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `log_record`
--

INSERT INTO `log_record` (`id`, `id_monitor`, `pid`, `start_time`, `finished`) VALUES
(1, 1, 4556, '2016-09-02 11:24:42', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `monitors`
--

CREATE TABLE `monitors` (
  `id` int(10) NOT NULL,
  `name` text NOT NULL,
  `path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `monitors`
--

INSERT INTO `monitors` (`id`, `name`, `path`) VALUES
(1, 'Cam_01', 'rtsp://video:123456@172.16.0.199:7070/axis-media/media.amp');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `log_record`
--
ALTER TABLE `log_record`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `monitors`
--
ALTER TABLE `monitors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `log_record`
--
ALTER TABLE `log_record`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `monitors`
--
ALTER TABLE `monitors`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
