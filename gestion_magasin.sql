-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 01 jan. 2025 à 00:54
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_magasin`
--

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id_client` int(11) NOT NULL,
  `nom_client` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `adresse` text DEFAULT NULL,
  `pasword` varchar(100) DEFAULT NULL,
  `telephone` int(11) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id_client`, `nom_client`, `email`, `adresse`, `pasword`, `telephone`, `admin`) VALUES
(2, 'root', 'root@gmail.com', 'rabat', '123456', 5040201, 1),
(6, 'admin', 'admin@gmail.com', 'Casa', '$2y$10$cbB7939p5MCcMnDcA/EdQ.41wuzeROHFKPxh6KnlJ0uugjBTNf28S', 50520502, 1),
(9, 'MarYam', 'laa@gmail.com', 'Casa', '$2y$10$AlQZ4Mr76XDjGsWFXHrnae0UnqKU2dBrp0BmTZmjdnylJMHn0vBny', 5040201, 0);

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id_commande` int(11) NOT NULL,
  `id_client` int(11) DEFAULT NULL,
  `date_commande` date DEFAULT NULL,
  `total` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déclencheurs `commandes`
--
DELIMITER $$
CREATE TRIGGER `verifclient` BEFORE INSERT ON `commandes` FOR EACH ROW BEGIN 
    DECLARE client_exist INT;
    SELECT COUNT(*) INTO client_exist 
    FROM clients 
    WHERE id_client = NEW.id_client;

    IF client_exist = 0 THEN 
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'The client does not exist';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `favorites`
--

CREATE TABLE `favorites` (
  `id_favorite` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `favorites`
--

INSERT INTO `favorites` (`id_favorite`, `client_id`, `product_id`) VALUES
(1, 9, 6),
(2, 9, 7),
(3, 9, 3),
(4, 9, 2),
(5, 9, 5),
(6, 9, 12);

-- --------------------------------------------------------

--
-- Structure de la table `ligne_commandes`
--

CREATE TABLE `ligne_commandes` (
  `id_ligne` int(11) NOT NULL,
  `id_commande` int(11) DEFAULT NULL,
  `id_produit` int(11) DEFAULT NULL,
  `quantite` int(11) DEFAULT NULL,
  `sous_total` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déclencheurs `ligne_commandes`
--
DELIMITER $$
CREATE TRIGGER `maj_total_et_stock` AFTER INSERT ON `ligne_commandes` FOR EACH ROW BEGIN
    
    UPDATE Produits
    SET stock = stock - NEW.quantite
    WHERE id_produit = NEW.id_produit;

    UPDATE Commandes
    SET total = total + NEW.sous_total
    WHERE id_commande = NEW.id_commande;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `verif_stock_et_calcul_sous_total` BEFORE INSERT ON `ligne_commandes` FOR EACH ROW BEGIN
    DECLARE stockdispo INT;
    
    
    SELECT stock INTO stockdispo
    FROM Produits
    WHERE id_produit = NEW.id_produit;
    
 
    IF stockdispo < NEW.quantite THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Stock insuffisant pour ce produit';
    END IF;
    
 
    SET NEW.sous_total = NEW.quantite * (
        SELECT prix 
        FROM Produits
        WHERE id_produit = NEW.id_produit
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE `panier` (
  `id_panier` int(11) NOT NULL,
  `id_client` int(11) DEFAULT NULL,
  `id_produit` int(11) DEFAULT NULL,
  `quantite` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `panier`
--

INSERT INTO `panier` (`id_panier`, `id_client`, `id_produit`, `quantite`) VALUES
(2, 9, 3, 1),
(4, 9, 5, 1),
(5, 9, 7, 1),
(8, 9, 10, 1);

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id_produit` int(11) NOT NULL,
  `nom_produit` varchar(200) DEFAULT NULL,
  `prix` float DEFAULT NULL,
  `stock` int(11) DEFAULT NULL CHECK (`stock` >= 0),
  `description` text DEFAULT NULL,
  `image` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id_produit`, `nom_produit`, `prix`, `stock`, `description`, `image`) VALUES
(2, 'Pink T-Shirt', 300, 50, 'Stylish pink T-shirt for a casual look.', 'images/tshirt.jpg'),
(3, 'Pink heels', 500, 20, 'Elegant pink heels, perfect for adding a touch of sophistication to any outfit.', 'images/shoes.jpg'),
(4, 'Blue Glasses', 350, 2, 'Sleek blue glasses with a minimalist design for effortless style.', 'images/glasses.jpg'),
(5, 'Pink pants', 250, 20, 'Chic pink pants that bring a pop of color and flair to your wardrobe.', 'images/pants.jpg'),
(6, 'Pink jacket', 600, 20, 'Trendy pink jacket that adds warmth and style to any outfit.', 'images/jackett.jpg'),
(7, 'White heels ', 250, 30, 'Classic white heels that exude elegance and versatility for any occasion.', 'images/shoess.jpg'),
(8, 'grey T-Shirt', 120, 20, 'Stylish grey T-shirt for a casual look.', 'images/tshirtgrey.jpg'),
(9, 'Milada Shirt', 400, 10, 'Milada biege Shirt casual', 'images/miladashirt.jpg'),
(10, 'Veste Jeans', 500, 50, 'Veste en jeans bleu, classique et tendance.', 'images/vestejeans.jpg'),
(11, 'Sleek Aviator Glasses', 360, 50, 'Lightweight metal frame with polarized lenses.', 'images/glasses2.jpg'),
(12, 'Floral Chiffon Blouse', 200, 10, 'Breezy blouse with floral prints and ruffled neckline.', 'images/blouse2.jpg'),
(13, 'Silk Satin Blouse', 500, 60, ' Elegant silk blouse with a minimalist collar.', 'images/blouse.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id_client`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `fk_client` (`id_client`);

--
-- Index pour la table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id_favorite`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Index pour la table `ligne_commandes`
--
ALTER TABLE `ligne_commandes`
  ADD PRIMARY KEY (`id_ligne`),
  ADD KEY `fk_commande` (`id_commande`),
  ADD KEY `fk_produit` (`id_produit`);

--
-- Index pour la table `panier`
--
ALTER TABLE `panier`
  ADD PRIMARY KEY (`id_panier`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_produit` (`id_produit`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id_produit`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id_favorite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `ligne_commandes`
--
ALTER TABLE `ligne_commandes`
  MODIFY `id_ligne` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `panier`
--
ALTER TABLE `panier`
  MODIFY `id_panier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id_produit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `fk_client` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id_client`);

--
-- Contraintes pour la table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id_client`),
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `produits` (`id_produit`);

--
-- Contraintes pour la table `ligne_commandes`
--
ALTER TABLE `ligne_commandes`
  ADD CONSTRAINT `fk_commande` FOREIGN KEY (`id_commande`) REFERENCES `commandes` (`id_commande`),
  ADD CONSTRAINT `fk_produit` FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id_produit`);

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `panier_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id_client`),
  ADD CONSTRAINT `panier_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id_produit`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
