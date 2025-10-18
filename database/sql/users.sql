-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.7.39 - MySQL Community Server (GPL)
-- Операционная система:         Win64
-- HeidiSQL Версия:              12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Дамп структуры базы данных tmtourism
CREATE DATABASE IF NOT EXISTS `tmtourism` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `tmtourism`;

-- Дамп структуры для таблица tmtourism.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы tmtourism.users: ~3 rows (приблизительно)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
	(1, 'bobo', 'bobo@tm.tm', '2025-10-06 22:45:47', '$2y$12$raQLRI0YfxwdIws01YVmquX30vDj/A3JJGpPyS/SNSyeDVY3aGQmS', 'fH6usC3RT1rK5AOE8MYp1Z4VVxa3fjPB1pxdOkzyq4Lv9q9SZdjObU4OOU7y', '2025-10-06 22:45:47', '2025-10-06 22:45:47', 'admin'),
	(2, 'user', 'bobo12@tm.tm', '2025-10-06 22:45:47', '$2y$12$UC9LU9AVkA.wkIm0NuzaM.uNpBPyaHfjajo6wX3ufm4T2nRRrBKXm', 'r7WCueP6dX', '2025-10-06 22:45:48', '2025-10-06 22:45:48', 'user'),
	(3, 'shohrateke', 'shohrateke@tm.tm', '2025-10-06 22:45:48', '$2y$12$CqM/lInZ3HYX9TaPzqa7HOj8pazOXx92IwDPePyUc6fPOlVAnd3Tu', 'tKdYqRUM6N', '2025-10-06 22:45:48', '2025-10-06 22:45:48', 'user');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
