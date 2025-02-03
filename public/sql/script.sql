CREATE TABLE elevage_Type_Alimentation(
   id_type_alimentation INTEGER AUTO_INCREMENT PRIMARY KEY,
   nom_type_alimentation VARCHAR(50) NOT NULL
);

CREATE TABLE elevage_Alimentation(
   id_alimentation INTEGER AUTO_INCREMENT PRIMARY KEY,
   id_type_alimentation INT,
   nom_aliment VARCHAR(50) NOT NULL,
   FOREIGN KEY(id_type_alimentation) REFERENCES elevage_Type_Alimentation(id_type_alimentation)
);


CREATE TABLE elevage_Type_Animal(
   id_type_animal INTEGER AUTO_INCREMENT PRIMARY KEY,
   nom_type VARCHAR(50) NOT NULL,
   poids_min_vente DECIMAL(10,2) NOT NULL,
   prix_vente_kg DECIMAL(10,2) NOT NULL,
   nb_jour_sans_manger INT,
   perte_poids DECIMAL(10,2) NOT NULL,
   id_type_alimentation INT,
   FOREIGN KEY(id_type_alimentation) REFERENCES elevage_Type_Alimentation(id_type_alimentation)
);


CREATE TABLE elevage_Animal(
   id_animal INTEGER AUTO_INCREMENT PRIMARY KEY,
   id_type_animal INT,
   poids DECIMAL(10,2) NOT NULL,
   image_animal VARCHAR(255) NOT NULL,
   nom_animal VARCHAR(60),
   en_ventre INT, -- 0 en vente | 1 pas en vente
   FOREIGN KEY(id_type_animal) REFERENCES elevage_Type_Animal(id_type_animal)
);


CREATE TABLE elevage_Argent (
   argent DECIMAL(10,2)
);

