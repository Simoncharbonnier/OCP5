-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 12 mai 2023 à 16:30
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : OCP5
--

-- --------------------------------------------------------

--
-- Structure de la table Comment
--

CREATE TABLE Comment (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `created_at` date NOT NULL,
  `valid` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table Comment
--

INSERT INTO Comment (`id`, `user_id`, `post_id`, `message`, `created_at`, `valid`) VALUES
(59, 2, 64, "Je ne connaissais pas, ça à l\'air vraiment super ! Il faut certainement être bien motivé pour apprendre un domaine inconnu en si peu de temps !", "2023-05-12", 1),
(61, 4, 67, "Est-il possible d\'avoir un lien vers le site ?", "2023-05-12", 1),
(62, 1, 67, "Je suis désolé mais il n\'est plus en ligne.", "2023-05-12", 1),
(63, 5, 66, "Développer dans ce contexte n\'est jamais facile, alors félicitations !", "2023-05-12", 1);

-- --------------------------------------------------------

--
-- Structure de la table Post
--

CREATE TABLE Post (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `headline` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(128) DEFAULT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table Post
--

INSERT INTO Post (`id`, `user_id`, `title`, `headline`, `content`, `image`, `created_at`, `updated_at`) VALUES
(64, 1, "Le Wagon Nantes", "Le bootcamp de 9 semaines pour apprendre à coder !", "Le Wagon est le bootcamp de code n°1 dans le monde pour vous reconvertir dans la tech, ou monter en compétences dans votre métier actuel.\r\nEn quelques semaines, on y apprend les compétences fondamentales d\'un.e Développeur.se Web. J\'ai tenté l\'expérience de Janvier à Mars 2022, c\'était formidable. <br>\r\n<br>\r\nChaque jour se déroulait de la manière suivante : <br>\r\n- 9h00-10h30: conférence du matin par l\'enseignant principal avec de nombreuses démonstrations en direct pour nous aider à comprendre les concepts à l\'aide d\'exemples pratiques. <br>\r\n- 10h30-12h30: session de programmation en binôme, travaillez sur les défis et poussez vos solutions sur Kitt. <br>\r\n- 14h00-17h30: terminez vos défis de la journée avec votre binôme. <br>\r\n- 17h30-19h00: session de code en direct, l\'enseignant présente un nouveau défi devant la classe et le résout à partir de zéro avec l\'aide de la classe. <br>\r\nIl y a 5 à 10 défis journaliers, différents avec leur propre suite de tests, et des défis optionnels supplémentaires pour les étudiants les plus rapides. <br>\r\n<br>\r\nGrâce à cette formation, j\'ai pu apprendre les bases du développement web en un temps record ! Je suis maintenant apte à utiliser Ruby, Rails, HTML, CSS, Bootstrap, Javascript, Stimulus, SQL, PostgreSQL, APIs, Github, Heroku, Figma... et évidemment apte à travailler en équipe sur toutes sortes de projets !\r\nOn nous accompagne même pour continuer notre carrière dans le domaine avec la career week qui suit la formation !", "post_Le Wagon Nantes.png", "2022-05-25", "2022-05-25"),
(65, 1, "Plan your trip", "Une app qui facilite l\'organisation d\'un groupe pour partir en voyage !", "Cette application est mon projet final de formation du Wagon Nantes (cf. précédent article). <br>\r\nEn groupe de 4, nous avons décidé de concevoir, réaliser et produire une application permettant de faciliter l\'organisation d\'un groupe de personne souhaitant partir en voyage ensemble.<br>\r\n<br>\r\nLe fonctionnement est le suivant, une de ces personnes va créer un voyage sur l\'application, elle va inviter ses partenaires, chacun va renseigner ses disponibilités et ses souhaits concernant la destination, tout ça de manière ludique. <br>\r\nUne fois que chaque personne aura renseigner ses informations, le créateur du voyage va pouvoir confirmer les dates en prenant compte des disponibilités de chacun grâce à une superbe interface. Si aucune des destinations proposées ne sort du lot, un vote va alors s\'effectuer avec les destinations les plus populaires, des informations complémentaires sur les destinations vont être données aux utilisateurs pour les aider à choisir.<br>\r\nUne fois le vote terminé, tout le monde peut découvrir la destination et place à l\'organisation ! Ils ont maintenant accès à un tableau de bord contenant un tchat, une to-do list personnalisable et des propositions d\'activités !", "post_Plan your trip.png", "2022-08-17", "2022-08-17"),
(66, 1, "Webnews", "Une plateforme pour partager et réagir à des articles réalisée en 8h !", "Webnews, c\'est une application que j\'ai développé seul lors de la certification du Wagon, nous avions 8 heures pour la réaliser. <br>\r\nVoici la consigne : <br>\r\n\"Vous devez créer une plateforme pour publier, commenter ou réagir à un contenu trouvé sur Internet.\" <br>\r\nVous pourrez trouver les contraintes de ce projet sur Github. <br>\r\nPS : Le jury m\'a accordé ma certification !", "post_Webnews.png", "2022-10-12", "2022-10-12"),
(67, 1, "Chalets et caviar", "Un site WordPress pour une agence immobilière de luxe", "Ce projet fait parti de ma formation OpenClassrooms de développeur web. <br>\r\nL\'objectif est de réaliser le site WordPress pour l\'agence immobilière de chalets de luxe \"Chalets et caviar\" de Courchevel. <br>\r\nIl y a plusieurs contraintes, le design du site doit montrer la ligne luxueuse de l\'agence, clair et épuré. <br>\r\nL\'équipe de l\'agence doit avoir accès à différents comptes et droits en fonction de leurs statuts, dans le but de pouvoir ajouter, modifier et supprimer des chalets. <br>\r\nUn formulaire de contact doit être également disponible et fonctionnel.\r\n\r\n", "post_Chalets et caviar.png", "2023-01-09", "2023-01-09"),
(68, 1, "Les Films de Plein Air", "Analyse de besoins d\'une association", "Ce projet fait parti de ma formation OpenClassrooms de développeur web. <br>\r\nEn tant que développeur, on nous demande de lister les fonctionnalités dont a besoin le client et de proposer une solution technique adaptée. Vous devez donc sélectionner la solution qui vous semble la plus à même de répondre à son besoin : quels outils utiliser, éventuellement un CMS, etc. dans un cahier des charges complet. <br>\r\nOn doit ensuite réaliser une première maquette de ce site correspondant à ses attentes, en utilisant uniquement HTML et CSS. <br>\r\nLe client est l\'association \"Les Films de Plein Air\", c\'est une nouvelle association ayant pour but de faire découvrir des films d\'auteur au grand public. \r\n", "post_Les Films de Plein Air.png", "2023-04-12", "2023-05-12");

-- --------------------------------------------------------

--
-- Structure de la table User
--

CREATE TABLE `User` (
  `id` int(11) NOT NULL,
  `first_name` varchar(128) NOT NULL,
  `last_name` varchar(128) NOT NULL,
  `mail` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `avatar` varchar(128) NOT NULL DEFAULT "default.jpg"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table User
--

INSERT INTO `User` (`id`, `first_name`, `last_name`, `mail`, `password`, `admin`, `avatar`) VALUES
(1, "Simon", "Charbonnier", "simoncharbonnier@orange.fr", "$2y$10$RcAyVqdQwuErl4hEErUuKO8wWD7qsyvleAcGDAWnxKZ5neZ4Gw9R2", 1, "user_1.jpg"),
(2, "Charlie", "Hartman", "charliehartman@gmail.com", "$2y$10$jpImrFJdjQV7L69Q6.3V7eqM.g2VTCmbEu0bOV4bkLjt9ywubb/K2", 0, "user_2.jpg"),
(3, "Jane", "Doe", "janedoe@gmail.com", "$2y$10$VEm.fPiOBJXkXItmUIRLhetbqYLssSQLHcbAxs9ZrFPa2pHhFp1qy", 0, "default.jpg"),
(4, "John", "Snow", "johnsnow@gmail.com", "$2y$10$JFzvw4W9SUvTgQcv2AF6jeQWMCK3wVKL27E/5tQ8QNorQ4ns1OASC", 0, "default.jpg"),
(5, "Billy", "Robertson", "billyrobertson@gmail.com", "$2y$10$F5i3NfoKXs3VnZPveBOaTuQcPO/eQNAMGGmdhv2C7JhXRML5lP9mu", 0, "user_5.jpg");

--
-- Index pour les tables déchargées
--

--
-- Index pour la table Comment
--

ALTER TABLE Comment
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Index pour la table Post
--

ALTER TABLE Post
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table User
--

ALTER TABLE `User`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table Comment
--
ALTER TABLE Comment
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT pour la table Post
--
ALTER TABLE Post
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT pour la table User
--
ALTER TABLE `User`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table Comment
--
ALTER TABLE Comment
  ADD CONSTRAINT `Comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`),
  ADD CONSTRAINT `Comment_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `Post` (`id`);

--
-- Contraintes pour la table Post
--
ALTER TABLE Post
  ADD CONSTRAINT `Post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
