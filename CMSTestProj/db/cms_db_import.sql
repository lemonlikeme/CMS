-- Combined SQL file for easy import of the CMS database structure

-- First drop tables if they exist
DROP TABLE IF EXISTS `user_assets`;
DROP TABLE IF EXISTS `site_preferences`;
DROP TABLE IF EXISTS `users`;

-- Create tables in order of dependencies

-- Users table first (parent table)
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert sample users
INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(8, 'Lemonlikeme', '11einstein.karlmavericklemon@gmail.com', '$2y$10$clxbaKU6HepwTlplTgfpreafNlTW1/kdw7/RHKy5Zt8wJAezgGKoC'),
(10, 'Lemonlikeme2', 'lemonkarlmaverick@gmail.com', '$2y$10$7GCgCVSNVRDQCdMWEUDNu.u9.zuJV80vgWV/aGzYSCmHPVCV4p4Se'),
(12, 'Lemon', 'kmavericklemon@gmail.com', '$2y$10$jPQ5n2uoeCJ/tKiL7cm12uTRFj05Fm9Ncev5Fk4Lvw0kErD3.1l9K');

-- Site preferences table (references users table)
CREATE TABLE `site_preferences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `site_title` varchar(100) DEFAULT NULL,
  `homepage_sections` text DEFAULT NULL,
  `pages_selected` text DEFAULT NULL,
  `color_scheme` text DEFAULT NULL,
  `selected_font` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `site_preferences_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- User assets table (references users table)
CREATE TABLE `user_assets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `page_id` varchar(100) DEFAULT NULL,
  `asset_id` varchar(100) NOT NULL,
  `asset_type` varchar(50) NOT NULL,
  `asset_data` longtext NOT NULL,
  `position` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_assets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; 