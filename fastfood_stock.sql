-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: May 12, 2026 at 09:11 AM
-- Server version: 11.5.2-MariaDB
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fastfood_stock`
--

-- --------------------------------------------------------

--
-- Table structure for table `categ_produits`
--

DROP TABLE IF EXISTS `categ_produits`;
CREATE TABLE IF NOT EXISTS `categ_produits` (
  `id_categ` int(11) NOT NULL AUTO_INCREMENT,
  `libelle_categ` varchar(100) NOT NULL,
  PRIMARY KEY (`id_categ`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `categ_produits`
--

INSERT INTO `categ_produits` (`id_categ`, `libelle_categ`) VALUES
(1, 'Boissons'),
(2, 'Viandes'),
(3, 'Légumes'),
(4, 'Emballages');

-- --------------------------------------------------------

--
-- Table structure for table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `id_commande` int(11) NOT NULL AUTO_INCREMENT,
  `date_commande` datetime NOT NULL,
  `quantite` int(11) NOT NULL,
  `statut` enum('En attente','Reçue','Annulée') NOT NULL DEFAULT 'En attente',
  `id_prod` int(11) NOT NULL,
  `id_fourni` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  PRIMARY KEY (`id_commande`),
  KEY `id_prod` (`id_prod`),
  KEY `id_fourni` (`id_fourni`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `commandes`
--

INSERT INTO `commandes` (`id_commande`, `date_commande`, `quantite`, `statut`, `id_prod`, `id_fourni`, `id_utilisateur`) VALUES
(1, '2026-03-18 14:11:19', 50, 'Reçue', 2, 2, 1),
(2, '2026-03-18 14:18:06', 21, 'Reçue', 2, 2, 1),
(3, '2026-03-18 16:42:06', 49, 'Reçue', 1, 1, 1),
(4, '2026-05-05 08:33:34', 1, 'Reçue', 5, 2, 1),
(5, '2026-05-05 08:42:59', 4, 'Reçue', 5, 1, 1),
(6, '2026-05-05 08:43:47', 3, 'Reçue', 5, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comptes`
--

