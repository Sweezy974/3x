-- créé la bdd 3xadvisor_test
CREATE DATABASE IF NOT EXISTS 3xadvisor_test CHARACTER SET 'utf8';
-- utilise la bdd 33xadvisor_test
USE `3xadvisor_test`;
-- --------------------------------------------------------

--
-- Structure de la table `city`
--
CREATE TABLE IF NOT EXISTS `3xadvisor_test`.`city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80)  NOT NULL,
  `zipcode` int(11) NOT NULL,
  `area` varchar(5)  NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE IF NOT EXISTS `3xadvisor_test`.`category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50)  NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `3xadvisor_test`.`user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `username` varchar(180)  NOT NULL,
  `username_canonical` varchar(180)  NOT NULL,
  `email` varchar(180)  NOT NULL,
  `email_canonical` varchar(180)  NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255)  DEFAULT NULL,
  `password` varchar(255)  NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180)  DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext  NOT NULL COMMENT '(DC2Type:array)',
  `description` varchar(255)  DEFAULT NULL,
  `birth_date` date NOT NULL,
  `avatar` varchar(255)  NOT NULL DEFAULT 'default.jpg',
  `avatar_updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



--
-- Structure de la table `place`
--

CREATE TABLE IF NOT EXISTS `3xadvisor_test`.`place` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(80)  NOT NULL,
  `location` varchar(255)  NOT NULL,
  `description` longtext  NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `main_photo` varchar(100)  NOT NULL DEFAULT 'default.jpg',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Structure de la table `advice`
--

CREATE TABLE IF NOT EXISTS `3xadvisor_test`.`advice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `place_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(80)  NOT NULL,
  `comment` varchar(255)  NOT NULL,
  `score` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime  DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

CREATE TABLE IF NOT EXISTS `3xadvisor_test`.`photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `advice_id` int(11) NOT NULL,
  `name` varchar(100)  NOT NULL DEFAULT 'default.jpg',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



--
-- Structure de la table `favorite`
--

CREATE TABLE IF NOT EXISTS `3xadvisor_test`.`favorite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Structure de la table `hobbies_list`
--

CREATE TABLE IF NOT EXISTS `3xadvisor_test`.`hobbies_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_category_id` int(11) NOT NULL,
  `second_category_id` int(11) NOT NULL,
  `third_category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `user`
--
ALTER TABLE `3xadvisor_test`.`user`
ADD CONSTRAINT `fk_user` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`);
--
-- Contraintes pour la table `place`
--
ALTER TABLE `3xadvisor_test`.`place`
ADD CONSTRAINT `fk_place_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
ADD CONSTRAINT `fk_place_city` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`),
ADD CONSTRAINT `fk_place_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `advice`
--
ALTER TABLE `3xadvisor_test`.`advice`
ADD CONSTRAINT `fk_advice_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
ADD CONSTRAINT `fk_advice_place` FOREIGN KEY (`place_id`) REFERENCES `place` (`id`);

--
-- Contraintes pour la table `photo`
--
ALTER TABLE `3xadvisor_test`.`photo`
ADD CONSTRAINT `fk_photo_advice_id` FOREIGN KEY (`advice_id`) REFERENCES `advice` (`id`),
ADD CONSTRAINT `fk_photo_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
ADD CONSTRAINT `fk_photo_place_id` FOREIGN KEY (`place_id`) REFERENCES `place` (`id`);


--
-- Contraintes pour la table `favorite`
--
ALTER TABLE `3xadvisor_test`.`favorite`
ADD CONSTRAINT `fk_favorite_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
ADD CONSTRAINT `fk_favorite_place_id` FOREIGN KEY (`place_id`) REFERENCES `place` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `hobbies_list`
--
ALTER TABLE `3xadvisor_test`.`hobbies_list`
ADD CONSTRAINT `fk_hobbies_list_third_category_id` FOREIGN KEY (`third_category_id`) REFERENCES `category` (`id`),
ADD CONSTRAINT `fk_hobbies_list_second_category_id` FOREIGN KEY (`second_category_id`) REFERENCES `category` (`id`),
ADD CONSTRAINT `fk_hobbies_list_first_category_id` FOREIGN KEY (`first_category_id`) REFERENCES `category` (`id`),
ADD CONSTRAINT `fk_hobbies_list_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;
