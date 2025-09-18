-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : agencegdwwm.mysql.db
-- Généré le : lun. 15 sep. 2025 à 08:47
-- Version du serveur : 8.0.43-34
-- Version de PHP : 8.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `enquetes`
--

-- --------------------------------------------------------

--
-- Structure de la table `civilities`
--

CREATE TABLE `civilities` (
  `id_civility` int NOT NULL,
  `civility_name` varchar(50) NOT NULL,
  `civility_title` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `civilities`
--

INSERT INTO `civilities` (`id_civility`, `civility_name`, `civility_title`) VALUES
(1, 'Homme', 'Monsieur'),
(2, 'Femme', 'Madame'),
(3, 'Autre', 'Mondame');

-- --------------------------------------------------------

--
-- Structure de la table `pnl_genders`
--

CREATE TABLE `pnl_genders` (
  `id_gender` int NOT NULL,
  `gender_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `pnl_genders`
--

INSERT INTO `pnl_genders` (`id_gender`, `gender_name`) VALUES
(1, 'Monsieur'),
(2, 'Madame');

-- --------------------------------------------------------

--
-- Structure de la table `pnl_users`
--

CREATE TABLE `pnl_users` (
  `id_user` int NOT NULL,
  `user_firstname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_gender` int NOT NULL,
  `user_img` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `pnl_users`
--

INSERT INTO `pnl_users` (`id_user`, `user_firstname`, `user_name`, `id_gender`, `user_img`) VALUES
(1, 'Eddy', 'Colliot', 1, 1),
(2, 'Chelsea', 'Colliot', 2, 2),
(3, 'Anastasiia', 'Babanska', 2, 2),
(4, 'Océane', 'Chaumette', 2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

CREATE TABLE `questions` (
  `id_question` int NOT NULL,
  `question_question` varchar(255) NOT NULL,
  `id_sujet` int NOT NULL,
  `question_date` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `questions`
--

INSERT INTO `questions` (`id_question`, `question_question`, `id_sujet`, `question_date`) VALUES
(1, 'Première question du sujet N°1', 1, '2025-08-21 16:18:05'),
(2, 'Ma seconde question du sujet N°1', 1, '2025-08-25 09:55:04'),
(3, '3e question', 1, '2025-08-27 13:31:22'),
(4, 'Question 4', 1, '2025-08-27 14:02:30'),
(5, 'Civilité:', 5, '2025-09-08 13:53:03'),
(6, 'Tranche d\'âge:', 5, '2025-09-08 13:54:00'),
(7, 'Comment avez-vous connu le Job Dating', 5, '2025-09-08 13:55:29'),
(8, 'Les informations communiquées étaient-elles claires', 5, '2025-09-08 13:58:20'),
(9, 'L\'accueil était-il satisfaisant ?', 5, '2025-09-08 14:00:30'),
(10, 'Dans quel secteur avez-vous déposé votre CV ?', 5, '2025-09-08 14:03:15'),
(11, 'Combien d\'entreprises avez-vous rencontré ?', 5, '2025-09-08 14:04:48'),
(12, 'Ce job dating vous a-t-il aidé à mieux vous préparer pour un entretien ?', 5, '2025-09-08 14:06:11'),
(13, 'Envisagez-vous une formation chez Via Formation ?', 5, '2025-09-08 14:07:08'),
(14, 'Si oui, cochez:', 5, '2025-09-08 14:07:51'),
(15, 'Souhaitez-vous que ce type d\'événement soit renouvelé ?', 5, '2025-09-08 14:09:50'),
(16, 'Quelle note globale de 1 à 5 donneriez-vous au job dating ?', 5, '2025-09-08 14:11:00'),
(17, 'Suggestions / Remarques:', 5, '2025-09-08 14:12:06'),
(18, 'Nom de l\'entreprise:', 6, '2025-09-08 14:15:20'),
(19, 'Secteur d\'activité:', 6, '2025-09-08 14:15:50'),
(20, 'Votre Nom:', 6, '2025-09-08 14:18:13'),
(21, 'Coordonnées:', 6, '2025-09-08 14:18:53'),
(22, 'Fonction:', 6, '2025-09-08 14:19:10'),
(23, 'L\'accueil et l\'organisation étaient-ils satisfaisant ?', 6, '2025-09-08 14:19:49'),
(24, 'Les informations communiquées étaient-elles claires ?', 6, '2025-09-08 14:21:57'),
(25, 'Les candidats rencontrés correspondaient-ils à vos attentes ?', 6, '2025-09-08 14:23:50'),
(26, 'Recommanderiez-vous cet événement à d\'autres recruteurs ?', 6, '2025-09-08 14:25:32'),
(27, 'Envisagez-vous d\'envoyer en formation, un ou plusieurs employés chez VIA Formation ?', 6, '2025-09-08 14:26:34'),
(28, 'Si oui, cochez:', 6, '2025-09-08 14:26:57'),
(29, 'Quelle note globale de 1 à 5 donneriez-vous au job dating ?', 6, '2025-09-08 14:28:30'),
(30, 'Suggestions / Remarques:', 6, '2025-09-08 14:29:31');

-- --------------------------------------------------------

--
-- Structure de la table `questions_rep_poss`
--

CREATE TABLE `questions_rep_poss` (
  `id_question_rep_poss` int NOT NULL,
  `id_question` int NOT NULL,
  `id_rep_poss` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `questions_rep_poss`
--

INSERT INTO `questions_rep_poss` (`id_question_rep_poss`, `id_question`, `id_rep_poss`) VALUES
(1, 1, 2),
(2, 1, 3),
(3, 2, 4),
(4, 2, 5),
(5, 3, 6),
(6, 3, 7),
(7, 4, 8),
(8, 4, 9),
(9, 4, 10),
(10, 5, 11),
(11, 5, 12),
(12, 5, 13),
(13, 6, 14),
(14, 6, 15),
(15, 6, 16),
(16, 6, 17),
(17, 6, 18),
(18, 7, 19),
(19, 7, 20),
(20, 7, 21),
(21, 7, 22),
(22, 7, 23),
(23, 7, 24),
(24, 8, 25),
(25, 8, 26),
(26, 8, 27),
(27, 9, 28),
(28, 9, 29),
(29, 9, 30),
(30, 9, 31),
(31, 10, 32),
(32, 10, 33),
(33, 10, 34),
(34, 10, 35),
(35, 10, 36),
(36, 11, 37),
(37, 11, 38),
(38, 11, 39),
(39, 11, 40),
(40, 12, 41),
(41, 12, 42),
(42, 13, 43),
(43, 13, 44),
(44, 14, 45),
(45, 14, 46),
(46, 14, 47),
(47, 14, 48),
(48, 14, 49),
(49, 15, 50),
(50, 15, 51),
(51, 16, 52),
(52, 16, 53),
(53, 16, 54),
(54, 16, 55),
(55, 16, 56),
(56, 16, 57),
(57, 17, 58),
(58, 18, 59),
(59, 19, 60),
(60, 20, 61),
(61, 21, 62),
(62, 22, 63),
(63, 23, 64),
(64, 23, 65),
(65, 23, 66),
(66, 23, 67),
(67, 24, 68),
(68, 24, 69),
(69, 24, 70),
(70, 25, 71),
(71, 25, 72),
(72, 25, 73),
(73, 25, 74),
(74, 26, 75),
(75, 26, 76),
(76, 27, 77),
(77, 27, 78),
(78, 28, 79),
(79, 28, 80),
(80, 28, 81),
(81, 28, 82),
(82, 28, 83),
(83, 29, 84),
(84, 29, 85),
(85, 29, 86),
(86, 29, 87),
(87, 29, 88),
(88, 29, 89),
(89, 30, 90);

-- --------------------------------------------------------

--
-- Structure de la table `question_types`
--

CREATE TABLE `question_types` (
  `id_question_type` int NOT NULL,
  `question_type_nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `question_types`
--

INSERT INTO `question_types` (`id_question_type`, `question_type_nom`) VALUES
(1, 'text'),
(2, 'Radio'),
(3, 'Checkbox');

-- --------------------------------------------------------

--
-- Structure de la table `reponses`
--

CREATE TABLE `reponses` (
  `id_reponse` int NOT NULL,
  `reponse_reponse` text,
  `id_utilisateur` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `reponses`
--

INSERT INTO `reponses` (`id_reponse`, `reponse_reponse`, `id_utilisateur`) VALUES
(19, 'Chambre', 1),
(20, 'Salon', 1),
(21, 'Oui', 4),
(22, 'Non', 4),
(23, 'Cuisine', 4),
(24, 'Salon', 4),
(25, 'test', 4),
(26, '', 4),
(27, 'Tout est parfait', 9),
(28, '5', 9),
(29, 'Femme', 10),
(30, '55 et +', 10),
(31, 'Autres', 10),
(32, 'Oui', 10),
(33, 'Très satisfaisant', 10),
(34, 'Tertiaire', 10),
(35, '2', 10),
(36, 'Non', 10),
(37, 'Oui', 10),
(38, 'Tertiaire', 10),
(39, 'Oui', 10),
(40, '4', 10),
(41, 'L\'accueil est excellent (je remercie tout particulièrement Johanna pour son dévouement, sa présence constante et ses conseils).  Plus de diversité pour les entreprises rendrait cet événement plus attractif. ', 10),
(42, 'Homme', 11),
(43, 'Autres', 11),
(44, '', 11),
(45, '5', 11),
(46, 'Oui', 11),
(47, 'Numérique', 11),
(48, 'Oui', 11),
(49, 'Oui', 11),
(50, '0', 11),
(51, 'Numérique', 11),
(52, 'Très satisfaisant', 11),
(53, 'Oui', 11),
(54, '18 - 24', 11),
(55, 'Autres', 12),
(56, '', 12),
(57, 'Femme', 15),
(58, 'Femme', 14),
(59, '35 - 44', 14),
(60, '35 - 44', 15),
(61, 'Affiche', 14),
(62, 'Oui', 14),
(63, 'Affiche', 15),
(64, 'Tout était parfait ', 13),
(65, 'Satisfaisant', 14),
(66, 'Oui', 15),
(67, 'Autres', 14),
(68, 'Satisfaisant', 15),
(69, '1', 14),
(70, 'Tertiaire', 15),
(71, 'Non', 14),
(72, 'Non', 14),
(73, '2', 15),
(74, 'Oui', 15),
(75, 'Oui', 14),
(76, 'Oui', 15),
(77, '4', 14),
(78, '', 14),
(79, 'Autres', 14),
(80, 'Tertiaire', 15),
(81, 'Oui', 15),
(82, '4', 15),
(83, 'Plus de communication ', 15),
(84, 'Homme', 16),
(85, '45 - 54', 16),
(86, 'Réseaux sociaux', 16),
(87, 'Oui', 16),
(88, 'Très satisfaisant', 16),
(89, 'Autres', 16),
(90, '1', 16),
(91, 'Oui', 16),
(92, 'Oui', 16),
(93, 'Oui', 16),
(94, 'Autres', 16),
(95, '5', 16),
(96, 'Accueil remarquable ', 16),
(97, 'Homme', 17),
(98, '25 - 34', 17),
(99, 'Autres', 17),
(100, 'Affiche', 17),
(101, 'Moyennement', 17),
(102, 'Satisfaisant', 17),
(103, 'Commerce / Vente', 17),
(104, 'Commerce / Vente', 18),
(105, '2', 17),
(106, 'Satisfaisant', 18),
(107, 'Non', 17),
(108, 'Homme', 18),
(109, '18 - 24', 18),
(110, 'Non', 17),
(111, 'Affiche', 18),
(112, 'Oui', 18),
(113, '1', 18),
(114, 'Oui', 17),
(115, 'Non', 18),
(116, '3', 17),
(117, 'Non', 18),
(118, '3', 18),
(119, 'Oui', 18),
(120, 'Commerce / Vente', 18),
(121, '', 18),
(122, 'Homme', 19),
(123, '45 - 54', 19),
(124, 'Autres', 19),
(125, 'Oui', 19),
(126, 'Médico Social / Service à la personne', 19),
(127, 'Tertiaire', 19),
(128, '2', 19),
(129, 'Non', 19),
(130, 'Non', 19),
(131, 'Oui', 19),
(132, '4', 19),
(133, 'Ce job dating bien qu\'il ne corresponde pas à mes attentes professionnelles a le mérite d\'exister et m\'a permis de rencontrer des professionnels d\'autres secteurs bravo ', 19),
(134, 'Femme', 20),
(135, '', 20),
(136, 'Homme', 21),
(137, '25 - 34', 21),
(138, 'Autres', 21),
(139, 'Oui', 21),
(140, 'Très satisfaisant', 21),
(141, 'Commerce / Vente', 21),
(142, '2', 21),
(143, 'Oui', 21),
(144, 'Oui', 21),
(145, 'Commerce / Vente', 21),
(146, 'Oui', 21),
(147, '4', 21),
(148, 'Aucune, vous avez répondu à toute mes questions ', 21),
(149, '', 22),
(150, '4', 22),
(151, 'Oui', 22),
(152, 'Non', 22),
(153, 'Non', 22),
(154, '1', 22),
(155, 'Numérique', 22),
(156, 'Satisfaisant', 22),
(157, 'Oui', 22),
(158, 'Presse', 22),
(159, '35 - 44', 22),
(160, 'Homme', 22),
(161, 'Autres', 22),
(162, 'Homme', 23),
(163, 'Femme', 24),
(164, '25 - 34', 24),
(165, 'Homme', 26),
(166, '55 et +', 26),
(167, 'Affiche', 26),
(168, 'Oui', 26),
(169, 'Très satisfaisant', 26),
(170, 'Autres', 26),
(171, '0', 26),
(172, 'Non', 26),
(173, 'Non', 26),
(174, 'Oui', 26),
(175, '5', 26),
(176, 'Très bon accueil avec les personnes présentes. Tout est parfait.', 26),
(177, '35 - 44', 27),
(178, '', 27),
(179, 'Femme', 27);

-- --------------------------------------------------------

--
-- Structure de la table `reponses_questions`
--

CREATE TABLE `reponses_questions` (
  `id_reponse_question` int NOT NULL,
  `id_question` int NOT NULL,
  `id_reponse` int NOT NULL,
  `reponse_question_date` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `reponses_questions`
--

INSERT INTO `reponses_questions` (`id_reponse_question`, `id_question`, `id_reponse`, `reponse_question_date`) VALUES
(1, 4, 19, '2025-09-01 11:58:52'),
(2, 4, 20, '2025-09-01 11:58:52'),
(3, 2, 21, '2025-09-06 15:34:18'),
(4, 3, 22, '2025-09-06 15:34:21'),
(5, 4, 23, '2025-09-06 15:34:25'),
(6, 4, 24, '2025-09-06 15:34:25'),
(7, 1, 25, '2025-09-06 15:34:30'),
(8, 1, 26, '2025-09-06 15:34:30'),
(9, 17, 27, '2025-09-09 09:50:23'),
(10, 16, 28, '2025-09-09 09:50:52'),
(11, 5, 29, '2025-09-09 11:04:48'),
(12, 6, 30, '2025-09-09 11:04:59'),
(13, 7, 31, '2025-09-09 11:05:08'),
(14, 8, 32, '2025-09-09 11:05:20'),
(15, 9, 33, '2025-09-09 11:05:24'),
(16, 10, 34, '2025-09-09 11:05:41'),
(17, 11, 35, '2025-09-09 11:05:51'),
(18, 12, 36, '2025-09-09 11:06:15'),
(19, 13, 37, '2025-09-09 11:06:22'),
(20, 14, 38, '2025-09-09 11:06:27'),
(21, 15, 39, '2025-09-09 11:06:33'),
(22, 16, 40, '2025-09-09 11:06:41'),
(23, 17, 41, '2025-09-09 11:10:58'),
(24, 5, 42, '2025-09-09 11:16:36'),
(25, 7, 43, '2025-09-09 11:16:46'),
(26, 17, 44, '2025-09-09 11:17:40'),
(27, 16, 45, '2025-09-09 11:17:46'),
(28, 15, 46, '2025-09-09 11:17:53'),
(29, 14, 47, '2025-09-09 11:17:56'),
(30, 13, 48, '2025-09-09 11:17:59'),
(31, 12, 49, '2025-09-09 11:18:04'),
(32, 11, 50, '2025-09-09 11:18:09'),
(33, 10, 51, '2025-09-09 11:18:11'),
(34, 9, 52, '2025-09-09 11:18:14'),
(35, 8, 53, '2025-09-09 11:18:24'),
(36, 6, 54, '2025-09-09 11:18:30'),
(37, 7, 55, '2025-09-09 11:18:40'),
(38, 17, 56, '2025-09-09 11:21:04'),
(39, 5, 57, '2025-09-09 11:27:59'),
(40, 5, 58, '2025-09-09 11:28:09'),
(41, 6, 59, '2025-09-09 11:28:14'),
(42, 6, 60, '2025-09-09 11:28:15'),
(43, 7, 61, '2025-09-09 11:28:17'),
(44, 8, 62, '2025-09-09 11:28:22'),
(45, 7, 63, '2025-09-09 11:28:31'),
(46, 17, 64, '2025-09-09 11:28:35'),
(47, 9, 65, '2025-09-09 11:28:36'),
(48, 8, 66, '2025-09-09 11:28:39'),
(49, 10, 67, '2025-09-09 11:28:43'),
(50, 9, 68, '2025-09-09 11:28:48'),
(51, 11, 69, '2025-09-09 11:28:50'),
(52, 10, 70, '2025-09-09 11:28:56'),
(53, 12, 71, '2025-09-09 11:28:58'),
(54, 13, 72, '2025-09-09 11:29:01'),
(55, 11, 73, '2025-09-09 11:29:03'),
(56, 12, 74, '2025-09-09 11:29:08'),
(57, 15, 75, '2025-09-09 11:29:13'),
(58, 13, 76, '2025-09-09 11:29:18'),
(59, 16, 77, '2025-09-09 11:29:19'),
(60, 17, 78, '2025-09-09 11:29:25'),
(61, 14, 79, '2025-09-09 11:29:30'),
(62, 14, 80, '2025-09-09 11:29:41'),
(63, 15, 81, '2025-09-09 11:29:47'),
(64, 16, 82, '2025-09-09 11:29:52'),
(65, 17, 83, '2025-09-09 11:31:30'),
(66, 5, 84, '2025-09-09 12:13:35'),
(67, 6, 85, '2025-09-09 12:13:41'),
(68, 7, 86, '2025-09-09 12:13:45'),
(69, 8, 87, '2025-09-09 12:13:51'),
(70, 9, 88, '2025-09-09 12:13:54'),
(71, 10, 89, '2025-09-09 12:14:01'),
(72, 11, 90, '2025-09-09 12:14:08'),
(73, 12, 91, '2025-09-09 12:14:14'),
(74, 15, 92, '2025-09-09 12:14:34'),
(75, 13, 93, '2025-09-09 12:14:58'),
(76, 14, 94, '2025-09-09 12:15:03'),
(77, 16, 95, '2025-09-09 12:15:09'),
(78, 17, 96, '2025-09-09 12:15:24'),
(79, 5, 97, '2025-09-09 12:15:49'),
(80, 6, 98, '2025-09-09 12:15:55'),
(81, 7, 99, '2025-09-09 12:16:05'),
(82, 7, 100, '2025-09-09 12:16:05'),
(83, 8, 101, '2025-09-09 12:16:10'),
(84, 9, 102, '2025-09-09 12:16:16'),
(85, 10, 103, '2025-09-09 12:16:24'),
(86, 10, 104, '2025-09-09 12:16:28'),
(87, 11, 105, '2025-09-09 12:16:31'),
(88, 9, 106, '2025-09-09 12:16:33'),
(89, 12, 107, '2025-09-09 12:16:36'),
(90, 5, 108, '2025-09-09 12:16:36'),
(91, 6, 109, '2025-09-09 12:16:39'),
(92, 13, 110, '2025-09-09 12:16:42'),
(93, 7, 111, '2025-09-09 12:16:42'),
(94, 8, 112, '2025-09-09 12:16:45'),
(95, 11, 113, '2025-09-09 12:16:54'),
(96, 15, 114, '2025-09-09 12:16:57'),
(97, 12, 115, '2025-09-09 12:17:08'),
(98, 16, 116, '2025-09-09 12:17:10'),
(99, 13, 117, '2025-09-09 12:17:20'),
(100, 16, 118, '2025-09-09 12:17:30'),
(101, 15, 119, '2025-09-09 12:17:38'),
(102, 14, 120, '2025-09-09 12:17:45'),
(103, 17, 121, '2025-09-09 12:17:50'),
(104, 5, 122, '2025-09-09 12:18:02'),
(105, 6, 123, '2025-09-09 12:18:07'),
(106, 7, 124, '2025-09-09 12:18:15'),
(107, 8, 125, '2025-09-09 12:18:20'),
(108, 10, 126, '2025-09-09 12:18:31'),
(109, 10, 127, '2025-09-09 12:18:31'),
(110, 11, 128, '2025-09-09 12:18:37'),
(111, 12, 129, '2025-09-09 12:18:42'),
(112, 13, 130, '2025-09-09 12:18:46'),
(113, 15, 131, '2025-09-09 12:18:55'),
(114, 16, 132, '2025-09-09 12:19:01'),
(115, 17, 133, '2025-09-09 12:20:46'),
(116, 5, 134, '2025-09-09 14:11:32'),
(117, 17, 135, '2025-09-09 14:12:20'),
(118, 5, 136, '2025-09-09 14:42:35'),
(119, 6, 137, '2025-09-09 14:42:43'),
(120, 7, 138, '2025-09-09 14:42:51'),
(121, 8, 139, '2025-09-09 14:42:55'),
(122, 9, 140, '2025-09-09 14:43:01'),
(123, 10, 141, '2025-09-09 14:43:11'),
(124, 11, 142, '2025-09-09 14:43:20'),
(125, 12, 143, '2025-09-09 14:43:26'),
(126, 13, 144, '2025-09-09 14:43:30'),
(127, 14, 145, '2025-09-09 14:43:34'),
(128, 15, 146, '2025-09-09 14:43:44'),
(129, 16, 147, '2025-09-09 14:43:52'),
(130, 17, 148, '2025-09-09 14:44:17'),
(131, 17, 149, '2025-09-09 15:19:04'),
(132, 16, 150, '2025-09-09 15:19:17'),
(133, 15, 151, '2025-09-09 15:19:20'),
(134, 13, 152, '2025-09-09 15:19:31'),
(135, 12, 153, '2025-09-09 15:19:35'),
(136, 11, 154, '2025-09-09 15:19:38'),
(137, 10, 155, '2025-09-09 15:19:40'),
(138, 9, 156, '2025-09-09 15:19:42'),
(139, 8, 157, '2025-09-09 15:19:45'),
(140, 7, 158, '2025-09-09 15:19:47'),
(141, 6, 159, '2025-09-09 15:19:48'),
(142, 5, 160, '2025-09-09 15:19:50'),
(143, 14, 161, '2025-09-09 15:20:11'),
(144, 5, 162, '2025-09-09 15:21:46'),
(145, 5, 163, '2025-09-09 15:29:23'),
(146, 6, 164, '2025-09-09 15:29:30'),
(147, 5, 165, '2025-09-09 15:43:00'),
(148, 6, 166, '2025-09-09 15:43:09'),
(149, 7, 167, '2025-09-09 15:43:19'),
(150, 8, 168, '2025-09-09 15:43:26'),
(151, 9, 169, '2025-09-09 15:43:30'),
(152, 10, 170, '2025-09-09 15:43:43'),
(153, 11, 171, '2025-09-09 15:43:48'),
(154, 12, 172, '2025-09-09 15:43:54'),
(155, 13, 173, '2025-09-09 15:43:59'),
(156, 15, 174, '2025-09-09 15:44:07'),
(157, 16, 175, '2025-09-09 15:44:15'),
(158, 17, 176, '2025-09-09 15:44:46'),
(159, 6, 177, '2025-09-09 16:21:01'),
(160, 17, 178, '2025-09-09 16:22:54'),
(161, 5, 179, '2025-09-09 16:23:06');

-- --------------------------------------------------------

--
-- Structure de la table `rep_poss`
--

CREATE TABLE `rep_poss` (
  `id_rep_poss` int NOT NULL,
  `rep_poss_reponse` varchar(255) NOT NULL,
  `id_question_type` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `rep_poss`
--

INSERT INTO `rep_poss` (`id_rep_poss`, `rep_poss_reponse`, `id_question_type`) VALUES
(1, 'reponse 1 de question 1 du sujet 1', 1),
(2, 'Reponse 2 à la question 1 du sujet 1', 1),
(3, 'Deuxième réponse à la question du sujet 1', 1),
(4, 'Oui', 2),
(5, 'Non', 2),
(6, 'Oui', 2),
(7, 'Non', 2),
(8, 'Cuisine', 3),
(9, 'Salon', 3),
(10, 'Chambre', 3),
(11, 'Femme', 2),
(12, 'Homme', 2),
(13, 'Autre', 2),
(14, '18 - 24', 2),
(15, '25 - 34', 2),
(16, '35 - 44', 2),
(17, '45 - 54', 2),
(18, '55 et +', 2),
(19, 'Affiche', 3),
(20, 'Réseaux sociaux', 3),
(21, 'Site internet', 3),
(22, 'Radio', 3),
(23, 'Presse', 3),
(24, 'Autres', 3),
(25, 'Oui', 2),
(26, 'Moyennement', 2),
(27, 'Non', 2),
(28, 'Très satisfaisant', 2),
(29, 'Satisfaisant', 2),
(30, 'Peu satisfaisant', 2),
(31, 'Pas du tout', 2),
(32, 'Médico Social / Service à la personne', 3),
(33, 'Tertiaire', 3),
(34, 'Numérique', 3),
(35, 'Commerce / Vente', 3),
(36, 'Autres', 3),
(37, '0', 2),
(38, '1', 2),
(39, '2', 2),
(40, '3+', 2),
(41, 'Oui', 2),
(42, 'Non', 2),
(43, 'Oui', 2),
(44, 'Non', 2),
(45, 'Médico Social / Service à la personne', 3),
(46, 'Tertiaire', 3),
(47, 'Numérique', 3),
(48, 'Commerce / Vente', 3),
(49, 'Autres', 3),
(50, 'Oui', 2),
(51, 'Non', 2),
(52, '0', 2),
(53, '1', 2),
(54, '2', 2),
(55, '3', 2),
(56, '4', 2),
(57, '5', 2),
(58, 'Ecrivez-nous vos suggestions ici:', 1),
(59, 'Ecrivez ici:', 1),
(60, 'Ecrivez ici:', 1),
(61, 'Ecrivez ici:', 1),
(62, 'Ecrivez ici:', 1),
(63, 'Ecrivez ici:', 1),
(64, 'Très satisfaisant', 2),
(65, 'Satisfaisant', 2),
(66, 'Moyennement', 2),
(67, 'Insatisfaisant', 2),
(68, 'Oui', 2),
(69, 'Moyennement', 2),
(70, 'non', 2),
(71, 'Tout à fait', 2),
(72, 'Moyennement', 2),
(73, 'Pas vraiment', 2),
(74, 'Pas du tout', 2),
(75, 'Oui', 2),
(76, 'Non', 2),
(77, 'Oui', 2),
(78, 'Non', 2),
(79, 'Médico Social / Service à la personne', 3),
(80, 'Tertiaire', 3),
(81, 'Numérique', 3),
(82, 'Commerce / Vente', 3),
(83, 'Autres', 3),
(84, '0', 2),
(85, '1', 2),
(86, '2', 2),
(87, '3', 2),
(88, '4', 2),
(89, '5', 2),
(90, 'Ecrivez ici:', 1);

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id_role` int NOT NULL,
  `role_name` varchar(100) NOT NULL,
  `role_level` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id_role`, `role_name`, `role_level`) VALUES
(1, 'Utilisateur', 10),
(2, 'Modérateur', 50),
(3, 'Administrateur', 100);

-- --------------------------------------------------------

--
-- Structure de la table `sujets`
--

CREATE TABLE `sujets` (
  `id_sujet` int NOT NULL,
  `sujet_nom` varchar(50) NOT NULL,
  `sujet_type` int NOT NULL DEFAULT '0' COMMENT '0: Particulier, 1: Entreprise',
  `sujet_date` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `sujets`
--

INSERT INTO `sujets` (`id_sujet`, `sujet_nom`, `sujet_type`, `sujet_date`) VALUES
(1, 'Nouveau question de satisfaction', 0, '2025-08-21 14:21:26'),
(2, 'Mon second sujet', 0, '2025-08-21 14:41:14'),
(3, 'Mon troisième sujet', 0, '2025-08-21 14:41:25'),
(4, 'Mon quatrième sujet', 0, '2025-08-29 13:50:51'),
(5, 'Questionnaire de satisfaction - Visiteur', 0, '2025-09-08 13:35:56'),
(6, 'Questionnaire de satisfaction - Entreprise', 1, '2025-09-08 13:36:06');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `user_lastname` varchar(50) NOT NULL,
  `user_firstname` varchar(50) NOT NULL,
  `id_civility` int NOT NULL,
  `user_pwd` varchar(255) NOT NULL,
  `user_mail` varchar(100) NOT NULL,
  `id_role` int NOT NULL,
  `user_create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_activ` int NOT NULL DEFAULT '0' COMMENT '0: actif, 1 inactif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `user_lastname`, `user_firstname`, `id_civility`, `user_pwd`, `user_mail`, `id_role`, `user_create_date`, `user_activ`) VALUES
(1, 'Colliot', 'Eddy', 1, '$argon2i$v=19$m=65536,t=4,p=1$SXJtY2ZFZDEuL2J1MWV2SA$OMpi2EvUpTQrjznW4vU0EJSgP7fnY07snfyP818hWmc', 'eddy.colliot@gmail.com', 3, '2025-09-04 11:58:00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_utilisateur` int NOT NULL,
  `utilisateur_mail` varchar(100) NOT NULL,
  `utilisateur_societe` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `utilisateur_type` int NOT NULL DEFAULT '0' COMMENT '0: particulier, 1: entreprise',
  `id_sujet` int NOT NULL DEFAULT '1',
  `utilisateur_date` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `utilisateur_mail`, `utilisateur_societe`, `utilisateur_type`, `id_sujet`, `utilisateur_date`) VALUES
(1, 'eddy.colliot@gmail.com', '', 1, 1, '2025-09-01 11:50:05'),
(2, '1@gmail.com', NULL, 0, 1, '2025-09-01 14:23:15'),
(3, '2@gmail.com', NULL, 0, 1, '2025-09-01 14:24:15'),
(4, '12@gmail.com', NULL, 0, 1, '2025-09-06 15:33:50'),
(5, '14@gmail.com', NULL, 0, 1, '2025-09-08 12:32:58'),
(6, 'ntsangoula.d@gmail.com', NULL, 0, 5, '2025-09-08 14:18:21'),
(7, 'test@gmail.com', NULL, 0, 5, '2025-09-08 14:30:17'),
(8, 'mickamicka28140@gmail.com', NULL, 0, 5, '2025-09-08 14:43:55'),
(9, 'angordomguvin@gmail.com', NULL, 0, 5, '2025-09-09 09:42:15'),
(10, 'sandrine.ceranton@gmail.com', NULL, 0, 5, '2025-09-09 11:04:43'),
(11, 'magalievillette@hotmail.com', NULL, 0, 5, '2025-09-09 11:16:08'),
(12, 'liger.michael@gmail.com', NULL, 0, 5, '2025-09-09 11:18:25'),
(13, 'aichamoursal@gmail.com', NULL, 0, 5, '2025-09-09 11:25:37'),
(14, 'corinneligeza@gmail.com', NULL, 0, 5, '2025-09-09 11:27:43'),
(15, 'Williaminna@yahoo.fr', NULL, 0, 5, '2025-09-09 11:27:52'),
(16, 'laurent.grosmaire304@orange.fr', NULL, 0, 5, '2025-09-09 12:13:13'),
(17, 'Killian.anceaume15@gmail.com', NULL, 0, 5, '2025-09-09 12:15:19'),
(18, 'eakbasialenti@gmail.com ', NULL, 0, 5, '2025-09-09 12:15:52'),
(19, 'patricelanfranchi@gmail.com', NULL, 0, 5, '2025-09-09 12:17:49'),
(20, '', NULL, 0, 5, '2025-09-09 14:11:26'),
(21, 'Fabiendu28170@hotmail.fr', NULL, 0, 5, '2025-09-09 14:42:25'),
(22, 'j.lepuill232@laposte.net ', NULL, 0, 5, '2025-09-09 15:18:18'),
(23, 'gulmohammadajaz07@gmail.com', NULL, 0, 5, '2025-09-09 15:21:33'),
(24, 'Benghalimalek@gmail.com', NULL, 0, 5, '2025-09-09 15:29:18'),
(25, 'noelliemoins28@gmail.com', NULL, 0, 5, '2025-09-09 15:33:28'),
(26, 'yann.gillard28@gmail.com', NULL, 0, 5, '2025-09-09 15:42:40'),
(27, 'linda.gaudin97@gmail.com', NULL, 0, 5, '2025-09-09 16:09:24'),
(30, 'benedicte.manoeuvrier@viaformation.fr', NULL, 1, 6, '2025-09-09 19:43:11'),
(31, 'Olympe.Krecke@vitalliance.fr', NULL, 1, 6, '2025-09-09 19:55:59'),
(32, 'Chartres@adworks.fr', NULL, 1, 6, '2025-09-12 17:24:55');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `civilities`
--
ALTER TABLE `civilities`
  ADD PRIMARY KEY (`id_civility`);

--
-- Index pour la table `pnl_genders`
--
ALTER TABLE `pnl_genders`
  ADD PRIMARY KEY (`id_gender`);

--
-- Index pour la table `pnl_users`
--
ALTER TABLE `pnl_users`
  ADD PRIMARY KEY (`id_user`);

--
-- Index pour la table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id_question`),
  ADD KEY `id_sujet` (`id_sujet`);

--
-- Index pour la table `questions_rep_poss`
--
ALTER TABLE `questions_rep_poss`
  ADD PRIMARY KEY (`id_question_rep_poss`),
  ADD KEY `id_question` (`id_question`),
  ADD KEY `id_rep_poss` (`id_rep_poss`);

--
-- Index pour la table `question_types`
--
ALTER TABLE `question_types`
  ADD PRIMARY KEY (`id_question_type`);

--
-- Index pour la table `reponses`
--
ALTER TABLE `reponses`
  ADD PRIMARY KEY (`id_reponse`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `reponses_questions`
--
ALTER TABLE `reponses_questions`
  ADD PRIMARY KEY (`id_reponse_question`),
  ADD KEY `id_question` (`id_question`),
  ADD KEY `id_reponse` (`id_reponse`);

--
-- Index pour la table `rep_poss`
--
ALTER TABLE `rep_poss`
  ADD PRIMARY KEY (`id_rep_poss`),
  ADD KEY `id_question_type` (`id_question_type`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`);

--
-- Index pour la table `sujets`
--
ALTER TABLE `sujets`
  ADD PRIMARY KEY (`id_sujet`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id_utilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `civilities`
--
ALTER TABLE `civilities`
  MODIFY `id_civility` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `pnl_genders`
--
ALTER TABLE `pnl_genders`
  MODIFY `id_gender` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `pnl_users`
--
ALTER TABLE `pnl_users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `questions`
--
ALTER TABLE `questions`
  MODIFY `id_question` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `questions_rep_poss`
--
ALTER TABLE `questions_rep_poss`
  MODIFY `id_question_rep_poss` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT pour la table `question_types`
--
ALTER TABLE `question_types`
  MODIFY `id_question_type` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `reponses`
--
ALTER TABLE `reponses`
  MODIFY `id_reponse` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT pour la table `reponses_questions`
--
ALTER TABLE `reponses_questions`
  MODIFY `id_reponse_question` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT pour la table `rep_poss`
--
ALTER TABLE `rep_poss`
  MODIFY `id_rep_poss` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `sujets`
--
ALTER TABLE `sujets`
  MODIFY `id_sujet` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_utilisateur` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`id_sujet`) REFERENCES `sujets` (`id_sujet`);

--
-- Contraintes pour la table `questions_rep_poss`
--
ALTER TABLE `questions_rep_poss`
  ADD CONSTRAINT `questions_rep_poss_ibfk_1` FOREIGN KEY (`id_question`) REFERENCES `questions` (`id_question`),
  ADD CONSTRAINT `questions_rep_poss_ibfk_2` FOREIGN KEY (`id_rep_poss`) REFERENCES `rep_poss` (`id_rep_poss`);

--
-- Contraintes pour la table `reponses`
--
ALTER TABLE `reponses`
  ADD CONSTRAINT `reponses_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`);

--
-- Contraintes pour la table `reponses_questions`
--
ALTER TABLE `reponses_questions`
  ADD CONSTRAINT `reponses_questions_ibfk_1` FOREIGN KEY (`id_question`) REFERENCES `questions` (`id_question`),
  ADD CONSTRAINT `reponses_questions_ibfk_2` FOREIGN KEY (`id_reponse`) REFERENCES `reponses` (`id_reponse`);

--
-- Contraintes pour la table `rep_poss`
--
ALTER TABLE `rep_poss`
  ADD CONSTRAINT `rep_poss_ibfk_1` FOREIGN KEY (`id_question_type`) REFERENCES `question_types` (`id_question_type`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
