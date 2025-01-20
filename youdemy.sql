-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 16 jan. 2025 à 16:34
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `youdemy`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_title` varchar(50) NOT NULL,
  `category_description` text NOT NULL,
  `creation_date` date DEFAULT curdate(),
  `category_status` enum('actif','inactif') DEFAULT 'actif'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`category_id`, `category_title`, `category_description`, `creation_date`, `category_status`) VALUES
(1, 'Bruno Graham', 'Earum doloremque vel', '2025-01-16', 'actif'),
(2, 'Eve Mcdowell', 'Laboriosam et repre', '2025-01-16', '');

-- --------------------------------------------------------

--
-- Structure de la table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_title` varchar(50) NOT NULL,
  `course_content` enum('video','document') DEFAULT NULL,
  `creation_date` date DEFAULT curdate(),
  `course_status` enum('accepté','en attente','refusé') DEFAULT 'accepté',
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `course_tags`
--

CREATE TABLE `course_tags` (
  `tag_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  PRIMARY KEY (`tag_id`, `course_id`),
  FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE
);


-- --------------------------------------------------------

--
-- Structure de la table `enrollments`
--

CREATE TABLE `enrollments` (
  `enrollment_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `enrollment_date` date DEFAULT curdate(),
  `enrollment_status` enum('accepté','en attente','refusé') NOT NULL DEFAULT 'accepté'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tags`
--

CREATE TABLE `tags` (
  `tag_id` int(11) NOT NULL,
  `tag_title` varchar(20) NOT NULL,
  `admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('etudiant','enseignant','admin') NOT NULL,
  `user_status` enum('accepté','en attente','refusé') DEFAULT 'accepté',
  `is_banned` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `role`, `user_status`, `is_banned`) VALUES
