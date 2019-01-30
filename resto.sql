-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 30 Janvier 2019 à 14:19
-- Version du serveur :  5.7.25-0ubuntu0.16.04.2
-- Version de PHP :  7.0.32-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `resto`
--
CREATE DATABASE IF NOT EXISTS `resto` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `resto`;

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `category`
--

INSERT INTO `category` (`id`, `name`, `description`) VALUES
(1, 'Entrée', 'Pour se mettre en appétit avant le plat principal'),
(2, 'Plat principal', 'L\'apothéose!!!'),
(3, 'Dessert', 'Redescendre en douceur...'),
(4, 'Boisson', 'Accompagner les festivités avec panache!');

-- --------------------------------------------------------

--
-- Structure de la table `commands`
--

CREATE TABLE `commands` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `command_details`
--

CREATE TABLE `command_details` (
  `id` int(11) NOT NULL,
  `command_id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_description` longtext COLLATE utf8_unicode_ci,
  `ProductImage` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` double NOT NULL,
  `stock` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `menu`
--

INSERT INTO `menu` (`id`, `product_name`, `product_description`, `ProductImage`, `price`, `stock`, `category_id`) VALUES
(1, 'campione', 'Viande hachée, oeuf', 'test.jpeg', 12.5, 23, 2),
(2, 'campione', 'Viande hachée, oeuf', 'fruits-de-mer.jpg.jpeg', 12.5, 23, 2),
(3, 'marguerita', 'Fromage', 'marguerita.jpg', 10, 23, 2),
(4, 'orientale', 'merguez', 'orientale.jpg', 11, 21, 2),
(5, 'mexicaine', 'merguez, poivron', 'mexicaine.jpg', 12.5, 21, 2),
(6, 'Sicilienne', 'Anchois', 'sicilienne.jpg', 11, 8, 2),
(7, 'Calamars frits', 'Calamar', 'calamars-frits.jpg', 7, 13, 1),
(8, 'Jalapenos', 'Entrée mexicaine', 'jalapenos.jpg', 7, 21, 1),
(9, 'mozza stick', 'Beignet de mozzarella', 'mozza-stick.jpg', 6, 21, 1),
(10, 'Croquette de mozarella', 'Croquette de mozarella', 'mozza-stick (1).jpg', 4, 31, 1),
(11, 'Onion rings', 'Onion rings', 'onions-rings.jpg', 6, 21, 1),
(12, 'Swiss cheese', 'Beignet au fromage suisse', 'swiss-cheesy.jpg', 8, 7, 1),
(13, 'Glace 1', 'Vanille', 'haeagen-dazs-100-ml.jpg', 6, 21, 3),
(14, 'Glace 2', 'Speculos', 'haeagen-dazs-caramel-biscuit-cream.jpg', 6, 21, 3),
(15, 'Glace 3', 'Cookie', 'haeagen-dazs-cookies-cream.jpg', 6, 21, 1),
(16, 'Glace 4', 'Fondant chocolat', 'haeagen-dazs-creme-brulee.jpg', 6, 21, 3),
(17, 'Glace 5', 'Noix macadamia', 'haeagen-dazs-macadamia.jpg', 6, 21, 3),
(18, 'Glace 6', 'Brownie', 'haeagen-dazs-vanille-caramel-brownie.jpg', 6, 21, 4),
(19, 'Perrier', 'Canette', 'perrier.jpg', 1, 21, 4),
(20, '7 up', 'Canette', '7up.jpg', 1, 21, 4),
(21, 'Pepsi', 'Canette', '7up-cherry.jpg', 1, 21, 4);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `role_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_64C19C15E237E06` (`name`);

--
-- Index pour la table `commands`
--
ALTER TABLE `commands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9A3E132CA76ED395` (`user_id`);

--
-- Index pour la table `command_details`
--
ALTER TABLE `command_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9D4C586933E1689A` (`command_id`),
  ADD KEY `IDX_9D4C58694ACC9A20` (`card_id`);

--
-- Index pour la table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7D053A9312469DE2` (`category_id`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D64924A232CF` (`user_name`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  ADD KEY `IDX_8D93D64957698A6A` (`role`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `commands`
--
ALTER TABLE `commands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `command_details`
--
ALTER TABLE `command_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `commands`
--
ALTER TABLE `commands`
  ADD CONSTRAINT `FK_9A3E132CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `command_details`
--
ALTER TABLE `command_details`
  ADD CONSTRAINT `FK_9D4C586933E1689A` FOREIGN KEY (`command_id`) REFERENCES `commands` (`id`),
  ADD CONSTRAINT `FK_9D4C58694ACC9A20` FOREIGN KEY (`card_id`) REFERENCES `menu` (`id`);

--
-- Contraintes pour la table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `FK_7D053A9312469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D64957698A6A` FOREIGN KEY (`role`) REFERENCES `role` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