DROP TABLE IF EXISTS `comptes`;
CREATE TABLE IF NOT EXISTS `comptes` (
  `id_compte` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `id_role` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  PRIMARY KEY (`id_compte`),
  UNIQUE KEY `login` (`login`),
  KEY `id_role` (`id_role`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `comptes`
--

INSERT INTO `comptes` (`id_compte`, `login`, `mot_de_passe`, `id_role`, `id_utilisateur`) VALUES
(1, 'admin', '$2y$10$srEWb1zqxmRcb.jFs.dY8.e1C83FR6fu4Ow1VXYlIPShXtu64csKm', 1, 1),
(2, 'employe', '$2y$10$suT2UrYiVsBivwZayrPsNeYbnD6Tt0eKzRSu8i6L8e6dzB6YzjCgG', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `fournisseurs`
--

DROP TABLE IF EXISTS `fournisseurs`;
CREATE TABLE IF NOT EXISTS `fournisseurs` (
  `id_fourni` int(11) NOT NULL AUTO_INCREMENT,
  `nom_fourni` varchar(100) NOT NULL,
  `tel_fourni` varchar(20) DEFAULT NULL,
  `rue_fourni` varchar(150) DEFAULT NULL,
  `cp_fourni` varchar(10) DEFAULT NULL,
  `ville_fourni` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_fourni`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `fournisseurs`
--

INSERT INTO `fournisseurs` (`id_fourni`, `nom_fourni`, `tel_fourni`, `rue_fourni`, `cp_fourni`, `ville_fourni`) VALUES
(1, 'Boucherie Centrale', '0102030405', '10 Rue de la Viande', '75001', 'Paris'),
(2, 'Metro Cash & Carry', '0908070605', 'ZAC des Entrepots', '93200', 'Saint-Denis'),
(3, 'Test Fournisseur', '0102030405', '123 Rue de Test', '75000', 'Paris');

-- --------------------------------------------------------

--
-- Table structure for table `mouvements`
--

DROP TABLE IF EXISTS `mouvements`;
CREATE TABLE IF NOT EXISTS `mouvements` (
  `id_mouv` int(11) NOT NULL AUTO_INCREMENT,
  `qte_mouv` int(11) NOT NULL,
  `date_mouv` datetime NOT NULL,
  `id_prod` int(11) NOT NULL,
  `id_type_mouvement` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  PRIMARY KEY (`id_mouv`),
  KEY `id_prod` (`id_prod`),
  KEY `id_type_mouvement` (`id_type_mouvement`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `mouvements`
--

INSERT INTO `mouvements` (`id_mouv`, `qte_mouv`, `date_mouv`, `id_prod`, `id_type_mouvement`, `id_utilisateur`) VALUES
(1, 50, '2026-03-18 14:17:28', 2, 1, 1),
(2, 250, '2026-03-18 14:17:42', 2, 2, 1),
(3, 21, '2026-03-18 14:18:25', 2, 1, 1),
(4, 50, '2026-03-18 15:08:11', 4, 1, 1),
(5, 499, '2026-03-18 15:08:28', 1, 2, 1),
(6, 49, '2026-03-18 16:42:20', 1, 1, 1),
(7, 50, '2026-03-18 17:03:12', 1, 1, 1),
(8, 1, '2026-05-05 08:33:58', 5, 1, 1),
(9, 4, '2026-05-05 08:43:26', 5, 1, 1),
(10, 3, '2026-05-05 08:43:54', 5, 1, 1),
(11, 50, '2026-05-05 09:21:10', 3, 2, 1),
(12, 30, '2026-05-05 09:25:03', 3, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `id_prod` int(11) NOT NULL AUTO_INCREMENT,
  `nom_prod` varchar(100) NOT NULL,
  `unite` varchar(20) NOT NULL,
  `stock_initial` int(11) NOT NULL DEFAULT 0,
  `seuil_alerte` int(11) NOT NULL DEFAULT 5,
  `id_categ` int(11) NOT NULL,
  `id_fourni` int(11) NOT NULL,
  PRIMARY KEY (`id_prod`),
  KEY `id_categ` (`id_categ`),
  KEY `id_fourni` (`id_fourni`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `produits`
--

INSERT INTO `produits` (`id_prod`, `nom_prod`, `unite`, `stock_initial`, `seuil_alerte`, `id_categ`, `id_fourni`) VALUES
(1, 'Steak Haché 150g', 'Pièce', 500, 50, 2, 1),
(2, 'Bouteille Cola 50cl', 'Bouteille', 200, 20, 1, 2),
(3, 'Salade Iceberg', 'Kg', 20, 5, 3, 2),
(4, 'Fromage ', 'tranches', 10, 5, 3, 2),
(5, 'test unite mesure', '0', 0, 5, 1, 1),
(6, 'Stylo Test', 'Pièces', 10, 55, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int(11) NOT NULL AUTO_INCREMENT,
  `libelle_role` varchar(50) NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id_role`, `libelle_role`) VALUES
(1, 'Administrateur'),
(2, 'Employé');

-- --------------------------------------------------------

--
-- Table structure for table `type_mouvements`
--

DROP TABLE IF EXISTS `type_mouvements`;
CREATE TABLE IF NOT EXISTS `type_mouvements` (
  `id_type_mouvement` int(11) NOT NULL AUTO_INCREMENT,
  `libelle_type_mouvement` varchar(50) NOT NULL,
  PRIMARY KEY (`id_type_mouvement`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `type_mouvements`
--

INSERT INTO `type_mouvements` (`id_type_mouvement`, `libelle_type_mouvement`) VALUES
(1, 'Entrée'),
(2, 'Sortie');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `nom`, `email`) VALUES
(1, 'Labidi Fahd', 'admin@fastfood.fr'),
(2, 'Alice Martin', 'employe@fastfood.fr'),
(999, 'Admin Test', 'admin@test.com');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`id_prod`) REFERENCES `produits` (`id_prod`),
  ADD CONSTRAINT `commandes_ibfk_2` FOREIGN KEY (`id_fourni`) REFERENCES `fournisseurs` (`id_fourni`),
  ADD CONSTRAINT `commandes_ibfk_3` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`);

--
-- Constraints for table `comptes`
--
ALTER TABLE `comptes`
  ADD CONSTRAINT `comptes_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`) ON DELETE CASCADE,
  ADD CONSTRAINT `comptes_ibfk_2` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`) ON DELETE CASCADE;

--
-- Constraints for table `mouvements`
--
ALTER TABLE `mouvements`
  ADD CONSTRAINT `mouvements_ibfk_1` FOREIGN KEY (`id_prod`) REFERENCES `produits` (`id_prod`),
  ADD CONSTRAINT `mouvements_ibfk_2` FOREIGN KEY (`id_type_mouvement`) REFERENCES `type_mouvements` (`id_type_mouvement`),
  ADD CONSTRAINT `mouvements_ibfk_3` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`);

--
-- Constraints for table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `produits_ibfk_1` FOREIGN KEY (`id_categ`) REFERENCES `categ_produits` (`id_categ`),
  ADD CONSTRAINT `produits_ibfk_2` FOREIGN KEY (`id_fourni`) REFERENCES `fournisseurs` (`id_fourni`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
