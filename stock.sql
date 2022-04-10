-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 07, 2019 at 12:49 PM
-- Server version: 5.7.21
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stock`
--

-- --------------------------------------------------------

--
-- Table structure for table `agence`
--

DROP TABLE IF EXISTS `agence`;
CREATE TABLE IF NOT EXISTS `agence` (
  `id_agence` int(11) NOT NULL AUTO_INCREMENT,
  `agence` varchar(250) NOT NULL,
  `tele_agence` varchar(15) NOT NULL,
  `province_agence` varchar(250) NOT NULL,
  `commune_agence` varchar(250) NOT NULL,
  `quartier_agence` varchar(250) NOT NULL,
  `avenue_agence` varchar(250) NOT NULL,
  `numero_agence` varchar(10) NOT NULL,
  `resp_agence` varchar(50) NOT NULL,
  `tele_resp_agence` varchar(15) NOT NULL,
  `id_user_add_agence` int(11) NOT NULL,
  `date_add_agence` datetime NOT NULL,
  `id_user_edit_agence` int(11) DEFAULT NULL,
  `date_edit_agence` datetime DEFAULT NULL,
  PRIMARY KEY (`id_agence`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `banque`
--

DROP TABLE IF EXISTS `banque`;
CREATE TABLE IF NOT EXISTS `banque` (
  `id_banque` int(11) NOT NULL AUTO_INCREMENT,
  `nom_banque` varchar(255) NOT NULL,
  `banque_status` int(11) NOT NULL,
  `user_add_banque` int(11) NOT NULL,
  `date_add_banque` datetime NOT NULL,
  PRIMARY KEY (`id_banque`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banque`
--

INSERT INTO `banque` (`id_banque`, `nom_banque`, `banque_status`, `user_add_banque`, `date_add_banque`) VALUES
(1, 'BCB', 1, 1, '2018-12-30 23:12:54');

-- --------------------------------------------------------

--
-- Table structure for table `boncommande`
--

