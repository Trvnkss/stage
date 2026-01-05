CREATE DATABASE IF NOT EXISTS fastfood_stock DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE fastfood_stock;

CREATE TABLE role (
    id_role INT AUTO_INCREMENT PRIMARY KEY,
    libelle_role VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE utilisateurs (
    id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE comptes (
    id_compte INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    id_role INT NOT NULL,
    id_utilisateur INT NOT NULL,
    FOREIGN KEY (id_role) REFERENCES role(id_role) ON DELETE CASCADE,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id_utilisateur) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE categ_produits (
    id_categ INT AUTO_INCREMENT PRIMARY KEY,
    libelle_categ VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE fournisseurs (
    id_fourni INT AUTO_INCREMENT PRIMARY KEY,
    nom_fourni VARCHAR(100) NOT NULL,
    tel_fourni VARCHAR(20),
    rue_fourni VARCHAR(150),
    cp_fourni VARCHAR(10),
    ville_fourni VARCHAR(100)
) ENGINE=InnoDB;

CREATE TABLE produits (
    id_prod INT AUTO_INCREMENT PRIMARY KEY,
    nom_prod VARCHAR(100) NOT NULL,
    unite VARCHAR(20) NOT NULL,
    stock_initial INT NOT NULL DEFAULT 0,
    seuil_alerte INT NOT NULL DEFAULT 5,
    id_categ INT NOT NULL,
    id_fourni INT NOT NULL,
    FOREIGN KEY (id_categ) REFERENCES categ_produits(id_categ) ON DELETE RESTRICT,
    FOREIGN KEY (id_fourni) REFERENCES fournisseurs(id_fourni) ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE type_mouvements (
    id_type_mouvement INT AUTO_INCREMENT PRIMARY KEY,
    libelle_type_mouvement VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE mouvements (
    id_mouv INT AUTO_INCREMENT PRIMARY KEY,
    qte_mouv INT NOT NULL,
    date_mouv DATETIME NOT NULL,
    id_prod INT NOT NULL,
    id_type_mouvement INT NOT NULL,
    id_utilisateur INT NOT NULL,
    FOREIGN KEY (id_prod) REFERENCES produits(id_prod) ON DELETE RESTRICT,
    FOREIGN KEY (id_type_mouvement) REFERENCES type_mouvements(id_type_mouvement) ON DELETE RESTRICT,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id_utilisateur) ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE commandes (
    id_commande INT AUTO_INCREMENT PRIMARY KEY,
    date_commande DATETIME NOT NULL,
    quantite INT NOT NULL,
    statut ENUM('En attente', 'Reçue', 'Annulée') NOT NULL DEFAULT 'En attente',
    id_prod INT NOT NULL,
    id_fourni INT NOT NULL,
    id_utilisateur INT NOT NULL,
    FOREIGN KEY (id_prod) REFERENCES produits(id_prod) ON DELETE RESTRICT,
    FOREIGN KEY (id_fourni) REFERENCES fournisseurs(id_fourni) ON DELETE RESTRICT,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id_utilisateur) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Données de référence
INSERT INTO role (libelle_role) VALUES ('Administrateur'), ('Employé');

INSERT INTO utilisateurs (nom, email) VALUES 
('Jean Dupont', 'admin@fastfood.fr'),
('Alice Martin', 'employe@fastfood.fr');

INSERT INTO comptes (login, mot_de_passe, id_role, id_utilisateur) VALUES 
('admin', '$2y$10$srEWb1zqxmRcb.jFs.dY8.e1C83FR6fu4Ow1VXYlIPShXtu64csKm', 1, 1), -- mdp: admin123
('employe', '$2y$10$suT2UrYiVsBivwZayrPsNeYbnD6Tt0eKzRSu8i6L8e6dzB6YzjCgG', 2, 2); -- mdp: employe123

INSERT INTO categ_produits (libelle_categ) VALUES 
('Boissons'), 
('Viandes'), 
('Légumes'), 
('Emballages');

INSERT INTO type_mouvements (libelle_type_mouvement) VALUES 
('Entrée'), 
('Sortie');

INSERT INTO fournisseurs (nom_fourni, tel_fourni, rue_fourni, cp_fourni, ville_fourni) VALUES
('Boucherie Centrale', '0102030405', '10 Rue de la Viande', '75001', 'Paris'),
('Metro Cash & Carry', '0908070605', 'ZAC des Entrepots', '93200', 'Saint-Denis');

INSERT INTO produits (nom_prod, unite, stock_initial, seuil_alerte, id_categ, id_fourni) VALUES
('Steak Haché 150g', 'Pièce', 500, 50, 2, 1),
('Bouteille Cola 50cl', 'Bouteille', 200, 20, 1, 2),
('Salade Iceberg', 'Kg', 20, 5, 3, 2);
