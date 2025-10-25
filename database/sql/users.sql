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


-- Дамп структуры базы данных rgtournament
CREATE DATABASE IF NOT EXISTS `rgtournament` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `rgtournament`;

-- Дамп структуры для таблица rgtournament.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.clubs
CREATE TABLE IF NOT EXISTS `clubs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club_id` int(11) DEFAULT NULL,
  `club_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8mb4 AVG_ROW_LENGTH=273 ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.cs2_maps
CREATE TABLE IF NOT EXISTS `cs2_maps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AVG_ROW_LENGTH=2340 ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.events
CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club_id` int(11) DEFAULT NULL,
  `game_id` int(11) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `date_from` datetime DEFAULT NULL,
  `date_to` datetime DEFAULT NULL,
  `token` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=239 DEFAULT CHARSET=utf8mb4 AVG_ROW_LENGTH=163 ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.events_copy
CREATE TABLE IF NOT EXISTS `events_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club_id` int(11) DEFAULT NULL,
  `game_id` varchar(10) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `date_from` datetime DEFAULT NULL,
  `date_to` datetime DEFAULT NULL,
  `token` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.events_season_rating
CREATE TABLE IF NOT EXISTS `events_season_rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) DEFAULT NULL,
  `player_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5636 DEFAULT CHARSET=utf8mb4 AVG_ROW_LENGTH=50 ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.games
CREATE TABLE IF NOT EXISTS `games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `team_size` smallint(5) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AVG_ROW_LENGTH=5461 ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.game_matches
CREATE TABLE IF NOT EXISTS `game_matches` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `game_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `match_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `match_score` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_scan` datetime DEFAULT NULL,
  `col_scan` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) unsigned NOT NULL,
  `player_id` int(11) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `game_matches_player_id_index` (`player_id`) USING BTREE,
  KEY `game_matches_user_id_index` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.join_requests
CREATE TABLE IF NOT EXISTS `join_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `player_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `status` enum('pending','accepted','rejected') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `player_id` (`player_id`,`team_id`),
  KEY `join_requests_ibfk_2` (`team_id`),
  CONSTRAINT `join_requests_ibfk_1` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `join_requests_ibfk_2` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AVG_ROW_LENGTH=16384;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.live_match
CREATE TABLE IF NOT EXISTS `live_match` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team1_id` int(11) NOT NULL,
  `team2_id` int(11) NOT NULL,
  `status` enum('map_voting','ready_check','live','finished') COLLATE utf8mb4_unicode_ci DEFAULT 'map_voting',
  `selected_map_id` bigint(20) unsigned DEFAULT NULL,
  `match_server_id` bigint(20) unsigned DEFAULT NULL,
  `server_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_voting_team` int(11) DEFAULT NULL,
  `current_voter` enum('team1','team2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'team1',
  PRIMARY KEY (`id`),
  KEY `live_match_ibfk_1` (`team1_id`),
  KEY `live_match_ibfk_2` (`team2_id`),
  CONSTRAINT `live_match_ibfk_1` FOREIGN KEY (`team1_id`) REFERENCES `teams` (`id`),
  CONSTRAINT `live_match_ibfk_2` FOREIGN KEY (`team2_id`) REFERENCES `teams` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2762 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AVG_ROW_LENGTH=8192 ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.live_match_banned_maps
CREATE TABLE IF NOT EXISTS `live_match_banned_maps` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `match_id` bigint(20) unsigned NOT NULL,
  `map_id` bigint(20) unsigned NOT NULL,
  `team_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `live_match_banned_maps_match_id_index` (`match_id`),
  KEY `live_match_banned_maps_map_id_index` (`map_id`),
  KEY `live_match_banned_maps_team_id_index` (`team_id`)
) ENGINE=InnoDB AUTO_INCREMENT=574 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.live_match_ready
CREATE TABLE IF NOT EXISTS `live_match_ready` (
  `match_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `is_ready` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`match_id`,`player_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AVG_ROW_LENGTH=4096 ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.map_votes
CREATE TABLE IF NOT EXISTS `map_votes` (
  `match_id` int(11) NOT NULL,
  `map_id` int(11) NOT NULL,
  `banned_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`match_id`,`map_id`),
  KEY `map_votes_ibfk_2` (`map_id`),
  KEY `map_votes_ibfk_3` (`banned_by`),
  CONSTRAINT `map_votes_ibfk_1` FOREIGN KEY (`match_id`) REFERENCES `live_match` (`id`),
  CONSTRAINT `map_votes_ibfk_2` FOREIGN KEY (`map_id`) REFERENCES `cs2_maps` (`id`),
  CONSTRAINT `map_votes_ibfk_3` FOREIGN KEY (`banned_by`) REFERENCES `teams` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.matches
