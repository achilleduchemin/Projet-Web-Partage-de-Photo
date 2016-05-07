-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 08 Mai 2016 à 01:24
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `espace_membre`
--

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE IF NOT EXISTS `membre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `motdepasse` text NOT NULL,
  `newphoto` varchar(255) NOT NULL,
  `test` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Contenu de la table `membre`
--

INSERT INTO `membre` (`id`, `pseudo`, `mail`, `motdepasse`, `newphoto`, `test`) VALUES
(14, 'Achille', 'achille.duchemin@gmail.com', '123', '', ''),
(17, 'Bob L''Eponge', 'Bob@gmail.com', '123', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `name` varchar(255) NOT NULL,
  `number` int(11) NOT NULL,
  `iduser` varchar(11) NOT NULL,
  `lieu` varchar(255) NOT NULL,
  `descri` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `id` int(11) NOT NULL,
  `partage` varchar(255) NOT NULL,
  PRIMARY KEY (`name`,`descri`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `photos`
--

INSERT INTO `photos` (`name`, `number`, `iduser`, `lieu`, `descri`, `date`, `id`, `partage`) VALUES
('2012-08-29_14-33-46_89.jpg', 1, '17', 'L''ile d''yeu', 'A la plage ', 'Le 08-05-2016 Ã  01:21', 4, 'public'),
('2012-09-08_20-52-02_718.jpg', 2, '17', 'Gros Festival', 'Avec mon poto Bob', 'Le 08-05-2016 Ã  01:22', 5, 'private'),
('IMG_20140425_141603.jpg', 1, '14', 'londres', 'James Bond''s Car', 'Le 08-05-2016 Ã  01:18', 1, 'public'),
('IMG_20140426_113811.jpg', 3, '14', 'Cathedrale ', 'Ciel bleu !', 'Le 08-05-2016 Ã  01:19', 3, 'private'),
('IMG_20141124_173748.jpg', 2, '14', 'Paris - Campus Eiffel', 'Jean guillaume allias Borat', 'Le 08-05-2016 Ã  01:18', 2, 'public');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
