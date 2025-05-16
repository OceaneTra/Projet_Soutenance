-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : jeu. 15 mai 2025 à 12:29
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
  `date_deb` datetime NOT NULL,
  `date_fin` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

--
-- Déchargement des données de la table `annee_academique`
--

INSERT INTO `annee_academique` (`id_annee_acad`, `date_deb`, `date_fin`) VALUES
(21819, '2018-09-15 00:00:00', '2019-05-30 00:00:00'),
(22021, '2020-10-12 00:00:00', '2021-05-30 00:00:00');

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
  `date_grade` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `compte_rendu`
--

CREATE TABLE `compte_rendu` (
  `id_CR` int NOT NULL,
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
-- Structure de la table `ecue`
--

CREATE TABLE `ecue` (
  `id_ecue` int NOT NULL,
  `id_ue` int NOT NULL,
  `lib_ecue` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `credit` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `enseignants`
--

CREATE TABLE `enseignants` (
  `id_enseignant` int NOT NULL,
  `nom_enseignant` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `prenom_enseignant` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `mail_enseignant` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `login_enseignant` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `mdp_enseignant` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `id_specialite` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `entreprises`
--

CREATE TABLE `entreprises` (
  `id_entreprise` int NOT NULL,
  `lib_entreprise` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

CREATE TABLE `etudiants` (
  `num_etu` int NOT NULL,
  `nom_etu` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `prenom_etu` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `date_naiss_etu` date NOT NULL,
  `genre_etu` enum('Homme','Femme','Neutre') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `login_etu` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `mdp_etu` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

--
-- Déchargement des données de la table `etudiants`
--

INSERT INTO `etudiants` (`num_etu`, `nom_etu`, `prenom_etu`, `date_naiss_etu`, `genre_etu`, `login_etu`, `mdp_etu`) VALUES
(102034, 'Monsan', 'Josué', '2004-03-22', 'Homme', 'mjmanuel@gmail.com', 'mdpParDefaut');

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
-- Structure de la table `faire_stage`
--

CREATE TABLE `faire_stage` (
  `id_entreprise` int NOT NULL,
  `num_etu` int NOT NULL,
  `date_deb_stage` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fonction`
--

CREATE TABLE `fonction` (
  `id_fonction` int NOT NULL,
  `lib_fonction` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

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
(6, 'A2'),
(7, 'A1');

-- --------------------------------------------------------

--
-- Structure de la table `groupe_utilisateur`
--

CREATE TABLE `groupe_utilisateur` (
  `id_GU` int NOT NULL,
  `lib_GU` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `inscrire`
--

CREATE TABLE `inscrire` (
  `num_etu` int NOT NULL,
  `id_annee_acad` int NOT NULL,
  `id_niv_etude` int NOT NULL,
  `date_inscr` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id_message` int NOT NULL,
  `contenu_message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(3, 'tout');

-- --------------------------------------------------------

--
-- Structure de la table `niveau_approbation`
--

CREATE TABLE `niveau_approbation` (
  `id_approb` int NOT NULL,
  `lib_approb` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `niveau_etude`
--

CREATE TABLE `niveau_etude` (
  `id_niv_etude` int NOT NULL,
  `lib_niv_etude` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

--
-- Déchargement des données de la table `niveau_etude`
--

INSERT INTO `niveau_etude` (`id_niv_etude`, `lib_niv_etude`) VALUES
(6, 'Licence 1'),
(7, 'Licence 2'),
(8, 'Licence 3');

-- --------------------------------------------------------

--
-- Structure de la table `occuper`
--

CREATE TABLE `occuper` (
  `id_fonction` int NOT NULL,
  `id_enseignant` int NOT NULL,
  `date_occupation` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personnel_admin`
--

CREATE TABLE `personnel_admin` (
  `id_pers_admin` int NOT NULL,
  `nom_pers_admin` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `prenom_pers_admin` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `email_pers_admin` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `login_pers_admin` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `mdp_pers_admin` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

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
  `theme_rapport` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `rattacher`
--

CREATE TABLE `rattacher` (
  `id_GU` int NOT NULL,
  `id_traitement` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

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
  `lib_semestre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `semestre`
--

INSERT INTO `semestre` (`id_semestre`, `lib_semestre`) VALUES
(1, 'semestre 5'),
(2, 'Semestre 6'),
(3, 'semestre 1'),
(4, 'semestre 2');

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
(2, 'Informatique');

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
(5, 'Ouin');

-- --------------------------------------------------------

--
-- Structure de la table `traitement`
--

CREATE TABLE `traitement` (
  `id_traitement` int NOT NULL,
  `lib_traitement` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `type_utilisateur`
--

CREATE TABLE `type_utilisateur` (
  `id_type_utilisateur` int NOT NULL,
  `lib_type_utilisateur` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

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

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int NOT NULL,
  `nom_utilisateur` varchar(200) COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `id_type_utilisateur` int NOT NULL,
  `id_fonction` int NOT NULL,
  `id_GU` int NOT NULL,
  `id_niv_acces_donnee` int NOT NULL,
  `statut_utilisateur` varchar(50) COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `login_utilisateur` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL,
  `mdp_utilisateur` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_mysql500_ci;

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
-- Index pour la table `compte_rendu`
--
ALTER TABLE `compte_rendu`
  ADD PRIMARY KEY (`id_CR`);

--
-- Index pour la table `deposer`
--
ALTER TABLE `deposer`
  ADD KEY `Key_deposer_etudiant` (`num_etu`),
  ADD KEY `Key_deposer_rapport_etud` (`id_rapport`);

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
  ADD PRIMARY KEY (`id_entreprise`);

--
-- Index pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD PRIMARY KEY (`num_etu`);

--
-- Index pour la table `evaluer`
--
ALTER TABLE `evaluer`
  ADD KEY `Key_evaluer_ecue` (`id_ecue`),
  ADD KEY `Key_evaluer_enseignant` (`id_enseignant`),
  ADD KEY `Key_evaluer_etudiant` (`num_etu`);

--
-- Index pour la table `faire_stage`
--
ALTER TABLE `faire_stage`
  ADD KEY `Key_faireStage_entreprise` (`id_entreprise`),
  ADD KEY `Key_faireStage_etudiant` (`num_etu`);

--
-- Index pour la table `fonction`
--
ALTER TABLE `fonction`
  ADD PRIMARY KEY (`id_fonction`);

--
-- Index pour la table `grade`
--
ALTER TABLE `grade`
  ADD PRIMARY KEY (`id_grade`);

--
-- Index pour la table `groupe_utilisateur`
--
ALTER TABLE `groupe_utilisateur`
  ADD PRIMARY KEY (`id_GU`);

--
-- Index pour la table `inscrire`
--
ALTER TABLE `inscrire`
  ADD KEY `Key_inscrip_anneeAc` (`id_annee_acad`),
  ADD KEY `Key_inscrip_niv_etude` (`id_niv_etude`),
  ADD KEY `Key_inscrip_etudiant` (`num_etu`);

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
-- Index pour la table `rendre`
--
ALTER TABLE `rendre`
  ADD KEY `Key_rendre_CR` (`id_CR`),
  ADD KEY `Key_rendre_enseignant` (`id_enseignant`);

--
-- Index pour la table `semestre`
--
ALTER TABLE `semestre`
  ADD PRIMARY KEY (`id_semestre`);

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
  ADD KEY `id_fonction` (`id_fonction`),
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
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `action`
--
ALTER TABLE `action`
  MODIFY `id_action` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `annee_academique`
--
ALTER TABLE `annee_academique`
  MODIFY `id_annee_acad` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29901;

--
-- AUTO_INCREMENT pour la table `compte_rendu`
--
ALTER TABLE `compte_rendu`
  MODIFY `id_CR` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ecue`
--
ALTER TABLE `ecue`
  MODIFY `id_ecue` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `enseignants`
--
ALTER TABLE `enseignants`
  MODIFY `id_enseignant` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `entreprises`
--
ALTER TABLE `entreprises`
  MODIFY `id_entreprise` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `etudiants`
--
ALTER TABLE `etudiants`
  MODIFY `num_etu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102035;

--
-- AUTO_INCREMENT pour la table `fonction`
--
ALTER TABLE `fonction`
  MODIFY `id_fonction` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `grade`
--
ALTER TABLE `grade`
  MODIFY `id_grade` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `groupe_utilisateur`
--
ALTER TABLE `groupe_utilisateur`
  MODIFY `id_GU` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id_message` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `niveau_acces_donnees`
--
ALTER TABLE `niveau_acces_donnees`
  MODIFY `id_niveau_acces_donnees` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `niveau_approbation`
--
ALTER TABLE `niveau_approbation`
  MODIFY `id_approb` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `niveau_etude`
--
ALTER TABLE `niveau_etude`
  MODIFY `id_niv_etude` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `personnel_admin`
--
ALTER TABLE `personnel_admin`
  MODIFY `id_pers_admin` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `rapport_etudiants`
--
ALTER TABLE `rapport_etudiants`
  MODIFY `id_rapport` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `semestre`
--
ALTER TABLE `semestre`
  MODIFY `id_semestre` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `specialite`
--
ALTER TABLE `specialite`
  MODIFY `id_specialite` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `statut_jury`
--
ALTER TABLE `statut_jury`
  MODIFY `id_jury` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `traitement`
--
ALTER TABLE `traitement`
  MODIFY `id_traitement` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `type_utilisateur`
--
ALTER TABLE `type_utilisateur`
  MODIFY `id_type_utilisateur` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `ue`
--
ALTER TABLE `ue`
  MODIFY `id_ue` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int NOT NULL AUTO_INCREMENT;

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
-- Contraintes pour la table `deposer`
--
ALTER TABLE `deposer`
  ADD CONSTRAINT `fk_deposer_etudiant` FOREIGN KEY (`num_etu`) REFERENCES `etudiants` (`num_etu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_deposer_rapport` FOREIGN KEY (`id_rapport`) REFERENCES `rapport_etudiants` (`id_rapport`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Contraintes pour la table `evaluer`
--
ALTER TABLE `evaluer`
  ADD CONSTRAINT `fk_evaluer_ecue` FOREIGN KEY (`id_ecue`) REFERENCES `ecue` (`id_ecue`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_evaluer_enseignant` FOREIGN KEY (`id_enseignant`) REFERENCES `enseignants` (`id_enseignant`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_evaluer_etudiant` FOREIGN KEY (`num_etu`) REFERENCES `etudiants` (`num_etu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `faire_stage`
--
ALTER TABLE `faire_stage`
  ADD CONSTRAINT `fk_faire_stage_entreprise` FOREIGN KEY (`id_entreprise`) REFERENCES `entreprises` (`id_entreprise`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_faire_stage_etudiant` FOREIGN KEY (`num_etu`) REFERENCES `etudiants` (`num_etu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `inscrire`
--
ALTER TABLE `inscrire`
  ADD CONSTRAINT `fk_inscrire_annee_acad` FOREIGN KEY (`id_annee_acad`) REFERENCES `annee_academique` (`id_annee_acad`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inscrire_etudiant` FOREIGN KEY (`num_etu`) REFERENCES `etudiants` (`num_etu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inscrire_niv_etude` FOREIGN KEY (`id_niv_etude`) REFERENCES `niveau_etude` (`id_niv_etude`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Contraintes pour la table `rendre`
--
ALTER TABLE `rendre`
  ADD CONSTRAINT `fk_rendre_cr` FOREIGN KEY (`id_CR`) REFERENCES `compte_rendu` (`id_CR`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rendre_enseignant` FOREIGN KEY (`id_enseignant`) REFERENCES `enseignants` (`id_enseignant`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`id_fonction`) REFERENCES `fonction` (`id_fonction`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `utilisateur_ibfk_2` FOREIGN KEY (`id_GU`) REFERENCES `groupe_utilisateur` (`id_GU`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `utilisateur_ibfk_3` FOREIGN KEY (`id_niv_acces_donnee`) REFERENCES `niveau_acces_donnees` (`id_niveau_acces_donnees`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `utilisateur_ibfk_4` FOREIGN KEY (`id_type_utilisateur`) REFERENCES `type_utilisateur` (`id_type_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `valider`
--
ALTER TABLE `valider`
  ADD CONSTRAINT `fk_valider_enseignant` FOREIGN KEY (`id_enseignant`) REFERENCES `enseignants` (`id_enseignant`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_valider_rapport` FOREIGN KEY (`id_rapport`) REFERENCES `rapport_etudiants` (`id_rapport`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
