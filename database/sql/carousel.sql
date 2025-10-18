USE `tmtourism`;

-- Дамп структуры для таблица tmtourism.carousel_slides
DROP TABLE IF EXISTS `carousel_slides`;
CREATE TABLE IF NOT EXISTS `carousel_slides` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `button_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы tmtourism.carousel_slides: ~2 rows (приблизительно)
DELETE FROM `carousel_slides`;
INSERT INTO `carousel_slides` (`id`, `title`, `description`, `image`, `button_text`, `button_link`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
	(6, 'Врата Ада: Путешествие к Дарвазе', 'Погрузитесь в огненное сердце пустыни Каракумы. Тур, который меняет представление о мире.', 'carousel/1760056973.jpg', 'Смотреть туры в Дарвазу', 'http://tmtur.loc/', 1, 1, '2025-10-09 21:42:53', '2025-10-09 23:45:14'),
	(7, 'Эхо Великого Шелкового пути', 'Откройте для себя руины древнего Мерва и Нисы. Исследуйте наследие цивилизаций.', 'carousel/1760057032.jpg', 'Выбрать исторический маршрут', 'http://tmtur.loc', 2, 1, '2025-10-09 21:43:52', '2025-10-09 21:43:52'),
	(8, 'Ахал-Теке: Знакомство с Небесными Конями', 'Увидьте легендарных скакунов Туркменистана — символ нации и ее гордость.', 'carousel/1760057091.jpg', 'Планировать индивидуальный тур', 'http://tmtur.loc', 3, 1, '2025-10-09 21:44:51', '2025-10-09 21:44:51');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
