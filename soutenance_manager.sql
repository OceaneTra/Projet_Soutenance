-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : dim. 22 juin 2025 à 18:54
-- Version du serveur : 8.0.42
-- Version de PHP : 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `soutenance_manager`
--

-- --------------------------------------------------------

--
-- Structure de la table `action`
--

CREATE TABLE `action` (
  `id_action` int NOT NULL,
  `lib_action` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `action`
--

INSERT INTO `action` (`id_action`, `lib_action`) VALUES
(3, 'Modifier'),
(6, 'Supprimer'),
(7, 'Consulter');

-- --------------------------------------------------------

--
-- Structure de la table `affecter`
--

CREATE TABLE `affecter` (
  `id_enseignant` int NOT NULL,
  `id_rapport` int NOT NULL,
  `id_jury` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `annee_academique`
--

CREATE TABLE `annee_academique` (
  `id_annee_acad` int NOT NULL,
  `date_deb` date NOT NULL,
  `date_fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

--
-- Déchargement des données de la table `annee_academique`
--

INSERT INTO `annee_academique` (`id_annee_acad`, `date_deb`, `date_fin`) VALUES
(21413, '2013-09-08', '2014-06-25'),
(21514, '2014-09-02', '2015-06-21'),
(21615, '2015-09-03', '2016-06-24'),
(21716, '2016-09-05', '2017-06-20'),
(21817, '2017-09-01', '2018-06-25'),
(21918, '2018-09-04', '2019-06-23'),
(22019, '2019-09-08', '2020-06-24'),
(22120, '2020-09-01', '2021-06-27'),
(22221, '2021-09-08', '2022-07-20'),
(22322, '2022-09-10', '2023-07-31'),
(22423, '2023-09-11', '2024-07-17'),
(22524, '2024-09-10', '2025-07-30');

-- --------------------------------------------------------

--
-- Structure de la table `approuver`
--

CREATE TABLE `approuver` (
  `id_pers_admin` int NOT NULL,
  `id_rapport` int NOT NULL,
  `date_approv` datetime NOT NULL,
  `commentaire_approv` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `avoir`
--

CREATE TABLE `avoir` (
  `id_grade` int NOT NULL,
  `id_enseignant` int NOT NULL,
  `date_grade` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

--
-- Déchargement des données de la table `avoir`
--

INSERT INTO `avoir` (`id_grade`, `id_enseignant`, `date_grade`) VALUES
(10, 2, '2023-06-05'),
(12, 5, '2015-05-04'),
(7, 7, '2022-05-04'),
(7, 9, '2020-06-27'),
(7, 10, '2018-02-12'),
(6, 11, '2018-05-13');

-- --------------------------------------------------------

--
-- Structure de la table `candidature_soutenance`
--

CREATE TABLE `candidature_soutenance` (
  `id_candidature` int NOT NULL,
  `num_etu` int NOT NULL,
  `date_candidature` datetime NOT NULL,
  `statut_candidature` enum('En attente','Approuvée','Rejetée') NOT NULL DEFAULT 'En attente',
  `date_traitement` datetime DEFAULT NULL,
  `commentaire_admin` text,
  `id_pers_admin` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `candidature_soutenance`
--

INSERT INTO `candidature_soutenance` (`id_candidature`, `num_etu`, `date_candidature`, `statut_candidature`, `date_traitement`, `commentaire_admin`, `id_pers_admin`) VALUES
(1, 2004003, '2025-06-06 00:49:02', 'En attente', NULL, NULL, NULL),
(3, 2007003, '2025-06-06 02:35:15', 'En attente', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `compte_rendu`
--

CREATE TABLE `compte_rendu` (
  `id_CR` int NOT NULL,
  `num_etu` int NOT NULL,
  `nom_CR` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `date_CR` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `deposer`
--

CREATE TABLE `deposer` (
  `num_etu` int NOT NULL,
  `id_rapport` int NOT NULL,
  `date_depot` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `echeances`
--

CREATE TABLE `echeances` (
  `id_echeance` int NOT NULL,
  `id_inscription` int DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  `date_echeance` date DEFAULT NULL,
  `statut_echeance` enum('En attente','Payée','En retard') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `echeances`
--

INSERT INTO `echeances` (`id_echeance`, `id_inscription`, `montant`, `date_echeance`, `statut_echeance`) VALUES
(1, 1, 565000.00, '2025-09-01', 'En attente'),
(2, 2, 565000.00, '2025-09-01', 'En attente'),
(6, 4, 188333.33, '2025-09-01', 'En attente'),
(7, 4, 188333.33, '2025-12-01', 'En attente'),
(8, 4, 188333.33, '2026-03-01', 'En attente'),
(10, 16, 205000.00, '2025-09-03', 'En attente'),
(11, 16, 205000.00, '2025-12-03', 'En attente'),
(12, 17, 565000.00, '2025-09-03', 'En attente'),
(15, 19, 410000.00, '2025-09-03', 'En attente'),
(36, 18, 220000.00, '2025-09-03', 'En attente'),
(37, 18, 220000.00, '2025-12-03', 'En attente'),
(38, 20, 565000.00, '2025-09-04', 'En attente'),
(49, 25, 565000.00, '2025-09-04', 'En attente'),
(50, 26, 565000.00, '2025-09-04', 'En attente');

-- --------------------------------------------------------

--
-- Structure de la table `ecue`
--

CREATE TABLE `ecue` (
  `id_ecue` int NOT NULL,
  `id_ue` int NOT NULL,
  `lib_ecue` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `credit` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

--
-- Déchargement des données de la table `ecue`
--

INSERT INTO `ecue` (`id_ecue`, `id_ue`, `lib_ecue`, `credit`) VALUES
(7, 8, 'Economie 1', 2),
(9, 8, 'Economie 2', 2),
(10, 13, 'Suites et fonctions', 3),
(11, 13, 'Calcul intégral', 2),
(12, 14, 'Elements de logique', 2),
(13, 14, 'Structures algébriques', 3),
(14, 17, 'Géométrie', 1),
(15, 17, 'Calcul matriciel', 2),
(16, 17, 'espaces vectoriels', 3),
(17, 18, 'Probabilités 1', 2),
(18, 18, 'Statistique 1', 2),
(19, 18, 'Initiation au langage R', 1),
(20, 82, 'Algorithmique', 3),
(21, 82, 'programmation Java', 2),
(22, 21, 'Methodologie de travail', 1),
(23, 21, 'Technique d\'expression', 1),
(24, 26, 'Fondamentaux de POO', 3),
(25, 26, 'Programmation POO', 3),
(26, 28, 'Analyse 2', 3),
(27, 28, 'Algèbre', 3),
(28, 29, 'Probabilités 2', 2),
(29, 29, 'Statistique 2', 2),
(30, 30, 'Modèle comptable', 2),
(31, 30, 'Opérations comptables', 2),
(32, 30, 'Opérations d\'inventaires', 2),
(33, 32, 'Arithmétique', 2),
(34, 33, 'Base de données relationnelles', 3),
(35, 33, 'Données semi-structurées', 2),
(36, 33, 'base de données et applications', 3),
(37, 35, 'Initiation au Langage SCALA', 2),
(38, 35, 'Atelier de Génie Logiciel', 4),
(39, 36, 'Programmation VBA', 2),
(40, 36, 'Programmation C#', 2),
(41, 38, 'Application à la cryptographie', 2),
(42, 40, 'Fondamentaux des systèmes d\'exploitation', 2),
(43, 40, 'UNIX et langage C', 4),
(44, 41, 'Algo avancé et Java', 5),
(45, 46, 'Suivi des performances', 2),
(46, 46, 'Coût complet et coût partiel', 2),
(47, 9, 'Fondamentaux des réseaux', 3),
(48, 9, 'Internet/Intranet', 2),
(49, 56, 'ISI', 2),
(50, 56, 'UML', 3),
(51, 57, 'Files d\'attente et gestion de stock', 3),
(52, 57, 'Regression linéaire', 1);

-- --------------------------------------------------------

--
-- Structure de la table `enseignants`
--

CREATE TABLE `enseignants` (
  `id_enseignant` int NOT NULL,
  `nom_enseignant` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `prenom_enseignant` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `mail_enseignant` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `id_specialite` int NOT NULL,
  `type_enseignant` enum('Simple','Administratif') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

--
-- Déchargement des données de la table `enseignants`
--

INSERT INTO `enseignants` (`id_enseignant`, `nom_enseignant`, `prenom_enseignant`, `mail_enseignant`, `id_specialite`, `type_enseignant`) VALUES
(2, 'Brou', 'Patrice', 'angeaxelgomez@gmail.com', 2, 'Simple'),
(5, 'Kouakou', 'Mathias', 'axelangegomez@gmail.com', 5, 'Simple'),
(7, 'Koua', 'Brou', 'oceanetl27@gmail.com', 2, 'Simple'),
(9, 'N\'golo', 'Konaté', 'ngolokonate@yahoo.fr', 2, 'Simple'),
(10, 'Nindjin', 'Malan', 'nindjinmalan@gmail.com', 2, 'Simple'),
(11, 'Kouakou', 'Florent', 'kouakouflorent@gmail.com', 5, 'Simple');

-- --------------------------------------------------------

--
-- Structure de la table `entreprises`
--

CREATE TABLE `entreprises` (
  `id_entreprise` int NOT NULL,
  `lib_entreprise` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

--
-- Déchargement des données de la table `entreprises`
--

INSERT INTO `entreprises` (`id_entreprise`, `lib_entreprise`) VALUES
(3, 'Deloitte Côte d\'Ivoire'),
(5, 'Orange Côte d\'Ivoire'),
(7, 'Tuzzo Côte d\'Ivoire');

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

CREATE TABLE `etudiants` (
  `num_etu` int NOT NULL,
  `nom_etu` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `prenom_etu` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `email_etu` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `date_naiss_etu` date NOT NULL,
  `genre_etu` enum('Homme','Femme','Neutre') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `promotion_etu` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

--
-- Déchargement des données de la table `etudiants`
--

INSERT INTO `etudiants` (`num_etu`, `nom_etu`, `prenom_etu`, `email_etu`, `date_naiss_etu`, `genre_etu`, `promotion_etu`) VALUES
(2003001, 'Brou', 'Kouamé Wa Ambroise', 'kouame.brou@miage.edu', '1980-05-15', 'Homme', '2003-2004'),
(2003002, 'Coulibaly', 'Pécory Ismaèl', 'pecory.coulibaly@miage.edu', '1981-07-22', 'Homme', '2003-2004'),
(2003003, 'Diomandé', 'Gondo Patrick', 'gondo.diomande@miage.edu', '1980-11-30', 'Homme', '2003-2004'),
(2003004, 'Ekponou', 'Georges', 'georges.ekponou@miage.edu', '1981-03-18', 'Homme', '2003-2004'),
(2003005, 'Gnaman', 'Arthur Berenger', 'arthur.gnaman@miage.edu', '1980-09-12', 'Homme', '2003-2004'),
(2003006, 'Guiégui', 'Arnaud Kévin Boris', 'arnaud.guiegui@miage.edu', '1981-01-25', 'Homme', '2003-2004'),
(2003007, 'Kacou', 'Allou Yves-Roland', 'yves.kacou@miage.edu', '1980-08-07', 'Homme', '2003-2004'),
(2003008, 'Kadio', 'Paule Elodie', 'elodie.kadio@miage.edu', '1981-04-14', 'Femme', '2003-2004'),
(2003009, 'Kéi', 'Ninsémon Hervé', 'herve.kei@miage.edu', '1980-12-03', 'Homme', '2003-2004'),
(2003010, 'Kinimo', 'Habia Elvire', 'elvire.kinimo@miage.edu', '1981-06-19', 'Femme', '2003-2004'),
(2003011, 'Kouadio', 'Donald', 'donald.kouadio@miage.edu', '1980-02-28', 'Homme', '2003-2004'),
(2003012, 'Kouadio', 'Sékédoua Jules', 'jules.kouadio@miage.edu', '1981-10-08', 'Homme', '2003-2004'),
(2003013, 'Mambo', 'Katty Tatiana', 'tatiana.mambo@miage.edu', '1980-07-17', 'Femme', '2003-2004'),
(2003014, 'Mukenge', 'Kalenga', 'kalenga.mukenge@miage.edu', '1981-09-05', 'Homme', '2003-2004'),
(2003015, 'N\'guessan', 'Constant', 'constant.nguessan@miage.edu', '1980-04-21', 'Homme', '2003-2004'),
(2003016, 'Niamien', 'Casimir', 'casimir.niamien@miage.edu', '1981-12-11', 'Homme', '2003-2004'),
(2003017, 'Oula', 'Séblé Lucien', 'lucien.oula@miage.edu', '1980-03-09', 'Homme', '2003-2004'),
(2003018, 'Sagnon', 'Boga Eric', 'eric.sagnon@miage.edu', '1981-05-30', 'Homme', '2003-2004'),
(2003019, 'Tiémélé', 'Solange', 'solange.tieme@miage.edu', '1981-06-30', 'Femme', '2003-2004'),
(2003020, 'Yao', 'Hermann Berenger', 'yao.hermann@miage.edu', '1982-03-27', 'Homme', '2003-2004'),
(2003021, 'Yao', 'Michaelle Sylvie', 'yao.mickaelle@miage.edu', '1986-03-27', 'Femme', '2003-2004'),
(2003022, 'Zakpa', 'Emmanuella', 'zakpa.emmanuella@miage.edu', '1982-08-25', 'Femme', '2003-2004'),
(2004001, 'Agounkpeto', 'Jean Michel', 'jean.agounkpeto@miage.edu', '1981-06-22', 'Homme', '2004-2005'),
(2004002, 'Aka', 'Ange Kévin', 'ange.aka@miage.edu', '1982-08-15', 'Homme', '2004-2005'),
(2004003, 'Aka', 'Prince', 'prince.aka@miage.edu', '1981-12-03', 'Homme', '2004-2005'),
(2004004, 'Akpa', 'Gnagne David Martial', 'david.akpa@miage.edu', '1982-04-18', 'Homme', '2004-2005'),
(2004005, 'Barthe', 'Kobi Hugues Didier', 'hugues.barthe@miage.edu', '1981-10-29', 'Homme', '2004-2005'),
(2004006, 'Djehéré', 'Claude', 'claude.djehere@miage.edu', '1982-02-14', 'Homme', '2004-2005'),
(2004007, 'Doumun', 'Mékapeu Solange', 'solange.doumun@miage.edu', '1981-07-07', 'Femme', '2004-2005'),
(2004008, 'Gogori', 'N\'guessan Etienne Hugues', 'etienne.gogori@miage.edu', '1982-05-21', 'Homme', '2004-2005'),
(2004009, 'Gouzou', 'Zékou Mathurin', 'mathurin.gouzou@miage.edu', '1981-09-30', 'Homme', '2004-2005'),
(2004010, 'Kacou', 'Akimba Carolle', 'carolle.kacou@miage.edu', '1982-01-12', 'Femme', '2004-2005'),
(2004011, 'Koffi', 'Bi Tiessé Franck', 'franck.koffi@miage.edu', '1981-11-25', 'Homme', '2004-2005'),
(2004012, 'Koné', 'Pétiéninpou Salifou', 'salifou.kone@miage.edu', '1982-03-08', 'Homme', '2004-2005'),
(2004013, 'Kouadé', 'Ano Jean', 'jean.kouade@miage.edu', '1981-08-17', 'Homme', '2004-2005'),
(2004014, 'Kouadio', 'Assi Donald Landry', 'donald.kouadio@miage.edu', '1982-06-19', 'Homme', '2004-2005'),
(2004015, 'Kouamé', 'Marie Paule', 'marie.kouame@miage.edu', '1981-04-05', 'Femme', '2004-2005'),
(2004016, 'Ossey', 'Tanguy', 'tanguy.ossey@miage.edu', '1982-10-27', 'Homme', '2004-2005'),
(2004017, 'Touré', 'Badiénry Fabrice', 'fabrice.toure@miage.edu', '1981-12-22', 'Homme', '2004-2005'),
(2004018, 'Yéré', 'Adou Vincent', 'vincent.yere@miage.edu', '1982-07-14', 'Homme', '2004-2005'),
(2005001, 'Aby', 'Nanpé Olivier', 'olivier.aby@miage.edu', '1982-01-15', 'Homme', '2005-2006'),
(2005002, 'Aliman', 'Prisca', 'prisca.aliman@miage.edu', '1983-03-28', 'Femme', '2005-2006'),
(2005003, 'Bakayoko', 'Soumaila', 'soumaila.bakayoko@miage.edu', '1982-09-10', 'Homme', '2005-2006'),
(2005004, 'Berthé', 'Issa', 'issa.berthe@miage.edu', '1983-05-22', 'Homme', '2005-2006'),
(2005005, 'Dacoury', 'Armand', 'armand.dacoury@miage.edu', '1982-11-07', 'Homme', '2005-2006'),
(2005006, 'Diallo', 'Marlène', 'marlene.diallo@miage.edu', '1983-07-19', 'Femme', '2005-2006'),
(2005007, 'Dossou', 'Falome Flora', 'flora.dossou@miage.edu', '1982-04-03', 'Femme', '2005-2006'),
(2005008, 'Fofana', 'Lazeni', 'lazeni.fofana@miage.edu', '1983-08-25', 'Homme', '2005-2006'),
(2005009, 'Fongbé', 'Amadou', 'amadou.fongbe@miage.edu', '1982-12-30', 'Homme', '2005-2006'),
(2005010, 'Gnamien', 'Badjo Carine', 'carine.gnamien@miage.edu', '1983-02-14', 'Femme', '2005-2006'),
(2005011, 'Kalou', 'Bi Florent', 'florent.kalou@miage.edu', '1982-06-18', 'Homme', '2005-2006'),
(2005012, 'Kané', 'Kader', 'kader.kane@miage.edu', '1983-10-09', 'Homme', '2005-2006'),
(2005013, 'Konan', 'Hermann Michel', 'hermann.konan@miage.edu', '1982-07-22', 'Homme', '2005-2006'),
(2005014, 'Koné', 'Djébilou', 'djebilou.kone@miage.edu', '1983-01-05', 'Homme', '2005-2006'),
(2005015, 'Koné', 'Moussa', 'moussa.kone@miage.edu', '1982-05-17', 'Homme', '2005-2006'),
(2005016, 'Kouyaté', 'Bangali', 'bangali.kouyate@miage.edu', '1983-09-28', 'Homme', '2005-2006'),
(2005017, 'Latte', 'Pierre André', 'pierre.latte@miage.edu', '1982-03-11', 'Homme', '2005-2006'),
(2005018, 'Méango', 'Jean Marie', 'jean.meango@miage.edu', '1983-04-24', 'Homme', '2005-2006'),
(2005019, 'Mian', 'Koffi Jules Césare', 'jules.mian@miage.edu', '1982-08-07', 'Homme', '2005-2006'),
(2005020, 'Monsan', 'Chimène', 'chimene.monsan@miage.edu', '1983-12-19', 'Femme', '2005-2006'),
(2005021, 'Mouhamed', 'Moubarak', 'moubarak.mouhamed@miage.edu', '1982-10-02', 'Homme', '2005-2006'),
(2005022, 'N\'goran', 'Yao Dénis', 'denis.ngoran@miage.edu', '1983-06-15', 'Homme', '2005-2006'),
(2005023, 'N\'guessan', 'Jacques', 'jacques.nguessan@miage.edu', '1982-02-28', 'Homme', '2005-2006'),
(2005024, 'Ossey', 'Sabrina', 'sabrina.ossey@miage.edu', '1983-11-11', 'Femme', '2005-2006'),
(2005025, 'Ouattara', 'Ecaré Myriam', 'myriam.ouattara@miage.edu', '1982-01-23', 'Femme', '2005-2006'),
(2005026, 'Ouffoué', 'Yawyha Attinouanfier J.', 'yawyha.ouffoue@miage.edu', '1983-07-06', 'Homme', '2005-2006'),
(2005027, 'Sassou', 'Mensah Boris', 'boris.sassou@miage.edu', '1982-04-19', 'Homme', '2005-2006'),
(2005028, 'Soumahoro', 'Badra Ali', 'ali.soumahoro@miage.edu', '1983-08-31', 'Homme', '2005-2006'),
(2005029, 'Tanoh', 'Kouassi Pacome', 'pacome.tanoh@miage.edu', '1982-12-14', 'Homme', '2005-2006'),
(2005030, 'Yaméogo', 'Emmanuel', 'emmanuel.yameogo@miage.edu', '1983-05-27', 'Homme', '2005-2006'),
(2006001, 'Akinola', 'Oyéniyi Alexis Laurent S.', 'alexis.akinola@miage.edu', '1983-02-15', 'Homme', '2006-2007'),
(2006002, 'Attisou', 'Jean-François', 'jean-francois.attisou@miage.edu', '1984-04-28', 'Homme', '2006-2007'),
(2006003, 'Badouon', 'Ange Rodrigue', 'rodrigue.badouon@miage.edu', '1983-10-10', 'Homme', '2006-2007'),
(2006004, 'Bédy', 'Nathanael Durand', 'nathanael.bedy@miage.edu', '1984-06-22', 'Homme', '2006-2007'),
(2006005, 'Blé', 'Aka Jean-Jacques Ferdinand', 'jean-jacques.ble@miage.edu', '1983-12-07', 'Homme', '2006-2007'),
(2006006, 'Bodjé', 'Hippolyte', 'hippolyte.bodje@miage.edu', '1984-08-19', 'Homme', '2006-2007'),
(2006007, 'Bodjé', 'N\'kauh Nathan Regis', 'nathan.bodje@miage.edu', '1983-05-03', 'Homme', '2006-2007'),
(2006008, 'Bouraïman', 'Farwaz', 'farwaz.bouraiman@miage.edu', '1984-09-25', 'Homme', '2006-2007'),
(2006009, 'Brou', 'Kouakou Ange', 'ange.brou@miage.edu', '1983-01-30', 'Homme', '2006-2007'),
(2006010, 'Cissé', 'Souleymane Désiré Cédric', 'souleymane.cisse@miage.edu', '1984-03-14', 'Homme', '2006-2007'),
(2006011, 'Diallo', 'Mamadou', 'mamadou.diallo@miage.edu', '1983-07-18', 'Homme', '2006-2007'),
(2006012, 'Dja', 'Blé Robert Martial', 'robert.dja@miage.edu', '1984-11-09', 'Homme', '2006-2007'),
(2006013, 'Dobé', 'Anicet Landry G.', 'landry.dobe@miage.edu', '1983-08-22', 'Homme', '2006-2007'),
(2006014, 'Doh', 'Alain Hyppolyte', 'alain.doh@miage.edu', '1984-02-05', 'Homme', '2006-2007'),
(2006015, 'Fanoudh-Siefer', 'Jocelyne', 'jocelyne.fanoudh@miage.edu', '1983-06-17', 'Femme', '2006-2007'),
(2006016, 'Fioklou', 'Mawuena Linda Sandrine', 'linda.fioklou@miage.edu', '1984-10-28', 'Femme', '2006-2007'),
(2006017, 'Gami', 'Tizié Bi Eric', 'eric.gami@miage.edu', '1983-04-11', 'Homme', '2006-2007'),
(2006018, 'Gnanagbé', 'Gilles Gohou', 'gilles.gnanagbe@miage.edu', '1984-07-24', 'Homme', '2006-2007'),
(2006019, 'Gouley', 'Vincent de Paul', 'vincent.gouley@miage.edu', '1983-09-07', 'Homme', '2006-2007'),
(2006020, 'Koffi', 'Kouassi Michel', 'michel.koffi@miage.edu', '1984-01-19', 'Homme', '2006-2007'),
(2006021, 'Koné', 'Moussa', 'moussa.kone2@miage.edu', '1983-05-02', 'Homme', '2006-2007'),
(2006022, 'Kouamé', 'Kouamenan Jean Baptiste', 'jean.kouame@miage.edu', '1984-12-15', 'Homme', '2006-2007'),
(2006023, 'Kouman', 'Kobenan Constant', 'constant.kouman@miage.edu', '1983-03-28', 'Homme', '2006-2007'),
(2006024, 'Maïga', 'Jean-Luc Hervé Morel', 'jean-luc.maiga@miage.edu', '1984-06-10', 'Homme', '2006-2007'),
(2006025, 'N\'gadjingar', 'Arnold', 'arnold.ngadjingar@miage.edu', '1983-10-23', 'Homme', '2006-2007'),
(2006026, 'N\'guessan', 'Medri suzanne Sandrine', 'suzanne.nguessan@miage.edu', '1984-04-05', 'Femme', '2006-2007'),
(2006027, 'Nindjin', 'Malan Alain', 'alain.nindjin@miage.edu', '1983-08-18', 'Homme', '2006-2007'),
(2006028, 'Oussou', 'Gbogboly Romaric Anselme', 'romaric.oussou@miage.edu', '1984-02-28', 'Homme', '2006-2007'),
(2006029, 'Rabet', 'Stéphane', 'stephane.rabet@miage.edu', '1983-07-11', 'Homme', '2006-2007'),
(2006030, 'Sékongo', 'Kafalo David', 'david.sekongo@miage.edu', '1984-11-24', 'Homme', '2006-2007'),
(2006031, 'Sékongo', 'Kafalo Siméon', 'simeon.sekongo@miage.edu', '1983-01-06', 'Homme', '2006-2007'),
(2006032, 'Sékongo', 'Sionta Débora', 'debora.sekongo@miage.edu', '1984-05-19', 'Femme', '2006-2007'),
(2006033, 'Senin', 'N\'guetta Patrick Yoann', 'patrick.senin@miage.edu', '1983-09-01', 'Homme', '2006-2007'),
(2006034, 'Tanoh-Niangoin', 'Arnaud Joël', 'arnaud.tanoh@miage.edu', '1984-12-14', 'Homme', '2006-2007'),
(2006035, 'Tchétché', 'Lazare', 'lazare.tchetche@miage.edu', '1983-04-27', 'Homme', '2006-2007'),
(2006036, 'Tchicaillat', 'Anelvie', 'anelvie.tchicaillat@miage.edu', '1984-08-09', 'Femme', '2006-2007'),
(2006037, 'Tiémélé', 'Amandi Jean-Michel', 'jean-michel.tieme@miage.edu', '1983-02-21', 'Homme', '2006-2007'),
(2006038, 'Traoré', 'Kigninlman François-Michaël', 'francois.traore@miage.edu', '1984-07-04', 'Homme', '2006-2007'),
(2006039, 'Traoré', 'Mamadou Ben', 'mamadou.traore@miage.edu', '1983-11-17', 'Homme', '2006-2007'),
(2006040, 'Yaméogo', 'Emmanuel', 'emmanuel.yameogo2@miage.edu', '1984-03-30', 'Homme', '2006-2007'),
(2006041, 'Yoboué', 'Kouamé Françis', 'francis.yoboue@miage.edu', '1983-10-13', 'Homme', '2006-2007'),
(2006042, 'Zokou', 'Gbalé Simion', 'simion.zokou@miage.edu', '1984-05-26', 'Homme', '2006-2007'),
(2007001, 'Abroh', 'Alokré Samuel Eliézer', 'samuel.abroh@miage.edu', '1984-01-15', 'Homme', '2007-2008'),
(2007002, 'Abudrahman', 'Bako Rouhiya', 'rouhiya.abudrahman@miage.edu', '1985-03-28', 'Femme', '2007-2008'),
(2007003, 'Acho', 'Dessi Stéphane Ivan', 'stephane.acho@miage.edu', '1984-09-10', 'Homme', '2007-2008'),
(2007004, 'Adja', 'Willy Junior', 'willy.adja@miage.edu', '1985-05-22', 'Homme', '2007-2008'),
(2007005, 'Aka', 'Manouan Angora Jean-Yves', 'jean-yves.aka@miage.edu', '1984-11-07', 'Homme', '2007-2008'),
(2007006, 'Allou', 'Niamké Jean-Marc', 'jean-marc.allou@miage.edu', '1985-07-19', 'Homme', '2007-2008'),
(2007007, 'Assy', 'Yves Landry', 'yves.assy@miage.edu', '1984-04-03', 'Homme', '2007-2008'),
(2007008, 'Bouah', 'Martin Benjamin', 'martin.bouah@miage.edu', '1985-08-25', 'Homme', '2007-2008'),
(2007009, 'Cissé', 'Ladji', 'ladji.cisse@miage.edu', '1984-12-30', 'Homme', '2007-2008'),
(2007010, 'Dagbo', 'Ouraga Hervé', 'herve.dagbo@miage.edu', '1985-02-14', 'Homme', '2007-2008'),
(2007011, 'Dagnogo', 'Chigata', 'chigata.dagnogo@miage.edu', '1984-06-18', 'Homme', '2007-2008'),
(2007012, 'Degni', 'N\'drin Marie-Corine Jordane', 'marie.degni@miage.edu', '1985-10-09', 'Femme', '2007-2008'),
(2007013, 'Djeah', 'Eric', 'eric.djeah@miage.edu', '1984-07-22', 'Homme', '2007-2008'),
(2007014, 'Fagla', 'Armel Jean Yves', 'jean.fagla@miage.edu', '1985-01-05', 'Homme', '2007-2008'),
(2007015, 'Gnayoro', 'Dano Hugues Florent', 'hugues.gnayoro@miage.edu', '1984-05-17', 'Homme', '2007-2008'),
(2007016, 'Gohourou', 'Djédjé Didier', 'didier.gohourou@miage.edu', '1985-09-28', 'Homme', '2007-2008'),
(2007017, 'Houi', 'Sosthène', 'sosthene.houi@miage.edu', '1984-03-11', 'Homme', '2007-2008'),
(2007018, 'Houssou', 'Ipou Marie-Ange Colette', 'marie-ange.houssou@miage.edu', '1985-04-24', 'Femme', '2007-2008'),
(2007019, 'Kabran', 'N\'guessan Jules-César', 'jules.kabran@miage.edu', '1984-08-07', 'Homme', '2007-2008'),
(2007020, 'Kacou', 'N\'da Geneviève', 'genevieve.kacou@miage.edu', '1985-12-19', 'Femme', '2007-2008'),
(2007021, 'Kanaté', 'Adama', 'adama.kanate@miage.edu', '1984-10-02', 'Homme', '2007-2008'),
(2007022, 'Konan', 'Attocoly Aristide Christian', 'aristide.konan@miage.edu', '1985-06-15', 'Homme', '2007-2008'),
(2007023, 'Kotei', 'Nikoi Samuel', 'samuel.kotei@miage.edu', '1984-02-28', 'Homme', '2007-2008'),
(2007024, 'Koua', 'Konin N\'goran Marc Benjamin', 'marc.koua@miage.edu', '1985-11-11', 'Homme', '2007-2008'),
(2007025, 'Kouacou', 'Adjoua Jessica Noelle', 'jessica.kouacou@miage.edu', '1984-01-23', 'Femme', '2007-2008'),
(2007026, 'Kouamé', 'Ayoua Alain Blédoumou', 'alain.kouame@miage.edu', '1985-07-06', 'Homme', '2007-2008'),
(2007027, 'Kouamé', 'Bi Gohoré Stéphane-Marcel', 'stephane.kouame@miage.edu', '1984-04-19', 'Homme', '2007-2008'),
(2007028, 'Kouao', 'Akoissy Amoan Lynda Flore', 'lynda.kouao@miage.edu', '1985-08-31', 'Femme', '2007-2008'),
(2007029, 'Kouodé', 'Nioulé Steve', 'steve.kouode@miage.edu', '1984-12-14', 'Homme', '2007-2008'),
(2007030, 'Loba', 'Badjo Caroline Vinciane', 'caroline.loba@miage.edu', '1985-05-27', 'Femme', '2007-2008'),
(2007031, 'Mariko', 'Eba Raïssa', 'raissa.mariko@miage.edu', '1984-09-09', 'Femme', '2007-2008'),
(2007032, 'Moukounzi', 'Bakala Axel', 'axel.moukounzi@miage.edu', '1985-01-22', 'Homme', '2007-2008'),
(2007033, 'N\'diaye', 'M\'baye', 'mbaye.ndiaye@miage.edu', '1984-06-05', 'Homme', '2007-2008'),
(2007034, 'Niamké', 'Ehuia Marie-Eve', 'marie-eve.niamke@miage.edu', '1985-10-18', 'Femme', '2007-2008'),
(2007035, 'Oué', 'Simon', 'simon.oue@miage.edu', '1984-03-01', 'Homme', '2007-2008'),
(2008001, 'Akanza', 'Kouassi Ronald', 'ronald.akanza@miage.edu', '1985-02-15', 'Homme', '2008-2009'),
(2008002, 'Ané', 'Antoine Ahoua', 'antoine.ane@miage.edu', '1986-04-28', 'Homme', '2008-2009'),
(2008003, 'Ango', 'Charles Erwan Brou', 'charles.ango@miage.edu', '1985-10-10', 'Homme', '2008-2009'),
(2008004, 'Anon', 'Noelly', 'noelly.anon@miage.edu', '1986-06-22', 'Femme', '2008-2009'),
(2008005, 'Boni', 'Jean-Philipe', 'jean-philipe.boni@miage.edu', '1985-12-07', 'Homme', '2008-2009'),
(2008006, 'Boua', 'Stéphane Guesso', 'stephane.boua@miage.edu', '1986-08-19', 'Homme', '2008-2009'),
(2008007, 'Coulibaly', 'Sékoumar Ayaké', 'sekoumar.coulibaly@miage.edu', '1985-05-03', 'Homme', '2008-2009'),
(2008008, 'Diallo', 'Ismaël', 'ismael.diallo@miage.edu', '1986-09-25', 'Homme', '2008-2009'),
(2008009, 'Diawara', 'Khady', 'khady.diawara@miage.edu', '1985-01-30', 'Femme', '2008-2009'),
(2008010, 'Djédjé', 'Manoko Arthur-Ange', 'arthur.djedje@miage.edu', '1986-03-14', 'Homme', '2008-2009'),
(2008011, 'Dongo', 'Kouamé Yannick', 'yannick.dongo@miage.edu', '1985-07-18', 'Homme', '2008-2009'),
(2008012, 'Doou', 'Serge Baulais', 'serge.doou@miage.edu', '1986-11-09', 'Homme', '2008-2009'),
(2008013, 'Douampo', 'Berthe', 'berthe.douampo@miage.edu', '1985-08-22', 'Femme', '2008-2009'),
(2008014, 'Goeh-Akue', 'Adoté Fabrice', 'fabrice.goeh@miage.edu', '1986-02-05', 'Homme', '2008-2009'),
(2008015, 'Kanga', 'Didier Franck', 'didier.kanga@miage.edu', '1985-06-17', 'Homme', '2008-2009'),
(2008016, 'Kanté', 'Néné', 'nene.kante@miage.edu', '1986-10-28', 'Femme', '2008-2009'),
(2008017, 'Kéïta', 'Abdul Pierre Emmanuel', 'pierre.keita@miage.edu', '1985-04-11', 'Homme', '2008-2009'),
(2008018, 'Kouadio', 'Ange Aristide', 'aristide.kouadio@miage.edu', '1986-07-24', 'Homme', '2008-2009'),
(2008019, 'Kouadio', 'Loukou Arnaud', 'arnaud.kouadio@miage.edu', '1985-09-07', 'Homme', '2008-2009'),
(2008020, 'Kouahouri', 'Okou Joel', 'joel.kouahouri@miage.edu', '1986-01-19', 'Homme', '2008-2009'),
(2008021, 'Kouamé', 'N\'woley Kévin', 'kevin.kouame@miage.edu', '1985-05-02', 'Homme', '2008-2009'),
(2008022, 'Kouassi', 'Kamelan Herman', 'herman.kouassi@miage.edu', '1986-12-15', 'Homme', '2008-2009'),
(2008023, 'Lobé', 'Ogonnin Gédéon', 'gedeon.lobe@miage.edu', '1985-03-28', 'Homme', '2008-2009'),
(2008024, 'M\'bra', 'Koffi Serges Pacôme', 'serges.mbra@miage.edu', '1986-06-10', 'Homme', '2008-2009'),
(2008025, 'Namongo', 'Soro Christian Etienne', 'christian.namongo@miage.edu', '1985-10-23', 'Homme', '2008-2009'),
(2008026, 'N\'da-Ezoa', 'Melanwa Issac', 'issac.ndaezoa@miage.edu', '1986-04-05', 'Homme', '2008-2009'),
(2008027, 'N\'guessan', 'Ahoko Lazare', 'lazare.nguessan@miage.edu', '1985-08-18', 'Homme', '2008-2009'),
(2008028, 'N\'zazi', 'Yannick', 'yannick.nzazi@miage.edu', '1986-02-28', 'Homme', '2008-2009'),
(2008029, 'Ouattara', 'Nambé Adama', 'adama.ouattara@miage.edu', '1985-07-11', 'Homme', '2008-2009'),
(2008030, 'Sawadogo', 'Moussa', 'moussa.sawadogo@miage.edu', '1986-11-24', 'Homme', '2008-2009'),
(2009001, 'Akini', 'Marie Danielle', 'marie.akini@miage.edu', '1986-01-15', 'Femme', '2009-2010'),
(2009002, 'Arra', 'Jean Jonathan', 'jean.arra@miage.edu', '1987-03-28', 'Homme', '2009-2010'),
(2009003, 'Attro', 'Elvis Donald', 'elvis.attro@miage.edu', '1986-09-10', 'Homme', '2009-2010'),
(2009004, 'Bailly', 'G. Arnaud', 'arnaud.bailly@miage.edu', '1987-05-22', 'Homme', '2009-2010'),
(2009005, 'Coulibaly', 'Hector Emile', 'hector.coulibaly@miage.edu', '1986-11-07', 'Homme', '2009-2010'),
(2009006, 'Diaw', 'Oumar Passidi', 'oumar.diaw@miage.edu', '1987-07-19', 'Homme', '2009-2010'),
(2009007, 'Diawara', 'Khady', 'khady.diawara2@miage.edu', '1986-04-03', 'Femme', '2009-2010'),
(2009008, 'Doe', 'Kuoassi Ezékiel', 'ezekiel.doe@miage.edu', '1987-08-25', 'Homme', '2009-2010'),
(2009009, 'Facondé', 'Rudy Ariel', 'rudy.faconde@miage.edu', '1986-12-30', 'Homme', '2009-2010'),
(2009010, 'Fofana', 'N\'valy', 'nvaly.fofana@miage.edu', '1987-02-14', 'Homme', '2009-2010'),
(2009011, 'Gossan', 'Akon Boris', 'boris.gossan@miage.edu', '1986-06-18', 'Homme', '2009-2010'),
(2009012, 'Koffi', 'Guetta J.B. Carmel', 'carmel.koffi@miage.edu', '1987-10-09', 'Homme', '2009-2010'),
(2009013, 'Koffi', 'Stéphane Placide', 'stephane.koffi@miage.edu', '1986-07-22', 'Homme', '2009-2010'),
(2009014, 'Kouadio', 'Stéphane Kpangban', 'stephane.kouadio@miage.edu', '1987-01-05', 'Homme', '2009-2010'),
(2009015, 'Kouahouri', 'Okou Joel', 'joel.kouahouri2@miage.edu', '1986-05-17', 'Homme', '2009-2010'),
(2009016, 'Kouamé', 'Christian Koffi', 'christian.kouame@miage.edu', '1987-09-28', 'Homme', '2009-2010'),
(2009017, 'Kouamé', 'Kodé Guy Roland', 'guy.kouame@miage.edu', '1986-03-11', 'Homme', '2009-2010'),
(2009018, 'Kouassi', 'N\'dri Yves', 'yves.kouassi@miage.edu', '1987-04-24', 'Homme', '2009-2010'),
(2009019, 'Kourouma', 'Fanta', 'fanta.kourouma@miage.edu', '1986-08-07', 'Femme', '2009-2010'),
(2009020, 'Kouyo', 'Jonathan Ivan Lesson', 'jonathan.kouyo@miage.edu', '1987-12-19', 'Homme', '2009-2010'),
(2009021, 'N\'guessan', 'Tecky Huber N\'da', 'huber.nguessan@miage.edu', '1986-10-02', 'Homme', '2009-2010'),
(2009022, 'Ossein', 'Franck', 'franck.ossein@miage.edu', '1987-06-15', 'Homme', '2009-2010'),
(2009023, 'Ouattara', 'Perbin Parfait', 'parfait.ouattara@miage.edu', '1986-02-28', 'Homme', '2009-2010'),
(2009024, 'Tra bi', 'Tra Tizié Cyrille Modeste', 'cyrille.tra@miage.edu', '1987-11-11', 'Homme', '2009-2010'),
(2010001, 'Ahouana', 'Akichi Roche Wilfried', 'wilfried.ahouana@miage.edu', '1987-01-15', 'Homme', '2010-2011'),
(2010002, 'Aka', 'Itchi Maxime', 'maxime.aka@miage.edu', '1988-03-28', 'Homme', '2010-2011'),
(2010003, 'Amisia', 'Molay Jean-marie', 'jean-marie.amisia@miage.edu', '1987-09-10', 'Homme', '2010-2011'),
(2010004, 'Amoikon', 'Kangah Christophe', 'christophe.amoikon@miage.edu', '1988-05-22', 'Homme', '2010-2011'),
(2010005, 'Attiembone', 'Christelle', 'christelle.attiembone@miage.edu', '1987-11-07', 'Femme', '2010-2011'),
(2010006, 'Beugré', 'Wahon Marie-claude Esther', 'marie-claude.beugre@miage.edu', '1988-07-19', 'Femme', '2010-2011'),
(2010007, 'Cherif', 'Idriss Ibrahim', 'ibrahim.cherif@miage.edu', '1987-04-03', 'Homme', '2010-2011'),
(2010008, 'Diarrassouba', 'Habib Ismael', 'habib.diarrassouba@miage.edu', '1988-08-25', 'Homme', '2010-2011'),
(2010009, 'Diawara', 'daoud ben Ahmed', 'daoud.diawara@miage.edu', '1987-12-30', 'Homme', '2010-2011'),
(2010010, 'Flan', 'Zédé delphin', 'delphin.flan@miage.edu', '1988-02-14', 'Homme', '2010-2011'),
(2010011, 'Gbakatchétché', 'Gilles-loïc', 'gilles.gbakatch@miage.edu', '1987-06-18', 'Homme', '2010-2011'),
(2010012, 'Gnangne', 'Jean Jacques', 'jean.gnangne@miage.edu', '1988-10-09', 'Homme', '2010-2011'),
(2010013, 'Koloubla', 'Dakouri Auguste Trésor', 'auguste.koloubla@miage.edu', '1987-07-22', 'Homme', '2010-2011'),
(2010014, 'Konan', 'Konan Jean françois regis', 'jean.konan@miage.edu', '1988-01-05', 'Homme', '2010-2011'),
(2010015, 'Kouakou', 'Enode de Laure', 'laure.kouakou@miage.edu', '1987-05-17', 'Femme', '2010-2011'),
(2010016, 'Kouakou', 'kouamé Adjaphin Noël Désiré', 'noel.kouakou@miage.edu', '1988-09-28', 'Homme', '2010-2011'),
(2010017, 'Kouakou', 'N\'guetta Marie-laure Cynthia', 'marie-laure.kouakou@miage.edu', '1987-03-11', 'Femme', '2010-2011'),
(2010018, 'Kouassi', 'Laetitia Aimée tomoly', 'laetitia.kouassi@miage.edu', '1988-04-24', 'Femme', '2010-2011'),
(2010019, 'Krama', 'Abdel-Kader', 'abdel.krama@miage.edu', '1987-08-07', 'Homme', '2010-2011'),
(2010020, 'Menzan', 'Bini Kouamé Christian', 'christian.menzan@miage.edu', '1988-12-19', 'Homme', '2010-2011'),
(2010021, 'Nguessan', 'kalou bi Dieudonné', 'dieudonne.nguessan@miage.edu', '1987-10-02', 'Homme', '2010-2011'),
(2010022, 'N\'guessan', 'kouakou Fulgence', 'fulgence.nguessan@miage.edu', '1988-06-15', 'Homme', '2010-2011'),
(2010023, 'Tanoh', 'Adjoua Marie', 'marie.tanoh@miage.edu', '1987-02-28', 'Femme', '2010-2011'),
(2010024, 'Tuo', 'Kolotioloma Augustin', 'augustin.tuo@miage.edu', '1988-11-11', 'Homme', '2010-2011'),
(2010025, 'Ya', 'Sandrine Anne-elodie', 'sandrine.ya@miage.edu', '1987-01-23', 'Femme', '2010-2011'),
(2010026, 'Yéyé', 'Schadrachs Guy-roland', 'guy.yeye@miage.edu', '1988-07-06', 'Homme', '2010-2011'),
(20190001, 'Emmanuel', 'Malan', 'emmanuelmalan@gmail.com', '1998-01-05', 'Homme', '2019-2020');

-- --------------------------------------------------------

--
-- Structure de la table `evaluations_rapports`
--

CREATE TABLE `evaluations_rapports` (
  `id_evaluation` int NOT NULL,
  `id_rapport` int NOT NULL,
  `id_evaluateur` int NOT NULL,
  `type_evaluateur` enum('enseignant','personnel_admin') NOT NULL,
  `note` decimal(4,2) DEFAULT NULL,
  `commentaire` text,
  `statut_evaluation` enum('en_attente','en_cours','terminee') NOT NULL DEFAULT 'en_attente',
  `date_evaluation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `evaluer`
--

CREATE TABLE `evaluer` (
  `num_etu` int NOT NULL,
  `id_ecue` int NOT NULL,
  `id_enseignant` int NOT NULL,
  `date_evaluation` datetime NOT NULL,
  `note` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fonction`
--

CREATE TABLE `fonction` (
  `id_fonction` int NOT NULL,
  `lib_fonction` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

--
-- Déchargement des données de la table `fonction`
--

INSERT INTO `fonction` (`id_fonction`, `lib_fonction`) VALUES
(2, 'Doyen de faculté'),
(3, 'Directeur de recherche'),
(5, 'Directeur pédagogique');

-- --------------------------------------------------------

--
-- Structure de la table `grade`
--

CREATE TABLE `grade` (
  `id_grade` int NOT NULL,
  `lib_grade` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

--
-- Déchargement des données de la table `grade`
--

INSERT INTO `grade` (`id_grade`, `lib_grade`) VALUES
(7, 'A1'),
(6, 'A2'),
(14, 'A3'),
(10, 'B1'),
(12, 'B2'),
(15, 'D1'),
(16, 'E2'),
(13, 'F4');

-- --------------------------------------------------------

--
-- Structure de la table `groupe_utilisateur`
--

CREATE TABLE `groupe_utilisateur` (
  `id_GU` int NOT NULL,
  `lib_GU` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

--
-- Déchargement des données de la table `groupe_utilisateur`
--

INSERT INTO `groupe_utilisateur` (`id_GU`, `lib_GU`) VALUES
(5, 'Administrateur'),
(6, 'Secretaire'),
(7, 'Chargée de communication'),
(8, 'Responsable scolarité'),
(9, 'Responsable Filière'),
(10, 'Responsable niveau'),
(11, 'commission de validation'),
(12, 'Enseignant sans responsabilité administrative'),
(13, 'Etudiant');

-- --------------------------------------------------------

--
-- Structure de la table `historique_reclamations`
--

CREATE TABLE `historique_reclamations` (
  `id_historique` int NOT NULL,
  `id_reclamation` int NOT NULL,
  `action` varchar(100) NOT NULL,
  `commentaire` text,
  `id_utilisateur` int DEFAULT NULL,
  `date_action` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `informations_stage`
--

CREATE TABLE `informations_stage` (
  `id_info_stage` int NOT NULL,
  `num_etu` int NOT NULL,
  `id_entreprise` int NOT NULL,
  `date_debut_stage` date NOT NULL,
  `date_fin_stage` date NOT NULL,
  `sujet_stage` text NOT NULL,
  `description_stage` text NOT NULL,
  `encadrant_entreprise` varchar(100) NOT NULL,
  `email_encadrant` varchar(100) NOT NULL,
  `telephone_encadrant` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `informations_stage`
--

INSERT INTO `informations_stage` (`id_info_stage`, `num_etu`, `id_entreprise`, `date_debut_stage`, `date_fin_stage`, `sujet_stage`, `description_stage`, `encadrant_entreprise`, `email_encadrant`, `telephone_encadrant`) VALUES
(1, 2004003, 7, '2024-05-04', '2024-11-05', 'Développement d\'application mobile', 'ce stage a été effectué dans le but de d\'améliorer mes compétences en UI/UX Design', 'Tra Bi Hervé', 'fabriceherve@gmail.com', '+255 0705925841'),
(2, 2007003, 5, '2024-02-15', '2024-08-20', 'Conception d\'intelligence artificielle', 'Ce stage consistait à explorer les nouvelles techniques de conception d\'ia en CI.', 'Kouakou Fernand', 'kouakoufernand@gmail.com', '+225 0741526369');

-- --------------------------------------------------------

--
-- Structure de la table `inscriptions`
--

CREATE TABLE `inscriptions` (
  `id_inscription` int NOT NULL,
  `id_etudiant` int DEFAULT NULL,
  `id_niveau` int DEFAULT NULL,
  `id_annee_acad` int NOT NULL,
  `date_inscription` datetime DEFAULT NULL,
  `statut_inscription` enum('En cours','Validée','Annulée') DEFAULT NULL,
  `nombre_tranche` int NOT NULL,
  `reste_a_payer` decimal(10,2) NOT NULL,
  `montant_paye` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `inscriptions`
--

INSERT INTO `inscriptions` (`id_inscription`, `id_etudiant`, `id_niveau`, `id_annee_acad`, `date_inscription`, `statut_inscription`, `nombre_tranche`, `reste_a_payer`, `montant_paye`) VALUES
(1, 2003001, 9, 22423, '2025-06-01 21:07:42', 'En cours', 2, 565000.00, 670000.00),
(2, 2003002, 9, 22524, '2025-06-01 21:22:01', 'En cours', 2, 565000.00, 670000.00),
(4, 2003003, 9, 22221, '2025-06-01 23:10:25', 'En cours', 4, 565000.00, 670000.00),
(15, 2003004, 9, 22221, '2025-06-03 00:53:09', 'En cours', 1, 565000.00, 670000.00),
(16, 2003005, 8, 22322, '2025-06-03 00:53:33', 'En cours', 3, 410000.00, 500000.00),
(17, 2003006, 9, 22221, '2025-06-03 00:55:05', 'En cours', 2, 565000.00, 670000.00),
(18, 2003007, 7, 22221, '2025-06-03 00:57:34', 'En cours', 3, 0.00, 890000.00),
(19, 2003008, 8, 22322, '2025-06-03 00:59:02', 'En cours', 2, 0.00, 910000.00),
(20, 2003009, 9, 22221, '2025-06-04 13:55:43', 'En cours', 2, 565000.00, 670000.00),
(25, 2003010, 9, 22221, '2025-06-04 19:09:06', 'En cours', 2, 565000.00, 670000.00),
(26, 2003011, 9, 22221, '2025-06-04 19:10:40', 'En cours', 2, 0.00, 1235000.00),
(30, 2004003, 9, 21817, '2025-06-16 00:48:39', 'En cours', 1, 565000.00, 670000.00);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id_message` int NOT NULL,
  `contenu_message` text NOT NULL,
  `lib_message` varchar(60) NOT NULL,
  `type_message` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id_message`, `contenu_message`, `lib_message`, `type_message`) VALUES
(3, 'Bienvenue sur Soutenance Manager', 'message_bienvenue', 'info'),
(4, 'Erreur lors du traitement du fichier', 'messageErreur', 'error');

-- --------------------------------------------------------

--
-- Structure de la table `niveau_acces_donnees`
--

CREATE TABLE `niveau_acces_donnees` (
  `id_niveau_acces_donnees` int NOT NULL,
  `lib_niveau_acces_donnees` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

--
-- Déchargement des données de la table `niveau_acces_donnees`
--

INSERT INTO `niveau_acces_donnees` (`id_niveau_acces_donnees`, `lib_niveau_acces_donnees`) VALUES
(4, 'Lecture seule'),
(5, 'Écriture');

-- --------------------------------------------------------

--
-- Structure de la table `niveau_approbation`
--

CREATE TABLE `niveau_approbation` (
  `id_approb` int NOT NULL,
  `lib_approb` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

--
-- Déchargement des données de la table `niveau_approbation`
--

INSERT INTO `niveau_approbation` (`id_approb`, `lib_approb`) VALUES
(3, 'Niveau 1'),
(4, 'Niveau 2'),
(6, 'Niveau 3');

-- --------------------------------------------------------

--
-- Structure de la table `niveau_etude`
--

CREATE TABLE `niveau_etude` (
  `id_niv_etude` int NOT NULL,
  `lib_niv_etude` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `montant_scolarite` decimal(10,2) DEFAULT NULL,
  `montant_inscription` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

--
-- Déchargement des données de la table `niveau_etude`
--

INSERT INTO `niveau_etude` (`id_niv_etude`, `lib_niv_etude`, `montant_scolarite`, `montant_inscription`) VALUES
(6, 'Licence 1', 870000.00, 450000.00),
(7, 'Licence 2', 890000.00, 450000.00),
(8, 'Licence 3', 910000.00, 500000.00),
(9, 'Master 2', 1235000.00, 670000.00),
(10, 'Master 1', 980000.00, 560000.00);

-- --------------------------------------------------------

--
-- Structure de la table `notes`
--

CREATE TABLE `notes` (
  `id` int NOT NULL,
  `num_etu` int NOT NULL,
  `id_ue` int NOT NULL,
  `id_ecue` int NOT NULL,
  `moyenne` decimal(4,2) NOT NULL,
  `commentaire` text,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_modification` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `statut` enum('en_attente','validée','rejetée') DEFAULT 'en_attente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `occuper`
--

CREATE TABLE `occuper` (
  `id_fonction` int NOT NULL,
  `id_enseignant` int NOT NULL,
  `date_occupation` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

--
-- Déchargement des données de la table `occuper`
--

INSERT INTO `occuper` (`id_fonction`, `id_enseignant`, `date_occupation`) VALUES
(5, 2, '2011-02-02'),
(3, 5, '1999-01-02'),
(5, 7, '2016-05-02'),
(5, 9, '2018-05-01'),
(2, 10, '2018-02-12'),
(3, 11, '2016-04-25');

-- --------------------------------------------------------

--
-- Structure de la table `personnel_admin`
--

CREATE TABLE `personnel_admin` (
  `id_pers_admin` int NOT NULL,
  `nom_pers_admin` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `prenom_pers_admin` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `email_pers_admin` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `tel_pers_admin` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `poste` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `date_embauche` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

--
-- Déchargement des données de la table `personnel_admin`
--

INSERT INTO `personnel_admin` (`id_pers_admin`, `nom_pers_admin`, `prenom_pers_admin`, `email_pers_admin`, `tel_pers_admin`, `poste`, `date_embauche`) VALUES
(2, 'Yah', 'Christine', 'yahchristine@gmail.com', '0748703738', 'Secrétaire de la filière MIAGE', '2013-02-05'),
(6, 'N\'goran', 'Durand', 'ngorandurand@gmail.com', '0759395841', 'Responsable scolarité', '2012-05-15'),
(7, 'Seri', 'Marie Christine', 'noemietra27@gmail.com', '0711489473', 'Chargé de communication', '2013-02-12'),
(8, 'Yao', 'Bertrand', 'yaobertrand@gmail.com', '0748703738', 'Chef du service informatique', '2006-02-05');

-- --------------------------------------------------------

--
-- Structure de la table `pister`
--

CREATE TABLE `pister` (
  `id_utilisateur` int NOT NULL,
  `id_traitement` int NOT NULL,
  `date_acces` date NOT NULL,
  `heure_acces` time NOT NULL,
  `acceder` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `posseder`
--

CREATE TABLE `posseder` (
  `id_utilisateur` int NOT NULL,
  `id_GU` int NOT NULL,
  `date_possed` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `rapport_etudiants`
--

CREATE TABLE `rapport_etudiants` (
  `id_rapport` int NOT NULL,
  `num_etu` int NOT NULL,
  `nom_rapport` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `date_rapport` datetime NOT NULL,
  `theme_rapport` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `chemin_fichier` varchar(255) COLLATE utf8mb3_general_mysql500_ci DEFAULT NULL COMMENT 'Chemin vers le fichier de contenu',
  `statut_rapport` enum('en_cours','en_revision','valide','a_corriger','rejete') COLLATE utf8mb3_general_mysql500_ci NOT NULL DEFAULT 'en_cours',
  `date_modification` datetime DEFAULT NULL,
  `taille_fichier` int DEFAULT NULL COMMENT 'Taille du fichier en octets',
  `version` int NOT NULL DEFAULT '1' COMMENT 'Version du rapport'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

--
-- Déchargement des données de la table `rapport_etudiants`
--

INSERT INTO `rapport_etudiants` (`id_rapport`, `num_etu`, `nom_rapport`, `date_rapport`, `theme_rapport`, `chemin_fichier`, `statut_rapport`, `date_modification`, `taille_fichier`, `version`) VALUES
(1, 2006002, 'RARA numero 1 oh', '2025-06-16 16:31:50', 'je sais pas deh', 'rapport_1.html', 'en_cours', '2025-06-16 16:31:50', 9892, 1),
(3, 2008005, 'Lrereet', '2025-06-17 16:21:39', 'Tchai c\'est quelque chose', 'rapport_3.html', 'en_cours', '2025-06-17 16:21:39', 9936, 1);

-- --------------------------------------------------------

--
-- Structure de la table `rattacher`
--

CREATE TABLE `rattacher` (
  `id_GU` int NOT NULL,
  `id_traitement` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

--
-- Déchargement des données de la table `rattacher`
--

INSERT INTO `rattacher` (`id_GU`, `id_traitement`) VALUES
(13, 12),
(13, 13),
(13, 20),
(13, 16),
(13, 15),
(13, 19),
(5, 5),
(5, 8),
(5, 7),
(5, 16),
(5, 11),
(5, 9),
(5, 19),
(5, 10),
(8, 23),
(8, 25),
(8, 6),
(8, 26),
(8, 24),
(8, 16),
(8, 19),
(12, 27),
(12, 28),
(12, 16),
(12, 19),
(9, 27),
(9, 29),
(9, 16),
(9, 19),
(10, 27),
(10, 30),
(10, 16),
(10, 19),
(6, 33),
(6, 34),
(6, 29),
(6, 16),
(6, 19),
(11, 37),
(11, 39),
(11, 35),
(11, 36),
(11, 16),
(11, 40),
(11, 38),
(11, 19),
(7, 32),
(7, 29),
(7, 16),
(7, 19),
(7, 31);

-- --------------------------------------------------------

--
-- Structure de la table `reclamations`
--

CREATE TABLE `reclamations` (
  `id_reclamation` int NOT NULL,
  `num_etu` int DEFAULT NULL,
  `id_utilisateur` int DEFAULT NULL,
  `titre_reclamation` varchar(255) NOT NULL,
  `description_reclamation` text NOT NULL,
  `type_reclamation` enum('Académique','Administrative','Technique','Financière','Autre') NOT NULL,
  `priorite_reclamation` enum('Faible','Moyenne','Élevée','Urgente') NOT NULL DEFAULT 'Moyenne',
  `statut_reclamation` enum('En attente','En cours','Résolue','Rejetée') NOT NULL DEFAULT 'En attente',
  `fichier_joint` varchar(255) DEFAULT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_mise_a_jour` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_admin_assigne` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `reclamations`
--

INSERT INTO `reclamations` (`id_reclamation`, `num_etu`, `id_utilisateur`, `titre_reclamation`, `description_reclamation`, `type_reclamation`, `priorite_reclamation`, `statut_reclamation`, `fichier_joint`, `date_creation`, `date_mise_a_jour`, `id_admin_assigne`) VALUES
(1, 2006002, NULL, 'Mes notes on été echanger', 'les chiennns la mes notes ahi vous avez quelle probleme bande de cafards', 'Académique', 'Moyenne', 'En attente', NULL, '2025-06-16 13:13:39', '2025-06-16 13:13:39', NULL),
(2, 2006002, NULL, 'balablbalbalba', 'j\'ai besoin d\'aide pour mon espace etudiant qui ne fonctionne pas', 'Technique', 'Moyenne', 'En attente', 'rec_2025-06-22_18-53-15_6858511bee4fa.jpg', '2025-06-22 18:53:16', '2025-06-22 18:53:16', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `rendre`
--

CREATE TABLE `rendre` (
  `id_CR` int NOT NULL,
  `id_enseignant` int NOT NULL,
  `date_env` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `semestre`
--

CREATE TABLE `semestre` (
  `id_semestre` int NOT NULL,
  `lib_semestre` varchar(100) NOT NULL,
  `id_niv_etude` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `semestre`
--

INSERT INTO `semestre` (`id_semestre`, `lib_semestre`, `id_niv_etude`) VALUES
(12, 'Semestre 1', 6),
(15, 'Semestre 2', 6),
(16, 'Semestre 3', 7),
(17, 'Semestre 4', 7),
(18, 'Semestre 5', 8),
(19, 'Semestre 6', 8),
(20, 'Semestre 7', 10),
(21, 'Semestre 8', 10),
(22, 'Semestre 9', 9);

-- --------------------------------------------------------

--
-- Structure de la table `specialite`
--

CREATE TABLE `specialite` (
  `id_specialite` int NOT NULL,
  `lib_specialite` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

--
-- Déchargement des données de la table `specialite`
--

INSERT INTO `specialite` (`id_specialite`, `lib_specialite`) VALUES
(2, 'Informatique'),
(3, 'Comptabilité'),
(5, 'Mathématique'),
(6, 'Réseaux'),
(7, 'Médecine'),
(8, 'Géoscience'),
(9, 'Physique'),
(10, 'Génie Électrique et Électronique'),
(11, 'Biologie'),
(12, 'Droit Public'),
(13, 'Langues Étrangères'),
(14, 'Management'),
(15, 'Finance'),
(16, 'Marketing');

-- --------------------------------------------------------

--
-- Structure de la table `statut_jury`
--

CREATE TABLE `statut_jury` (
  `id_jury` int NOT NULL,
  `lib_jury` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

--
-- Déchargement des données de la table `statut_jury`
--

INSERT INTO `statut_jury` (`id_jury`, `lib_jury`) VALUES
(6, 'accepter'),
(7, 'refuser');

-- --------------------------------------------------------

--
-- Structure de la table `traitement`
--

CREATE TABLE `traitement` (
  `id_traitement` int NOT NULL,
  `lib_traitement` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `label_traitement` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `icone_traitement` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `ordre_traitement` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

--
-- Déchargement des données de la table `traitement`
--

INSERT INTO `traitement` (`id_traitement`, `lib_traitement`, `label_traitement`, `icone_traitement`, `ordre_traitement`) VALUES
(5, 'dashboard', 'Tableau de bord', 'fa-home', 1),
(6, 'gestion_etudiants', 'Gestion des étudiants', 'fa-book', 2),
(7, 'gestion_utilisateurs', 'Gestion des utilisateurs', 'fa-user', 3),
(8, 'gestion_rh', 'Gestion des ressources humaines', 'fa-users', 2),
(9, 'piste_audit', 'Gestion de la piste', 'fa-history', 4),
(10, 'sauvegarde_restauration', 'Sauvegarde et restauration des données', 'fa-save', 5),
(11, 'parametres_generaux', 'Paramètres généraux', 'fa-gears', 6),
(12, 'candidature_soutenance', 'Candidater à la soutenance', 'fa-graduation-cap', 1),
(13, 'gestion_rapports', 'Gestion des rapports', 'fa-file', 2),
(15, 'notes_resultats', 'Notes & résultats', 'fa-note-sticky', 4),
(16, 'messagerie', 'Messagerie', 'fa-envelope', 5),
(17, 'profil_etudiant', 'Profil étudiant', 'fa-user', 6),
(19, 'profil', 'Profil', 'fa-user', 6),
(20, 'gestion_reclamations', 'Gestion des réclamations', 'fa-exclamation', 3),
(23, 'dashboard_scolarite', 'Tableau de bord scolarité', 'fa-home', 1),
(24, 'gestion_scolarite', 'Gestion de la scolarité', 'fa-money-bill', 3),
(25, 'gestion_candidatures_soutenance', 'Gestion des candidatures de soutenance', 'fa-folder', 4),
(26, 'gestion_notes_evaluations', 'Gestions des notes et évaluations', 'fa-note-sticky', 5),
(27, 'dashboard_enseignant', 'Tableau de bord enseignant', 'fa-home', 1),
(28, 'liste_etudiants_ens_simple', 'Liste des étudiants évalués', 'fa-users', 2),
(29, 'liste_etudiants_resp_filiere', 'Liste des étudiants MIAGE', 'fa-users', 2),
(30, 'liste_etudiants_resp_niveau', 'Liste des étudiants de mon niveau', 'fa-users', 2),
(31, 'verification_candidatures_soutenance', 'Vérification des candidatures de soutenance', 'fa-certificate', 1),
(32, 'gestion_dossiers_candidatures', 'Gestion des dossiers de candidature', 'fa-folder', 2),
(33, 'dashboard_secretaire', 'Tableau de bord secrétariat', 'fa-home', 1),
(34, 'dossiers_academiques', 'Dossiers académiques', 'fa-folder-open', 3),
(35, 'dashboard_commission', 'Tableau de bord de la commission', 'fa-home', 1),
(36, 'evaluations_dossiers_soutenance', 'Évaluation des dossiers de soutenance', 'fa-file-contract', 2),
(37, 'analyse_rapports_etudiants', 'Analyse des rapports étudiants', 'fa-chart-line', 3),
(38, 'processus_validation', 'Processus de validation des dossiers', 'fa-list-check', 3),
(39, 'archives_dossiers_soutenance', 'Archives des dossiers de soutenance', 'fa-inbox', 5),
(40, 'planification_reunion', 'Planification des réunions', 'fa-calendar-days', 6);

-- --------------------------------------------------------

--
-- Structure de la table `type_utilisateur`
--

CREATE TABLE `type_utilisateur` (
  `id_type_utilisateur` int NOT NULL,
  `lib_type_utilisateur` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

--
-- Déchargement des données de la table `type_utilisateur`
--

INSERT INTO `type_utilisateur` (`id_type_utilisateur`, `lib_type_utilisateur`) VALUES
(4, 'Personnel administratif'),
(5, 'Enseignant administratif'),
(6, 'Enseignant simple'),
(7, 'Etudiant');

-- --------------------------------------------------------

--
-- Structure de la table `ue`
--

CREATE TABLE `ue` (
  `id_ue` int NOT NULL,
  `lib_ue` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `id_niveau_etude` int NOT NULL,
  `id_semestre` int NOT NULL,
  `id_annee_academique` int NOT NULL,
  `credit` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

--
-- Déchargement des données de la table `ue`
--

INSERT INTO `ue` (`id_ue`, `lib_ue`, `id_niveau_etude`, `id_semestre`, `id_annee_academique`, `credit`) VALUES
(8, 'Economie', 6, 12, 22524, 5),
(9, 'Réseaux informatiques', 8, 19, 22423, 5),
(10, 'Initiation à l\'informatique', 6, 12, 22524, 4),
(11, 'Initiation à l\'algorithmique', 6, 12, 22524, 3),
(12, 'Outils bureautiques 1', 6, 12, 22524, 2),
(13, 'Mathématiques 1', 6, 12, 22524, 5),
(14, 'Mathématiques 2', 6, 12, 22524, 5),
(15, 'Organisation des entreprises', 6, 12, 22524, 3),
(16, 'Électronique', 6, 12, 22524, 3),
(17, 'Mathématiques 3', 6, 15, 22524, 6),
(18, 'Probabilité et Statistique 1', 6, 15, 22524, 5),
(19, 'Outils bureautiques 2', 6, 15, 22524, 2),
(20, 'Atelier de maintenance', 6, 15, 22524, 1),
(21, 'Technique d\'expression et méthodologie de travail', 6, 15, 22524, 2),
(22, 'Intelligence économique', 6, 15, 22524, 2),
(23, 'Gestion des Ressources Humaines', 6, 15, 22524, 2),
(24, 'Logiciel de traitement d\'images ou de montage vidéo', 6, 15, 22524, 2),
(25, 'Anglais', 6, 15, 22524, 3),
(26, 'Programmation orientée objet', 7, 16, 22524, 6),
(27, 'Outils formels pour l\'informatique', 7, 16, 22524, 2),
(28, 'Mathématiques 4', 7, 16, 22524, 6),
(29, 'Probabilité et Statistique 2', 7, 16, 22524, 4),
(30, 'Comptabilité generale', 7, 16, 22524, 6),
(31, 'Anglais', 7, 16, 22524, 3),
(32, 'Mathématiques 5', 7, 17, 22524, 2),
(33, 'Données semi-structurées et bases de données', 7, 17, 22524, 8),
(34, 'Programmation web', 7, 17, 22524, 3),
(35, 'Génie logiciel', 7, 17, 22524, 6),
(36, 'Programmation sous windows', 7, 17, 22524, 4),
(37, 'Contrôle budgétaire', 7, 17, 22524, 3),
(38, 'Initiation Python', 7, 17, 22524, 2),
(39, 'Projet', 7, 17, 22524, 2),
(40, 'Systèmes informatiques', 8, 18, 22524, 6),
(41, 'Programmation', 8, 18, 22524, 5),
(42, 'Base de données avancées', 8, 18, 22524, 3),
(43, 'Programmation client web', 8, 18, 22524, 3),
(44, 'Algorithmique des graphes', 8, 18, 22524, 3),
(45, 'Programmation linéaire', 8, 18, 22524, 3),
(46, 'Comptabilité de gestion', 8, 18, 22524, 4),
(47, 'Files d\'attente et gestion de stock', 8, 19, 22524, 3),
(48, 'Analyse de données', 8, 19, 22524, 3),
(49, 'Programmation d\'application', 8, 19, 22524, 3),
(51, 'Théorie des langages', 8, 19, 22524, 3),
(53, 'Anglais', 8, 19, 22524, 3),
(54, 'Projet', 8, 19, 22524, 4),
(55, 'Environnement juridique', 8, 19, 22524, 3),
(56, 'Modélisation système d\'information', 10, 20, 22524, 5),
(57, 'Compléments de mathématiques', 10, 20, 22423, 4),
(58, 'Intelligence Artificielle', 10, 20, 22423, 2),
(59, 'Base de données avancées', 10, 20, 22524, 4),
(60, 'Programmation avancée Java', 10, 20, 22524, 4),
(61, 'Progiciel de comptabilité (SAGE)', 10, 20, 22423, 2),
(62, 'Management des entreprises', 10, 20, 22423, 3),
(63, 'Concurrence et coopération dans les systèmes et les réseaux', 10, 20, 22423, 4),
(64, 'Internet/Intranet', 10, 20, 22423, 2),
(65, 'Base de données décisionnelles ', 10, 21, 22524, 3),
(66, 'Programmation impérative et developpement d\'IHM ', 10, 21, 22524, 4),
(67, 'Système d\'information repartis', 10, 21, 22524, 5),
(68, 'Contrôle de gestion', 10, 21, 22524, 3),
(69, 'Comptabilité analytique', 10, 21, 22524, 4),
(70, 'Marketing', 10, 21, 22524, 3),
(71, 'Projet de developpement logiciel', 10, 21, 22524, 5),
(72, 'Anglais', 10, 21, 22524, 3),
(73, 'Analyse et conception à objet', 9, 22, 22524, 5),
(74, 'Gestion financière', 9, 22, 22524, 3),
(75, 'Management de projet et intégration d\'application', 9, 22, 22524, 6),
(76, 'Audit informatique', 9, 22, 22524, 3),
(77, 'Entrepreunariat', 9, 22, 22524, 2),
(78, 'Multimedia mobile', 9, 22, 22524, 3),
(79, 'Ingenierie des exigences et veille technologique', 9, 22, 22524, 3),
(80, 'Mathématiques financières', 9, 22, 22524, 3),
(81, 'Anglais', 9, 22, 22524, 2),
(82, 'Algorithmique et Programmation', 6, 15, 22524, 5),
(83, 'Gestion financière', 8, 19, 22524, 3),
(84, 'Analyse de données', 7, 16, 22524, 3),
(85, 'BMO', 8, 18, 22524, 3);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int NOT NULL,
  `nom_utilisateur` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `id_type_utilisateur` int NOT NULL,
  `id_GU` int NOT NULL,
  `id_niv_acces_donnee` int NOT NULL,
  `statut_utilisateur` enum('Actif','Inactif') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `login_utilisateur` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `mdp_utilisateur` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `nom_utilisateur`, `id_type_utilisateur`, `id_GU`, `id_niv_acces_donnee`, `statut_utilisateur`, `login_utilisateur`, `mdp_utilisateur`) VALUES
(5, 'Koua Brou', 5, 5, 5, 'Actif', 'oceanetl27@gmail.com', '$2y$10$5xegW5cpfo9paDNWYZHnsup7Qngf8JpejSPRxwVpmxCaxAGP.w4im'),
(21, 'Seri Marie Christine', 4, 7, 5, 'Actif', 'noemietra27@gmail.com', '$2y$10$7wJ0eu/RsZRSNGb1ZK8ow.Bj.9vTM0Z.Kj9bYK4A6y0U44cv1gCse'),
(27, 'Kouakou Mathias', 6, 12, 5, 'Actif', 'axelangegomez@gmail.com', '$2y$10$QXdyHw8Tky94eHKJY.Bw/OoQ/t9h1cNn/itHTZa7wgRHJxtKb9URC'),
(34, 'Yah Christine', 4, 6, 4, 'Actif', 'yahchristine@gmail.com', '$2y$10$StdfqOOpnOBUf1kSZnhHeu6TqUiXVWtfqI73AKv4v7Cv2NjjKqNna'),
(35, 'N\'goran Durand', 4, 8, 5, 'Actif', 'ngorandurand@gmail.com', '$2y$10$9ZHd/WKtdrB2jpeaH2cewe/hdoUfUOxaDH7P4S/YUTI5uqu23hOoe'),
(36, 'Brou Patrice', 5, 11, 5, 'Actif', 'angeaxelgomez@gmail.com', '$2y$10$QtMW8goQLrH.om8q1mlgo.tJwA1AGFc./uZpOLhoo4g2z7p46OCrm'),
(39, 'N\'golo Konaté', 6, 12, 5, 'Inactif', 'ngolokonate@yahoo.fr', '$2y$10$o7fxEokbRfMLFoGPOS1TpOFuxjFQ3TFzMMV4mukNEWLs9aNxGjr/u'),
(40, 'Nindjin Malan', 6, 12, 5, 'Inactif', 'nindjinmalan@gmail.com', '$2y$10$f0Nq70iGpanY5FrbCZI2G.fJ.aj8oDu05Y2Gi5y1LjsrcDc5M3TXa'),
(41, 'Abroh Alokré Samuel Eliézer', 7, 13, 4, 'Inactif', 'samuel.abroh@miage.edu', '$2y$10$F1OOtQYIjbu1CeEzkAZA3OPuZEjABsXAxAzFs/WMlWXbRvnAGK9ZO'),
(42, 'Abudrahman Bako Rouhiya', 7, 13, 5, 'Inactif', 'rouhiya.abudrahman@miage.edu', '$2y$10$h0YCvxudG9rt1FnLVbP7rewIZSNYYtaAvLDYonGiEY1jqJ.0BXOc6'),
(43, 'Aby Nanpé Olivier', 7, 13, 5, 'Inactif', 'olivier.aby@miage.edu', '$2y$10$MvjnGeToYLbiKi22QReaXufAQEl/3nYKeMbAFMAF3uHaldPphVRTS'),
(44, 'Acho Dessi Stéphane Ivan', 7, 13, 5, 'Actif', 'stephane.acho@miage.edu', '$2y$10$9TPspFtSlEL1gffNH0MXzunJ8sNtqEipGJ0MOyaJTxxNLWY5Znhp6'),
(45, 'Adja Willy Junior', 7, 13, 5, 'Actif', 'willy.adja@miage.edu', '$2y$10$YMMUvIsLYs2OetoPi5mUcOI9oOPkAN8PLTjlF4ECT7G6EngerqbRq'),
(46, 'Badouon Ange Rodrigue', 7, 13, 5, 'Inactif', 'rodrigue.badouon@miage.edu', '$2y$10$RxVWtaUqVWVorw4Cb70aQ.draDDRELevfohXHNKc7GmNdAk1TYnjS'),
(47, 'Bailly G. Arnaud', 7, 13, 5, 'Inactif', 'arnaud.bailly@miage.edu', '$2y$10$v0KLyBNPqYIq0pzs5PI5yuXzqDm/4.9LMuGTEb3deC7VSNyvi3DRu'),
(48, 'Bakayoko Soumaila', 7, 13, 5, 'Inactif', 'soumaila.bakayoko@miage.edu', '$2y$10$rD2s96J4BLg00PKoLaKNz.1Mqldbho2xQKTV9KNq.v6yojlgt4zQK'),
(49, 'Barthe Kobi Hugues Didier', 7, 13, 5, 'Inactif', 'hugues.barthe@miage.edu', '$2y$10$GebCeUjBuy/1yoGiIawDRe0XjlvfokxhUw2Sbc0fc6TIWDjSuHZvq'),
(50, 'Bédy Nathanael Durand', 7, 13, 5, 'Inactif', 'nathanael.bedy@miage.edu', '$2y$10$8oARJ1059Pm94PGBHobPluiuoL85oehbLMho7QnQaHmigbnHgDAXm'),
(51, 'Agounkpeto Jean Michel', 7, 13, 4, 'Actif', 'jean.agounkpeto@miage.edu', '$2y$10$VbOgIMd2.EiNrOvsv3A4lO9DN8Z5JW3RfzSGQUDekv205Mo7UwdrO'),
(52, 'Ahouana Akichi Roche Wilfried', 7, 13, 4, 'Actif', 'wilfried.ahouana@miage.edu', '$2y$10$4xg2mUGEsK88oKAJtbbBDuEop3WEdER1ZMoKlycKtsonrVnGg7Q/W'),
(53, 'Aka Ange Kévin', 7, 13, 4, 'Actif', 'ange.aka@miage.edu', '$2y$10$Lkz46NI3W.WE4Deb8CxwleS5L5Hi.lJkffKsrVGOA6IccBeEl5iQe'),
(54, 'Aka Manouan Angora Jean-Yves', 7, 13, 5, 'Actif', 'jean-yves.aka@miage.edu', '$2y$10$X/nhUBb9oxwV4o/zNJyWIOdAqUAGx2qqj7iG0vi1pAZL2XTX4SQDm'),
(55, 'Aka Itchi Maxime', 7, 13, 5, 'Inactif', 'maxime.aka@miage.edu', '$2y$10$3PBcDYPqdPw7MEwDpsHaBOkjzLU44G.wT/Ye6ehFV.8BLB9.GQy1K'),
(56, 'Akanza Kouassi Ronald', 7, 13, 5, 'Actif', 'ronald.akanza@miage.edu', '$2y$10$9teu8Zp/EPpDLLYrRu/iK.nfyrAhvBuuLehanv2o1iHoDGsBMkpUe'),
(57, 'Akini Marie Danielle', 7, 13, 5, 'Actif', 'marie.akini@miage.edu', '$2y$10$cTTUUmNQ3ZiIAWYGOwoHsu6Z1nDJQQfdLS9W5VM2QbGKd93Y.IkUa'),
(58, 'Akinola Oyéniyi Alexis Laurent S.', 7, 13, 5, 'Inactif', 'alexis.akinola@miage.edu', '$2y$10$6ZmvjrDzeWMHSiEQ72RXzeWkFSjdqbmD8gQ0jQxZJY4snBmLK5QpW'),
(59, 'Aka Prince', 7, 13, 5, 'Actif', 'prince.aka@miage.edu', '$2y$10$4Ch3UNErI7enw4qTEum.He/je80LyawhwafWzSd1XFpPslQresEdy'),
(60, 'Akpa Gnagne David Martial', 7, 13, 5, 'Inactif', 'david.akpa@miage.edu', '$2y$10$yeixpuMsVyPcYVvKFfVK7O.KpNfXb6HtduveqSmDdamq/K1kwMFbS'),
(61, 'Aliman Prisca', 7, 13, 5, 'Actif', 'prisca.aliman@miage.edu', '$2y$10$vMKeytxpNw3QauzeWrPVbOr.qdsObMHNx.NHwWh/e.TP2G5QKgkD2'),
(62, 'Allou Niamké Jean-Marc', 7, 13, 5, 'Actif', 'jean-marc.allou@miage.edu', '$2y$10$n6/8TSV1qrYL08FixLkJsO1ooFp8SPSnceL3x48/EVFMqJ6jLYCVO'),
(63, 'Amisia Molay Jean-marie', 7, 13, 5, 'Inactif', 'jean-marie.amisia@miage.edu', '$2y$10$JwEgONSpm1suZ/RmSzycd.2oAkCUALKvG12FMWpPDC3cxaXB6ZdDS'),
(64, 'Amoikon Kangah Christophe', 7, 13, 5, 'Inactif', 'christophe.amoikon@miage.edu', '$2y$10$yBZHbhQfbS4zXBIe7z.zDO/9Py9sIQDksYbVd2QJmmUrePVz0euJ2'),
(65, 'Ané Antoine Ahoua', 7, 13, 5, 'Actif', 'antoine.ane@miage.edu', '$2y$10$RTOOP8ZEHsYXid3nVvDHfOUmKZMKztJhCnlm/OoKRHuyssxdy66iu'),
(66, 'Ango Charles Erwan Brou', 7, 13, 4, 'Actif', 'charles.ango@miage.edu', '$2y$10$ygTM2WIFHdCyyhWtJeo6HOf7.dNg.qX6NByW.mMY1nhwuVQ3SRuPq'),
(67, 'Anon Noelly', 7, 13, 5, 'Actif', 'noelly.anon@miage.edu', '$2y$10$qFPc3.oAugeDpHXuL/QUxuNj./GzOSmuRYAtqClYkK9p4yvVKE9tC'),
(68, 'Arra Jean Jonathan', 7, 13, 5, 'Actif', 'jean.arra@miage.edu', '$2y$10$332Yfywd06TBzkP0WRg8aOO8pKFA7hx/65.XvvC0GD.yB5.b2wNVa'),
(69, 'Assy Yves Landry', 7, 13, 5, 'Inactif', 'yves.assy@miage.edu', '$2y$10$Cd/wgWv795uT5XMpLnKHaOGPqMkFhROimw5ve3fXboOd/epY8h9sS'),
(70, 'Attiembone Christelle', 7, 13, 5, 'Actif', 'christelle.attiembone@miage.edu', '$2y$10$qBa9JkUqUp/b9Bdzut4KDuLEVu.e1Bs.xYcl3QBAnEPuTI7t31ZFC'),
(71, 'Attisou Jean-François', 7, 13, 5, 'Actif', 'jean-francois.attisou@miage.edu', '$2y$10$9ABjSrf34KdurB/GSGJEFuAQmg/wRAsty0RJnb5yATv2m2e48LZsC'),
(72, 'Attro Elvis Donald', 7, 13, 5, 'Actif', 'elvis.attro@miage.edu', '$2y$10$xfneiO5GQR9tHbnYYXYq/eRSH9aMGCAHtY5i2kUcnnkAcblnhM0HK'),
(73, 'Berthé Issa', 7, 13, 5, 'Actif', 'issa.berthe@miage.edu', '$2y$10$jiPYvoRCffth5xPmAUu7Sevr83epUHkKTahvPpQtqFtCRZjONdfiK'),
(74, 'Beugré Wahon Marie-claude Esther', 7, 13, 4, 'Actif', 'marie-claude.beugre@miage.edu', '$2y$10$tWiciNPGAZy6iIRQsMsrTuEf.cF5wW0mKfFRhCiPm7J3zJPhhyvCO'),
(75, 'Blé Aka Jean-Jacques Ferdinand', 7, 13, 4, 'Actif', 'jean-jacques.ble@miage.edu', '$2y$10$v4.FwYzTBLS59sYe7n/UzurVjQcOghjpF29H1xob1oyiKsDQRIbAC'),
(76, 'Bodjé Hippolyte', 7, 13, 5, 'Inactif', 'hippolyte.bodje@miage.edu', '$2y$10$Valo3K9ZKG7D7TxiDiWC1e7jjGYAxFv2BiPrKk52Xm71dsVJNRbgO'),
(77, 'Bodjé N\'kauh Nathan Regis', 7, 13, 5, 'Inactif', 'nathan.bodje@miage.edu', '$2y$10$byj8vnOGfyD7ob8dEvOWbOCeiDQP9wlyTDkIPb4hDoPA0s9c4pyAG'),
(78, 'Boni Jean-Philipe', 7, 13, 5, 'Actif', 'jean-philipe.boni@miage.edu', '$2y$10$bXu41vPpj6gfVu/jWnG3oOs1wbUFonOXngVTOyUHLM9j6XQhTu4Ja');

-- --------------------------------------------------------

--
-- Structure de la table `valider`
--

CREATE TABLE `valider` (
  `id_enseignant` int NOT NULL,
  `id_rapport` int NOT NULL,
  `date_validation` datetime NOT NULL,
  `commentaire_validation` varchar(1000) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `versements`
--

CREATE TABLE `versements` (
  `id_versement` int NOT NULL,
  `id_inscription` int DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  `date_versement` datetime DEFAULT CURRENT_TIMESTAMP,
  `type_versement` enum('Premier versement','Tranche') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `methode_paiement` enum('Espèce','Carte bancaire','Virement','Chèque') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `versements`
--

INSERT INTO `versements` (`id_versement`, `id_inscription`, `montant`, `date_versement`, `type_versement`, `methode_paiement`) VALUES
(1, 1, 670000.00, '2025-06-01 21:07:42', 'Premier versement', 'Espèce'),
(2, 2, 670000.00, '2025-06-01 21:22:01', 'Premier versement', 'Espèce'),
(4, 4, 670000.00, '2025-06-01 23:10:25', 'Premier versement', 'Espèce'),
(19, 15, 670000.00, '2025-06-03 00:53:09', 'Premier versement', 'Espèce'),
(20, 16, 500000.00, '2025-06-03 00:53:33', 'Premier versement', 'Carte bancaire'),
(21, 17, 670000.00, '2025-06-03 00:55:05', 'Premier versement', 'Carte bancaire'),
(22, 18, 450000.00, '2025-06-03 00:57:34', 'Premier versement', 'Espèce'),
(23, 19, 500000.00, '2025-06-03 00:59:02', 'Premier versement', 'Carte bancaire'),
(24, 20, 670000.00, '2025-06-04 13:55:43', 'Premier versement', 'Carte bancaire'),
(29, 25, 670000.00, '2025-06-04 19:09:06', 'Premier versement', 'Virement'),
(30, 26, 670000.00, '2025-06-04 19:10:40', 'Premier versement', 'Espèce'),
(45, 26, 165000.00, '2025-06-15 23:37:22', 'Tranche', 'Carte bancaire'),
(46, 19, 410000.00, '2025-06-15 23:44:56', 'Tranche', 'Chèque'),
(51, 30, 670000.00, '2025-06-16 00:48:39', 'Premier versement', 'Virement'),
(54, 26, 400000.00, '2025-06-16 01:33:56', 'Tranche', 'Espèce'),
(55, 18, 440000.00, '2025-06-16 01:36:18', 'Tranche', 'Carte bancaire');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `action`
--
ALTER TABLE `action`
  ADD PRIMARY KEY (`id_action`);

--
-- Index pour la table `affecter`
--
ALTER TABLE `affecter`
  ADD KEY `Key_affecter_enseignant` (`id_enseignant`),
  ADD KEY `Key_affecter_rappetu` (`id_rapport`),
  ADD KEY `Key_affecter_jury` (`id_jury`);

--
-- Index pour la table `annee_academique`
--
ALTER TABLE `annee_academique`
  ADD PRIMARY KEY (`id_annee_acad`);

--
-- Index pour la table `approuver`
--
ALTER TABLE `approuver`
  ADD KEY `Key_approver_enseignant` (`id_pers_admin`),
  ADD KEY `Key_approver_rapport` (`id_rapport`);

--
-- Index pour la table `avoir`
--
ALTER TABLE `avoir`
  ADD KEY `Key_avoir_grade` (`id_grade`),
  ADD KEY `Key_avoir_enseignant` (`id_enseignant`);

--
-- Index pour la table `candidature_soutenance`
--
ALTER TABLE `candidature_soutenance`
  ADD PRIMARY KEY (`id_candidature`),
  ADD KEY `num_etu` (`num_etu`),
  ADD KEY `id_pers_admin` (`id_pers_admin`);

--
-- Index pour la table `compte_rendu`
--
ALTER TABLE `compte_rendu`
  ADD PRIMARY KEY (`id_CR`),
  ADD KEY `fk_etudiant` (`num_etu`);

--
-- Index pour la table `deposer`
--
ALTER TABLE `deposer`
  ADD KEY `Key_deposer_etudiant` (`num_etu`),
  ADD KEY `Key_deposer_rapport_etud` (`id_rapport`);

--
-- Index pour la table `echeances`
--
ALTER TABLE `echeances`
  ADD PRIMARY KEY (`id_echeance`),
  ADD KEY `id_inscription` (`id_inscription`);

--
-- Index pour la table `ecue`
--
ALTER TABLE `ecue`
  ADD PRIMARY KEY (`id_ecue`),
  ADD KEY `Key_ecue_ue` (`id_ue`);

--
-- Index pour la table `enseignants`
--
ALTER TABLE `enseignants`
  ADD PRIMARY KEY (`id_enseignant`),
  ADD KEY `Key_enseign_specialite` (`id_specialite`);

--
-- Index pour la table `entreprises`
--
ALTER TABLE `entreprises`
  ADD PRIMARY KEY (`id_entreprise`),
  ADD UNIQUE KEY `lib_entreprise` (`lib_entreprise`);

--
-- Index pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD PRIMARY KEY (`num_etu`);

--
-- Index pour la table `evaluations_rapports`
--
ALTER TABLE `evaluations_rapports`
  ADD PRIMARY KEY (`id_evaluation`),
  ADD KEY `idx_rapport` (`id_rapport`),
  ADD KEY `idx_evaluateur` (`id_evaluateur`);

--
-- Index pour la table `evaluer`
--
ALTER TABLE `evaluer`
  ADD KEY `Key_evaluer_ecue` (`id_ecue`),
  ADD KEY `Key_evaluer_enseignant` (`id_enseignant`),
  ADD KEY `Key_evaluer_etudiant` (`num_etu`);

--
-- Index pour la table `fonction`
--
ALTER TABLE `fonction`
  ADD PRIMARY KEY (`id_fonction`);

--
-- Index pour la table `grade`
--
ALTER TABLE `grade`
  ADD PRIMARY KEY (`id_grade`),
  ADD UNIQUE KEY `lib_grade` (`lib_grade`);

--
-- Index pour la table `groupe_utilisateur`
--
ALTER TABLE `groupe_utilisateur`
  ADD PRIMARY KEY (`id_GU`);

--
-- Index pour la table `historique_reclamations`
--
ALTER TABLE `historique_reclamations`
  ADD PRIMARY KEY (`id_historique`),
  ADD KEY `idx_id_reclamation` (`id_reclamation`),
  ADD KEY `idx_id_utilisateur` (`id_utilisateur`),
  ADD KEY `idx_date_action` (`date_action`);

--
-- Index pour la table `informations_stage`
--
ALTER TABLE `informations_stage`
  ADD PRIMARY KEY (`id_info_stage`),
  ADD KEY `num_etu` (`num_etu`),
  ADD KEY `id_entreprise` (`id_entreprise`);

--
-- Index pour la table `inscriptions`
--
ALTER TABLE `inscriptions`
  ADD PRIMARY KEY (`id_inscription`),
  ADD KEY `id_etudiant` (`id_etudiant`),
  ADD KEY `id_niveau` (`id_niveau`),
  ADD KEY `id_annee_acad` (`id_annee_acad`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id_message`);

--
-- Index pour la table `niveau_acces_donnees`
--
ALTER TABLE `niveau_acces_donnees`
  ADD PRIMARY KEY (`id_niveau_acces_donnees`);

--
-- Index pour la table `niveau_approbation`
--
ALTER TABLE `niveau_approbation`
  ADD PRIMARY KEY (`id_approb`);

--
-- Index pour la table `niveau_etude`
--
ALTER TABLE `niveau_etude`
  ADD PRIMARY KEY (`id_niv_etude`);

--
-- Index pour la table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notes_ibfk_1` (`num_etu`),
  ADD KEY `notes_ibfk_2` (`id_ue`),
  ADD KEY `notes_ibfk_3` (`id_ecue`);

--
-- Index pour la table `occuper`
--
ALTER TABLE `occuper`
  ADD KEY `Key_occuper_enseignant` (`id_enseignant`),
  ADD KEY `Key_occuper_fonction` (`id_fonction`);

--
-- Index pour la table `personnel_admin`
--
ALTER TABLE `personnel_admin`
  ADD PRIMARY KEY (`id_pers_admin`);

--
-- Index pour la table `pister`
--
ALTER TABLE `pister`
  ADD KEY `Key_pister_traitement` (`id_traitement`),
  ADD KEY `Key_pister_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `posseder`
--
ALTER TABLE `posseder`
  ADD KEY `Key_posseder_utilisateur` (`id_GU`),
  ADD KEY `Key_posserder_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `rapport_etudiants`
--
ALTER TABLE `rapport_etudiants`
  ADD PRIMARY KEY (`id_rapport`),
  ADD KEY `Key_rapport_etu_etudiant` (`num_etu`);

--
-- Index pour la table `rattacher`
--
ALTER TABLE `rattacher`
  ADD KEY `Key_rattacher_GU` (`id_GU`),
  ADD KEY `Key_rattacher_traitement` (`id_traitement`);

--
-- Index pour la table `reclamations`
--
ALTER TABLE `reclamations`
  ADD PRIMARY KEY (`id_reclamation`),
  ADD KEY `idx_num_etu` (`num_etu`),
  ADD KEY `idx_id_utilisateur` (`id_utilisateur`),
  ADD KEY `idx_id_admin_assigne` (`id_admin_assigne`),
  ADD KEY `idx_statut` (`statut_reclamation`),
  ADD KEY `idx_type` (`type_reclamation`),
  ADD KEY `idx_date_creation` (`date_creation`);

--
-- Index pour la table `rendre`
--
ALTER TABLE `rendre`
  ADD KEY `Key_rendre_CR` (`id_CR`),
  ADD KEY `Key_rendre_enseignant` (`id_enseignant`);

--
-- Index pour la table `semestre`
--
ALTER TABLE `semestre`
  ADD PRIMARY KEY (`id_semestre`),
  ADD KEY `id_niv_etude` (`id_niv_etude`);

--
-- Index pour la table `specialite`
--
ALTER TABLE `specialite`
  ADD PRIMARY KEY (`id_specialite`);

--
-- Index pour la table `statut_jury`
--
ALTER TABLE `statut_jury`
  ADD PRIMARY KEY (`id_jury`);

--
-- Index pour la table `traitement`
--
ALTER TABLE `traitement`
  ADD PRIMARY KEY (`id_traitement`);

--
-- Index pour la table `type_utilisateur`
--
ALTER TABLE `type_utilisateur`
  ADD PRIMARY KEY (`id_type_utilisateur`);

--
-- Index pour la table `ue`
--
ALTER TABLE `ue`
  ADD PRIMARY KEY (`id_ue`),
  ADD KEY `id_annee_academique` (`id_annee_academique`),
  ADD KEY `id_niveau_etude` (`id_niveau_etude`),
  ADD KEY `id_semestre` (`id_semestre`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `login_utilisateur` (`login_utilisateur`),
  ADD KEY `id_groupe_utilisateur` (`id_GU`),
  ADD KEY `id_niv_acces_donnee` (`id_niv_acces_donnee`),
  ADD KEY `id_type_utilisateur` (`id_type_utilisateur`);

--
-- Index pour la table `valider`
--
ALTER TABLE `valider`
  ADD KEY `Key_valider_enseignant` (`id_enseignant`),
  ADD KEY `Key_valider_rapport` (`id_rapport`);

--
-- Index pour la table `versements`
--
ALTER TABLE `versements`
  ADD PRIMARY KEY (`id_versement`),
  ADD KEY `id_inscription` (`id_inscription`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `action`
--
ALTER TABLE `action`
  MODIFY `id_action` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `annee_academique`
--
ALTER TABLE `annee_academique`
  MODIFY `id_annee_acad` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29901;

--
-- AUTO_INCREMENT pour la table `candidature_soutenance`
--
ALTER TABLE `candidature_soutenance`
  MODIFY `id_candidature` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `compte_rendu`
--
ALTER TABLE `compte_rendu`
  MODIFY `id_CR` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `echeances`
--
ALTER TABLE `echeances`
  MODIFY `id_echeance` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT pour la table `ecue`
--
ALTER TABLE `ecue`
  MODIFY `id_ecue` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT pour la table `enseignants`
--
ALTER TABLE `enseignants`
  MODIFY `id_enseignant` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `entreprises`
--
ALTER TABLE `entreprises`
  MODIFY `id_entreprise` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `etudiants`
--
ALTER TABLE `etudiants`
  MODIFY `num_etu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20250003;

--
-- AUTO_INCREMENT pour la table `evaluations_rapports`
--
ALTER TABLE `evaluations_rapports`
  MODIFY `id_evaluation` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `fonction`
--
ALTER TABLE `fonction`
  MODIFY `id_fonction` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `grade`
--
ALTER TABLE `grade`
  MODIFY `id_grade` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `groupe_utilisateur`
--
ALTER TABLE `groupe_utilisateur`
  MODIFY `id_GU` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `historique_reclamations`
--
ALTER TABLE `historique_reclamations`
  MODIFY `id_historique` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `informations_stage`
--
ALTER TABLE `informations_stage`
  MODIFY `id_info_stage` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `inscriptions`
--
ALTER TABLE `inscriptions`
  MODIFY `id_inscription` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id_message` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `niveau_acces_donnees`
--
ALTER TABLE `niveau_acces_donnees`
  MODIFY `id_niveau_acces_donnees` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `niveau_approbation`
--
ALTER TABLE `niveau_approbation`
  MODIFY `id_approb` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `niveau_etude`
--
ALTER TABLE `niveau_etude`
  MODIFY `id_niv_etude` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `personnel_admin`
--
ALTER TABLE `personnel_admin`
  MODIFY `id_pers_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `rapport_etudiants`
--
ALTER TABLE `rapport_etudiants`
  MODIFY `id_rapport` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `reclamations`
--
ALTER TABLE `reclamations`
  MODIFY `id_reclamation` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `semestre`
--
ALTER TABLE `semestre`
  MODIFY `id_semestre` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `specialite`
--
ALTER TABLE `specialite`
  MODIFY `id_specialite` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `statut_jury`
--
ALTER TABLE `statut_jury`
  MODIFY `id_jury` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `traitement`
--
ALTER TABLE `traitement`
  MODIFY `id_traitement` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pour la table `type_utilisateur`
--
ALTER TABLE `type_utilisateur`
  MODIFY `id_type_utilisateur` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `ue`
--
ALTER TABLE `ue`
  MODIFY `id_ue` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT pour la table `versements`
--
ALTER TABLE `versements`
  MODIFY `id_versement` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `affecter`
--
ALTER TABLE `affecter`
  ADD CONSTRAINT `fk_affecter_enseignant` FOREIGN KEY (`id_enseignant`) REFERENCES `enseignants` (`id_enseignant`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_affecter_jury` FOREIGN KEY (`id_jury`) REFERENCES `statut_jury` (`id_jury`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_affecter_rapport` FOREIGN KEY (`id_rapport`) REFERENCES `rapport_etudiants` (`id_rapport`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `approuver`
--
ALTER TABLE `approuver`
  ADD CONSTRAINT `fk_approuver_pers_admin` FOREIGN KEY (`id_pers_admin`) REFERENCES `personnel_admin` (`id_pers_admin`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_approuver_rapport` FOREIGN KEY (`id_rapport`) REFERENCES `rapport_etudiants` (`id_rapport`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `avoir`
--
ALTER TABLE `avoir`
  ADD CONSTRAINT `fk_avoir_enseignant` FOREIGN KEY (`id_enseignant`) REFERENCES `enseignants` (`id_enseignant`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_avoir_grade` FOREIGN KEY (`id_grade`) REFERENCES `grade` (`id_grade`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `candidature_soutenance`
--
ALTER TABLE `candidature_soutenance`
  ADD CONSTRAINT `candidature_soutenance_ibfk_1` FOREIGN KEY (`num_etu`) REFERENCES `etudiants` (`num_etu`),
  ADD CONSTRAINT `candidature_soutenance_ibfk_2` FOREIGN KEY (`id_pers_admin`) REFERENCES `personnel_admin` (`id_pers_admin`);

--
-- Contraintes pour la table `compte_rendu`
--
ALTER TABLE `compte_rendu`
  ADD CONSTRAINT `fk_etudiant` FOREIGN KEY (`num_etu`) REFERENCES `etudiants` (`num_etu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `deposer`
--
ALTER TABLE `deposer`
  ADD CONSTRAINT `fk_deposer_etudiant` FOREIGN KEY (`num_etu`) REFERENCES `etudiants` (`num_etu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_deposer_rapport` FOREIGN KEY (`id_rapport`) REFERENCES `rapport_etudiants` (`id_rapport`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `echeances`
--
ALTER TABLE `echeances`
  ADD CONSTRAINT `echeances_ibfk_1` FOREIGN KEY (`id_inscription`) REFERENCES `inscriptions` (`id_inscription`);

--
-- Contraintes pour la table `ecue`
--
ALTER TABLE `ecue`
  ADD CONSTRAINT `fk_ecue_ue` FOREIGN KEY (`id_ue`) REFERENCES `ue` (`id_ue`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `enseignants`
--
ALTER TABLE `enseignants`
  ADD CONSTRAINT `fk_enseignants_specialite` FOREIGN KEY (`id_specialite`) REFERENCES `specialite` (`id_specialite`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `evaluations_rapports`
--
ALTER TABLE `evaluations_rapports`
  ADD CONSTRAINT `fk_eval_rapport` FOREIGN KEY (`id_rapport`) REFERENCES `rapport_etudiants` (`id_rapport`) ON DELETE CASCADE;

--
-- Contraintes pour la table `evaluer`
--
ALTER TABLE `evaluer`
  ADD CONSTRAINT `fk_evaluer_ecue` FOREIGN KEY (`id_ecue`) REFERENCES `ecue` (`id_ecue`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_evaluer_enseignant` FOREIGN KEY (`id_enseignant`) REFERENCES `enseignants` (`id_enseignant`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_evaluer_etudiant` FOREIGN KEY (`num_etu`) REFERENCES `etudiants` (`num_etu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `historique_reclamations`
--
ALTER TABLE `historique_reclamations`
  ADD CONSTRAINT `fk_historique_reclamation` FOREIGN KEY (`id_reclamation`) REFERENCES `reclamations` (`id_reclamation`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_historique_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `informations_stage`
--
ALTER TABLE `informations_stage`
  ADD CONSTRAINT `informations_stage_ibfk_1` FOREIGN KEY (`num_etu`) REFERENCES `etudiants` (`num_etu`),
  ADD CONSTRAINT `informations_stage_ibfk_2` FOREIGN KEY (`id_entreprise`) REFERENCES `entreprises` (`id_entreprise`);

--
-- Contraintes pour la table `inscriptions`
--
ALTER TABLE `inscriptions`
  ADD CONSTRAINT `inscriptions_ibfk_1` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiants` (`num_etu`),
  ADD CONSTRAINT `inscriptions_ibfk_2` FOREIGN KEY (`id_niveau`) REFERENCES `niveau_etude` (`id_niv_etude`),
  ADD CONSTRAINT `inscriptions_ibfk_3` FOREIGN KEY (`id_annee_acad`) REFERENCES `annee_academique` (`id_annee_acad`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`num_etu`) REFERENCES `etudiants` (`num_etu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`id_ue`) REFERENCES `ue` (`id_ue`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notes_ibfk_3` FOREIGN KEY (`id_ecue`) REFERENCES `ecue` (`id_ecue`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `occuper`
--
ALTER TABLE `occuper`
  ADD CONSTRAINT `fk_occuper_enseignant` FOREIGN KEY (`id_enseignant`) REFERENCES `enseignants` (`id_enseignant`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_occuper_fonction` FOREIGN KEY (`id_fonction`) REFERENCES `fonction` (`id_fonction`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `pister`
--
ALTER TABLE `pister`
  ADD CONSTRAINT `fk_pister_traitement` FOREIGN KEY (`id_traitement`) REFERENCES `traitement` (`id_traitement`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pister_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `posseder`
--
ALTER TABLE `posseder`
  ADD CONSTRAINT `fk_posseder_gu` FOREIGN KEY (`id_GU`) REFERENCES `groupe_utilisateur` (`id_GU`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_posseder_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `rapport_etudiants`
--
ALTER TABLE `rapport_etudiants`
  ADD CONSTRAINT `fk_rapport_etudiants_etudiant` FOREIGN KEY (`num_etu`) REFERENCES `etudiants` (`num_etu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `rattacher`
--
ALTER TABLE `rattacher`
  ADD CONSTRAINT `fk_rattacher_gu` FOREIGN KEY (`id_GU`) REFERENCES `groupe_utilisateur` (`id_GU`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rattacher_traitement` FOREIGN KEY (`id_traitement`) REFERENCES `traitement` (`id_traitement`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `reclamations`
--
ALTER TABLE `reclamations`
  ADD CONSTRAINT `fk_reclamations_admin_assigne` FOREIGN KEY (`id_admin_assigne`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reclamations_etudiant` FOREIGN KEY (`num_etu`) REFERENCES `etudiants` (`num_etu`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reclamations_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `rendre`
--
ALTER TABLE `rendre`
  ADD CONSTRAINT `fk_rendre_cr` FOREIGN KEY (`id_CR`) REFERENCES `compte_rendu` (`id_CR`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rendre_enseignant` FOREIGN KEY (`id_enseignant`) REFERENCES `enseignants` (`id_enseignant`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `semestre`
--
ALTER TABLE `semestre`
  ADD CONSTRAINT `fk_niveau_etude` FOREIGN KEY (`id_niv_etude`) REFERENCES `niveau_etude` (`id_niv_etude`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ue`
--
ALTER TABLE `ue`
  ADD CONSTRAINT `ue_ibfk_1` FOREIGN KEY (`id_annee_academique`) REFERENCES `annee_academique` (`id_annee_acad`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ue_ibfk_2` FOREIGN KEY (`id_niveau_etude`) REFERENCES `niveau_etude` (`id_niv_etude`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ue_ibfk_3` FOREIGN KEY (`id_semestre`) REFERENCES `semestre` (`id_semestre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_ibfk_2` FOREIGN KEY (`id_GU`) REFERENCES `groupe_utilisateur` (`id_GU`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `utilisateur_ibfk_3` FOREIGN KEY (`id_niv_acces_donnee`) REFERENCES `niveau_acces_donnees` (`id_niveau_acces_donnees`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `utilisateur_ibfk_4` FOREIGN KEY (`id_type_utilisateur`) REFERENCES `type_utilisateur` (`id_type_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `valider`
--
ALTER TABLE `valider`
  ADD CONSTRAINT `fk_valider_enseignant` FOREIGN KEY (`id_enseignant`) REFERENCES `enseignants` (`id_enseignant`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_valider_rapport` FOREIGN KEY (`id_rapport`) REFERENCES `rapport_etudiants` (`id_rapport`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `versements`
--
ALTER TABLE `versements`
  ADD CONSTRAINT `versements_ibfk_1` FOREIGN KEY (`id_inscription`) REFERENCES `inscriptions` (`id_inscription`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
