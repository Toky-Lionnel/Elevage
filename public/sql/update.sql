
-- Initialisation des données
INSERT INTO elevage_Alimentation (nom_aliment, image_url, gain, prix) VALUES
('Maïs','public/assets/images/mais.png', 5.00, 1.50),
('Soja','public/assets/images/soja.png', 6.50, 2.00),
('Foin','public/assets/images/foin.png', 2.50, 0.80),
('Granulés','public/assets/images/granules.png', 7.00, 2.50),
('Herbe','public/assets/images/herbe.png', 3.00, 0.50);

INSERT INTO elevage_Type_Animal (nom_type, poids_min_vente, poids_maximal, prix_vente_kg, nb_jour_sans_manger, perte_poids, id_alimentation, quota) VALUES
('Poulet', 1.20, 3.50, 5.00, 3, 0.10, 1, 0.50),
('Boeuf', 250.00, 900.00, 4.50, 5, 10.00, 2, 15.00),
('Mouton', 30.00, 80.00, 6.00, 4, 2.00, 3, 5.00),
('Cochon', 50.00, 150.00, 5.50, 4, 5.00, 4, 10.00),
('Lapin', 2.00, 5.00, 7.00, 2, 0.20, 5, 0.30);

INSERT INTO elevage_Animal (id_type_animal, poids_initial, image_animal, nom_animal, en_vente, auto_vente, date_mort)
VALUES
-- Poulets
(1, 0.5, 'public/assets/images/poulet1.png', 'Poulet A', 0, 0, NULL),
(1, 0.6, 'public/assets/images/poulet2.png', 'Poulet B', 1, 1, NULL),
(1, 0.4, 'public/assets/images/poulet3.png', 'Poulet C', 0, 1, NULL),
(1, 0.7, 'public/assets/images/poulet4.png', 'Poulet D', 1, 0, NULL),
(1, 0.3, 'public/assets/images/poulet5.png', 'Poulet E', 0, 0, NULL),

-- Moutons
(3, 20.0, 'public/assets/images/mouton1.png', 'Mouton A', 1, 0, NULL),
(3, 20.5, 'public/assets/images/mouton2.png', 'Mouton B', 0, 1, NULL),
(3, 20.3, 'public/assets/images/mouton3.png', 'Mouton C', 1, 1, NULL),
(3, 32.1, 'public/assets/images/mouton4.png', 'Mouton D', 0, 0, NULL),
(3, 20.8, 'public/assets/images/mouton5.png', 'Mouton E', 1, 0, NULL),

-- Bœufs
(2, 178.0, 'public/assets/images/boeuf1.png', 'Boeuf A', 1, 1, NULL),
(2, 100.0, 'public/assets/images/boeuf2.png', 'Boeuf B', 0, 0, NULL),
(2, 400.5, 'public/assets/images/boeuf3.png', 'Boeuf C', 1, 0, NULL),
(2, 800.7, 'public/assets/images/boeuf4.png', 'Boeuf D', 0, 1, NULL),
(2, 900.3, 'public/assets/images/boeuf5.png', 'Boeuf E', 1, 1, NULL),

-- Lapins
(5, 1.2, 'public/assets/images/lapin1.png', 'Lapin A', 0, 0, NULL),
(5, 1.8, 'public/assets/images/lapin2.png', 'Lapin B', 1, 1, NULL),
(5, 1.5, 'public/assets/images/lapin3.png', 'Lapin C', 0, 1, NULL),
(5, 1.0, 'public/assets/images/lapin4.png', 'Lapin D', 1, 0, NULL),
(5, 2.9, 'public/assets/images/lapin2.png', 'Lapin E', 0, 0, NULL),

-- Cochons
(4, 40.0, 'public/assets/images/cochon1.png', 'Cochon A', 1, 1, NULL),
(4, 45.2, 'public/assets/images/cochon2.png', 'Cochon B', 0, 0, NULL),
(4, 32.7, 'public/assets/images/cochon3.png', 'Cochon C', 1, 0, NULL),
(4, 58.3, 'public/assets/images/cochon4.png', 'Cochon D', 0, 1, NULL),
(4, 24.1, 'public/assets/images/cochon5.png', 'Cochon E', 1, 1, NULL);


UPDATE elevage_Argent SET argent = 1000.00;
INSERT INTO elevage_Argent (argent) VALUES (1000.00);

INSERT INTO elevage_Stock (id_alimentation, quantite) VALUES 
(1, 100),
(2, 20),
(3, 3),
(4, 40),
(5, 5);
