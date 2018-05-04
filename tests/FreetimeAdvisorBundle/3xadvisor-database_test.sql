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
-- Structure de la table `place_categories`
--

CREATE TABLE IF NOT EXISTS `3xadvisor_test`.`place_categories` (
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
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Structure de la table `place_advices`
--

CREATE TABLE IF NOT EXISTS `3xadvisor_test`.`place_advices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `place_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(80)  NOT NULL,
  `comment` varchar(255)  NOT NULL,
  `score` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `place_advices_photos`
--

CREATE TABLE IF NOT EXISTS `3xadvisor_test`.`place_advices_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `advice_id` int(11) NOT NULL,
  `name` varchar(100)  NOT NULL DEFAULT 'default.jpg',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



--
-- Structure de la table `user_favorites`
--

CREATE TABLE IF NOT EXISTS `3xadvisor_test`.`user_favorites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Structure de la table `user_hobbies_list`
--

CREATE TABLE IF NOT EXISTS `3xadvisor_test`.`user_hobbies_list` (
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
ADD CONSTRAINT `fk_place_category` FOREIGN KEY (`category_id`) REFERENCES `place_categories` (`id`),
ADD CONSTRAINT `fk_place_city` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`),
ADD CONSTRAINT `fk_place_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `place_advices`
--
ALTER TABLE `3xadvisor_test`.`place_advices`
ADD CONSTRAINT `fk_place_advices_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
ADD CONSTRAINT `fk_place_advices_place` FOREIGN KEY (`place_id`) REFERENCES `place` (`id`);

--
-- Contraintes pour la table `place_advices_photos`
--
ALTER TABLE `3xadvisor_test`.`place_advices_photos`
ADD CONSTRAINT `fk_place_advices_photos_advice_id` FOREIGN KEY (`advice_id`) REFERENCES `place_advices` (`id`),
ADD CONSTRAINT `fk_place_advices_photos_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
ADD CONSTRAINT `fk_place_advices_photos_place_id` FOREIGN KEY (`place_id`) REFERENCES `place` (`id`);


--
-- Contraintes pour la table `user_favorites`
--
ALTER TABLE `3xadvisor_test`.`user_favorites`
ADD CONSTRAINT `fk_user_favorites_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
ADD CONSTRAINT `fk_user_favorites_place_id` FOREIGN KEY (`place_id`) REFERENCES `place` (`id`);

--
-- Contraintes pour la table `user_hobbies_list`
--
ALTER TABLE `3xadvisor_test`.`user_hobbies_list`
ADD CONSTRAINT `fk_user_hobbies_list_third_category_id` FOREIGN KEY (`third_category_id`) REFERENCES `place_categories` (`id`),
ADD CONSTRAINT `fk_user_hobbies_list_second_category_id` FOREIGN KEY (`second_category_id`) REFERENCES `place_categories` (`id`),
ADD CONSTRAINT `fk_user_hobbies_list_first_category_id` FOREIGN KEY (`first_category_id`) REFERENCES `place_categories` (`id`),
ADD CONSTRAINT `fk_user_hobbies_list_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

--
-- Déchargement des données de la table `city`
--

INSERT INTO `3xadvisor_test`.`city` (`id`, `name`, `zipcode`, `area`) VALUES
(1, 'SAINT-DENIS', 97400, 'NORD'),
(2, 'SAINT-PIERRE', 97410, 'SUD'),
(3, 'BRAS-PANON', 97412, 'EST'),
(4, 'CILAOS', 97413, 'SUD'),
(5, 'ENTRE-DEUX', 97414, 'SUD'),
(6, 'LA POSSESSION', 97419, 'OUEST'),
(7, 'LE PORT', 97420, 'OUEST'),
(8, 'LES AVIRONS', 97425, 'SUD'),
(9, 'LES TROIS-BASSINS', 97426, 'OUEST'),
(10, 'ETANG-SALÉ', 97427, 'SUD'),
(11, 'PETIT-ILE', 97429, 'SUD'),
(12, 'LE TAMPON', 97430, 'SUD'),
(13, 'LA PLAINE DES PALMISTES', 97431, 'SUD'),
(14, 'SALAZIE', 97433, 'EST'),
(15, 'SAINT-LEU', 97436, 'OUEST'),
(16, 'SAINTE-MARIE', 97438, 'NORD'),
(17, 'SAINTE-ROSE', 97439, 'EST'),
(18, 'SAINT-ANDRÉ', 97440, 'EST'),
(19, 'SAINT-SUZANNE', 974411, 'EST'),
(20, 'SAINT-PHILLIPPE', 97442, 'SUD'),
(21, 'SAINT-LOUIS', 97450, 'SUD'),
(22, 'SAINT-PAUL', 97460, 'OUEST'),
(23, 'SAINT-BENOIT', 97470, 'EST'),
(24, 'SAINT-JOSEPH', 97480, 'SUD');

--
-- Déchargement des données de la table `user`
--

INSERT INTO `3xAdvisor_test`.`user` (`id`, `city_id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `description`, `birth_date`, `avatar`, `avatar_updated_at`,`created_at`) VALUES
(1, 1, 'user974', 'user974', 'user@test.fr', 'user@test.fr', 1, NULL, '$2y$13$cSIuTklm56v5f/TjbaEhROPvh.iBy11.gTrbhlJRQW1JbHAVcxhui', '2018-04-16 11:07:59', NULL, NULL, 'a:0:{}', 'Bonjour, je suis un simple utilisateur !', '1983-04-06', '5ae0d15ee5f25.jpg', '2018-04-15 17:37:00','2018-04-15 17:37:00');
-- --------------------------------------------------------
--
-- Déchargement des données de la table `place_categories`
--

INSERT INTO `3xadvisor_test`.`place_categories` (`id`, `name`) VALUES
(12, 'CULTURE'),
(11, 'DÉCOUVERTE'),
(3, 'DIVERTISSEMENT'),
(1, 'NATURE'),
(7, 'PIQUE-NIQUE'),
(6, 'RENCONTRE'),
(5, 'REPOS'),
(10, 'RESTAURATION'),
(2, 'SPORT');
--
--
-- Déchargement des données de la table `place`
--

INSERT INTO `3xadvisor_test`.`place` (`id`, `city_id`, `category_id`, `user_id`, `name`, `location`, `description`, `created_at`, `main_photo`) VALUES
(1, 1, 1, 1, 'CASCADE DU CHAUDRON', 'Depuis Saint-Denis, montez en direction de La Bretagne que l\'on traverse. 500 mètres après la fin de l\'agglomération, prenez à droite le Chemin de Bois Rouge. Continuez 600 mètres puis montez à gauche dans le Chemin des Fougères.', 'La Cascade du Chaudron est juste au-dessus de chez nous. Cette cascade est impressionnante après de fortes pluies, mais il vaut mieux que le terrain soit sec pour entreprendre cette marche. Cette balade se fait dans la fraîcheur, le long d\'un rempart abrupt et encaissé, d\'où quelques passages étroits et vertigineux. Il faut compter 1 h pour l\'aller et autant pour le retour.', '2018-04-15 18:03:25', 'chaudron.JPG'),
(2, 15, 12, 1, 'MUSÉE DE STELLA', 'Si vous êtes en voiture, le musée dispose d’un parking. Si vous venez en bus, prenez le bus Kar’Ouest Littoral 2 ou la ligne 48 ou bien le Car Jaune S4 et descendez à l’arrêt École Stella ou Stella. (prévoir entre 3 € et 4 € pour le car/bus aller/retour).', 'Le Musée Stella Matutina, installé dans l\'ancienne usine sucrière du même nom, a ouvert ses portes en 1991. \r\nPendant 20 ans, le public y a découvert les techniques industrielles de la fabrication du sucre de canne, ainsi que des informations sur l\'histoire de La Réunion et de sa population. \r\nLa Région Réunion a entrepris en 2011 une réhabilitation totale du Musée et du site, fondée sur un nouveau projet scientifique et culturel. Stella Matutina dispose de l\'appellation « Musée de France ».', '2018-04-15 18:13:05', 'stella.jpg'),
(3, 21, 5, 1, 'KAZ INSOLITE', 'Kaz Insolite est situé à 1500 mètres d’altitude, au coeur du Parc national de la Réunion dans les Hauts de Saint-Louis. Les bulles sont entourées de la forêt des Makes qui surplombe le cirque naturel de Cilaos.', 'L’hébergement insolite est intégré sur un site d’un hectare dans le sous bois forestier des Hauts de la Réunion. Les quatre suites bulles sont labellisées Gîte de France.\r\n\r\nSous les étoiles, les bulles se fondent dans la forêt de cryptomeria telle la rosée matinale. Implanté sur une parcelle gérée par l’Office National des Forêts, Kaz Insolite est situé à deux pas du coeur du Parc National de la Réunion, site naturel classé au patrimoine mondial de l’UNESCO.\r\n\r\nChacune des bulles repose sur une plateforme sur pilotis. Elle vous offre le plaisir de flâner sous les cryptomerias et les plantes endémiques, tout en respectant leur zone de confort.', '2018-04-15 18:31:54', 'kazinso.jpg'),
(4, 1, 1, 1, 'LE PITON DES NEIGES', 'Il est possible de se lancer à l’assaut de ses flancs mythiques depuis la Plaine des Cafres ou le cirque de Salazie. Mais en général, les valeureux marcheurs partent duIl e cirque de Cilaos, également au centre de l’île. Ils font ensuite halte au seul gît', 'Avec ses 3.071 mètres d\'altitude, le Piton des Neiges est considéré comme le point culminant de l\'océan Indien.\r\nLe volcan, éteint depuis fort longtemps, fascine par sa présence majestueuse au centre de l’île. Point culminant de La Réunion, le Piton des Neiges constitue un très bel objectif de randonnée. L’occasion rêvée d’explorer une merveilleuse nature préservée.', '2018-04-15 19:10:02', 'piton.jpg'),
(5, 24, 7, 1, 'PLAGE DE GRAND ANSE', 'Depuis Saint-Pierre, prendre la N2, suivre la direction « Grande Anse ». Sur la route d’accès à la plage, tourner à gauche sur le parking en face de la maison forestière.', 'Superbe baie bordée de cocotiers, située au pied de Piton Grande Anse. Plage de sable blanc où les familles aiment se retrouver pour un pique-nique. L\'endroit est d\'une grande beauté mais la houle est régulièrement présente et la baignade dangereuse. Cependant, une piscine naturelle a été aménagée, tout au Sud de la plage, afin de pouvoir se baigner en toute sécurité, abrité de la houle par d’énormes roches basaltiques. Le site comprend un parc verdoyant avec des aires de pique-niques, des espaces verts entretenus, un boulodrome, un grand parking, des blocs sanitaires, des allées piétonnes et des camions-bars.', '2018-04-15 18:56:42', 'anse.jpg'),
(6, 10, 2, 1, 'LE GRAND TOUR DE LA FORET', 'Gagner L\'Etang-Salé les Bains - A la sortie de la RN1, garer le véhicule au plus près du premier rond-point au début de la ville - Débuter la boucle par la piste cyclable (fermée par une chaîne) juste en face du parking - Suivre cette piste jusqu\'à ce qu\'', 'Cette randonnée est placée sous le signe de la sécheresse dans cette région sableuse de l\'Etang-Salé où aucune ravine ne coule et où une bonne partie du circuit s\'effectue sur des pistes sableuses où les pieds s\'enfoncent. Cette région est très connue des sportifs des villages alentour qui disposent de nombreux parkings et d\'innombrables pistes qui quadrillent cette Forêt de l\'Etang-Salé. Mais très peu de chances de s\'égarer si on a un minimum de sens de l\'orientation. Les travaux de la route des Tamarins ont apporté quelques petites modifications d\'itinéraire en fin de circuit mais on s\'oriente très bien par rapport à la route ou au bord de mer qu\'on aperçoit souvent dans la descente. Ce circuit peut également s\'effectuer à cheval ou à VTT mais des zones sableuses imposent de bien garder l\'équilibre. Ne pas oublier de boisson pour éliminer le sable microscopique qui s\'insinue partout, même dans la bouche si on parle et qu\'il y a du vent. Au milieu du circuit se situe le parc des Crocodiles. Ne pas oublier de monnaie en cas de visite.', '2018-04-15 19:01:41', 'grand-tour.jpg'),
(7, 22, 10, 1, 'LA BOBINE', 'près de la plage', 'st gilles', '2018-04-26 19:18:04', '5ae225ec082eb.jpg'),
(8, 15, 7, 1, 'FRONT DE MER', 'près du port de st leu', 'lieu atypique', '2018-04-26 19:23:51', '5ae22747c1ed4.jpg'),
(9, 22, 6, 1, 'MARCHÉ DE ST PAUL', 'front de mer', 'bazar', '2018-04-26 19:28:11', '5ae2284b8f934.jpg'),
(10, 18, 3, 1, 'TOURNOI FIFA 18', 'crésonnière', 'sur ps4', '2018-04-26 19:49:08', '5ae22d346a452.png'),
(11, 16, 3, 1, 'CINEPALMES', 'près de jumbo score', 'endroit convivial pour regarder des films dans une totale immersion', '2018-04-26 19:52:15', '5ae22def13497.jpg');

--
-- Déchargement des données de la table `place_advices`
--

INSERT INTO `3xadvisor_test`.`place_advices` (`id`, `place_id`, `user_id`, `title`, `comment`, `score`, `created_at`) VALUES
(1, 1, 1, 'lieu magnifique', 'Suspendisse vestibulum metus vel libero hendrerit, eu lacinia diam molestie. Vestibulum nunc velit, tincidunt non rutrum ac, laoreet id mi. Curabitur eget augue consectetur, sollicitudin urna in, tempus felis. Cras in mauris quis purus consequat condiment', 5, '2018-04-15 18:04:28'),
(2, 2, 1, 'passable..', 'Sed nec placerat arcu, quis varius ligula. Donec eget sapien bibendum, mollis neque et, venenatis sapien. Aenean vitae augue non risus mattis scelerisque. Nunc viverra, massa sit amet finibus sollicitudin, dolor sapien tincidunt tellus, ac congue magna me', 3, '2018-04-15 18:14:00'),
(3, 3, 1, 'dormir sous une nuit étoilé c\'est magique !', 'In diam ante, pharetra eu rhoncus vitae, vehicula non odio. In imperdiet, lorem mollis venenatis pellentesque, ligula odio aliquam purus, fermentum molestie diam sapien quis dui. Aliquam ac augue malesuada nunc venenatis ullamcorper. Pellentesque lacinia', 5, '2018-04-15 18:33:07'),
(4, 4, 1, 'majestueux', 'jamais vu un truc pareil !', 5, '2018-04-15 18:43:44'),
(5, 5, 1, 'endroit agréable', 'dapibus ullamcorper felis fermentum quis. Curabitur at mi vestibulum, fermentum eros in, tempus ipsum. Praesent ut ex elit. Fusce diam dolor, iaculis sit amet elit non, sagittis mattis erat. Mauris eget iaculis massa. Donec in facilisis tellus. Nullam sit', 4, '2018-04-15 18:57:15'),
(6, 6, 1, 'parcours assez difficile', 'Aliquam sit amet felis facilisis urna eleifend ullamcorper ac nec risus. Morbi sodales diam eget eleifend pharetra. Pellentesque faucibus nisi gravida ex ultricies pretium quis vitae nunc. Morbi odio ante, ornare at porttitor sagittis, semper sed nisi. Nu', 2, '2018-04-16 11:21:15'),
(8, 7, 1, 'un cadre fabuleux', 'Devant le lagon de La Réunion, un restaurant très agréable et typique dans lequel nous avons dîné deux fois. Cocktails et nourriture délicieux, cadre magnifique, très romantique...!', 4, '2018-04-26 19:13:09'),
(9, 8, 1, 'barbecue!', 'sympa', 5, '2018-04-26 19:24:25'),
(10, 9, 1, 'samoussa très chaud !', 'etc..', 3, '2018-04-26 19:28:56'),
(11, 10, 1, 'belle journée', 'battue au 3e round', 2, '2018-04-26 19:49:50'),
(12, 11, 1, 'le son dolby atmos !', 'plongé comme si on était dans le film !', 5, '2018-04-26 19:53:14');

--
-- Déchargement des données de la table `place_advices_photos`
--

INSERT INTO `3xadvisor_test`.`place_advices_photos` (`id`, `user_id`, `place_id`, `advice_id`, `name`, `created_at`) VALUES
(1, 1, 6, 6, 'kk.jpg', '2018-04-16 11:21:53'),
(2, 1, 5, 5, '5adf01457abd3.jpg', '2018-04-24 10:04:53'),
(3, 1, 4, 4, '5adf01b640e92.jpg', '2018-04-24 10:06:46'),
(4, 1, 3, 3, '5adf020075aab.jpg', '2018-04-24 10:08:00'),
(5, 1, 2, 2, '5adf022cc6603.jpg', '2018-04-24 10:08:44'),
(6, 1, 7, 8, '5ae22510eee23.jpg', '2018-04-26 19:14:24'),
(7, 1, 8, 9, '5ae2277f0f4a5.jpg', '2018-04-26 19:24:47'),
(8, 1, 9, 10, '5ae2288f8a041.jpg', '2018-04-26 19:29:19'),
(9, 1, 10, 11, '5ae22d7507f23.jpg', '2018-04-26 19:50:13'),
(10, 1, 11, 12, '5ae22e35b3363.jpeg', '2018-04-26 19:53:25');
-- Déchargement des données de la table `user_favorites`
--

INSERT INTO `3xadvisor_test`.`user_favorites` (`id`, `user_id`, `place_id`,`created_at`) VALUES
(2, 1, 4,'2018-04-16 11:21:33');
--
-- Déchargement des données de la table `user_hobbies_list`
--

INSERT INTO `3xadvisor_test`.`user_hobbies_list` (`id`, `first_category_id`, `second_category_id`, `third_category_id`, `user_id`,`updated_at`) VALUES
(1, 1, 3, 10, 1,'2018-04-16 11:21:33');
