-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mer 29 Novembre 2017 à 03:13
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `soccer`
--
DROP DATABASE `soccer`;
CREATE DATABASE IF NOT EXISTS `soccer` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `soccer`;

-- --------------------------------------------------------

--
-- Structure de la table `dates_match`
--

DROP TABLE IF EXISTS `dates_match`;
CREATE TABLE `dates_match` (
  `date_match` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vider la table avant d'insérer `dates_match`
--

TRUNCATE TABLE `dates_match`;
--
-- Contenu de la table `dates_match`
--

INSERT INTO `dates_match` (`date_match`) VALUES
('2017-10-28 06:45:00'),
('2017-11-04 06:45:00'),
('2017-11-11 06:45:00'),
('2017-11-18 06:45:00'),
('2017-11-25 06:45:00'),
('2017-12-02 06:45:00'),
('2017-12-09 06:45:00'),
('2017-12-16 06:45:00'),
('2017-12-23 06:45:00'),
('2017-12-30 06:45:00'),
('2018-01-06 06:45:00'),
('2018-01-13 06:45:00'),
('2018-01-20 06:45:00'),
('2018-01-27 06:45:00'),
('2018-02-03 06:45:00'),
('2018-02-10 06:45:00'),
('2018-02-17 06:45:00'),
('2018-02-24 06:45:00'),
('2018-03-03 06:45:00'),
('2018-03-10 06:45:00'),
('2018-03-17 06:45:00'),
('2018-03-24 06:45:00'),
('2018-03-31 06:45:00'),
('2018-04-07 06:45:00'),
('2018-04-14 06:45:00'),
('2018-04-21 06:45:00'),
('2018-04-28 06:45:00'),
('2018-05-05 06:45:00'),
('2018-05-12 06:45:00'),
('2018-05-19 06:45:00');

-- --------------------------------------------------------

--
-- Structure de la table `equipe`
--

DROP TABLE IF EXISTS `equipe`;
CREATE TABLE `equipe` (
  `id` int(11) NOT NULL,
  `couleur` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vider la table avant d'insérer `equipe`
--

TRUNCATE TABLE `equipe`;
--
-- Contenu de la table `equipe`
--

INSERT INTO `equipe` (`id`, `couleur`) VALUES
(1, 'verte'),
(2, 'orange');

-- --------------------------------------------------------

--
-- Structure de la table `joueur`
--

DROP TABLE IF EXISTS `joueur`;
CREATE TABLE `joueur` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `password` text NOT NULL,
  `is_admin` int(1) NOT NULL DEFAULT '0',
  `attaque` int(3) NOT NULL DEFAULT '0',
  `defense` int(3) NOT NULL DEFAULT '0',
  `milieu` int(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vider la table avant d'insérer `joueur`
--

TRUNCATE TABLE `joueur`;
--
-- Contenu de la table `joueur`
--

INSERT INTO `joueur` (`id`, `nom`, `email`, `telephone`, `password`, `is_admin`, `attaque`, `defense`, `milieu`) VALUES
(1, 'Moussa', 'moussa.thimbo@gmail.com', '5146010883', '', 0, 2, 7, 7),
(2, 'Walid', NULL, NULL, '', 0, 2, 7, 7),
(3, 'Ibrahim', NULL, NULL, '', 0, 2, 7, 7),
(4, 'Khaled', NULL, NULL, '', 0, 2, 7, 7),
(5, 'Abdoul Wahab', NULL, NULL, '', 0, 2, 7, 7),
(6, 'Mouhamed Togo', NULL, NULL, '', 0, 2, 7, 7),
(7, 'Mouhamed new', NULL, NULL, '', 0, 2, 7, 7),
(8, 'Cheikh Fadl', NULL, NULL, '', 0, 2, 7, 7),
(9, 'Cheikh Adam', NULL, NULL, '', 0, 2, 7, 7),
(10, 'Ghazhi', NULL, NULL, '', 0, 2, 7, 7),
(11, 'Mouhamadou Lamine', NULL, NULL, '', 0, 2, 7, 7),
(12, 'Ferid', NULL, NULL, '', 0, 2, 7, 7),
(13, 'AbdoulKarim', NULL, NULL, '', 0, 2, 7, 7),
(14, 'Abdellillah', NULL, NULL, '', 0, 2, 7, 7),
(15, 'AbdelHadi', NULL, NULL, '', 0, 2, 7, 7),
(16, 'Ayoub', NULL, NULL, '', 0, 2, 7, 7),
(17, 'Aboubakr', NULL, NULL, '', 0, 2, 7, 7),
(18, 'Silvere', NULL, NULL, '', 0, 2, 7, 7),
(19, 'Soufiane', NULL, NULL, '', 0, 2, 7, 7),
(20, 'Test Test', 'info@mail.com', '5142963565', '25f9e794323b453885f5181f1b624d0b', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `match`
--

DROP TABLE IF EXISTS `match`;
CREATE TABLE `match` (
  `date_match` datetime NOT NULL,
  `id_joueur` int(11) NOT NULL,
  `id_equipe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vider la table avant d'insérer `match`
--

TRUNCATE TABLE `match`;
-- --------------------------------------------------------

--
-- Structure de la table `presence`
--

DROP TABLE IF EXISTS `presence`;
CREATE TABLE `presence` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `id_joueur` int(11) NOT NULL,
  `id_equipe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vider la table avant d'insérer `presence`
--

TRUNCATE TABLE `presence`;
--
-- Contenu de la table `presence`
--

INSERT INTO `presence` (`id`, `date`, `id_joueur`, `id_equipe`) VALUES
(1, '2017-11-18 06:45:00', 1, 2),
(5, '2017-11-18 06:45:00', 12, 2),
(6, '2017-11-18 06:45:00', 4, 1),
(7, '2017-11-18 06:45:00', 2, 1),
(8, '2017-11-18 06:45:00', 10, 2),
(9, '2017-11-18 06:45:00', 3, 1),
(12, '2017-11-25 06:45:00', 3, 1),
(13, '2017-11-25 06:45:00', 4, 1),
(15, '2017-11-25 06:45:00', 6, 1),
(16, '2017-11-25 06:45:00', 7, 2),
(17, '2017-11-25 06:45:00', 8, 1),
(18, '2017-11-25 06:45:00', 9, 2),
(19, '2017-11-25 06:45:00', 11, 1),
(20, '2017-11-25 06:45:00', 12, 2),
(29, '2017-11-25 06:45:00', 1, 2),
(30, '2017-12-02 06:45:00', 1, 2),
(31, '2017-12-02 06:45:00', 3, 1),
(32, '2017-12-02 06:45:00', 5, 2),
(33, '2017-12-02 06:45:00', 7, 2),
(34, '2017-12-02 06:45:00', 9, 2),
(35, '2017-12-02 06:45:00', 2, 1),
(36, '2017-12-02 06:45:00', 6, 1),
(37, '2017-12-02 06:45:00', 4, 1),
(38, '2017-12-02 06:45:00', 10, 2);

-- --------------------------------------------------------

--
-- Structure de la table `score`
--

DROP TABLE IF EXISTS `score`;
CREATE TABLE `score` (
  `id` int(11) NOT NULL,
  `date_rencontre` datetime NOT NULL,
  `score_verte` int(11) NOT NULL,
  `score_orange` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vider la table avant d'insérer `score`
--

TRUNCATE TABLE `score`;
--
-- Contenu de la table `score`
--

INSERT INTO `score` (`id`, `date_rencontre`, `score_verte`, `score_orange`) VALUES
(1, '2017-10-28 06:45:00', 0, 0),
(2, '2017-11-04 06:45:00', 0, 1),
(3, '2017-11-11 06:45:00', 7, 0),
(4, '2017-11-18 06:45:00', 0, 1),
(5, '2017-11-25 06:45:00', 0, 2);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `dates_match`
--
ALTER TABLE `dates_match`
  ADD PRIMARY KEY (`date_match`),
  ADD UNIQUE KEY `date_rencontre_2` (`date_match`),
  ADD KEY `date_rencontre` (`date_match`),
  ADD KEY `date_rencontre_3` (`date_match`),
  ADD KEY `date_rencontre_4` (`date_match`),
  ADD KEY `date_rencontre_5` (`date_match`),
  ADD KEY `date_match` (`date_match`);

--
-- Index pour la table `equipe`
--
ALTER TABLE `equipe`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `joueur`
--
ALTER TABLE `joueur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `presence`
--
ALTER TABLE `presence`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_joueur` (`id_joueur`),
  ADD KEY `id_equipe` (`id_equipe`);

--
-- Index pour la table `score`
--
ALTER TABLE `score`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `date_match` (`date_rencontre`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `date_rencontre` (`date_rencontre`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `equipe`
--
ALTER TABLE `equipe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `joueur`
--
ALTER TABLE `joueur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT pour la table `presence`
--
ALTER TABLE `presence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT pour la table `score`
--
ALTER TABLE `score`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `presence`
--
ALTER TABLE `presence`
  ADD CONSTRAINT `presence_ibfk_1` FOREIGN KEY (`id_joueur`) REFERENCES `joueur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `presence_ibfk_2` FOREIGN KEY (`id_equipe`) REFERENCES `equipe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