CREATE TABLE IF NOT EXISTS `matches` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `club_id` int(11) DEFAULT '0',
  `player_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `log` text,
  `log_gameover` text,
  `victory` int(11) DEFAULT '0',
  `score` int(11) DEFAULT '0',
  `math_score` varchar(45) DEFAULT NULL,
  `current_voting_team` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_player_id` (`player_id`),
  KEY `idx_player_date` (`player_id`,`date`)
) ENGINE=InnoDB AUTO_INCREMENT=46219 DEFAULT CHARSET=utf8mb4 AVG_ROW_LENGTH=2996 ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.matches_dota2
CREATE TABLE IF NOT EXISTS `matches_dota2` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `club_id` int(11) DEFAULT '0',
  `player_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `log` longtext,
  `log_gameover` longtext,
  `victory` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `math_score` varchar(45) DEFAULT NULL,
  `match_id` bigint(20) DEFAULT NULL,
  `hero_id` int(11) DEFAULT NULL,
  `date_scan` datetime DEFAULT NULL,
  `col_scan` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_player_date` (`player_id`,`date`),
  KEY `idx_player_id` (`player_id`),
  KEY `idx_player_date_victory` (`player_id`,`date`,`victory`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AVG_ROW_LENGTH=14918 ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.matches_pubg
CREATE TABLE IF NOT EXISTS `matches_pubg` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `club_id` int(11) DEFAULT '0',
  `player_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `log` text,
  `log_gameover` text,
  `victory` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `math_score` varchar(45) DEFAULT '0/0',
  `date_scan` datetime DEFAULT NULL,
  `col_scan` int(11) DEFAULT '0',
  `gamemode` varchar(45) DEFAULT NULL,
  `mapname` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_player_date` (`player_id`,`date`),
  KEY `idx_player_id` (`player_id`),
  KEY `idx_player_date_victory` (`player_id`,`date`,`victory`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AVG_ROW_LENGTH=1503 ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.matchmaking
CREATE TABLE IF NOT EXISTS `matchmaking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('searching','matched') COLLATE utf8mb4_unicode_ci DEFAULT 'searching',
  PRIMARY KEY (`id`),
  KEY `matchmaking_ibfk_1` (`team_id`),
  KEY `matchmaking_ibfk_2` (`game_id`),
  CONSTRAINT `matchmaking_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`),
  CONSTRAINT `matchmaking_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.match_results
CREATE TABLE IF NOT EXISTS `match_results` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `match_id` bigint(20) unsigned NOT NULL,
  `player_id` int(10) unsigned NOT NULL,
  `victory` tinyint(1) NOT NULL DEFAULT '0',
  `round` int(11) NOT NULL DEFAULT '1',
  `start_math` tinyint(1) NOT NULL DEFAULT '0',
  `add_score` int(11) NOT NULL DEFAULT '0',
  `details` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `match_results_match_id_index` (`match_id`),
  KEY `match_results_player_id_index` (`player_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.match_servers
CREATE TABLE IF NOT EXISTS `match_servers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `port_game` smallint(5) unsigned NOT NULL,
  `port_rcon` smallint(5) unsigned NOT NULL,
  `rcon_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `busy` tinyint(1) NOT NULL DEFAULT '0',
  `last_used` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_unique_ports` (`ip`,`port_game`,`port_rcon`),
  UNIQUE KEY `idx_unique_ip_port` (`ip`,`port_game`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.match_server_processes
CREATE TABLE IF NOT EXISTS `match_server_processes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `match_server_id` bigint(20) unsigned NOT NULL,
  `match_id` int(11) NOT NULL,
  `pid` int(10) unsigned NOT NULL,
  `script_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `map_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `server_password` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('running','finished','failed') COLLATE utf8mb4_unicode_ci DEFAULT 'running',
  `exit_code` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.players
CREATE TABLE IF NOT EXISTS `players` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club_id` varchar(100) DEFAULT NULL,
  `client_id` varchar(100) DEFAULT NULL,
  `client_nick` varchar(100) DEFAULT NULL,
  `client_hash` varchar(100) DEFAULT NULL,
  `client_password` varchar(100) DEFAULT NULL,
  `auth_token` varchar(100) DEFAULT NULL,
  `auth_token_from_date` datetime DEFAULT NULL,
  `client_status` varchar(10) DEFAULT 'web',
  `change_password` tinyint(1) DEFAULT '0',
  `remember_token` tinyint(4) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_seen_at` timestamp NULL DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_client_nick` (`client_nick`)
) ENGINE=InnoDB AUTO_INCREMENT=1690 DEFAULT CHARSET=utf8mb4 AVG_ROW_LENGTH=137 ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.rating
CREATE TABLE IF NOT EXISTS `rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club_id` int(11) DEFAULT NULL,
  `player_id` int(11) DEFAULT NULL,
  `season_id` int(11) DEFAULT NULL,
  `game_id` varchar(10) DEFAULT NULL,
  `game_rating` int(11) DEFAULT NULL,
  `game_now` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4844 DEFAULT CHARSET=utf8mb4 AVG_ROW_LENGTH=47 ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.script_log
CREATE TABLE IF NOT EXISTS `script_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `script_name` varchar(50) DEFAULT NULL,
  `log` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_last_activity_index` (`last_activity`),
  KEY `sessions_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AVG_ROW_LENGTH=16384;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.teams
CREATE TABLE IF NOT EXISTS `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `game_id` int(11) NOT NULL,
  `captain_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT '10',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_searching` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`game_id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AVG_ROW_LENGTH=3276 ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.team_invitations
CREATE TABLE IF NOT EXISTS `team_invitations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `team_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `invited_by` int(11) NOT NULL,
  `status` enum('pending','accepted','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `team_invitations_team_id_player_id_status_unique` (`team_id`,`player_id`,`status`),
  KEY `team_invitations_invited_by_foreign` (`invited_by`),
  KEY `team_invitations_player_id_foreign` (`player_id`),
  CONSTRAINT `team_invitations_invited_by_foreign` FOREIGN KEY (`invited_by`) REFERENCES `players` (`id`) ON DELETE CASCADE,
  CONSTRAINT `team_invitations_player_id_foreign` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`) ON DELETE CASCADE,
  CONSTRAINT `team_invitations_team_id_foreign` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.team_members
CREATE TABLE IF NOT EXISTS `team_members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `player_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `role` enum('captain','member') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`,`player_id`,`team_id`),
  KEY `team_members_ibfk_1` (`player_id`),
  KEY `team_members_ibfk_2` (`team_id`),
  CONSTRAINT `team_members_ibfk_1` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`),
  CONSTRAINT `team_members_ibfk_2` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AVG_ROW_LENGTH=1820 ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица rgtournament.__table_transfer_progress
CREATE TABLE IF NOT EXISTS `__table_transfer_progress` (
  `name` varchar(255) NOT NULL,
  `lsn` bigint(20) DEFAULT NULL,
  `status` enum('SnapshotWait','SyncWait','InSync') DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AVG_ROW_LENGTH=1820 ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
