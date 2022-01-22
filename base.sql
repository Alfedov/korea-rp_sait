-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.7.13-log - MySQL Community Server (GPL)
-- ОС Сервера:                   Win64
-- HeidiSQL Версия:              9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры для таблица grandrp.log_auth
DROP TABLE IF EXISTS `log_auth`;
CREATE TABLE IF NOT EXISTS `log_auth` (
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `server` varchar(128) NOT NULL,
  `date` varchar(128) NOT NULL,
  `ip` varchar(128) NOT NULL,
  `browser` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;


-- Дамп структуры для таблица grandrp.news
DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '0',
  `html_preview` text NOT NULL,
  `thumbnail` varchar(255) NOT NULL DEFAULT '0',
  `created_at` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы grandrp.news: ~1 rows (приблизительно)
DELETE FROM `news`;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` (`id`, `title`, `html_preview`, `thumbnail`, `created_at`) VALUES
	(11, 'Технические работы форума и сайта', '<span style="background-color: rgb(51, 204, 0);">Отформатированный текст добавленной новости</span>', 'https://pp.vk.me/c633717/v633717133/373bb/JarcYkDAoBo.jpg', '1484860317');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;

-- Дамп структуры для таблица grandrp.payments
DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(55) NOT NULL AUTO_INCREMENT,
  `acc` int(55) DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  `time` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `server` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
