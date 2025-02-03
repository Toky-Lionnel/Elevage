

CREATE DATABASE prepaExam ;

USE prepaExam;

CREATE TABLE admin (
    pseudo VARCHAR(30),
    motdepasse VARCHAR(30)
);

INSERT INTO admin (pseudo,motdepasse) VALUES ("Lionnel","0407");


CREATE TABLE variete_The (
    id_variete INTEGER PRIMARY KEY AUTO_INCREMENT,
    nom_variete VARCHAR(50),
    occupation DECIMAL(6,2),
    rendement DECIMAL(6,2),
    image_the VARCHAR(100)
);


CREATE TABLE parcelle (
    id_parcelle INTEGER PRIMARY KEY AUTO_INCREMENT,
    numero_parcelle VARCHAR(50) NOT NULL,
    surface_hectare DECIMAL(6,2) NOT NULL,
    id_variete INTEGER NOT NULL,
    FOREIGN KEY (id_variete) REFERENCES variete_The(id_variete) ON DELETE CASCADE
);
