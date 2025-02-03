CREATE TABLE elevage_Alimentation(
   id_alimentation INTEGER AUTO_INCREMENT PRIMARY KEY,
   nom_aliment VARCHAR(50) NOT NULL,
   image_url VARCHAR(255) NOT NULL,
   gain DECIMAL(10,2) NOT NULL DEFAULT 0.00
);
ALTER TABLE elevage_Alimentation
ADD COLUMN gain DECIMAL(10,2) NOT NULL DEFAULT 0.00;




CREATE TABLE elevage_Type_Animal(
   id_type_animal INTEGER AUTO_INCREMENT PRIMARY KEY,
   nom_type VARCHAR(50) NOT NULL,
   poids_min_vente DECIMAL(10,2) NOT NULL,
   poids_maximal DECIMAL(10,2) NOT NULL,
   prix_vente_kg DECIMAL(10,2) NOT NULL,
   nb_jour_sans_manger INT,
   perte_poids DECIMAL(10,2) NOT NULL,
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
   FOREIGN KEY(id_type_animal) REFERENCES elevage_Type_Animal(id_type_animal)
);


CREATE TABLE elevage_Stock (
   id_stock INTEGER AUTO_INCREMENT PRIMARY KEY,
   id_alimentation INT,
   quantite INT,
   FOREIGN KEY (id_alimentation) REFERENCES elevage_Alimentation(id_alimentation) 
);

CREATE TABLE elevage_Argent (
   argent DECIMAL(10,2)
);


CREATE TABLE elevage_Historique_Alimentaion(
   id_historique INTEGER AUTO_INCREMENT PRIMARY KEY,
   id_animal INT,
   date_alimentation DATE NOT NULL,
   poids DECIMAL(10,2),
   FOREIGN KEY(id_animal) REFERENCES elevage_Animal(id_animal)
);

CREATE TABLE gain (
   id_gain INTEGER AUTO_INCREMENT PRIMARY KEY,
   id_type_animal INT,
   pourcentage DECIMAL(10,2)
);