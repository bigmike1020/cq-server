CREATE TABLE `global` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `key` TEXT UNIQUE,
  `value` TEXT,
  PRIMARY KEY (`id`)
)

INSERT INTO global (key, value) VALUES ('version', 1)

CREATE TABLE `pictures` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `rel_path` TEXT NOT NULL,
  `user_id` INT NOT NULL,
  `question` TEXT,
  `upload_date` TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
)

CREATE TABLE `answers` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `picture_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `answer` TEXT NOT NULL,
  `date` TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `picture_id` (`picture_id`)
)

CREATE TABLE `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` TEXT NOT NULL,
  `join_date` TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
)