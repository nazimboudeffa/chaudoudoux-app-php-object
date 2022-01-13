-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 13 jan. 2022 à 21:50
-- Version du serveur :  10.4.17-MariaDB
-- Version de PHP : 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `chaudoudoux-app-php-object`
--

-- --------------------------------------------------------

--
-- Structure de la table `chaudoudoux_site_settings`
--

CREATE TABLE `chaudoudoux_site_settings` (
  `setting_id` bigint(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `chaudoudoux_site_settings`
--

INSERT INTO `chaudoudoux_site_settings` (`setting_id`, `name`, `value`) VALUES
(1, 'theme', 'goblue'),
(2, 'site_name', '<<sitename>>'),
(3, 'language', 'en'),
(4, 'cache', '0'),
(5, 'owner_email', '<<owner_email>>'),
(6, 'notification_email', '<<notification_email>>'),
(7, 'upgrades', '[\"1410545706.php\",\"1411396351.php\", \"1412353569.php\",\"1415553653.php\",\"1415819862.php\", \"1423419053.php\", \"1423419054.php\", \"1439295894.php\", \"1440716428.php\", \"1440867331.php\", \"1440603377.php\", \"1443202118.php\", \"1443211017.php\", \"1443545762.php\", \"1443617470.php\", \"1446311454.php\", \"1448807613.php\", \"1453676400.php\", \"1459411815.php\", \"1468010638.php\", \"1470127853.php\", \"1480759958.php\", \"1495366993.php\", \"1513524535.php\", \"1513603766.php\", \"1513783390.php\", \"1542223614.php\", \"1564080285.php\", \"1577836800.php\", \"1597058454.php\", \"1597734806.php\", \"1598389337.php\", \"1605286634.php\", \"1632413382.php\", \"1633420776.php\"]'),
(9, 'display_errors', 'off'),
(10, 'site_key', '<<secret>>'),
(11, 'last_cache', ''),
(12, 'site_version', '6.1');

-- --------------------------------------------------------

--
-- Structure de la table `chaudoudoux_users`
--

CREATE TABLE `chaudoudoux_users` (
  `guid` bigint(20) NOT NULL,
  `type` text NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` text NOT NULL,
  `password` varchar(65) NOT NULL,
  `salt` varchar(8) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `last_login` int(11) NOT NULL,
  `last_activity` int(11) NOT NULL,
  `activation` varchar(32) DEFAULT NULL,
  `time_created` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `chaudoudoux_site_settings`
--
ALTER TABLE `chaudoudoux_site_settings`
  ADD PRIMARY KEY (`setting_id`);

--
-- Index pour la table `chaudoudoux_users`
--
ALTER TABLE `chaudoudoux_users`
  ADD PRIMARY KEY (`guid`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `chaudoudoux_site_settings`
--
ALTER TABLE `chaudoudoux_site_settings`
  MODIFY `setting_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `chaudoudoux_users`
--
ALTER TABLE `chaudoudoux_users`
  MODIFY `guid` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
