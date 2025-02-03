CREATE TABLE Type_Alimentation(
   id_type_alimentation INT AUTO_INCREMENT,
   nom_type_alimentation INT NOT NULL,
   PRIMARY KEY(id_type_alimentation)
);

CREATE TABLE Alimentation(
   id_alimentation INT AUTO_INCREMENT,
   id_type_alimentation INT,
   nom_aliment INT NOT NULL,
   PRIMARY KEY(id_type_alimentation, id_alimentation),
   FOREIGN KEY(id_type_alimentation) REFERENCES Type_Alimentation(id_type_alimentation)
);

CREATE TABLE Utilisateur(
   id_utilisateur INT AUTO_INCREMENT,
   nom_utilsateur VARCHAR(50) NOT NULL,
   argent DECIMAL(10,2),
   PRIMARY KEY(id_utilisateur)
);

CREATE TABLE Type_Animal(
   id_type_animal INT AUTO_INCREMENT,
   poids_min_vente DECIMAL(10,2) NOT NULL,
   prix_vente_kg VARCHAR(50) NOT NULL,
   nb_jour_sans_manger INT,
   perte_poids DECIMAL(10,2) NOT NULL,
   id_type_alimentation INT,
   nom_type VARCHAR(50) NOT NULL,
   id_type_alimentation_1 INT NOT NULL,
   PRIMARY KEY(id_type_animal),
   FOREIGN KEY(id_type_alimentation) REFERENCES Type_Alimentation(id_type_alimentation)
);

CREATE TABLE Animal(
   id_animal INT AUTO_INCREMENT,
   id_utilisateur INT,
   id_type_animal INT,
   poids DECIMAL(10,2) NOT NULL,
   image_animal VARCHAR(50) NOT NULL,
   nom_animal VARCHAR(60),
   PRIMARY KEY(id_animal),
   FOREIGN KEY(id_utilisateur) REFERENCES Utilisateur(id_utilisateur),
   FOREIGN KEY(id_type_animal) REFERENCES Type_Animal(id_type_animal)
);