DROP TABLE IF EXISTS `boncommande`;
CREATE TABLE IF NOT EXISTS `boncommande` (
  `id_commande` int(11) NOT NULL AUTO_INCREMENT,
  `ref_commande` varchar(45) NOT NULL,
  `date_commande` date NOT NULL,
  `id_marque` int(4) NOT NULL,
  `prix_total_achat` varchar(255) NOT NULL,
  `status` smallint(6) NOT NULL,
  `user_add` tinyint(4) NOT NULL,
  `date_add` datetime NOT NULL,
  `pieceBonLivraisionCommande` varchar(300) DEFAULT NULL,
  `observationCommande` varchar(500) DEFAULT NULL,
  `user_edit` tinyint(4) DEFAULT NULL,
  `date_edit` datetime DEFAULT NULL,
  `status_paye` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_commande`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `boncommande_item`
--

DROP TABLE IF EXISTS `boncommande_item`;
CREATE TABLE IF NOT EXISTS `boncommande_item` (
  `bonLivraison_id` int(11) NOT NULL AUTO_INCREMENT,
  `id_commande` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `quantite` int(4) NOT NULL,
  `prix_achat` varchar(255) NOT NULL,
  `prix_achat_total` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`bonLivraison_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `boncommande_paye`
--

DROP TABLE IF EXISTS `boncommande_paye`;
CREATE TABLE IF NOT EXISTS `boncommande_paye` (
  `id_boncommande_paye` int(11) NOT NULL AUTO_INCREMENT,
  `id_boncommande` int(11) NOT NULL,
  `code_compte` int(11) NOT NULL,
  `numero_facture_boncommande` varchar(50) NOT NULL,
  `montant` varchar(30) NOT NULL,
  `type_paiement` tinyint(4) NOT NULL,
  `status_paiement` tinyint(4) NOT NULL,
  `date_paiement` date NOT NULL,
  `observation` text,
  `user_add` int(11) NOT NULL,
  `date_add` datetime NOT NULL,
  `pieceFacture_boncommande` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id_boncommande_paye`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bon_sortie`
--

DROP TABLE IF EXISTS `bon_sortie`;
CREATE TABLE IF NOT EXISTS `bon_sortie` (
  `id_bonSortie` int(11) NOT NULL AUTO_INCREMENT,
  `date_sortie` date NOT NULL,
  `ref_sortie` varchar(50) NOT NULL,
  `autorise_sortie` varchar(255) NOT NULL,
  `montant` varchar(255) NOT NULL,
  `observation_sortie` varchar(300) NOT NULL,
  `user_add_sortie` int(11) NOT NULL,
  `date_add_sortie` datetime NOT NULL,
  `status_sortie` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_bonSortie`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bon_sortie_item`
--

DROP TABLE IF EXISTS `bon_sortie_item`;
CREATE TABLE IF NOT EXISTS `bon_sortie_item` (
  `id_sortie_item` int(11) NOT NULL AUTO_INCREMENT,
  `id_bonSortie` int(11) NOT NULL,
  `libelle_sortie` text NOT NULL,
  `quantite_sortie` int(11) NOT NULL,
  `prix_achat_sortie` varchar(50) NOT NULL,
  `prix_achat_total_sortie` varchar(50) NOT NULL,
  `status_item_sortie` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_sortie_item`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bon_sortie_paye`
--

DROP TABLE IF EXISTS `bon_sortie_paye`;
CREATE TABLE IF NOT EXISTS `bon_sortie_paye` (
  `id_sortie_paye` int(11) NOT NULL AUTO_INCREMENT,
  `id_bonSortie` int(11) NOT NULL,
  `code_compte` int(11) NOT NULL,
  `montant` varchar(30) NOT NULL,
  `type_paiement` tinyint(4) NOT NULL,
  `status_paiement` tinyint(4) NOT NULL,
  `date_paiement` date NOT NULL,
  `observation` text,
  `user_add` int(11) NOT NULL,
  `date_add` datetime NOT NULL,
  `pieceFacture` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id_sortie_paye`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
CREATE TABLE IF NOT EXISTS `brands` (
  `brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(255) NOT NULL,
  `brand_active` int(11) NOT NULL DEFAULT '0',
  `brand_status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`brand_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `caisse`
--

DROP TABLE IF EXISTS `caisse`;
CREATE TABLE IF NOT EXISTS `caisse` (
  `id_caisse` int(11) NOT NULL AUTO_INCREMENT,
  `montant_caisse` varchar(255) NOT NULL,
  `date_caisse` date NOT NULL,
  `user_add_caisse` int(11) NOT NULL,
  `date_add_caisse` datetime NOT NULL,
  PRIMARY KEY (`id_caisse`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `categories_id` int(11) NOT NULL AUTO_INCREMENT,
  `categories_name` varchar(255) NOT NULL,
  `categories_active` int(11) NOT NULL DEFAULT '0',
  `categories_status` int(11) NOT NULL DEFAULT '0',
  `idBrand` int(11) NOT NULL,
  PRIMARY KEY (`categories_id`),
  KEY `fk_categories_brands1_idx` (`idBrand`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id_client` int(11) NOT NULL AUTO_INCREMENT,
  `nom_client` varchar(50) NOT NULL,
  `prenom_client` varchar(50) NOT NULL,
  `telephone_client` varchar(20) NOT NULL,
  `adresse_client` text NOT NULL,
  `nif_client` varchar(150) NOT NULL,
  `client_tva` int(11) NOT NULL,
  `user_add_client` int(11) NOT NULL,
  `date_add_client` datetime NOT NULL,
  `status_client` int(11) NOT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comptabilite_classe_compte`
--

DROP TABLE IF EXISTS `comptabilite_classe_compte`;
CREATE TABLE IF NOT EXISTS `comptabilite_classe_compte` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `libelle_classe` varchar(1024) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `user_add` int(11) NOT NULL,
  `date_add` datetime NOT NULL,
  `id_user_edit` int(11) DEFAULT NULL,
  `date_edit` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comptabilite_classe_compte`
--

INSERT INTO `comptabilite_classe_compte` (`id`, `libelle_classe`, `status`, `user_add`, `date_add`, `id_user_edit`, `date_edit`) VALUES
(1, 'COMPTES DE CAPITAUX', 1, 1, '2018-11-16 15:11:12', NULL, NULL),
(2, 'COMPTES D\'IMMOBILISATIONS', 1, 1, '2018-11-16 11:11:41', NULL, NULL),
(3, 'COMPTES DE STOCKS ET EN-COURS', 1, 1, '2018-11-16 11:11:01', NULL, NULL),
(4, 'COMPTES DE TIERS', 1, 1, '2018-11-16 11:11:14', NULL, NULL),
(5, 'COMPTES FINANCIERS', 1, 1, '2018-11-16 11:11:52', 1, '2018-11-17 14:11:12'),
(6, 'COMPTES DE CHARGES', 1, 1, '2018-11-16 11:11:00', NULL, NULL),
(7, 'COMPTES DE PRODUITS', 1, 1, '2018-11-16 11:11:07', NULL, NULL),
(8, 'COMPTES SPECIAUX', 1, 1, '2018-11-16 11:11:15', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comptabilite_compte_principal`
--

DROP TABLE IF EXISTS `comptabilite_compte_principal`;
CREATE TABLE IF NOT EXISTS `comptabilite_compte_principal` (
  `id_compte_principal` int(11) NOT NULL AUTO_INCREMENT,
  `id_classe` tinyint(11) NOT NULL,
  `code_compte` int(11) NOT NULL,
  `libelle_compte` varchar(2048) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `user_add` int(11) NOT NULL,
  `date_add` datetime NOT NULL,
  `id_user_edit` int(11) DEFAULT NULL,
  `date_edit` datetime DEFAULT NULL,
  PRIMARY KEY (`id_compte_principal`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comptabilite_compte_principal`
--

INSERT INTO `comptabilite_compte_principal` (`id_compte_principal`, `id_classe`, `code_compte`, `libelle_compte`, `status`, `user_add`, `date_add`, `id_user_edit`, `date_edit`) VALUES
(1, 5, 56, 'Banques, ChÃ¨ques postaux, Comptes de rÃ©gies dÃ¹avance et d\'accrÃ©ditifs', 1, 1, '2018-11-16 14:11:00', 1, '2018-11-16 15:11:37'),
(2, 5, 57, 'Caisse', 1, 1, '2018-11-16 14:11:27', 1, '2018-11-16 15:11:09'),
(3, 5, 58, 'Virement internes', 1, 1, '2018-11-16 14:11:52', NULL, NULL),
(4, 6, 60, 'CoÃ»ts des stocks vendus', 1, 1, '2018-11-16 14:11:37', 1, '2018-11-16 15:11:15'),
(5, 6, 61, 'MatiÃ¨res et fournitures consommÃ©es', 1, 1, '2018-11-16 14:11:22', 1, '2018-11-16 15:11:38'),
(6, 6, 62, 'Transport consommes', 1, 1, '2018-11-16 14:11:03', NULL, NULL),
(7, 6, 63, 'Autres services consommes', 1, 1, '2018-11-16 14:11:12', NULL, NULL),
(8, 6, 64, 'Autres charges ce gestion courante', 1, 1, '2018-11-16 14:11:00', NULL, NULL),
(9, 6, 65, 'Charges de personnel', 1, 1, '2018-11-16 14:11:23', NULL, NULL),
(10, 6, 66, 'ImpÃ´ts, taxes et versement assimilÃ©s', 1, 1, '2018-11-16 14:11:24', 1, '2018-11-16 15:11:00'),
(11, 6, 67, 'Charges financiers', 1, 1, '2018-11-16 14:11:59', NULL, NULL),
(12, 6, 68, 'Donations qux amortisserment, dÃ©prÃ©ciations et provisions', 1, 1, '2018-11-16 14:11:58', 1, '2018-11-16 15:11:37'),
(13, 6, 69, 'ImpÃ´t sur les rÃ©sultats et assimilÃ©s', 1, 1, '2018-11-16 14:11:42', 1, '2018-11-16 15:11:13'),
(14, 7, 70, 'Vente de marchandises', 1, 1, '2018-11-16 14:11:08', NULL, NULL),
(15, 7, 71, 'Production vente de biens et services', 1, 1, '2018-11-16 14:11:33', NULL, NULL),
(16, 7, 72, 'Production stockÃ©e (ou d&eacute;stockÃ©e)', 1, 1, '2018-11-16 14:11:06', 1, '2018-11-16 15:11:34');

-- --------------------------------------------------------

--
-- Table structure for table `comptabilite_sous_compte`
--

DROP TABLE IF EXISTS `comptabilite_sous_compte`;
CREATE TABLE IF NOT EXISTS `comptabilite_sous_compte` (
  `id_sous_compte` int(11) NOT NULL AUTO_INCREMENT,
  `id_compte_principal` int(11) NOT NULL,
  `code_sous_compte` int(11) NOT NULL,
  `libelle_sous_compte` varchar(1024) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `user_add` int(11) NOT NULL,
  `date_add` datetime NOT NULL,
  `id_user_edit` int(11) DEFAULT NULL,
  `date_edit` datetime DEFAULT NULL,
  PRIMARY KEY (`id_sous_compte`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comptabilite_sous_compte`
--

INSERT INTO `comptabilite_sous_compte` (`id_sous_compte`, `id_compte_principal`, `code_sous_compte`, `libelle_sous_compte`, `status`, `user_add`, `date_add`, `id_user_edit`, `date_edit`) VALUES
(1, 1, 561, 'Banques locales', 1, 1, '2018-11-24 10:11:43', 1, '2018-11-24 10:11:21'),
(2, 1, 562, 'Organismes finaciers locaux', 1, 1, '2018-11-24 10:11:53', 1, '2018-11-24 10:11:43'),
(3, 1, 563, 'ChÃ¨ques postaux', 1, 1, '2018-11-24 10:11:18', NULL, NULL),
(4, 1, 564, 'Banques et organismes et accrÃ©ditifs', 1, 1, '2018-11-24 10:11:48', NULL, NULL),
(5, 1, 565, 'RÃ©gies dÃ¹qvqnces et qccrÃ©ditifs', 1, 1, '2018-11-24 10:11:25', NULL, NULL),
(6, 1, 566, 'CrÃ©dits documentaires - fonds bloques', 1, 1, '2018-11-24 10:11:29', NULL, NULL),
(7, 1, 567, 'DÃ©pÃ´ts et cautionnements bancaires', 1, 1, '2018-11-24 10:11:09', NULL, NULL),
(8, 1, 568, 'Comptes Ã  terme', 1, 1, '2018-11-24 10:11:39', NULL, NULL),
(9, 1, 569, 'Autres concours bancaires', 1, 1, '2018-11-24 10:11:04', NULL, NULL),
(10, 2, 571, 'Caisse principales', 1, 1, '2018-11-24 10:11:44', NULL, NULL),
(11, 2, 572, 'Petite caisse', 1, 1, '2018-11-24 10:11:00', NULL, NULL),
(12, 2, 574, 'Caisse des Ã©tablissement et succursales', 1, 1, '2018-11-24 10:11:30', NULL, NULL),
(13, 4, 601, 'CoÃ»t des marchandises vendues', 1, 1, '2018-11-24 10:11:13', NULL, NULL),
(14, 4, 603, 'CoÃ»ts des emballages vendus', 1, 1, '2018-11-24 10:11:43', NULL, NULL),
(15, 4, 609, 'RRR et escomptes obtenues sur achat de marchandises', 1, 1, '2018-11-24 10:11:20', NULL, NULL),
(16, 6, 621, 'Transports sur ventes', 1, 1, '2018-11-24 10:11:49', NULL, NULL),
(17, 6, 622, 'Transports et dÃ©placessement tiers non salaries', 1, 1, '2018-11-24 10:11:30', NULL, NULL),
(18, 6, 623, 'Transports et dÃ©placements concemant personnel', 1, 1, '2018-11-24 10:11:42', NULL, NULL),
(19, 6, 624, 'Transports collectifs du personnel', 1, 1, '2018-11-24 10:11:10', NULL, NULL),
(20, 6, 628, 'Autres frais de transport et dÃ©placement', 1, 1, '2018-11-24 10:11:48', NULL, NULL),
(21, 7, 631, 'Loyer et charges locatives', 1, 1, '2018-12-02 23:12:26', NULL, NULL),
(22, 7, 632, 'Entretien et reparation', 1, 1, '2018-12-02 23:12:52', NULL, NULL),
(23, 7, 633, 'Honoraires et assimilÃ©s', 1, 1, '2018-12-02 23:12:23', NULL, NULL),
(24, 7, 634, 'Achats de services exterieurs', 1, 1, '2018-12-02 23:12:51', NULL, NULL),
(25, 7, 635, 'Commission et courtages sur ventes', 1, 1, '2018-12-03 00:12:36', NULL, NULL),
(26, 7, 636, 'Sous-traitance gÃ©nÃ©rale', 1, 1, '2018-12-03 00:12:15', NULL, NULL),
(27, 7, 637, 'Assurances', 1, 1, '2018-12-03 00:12:26', NULL, NULL),
(28, 7, 638, 'Autres services consommÃ©s', 1, 1, '2018-12-03 00:12:49', NULL, NULL),
(29, 8, 639, 'Rabais, remises, ristoumes et escomptes obtenus', 1, 1, '2018-12-03 00:12:48', NULL, NULL),
(30, 8, 641, 'Redevences pour consessions, brevets, licences, marques, procÃ©dÃ©s; logiciels; droits et valeur similaires', 1, 1, '2018-12-03 00:12:44', NULL, NULL),
(31, 8, 644, 'RÃ©munÃ©ration des administrateurs', 1, 1, '2018-12-03 00:12:45', NULL, NULL),
(32, 8, 645, 'Dons, libÃ©ralitÃ©s et subventions accordÃ©es, cotisations verses', 1, 1, '2018-12-03 00:12:03', NULL, NULL),
(33, 8, 646, 'Moins-valeur sur cessions d\'actifs immobilisÃ©s', 1, 1, '2018-12-03 00:12:12', NULL, NULL),
(34, 8, 647, 'Pertes sur crÃ©ances irrÃ©couvrables', 1, 1, '2018-12-03 00:12:52', NULL, NULL),
(35, 8, 648, 'Quote-part de resultat sur opÃ©rations faites en commun', 1, 1, '2018-12-03 00:12:45', NULL, NULL),
(36, 9, 651, 'RÃ©munÃ©rations directes', 1, 1, '2018-12-03 00:12:04', NULL, NULL),
(37, 9, 652, 'IndemnitÃ©s de logement', 1, 1, '2018-12-03 00:12:31', NULL, NULL),
(38, 9, 653, 'Prestations familiales', 1, 1, '2018-12-03 00:12:03', NULL, NULL),
(39, 9, 654, 'Charges sociales', 1, 1, '2018-12-03 00:12:26', NULL, NULL),
(40, 9, 655, 'IndemnitÃ©s de fin de contrat', 1, 1, '2018-12-03 00:12:02', NULL, NULL),
(41, 9, 656, 'Autres avantages et indemnitÃ©s au personnel', 1, 1, '2018-12-03 00:12:57', NULL, NULL),
(42, 14, 709, 'RRR et escomptes accordÃ©s sur ventes marchandises', 1, 1, '2018-12-03 00:12:14', NULL, NULL),
(43, 15, 719, 'RRR et escomptes accordÃ©s sur productions vendues ', 1, 1, '2018-12-03 00:12:18', NULL, NULL),
(44, 16, 722, 'DÃ©chets et rebuls', 1, 1, '2018-12-03 00:12:56', NULL, NULL),
(45, 16, 723, 'Emballages commerciaux fabriquÃ©s par l\'entreprise', 1, 1, '2018-12-03 00:12:55', NULL, NULL),
(46, 16, 724, 'Produit semi-ouvrÃ©s', 1, 1, '2018-12-03 00:12:25', NULL, NULL),
(47, 16, 725, 'Produit finis', 1, 1, '2018-12-03 00:12:42', NULL, NULL),
(48, 16, 726, 'Produit et travaux en cours', 1, 1, '2018-12-03 00:12:06', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `depenses`
--

DROP TABLE IF EXISTS `depenses`;
CREATE TABLE IF NOT EXISTS `depenses` (
  `id_depense` int(11) NOT NULL AUTO_INCREMENT,
  `ref_depense` varchar(50) NOT NULL,
  `prix_total_depense` varchar(50) NOT NULL,
  `date_depense` date NOT NULL,
  `demende_depense` varchar(50) NOT NULL,
  `autorisation_depense` varchar(50) NOT NULL,
  `status_payement` int(11) NOT NULL,
  `user_add` int(11) NOT NULL,
  `date_add` datetime NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_depense`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `depense_item`
--

DROP TABLE IF EXISTS `depense_item`;
CREATE TABLE IF NOT EXISTS `depense_item` (
  `id_depesne_item` int(11) NOT NULL AUTO_INCREMENT,
  `id_depense` int(11) NOT NULL,
  `libelle_depense` text NOT NULL,
  `quantite_depense` int(11) NOT NULL,
  `prix_achat_depense` varchar(50) NOT NULL,
  `prix_achat_total_depense` varchar(50) NOT NULL,
  `status_item_depense` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_depesne_item`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `depense_paye`
--

DROP TABLE IF EXISTS `depense_paye`;
CREATE TABLE IF NOT EXISTS `depense_paye` (
  `id_depesne_paye` int(11) NOT NULL AUTO_INCREMENT,
  `id_depense` int(11) NOT NULL,
  `code_compte` int(11) NOT NULL,
  `numero_facture_depense` varchar(50) NOT NULL,
  `montant` varchar(30) NOT NULL,
  `type_paiement` tinyint(4) NOT NULL,
  `status_paiement` tinyint(4) NOT NULL,
  `date_paiement` date NOT NULL,
  `observation` text,
  `user_add` int(11) NOT NULL,
  `date_add` datetime NOT NULL,
  `pieceFacture` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id_depesne_paye`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `helper_chron`
--

DROP TABLE IF EXISTS `helper_chron`;
CREATE TABLE IF NOT EXISTS `helper_chron` (
  `id_helper` int(11) NOT NULL AUTO_INCREMENT,
  `prefix` varchar(10) NOT NULL,
  `annee` smallint(11) NOT NULL,
  `mois` int(11) NOT NULL,
  `last_fac` varchar(30) NOT NULL,
  PRIMARY KEY (`id_helper`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `helper_chron`
--

INSERT INTO `helper_chron` (`id_helper`, `prefix`, `annee`, `mois`, `last_fac`) VALUES
(1, 'SA', 2018, 11, 'SA201811-000000'),
(2, 'LI', 2018, 11, 'LI201811-000008'),
(3, 'BCLI', 2018, 11, 'BCLI201811-000000'),
(4, 'DP', 2018, 11, 'DP201811-000000'),
(5, 'BCSA', 2018, 11, 'BCSA201811-000000'),
(6, 'BS', 2018, 11, 'BS201811-000000');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `numeroFacture` varchar(20) NOT NULL,
  `order_date` date NOT NULL,
  `client_id` int(11) NOT NULL,
  `sub_total` varchar(255) NOT NULL,
  `vat` varchar(255) NOT NULL,
  `total_amount` varchar(255) NOT NULL,
  `discount` varchar(255) NOT NULL,
  `grand_total` varchar(255) NOT NULL,
  `paid` varchar(255) NOT NULL,
  `due` varchar(255) NOT NULL,
  `payment_type` int(11) NOT NULL,
  `payment_status` int(11) NOT NULL,
  `order_status` int(11) NOT NULL DEFAULT '0',
  `factureTva` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dateJour` datetime NOT NULL,
  `agenceId` int(11) NOT NULL,
  `id_marque` int(11) DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `fk_orders_users1_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

DROP TABLE IF EXISTS `order_item`;
CREATE TABLE IF NOT EXISTS `order_item` (
  `order_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL DEFAULT '0',
  `quantity` varchar(255) NOT NULL,
  `rate` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `order_item_status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`order_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL,
  `produit_pieceCarton` tinyint(4) NOT NULL,
  `product_image` text NOT NULL,
  `brand_id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `rate` varchar(255) NOT NULL,
  `rateTva` int(11) DEFAULT NULL,
  `prix_achat` varchar(255) NOT NULL,
  `benefice` varchar(255) NOT NULL,
  `produit_tva` tinyint(1) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `id_user` int(11) NOT NULL,
  `date_add` datetime NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `categories_id` (`categories_id`),
  KEY `fk_product_users1_idx` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_stock`
--

DROP TABLE IF EXISTS `product_stock`;
CREATE TABLE IF NOT EXISTS `product_stock` (
  `productStock_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `quantity_total` int(11) NOT NULL,
  `prix_achat_total` varchar(255) NOT NULL,
  `rate_total` varchar(255) NOT NULL,
  `benefice_total` varchar(255) NOT NULL,
  `id_user` int(11) NOT NULL,
  `date_add` datetime NOT NULL,
  PRIMARY KEY (`productStock_id`),
  KEY `fk_product_users1_idx` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `produit_agence`
--

DROP TABLE IF EXISTS `produit_agence`;
CREATE TABLE IF NOT EXISTS `produit_agence` (
  `produitAgence_id` int(11) NOT NULL AUTO_INCREMENT,
  `id_agence` int(11) NOT NULL,
  `id_agence_arrive` tinyint(4) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity_total_agence` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix_vente` int(11) NOT NULL,
  `prix_achat_agence` int(11) NOT NULL,
  `prix_total_vente` int(11) NOT NULL,
  `prix_total_achat` int(11) NOT NULL,
  `benefice_total` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `date_add` datetime NOT NULL,
  `id_user_edit` int(11) DEFAULT NULL,
  `date_edit` datetime DEFAULT NULL,
  PRIMARY KEY (`produitAgence_id`),
  KEY `fk_produit_history_users1_idx` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `produit_history`
--

DROP TABLE IF EXISTS `produit_history`;
CREATE TABLE IF NOT EXISTS `produit_history` (
  `history_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `prix_achat` int(11) NOT NULL,
  `prix_vente` int(11) NOT NULL,
  `date_add` datetime NOT NULL,
  `pass_quantite` int(11) NOT NULL,
  `new_quantite` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`history_id`),
  KEY `fk_produit_history_users1_idx` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `produit_history_agence`
--

DROP TABLE IF EXISTS `produit_history_agence`;
CREATE TABLE IF NOT EXISTS `produit_history_agence` (
  `produitAgenceHistory_id` int(11) NOT NULL AUTO_INCREMENT,
  `produitAgence_id` int(11) NOT NULL,
  `id_agence` int(11) NOT NULL,
  `id_agence_arrive` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity_total_agence` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `new_quantite_agence` int(11) NOT NULL,
  `prix_vente` int(11) NOT NULL,
  `prix_achat_agence` int(11) NOT NULL,
  `prix_total_vente` int(11) NOT NULL,
  `prix_total_achat` int(11) NOT NULL,
  `benefice_total` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `date_add` datetime NOT NULL,
  PRIMARY KEY (`produitAgenceHistory_id`),
  KEY `fk_produit_history_users1_idx` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `remborsement`
--

DROP TABLE IF EXISTS `remborsement`;
CREATE TABLE IF NOT EXISTS `remborsement` (
  `id_remb` int(11) NOT NULL AUTO_INCREMENT,
  `id_order_remb` int(11) NOT NULL,
  `id_client_remb` int(11) NOT NULL,
  `montant` varchar(255) NOT NULL,
  `date_remb` date NOT NULL,
  PRIMARY KEY (`id_remb`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `societe`
--

DROP TABLE IF EXISTS `societe`;
CREATE TABLE IF NOT EXISTS `societe` (
  `societe_id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_societe` varchar(1024) NOT NULL,
  `siegle_societe` varchar(150) NOT NULL,
  `tele_societe` varchar(15) NOT NULL,
  `tele_societeSecond` varchar(15) NOT NULL,
  `postBP` varchar(50) NOT NULL,
  `pays` varchar(500) NOT NULL,
  `province` varchar(500) NOT NULL,
  `commune_societe` varchar(1024) NOT NULL,
  `quartier` varchar(250) NOT NULL,
  `avenue` varchar(250) NOT NULL,
  `numero` varchar(100) NOT NULL,
  `email_societe` varchar(50) NOT NULL,
  `assujetti_tva` int(11) NOT NULL,
  `NIF_societe` varchar(20) NOT NULL,
  `Registre_commerce` varchar(20) NOT NULL,
  `centre_fiscal` varchar(300) NOT NULL,
  `forme_juridique` varchar(1024) NOT NULL,
  `secteur_activite` varchar(1024) NOT NULL,
  `logoSociete` varchar(1024) DEFAULT NULL,
  `id_user_add` int(11) NOT NULL,
  `date_add` datetime NOT NULL,
  `id_user_edit` int(11) DEFAULT NULL,
  `date_edit` datetime DEFAULT NULL,
  PRIMARY KEY (`societe_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `id_agence` int(11) NOT NULL,
  `role` tinyint(4) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `telephone`, `id_agence`, `role`, `status`) VALUES
(1, 'admin', '6f4977585004cfad52130b5bb6eb13cf', 'bwakiza@gmail.com', '71895214', 1, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_online`
--

DROP TABLE IF EXISTS `user_online`;
CREATE TABLE IF NOT EXISTS `user_online` (
  `idOnline` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `date_enter` datetime NOT NULL,
  `date_close` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`idOnline`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_online`
--

INSERT INTO `user_online` (`idOnline`, `id_user`, `date_enter`, `date_close`, `status`) VALUES
(1, 1, '2018-12-20 23:12:02', '2018-12-20 23:12:06', 2),
(9, 1, '2018-12-30 22:12:53', '2018-12-30 00:00:00', 1),
(8, 1, '2018-12-30 22:12:09', '2018-12-30 22:12:55', 2);

-- --------------------------------------------------------

--
-- Table structure for table `versement`
--

DROP TABLE IF EXISTS `versement`;
CREATE TABLE IF NOT EXISTS `versement` (
  `id_versement` int(11) NOT NULL AUTO_INCREMENT,
  `id_banque` int(11) NOT NULL,
  `montant_verse` varchar(255) NOT NULL,
  `numero_compte_banque` varchar(255) NOT NULL,
  `nom_personne_verse` varchar(150) NOT NULL,
  `numero_bordereau` varchar(100) NOT NULL,
  `date_bordereau` date NOT NULL,
  `type_versement` int(11) NOT NULL,
  `user_add_verserment` int(11) NOT NULL,
  `date_add_versement` datetime NOT NULL,
  `pieceversement` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_versement`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `fk_categories_brands1` FOREIGN KEY (`idBrand`) REFERENCES `brands` (`brand_id`) ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_users1` FOREIGN KEY (`id_user`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`categories_id`) ON UPDATE CASCADE;

--
-- Constraints for table `produit_history`
--
ALTER TABLE `produit_history`
  ADD CONSTRAINT `fk_produit_history_users1` FOREIGN KEY (`id_user`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