(1, 'OUSSAMA', 'EDDDERKAOUI', 'oussamaedd@gmail.com', '$2y$10$.vXkzjMYTLL8jIqOnMh7mOqXRS/yHVikx1Vn6Q73Y1uiiEwoAem0S', 'enseignant', 'accepté', 0),
(3, 'Vel voluptas volupta', 'Quia dolorem error d', 'secuwor@mailinator.com', '$2y$10$bctN3npw.MWcdLS3Gj/MR.QneZ3p8LUy70Ih5WWc7gjEIxUfi6xCS', 'enseignant', 'accepté', 0),
(4, 'Fuga Consequatur p', 'Provident distincti', 'dezote@mailinator.com', '$2y$10$835cE2adx.vR1G8yDlXYjuk4yQjSZVNFWxMrYVlhhg9yLDEppg2lm', 'etudiant', 'accepté', 0),
(5, 'Consectetur dolore ', 'Animi tempor possim', 'fewylese@mailinator.com', '$2y$10$iwCOazRwk.Wsd1zF9rXckuHt89Seaw31ydTLTbL0N/DdP8oUdhVaa', 'etudiant', 'accepté', 0),
(6, 'Nisi ad quidem a ven', 'Illum autem cupidat', 'zeza@mailinator.com', '$2y$10$PO5nr.3Mh0QCFvdDGLju5ueSkUiPwkOq1ykWGfGC.GR4vGLzM9fdi', 'enseignant', 'accepté', 0),
(7, 'Labore fugiat non n', 'Voluptate deserunt q', 'pyfixu@mailinator.com', '$2y$10$pTXFPtVOyKia0j7Ald0XQuqfTPSVN9FcSYbWFhHNNqeseL1w4.Gfe', 'etudiant', 'accepté', 0),
(8, 'Repudiandae magna au', 'Et consequat Ipsum', 'fecyvo@mailinator.com', '$2y$10$nJ8vVG.QoN5Zp78E/H85zOCybZJ0GTwjcGyrKsuYLfgcYQItD2Bbu', 'enseignant', 'accepté', 0),
(9, 'JAWAD', 'EDDERKAOUI', 'jawadedd@gmail.com', '$2y$10$mUMWeSp6gXPdZSlrwMO.X.T/xdZ73D4JLIGYOZIBgYC3p.ErFsiAK', 'enseignant', 'accepté', 0),
(10, 'AHMED', 'ALI', 'tymimaw@mailinator.com', '$2y$10$8al89F58pcRY8XRoW1M5l.tLbM7g22yh.rj5YHAmicUu5P65QO/QC', 'etudiant', 'accepté', 0),
(12, 'ABDELATIF', 'RIAD', 'riad@gmail.com', '$2y$10$xajd8QiN5IGwAQchaOgZRe0U.W0VzKzdVnoni.QZaaCQjMOKSGquG', 'enseignant', 'en attente', 0),
(15, 'Eum dolores et earum', 'Earum dolores volupt', 'kipytutyc@mailinator.com', '$2y$10$hUfKjapPT57NkSEG9pUH/ua1dQOXDeLzVz.D0jNZmXCle7YX.YDra', 'etudiant', '', 0),
(16, 'Quae facere ea eaque', 'Ut accusantium enim ', 'gico@mailinator.com', '$2y$10$q2Czq0/VH0QWotDEETTGyOylNjC9HnL9jgKEhMKCa4yZvN.mBhsWq', 'etudiant', '', 0),
(17, 'Aperiam modi dolores', 'Nostrum aut ullamco ', 'cotaj@mailinator.com', '$2y$10$egdsbHC3WXCIt3ub3klBMe1.wGyzuX7HbPc.oeQ8p/MIHPJacETra', 'enseignant', 'en attente', 0),
(18, 'Harum voluptate sunt', 'Saepe ex esse aliqu', 'zynype@mailinator.com', '$2y$10$zUfUHDx2X19rcNRMM4PUlOw0lVVw6ejBOrL8r9VLFkjNW9ZsvWHD2', 'etudiant', 'accepté', 0),
(19, 'Voluptas autem natus', 'Quae labore quae eos', 'lanutas@mailinator.com', '$2y$10$KlzE/9yOWXc/uOPBBXUE3uu4HsQvOu25kqhD7YFFkPGA/vTl70hdC', 'etudiant', '', 0),
(20, 'Soluta quis porro ne', 'Illo mollit quasi cu', 'locyhyh@mailinator.com', '$2y$10$c.6Xuitpmpg593FVNB2HTeedxm0JGLSjRwCmMa6npdBkcMA28F.ha', 'enseignant', 'en attente', 0),
(21, 'Natus enim vitae ea ', 'Molestias eum cillum', 'bipeqocyfo@mailinator.com', '$2y$10$GHgsV0IDZoXXj9gIeXmBROCf6TAITBcUEVHB4WEbYz5C68rJ3juCK', 'etudiant', '', 0),
(22, 'Qui nihil fugit nul', 'Molestiae quia dolor', 'davadi@mailinator.com', '$2y$10$H7jpiEIczSmx.HiBlwig1e1QMqquDoTy19iLzgOWP8NFJ361dOunq', 'etudiant', '', 0),
(23, 'Est laborum in occa', 'Obcaecati qui repell', 'qucyfi@mailinator.com', '$2y$10$lYOWXXjMQJi6dKiX4lOQYOQb6sfPXrQQafI6Hz5a78/IlUPba.GRm', 'enseignant', 'en attente', 0),
(24, 'Et excepturi provide', 'Et labore officiis p', 'texu@mailinator.com', '$2y$10$FWgI4Vwe.jSZPGY92IStVOjieIGfTtJZ8/7Lam.c86R3H0pgfd7Sy', 'etudiant', '', 0),
(25, 'Deleniti quasi do qu', 'Aut perspiciatis re', 'gedynytin@mailinator.com', '$2y$10$qH60AUMUr/Olgly2H0V6b.bmPMcr.2FSo8J9W3xiiZviioJPsE.fa', 'etudiant', 'accepté', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_title` (`category_title`);

--
-- Index pour la table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD UNIQUE KEY `course_title` (`course_title`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Index pour la table `course_tags`
--
ALTER TABLE `course_tags`
  ADD PRIMARY KEY (`tag_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Index pour la table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Index pour la table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `enrollment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `course_tags`
--
ALTER TABLE `course_tags`
  ADD CONSTRAINT `course_tags_ibfk_1` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_tags_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `tags_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
