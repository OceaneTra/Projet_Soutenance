-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : jeu. 15 mai 2025 à 02:32
-- Version du serveur : 8.0.42
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `soutenance_manager`
--

-- --------------------------------------------------------

--
-- Structure de la table `action`
--

CREATE TABLE `action`
(
    `id_action`  int(11)      NOT NULL,
    `lib_action` varchar(120) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `affecter`
--

CREATE TABLE `affecter`
(
    `id_enseignant` int(11) NOT NULL,
    `id_rapport`    int(11) NOT NULL,
    `id_jury`       int(11) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `annee_academique`
--

CREATE TABLE `annee_academique`
(
    `id_annee_acad` int(11)  NOT NULL,
    `date_deb`      datetime NOT NULL,
    `date_fin`      datetime NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

--
-- Déchargement des données de la table `annee_academique`
--

INSERT INTO `annee_academique` (`id_annee_acad`, `date_deb`, `date_fin`)
VALUES (22223, '2022-09-05 00:00:00', '2023-07-21 00:00:00'),
       (22324, '2023-09-11 00:00:00', '2024-07-26 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `approuver`
--

CREATE TABLE `approuver`
(
    `id_pers_admin`      int(11)  NOT NULL,
    `id_rapport`         int(11)  NOT NULL,
    `date_approv`        datetime NOT NULL,
    `commentaire_approv` text     NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `avoir`
--

CREATE TABLE `avoir`
(
    `id_grade`      int(11)  NOT NULL,
    `id_enseignant` int(11)  NOT NULL,
    `date_grade`    datetime NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `compte_rendu`
--

CREATE TABLE `compte_rendu`
(
    `id_CR`   int(11)     NOT NULL,
    `nom_CR`  varchar(70) NOT NULL,
    `date_CR` datetime    NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `deposer`
--

CREATE TABLE `deposer`
(
    `num_etu`    int(11)  NOT NULL,
    `id_rapport` int(11)  NOT NULL,
    `date_depot` datetime NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ecue`
--

CREATE TABLE `ecue`
(
    `id_ecue`  int(11)     NOT NULL,
    `id_ue`    int(11)     NOT NULL,
    `lib_ecue` varchar(70) NOT NULL,
    `credit`   int(11)     NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `enseignants`
--

CREATE TABLE `enseignants`
(
    `id_enseignant`     int(11)      NOT NULL,
    `nom_enseignant`    varchar(50)  NOT NULL,
    `prenom_enseignant` varchar(100) NOT NULL,
    `mail_enseignant`   varchar(100) NOT NULL,
    `login_enseignant`  varchar(30)  NOT NULL,
    `mdp_enseignant`    varchar(255) NOT NULL,
    `id_specialite`     int(11)      NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `entreprises`
--

CREATE TABLE `entreprises`
(
    `id_entreprise`  int(11)      NOT NULL,
    `lib_entreprise` varchar(100) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

CREATE TABLE `etudiants`
(
    `num_etu`        int(11)                         NOT NULL,
    `nom_etu`        varchar(50)                     NOT NULL,
    `prenom_etu`     varchar(100)                    NOT NULL,
    `date_naiss_etu` date                            NOT NULL,
    `genre_etu`      enum ('Homme','Femme','Neutre') NOT NULL,
    `login_etu`      varchar(30)                     NOT NULL,
    `mdp_etu`        varchar(255)                    NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `evaluer`
--

CREATE TABLE `evaluer`
(
    `num_etu`         int(11)  NOT NULL,
    `id_ecue`         int(11)  NOT NULL,
    `id_enseignant`   int(11)  NOT NULL,
    `date_evaluation` datetime NOT NULL,
    `note`            int(11)  NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `faire_stage`
--

CREATE TABLE `faire_stage`
(
    `id_entreprise`  int(11)  NOT NULL,
    `num_etu`        int(11)  NOT NULL,
    `date_deb_stage` datetime NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fonction`
--

CREATE TABLE `fonction`
(
    `id_fonction`  int(11)     NOT NULL,
    `lib_fonction` varchar(70) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `grade`
--

CREATE TABLE `grade`
(
    `id_grade`  int(11)      NOT NULL,
    `lib_grade` varchar(150) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

--
-- Déchargement des données de la table `grade`
--

INSERT INTO `grade` (`id_grade`, `lib_grade`)
VALUES (6, 'A2'),
       (7, 'A1');

-- --------------------------------------------------------

--
-- Structure de la table `groupe_utilisateur`
--

CREATE TABLE `groupe_utilisateur`
(
    `id_GU`  int(11)      NOT NULL,
    `lib_GU` varchar(100) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `inscrire`
--

CREATE TABLE `inscrire`
(
    `num_etu`       int(11)  NOT NULL,
    `id_annee_acad` int(11)  NOT NULL,
    `id_niv_etude`  int(11)  NOT NULL,
    `date_inscr`    datetime NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `menu_config`
--

CREATE TABLE `menu_config`
(
    `id`            int(11)      NOT NULL,
    `role`          varchar(50)  NOT NULL COMMENT 'admin, personnel_admin, enseignant, etudiant',
    `slug`          varchar(50)  NOT NULL COMMENT 'Identifiant unique du menu',
    `label`         varchar(100) NOT NULL COMMENT 'Libellé affiché',
    `icon`          varchar(50)  NOT NULL COMMENT 'Classe FontAwesome ou autre',
    `parent_id`     int(11)               DEFAULT NULL COMMENT 'Pour les sous-menus',
    `display_order` int(11)      NOT NULL DEFAULT 0 COMMENT 'Ordre d affichage',
    `is_active`     tinyint(1)            DEFAULT 1 COMMENT 'Actif/inactif',
    `created_at`    timestamp    NOT NULL DEFAULT current_timestamp(),
    `updated_at`    timestamp    NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

--
-- Déchargement des données de la table `menu_config`
--

INSERT INTO `menu_config` (`id`, `role`, `slug`, `label`, `icon`, `parent_id`, `display_order`, `is_active`,
                           `created_at`, `updated_at`)
VALUES (1, 'admin', 'dashboard', 'Tableau de bord', 'fa-chart-line', NULL, 1, 1, '2025-05-15 00:21:31',
        '2025-05-15 00:21:31'),
       (2, 'admin', 'gestion_etudiants', 'Gestion des étudiants', 'fa-book', NULL, 2, 1, '2025-05-15 00:21:31',
        '2025-05-15 00:21:31'),
       (3, 'admin', 'gestion_rh', 'Gestion des ressources humaines', 'fa-users', NULL, 3, 1, '2025-05-15 00:21:31',
        '2025-05-15 00:21:31'),
       (4, 'admin', 'gestion_utilisateurs', 'Gestion des utilisateurs', 'fa-user', NULL, 4, 1, '2025-05-15 00:21:31',
        '2025-05-15 00:21:31'),
       (5, 'admin', 'piste_audit', 'Gestion de la piste d\'audit', 'fa-history', NULL, 5, 1, '2025-05-15 00:21:31',
        '2025-05-15 00:21:31'),
       (6, 'admin', 'sauvegarde_restauration', 'Sauvegarde et restauration des données', 'fa-save', NULL, 6, 1,
        '2025-05-15 00:21:31', '2025-05-15 00:21:31'),
       (7, 'admin', 'parametres_generaux', 'Paramètres généraux', 'fa-gears', NULL, 7, 1, '2025-05-15 00:21:31',
        '2025-05-15 00:21:31'),
       (8, 'admin', 'profil', 'Profil', 'fa-user', NULL, 8, 1, '2025-05-15 00:21:31', '2025-05-15 00:21:31'),
       (9, 'personnel_admin', 'candidature_soutenance', 'Candidater à la soutenance', 'fa-graduation-cap', NULL, 1, 1,
        '2025-05-15 00:21:31', '2025-05-15 00:21:31'),
       (10, 'personnel_admin', 'gestion_rapport', 'Gestion des rapports/mémoires', 'fa-file', NULL, 2, 1,
        '2025-05-15 00:21:31', '2025-05-15 00:21:31'),
       (11, 'personnel_admin', 'gestion_reclamations', 'Réclamations', 'fa-circle-exclamation', NULL, 3, 1,
        '2025-05-15 00:21:31', '2025-05-15 00:21:31'),
       (12, 'personnel_admin', 'notes_resultats', 'Notes & résultats', 'fa-note-sticky', NULL, 4, 1,
        '2025-05-15 00:21:31', '2025-05-15 00:21:31'),
       (13, 'personnel_admin', 'messagerie', 'Messagerie', 'fa-envelope', NULL, 5, 1, '2025-05-15 00:21:31',
        '2025-05-15 00:21:31'),
       (14, 'personnel_admin', 'profil', 'Profil', 'fa-user', NULL, 6, 1, '2025-05-15 00:21:31', '2025-05-15 00:21:31'),
       (15, 'enseignant', 'dashboard_ens', 'Tableau de bord', 'fa-chart-line', NULL, 1, 1, '2025-05-15 00:21:31',
        '2025-05-15 00:21:31'),
       (16, 'enseignant', 'mes_jurys', 'Mes jurys', 'fa-users', NULL, 2, 1, '2025-05-15 00:21:31',
        '2025-05-15 00:21:31'),
       (17, 'enseignant', 'evaluation', 'Évaluation', 'fa-star', NULL, 3, 1, '2025-05-15 00:21:31',
        '2025-05-15 00:21:31'),
       (18, 'enseignant', 'messagerie', 'Messagerie', 'fa-envelope', NULL, 4, 1, '2025-05-15 00:21:31',
        '2025-05-15 00:21:31'),
       (19, 'enseignant', 'profil', 'Profil', 'fa-user', NULL, 5, 1, '2025-05-15 00:21:31', '2025-05-15 00:21:31'),
       (20, 'etudiant', 'candidature_soutenance', 'Candidater à la soutenance', 'fa-graduation-cap', NULL, 1, 1,
        '2025-05-15 00:21:31', '2025-05-15 00:21:31'),
       (21, 'etudiant', 'gestion_rapport', 'Gestion des rapports', 'fa-file', NULL, 2, 1, '2025-05-15 00:21:31',
        '2025-05-15 00:21:31'),
       (22, 'etudiant', 'gestion_reclamations', 'Réclamations', 'fa-exclamation', NULL, 3, 1, '2025-05-15 00:21:31',
        '2025-05-15 00:21:31'),
       (23, 'etudiant', 'notes_resultats', 'Notes & résultats', 'fa-note-sticky', NULL, 4, 1, '2025-05-15 00:21:31',
        '2025-05-15 00:21:31'),
       (24, 'etudiant', 'messagerie', 'Messagerie', 'fa-envelope', NULL, 5, 1, '2025-05-15 00:21:31',
        '2025-05-15 00:21:31'),
       (25, 'etudiant', 'profil', 'Profil', 'fa-user', NULL, 6, 1, '2025-05-15 00:21:31', '2025-05-15 00:21:31');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages`
(
    `id_message`      int(11) NOT NULL,
    `contenu_message` text    NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `niveau_acces_donnees`
--

CREATE TABLE `niveau_acces_donnees`
(
    `id_niveau_acces_donnees`  varchar(20) NOT NULL,
    `lib_niveau_acces_donnees` varchar(70) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `niveau_approbation`
--

CREATE TABLE `niveau_approbation`
(
    `id_approb`  int(11)      NOT NULL,
    `lib_approb` varchar(100) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `niveau_etude`
--

CREATE TABLE `niveau_etude`
(
    `id_niv_etude`  int(11)     NOT NULL,
    `lib_niv_etude` varchar(20) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

--
-- Déchargement des données de la table `niveau_etude`
--

INSERT INTO `niveau_etude` (`id_niv_etude`, `lib_niv_etude`)
VALUES (6, 'Licence 1'),
       (7, 'Licence 2'),
       (8, 'Licence 3');

-- --------------------------------------------------------

--
-- Structure de la table `occuper`
--

CREATE TABLE `occuper`
(
    `id_fonction`     int(11)  NOT NULL,
    `id_enseignant`   int(11)  NOT NULL,
    `date_occupation` datetime NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personnel_admin`
--

CREATE TABLE `personnel_admin`
(
    `id_pers_admin`     int(11)      NOT NULL,
    `nom_pers_admin`    varchar(50)  NOT NULL,
    `prenom_pers_admin` varchar(100) NOT NULL,
    `email_pers_admin`  varchar(100) NOT NULL,
    `login_pers_admin`  varchar(30)  NOT NULL,
    `mdp_pers_admin`    varchar(255) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pister`
--

CREATE TABLE `pister`
(
    `id_utilisateur` int(11)    NOT NULL,
    `id_traitement`  int(11)    NOT NULL,
    `date_acces`     date       NOT NULL,
    `heure_acces`    time       NOT NULL,
    `acceder`        tinyint(1) NOT NULL DEFAULT 0
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `posseder`
--

CREATE TABLE `posseder`
(
    `id_utilisateur` int(11)  NOT NULL,
    `id_GU`          int(11)  NOT NULL,
    `date_possed`    datetime NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `rapport_etudiants`
--

CREATE TABLE `rapport_etudiants`
(
    `id_rapport`    int(11)      NOT NULL,
    `num_etu`       int(11)      NOT NULL,
    `nom_rapport`   varchar(150) NOT NULL,
    `date_rapport`  datetime     NOT NULL,
    `theme_rapport` varchar(150) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `rattacher`
--

CREATE TABLE `rattacher`
(
    `id_GU`         int(11) NOT NULL,
    `id_traitement` int(11) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `rendre`
--

CREATE TABLE `rendre`
(
    `id_CR`         int(11)  NOT NULL,
    `id_enseignant` int(11)  NOT NULL,
    `date_env`      datetime NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `semestre`
--

CREATE TABLE `semestre`
(
    `id_semestre`  int(11)      NOT NULL,
    `lib_semestre` varchar(100) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

--
-- Déchargement des données de la table `semestre`
--

INSERT INTO `semestre` (`id_semestre`, `lib_semestre`)
VALUES (1, 'semestre 5'),
       (2, 'Semestre 6');

-- --------------------------------------------------------

--
-- Structure de la table `specialite`
--

CREATE TABLE `specialite`
(
    `id_specialite`  int(11)     NOT NULL,
    `lib_specialite` varchar(70) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

--
-- Déchargement des données de la table `specialite`
--

INSERT INTO `specialite` (`id_specialite`, `lib_specialite`)
VALUES (2, 'Informatique');

-- --------------------------------------------------------

--
-- Structure de la table `statut_jury`
--

CREATE TABLE `statut_jury`
(
    `id_jury`  int(11)     NOT NULL,
    `lib_jury` varchar(50) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

--
-- Déchargement des données de la table `statut_jury`
--

INSERT INTO `statut_jury` (`id_jury`, `lib_jury`)
VALUES (2, 'z');

-- --------------------------------------------------------

--
-- Structure de la table `traitement`
--

CREATE TABLE `traitement`
(
    `id_traitement`  int(11)      NOT NULL,
    `lib_traitement` varchar(100) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `type_utilisateur`
--

CREATE TABLE `type_utilisateur`
(
    `id_type_utilisateur`  int(11)      NOT NULL,
    `lib_type_utilisateur` varchar(100) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ue`
--

CREATE TABLE `ue`
(
    `id_ue`               int(11)     NOT NULL,
    `lib_ue`              varchar(70) NOT NULL,
    `id_niveau_etude`     int(11)     NOT NULL,
    `id_semestre`         int(11)     NOT NULL,
    `id_annee_academique` int(11)     NOT NULL,
    `credit`              int(11)     NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

--
-- Déchargement des données de la table `ue`
--

INSERT INTO `ue` (`id_ue`, `lib_ue`, `id_niveau_etude`, `id_semestre`, `id_annee_academique`, `credit`)
VALUES (3, 'BMO', 8, 2, 22324, 3);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur`
(
    `id_utilisateur`    int(11)      NOT NULL,
    `login_utilisateur` varchar(20)  NOT NULL,
    `mdp_utilisateur`   varchar(255) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `valider`
--

CREATE TABLE `valider`
(
    `id_enseignant`          int(11)       NOT NULL,
    `id_rapport`             int(11)       NOT NULL,
    `date_validation`        datetime      NOT NULL,
    `commentaire_validation` varchar(1000) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_mysql500_ci;

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
-- Index pour la table `menu_config`
--
ALTER TABLE `menu_config`
    ADD PRIMARY KEY (`id`),
    ADD KEY `parent_id` (`parent_id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
    ADD PRIMARY KEY (`id_message`);

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
    ADD PRIMARY KEY (`id_utilisateur`);

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
    MODIFY `id_action` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `annee_academique`
--
ALTER TABLE `annee_academique`
    MODIFY `id_annee_acad` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 29901;

--
-- AUTO_INCREMENT pour la table `compte_rendu`
--
ALTER TABLE `compte_rendu`
    MODIFY `id_CR` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ecue`
--
ALTER TABLE `ecue`
    MODIFY `id_ecue` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 2;

--
-- AUTO_INCREMENT pour la table `enseignants`
--
ALTER TABLE `enseignants`
    MODIFY `id_enseignant` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `entreprises`
--
ALTER TABLE `entreprises`
    MODIFY `id_entreprise` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `etudiants`
--
ALTER TABLE `etudiants`
    MODIFY `num_etu` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `fonction`
--
ALTER TABLE `fonction`
    MODIFY `id_fonction` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `grade`
--
ALTER TABLE `grade`
    MODIFY `id_grade` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 8;

--
-- AUTO_INCREMENT pour la table `groupe_utilisateur`
--
ALTER TABLE `groupe_utilisateur`
    MODIFY `id_GU` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 5;

--
-- AUTO_INCREMENT pour la table `menu_config`
--
ALTER TABLE `menu_config`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 26;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
    MODIFY `id_message` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `niveau_approbation`
--
ALTER TABLE `niveau_approbation`
    MODIFY `id_approb` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `niveau_etude`
--
ALTER TABLE `niveau_etude`
    MODIFY `id_niv_etude` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 9;

--
-- AUTO_INCREMENT pour la table `personnel_admin`
--
ALTER TABLE `personnel_admin`
    MODIFY `id_pers_admin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `rapport_etudiants`
--
ALTER TABLE `rapport_etudiants`
    MODIFY `id_rapport` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `semestre`
--
ALTER TABLE `semestre`
    MODIFY `id_semestre` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 3;

--
-- AUTO_INCREMENT pour la table `specialite`
--
ALTER TABLE `specialite`
    MODIFY `id_specialite` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 3;

--
-- AUTO_INCREMENT pour la table `statut_jury`
--
ALTER TABLE `statut_jury`
    MODIFY `id_jury` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 3;

--
-- AUTO_INCREMENT pour la table `traitement`
--
ALTER TABLE `traitement`
    MODIFY `id_traitement` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `type_utilisateur`
--
ALTER TABLE `type_utilisateur`
    MODIFY `id_type_utilisateur` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT pour la table `ue`
--
ALTER TABLE `ue`
    MODIFY `id_ue` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
    MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT;

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
-- Contraintes pour la table `menu_config`
--
ALTER TABLE `menu_config`
    ADD CONSTRAINT `menu_config_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `menu_config` (`id`) ON DELETE SET NULL;

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
-- Contraintes pour la table `valider`
--
ALTER TABLE `valider`
    ADD CONSTRAINT `fk_valider_enseignant` FOREIGN KEY (`id_enseignant`) REFERENCES `enseignants` (`id_enseignant`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_valider_rapport` FOREIGN KEY (`id_rapport`) REFERENCES `rapport_etudiants` (`id_rapport`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
