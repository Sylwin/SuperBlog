CREATE TABLE `users` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `username` varchar(50) NOT NULL,
 `email` varchar(50) NOT NULL,
 `password` varchar(255) NOT NULL,
 `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
 PRIMARY KEY (`id`)
);

CREATE TABLE `posts` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `post_title` varchar(255) NOT NULL,
 `description` text NOT NULL,
 `post_text` text NOT NULL,
 `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
 `modification_date` timestamp NULL DEFAULT NULL,
 `user_id` int(11) DEFAULT NULL,
 `published` tinyint(1) NOT NULL,
 `image` varchar(255) NOT NULL,
 PRIMARY KEY (`id`),
 KEY `fk_name` (`user_id`),
 CONSTRAINT `fk_name` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
);

CREATE TABLE `topics` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `name` varchar(255) NOT NULL,
 PRIMARY KEY (`id`)
);

CREATE TABLE `post_topic` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `post_id` int(11) NOT NULL,
 `topic_id` int(11) NOT NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `post_u` (`post_id`),
 KEY `topic_id_con` (`topic_id`),
 CONSTRAINT `post_id_con` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `topic_id_con` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);