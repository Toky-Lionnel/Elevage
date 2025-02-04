CREATE TABLE elevage_Alimentation(
   id_alimentation INTEGER AUTO_INCREMENT PRIMARY KEY,
   nom_aliment VARCHAR(50) NOT NULL,
   image_url VARCHAR(255) NOT NULL,
   gain DECIMAL(10,2) NOT NULL DEFAULT 0.00,
   prix DECIMAL(10,2) NOT NULL DEFAULT 0.00
);


CREATE TABLE elevage_Type_Animal(
   id_type_animal INTEGER AUTO_INCREMENT PRIMARY KEY,
   nom_type VARCHAR(50) NOT NULL,
   poids_min_vente DECIMAL(10,2) NOT NULL,
   poids_maximal DECIMAL(10,2) NOT NULL,
   prix_vente_kg DECIMAL(10,2) NOT NULL,
   nb_jour_sans_manger INT,
   perte_poids DECIMAL(10,2) NOT NULL,
   quota DECIMAL(10,2) NOT NULL DEFAULT 0.00,
   id_alimentation INT,
   FOREIGN KEY(id_alimentation) REFERENCES elevage_Alimentation(id_alimentation)
);


CREATE TABLE elevage_Animal(
   id_animal INTEGER AUTO_INCREMENT PRIMARY KEY,
   id_type_animal INT,
   poids_initial DECIMAL(10,2) NOT NULL,
   image_animal VARCHAR(255) NOT NULL,
   nom_animal VARCHAR(60),
   en_vente INT, -- 0 en vente | 1 pas en vente
   auto_vente INT, -- 0 auto | 1 pas auto
   date_mort DATE DEFAULT NULL,
   FOREIGN KEY(id_type_animal) REFERENCES elevage_Type_Animal(id_type_animal)
);


CREATE TABLE elevage_Stock (
   id_stock INTEGER AUTO_INCREMENT PRIMARY KEY,
   id_alimentation INT,
   quantite DECIMAL(10,2),
   FOREIGN KEY (id_alimentation) REFERENCES elevage_Alimentation(id_alimentation) 
);

CREATE TABLE elevage_Argent (
   argent DECIMAL(10,2) NOT NULL DEFAULT 0.00
);

INSERT INTO elevage_Argent (argent) VALUES (1000.00);

CREATE TABLE elevage_Historique_Alimentation(
   id_historique INTEGER AUTO_INCREMENT PRIMARY KEY,
   id_animal INT,
   date_alimentation DATE NOT NULL,
   poids DECIMAL(10,2),
   FOREIGN KEY(id_animal) REFERENCES elevage_Animal(id_animal)
);

